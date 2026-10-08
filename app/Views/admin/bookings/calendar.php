<?php $monthLabel = date('F Y', strtotime($month . '-01')); ?>

<div class="space-y-5">
  <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Booking Calendar</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Month-wise stay occupancy from pending and confirmed bookings.</p>
    </div>
    <div class="flex flex-wrap gap-2">
      <a href="<?= base_url('admin/bookings/create') ?>" class="rounded-xl bg-[#F59E0B] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#d88a06]">Manual Booking</a>
      <a href="<?= base_url('admin/bookings') ?>" class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">List View</a>
    </div>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 p-4 dark:border-gray-800">
      <a href="<?= base_url('admin/bookings/calendar?month=' . $prevMonth) ?>" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Previous</a>
      <h2 class="text-lg font-bold text-gray-900 dark:text-white"><?= esc($monthLabel) ?></h2>
      <a href="<?= base_url('admin/bookings/calendar?month=' . $nextMonth) ?>" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Next</a>
    </div>

    <div class="grid gap-px bg-gray-100 p-px dark:bg-gray-800 sm:grid-cols-2 lg:grid-cols-7">
      <?php foreach ($calendarDays as $day): ?>
        <div class="min-h-36 bg-white p-3 dark:bg-gray-900">
          <div class="mb-3 flex items-center justify-between">
            <span class="text-sm font-bold text-gray-900 dark:text-white"><?= esc((string) $day['day']) ?></span>
            <span class="text-[10px] uppercase tracking-wide text-gray-400"><?= esc(date('D', strtotime($day['date']))) ?></span>
          </div>
          <div class="space-y-2">
            <?php foreach (array_slice($day['bookings'], 0, 4) as $booking): ?>
              <?php $tone = ($booking['status'] ?? '') === 'confirmed' ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-900/40 dark:bg-emerald-900/15 dark:text-emerald-300' : 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900/40 dark:bg-amber-900/15 dark:text-amber-300'; ?>
              <a href="<?= base_url('admin/bookings/' . $booking['id']) ?>" class="block rounded-lg border px-2.5 py-2 text-xs <?= $tone ?>">
                <span class="block truncate font-semibold"><?= esc($booking['room_type'] ?? 'Room') ?></span>
                <span class="mt-0.5 block truncate opacity-80"><?= esc($booking['name'] ?? 'Guest') ?></span>
                <span class="mt-1 block text-[10px] font-semibold opacity-70"><?= esc($booking['occupancy_label'] ?? '') ?></span>
              </a>
            <?php endforeach; ?>
            <?php if (count($day['bookings']) > 4): ?>
              <p class="text-xs text-gray-400">+<?= esc((string) (count($day['bookings']) - 4)) ?> more</p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
