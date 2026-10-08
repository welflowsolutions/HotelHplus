<?php
$statusClass = static function (string $status): string {
    return match ($status) {
        'paid', 'processed' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
        'failed', 'cancelled', 'signature_failed', 'missing_secret', 'invalid_json' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400',
        'pending', 'checkout_ready', 'created' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
        default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    };
};

$redactPayload = static function (mixed $value) use (&$redactPayload): mixed {
    if (! is_array($value)) {
        return $value;
    }

    $sensitiveKeys = ['email', 'contact', 'phone', 'mobile', 'customer_email', 'customer_phone'];
    $redacted = [];

    foreach ($value as $key => $item) {
        $keyText = strtolower((string) $key);

        if (in_array($keyText, $sensitiveKeys, true)) {
            $redacted[$key] = '*** masked ***';
            continue;
        }

        $redacted[$key] = $redactPayload($item);
    }

    return $redacted;
};

$prettyJson = static function (?string $json) use ($redactPayload): string {
    if ($json === null || trim($json) === '') {
        return '';
    }

    $decoded = json_decode($json, true);

    if (! is_array($decoded)) {
        return $json;
    }

    return json_encode($redactPayload($decoded), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: $json;
};

$detail = static function (string $label, ?string $value): void {
    ?>
    <div>
      <p class="mb-0.5 text-xs text-gray-400"><?= esc($label) ?></p>
      <p class="break-words text-sm font-medium text-gray-900 dark:text-white"><?= esc($value !== null && $value !== '' ? $value : '—') ?></p>
    </div>
    <?php
};

$latestRefund = $refunds[0] ?? null;
$isEventPayment = ($transaction['payment_for'] ?? 'booking') === 'event';
?>

<div class="max-w-5xl space-y-5">
  <div class="flex flex-wrap items-center gap-3">
    <a href="<?= base_url('admin/payments') ?>"
       class="flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Payment #<?= esc((string) $transaction['id']) ?></h1>
      <p class="mt-0.5 text-xs text-gray-400"><?= ! empty($transaction['created_at']) ? esc(date('d M Y, h:i A', strtotime((string) $transaction['created_at']))) : '—' ?></p>
    </div>
    <span class="ml-auto rounded-full px-3 py-1 text-xs font-medium <?= $statusClass((string) ($transaction['status'] ?? '')) ?>">
      <?= esc(ucwords(str_replace('_', ' ', (string) ($transaction['status'] ?? 'created')))) ?>
    </span>
  </div>

  <div class="grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Transaction Details</h2>
      <div class="grid gap-4 sm:grid-cols-2">
        <?php $detail('Gateway', ucfirst((string) ($transaction['gateway'] ?? ''))); ?>
        <?php if (! empty($transaction['payment_method'])): ?>
          <?php $detail('Method', ucwords(str_replace('_', ' ', (string) $transaction['payment_method']))); ?>
        <?php endif; ?>
        <?php $detail('Amount', (string) ($transaction['currency'] ?? 'INR') . ' ' . number_format((float) ($transaction['amount'] ?? 0), 2)); ?>
        <?php $detail('Gateway Order ID', $transaction['gateway_order_id'] ?? null); ?>
        <?php $detail('Gateway Payment ID', $transaction['gateway_payment_id'] ?? null); ?>
        <?php if (! empty($transaction['payment_reference'])): ?>
          <?php $detail('Payment Reference', $transaction['payment_reference']); ?>
        <?php endif; ?>
        <?php $detail('Session Token', ! empty($transaction['session_token']) ? 'Stored' : null); ?>
        <?php $detail('Verified At', ! empty($transaction['verified_at']) ? date('d M Y, h:i A', strtotime((string) $transaction['verified_at'])) : null); ?>
        <?php $detail('Paid At', ! empty($transaction['paid_at']) ? date('d M Y, h:i A', strtotime((string) $transaction['paid_at'])) : null); ?>
        <?php $detail('Last Updated', ! empty($transaction['updated_at']) ? date('d M Y, h:i A', strtotime((string) $transaction['updated_at'])) : null); ?>
      </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><?= $isEventPayment ? 'Event Payment' : 'Booking' ?></h2>
      <div class="space-y-4">
        <?php $detail($isEventPayment ? 'Payment Code' : 'Booking Code', $transaction['booking_code'] ?? $transaction['event_payment_code'] ?? null); ?>
        <?php $detail('Guest', $transaction['guest_name'] ?? null); ?>
        <?php $detail('Contact', $transaction['guest_email'] ?: ($transaction['guest_phone'] ?? null)); ?>
        <?php $detail($isEventPayment ? 'Event Type' : 'Room', $transaction['room_type'] ?? null); ?>
      </div>
      <div class="mt-5 flex flex-wrap gap-2">
        <?php if (! empty($transaction['booking_id'])): ?>
          <a href="<?= base_url('admin/bookings/' . $transaction['booking_id']) ?>"
             class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">View Booking</a>
        <?php endif; ?>
        <?php if (($transaction['status'] ?? '') === 'paid' && ! empty($transaction['booking_code'])): ?>
          <a href="<?= base_url('booking/receipt/' . $transaction['booking_code']) ?>" target="_blank" rel="noopener"
             class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">Receipt</a>
        <?php endif; ?>
        <?php if (($transaction['status'] ?? '') === 'paid' && $isEventPayment && ! empty($transaction['event_payment_code'])): ?>
          <a href="<?= base_url('event-payment/receipt/' . $transaction['event_payment_code']) ?>" target="_blank" rel="noopener"
             class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">Receipt</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</h2>
    <div class="flex flex-wrap gap-3">
      <form action="<?= base_url('admin/payments/' . $transaction['id'] . '/recheck') ?>"
            method="POST"
            data-confirm-action-form
            data-confirm-title="Recheck payment?"
            data-confirm-message="This will contact <?= esc(ucfirst((string) ($transaction['gateway'] ?? 'the gateway'))) ?> and update the transaction status if the gateway returns a newer result."
            data-confirm-button="Recheck">
        <?= csrf_field() ?>
        <button type="submit"
                class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
                style="background:linear-gradient(to right,#F59E0B,#FB923C)">Recheck Payment</button>
      </form>

      <?php if ($canRefund && ! $isEventPayment): ?>
        <?php if ($refundAllowed): ?>
          <?php if ($refundOtpPending): ?>
            <form action="<?= base_url('admin/payments/' . $transaction['id'] . '/refund/verify') ?>"
                  method="POST"
                  class="flex w-full flex-col gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/60 dark:bg-emerald-900/15 sm:max-w-xl">
              <?= csrf_field() ?>
              <div>
                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Refund OTP sent</p>
                <p class="mt-1 text-sm text-emerald-700/80 dark:text-emerald-300/80">Enter the 6-digit OTP sent to <?= esc($refundOtpEmail ?: 'admin email') ?>. The gateway refund starts only after verification.</p>
              </div>
              <div class="flex flex-col gap-2 sm:flex-row">
                <input name="refund_otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" required
                       class="w-full rounded-xl border border-emerald-200 bg-white px-4 py-2.5 text-sm font-semibold tracking-[0.35em] text-gray-900 outline-none transition focus:ring-2 focus:ring-emerald-400 dark:border-emerald-900/60 dark:bg-gray-950 dark:text-white sm:w-48"
                       placeholder="000000">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                  Verify & Refund
                </button>
              </div>
            </form>
            <form action="<?= base_url('admin/payments/' . $transaction['id'] . '/refund') ?>"
                  method="POST"
                  data-confirm-action-form
                  data-confirm-title="Send new refund OTP?"
                  data-confirm-message="A fresh OTP will be sent to <?= esc($refundOtpEmail ?: 'the admin email') ?>. The previous OTP will be replaced."
                  data-confirm-button="Send OTP">
              <?= csrf_field() ?>
              <button type="submit"
                      class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-950/40 dark:text-gray-300 dark:hover:bg-gray-800">
                Resend OTP
              </button>
            </form>
          <?php else: ?>
            <form action="<?= base_url('admin/payments/' . $transaction['id'] . '/refund') ?>"
                  method="POST"
                  data-confirm-action-form
                  data-confirm-title="Send refund OTP?"
                  data-confirm-message="This booking is cancelled. A 6-digit OTP will be sent to the admin email before requesting a full refund of <?= esc((string) ($transaction['currency'] ?? 'INR')) ?> <?= esc(number_format((float) ($transaction['amount'] ?? 0), 2)) ?> from <?= esc(ucfirst((string) ($transaction['gateway'] ?? 'the gateway'))) ?>."
                  data-confirm-button="Send OTP">
              <?= csrf_field() ?>
              <button type="submit"
                      class="inline-flex items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-2.5 text-sm font-medium text-emerald-700 transition-colors hover:bg-emerald-100 dark:border-emerald-900/60 dark:bg-emerald-900/20 dark:text-emerald-300 dark:hover:bg-emerald-900/35">
                Send Refund OTP
              </button>
            </form>
          <?php endif; ?>
        <?php else: ?>
        <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-600 dark:border-gray-800 dark:bg-gray-950/40 dark:text-gray-400">
          Refund available only when the booking is cancelled and payment is paid.
          <?php if (($transaction['booking_status'] ?? '') === 'confirmed'): ?>
            Confirmed bookings cannot be refunded.
          <?php endif; ?>
        </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="border-b border-gray-100 p-5 dark:border-gray-800">
      <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Refunds</h2>
    </div>
    <?php if ($refunds === []): ?>
      <div class="p-8 text-sm text-gray-500 dark:text-gray-400">
        No refund has been requested for this transaction.
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-sm dark:divide-gray-800">
          <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:bg-gray-950/40 dark:text-gray-400">
            <tr>
              <th class="px-4 py-3">Reference</th>
              <th class="px-4 py-3">Amount</th>
              <th class="px-4 py-3">Gateway Refund</th>
              <th class="px-4 py-3">OTP Email</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3"></th>
              <th class="px-4 py-3">Requested</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            <?php foreach ($refunds as $refund): ?>
              <tr>
                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?= esc($refund['refund_reference'] ?? '—') ?></td>
                <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                  <?= esc((string) ($refund['currency'] ?? 'INR')) ?> <?= esc(number_format((float) ($refund['amount'] ?? 0), 2)) ?>
                </td>
                <td class="px-4 py-3 text-gray-500 dark:text-gray-400"><?= esc($refund['gateway_refund_id'] ?? '—') ?></td>
                <td class="px-4 py-3 text-gray-500 dark:text-gray-400"><?= esc(! empty($refund['otp_email']) ? $refund['otp_email'] : '—') ?></td>
                <td class="px-4 py-3">
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $statusClass((string) ($refund['status'] ?? '')) ?>">
                    <?= esc(ucfirst((string) ($refund['status'] ?? 'pending'))) ?>
                  </span>
                </td>
                <td class="px-4 py-3">
                  <?php if (in_array((string) ($refund['status'] ?? ''), ['pending', 'failed'], true)): ?>
                    <form action="<?= base_url('admin/payments/refunds/' . $refund['id'] . '/recheck') ?>" method="POST">
                      <?= csrf_field() ?>
                      <button type="submit" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300">Recheck</button>
                    </form>
                  <?php endif; ?>
                </td>
                <td class="whitespace-nowrap px-4 py-3 text-gray-500 dark:text-gray-400">
                  <?= ! empty($refund['created_at']) ? esc(date('d M Y, h:i A', strtotime((string) $refund['created_at']))) : '—' ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($canRefund): ?>
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="border-b border-gray-100 p-5 dark:border-gray-800">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Webhook Logs</h2>
      </div>
      <?php if ($webhookLogs === []): ?>
        <div class="p-10 text-center">
          <p class="font-medium text-gray-900 dark:text-white">No webhook callbacks recorded</p>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Future gateway callbacks for this order will appear here.</p>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-100 text-sm dark:divide-gray-800">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:bg-gray-950/40 dark:text-gray-400">
              <tr>
                <th class="px-4 py-3">Time</th>
                <th class="px-4 py-3">Event</th>
                <th class="px-4 py-3">Signature</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Message</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              <?php foreach ($webhookLogs as $log): ?>
                <tr class="align-top">
                  <td class="whitespace-nowrap px-4 py-3 text-gray-500 dark:text-gray-400">
                    <?= ! empty($log['created_at']) ? esc(date('d M Y, h:i A', strtotime((string) $log['created_at']))) : '—' ?>
                  </td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                    <p class="font-medium"><?= esc($log['event_type'] ?: 'Webhook') ?></p>
                    <?php if (! empty($log['gateway_event_id'])): ?>
                      <p class="mt-1 text-xs text-gray-400"><?= esc($log['gateway_event_id']) ?></p>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-3">
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= ! empty($log['signature_valid']) ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400' ?>">
                      <?= ! empty($log['signature_valid']) ? 'Verified' : 'Failed' ?>
                    </span>
                  </td>
                  <td class="px-4 py-3">
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $statusClass((string) ($log['process_status'] ?? '')) ?>">
                      <?= esc(ucwords(str_replace('_', ' ', (string) ($log['process_status'] ?? '')))) ?>
                    </span>
                  </td>
                  <td class="px-4 py-3 text-gray-600 dark:text-gray-300"><?= esc($log['error_message'] ?? '—') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <details class="group rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5">
        <div>
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Technical Gateway Data</h2>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Collapsed by default. Use this only for gateway support or debugging.</p>
        </div>
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500 transition group-open:rotate-180 dark:bg-gray-800 dark:text-gray-300">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </span>
      </summary>
      <div class="border-t border-gray-100 p-5 dark:border-gray-800">
        <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-900/50 dark:bg-amber-900/15 dark:text-amber-300">
          Personal contact fields are masked here. Full data remains stored for system processing.
        </div>
        <div class="grid gap-5 lg:grid-cols-3">
          <?php foreach (['request_payload' => 'Request Payload', 'response_payload' => 'Gateway Response', 'verified_payload' => 'Verified Payload'] as $field => $label): ?>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-[#0B111C]">
              <div class="border-b border-gray-100 p-4 dark:border-gray-800">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><?= esc($label) ?></h3>
              </div>
              <pre class="max-h-96 overflow-auto whitespace-pre-wrap break-words p-4 text-xs leading-relaxed text-gray-700 dark:text-gray-300"><?= esc($prettyJson($transaction[$field] ?? null) ?: 'No payload stored.') ?></pre>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </details>
  <?php endif; ?>
</div>
