<?php

namespace App\Libraries\Payments;

use App\Libraries\Payments\Contracts\PaymentGatewayInterface;
use App\Libraries\Payments\DTO\CheckoutSession;
use App\Libraries\Payments\DTO\VerificationResult;
use CodeIgniter\Database\BaseConnection;
use DateTimeImmutable;

class PaymentService
{
    public function __construct(
        private readonly PaymentGatewayFactory $factory,
        private readonly ?BaseConnection $db = null,
    ) {
    }

    public function providerOptions(): array
    {
        return $this->factory->providerOptions();
    }

    public function gatewayModeActive(): bool
    {
        return app_setting('payment_gateway_enabled', '0') === '1';
    }

    public function websiteBookingEnabled(): bool
    {
        return app_setting('booking_enabled', '1') === '1';
    }

    public function currentProvider(): string
    {
        $provider = trim((string) app_setting('payment_gateway_provider', 'cashfree'));

        return $provider !== '' ? $provider : 'cashfree';
    }

    public function currentGateway(): ?PaymentGatewayInterface
    {
        return $this->factory->make($this->currentProvider());
    }

    public function currentGatewayLabel(): string
    {
        return $this->currentGateway()?->label() ?? 'Payment Gateway';
    }

    public function isReady(): bool
    {
        if (! $this->gatewayModeActive()) {
            return false;
        }

        $gateway = $this->currentGateway();

        if ($gateway === null || ! $gateway->isConfigured()) {
            return false;
        }

        if (trim((string) app_setting($gateway->id() . '_webhook_secret', '')) === '') {
            return false;
        }

        return in_array($gateway->environment(), ['sandbox', 'production'], true);
    }

    public function checkoutScriptUrl(): string
    {
        return $this->currentGateway()?->checkoutScriptUrl() ?? '';
    }

    public function buildBookingCode(): string
    {
        return 'BKG' . date('ymdHis') . strtoupper(substr(bin2hex(random_bytes(4)), 0, 4));
    }

    public function buildEventPaymentCode(): string
    {
        return 'EVP' . date('ymdHis') . strtoupper(substr(bin2hex(random_bytes(4)), 0, 4));
    }

    public function calculateRoomAmount(array $room, string $checkin, string $checkout, int $roomsRequired = 1): array
    {
        $start = new DateTimeImmutable($checkin);
        $end = new DateTimeImmutable($checkout);
        $nights = max(1, (int) $start->diff($end)->days);
        $rate = round((float) ($room['price'] ?? 0), 2);
        $roomsRequired = max(1, $roomsRequired);

        return [
            'nights' => $nights,
            'nightly_rate' => $rate,
            'rooms_required' => $roomsRequired,
            'total_amount' => round($rate * $nights * $roomsRequired, 2),
            'currency' => 'INR',
        ];
    }

