<?php $monthLabel = date('F Y', strtotime($month . '-01')); ?>

<div class="space-y-5">
  <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Event Calendar</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">All public enquiries and admin-created offline events by preferred event date.</p>
    </div>
    <div class="flex flex-wrap gap-2">
      <a href="<?= base_url('admin/events/create') ?>" class="rounded-xl bg-[#F59E0B] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#d88a06]">Create Event</a>
      <a href="<?= base_url('admin/events') ?>" class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">List View</a>
    </div>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 p-4 dark:border-gray-800">
      <a href="<?= base_url('admin/events/calendar?month=' . $prevMonth) ?>" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Previous</a>
      <h2 class="text-lg font-bold text-gray-900 dark:text-white"><?= esc($monthLabel) ?></h2>
      <a href="<?= base_url('admin/events/calendar?month=' . $nextMonth) ?>" class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Next</a>
    </div>

    <div class="grid gap-px bg-gray-100 p-px dark:bg-gray-800 sm:grid-cols-2 lg:grid-cols-7">
      <?php foreach ($calendarDays as $day): ?>
        <div class="min-h-36 bg-white p-3 dark:bg-gray-900">
          <div class="mb-3 flex items-center justify-between">
            <span class="text-sm font-bold text-gray-900 dark:text-white"><?= esc((string) $day['day']) ?></span>
            <div class="flex items-center gap-1.5">
              <?php if ((int) ($day['confirmed_count'] ?? 0) > 1): ?>
                <span class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-semibold text-red-700 dark:bg-red-900/25 dark:text-red-300">
                  <?= esc((string) $day['confirmed_count']) ?> confirmed
                </span>
              <?php endif; ?>
              <span class="text-[10px] uppercase tracking-wide text-gray-400"><?= esc(date('D', strtotime($day['date']))) ?></span>
            </div>
          </div>
          <div class="space-y-2">
            <?php foreach (array_slice($day['events'], 0, 4) as $event): ?>
              <?php
                $tone = match ($event['status'] ?? 'new') {
                  'confirmed' => 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-900/40 dark:bg-emerald-900/15 dark:text-emerald-300',
                  'cancelled' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-900/40 dark:bg-red-900/15 dark:text-red-300',
                  'read' => 'border-sky-200 bg-sky-50 text-sky-800 dark:border-sky-900/40 dark:bg-sky-900/15 dark:text-sky-300',
                  'replied' => 'border-violet-200 bg-violet-50 text-violet-800 dark:border-violet-900/40 dark:bg-violet-900/15 dark:text-violet-300',
                  default => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900/40 dark:bg-amber-900/15 dark:text-amber-300',
                };
                $sourceLabel = ($event['source'] ?? 'public') === 'admin' ? 'Offline' : 'Online';
              ?>
              <a href="<?= base_url('admin/events/' . $event['id']) ?>" class="block rounded-lg border px-2.5 py-2 text-xs <?= $tone ?>">
                <span class="block truncate font-semibold"><?= esc($event['event_type'] ?? 'Event') ?></span>
                <span class="mt-0.5 block truncate opacity-80"><?= esc($event['name'] ?? 'Guest') ?></span>
                <span class="mt-1 block text-[10px] font-semibold uppercase tracking-wide opacity-70"><?= esc($sourceLabel) ?> · <?= esc((string) ($event['status'] ?? 'new')) ?></span>
              </a>
            <?php endforeach; ?>
            <?php if (count($day['events']) > 4): ?>
              <p class="text-xs text-gray-400">+<?= esc((string) (count($day['events']) - 4)) ?> more</p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
