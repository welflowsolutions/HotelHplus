<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\Payments\Contracts\PaymentGatewayInterface;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class PaymentController extends BaseController
{
    private function payments()
    {
        return service('paymentService');
    }

    public function webhook(string $provider): ResponseInterface
    {
        $gateway = $this->payments()->currentProvider() === $provider
            ? $this->payments()->currentGateway()
            : service('paymentGatewayFactory')->make($provider);

        if (! $gateway instanceof PaymentGatewayInterface) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'ignored',
                'message' => 'Unsupported gateway.',
            ]);
        }

        $rawBody = (string) $this->request->getBody();
        $payload = json_decode($rawBody, true);

        if (! is_array($payload)) {
            $this->logWebhook($provider, [], null, false, null, null, 'invalid_json', 'Invalid JSON payload.');

            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'invalid',
                'message' => 'Invalid JSON payload.',
            ]);
        }

        $headers = [
            'x-webhook-signature' => $this->request->getHeaderLine('x-webhook-signature'),
            'x-webhook-timestamp' => $this->request->getHeaderLine('x-webhook-timestamp'),
            'x-cashfree-signature'=> $this->request->getHeaderLine('x-cashfree-signature'),
            'x-razorpay-signature'=> $this->request->getHeaderLine('x-razorpay-signature'),
        ];

        $signatureValid = $gateway->verifyWebhookSignature($headers, $rawBody);
        $configuredWebhookSecret = trim((string) app_setting($provider . '_webhook_secret', '')) !== '';

        if (! $configuredWebhookSecret) {
            log_message('warning', 'Payment webhook rejected because no webhook secret is configured for provider {provider}.', ['provider' => $provider]);
            $this->logWebhook($provider, $headers, $payload, $signatureValid, null, null, 'missing_secret', 'Webhook signature verification is not configured.');

            return $this->response->setStatusCode(503)->setJSON([
                'status' => 'rejected',
                'message' => 'Webhook signature verification is not configured.',
            ]);
        }

        if ($configuredWebhookSecret && ! $signatureValid) {
            log_message('warning', 'Payment webhook rejected because signature verification failed for provider {provider}.', ['provider' => $provider]);
            $this->logWebhook($provider, $headers, $payload, false, null, null, 'signature_failed', 'Invalid webhook signature.');

            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'rejected',
                'message' => 'Invalid webhook signature.',
            ]);
        }

        if (! $signatureValid) {
            log_message('warning', 'Payment webhook signature could not be verified for provider {provider}.', ['provider' => $provider]);
        }

        $refundProcessed = $this->processRefundWebhook($provider, $payload);

        if ($refundProcessed) {
            $gatewayOrderId = $gateway->extractWebhookOrderId($payload);
            $gatewayPaymentId = $this->extractWebhookPaymentId($payload);
            $this->logWebhook($provider, $headers, $payload, $signatureValid, $gatewayOrderId, $gatewayPaymentId, 'processed', 'Refund webhook processed.');

            return $this->response->setJSON([
                'status' => 'ok',
                'signature_verified' => $signatureValid,
                'refund_processed' => true,
            ]);
        }

        $gatewayOrderId = $gateway->extractWebhookOrderId($payload);
        $gatewayPaymentId = $this->extractWebhookPaymentId($payload);

        if ($gatewayOrderId === null) {
            $this->logWebhook($provider, $headers, $payload, $signatureValid, null, $gatewayPaymentId, 'ignored_no_order', 'No order id found in webhook payload.');

            return $this->response->setStatusCode(202)->setJSON([
                'status' => 'ignored',
                'message' => 'No order id found in webhook payload.',
            ]);
        }

        $booking = $this->payments()->bookingByGatewayOrderId($gatewayOrderId);

        if ($booking === null) {
            $eventPayment = $this->payments()->eventPaymentByGatewayOrderId($gatewayOrderId);

            if ($eventPayment !== null) {
                $result = $this->payments()->verifyEventPayment($eventPayment, $gatewayOrderId);
                $this->logWebhook($provider, $headers, $payload, $signatureValid, $gatewayOrderId, $gatewayPaymentId, 'processed', 'Event payment status: ' . $result->status);

                return $this->response->setJSON([
                    'status' => 'ok',
                    'signature_verified' => $signatureValid,
                    'payment_status' => $result->status,
                    'event_payment_code' => $eventPayment['payment_code'] ?? null,
                ]);
            }

            $this->logWebhook($provider, $headers, $payload, $signatureValid, $gatewayOrderId, $gatewayPaymentId, 'ignored_no_payment_record', 'No matching booking or event payment found.');

            return $this->response->setStatusCode(202)->setJSON([
                'status' => 'ignored',
                'message' => 'No matching booking or event payment found.',
            ]);
        }

        $result = $this->payments()->verifyBookingPayment($booking, $gatewayOrderId);
        $booking = $this->payments()->bookingByCode((string) ($booking['booking_code'] ?? '')) ?? $booking;

        if ($result->status === 'paid') {
            $this->payments()->sendBookingNotificationsIfNeeded($booking);
        }

        $this->logWebhook($provider, $headers, $payload, $signatureValid, $gatewayOrderId, $gatewayPaymentId, 'processed', 'Payment status: ' . $result->status);

        return $this->response->setJSON([
            'status' => 'ok',
            'signature_verified' => $signatureValid,
            'payment_status' => $result->status,
            'booking_code' => $booking['booking_code'] ?? null,
        ]);
    }

    public function razorpayVerify(): ResponseInterface
    {
        $payload = $this->request->getJSON(true);

        if (! is_array($payload)) {
            $payload = $this->request->getPost();
        }

        $bookingCode = trim((string) ($payload['booking_code'] ?? ''));
        $orderId = trim((string) ($payload['razorpay_order_id'] ?? $payload['gateway_order_id'] ?? ''));
        $paymentId = trim((string) ($payload['razorpay_payment_id'] ?? ''));
        $signature = trim((string) ($payload['razorpay_signature'] ?? ''));

        if ($bookingCode === '' || $orderId === '' || $paymentId === '' || $signature === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'failed',
                'message' => 'Incomplete Razorpay payment response.',
            ]);
        }

        $gateway = service('paymentGatewayFactory')->make('razorpay');

        if (! $gateway || ! method_exists($gateway, 'verifyCheckoutSignature') || ! $gateway->verifyCheckoutSignature($orderId, $paymentId, $signature)) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'failed',
                'message' => 'Invalid Razorpay payment signature.',
            ]);
        }

        $booking = $this->payments()->bookingByCode($bookingCode);

        if ($booking === null) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'failed',
                'message' => 'Booking not found.',
            ]);
        }

        $this->payments()->markTransactionPaymentId($orderId, $paymentId);
        $result = $this->payments()->verifyBookingPayment($booking, $orderId);
        $booking = $this->payments()->bookingByCode($bookingCode) ?? $booking;

        if ($result->status === 'paid') {
            $this->payments()->sendBookingNotificationsIfNeeded($booking);
        }

        return $this->response->setJSON([
            'status' => $result->status,
            'message' => $result->message,
            'redirect_url' => base_url('booking/payment-status/' . $bookingCode . '?source=razorpay'),
        ]);
    }

    private function logWebhook(
        string $gateway,
        array $headers,
        ?array $payload,
        bool $signatureValid,
        ?string $gatewayOrderId,
        ?string $gatewayPaymentId,
        string $processStatus,
        ?string $errorMessage = null,
    ): void {
        try {
            $db = \Config\Database::connect();

            if (! $db instanceof BaseConnection || ! $db->tableExists('payment_webhook_logs')) {
                return;
            }

            $db->table('payment_webhook_logs')->insert([
                'gateway' => substr($gateway, 0, 40),
                'event_type' => $this->extractWebhookEventType($payload),
                'gateway_event_id' => $this->extractWebhookEventId($payload),
                'signature_valid' => $signatureValid ? 1 : 0,
                'gateway_order_id' => $gatewayOrderId,
                'gateway_payment_id' => $gatewayPaymentId,
                'headers_json' => $headers !== [] ? json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                'payload_json' => $payload !== null ? json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                'process_status' => $processStatus,
                'error_message' => $errorMessage !== null ? substr($errorMessage, 0, 255) : null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Payment webhook log write failed: {message}', ['message' => $e->getMessage()]);
        }
    }

    private function extractWebhookEventType(?array $payload): ?string
    {
        if ($payload === null) {
            return null;
        }

        $value = $payload['event'] ?? $payload['type'] ?? $payload['event_type'] ?? $payload['data']['type'] ?? null;

        return is_scalar($value) ? substr((string) $value, 0, 120) : null;
    }

    private function extractWebhookEventId(?array $payload): ?string
    {
        if ($payload === null) {
            return null;
        }

        $value = $payload['id']
            ?? $payload['event_id']
            ?? $payload['data']['event_id']
            ?? $payload['data']['cf_event_id']
            ?? null;

        return is_scalar($value) ? substr((string) $value, 0, 160) : null;
    }

    private function extractWebhookPaymentId(array $payload): ?string
    {
        $value = $payload['payload']['payment']['entity']['id']
            ?? $payload['data']['payment']['payment_id']
            ?? $payload['data']['payment']['cf_payment_id']
            ?? $payload['data']['payment_id']
            ?? null;

        return is_scalar($value) ? substr((string) $value, 0, 120) : null;
    }

    private function processRefundWebhook(string $provider, array $payload): bool
    {
        $refundId = $this->extractWebhookRefundId($payload);
        $refundReference = $this->extractWebhookRefundReference($payload);

        if ($refundId === null && $refundReference === null) {
            return false;
        }

        try {
            $db = \Config\Database::connect();

            if (! $db->tableExists('payment_refunds')) {
                return false;
            }

            $builder = $db->table('payment_refunds')->where('gateway', $provider)->groupStart();

            if ($refundId !== null && $refundReference !== null) {
                $builder->where('gateway_refund_id', $refundId);
                $builder->orWhere('refund_reference', $refundReference);
            } elseif ($refundId !== null) {
                $builder->where('gateway_refund_id', $refundId);
            } else {
                $builder->where('refund_reference', (string) $refundReference);
            }

            $refund = $builder->groupEnd()->get()->getRowArray();

            if (! $refund) {
                return false;
            }

            $status = $this->extractWebhookRefundStatus($provider, $payload);
            $update = [
                'gateway_refund_id' => $refundId ?: ($refund['gateway_refund_id'] ?? null),
                'gateway_payment_id' => $this->extractWebhookPaymentId($payload) ?: ($refund['gateway_payment_id'] ?? null),
                'status' => $status,
                'response_payload' => json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'processed_at' => $status === 'processed' ? date('Y-m-d H:i:s') : ($refund['processed_at'] ?? null),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $db->table('payment_refunds')->where('id', (int) $refund['id'])->update($update);
            $updatedRefund = array_merge($refund, $update);
            $this->notifyGuestIfRefundProcessed((int) ($refund['booking_id'] ?? 0), $updatedRefund);

            return true;
        } catch (Throwable $e) {
            log_message('error', 'Payment refund webhook processing failed: {message}', ['message' => $e->getMessage()]);

            return false;
        }
    }

    private function extractWebhookRefundId(array $payload): ?string
    {
        $value = $payload['payload']['refund']['entity']['id']
            ?? $payload['data']['refund']['cf_refund_id']
            ?? $payload['data']['refund']['refund_id']
            ?? $payload['data']['cf_refund_id']
            ?? $payload['data']['refund_id']
            ?? null;

        return is_scalar($value) && trim((string) $value) !== '' ? substr((string) $value, 0, 160) : null;
    }

    private function extractWebhookRefundReference(array $payload): ?string
    {
        $value = $payload['payload']['refund']['entity']['notes']['refund_reference']
            ?? $payload['data']['refund']['refund_id']
            ?? $payload['data']['refund_id']
            ?? null;

        return is_scalar($value) && trim((string) $value) !== '' ? substr((string) $value, 0, 40) : null;
    }

    private function extractWebhookRefundStatus(string $provider, array $payload): string
    {
        if ($provider === 'razorpay') {
            $status = strtolower((string) ($payload['payload']['refund']['entity']['status'] ?? 'pending'));

            return $status === 'processed' ? 'processed' : ($status === 'pending' ? 'pending' : 'failed');
        }

        $status = strtoupper((string) ($payload['data']['refund']['refund_status'] ?? $payload['data']['refund_status'] ?? 'PENDING'));

        return $status === 'SUCCESS' ? 'processed' : (in_array($status, ['PENDING', 'ACTIVE'], true) ? 'pending' : 'failed');
    }

    private function notifyGuestIfRefundProcessed(int $bookingId, array $refund): void
    {
        if ($bookingId <= 0 || (string) ($refund['status'] ?? '') !== 'processed' || ! empty($refund['notified_at'])) {
            return;
        }

        $db = \Config\Database::connect();
        $booking = $db->table('bookings')->where('id', $bookingId)->get()->getRowArray();

        if (! $booking || empty($booking['email'])) {
            return;
        }

        if (service('appMailer')->sendGuestRefundNotification($booking, $refund)) {
            $db->table('payment_refunds')->where('id', (int) ($refund['id'] ?? 0))->update([
                'notified_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
