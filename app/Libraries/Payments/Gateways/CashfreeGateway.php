<?php

namespace App\Libraries\Payments\Gateways;

use App\Libraries\Payments\Contracts\PaymentGatewayInterface;
use App\Libraries\Payments\DTO\CheckoutSession;
use App\Libraries\Payments\DTO\RefundResult;
use App\Libraries\Payments\DTO\VerificationResult;
use CodeIgniter\HTTP\CURLRequest;
use Throwable;

class CashfreeGateway implements PaymentGatewayInterface
{
    private const API_VERSION = '2023-08-01';

    public function __construct(
        private readonly string $appId,
        private readonly string $secretKey,
        private readonly string $environment,
        private readonly string $webhookSecret = '',
    ) {
    }

    public function id(): string
    {
        return 'cashfree';
    }

    public function label(): string
    {
        return 'Cashfree';
    }

    public function environment(): string
    {
        return $this->environment === 'production' ? 'production' : 'sandbox';
    }

    public function isConfigured(): bool
    {
        return $this->appId !== '' && $this->secretKey !== '';
    }

    public function checkoutScriptUrl(): string
    {
        return 'https://sdk.cashfree.com/js/v3/cashfree.js';
    }

    public function createCheckout(array $booking, array $room): CheckoutSession
    {
        $payload = [
            'order_id'       => (string) ($booking['gateway_order_id'] ?? ''),
            'order_amount'   => round((float) ($booking['total_amount'] ?? 0), 2),
            'order_currency' => (string) ($booking['currency'] ?? 'INR'),
            'customer_details' => [
                'customer_id'    => (string) ($booking['booking_code'] ?? ('booking-' . ($booking['id'] ?? '0'))),
                'customer_name'  => (string) ($booking['name'] ?? 'Guest'),
                'customer_email' => (string) ($booking['email'] ?? ''),
                'customer_phone' => (string) ($booking['phone'] ?? ''),
            ],
            'order_meta' => [
                'return_url' => (string) ($booking['return_url'] ?? base_url('booking/payment/return?booking=' . urlencode((string) ($booking['booking_code'] ?? '')) . '&order_id={order_id}')),
            ],
            'order_note' => (string) ($booking['order_note'] ?? sprintf(
                'Room booking for %s (%s to %s, %s room%s)',
                (string) ($room['name'] ?? $booking['room_type'] ?? 'Room'),
                (string) ($booking['checkin'] ?? ''),
                (string) ($booking['checkout'] ?? ''),
                (string) max(1, (int) ($booking['rooms_required'] ?? 1)),
                max(1, (int) ($booking['rooms_required'] ?? 1)) > 1 ? 's' : ''
            )),
        ];

        try {
            $response = $this->client()->post('pg/orders', ['json' => $payload]);
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new CheckoutSession(false, 'Cashfree returned an unreadable response.', null, null, $payload, []);
            }

            $gatewayOrderId = (string) ($body['order_id'] ?? $payload['order_id']);
            $sessionToken = (string) ($body['payment_session_id'] ?? '');

            if ($sessionToken === '') {
                return new CheckoutSession(false, (string) ($body['message'] ?? 'Cashfree did not return a payment session.'), $gatewayOrderId, null, $payload, $body);
            }

            return new CheckoutSession(true, 'Cashfree checkout created.', $gatewayOrderId, $sessionToken, $payload, $body);
        } catch (Throwable $e) {
            log_message('error', 'Cashfree order creation failed: {message}', ['message' => $e->getMessage()]);

            return new CheckoutSession(false, 'Unable to start Cashfree checkout right now.', null, null, $payload, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function verifyOrder(string $gatewayOrderId): VerificationResult
    {
        try {
            $response = $this->client()->get('pg/orders/' . rawurlencode($gatewayOrderId));
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new VerificationResult(false, 'failed', 'Cashfree verification response was unreadable.', $gatewayOrderId);
            }

            $orderStatus = strtoupper((string) ($body['order_status'] ?? ''));
            $paymentStatus = match ($orderStatus) {
                'PAID' => 'paid',
                'ACTIVE', 'PENDING' => 'pending',
                'CANCELLED' => 'cancelled',
                default => 'failed',
            };

            return new VerificationResult(
                $paymentStatus === 'paid',
                $paymentStatus,
                (string) ($body['message'] ?? ('Cashfree order status: ' . $orderStatus)),
                (string) ($body['order_id'] ?? $gatewayOrderId),
                (string) ($body['cf_order_id'] ?? ''),
                $body,
            );
        } catch (Throwable $e) {
            log_message('error', 'Cashfree verification failed: {message}', ['message' => $e->getMessage()]);

            return new VerificationResult(false, 'failed', 'Unable to verify Cashfree payment right now.', $gatewayOrderId, null, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function verifyWebhookSignature(array $headers, string $rawBody): bool
    {
        if ($this->webhookSecret === '') {
            return false;
        }

        $signature = trim((string) ($headers['x-webhook-signature'] ?? $headers['X-Webhook-Signature'] ?? ''));
        $timestamp = trim((string) ($headers['x-webhook-timestamp'] ?? $headers['X-Webhook-Timestamp'] ?? ''));

        if ($signature === '' || $timestamp === '') {
            return false;
        }

        $signedPayloads = [
            $timestamp . $rawBody,
            $rawBody . $timestamp,
            $rawBody,
        ];

        foreach ($signedPayloads as $message) {
            $computedRaw = hash_hmac('sha256', $message, $this->webhookSecret, true);
            $computedBase64 = base64_encode($computedRaw);
            $computedHex = hash_hmac('sha256', $message, $this->webhookSecret);

            if (hash_equals($computedBase64, $signature) || hash_equals($computedHex, strtolower($signature)) || hash_equals($computedHex, $signature)) {
                return true;
            }
        }

        return false;
    }

    public function refundPayment(string $gatewayOrderId, ?string $gatewayPaymentId, float $amount, string $currency, string $refundReference, string $note = ''): RefundResult
    {
        $payload = [
            'refund_amount' => round($amount, 2),
            'refund_id' => substr(preg_replace('/[^A-Za-z0-9]/', '', $refundReference) ?: ('REF' . time()), 0, 40),
            'refund_note' => substr($note !== '' ? $note : ('Refund for ' . $gatewayOrderId), 0, 100),
            'refund_speed' => 'STANDARD',
        ];

        try {
            $response = $this->client()->post('pg/orders/' . rawurlencode($gatewayOrderId) . '/refunds', ['json' => $payload]);
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new RefundResult(false, 'failed', 'Cashfree refund response was unreadable.', null, $gatewayPaymentId, []);
            }

            $refund = isset($body[0]) && is_array($body[0]) ? $body[0] : $body;
            $status = strtoupper((string) ($refund['refund_status'] ?? 'PENDING'));
            $refundStatus = match ($status) {
                'SUCCESS' => 'processed',
                'PENDING', 'ACTIVE' => 'pending',
                default => 'failed',
            };

            return new RefundResult(
                in_array($refundStatus, ['processed', 'pending'], true),
                $refundStatus,
                (string) ($refund['status_description'] ?? ('Cashfree refund status: ' . $status)),
                (string) ($refund['cf_refund_id'] ?? $refund['refund_id'] ?? ''),
                (string) ($refund['cf_payment_id'] ?? $gatewayPaymentId ?? ''),
                $body,
            );
        } catch (Throwable $e) {
            log_message('error', 'Cashfree refund failed: {message}', ['message' => $e->getMessage()]);

            return new RefundResult(false, 'failed', 'Unable to create Cashfree refund right now.', null, $gatewayPaymentId, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function fetchRefund(string $gatewayOrderId, string $gatewayRefundId, ?string $gatewayPaymentId = null): RefundResult
    {
        $refundId = trim($gatewayRefundId);

        if ($gatewayOrderId === '' || $refundId === '') {
            return new RefundResult(false, 'failed', 'Cashfree order id and refund id are required.');
        }

        try {
            $response = $this->client()->get('pg/orders/' . rawurlencode($gatewayOrderId) . '/refunds/' . rawurlencode($refundId));
            $body = json_decode((string) $response->getBody(), true);

            if (! is_array($body)) {
                return new RefundResult(false, 'failed', 'Cashfree refund response was unreadable.', $refundId, $gatewayPaymentId, []);
            }

            $refund = isset($body[0]) && is_array($body[0]) ? $body[0] : $body;
            $status = strtoupper((string) ($refund['refund_status'] ?? 'PENDING'));
            $refundStatus = match ($status) {
                'SUCCESS' => 'processed',
                'PENDING', 'ACTIVE' => 'pending',
                default => 'failed',
            };

            return new RefundResult(
                in_array($refundStatus, ['processed', 'pending'], true),
                $refundStatus,
                (string) ($refund['status_description'] ?? ('Cashfree refund status: ' . $status)),
                (string) ($refund['cf_refund_id'] ?? $refund['refund_id'] ?? $refundId),
                (string) ($refund['cf_payment_id'] ?? $gatewayPaymentId ?? ''),
                $body,
            );
        } catch (Throwable $e) {
            log_message('error', 'Cashfree refund lookup failed: {message}', ['message' => $e->getMessage()]);

            return new RefundResult(false, 'failed', 'Unable to check Cashfree refund right now.', $refundId, $gatewayPaymentId, [
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function extractWebhookOrderId(array $payload): ?string
    {
        $candidates = [
            $payload['data']['order']['order_id'] ?? null,
            $payload['data']['order_id'] ?? null,
            $payload['order']['order_id'] ?? null,
            $payload['order_id'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            $value = trim((string) $candidate);

            if ($value !== '') {
                return $value;
            }
        }

        return null;
    }

    private function client(): CURLRequest
    {
        $baseUri = $this->environment() === 'production'
            ? 'https://api.cashfree.com/'
            : 'https://sandbox.cashfree.com/';

        return service('curlrequest', [
            'baseURI' => $baseUri,
            'timeout' => 30,
            'headers' => [
                'accept'          => 'application/json',
                'content-type'    => 'application/json',
                'x-client-id'     => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version'   => self::API_VERSION,
            ],
        ]);
    }
}
