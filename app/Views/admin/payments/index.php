<?php
$statusTabs = [
    'all' => 'All',
    'checkout_ready' => 'Ready',
    'pending' => 'Pending',
    'paid' => 'Paid',
    'failed' => 'Failed',
    'cancelled' => 'Cancelled',
];

$statusClass = static function (string $status): string {
    return match ($status) {
        'paid' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
        'failed', 'cancelled' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400',
        'pending', 'checkout_ready', 'created' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
        default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    };
};

$buildUrl = static function (array $overrides = []) use ($filters): string {
    $query = array_merge($filters, $overrides);
    $query = array_filter($query, static fn ($value): bool => $value !== '' && $value !== 'all');

    return base_url('admin/payments') . ($query !== [] ? '?' . http_build_query($query) : '');
};
?>

<div class="space-y-5">
  <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payment Manager</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Gateway transactions from Cashfree and Razorpay.</p>
    </div>
    <?php if (! empty($canExport)): ?>
      <a href="<?= esc(base_url('admin/payments/export') . '?' . http_build_query(array_filter($filters, static fn ($value): bool => $value !== '' && $value !== 'all'))) ?>"
         class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
        Export CSV
      </a>
    <?php endif; ?>
  </div>

  <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
    <?php foreach (['all' => 'Total', 'paid' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed', 'cancelled' => 'Cancelled'] as $key => $label): ?>
      <a href="<?= esc($buildUrl(['status' => $key])) ?>"
         class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition-colors hover:border-[#F59E0B]/40 dark:border-gray-800 dark:bg-gray-900">
        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400"><?= esc($label) ?></p>
        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white"><?= esc((string) ($counts[$key] ?? 0)) ?></p>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Paid Amount</p>
      <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">INR <?= esc(number_format((float) ($stats['paid_amount'] ?? 0), 2)) ?></p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Refunded / Pending Refund</p>
      <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">INR <?= esc(number_format((float) ($stats['refunded_amount'] ?? 0), 2)) ?></p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Pending Payments</p>
      <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white"><?= esc((string) ($stats['pending_count'] ?? 0)) ?></p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Failed Payments</p>
      <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white"><?= esc((string) ($stats['failed_count'] ?? 0)) ?></p>
    </div>
  </div>

  <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-0 dark:border-gray-800">
    <?php foreach ($statusTabs as $key => $label): ?>
      <?php $isActive = ($filters['status'] ?? 'all') === $key; ?>
      <a href="<?= esc($buildUrl(['status' => $key])) ?>"
         class="-mb-px border-b-2 px-4 py-2 text-sm font-medium transition-colors <?= $isActive ? 'border-[#F59E0B] text-[#F59E0B]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' ?>">
        <?= esc($label) ?>
        <span class="ml-1 rounded-full px-1.5 py-0.5 text-[10px] <?= $isActive ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' ?>">
          <?= esc((string) ($counts[$key] ?? 0)) ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <form method="GET" action="<?= base_url('admin/payments') ?>" class="grid gap-3 border-b border-gray-100 p-4 dark:border-gray-800 md:grid-cols-[1.4fr_0.8fr_0.8fr_0.8fr_auto]">
      <input type="hidden" name="status" value="<?= esc($filters['status'] ?? 'all') ?>">
      <input type="text" name="q" value="<?= esc($filters['q'] ?? '') ?>" placeholder="Search booking/event, guest, phone, order id..."
             class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
      <select name="gateway"
              class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        <option value="all">All gateways</option>
        <?php foreach ($gateways as $gateway): ?>
          <option value="<?= esc($gateway) ?>" <?= ($filters['gateway'] ?? 'all') === $gateway ? 'selected' : '' ?>><?= esc(ucfirst($gateway)) ?></option>
        <?php endforeach; ?>
      </select>
      <input type="date" name="date_from" value="<?= esc($filters['date_from'] ?? '') ?>"
             class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
      <input type="date" name="date_to" value="<?= esc($filters['date_to'] ?? '') ?>"
             class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
      <div class="flex gap-2">
        <button type="submit"
                class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
                style="background:linear-gradient(to right,#F59E0B,#FB923C)">Filter</button>
        <a href="<?= base_url('admin/payments') ?>"
           class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Reset</a>
      </div>
    </form>

    <?php if (! empty($transactions)): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Transaction</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 md:table-cell">Guest</th>
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Amount</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Gateway</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:table-cell">Refund</th>
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 lg:table-cell">Created</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
            <?php foreach ($transactions as $transaction): ?>
              <tr class="align-top transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-5 py-3.5">
                  <div class="font-medium text-gray-900 dark:text-white"><?= esc($transaction['gateway_order_id'] ?? '—') ?></div>
                  <?php $isEventPayment = ($transaction['payment_for'] ?? 'booking') === 'event'; ?>
                  <div class="mt-0.5 text-xs text-gray-400">
                    <?= $isEventPayment ? 'Event ' : 'Booking ' ?><?= esc($transaction['booking_code'] ?? $transaction['event_payment_code'] ?? ('#' . ($transaction['booking_id'] ?? '—'))) ?>
                  </div>
                  <?php if (! empty($transaction['gateway_payment_id'])): ?>
                    <div class="mt-0.5 text-xs text-gray-400"><?= esc($transaction['gateway_payment_id']) ?></div>
                  <?php endif; ?>
                </td>
                <td class="hidden px-5 py-3.5 md:table-cell">
                  <div class="font-medium text-gray-900 dark:text-white"><?= esc($transaction['guest_name'] ?? '—') ?></div>
                  <div class="mt-0.5 text-xs text-gray-400"><?= esc($transaction['guest_email'] ?: ($transaction['guest_phone'] ?? '')) ?></div>
                </td>
                <td class="px-5 py-3.5 font-medium text-gray-900 dark:text-white">
                  <?= esc((string) ($transaction['currency'] ?? 'INR')) ?> <?= esc(number_format((float) ($transaction['amount'] ?? 0), 2)) ?>
                </td>
                <td class="hidden px-5 py-3.5 sm:table-cell">
                  <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <?= esc(ucfirst((string) ($transaction['gateway'] ?? '—'))) ?>
                  </span>
                  <?php if (! empty($transaction['payment_method'])): ?>
                    <div class="mt-1 text-xs text-gray-400"><?= esc(ucwords(str_replace('_', ' ', (string) $transaction['payment_method']))) ?></div>
                  <?php endif; ?>
                </td>
                <td class="hidden px-5 py-3.5 xl:table-cell">
                  <?php $latestRefund = $latestRefunds[(int) ($transaction['id'] ?? 0)] ?? null; ?>
                  <?php if ($latestRefund): ?>
                    <div class="font-medium text-gray-700 dark:text-gray-200"><?= esc($latestRefund['refund_reference'] ?? '—') ?></div>
                    <div class="mt-0.5 text-xs text-gray-400"><?= esc(ucfirst((string) ($latestRefund['status'] ?? 'pending'))) ?></div>
                  <?php else: ?>
                    <span class="text-xs text-gray-400">—</span>
                  <?php endif; ?>
                </td>
                <td class="px-5 py-3.5">
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $statusClass((string) ($transaction['status'] ?? '')) ?>">
                    <?= esc(ucwords(str_replace('_', ' ', (string) ($transaction['status'] ?? 'created')))) ?>
                  </span>
                </td>
                <td class="hidden px-5 py-3.5 text-xs text-gray-400 lg:table-cell">
                  <?= ! empty($transaction['created_at']) ? esc(date('d M Y, h:i A', strtotime((string) $transaction['created_at']))) : '—' ?>
                </td>
                <td class="px-5 py-3.5 text-right">
                  <a href="<?= base_url('admin/payments/' . $transaction['id']) ?>"
                     class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">
                    View
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="py-16 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">
          <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm2 8h4m6 0h.01"/>
          </svg>
        </div>
        <p class="text-sm font-medium text-gray-900 dark:text-white">No payment transactions found</p>
        <p class="mt-1 text-sm text-gray-400">Gateway attempts will appear after a guest reaches checkout.</p>
      </div>
    <?php endif; ?>
  </div>
</div>