    public function prepareCheckout(array $booking, array $room): CheckoutSession
    {
        $gateway = $this->currentGateway();

        if ($gateway === null) {
            return new CheckoutSession(false, 'Selected payment gateway is not supported.');
        }

        $existing = $this->latestTransaction((int) $booking['id']);

        if (
            $existing !== null
            && (string) ($existing['gateway'] ?? '') === $gateway->id()
            && trim((string) ($existing['session_token'] ?? '')) !== ''
            && in_array((string) ($existing['status'] ?? ''), ['created', 'checkout_ready', 'pending'], true)
        ) {
            return new CheckoutSession(
                true,
                'Reusing existing checkout session.',
                (string) ($existing['gateway_order_id'] ?? ''),
                (string) ($existing['session_token'] ?? ''),
                json_decode((string) ($existing['request_payload'] ?? '[]'), true) ?: [],
                json_decode((string) ($existing['response_payload'] ?? '[]'), true) ?: [],
            );
        }

        $gatewayOrderId = $this->buildGatewayOrderId((string) ($booking['booking_code'] ?? ''));
        $booking['gateway_order_id'] = $gatewayOrderId;
        $session = $gateway->createCheckout($booking, $room);

        $transactionData = [
            'booking_id'        => (int) $booking['id'],
            'payment_for'       => 'booking',
            'event_payment_id'  => null,
            'gateway'           => $gateway->id(),
            'gateway_order_id'  => $session->gatewayOrderId ?: $gatewayOrderId,
            'gateway_payment_id'=> null,
            'amount'            => round((float) ($booking['total_amount'] ?? 0), 2),
            'currency'          => (string) ($booking['currency'] ?? 'INR'),
            'status'            => $session->success ? 'checkout_ready' : 'failed',
            'session_token'     => $session->sessionToken,
            'request_payload'   => json_encode($session->requestPayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'response_payload'  => json_encode($session->responsePayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'verified_payload'  => null,
            'paid_at'           => null,
            'verified_at'       => null,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        $this->db()->table('payment_transactions')->insert($transactionData);

        $this->db()->table('bookings')->where('id', (int) $booking['id'])->update([
            'payment_gateway' => $gateway->id(),
            'payment_status'  => $session->success ? 'pending' : 'failed',
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        return $session;
    }

    public function prepareEventCheckout(array $eventPayment): CheckoutSession
    {
        $gateway = $this->currentGateway();

        if ($gateway === null) {
            return new CheckoutSession(false, 'Selected payment gateway is not supported.');
        }

        $existing = $this->latestEventTransaction((int) $eventPayment['id']);

        if (
            $existing !== null
            && (string) ($existing['gateway'] ?? '') === $gateway->id()
            && trim((string) ($existing['session_token'] ?? '')) !== ''
            && in_array((string) ($existing['status'] ?? ''), ['created', 'checkout_ready', 'pending'], true)
        ) {
            return new CheckoutSession(
                true,
                'Reusing existing checkout session.',
                (string) ($existing['gateway_order_id'] ?? ''),
                (string) ($existing['session_token'] ?? ''),
                json_decode((string) ($existing['request_payload'] ?? '[]'), true) ?: [],
                json_decode((string) ($existing['response_payload'] ?? '[]'), true) ?: [],
            );
        }

        $gatewayOrderId = $this->buildGatewayOrderId((string) ($eventPayment['payment_code'] ?? ''));
        $payloadBooking = [
            'id' => (int) ($eventPayment['id'] ?? 0),
            'booking_code' => (string) ($eventPayment['payment_code'] ?? ''),
            'gateway_order_id' => $gatewayOrderId,
            'total_amount' => round((float) ($eventPayment['amount'] ?? 0), 2),
            'currency' => (string) ($eventPayment['currency'] ?? 'INR'),
            'name' => (string) ($eventPayment['customer_name'] ?? 'Guest'),
            'email' => (string) ($eventPayment['customer_email'] ?? ''),
            'phone' => (string) ($eventPayment['customer_phone'] ?? ''),
            'checkin' => (string) ($eventPayment['event_date'] ?? ''),
            'checkout' => (string) ($eventPayment['event_date'] ?? ''),
            'return_url' => base_url('event-payment/return?payment=' . urlencode((string) ($eventPayment['payment_code'] ?? '')) . '&order_id={order_id}'),
            'notes' => [
                'payment_for' => 'event',
                'event_type' => (string) ($eventPayment['event_type'] ?? ''),
                'guests' => (string) ($eventPayment['guests'] ?? ''),
            ],
            'order_note' => 'Event payment for ' . (string) ($eventPayment['event_type'] ?? 'Event') . ' (' . (string) ($eventPayment['payment_code'] ?? '') . ')',
        ];
        $payloadRoom = [
            'name' => 'Event Payment - ' . (string) ($eventPayment['event_type'] ?? 'Event'),
        ];

        $session = $gateway->createCheckout($payloadBooking, $payloadRoom);

        $this->db()->table('payment_transactions')->insert([
            'booking_id'        => null,
            'payment_for'       => 'event',
            'event_payment_id'  => (int) $eventPayment['id'],
            'gateway'           => $gateway->id(),
            'gateway_order_id'  => $session->gatewayOrderId ?: $gatewayOrderId,
            'gateway_payment_id'=> null,
            'amount'            => round((float) ($eventPayment['amount'] ?? 0), 2),
            'currency'          => (string) ($eventPayment['currency'] ?? 'INR'),
            'status'            => $session->success ? 'checkout_ready' : 'failed',
            'session_token'     => $session->sessionToken,
            'request_payload'   => json_encode($session->requestPayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'response_payload'  => json_encode($session->responsePayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'verified_payload'  => null,
            'paid_at'           => null,
            'verified_at'       => null,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        $this->db()->table('event_payments')->where('id', (int) $eventPayment['id'])->update([
            'payment_gateway' => $gateway->id(),
            'payment_status' => $session->success ? 'pending' : 'failed',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $session;
    }

    public function verifyBookingPayment(array $booking, ?string $gatewayOrderId = null): VerificationResult
    {
        $transaction = $gatewayOrderId !== null && $gatewayOrderId !== ''
            ? $this->findTransactionByOrderId($gatewayOrderId)
            : $this->latestTransaction((int) $booking['id']);

        if ($transaction === null) {
            return new VerificationResult(false, 'failed', 'No payment attempt was found for this booking.');
        }

        if ((int) ($transaction['booking_id'] ?? 0) !== (int) ($booking['id'] ?? 0)) {
            return new VerificationResult(false, 'failed', 'Payment attempt does not belong to this booking.');
        }

        $gateway = $this->factory->make((string) $transaction['gateway']);

        if ($gateway === null) {
            return new VerificationResult(false, 'failed', 'Payment gateway for this booking is not supported.');
        }

        $result = $gateway->verifyOrder((string) $transaction['gateway_order_id']);

        $transactionUpdate = [
            'gateway_payment_id' => $result->gatewayPaymentId,
            'status'             => $result->status,
            'verified_payload'   => json_encode($result->payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'verified_at'        => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        if ($result->status === 'paid') {
            $transactionUpdate['paid_at'] = date('Y-m-d H:i:s');
        }

        $this->db()->table('payment_transactions')->where('id', (int) $transaction['id'])->update($transactionUpdate);

        $bookingUpdate = [
            'payment_gateway' => (string) $transaction['gateway'],
            'payment_status'  => $result->status,
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        $this->db()->table('bookings')->where('id', (int) $booking['id'])->update($bookingUpdate);

        return $result;
    }

    public function bookingByCode(string $bookingCode): ?array
    {
        return $this->db()->table('bookings')->where('booking_code', $bookingCode)->get()->getRowArray();
    }

    public function bookingByGatewayOrderId(string $gatewayOrderId): ?array
    {
        $transaction = $this->findTransactionByOrderId($gatewayOrderId);

        if ($transaction === null) {
            return null;
        }

        return $this->db()->table('bookings')->where('id', (int) $transaction['booking_id'])->get()->getRowArray();
    }

    public function eventPaymentByCode(string $paymentCode): ?array
    {
        if (! $this->db()->tableExists('event_payments')) {
            return null;
        }

        return $this->db()->table('event_payments')->where('payment_code', $paymentCode)->get()->getRowArray();
    }

    public function eventPaymentByGatewayOrderId(string $gatewayOrderId): ?array
    {
        $transaction = $this->findTransactionByOrderId($gatewayOrderId);

        if ($transaction === null || (string) ($transaction['payment_for'] ?? 'booking') !== 'event') {
            return null;
        }

        return $this->db()->table('event_payments')->where('id', (int) $transaction['event_payment_id'])->get()->getRowArray();
    }

    public function verifyEventPayment(array $eventPayment, ?string $gatewayOrderId = null): VerificationResult
    {
        if ((string) ($eventPayment['payment_status'] ?? '') === 'cancelled') {
            return new VerificationResult(false, 'cancelled', 'This event payment link has been cancelled.');
        }

        $transaction = $gatewayOrderId !== null && $gatewayOrderId !== ''
            ? $this->findTransactionByOrderId($gatewayOrderId)
            : $this->latestEventTransaction((int) $eventPayment['id']);

        if ($transaction === null) {
            return new VerificationResult(false, 'failed', 'No payment attempt was found for this event payment.');
        }

        if ((int) ($transaction['event_payment_id'] ?? 0) !== (int) ($eventPayment['id'] ?? 0)) {
            return new VerificationResult(false, 'failed', 'Payment attempt does not belong to this event payment.');
        }

        $gateway = $this->factory->make((string) $transaction['gateway']);

        if ($gateway === null) {
            return new VerificationResult(false, 'failed', 'Payment gateway for this event payment is not supported.');
        }

        $result = $gateway->verifyOrder((string) $transaction['gateway_order_id']);

        $transactionUpdate = [
            'gateway_payment_id' => $result->gatewayPaymentId,
            'status'             => $result->status,
            'verified_payload'   => json_encode($result->payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'verified_at'        => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        if ($result->status === 'paid') {
            $transactionUpdate['paid_at'] = date('Y-m-d H:i:s');
        }

        $this->db()->table('payment_transactions')->where('id', (int) $transaction['id'])->update($transactionUpdate);

        $this->db()->table('event_payments')->where('id', (int) $eventPayment['id'])->update([
            'payment_gateway' => (string) $transaction['gateway'],
            'payment_status' => $result->status,
            'paid_at' => $result->status === 'paid' ? date('Y-m-d H:i:s') : ($eventPayment['paid_at'] ?? null),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $result;
    }

    public function sendBookingNotificationsIfNeeded(array $booking): void
    {
        if (($booking['payment_notified_at'] ?? null) !== null) {
            return;
        }

        $mailer = service('appMailer');

        if (! $mailer->sendBookingAdminNotification($booking)) {
            log_message('error', 'Failed to send admin booking payment notification email.');
        }

        if (! $mailer->sendBookingAutoReply($booking)) {
            log_message('warning', 'Booking payment auto-reply email was not sent.');
        }

        $this->db()->table('bookings')->where('id', (int) $booking['id'])->update([
            'payment_notified_at' => date('Y-m-d H:i:s'),
            'updated_at'          => date('Y-m-d H:i:s'),
        ]);
    }

    public function latestTransaction(int $bookingId): ?array
    {
        return $this->db()->table('payment_transactions')
            ->where('booking_id', $bookingId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function latestEventTransaction(int $eventPaymentId): ?array
    {
        return $this->db()->table('payment_transactions')
            ->where('payment_for', 'event')
            ->where('event_payment_id', $eventPaymentId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function bookingStatusLabel(string $paymentStatus): string
    {
        return match ($paymentStatus) {
            'paid' => 'Payment Successful',
            'failed' => 'Payment Failed',
            'cancelled' => 'Payment Cancelled',
            'pending', 'initiated' => 'Payment Pending',
            default => 'Booking Created',
        };
    }

    public function bookingStatusMessage(array $booking): string
    {
        return match ((string) ($booking['payment_status'] ?? 'not_required')) {
            'paid' => 'Your payment was received successfully and your booking has been recorded. Please keep your receipt number for reference.',
            'failed' => 'Your payment did not go through. You can review the details below and retry securely.',
            'cancelled' => 'The payment was cancelled before completion. You can retry whenever you are ready.',
            'pending', 'initiated' => 'We are still checking the payment result. If you have already paid, please wait a moment and refresh this page.',
            default => 'Your booking request has been created successfully.',
        };
    }

    public function bookingCanRetry(array $booking): bool
    {
        if ((int) ($booking['payment_required'] ?? 0) !== 1) {
            return false;
        }

        return in_array((string) ($booking['payment_status'] ?? ''), ['failed', 'cancelled'], true);
    }

    public function receiptData(array $booking, ?array $room = null, ?array $transaction = null): array
    {
        $room ??= [];
        $transaction ??= $this->latestTransaction((int) ($booking['id'] ?? 0));
        $checkin = (string) ($booking['checkin'] ?? '');
        $checkout = (string) ($booking['checkout'] ?? '');
        $nights = 1;

        if ($checkin !== '' && $checkout !== '') {
            $nights = max(1, (int) (new DateTimeImmutable($checkin))->diff(new DateTimeImmutable($checkout))->days);
        }

        $paidAt = $transaction['paid_at'] ?? $transaction['verified_at'] ?? $booking['updated_at'] ?? $booking['created_at'] ?? null;

        $invoiceNumber = trim((string) ($booking['invoice_number'] ?? ''));
        $bookingCode = (string) ($booking['booking_code'] ?? '');

        if ($invoiceNumber === '') {
            $prefix = strtoupper(preg_replace('/[^A-Z0-9]/i', '', (string) app_setting('receipt_invoice_prefix', 'HHP')) ?: 'HHP');
            $invoiceNumber = $bookingCode !== '' ? $prefix . '-' . $bookingCode : $prefix . '-' . date('YmdHis');
        }

        return $this->withGstReceiptFields([
            'hotel_name'        => app_setting('hotel_name', 'Hotel H Plus'),
            'hotel_address'     => app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra'),
            'hotel_phone'       => app_setting('hotel_phone', '+91 92530 72122'),
            'hotel_email'       => app_setting('hotel_email', 'info@hotelhplus.in'),
            'tax_label'         => app_setting('receipt_tax_label', ''),
            'tax_number'        => app_setting('receipt_tax_number', ''),
            'receipt_number'    => $invoiceNumber,
            'booking_code'      => $bookingCode,
            'payment_reference' => (string) ($transaction['payment_reference'] ?? $transaction['gateway_order_id'] ?? $transaction['gateway_payment_id'] ?? ''),
            'payment_status'    => $this->bookingStatusLabel((string) ($booking['payment_status'] ?? 'not_required')),
            'payment_date'      => $paidAt ? date('d M Y, h:i A', strtotime((string) $paidAt)) : '—',
            'guest_name'        => (string) ($booking['name'] ?? ''),
            'guest_phone'       => (string) ($booking['phone'] ?? ''),
            'guest_email'       => (string) ($booking['email'] ?? ''),
            'room_name'         => (string) ($room['name'] ?? $booking['room_type'] ?? ''),
            'checkin'           => $checkin !== '' ? date('d M Y', strtotime($checkin)) : '—',
            'checkout'          => $checkout !== '' ? date('d M Y', strtotime($checkout)) : '—',
            'rooms_required'    => (string) max(1, (int) ($booking['rooms_required'] ?? 1)),
            'guests'            => (string) ($booking['guests'] ?? '1'),
            'nights'            => (string) $nights,
            'currency'          => (string) ($booking['currency'] ?? 'INR'),
            'amount'            => number_format((float) ($booking['total_amount'] ?? 0), 2),
            'issued_on'         => date('d M Y, h:i A'),
        ]);
    }

    public function eventReceiptData(array $eventPayment, ?array $transaction = null): array
    {
        $transaction ??= $this->latestEventTransaction((int) ($eventPayment['id'] ?? 0));
        $paidAt = $transaction['paid_at'] ?? $transaction['verified_at'] ?? $eventPayment['paid_at'] ?? $eventPayment['updated_at'] ?? null;
        $paymentCode = (string) ($eventPayment['payment_code'] ?? '');
        $prefix = strtoupper(preg_replace('/[^A-Z0-9]/i', '', (string) app_setting('receipt_invoice_prefix', 'HHP')) ?: 'HHP');

        return $this->withGstReceiptFields([
            'hotel_name' => app_setting('hotel_name', 'Hotel H Plus'),
            'hotel_address' => app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra'),
            'hotel_phone' => app_setting('hotel_phone', '+91 92530 72122'),
            'hotel_email' => app_setting('hotel_email', 'info@hotelhplus.in'),
            'tax_label' => app_setting('receipt_tax_label', ''),
            'tax_number' => app_setting('receipt_tax_number', ''),
            'receipt_number' => $prefix . '-' . $paymentCode,
            'booking_code' => $paymentCode,
            'payment_reference' => (string) ($transaction['payment_reference'] ?? $transaction['gateway_order_id'] ?? $transaction['gateway_payment_id'] ?? ''),
            'payment_status' => $this->bookingStatusLabel((string) ($eventPayment['payment_status'] ?? 'created')),
            'payment_date' => $paidAt ? date('d M Y, h:i A', strtotime((string) $paidAt)) : '—',
            'guest_name' => (string) ($eventPayment['customer_name'] ?? ''),
            'guest_phone' => (string) ($eventPayment['customer_phone'] ?? ''),
            'guest_email' => (string) ($eventPayment['customer_email'] ?? ''),
            'room_name' => 'Event Payment - ' . (string) ($eventPayment['event_type'] ?? 'Event'),
            'checkin' => ! empty($eventPayment['event_date']) ? date('d M Y', strtotime((string) $eventPayment['event_date'])) : '—',
            'checkout' => 'Event',
            'rooms_required' => '—',
            'guests' => (string) ($eventPayment['guests'] ?? '—'),
            'nights' => '—',
            'currency' => (string) ($eventPayment['currency'] ?? 'INR'),
            'amount' => number_format((float) ($eventPayment['amount'] ?? 0), 2),
            'issued_on' => date('d M Y, h:i A'),
        ]);
    }

    private function withGstReceiptFields(array $receipt): array
    {
        $gstEnabled = app_setting('receipt_gst_enabled', '0') === '1';
        $gstRate = max(0.0, (float) app_setting('receipt_gst_rate', '12'));
        $grossAmount = (float) str_replace(',', '', (string) ($receipt['amount'] ?? '0'));
        $taxableAmount = $grossAmount;
        $gstAmount = 0.0;

        if ($gstEnabled && $gstRate > 0) {
            $taxableAmount = round($grossAmount / (1 + ($gstRate / 100)), 2);
            $gstAmount = round($grossAmount - $taxableAmount, 2);
        }

        $receipt['gst_enabled'] = $gstEnabled ? '1' : '0';
        $receipt['gst_rate'] = number_format($gstRate, 2);
        $receipt['taxable_amount'] = number_format($taxableAmount, 2);
        $receipt['gst_amount'] = number_format($gstAmount, 2);
        $receipt['receipt_style'] = app_setting('receipt_pdf_style', 'classic');

        if (! $gstEnabled) {
            $receipt['tax_label'] = '';
            $receipt['tax_number'] = '';
        } elseif ((string) ($receipt['tax_label'] ?? '') === '') {
            $receipt['tax_label'] = 'GSTIN';
        }

        return $receipt;
    }

    public function findTransactionByOrderId(string $gatewayOrderId): ?array
    {
        return $this->db()->table('payment_transactions')
            ->where('gateway_order_id', $gatewayOrderId)
            ->get()
            ->getRowArray();
    }

    public function markTransactionPaymentId(string $gatewayOrderId, string $gatewayPaymentId): void
    {
        if ($gatewayOrderId === '' || $gatewayPaymentId === '') {
            return;
        }

        $this->db()->table('payment_transactions')
            ->where('gateway_order_id', $gatewayOrderId)
            ->update([
                'gateway_payment_id' => $gatewayPaymentId,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    private function buildGatewayOrderId(string $bookingCode): string
    {
        $prefix = 'HHP';
        $base = preg_replace('/[^A-Za-z0-9]/', '', strtoupper($bookingCode));
        $suffix = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $value = $prefix . $base . $suffix;

        return substr($value, 0, 40);
    }

    private function db(): BaseConnection
    {
        return $this->db ?? \Config\Database::connect();
    }
}
