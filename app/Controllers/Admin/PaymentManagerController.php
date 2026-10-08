<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class PaymentManagerController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    public function index(): string
    {
        $db = \Config\Database::connect();
        $filters = [
            'status' => (string) ($this->request->getGet('status') ?? 'all'),
            'gateway' => (string) ($this->request->getGet('gateway') ?? 'all'),
            'date_from' => trim((string) ($this->request->getGet('date_from') ?? '')),
            'date_to' => trim((string) ($this->request->getGet('date_to') ?? '')),
            'q' => trim((string) ($this->request->getGet('q') ?? '')),
        ];

        $builder = $this->baseTransactionQuery($db)
            ->orderBy('pt.created_at', 'DESC')
            ->orderBy('pt.id', 'DESC');
        $this->applyFilters($builder, $filters);

        $transactions = $builder->limit(300)->get()->getResultArray();
        $latestRefunds = $this->latestRefundsForTransactions($db, array_column($transactions, 'id'));

        return $this->render('admin/payments/index', [
            'title' => 'Payment Manager',
            'page' => 'payments',
            'transactions' => $transactions,
            'latestRefunds' => $latestRefunds,
            'filters' => $filters,
            'counts' => $this->statusCounts($db),
            'stats' => $this->paymentStats($db),
            'gateways' => $this->gatewayOptions($db),
            'canRefund' => $this->can('payments.refund'),
            'canExport' => $this->can('payments.export'),
        ]);
    }

    public function export(): ResponseInterface|RedirectResponse
    {
        if (! $this->can('payments.export')) {
            return redirect()->to(base_url('admin/payments'))->with('error', 'You do not have permission to export payments.');
        }

        $db = \Config\Database::connect();
        $filters = [
            'status' => (string) ($this->request->getGet('status') ?? 'all'),
            'gateway' => (string) ($this->request->getGet('gateway') ?? 'all'),
            'date_from' => trim((string) ($this->request->getGet('date_from') ?? '')),
            'date_to' => trim((string) ($this->request->getGet('date_to') ?? '')),
            'q' => trim((string) ($this->request->getGet('q') ?? '')),
        ];

        $builder = $this->baseTransactionQuery($db)
            ->orderBy('pt.created_at', 'DESC')
            ->orderBy('pt.id', 'DESC');
        $this->applyFilters($builder, $filters);
        $rows = $builder->get()->getResultArray();

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Transaction ID', 'Type', 'Reference', 'Guest', 'Email', 'Phone', 'Gateway', 'Method', 'Gateway Order ID', 'Gateway Payment ID', 'Payment Reference', 'Amount', 'Currency', 'Status', 'Booking Status', 'Created At']);

        foreach ($rows as $row) {
            fputcsv($handle, [
                $row['id'] ?? '',
                $row['payment_for'] ?? 'booking',
                $row['booking_code'] ?? $row['event_payment_code'] ?? '',
                $row['guest_name'] ?? '',
                $row['guest_email'] ?? '',
                $row['guest_phone'] ?? '',
                $row['gateway'] ?? '',
                $row['payment_method'] ?? '',
                $row['gateway_order_id'] ?? '',
                $row['gateway_payment_id'] ?? '',
                $row['payment_reference'] ?? '',
                $row['amount'] ?? '',
                $row['currency'] ?? '',
                $row['status'] ?? '',
                $row['booking_status'] ?? '',
                $row['created_at'] ?? '',
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle) ?: '';
        fclose($handle);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="payments-' . date('Ymd-His') . '.csv"')
            ->setBody($csv);
    }

    public function show(int $id): string|RedirectResponse
    {
        $db = \Config\Database::connect();
        $transaction = $this->baseTransactionQuery($db)
            ->where('pt.id', $id)
            ->get()
            ->getRowArray();

        if (! $transaction) {
            return redirect()->to(base_url('admin/payments'))->with('error', 'Payment transaction not found.');
        }

        $webhookLogs = [];

        if ($db->tableExists('payment_webhook_logs') && trim((string) ($transaction['gateway_order_id'] ?? '')) !== '') {
            $webhookLogs = $db->table('payment_webhook_logs')
                ->where('gateway_order_id', (string) $transaction['gateway_order_id'])
                ->orderBy('created_at', 'DESC')
                ->orderBy('id', 'DESC')
                ->limit(50)
                ->get()
                ->getResultArray();
        }

        $refunds = [];

        if ($db->tableExists('payment_refunds')) {
            $refunds = $db->table('payment_refunds')
                ->where('payment_transaction_id', $id)
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray();
        }

        return $this->render('admin/payments/show', [
            'title' => 'Payment #' . $id,
            'page' => 'payments',
            'transaction' => $transaction,
            'webhookLogs' => $webhookLogs,
            'refunds' => $refunds,
            'refundAllowed' => $this->refundAllowed($transaction, $refunds),
            'refundOtpPending' => $this->refundOtpPending($id),
            'refundOtpEmail' => $this->maskEmail((string) ($this->refundOtpSession($id)['admin_email'] ?? session()->get('admin_email') ?? '')),
            'canRefund' => $this->can('payments.refund'),
        ]);
    }

    public function recheck(int $id): RedirectResponse
    {
        if (! $this->can('payments.recheck')) {
            return redirect()->back()->with('error', 'You do not have permission to recheck payments.');
        }

        $db = \Config\Database::connect();
        $transaction = $db->table('payment_transactions')->where('id', $id)->get()->getRowArray();

        if (! $transaction) {
            return redirect()->to(base_url('admin/payments'))->with('error', 'Payment transaction not found.');
        }

        $oldStatus = (string) ($transaction['status'] ?? '');

        if (($transaction['payment_for'] ?? 'booking') === 'event') {
            $eventPayment = $db->table('event_payments')->where('id', (int) $transaction['event_payment_id'])->get()->getRowArray();

            if (! $eventPayment) {
                return redirect()->back()->with('error', 'Linked event payment was not found.');
            }

            $result = service('paymentService')->verifyEventPayment($eventPayment, (string) $transaction['gateway_order_id']);

            Services::auditLogger()->log('event_payment.rechecked', 'payment_transaction', $id, 'Event payment rechecked: ' . (string) $transaction['gateway_order_id'], [
                'gateway' => (string) ($transaction['gateway'] ?? ''),
                'gateway_order_id' => (string) ($transaction['gateway_order_id'] ?? ''),
                'old_status' => $oldStatus,
                'new_status' => $result->status,
                'payment_code' => (string) ($eventPayment['payment_code'] ?? ''),
            ]);

            return redirect()->back()->with($result->success ? 'success' : 'error', $result->success ? 'Event payment rechecked. Current status: ' . $result->status . '.' : $result->message);
        }

        $booking = $db->table('bookings')->where('id', (int) $transaction['booking_id'])->get()->getRowArray();

        if (! $booking) {
            return redirect()->back()->with('error', 'Linked booking was not found.');
        }

        $result = service('paymentService')->verifyBookingPayment($booking, (string) $transaction['gateway_order_id']);
        $updatedBooking = service('paymentService')->bookingByCode((string) ($booking['booking_code'] ?? '')) ?? $booking;

        if ($result->status === 'paid') {
            service('paymentService')->sendBookingNotificationsIfNeeded($updatedBooking);
        }

        Services::auditLogger()->log('payment.rechecked', 'payment_transaction', $id, 'Payment rechecked: ' . (string) $transaction['gateway_order_id'], [
            'gateway' => (string) ($transaction['gateway'] ?? ''),
            'gateway_order_id' => (string) ($transaction['gateway_order_id'] ?? ''),
            'gateway_payment_id' => (string) ($transaction['gateway_payment_id'] ?? ''),
            'old_status' => $oldStatus,
            'new_status' => $result->status,
            'booking_code' => (string) ($booking['booking_code'] ?? ''),
        ]);

        $message = $result->success
            ? 'Payment rechecked. Current status: ' . $result->status . '.'
            : $result->message;

        return redirect()->back()->with($result->success ? 'success' : 'error', $message);
    }

    public function refund(int $id): RedirectResponse
    {
        if (! $this->can('payments.refund')) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        $db = \Config\Database::connect();
        $transaction = $this->baseTransactionQuery($db)
            ->where('pt.id', $id)
            ->get()
            ->getRowArray();

        if (! $transaction) {
            return redirect()->to(base_url('admin/payments'))->with('error', 'Payment transaction not found.');
        }

        $refunds = $db->tableExists('payment_refunds')
            ? $db->table('payment_refunds')->where('payment_transaction_id', $id)->get()->getResultArray()
            : [];

        if (! $this->refundAllowed($transaction, $refunds)) {
            return redirect()->back()->with('error', $this->refundBlockedMessage($transaction, $refunds));
        }

        $adminEmail = trim((string) session()->get('admin_email'));

        if ($adminEmail === '') {
            return redirect()->back()->with('error', 'Admin email is required before a refund OTP can be sent.');
        }

        $allowedDomain = $this->refundOtpAllowedDomain();

        if ($allowedDomain === '') {
            return redirect()->back()->with('error', 'Hotel domain could not be detected. Set the hotel email before sending refund OTP.');
        }

        if (! $this->emailBelongsToDomain($adminEmail, $allowedDomain)) {
            return redirect()->back()->with('error', 'Refund OTP can only be sent to an admin email on @' . $allowedDomain . '. Update the admin email to a domain-owned address.');
        }

        $rateIdentifier = $this->refundOtpRateIdentifier($id, $adminEmail);
        $rateLimiter = service('rateLimiter');

        if ($rateLimiter->isLocked('refund_otp_request', $rateIdentifier)) {
            return redirect()->back()->with('error', $rateLimiter->lockedMessage('refund_otp_request', $rateIdentifier, 'Refund OTP was sent recently.'));
        }

        $otp = (string) random_int(100000, 999999);
        $this->setRefundOtpSession($id, $adminEmail, $allowedDomain, $otp);

        if (! service('appMailer')->sendAdminRefundOtp($adminEmail, $otp, $transaction)) {
            $this->clearRefundOtpSession($id);

            return redirect()->back()->with('error', 'Could not send refund OTP. Please check SMTP/admin email settings.');
        }

        $rateLimiter->hit(
            'refund_otp_request',
            $rateIdentifier,
            1,
            (int) app_setting('security_refund_otp_resend_minutes', '2')
        );

        Services::auditLogger()->log('payment.refund_otp_sent', 'payment_transaction', $id, 'Refund OTP sent to admin email', [
            'gateway' => (string) ($transaction['gateway'] ?? ''),
            'gateway_order_id' => (string) ($transaction['gateway_order_id'] ?? ''),
            'booking_code' => (string) ($transaction['booking_code'] ?? ''),
            'otp_email' => $adminEmail,
            'otp_email_masked' => $this->maskEmail($adminEmail),
            'allowed_domain' => $allowedDomain,
        ]);

        return redirect()->back()->with('success', 'Refund OTP sent to ' . $this->maskEmail($adminEmail) . '.');
    }

    public function verifyRefundOtp(int $id): RedirectResponse
    {
        if (! $this->can('payments.refund')) {
            $this->clearRefundOtpSession($id);

            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        $db = \Config\Database::connect();
        $transaction = $this->baseTransactionQuery($db)
            ->where('pt.id', $id)
            ->get()
            ->getRowArray();

        if (! $transaction) {
            return redirect()->to(base_url('admin/payments'))->with('error', 'Payment transaction not found.');
        }

        $refunds = $db->tableExists('payment_refunds')
            ? $db->table('payment_refunds')->where('payment_transaction_id', $id)->get()->getResultArray()
            : [];

        if (! $this->refundAllowed($transaction, $refunds)) {
            $this->clearRefundOtpSession($id);

            return redirect()->back()->with('error', $this->refundBlockedMessage($transaction, $refunds));
        }

        $otp = preg_replace('/\D+/', '', (string) $this->request->getPost('refund_otp'));
        $otpSession = $this->refundOtpSession($id);

        if (! $otpSession || time() > (int) ($otpSession['expires_at'] ?? 0)) {
            $this->clearRefundOtpSession($id);

            return redirect()->back()->with('error', 'Refund OTP expired. Please request a new OTP.');
        }

        $attempts = (int) ($otpSession['attempts'] ?? 0);

        $maxOtpAttempts = max(1, (int) app_setting('security_refund_otp_max_attempts', '5'));

        if ($otp === '' || ! password_verify($otp, (string) ($otpSession['hash'] ?? ''))) {
            $otpSession['attempts'] = $attempts + 1;
            session()->set($this->refundOtpSessionKey($id), $otpSession);

            if ($otpSession['attempts'] >= $maxOtpAttempts) {
                $this->clearRefundOtpSession($id);

                return redirect()->back()->with('error', 'Too many incorrect OTP attempts. Please request a new OTP.');
            }

            return redirect()->back()->with('error', 'Invalid refund OTP. Please try again.');
        }

        $otpEmail = (string) ($otpSession['admin_email'] ?? '');
        $this->clearRefundOtpSession($id);

        return $this->executeRefund($transaction, $refunds, $otpEmail);
    }

    public function recheckRefund(int $id): RedirectResponse
    {
        if (! $this->can('payments.recheck')) {
            return redirect()->back()->with('error', 'You do not have permission to recheck refunds.');
        }

        $db = \Config\Database::connect();
        $refund = $db->table('payment_refunds')->where('id', $id)->get()->getRowArray();

        if (! $refund) {
            return redirect()->to(base_url('admin/payments'))->with('error', 'Refund not found.');
        }

        $gateway = service('paymentGatewayFactory')->make((string) ($refund['gateway'] ?? ''));

        if ($gateway === null || ! $gateway->isConfigured()) {
            return redirect()->back()->with('error', 'Payment gateway is not configured for refund recheck.');
        }

        $oldStatus = (string) ($refund['status'] ?? '');
        $refundLookupId = (string) ((string) ($refund['gateway'] ?? '') === 'cashfree'
            ? ($refund['refund_reference'] ?? '')
            : (($refund['gateway_refund_id'] ?? '') ?: ($refund['refund_reference'] ?? '')));
        $result = $gateway->fetchRefund(
            (string) ($refund['gateway_order_id'] ?? ''),
            $refundLookupId,
            (string) ($refund['gateway_payment_id'] ?? ''),
        );

        $update = [
            'gateway_refund_id' => $result->gatewayRefundId ?: ($refund['gateway_refund_id'] ?? null),
            'gateway_payment_id' => $result->gatewayPaymentId ?: ($refund['gateway_payment_id'] ?? null),
            'status' => $result->status,
            'response_payload' => json_encode($result->payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'processed_at' => $result->status === 'processed' ? date('Y-m-d H:i:s') : ($refund['processed_at'] ?? null),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $db->table('payment_refunds')->where('id', $id)->update($update);
        $this->notifyGuestIfRefundProcessed((int) ($refund['booking_id'] ?? 0), array_merge($refund, $update));

        Services::auditLogger()->log('payment.refund_rechecked', 'payment_refund', $id, 'Refund rechecked: ' . (string) ($refund['refund_reference'] ?? ''), [
            'old_status' => $oldStatus,
            'new_status' => $result->status,
            'gateway_refund_id' => $update['gateway_refund_id'],
        ]);

        return redirect()->back()->with($result->success ? 'success' : 'error', $result->success ? 'Refund rechecked. Current status: ' . $result->status . '.' : $result->message);
    }

    private function executeRefund(array $transaction, array $refunds, string $otpEmail): RedirectResponse
    {
        if (! $this->refundAllowed($transaction, $refunds)) {
            return redirect()->back()->with('error', $this->refundBlockedMessage($transaction, $refunds));
        }

        $db = \Config\Database::connect();
        $gateway = service('paymentGatewayFactory')->make((string) $transaction['gateway']);

        if ($gateway === null || ! $gateway->isConfigured()) {
            return redirect()->back()->with('error', 'Payment gateway is not configured for refund.');
        }

        $refundReference = $this->buildRefundReference((int) $transaction['id']);
        $amount = round((float) ($transaction['amount'] ?? 0), 2);
        $currency = (string) ($transaction['currency'] ?? 'INR');
        $note = 'Refund for cancelled booking ' . (string) ($transaction['booking_code'] ?? '');
        $requestPayload = [
            'gateway_order_id' => (string) ($transaction['gateway_order_id'] ?? ''),
            'gateway_payment_id' => (string) ($transaction['gateway_payment_id'] ?? ''),
            'amount' => $amount,
            'currency' => $currency,
            'refund_reference' => $refundReference,
            'note' => $note,
            'otp_email' => $otpEmail,
        ];

        $result = $gateway->refundPayment(
            (string) ($transaction['gateway_order_id'] ?? ''),
            (string) ($transaction['gateway_payment_id'] ?? ''),
            $amount,
            $currency,
            $refundReference,
            $note,
        );

        $db->table('payment_refunds')->insert([
            'payment_transaction_id' => (int) $transaction['id'],
            'booking_id' => (int) ($transaction['booking_id'] ?? 0),
            'gateway' => (string) ($transaction['gateway'] ?? ''),
            'gateway_order_id' => (string) ($transaction['gateway_order_id'] ?? ''),
            'gateway_payment_id' => $result->gatewayPaymentId ?: (string) ($transaction['gateway_payment_id'] ?? ''),
            'gateway_refund_id' => $result->gatewayRefundId,
            'refund_reference' => $refundReference,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $result->status,
            'note' => $note,
            'request_payload' => json_encode($requestPayload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'response_payload' => json_encode($result->payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'created_by' => session()->get('admin_id') ? (int) session()->get('admin_id') : null,
            'otp_email' => $otpEmail !== '' ? $otpEmail : null,
            'processed_at' => $result->status === 'processed' ? date('Y-m-d H:i:s') : null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $refundId = (int) $db->insertID();
        $storedRefund = $db->table('payment_refunds')->where('id', $refundId)->get()->getRowArray() ?: [];
        $this->notifyGuestIfRefundProcessed((int) ($transaction['booking_id'] ?? 0), $storedRefund);

        Services::auditLogger()->log('payment.refunded', 'payment_transaction', (int) ($transaction['id'] ?? 0), 'Refund requested: ' . $refundReference, [
            'gateway' => (string) ($transaction['gateway'] ?? ''),
            'gateway_order_id' => (string) ($transaction['gateway_order_id'] ?? ''),
            'gateway_refund_id' => $result->gatewayRefundId,
            'refund_reference' => $refundReference,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $result->status,
            'booking_code' => (string) ($transaction['booking_code'] ?? ''),
            'otp_email' => $otpEmail,
            'otp_email_masked' => $this->maskEmail($otpEmail),
        ]);

        $flashType = $result->success ? 'success' : 'error';
        $message = $result->success
            ? 'Refund requested. Current refund status: ' . $result->status . '.'
            : $result->message;

        return redirect()->back()->with($flashType, $message);
    }

    private function baseTransactionQuery($db)
    {
        return $db->table('payment_transactions pt')
            ->select('pt.*, b.booking_code, ep.payment_code as event_payment_code, COALESCE(b.name, ep.customer_name) as guest_name, COALESCE(b.email, ep.customer_email) as guest_email, COALESCE(b.phone, ep.customer_phone) as guest_phone, COALESCE(b.room_type, ep.event_type) as room_type, COALESCE(b.checkin, ep.event_date) as checkin, b.checkout, b.payment_status as booking_payment_status, b.status as booking_status, ep.payment_status as event_payment_status')
            ->join('bookings b', 'b.id = pt.booking_id', 'left')
            ->join('event_payments ep', 'ep.id = pt.event_payment_id', 'left');
    }

    private function applyFilters($builder, array $filters): void
    {
        if ($filters['status'] !== 'all' && $filters['status'] !== '') {
            $builder->where('pt.status', $filters['status']);
        }

        if ($filters['gateway'] !== 'all' && $filters['gateway'] !== '') {
            $builder->where('pt.gateway', $filters['gateway']);
        }

        if ($filters['date_from'] !== '') {
            $builder->where('DATE(pt.created_at) >=', $filters['date_from']);
        }

        if ($filters['date_to'] !== '') {
            $builder->where('DATE(pt.created_at) <=', $filters['date_to']);
        }

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $builder->groupStart()
                ->like('b.booking_code', $q)
                ->orLike('ep.payment_code', $q)
                ->orLike('b.name', $q)
                ->orLike('ep.customer_name', $q)
                ->orLike('b.email', $q)
                ->orLike('ep.customer_email', $q)
                ->orLike('b.phone', $q)
                ->orLike('ep.customer_phone', $q)
                ->orLike('pt.gateway_order_id', $q)
                ->orLike('pt.gateway_payment_id', $q)
                ->groupEnd();
        }
    }

    private function statusCounts($db): array
    {
        $counts = [
            'all' => $db->table('payment_transactions')->countAllResults(),
            'checkout_ready' => 0,
            'pending' => 0,
            'paid' => 0,
            'failed' => 0,
            'cancelled' => 0,
        ];

        $rows = $db->table('payment_transactions')
            ->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $counts[(string) $row['status']] = (int) $row['total'];
        }

        return $counts;
    }

    private function gatewayOptions($db): array
    {
        return array_map(
            static fn (array $row): string => (string) $row['gateway'],
            $db->table('payment_transactions')
                ->select('gateway')
                ->where('gateway IS NOT NULL')
                ->groupBy('gateway')
                ->orderBy('gateway', 'ASC')
                ->get()
                ->getResultArray()
        );
    }

    private function latestRefundsForTransactions($db, array $transactionIds): array
    {
        $transactionIds = array_values(array_filter(array_map('intval', $transactionIds)));

        if ($transactionIds === [] || ! $db->tableExists('payment_refunds')) {
            return [];
        }

        $rows = $db->table('payment_refunds')
            ->whereIn('payment_transaction_id', $transactionIds)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
        $latest = [];

        foreach ($rows as $row) {
            $transactionId = (int) ($row['payment_transaction_id'] ?? 0);

            if ($transactionId > 0 && ! isset($latest[$transactionId])) {
                $latest[$transactionId] = $row;
            }
        }

        return $latest;
    }

    private function paymentStats($db): array
    {
        $paidAmount = (float) ($db->table('payment_transactions')
            ->selectSum('amount')
            ->where('status', 'paid')
            ->get()
            ->getRowArray()['amount'] ?? 0);
        $refundedAmount = 0.0;

        if ($db->tableExists('payment_refunds')) {
            $refundedAmount = (float) ($db->table('payment_refunds')
                ->selectSum('amount')
                ->whereIn('status', ['pending', 'processed'])
                ->get()
                ->getRowArray()['amount'] ?? 0);
        }

        return [
            'paid_amount' => $paidAmount,
            'refunded_amount' => $refundedAmount,
            'pending_count' => $db->table('payment_transactions')->whereIn('status', ['pending', 'checkout_ready'])->countAllResults(),
            'failed_count' => $db->table('payment_transactions')->where('status', 'failed')->countAllResults(),
        ];
    }

    private function refundAllowed(array $transaction, array $refunds): bool
    {
        if ((string) ($transaction['booking_status'] ?? '') !== 'cancelled') {
            return false;
        }

        if ((string) ($transaction['status'] ?? '') !== 'paid') {
            return false;
        }

        if (round((float) ($transaction['amount'] ?? 0), 2) <= 0) {
            return false;
        }

        foreach ($refunds as $refund) {
            if (in_array((string) ($refund['status'] ?? ''), ['pending', 'processed'], true)) {
                return false;
            }
        }

        return true;
    }

    private function refundBlockedMessage(array $transaction, array $refunds): string
    {
        if ((string) ($transaction['booking_status'] ?? '') === 'confirmed') {
            return 'Refund is not available for confirmed bookings. Cancel the booking first if a refund is required.';
        }

        if ((string) ($transaction['booking_status'] ?? '') !== 'cancelled') {
            return 'Refund is available only after the booking is cancelled.';
        }

        if ((string) ($transaction['status'] ?? '') !== 'paid') {
            return 'Only paid transactions can be refunded.';
        }

        foreach ($refunds as $refund) {
            if (in_array((string) ($refund['status'] ?? ''), ['pending', 'processed'], true)) {
                return 'A refund has already been requested for this payment.';
            }
        }

        return 'Refund is not available for this payment.';
    }

    private function notifyGuestIfRefundProcessed(int $bookingId, array $refund): void
    {
        if ($bookingId <= 0 || (string) ($refund['status'] ?? '') !== 'processed') {
            return;
        }

        $db = \Config\Database::connect();
        $booking = $db->table('bookings')->where('id', $bookingId)->get()->getRowArray();

        if (! $booking || empty($booking['email'])) {
            return;
        }

        if (! empty($refund['notified_at'])) {
            return;
        }

        if (! service('appMailer')->sendGuestRefundNotification($booking, $refund)) {
            log_message('warning', 'Refund notification email was not sent for refund {refund}.', ['refund' => $refund['refund_reference'] ?? $refund['id'] ?? '']);
            return;
        }

        $db->table('payment_refunds')->where('id', (int) ($refund['id'] ?? 0))->update([
            'notified_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    private function can(string $permission): bool
    {
        return Services::adminPermissions()->can($permission);
    }

    private function buildRefundReference(int $transactionId): string
    {
        return substr('HHPREF' . $transactionId . strtoupper(bin2hex(random_bytes(5))), 0, 40);
    }

    private function refundOtpSessionKey(int $transactionId): string
    {
        return 'refund_otp_' . $transactionId;
    }

    private function setRefundOtpSession(int $transactionId, string $adminEmail, string $allowedDomain, string $otp): void
    {
        session()->set($this->refundOtpSessionKey($transactionId), [
            'hash' => password_hash($otp, PASSWORD_DEFAULT),
            'admin_email' => $adminEmail,
            'allowed_domain' => $allowedDomain,
            'expires_at' => time() + 600,
            'attempts' => 0,
        ]);
    }

    private function refundOtpSession(int $transactionId): ?array
    {
        $value = session()->get($this->refundOtpSessionKey($transactionId));

        return is_array($value) ? $value : null;
    }

    private function refundOtpPending(int $transactionId): bool
    {
        $otpSession = $this->refundOtpSession($transactionId);

        return $otpSession !== null && time() <= (int) ($otpSession['expires_at'] ?? 0);
    }

    private function clearRefundOtpSession(int $transactionId): void
    {
        session()->remove($this->refundOtpSessionKey($transactionId));
    }

    private function maskEmail(string $email): string
    {
        if (! str_contains($email, '@')) {
            return $email;
        }

        [$name, $domain] = explode('@', $email, 2);
        $prefix = substr($name, 0, 2);

        return $prefix . str_repeat('*', max(2, strlen($name) - 2)) . '@' . $domain;
    }

    private function refundOtpAllowedDomain(): string
    {
        $hotelEmailDomain = $this->domainFromEmail((string) app_setting('hotel_email', ''));

        if ($hotelEmailDomain !== '') {
            return $hotelEmailDomain;
        }

        $host = parse_url(base_url(), PHP_URL_HOST);

        if (! is_string($host) || trim($host) === '') {
            return '';
        }

        return $this->normalizeDomain($host);
    }

    private function domainFromEmail(string $email): string
    {
        $email = trim(strtolower($email));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '';
        }

        return $this->normalizeDomain(substr(strrchr($email, '@') ?: '', 1));
    }

    private function normalizeDomain(string $domain): string
    {
        $domain = strtolower(trim($domain));
        $domain = preg_replace('/:\d+$/', '', $domain) ?? $domain;
        $domain = preg_replace('/^www\./', '', $domain) ?? $domain;

        return trim($domain, '.');
    }

    private function emailBelongsToDomain(string $email, string $allowedDomain): bool
    {
        $emailDomain = $this->domainFromEmail($email);
        $allowedDomain = $this->normalizeDomain($allowedDomain);

        if ($emailDomain === '' || $allowedDomain === '') {
            return false;
        }

        return $emailDomain === $allowedDomain || str_ends_with($emailDomain, '.' . $allowedDomain);
    }

    private function refundOtpRateIdentifier(int $transactionId, string $email): string
    {
        return hash('sha256', $transactionId . '|' . strtolower(trim($email)) . '|' . (string) $this->request->getIPAddress());
    }
}
