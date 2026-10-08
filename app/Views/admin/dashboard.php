<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$adminName = session()->get('admin_name') ?: 'Admin';
$roleLabel = ucfirst((string) ($role ?? session()->get('admin_usertype') ?? 'staff'));

$money = static fn (float $amount, string $currency = 'INR'): string => $currency . ' ' . number_format($amount, 2);
$dateLabel = static function (?string $date): string {
    if ($date === null || trim($date) === '') {
        return 'Not set';
    }

    return date('d M Y', strtotime($date));
};
$timeLabel = static function (?string $date): string {
    if ($date === null || trim($date) === '') {
        return 'Not set';
    }

    return date('d M, h:i A', strtotime($date));
};
$statusClass = static function (string $status): string {
    return match ($status) {
        'paid', 'confirmed', 'read', 'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300',
        'failed', 'cancelled' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-300',
        'pending', 'new', 'checkout_ready', 'created' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-300',
        default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    };
};

$statCards = [
    [
        'label' => 'Pending Bookings',
        'value' => (int) ($bookingCounts['pending'] ?? 0),
        'hint' => ((int) ($bookingCounts['today'] ?? 0)) . ' created today',
        'url' => base_url('admin/bookings?status=pending'),
        'tone' => 'amber',
        'icon' => 'M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z',
    ],
    [
        'label' => 'New Enquiries',
        'value' => (int) ($enquiryCounts['new'] ?? 0),
        'hint' => ((int) ($enquiryCounts['today'] ?? 0)) . ' arrived today',
        'url' => base_url('admin/enquiries?status=new'),
        'tone' => 'sky',
        'icon' => 'M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z',
    ],
    [
        'label' => 'Paid Revenue',
        'value' => $money((float) ($paymentStats['paidAmount'] ?? 0)),
        'hint' => $money((float) ($paymentStats['todayPaidAmount'] ?? 0)) . ' today',
        'url' => base_url('admin/payments?status=paid'),
        'tone' => 'emerald',
        'icon' => 'M3 8h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm2 8h4m6 0h.01',
    ],
];

if (! empty($can['roomsManage'])) {
    $statCards[] = [
        'label' => 'Rooms Open',
        'value' => (int) ($roomCounts['bookingOpen'] ?? 0) . ' / ' . (int) ($roomCounts['total'] ?? 0),
        'hint' => ((int) ($roomCounts['active'] ?? 0)) . ' active rooms',
        'url' => base_url('admin/rooms'),
        'tone' => 'violet',
        'icon' => 'M3 20v-8m0 4h18m0 4v-8M5 12V6a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v6m0 0V8a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v4',
    ];
}

$quickActions = [
    ['label' => 'Review Bookings', 'url' => base_url('admin/bookings'), 'show' => true],
    ['label' => 'Check Payments', 'url' => base_url('admin/payments'), 'show' => ! empty($can['paymentsView'])],
    ['label' => 'Add Room', 'url' => base_url('admin/rooms/create'), 'show' => ! empty($can['roomsManage'])],
    ['label' => 'Open Media', 'url' => base_url('admin/media'), 'show' => ! empty($can['mediaManage'])],
    ['label' => 'Settings', 'url' => base_url('admin/settings'), 'show' => ! empty($can['settingsManage'])],
    ['label' => 'Users', 'url' => base_url('admin/users'), 'show' => ! empty($can['usersManage'])],
];
?>

