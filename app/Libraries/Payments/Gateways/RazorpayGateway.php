<?php

namespace App\Libraries\Payments\Gateways;

use App\Libraries\Payments\Contracts\PaymentGatewayInterface;
use App\Libraries\Payments\DTO\CheckoutSession;
use App\Libraries\Payments\DTO\RefundResult;
use App\Libraries\Payments\DTO\VerificationResult;
use CodeIgniter\HTTP\CURLRequest;
use Throwable;

class RazorpayGateway implements PaymentGatewayInterface
{
    public function __construct(
        private readonly string $keyId,
        private readonly string $keySecret,
        private readonly string $environment,
        private readonly string $webhookSecret = '',
    ) {
    }

    public function id(): string
    {
        return 'razorpay';
    }

    public function label(): string
    {
        return 'Razorpay';
    }

    public function environment(): string
    {
        return $this->environment === 'production' ? 'production' : 'sandbox';
    }

    public function isConfigured(): bool
    {
        return $this->keyId !== '' && $this->keySecret !== '';
    }

    public function checkoutScriptUrl(): string
    {
        return 'https://checkout.razorpay.com/v1/checkout.js';
    }

    public function createCheckout(array $booking, array $room): CheckoutSession
    {
        $amount = max(1, (int) round(((float) ($booking['total_amount'] ?? 0)) * 100));
        $gatewayOrderId = (string) ($booking['gateway_order_id'] ?? '');
        $currency = (string) ($booking['currency'] ?? 'INR');
        $roomName = (string) ($room['name'] ?? $booking['room_type'] ?? 'Room');

        $payload = [
            'amount' => $amount,
            'currency' => $currency,
            'receipt' => substr($gatewayOrderId, 0, 40),
            'notes' => array_merge([
                'booking_code' => (string) ($booking['booking_code'] ?? ''),
                'room' => $roomName,
                'checkin' => (string) ($booking['checkin'] ?? ''),
                'checkout' => (string) ($booking['checkout'] ?? ''),
                'rooms_required' => (string) max(1, (int) ($booking['rooms_required'] ?? 1)),
            ], is_array($booking['notes'] ?? null) ? $booking['notes'] : []),
        ];

        try {
            $response = $this->client()->post('orders', ['json' => $payload]);
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new CheckoutSession(false, 'Razorpay returned an unreadable response.', null, null, $payload, []);
            }

            $razorpayOrderId = (string) ($body['id'] ?? '');

            if ($razorpayOrderId === '') {
                return new CheckoutSession(false, (string) ($body['error']['description'] ?? 'Razorpay did not return an order id.'), null, null, $payload, $body);
            }

            $checkout = [
                'key' => $this->keyId,
                'amount' => $amount,
                'currency' => $currency,
                'name' => app_setting('hotel_name', 'Hotel H Plus'),
                'description' => 'Room booking for ' . $roomName,
                'order_id' => $razorpayOrderId,
                'prefill' => [
                    'name' => (string) ($booking['name'] ?? ''),
                    'email' => (string) ($booking['email'] ?? ''),
                    'contact' => (string) ($booking['phone'] ?? ''),
                ],
                'notes' => $payload['notes'],
                'theme' => [
                    'color' => '#C99A30',
                ],
            ];

            return new CheckoutSession(true, 'Razorpay checkout created.', $razorpayOrderId, $razorpayOrderId, $payload, [
                'order' => $body,
                'checkout' => $checkout,
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Razorpay order creation failed: {message}', ['message' => $e->getMessage()]);

            return new CheckoutSession(false, 'Unable to start Razorpay checkout right now.', null, null, $payload, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function verifyOrder(string $gatewayOrderId): VerificationResult
    {
        try {
            $response = $this->client()->get('orders/' . rawurlencode($gatewayOrderId));
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new VerificationResult(false, 'failed', 'Razorpay verification response was unreadable.', $gatewayOrderId);
            }

            $status = strtolower((string) ($body['status'] ?? ''));
            $paymentStatus = match ($status) {
                'paid' => 'paid',
                'created', 'attempted' => 'pending',
                default => 'failed',
            };
            $paymentId = $this->latestPaymentId($gatewayOrderId);

            return new VerificationResult(
                $paymentStatus === 'paid',
                $paymentStatus,
                (string) ($body['error']['description'] ?? ('Razorpay order status: ' . $status)),
                (string) ($body['id'] ?? $gatewayOrderId),
                $paymentId,
                $body,
            );
        } catch (Throwable $e) {
            log_message('error', 'Razorpay verification failed: {message}', ['message' => $e->getMessage()]);

            return new VerificationResult(false, 'failed', 'Unable to verify Razorpay payment right now.', $gatewayOrderId, null, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function verifyWebhookSignature(array $headers, string $rawBody): bool
    {
        if ($this->webhookSecret === '') {
            return false;
        }

        $signature = trim((string) ($headers['x-razorpay-signature'] ?? $headers['X-Razorpay-Signature'] ?? ''));

        if ($signature === '') {
            return false;
        }

        return hash_equals(hash_hmac('sha256', $rawBody, $this->webhookSecret), $signature);
    }

    public function refundPayment(string $gatewayOrderId, ?string $gatewayPaymentId, float $amount, string $currency, string $refundReference, string $note = ''): RefundResult
    {
        $paymentId = trim((string) $gatewayPaymentId);

        if ($paymentId === '') {
            $paymentId = (string) ($this->latestPaymentId($gatewayOrderId) ?? '');
        }

        if ($paymentId === '') {
            return new RefundResult(false, 'failed', 'Razorpay payment id is required before a refund can be created.');
        }

        $payload = [
            'amount' => max(1, (int) round($amount * 100)),
            'receipt' => substr($refundReference, 0, 40),
            'notes' => [
                'refund_reference' => $refundReference,
                'gateway_order_id' => $gatewayOrderId,
            ],
        ];

        if ($note !== '') {
            $payload['notes']['note'] = substr($note, 0, 100);
        }

        try {
            $response = $this->client()->post('payments/' . rawurlencode($paymentId) . '/refund', ['json' => $payload]);
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new RefundResult(false, 'failed', 'Razorpay refund response was unreadable.', null, $paymentId, []);
            }

            $status = strtolower((string) ($body['status'] ?? 'pending'));
            $refundStatus = match ($status) {
                'processed' => 'processed',
                'pending' => 'pending',
                default => 'failed',
            };

            return new RefundResult(
                in_array($refundStatus, ['processed', 'pending'], true),
                $refundStatus,
                (string) ($body['error']['description'] ?? ('Razorpay refund status: ' . $status)),
                (string) ($body['id'] ?? ''),
                $paymentId,
                $body,
            );
        } catch (Throwable $e) {
            log_message('error', 'Razorpay refund failed: {message}', ['message' => $e->getMessage()]);

            return new RefundResult(false, 'failed', 'Unable to create Razorpay refund right now.', null, $paymentId, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function fetchRefund(string $gatewayOrderId, string $gatewayRefundId, ?string $gatewayPaymentId = null): RefundResult
    {
        $refundId = trim($gatewayRefundId);

        if ($refundId === '') {
            return new RefundResult(false, 'failed', 'Razorpay refund id is required.');
        }

        try {
            $response = $this->client()->get('refunds/' . rawurlencode($refundId));
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new RefundResult(false, 'failed', 'Razorpay refund response was unreadable.', $refundId, $gatewayPaymentId, []);
            }

            $status = strtolower((string) ($body['status'] ?? 'pending'));
            $refundStatus = match ($status) {
                'processed' => 'processed',
                'pending' => 'pending',
                default => 'failed',
            };

            return new RefundResult(
                in_array($refundStatus, ['processed', 'pending'], true),
                $refundStatus,
                'Razorpay refund status: ' . $status,
                (string) ($body['id'] ?? $refundId),
                (string) ($body['payment_id'] ?? $gatewayPaymentId ?? ''),
                $body,
            );
        } catch (Throwable $e) {
            log_message('error', 'Razorpay refund lookup failed: {message}', ['message' => $e->getMessage()]);

            return new RefundResult(false, 'failed', 'Unable to check Razorpay refund right now.', $refundId, $gatewayPaymentId, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function extractWebhookOrderId(array $payload): ?string
    {
        $candidates = [
            $payload['payload']['payment']['entity']['order_id'] ?? null,
            $payload['payload']['order']['entity']['id'] ?? null,
            $payload['order_id'] ?? null,
            $payload['razorpay_order_id'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            $value = trim((string) $candidate);

            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    public function verifyCheckoutSignature(string $orderId, string $paymentId, string $signature): bool
    {
        if ($orderId === '' || $paymentId === '' || $signature === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->keySecret);

        return hash_equals($expected, $signature);
    }

    private function latestPaymentId(string $gatewayOrderId): ?string
    {
        try {
            $response = $this->client()->get('orders/' . rawurlencode($gatewayOrderId) . '/payments');
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body) || empty($body['items']) || ! is_array($body['items'])) {
                return null;
            }

            foreach ($body['items'] as $payment) {
                if (is_array($payment) && in_array((string) ($payment['status'] ?? ''), ['captured', 'authorized'], true)) {
                    return (string) ($payment['id'] ?? '');
                }
            }

            $first = $body['items'][0] ?? null;

            return is_array($first) ? (string) ($first['id'] ?? '') : null;
        } catch (Throwable $e) {
            log_message('warning', 'Razorpay payment lookup failed: {message}', ['message' => $e->getMessage()]);

            return null;
        }
    }

    private function client(): CURLRequest
    {
        return service('curlrequest', [
            'baseURI' => 'https://api.razorpay.com/v1/',
            'timeout' => 30,
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($this->keyId . ':' . $this->keySecret),
            ],
        ]);
    }
}