<div class="space-y-6">
  <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="flex min-w-0 flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
      <div class="min-w-0">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#C99A30]"><?= esc($roleLabel) ?> Dashboard</p>
        <h1 class="mt-2 max-w-full break-words text-2xl font-bold leading-tight text-gray-900 dark:text-white">Welcome back, <?= esc($adminName) ?></h1>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
          Live operational snapshot for <?= esc($hotelName) ?>.
        </p>
      </div>
      <div class="grid w-full min-w-0 grid-cols-3 gap-3 rounded-xl border border-gray-100 bg-gray-50 p-3 text-center dark:border-gray-800 dark:bg-gray-950/40 lg:w-auto">
        <div class="px-3">
          <p class="text-xs text-gray-400">Confirmed</p>
          <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white"><?= esc((string) ($bookingCounts['confirmed'] ?? 0)) ?></p>
        </div>
        <div class="border-x border-gray-200 px-3 dark:border-gray-800">
          <p class="text-xs text-gray-400">Upcoming</p>
          <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white"><?= esc((string) ($bookingCounts['upcoming'] ?? 0)) ?></p>
        </div>
        <div class="px-3">
          <p class="text-xs text-gray-400">Paid</p>
          <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white"><?= esc((string) ($paymentStats['paid'] ?? 0)) ?></p>
        </div>
      </div>
    </div>
  </section>

  <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <?php foreach ($statCards as $card): ?>
      <?php
        $tone = $card['tone'];
        $toneClass = match ($tone) {
            'sky' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-300',
            'emerald' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-300',
            'violet' => 'bg-violet-50 text-violet-700 dark:bg-violet-900/20 dark:text-violet-300',
            default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-300',
        };
      ?>
      <a href="<?= esc($card['url']) ?>" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
        <div class="flex items-start justify-between gap-4">
          <span class="flex h-11 w-11 items-center justify-center rounded-xl <?= $toneClass ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="<?= esc($card['icon']) ?>"/>
            </svg>
          </span>
          <span class="text-xs font-medium text-gray-400 transition group-hover:text-gray-600 dark:group-hover:text-gray-300">Open</span>
        </div>
        <p class="mt-5 text-sm font-medium text-gray-500 dark:text-gray-400"><?= esc($card['label']) ?></p>
        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= esc((string) $card['value']) ?></p>
        <p class="mt-2 text-xs text-gray-400"><?= esc($card['hint']) ?></p>
      </a>
    <?php endforeach; ?>
  </section>

  <section class="grid gap-5 xl:grid-cols-[1.25fr_0.75fr]">
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="flex items-center justify-between border-b border-gray-100 p-5 dark:border-gray-800">
        <div>
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Recent Bookings</h2>
          <p class="mt-1 text-xs text-gray-400">Latest reservation requests and status.</p>
        </div>
        <a href="<?= base_url('admin/bookings') ?>" class="text-sm font-medium text-[#C99A30]">View all</a>
      </div>
      <?php if ($recentBookings === []): ?>
        <div class="p-10 text-center text-sm text-gray-500 dark:text-gray-400">No bookings yet.</div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-100 text-sm dark:divide-gray-800">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:bg-gray-950/40 dark:text-gray-400">
              <tr>
                <th class="px-5 py-3">Guest</th>
                <th class="px-5 py-3">Stay</th>
                <th class="px-5 py-3">Room</th>
                <th class="px-5 py-3">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              <?php foreach ($recentBookings as $booking): ?>
                <tr>
                  <td class="px-5 py-4">
                    <p class="font-medium text-gray-900 dark:text-white"><?= esc($booking['name'] ?? 'Guest') ?></p>
                    <p class="mt-0.5 text-xs text-gray-400"><?= esc($booking['booking_code'] ?? $booking['email'] ?? '') ?></p>
                  </td>
                  <td class="whitespace-nowrap px-5 py-4 text-gray-600 dark:text-gray-300">
                    <?= esc($dateLabel($booking['checkin'] ?? null)) ?>
                  </td>
                  <td class="px-5 py-4 text-gray-600 dark:text-gray-300"><?= esc($booking['room_type'] ?? '-') ?></td>
                  <td class="px-5 py-4">
                    <span class="rounded-full px-2.5 py-1 text-xs font-medium <?= $statusClass((string) ($booking['status'] ?? 'pending')) ?>">
                      <?= esc(ucfirst((string) ($booking['status'] ?? 'pending'))) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <div class="space-y-5">
      <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Today</h2>
        <div class="mt-4 grid grid-cols-2 gap-3">
          <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-950/40">
            <p class="text-xs text-gray-400">Bookings</p>
            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= esc((string) ($bookingCounts['today'] ?? 0)) ?></p>
          </div>
          <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-950/40">
            <p class="text-xs text-gray-400">Paid Amount</p>
            <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white"><?= esc($money((float) ($paymentStats['todayPaidAmount'] ?? 0))) ?></p>
          </div>
          <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-950/40">
            <p class="text-xs text-gray-400">Contact Leads</p>
            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= esc((string) ($enquiryCounts['today'] ?? 0)) ?></p>
          </div>
          <?php if (! empty($can['eventsManage']) || ! empty($can['tridentManage'])): ?>
            <div class="rounded-xl bg-gray-50 p-4 dark:bg-gray-950/40">
              <p class="text-xs text-gray-400">Event Leads</p>
              <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= esc((string) (($eventCounts['today'] ?? 0) + ($eventCounts['tridentToday'] ?? 0))) ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Quick Actions</h2>
        <div class="mt-4 grid gap-2">
          <?php foreach ($quickActions as $action): ?>
            <?php if (empty($action['show'])) continue; ?>
            <a href="<?= esc($action['url']) ?>" class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:border-[#C99A30]/60 hover:bg-[#C99A30]/5 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-[#C99A30]/10">
              <span><?= esc($action['label']) ?></span>
              <span class="text-[#C99A30]">&rarr;</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="grid gap-5 xl:grid-cols-3">
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="flex items-center justify-between border-b border-gray-100 p-5 dark:border-gray-800">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Recent Enquiries</h2>
        <a href="<?= base_url('admin/enquiries') ?>" class="text-sm font-medium text-[#C99A30]">View all</a>
      </div>
      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        <?php if ($recentEnquiries === []): ?>
          <div class="p-8 text-sm text-gray-500 dark:text-gray-400">No enquiries yet.</div>
        <?php else: ?>
          <?php foreach ($recentEnquiries as $enquiry): ?>
            <div class="p-5">
              <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                  <p class="truncate text-sm font-medium text-gray-900 dark:text-white"><?= esc(trim(($enquiry['first_name'] ?? '') . ' ' . ($enquiry['last_name'] ?? '')) ?: 'Guest') ?></p>
                  <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400"><?= esc($enquiry['subject'] ?? 'Enquiry') ?></p>
                </div>
                <span class="rounded-full px-2 py-0.5 text-xs font-medium <?= $statusClass((string) ($enquiry['status'] ?? 'new')) ?>">
                  <?= esc($enquiry['status'] ?? 'new') ?>
                </span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="border-b border-gray-100 p-5 dark:border-gray-800">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Upcoming Stays</h2>
      </div>
      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        <?php if ($upcomingBookings === []): ?>
          <div class="p-8 text-sm text-gray-500 dark:text-gray-400">No upcoming stays.</div>
        <?php else: ?>
          <?php foreach ($upcomingBookings as $booking): ?>
            <div class="flex items-center justify-between gap-3 p-5">
              <div class="min-w-0">
                <p class="truncate text-sm font-medium text-gray-900 dark:text-white"><?= esc($booking['name'] ?? 'Guest') ?></p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"><?= esc($booking['room_type'] ?? '-') ?></p>
              </div>
              <p class="whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-gray-200"><?= esc($dateLabel($booking['checkin'] ?? null)) ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <?php if (! empty($can['paymentsView'])): ?>
      <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="flex items-center justify-between border-b border-gray-100 p-5 dark:border-gray-800">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Recent Payments</h2>
          <a href="<?= base_url('admin/payments') ?>" class="text-sm font-medium text-[#C99A30]">View all</a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
          <?php if ($recentPayments === []): ?>
            <div class="p-8 text-sm text-gray-500 dark:text-gray-400">No payment records yet.</div>
          <?php else: ?>
            <?php foreach ($recentPayments as $payment): ?>
              <a href="<?= base_url('admin/payments/' . $payment['id']) ?>" class="block p-5 transition hover:bg-gray-50 dark:hover:bg-gray-950/40">
                <div class="flex items-start justify-between gap-3">
                  <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-gray-900 dark:text-white"><?= esc($payment['name'] ?? $payment['booking_code'] ?? 'Payment #' . $payment['id']) ?></p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"><?= esc(ucfirst((string) ($payment['gateway'] ?? 'gateway'))) ?> · <?= esc($timeLabel($payment['paid_at'] ?? $payment['created_at'] ?? null)) ?></p>
                  </div>
                  <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= esc($money((float) ($payment['amount'] ?? 0), (string) ($payment['currency'] ?? 'INR'))) ?></p>
                    <span class="mt-1 inline-block rounded-full px-2 py-0.5 text-xs font-medium <?= $statusClass((string) ($payment['status'] ?? 'created')) ?>">
                      <?= esc(str_replace('_', ' ', (string) ($payment['status'] ?? 'created'))) ?>
                    </span>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>
