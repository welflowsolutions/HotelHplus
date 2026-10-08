<div class="space-y-5">
  <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
      <div class="max-w-2xl">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Events Manager</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Manage public enquiries, offline events, advances, and event payment links in one place.</p>
      </div>

      <div class="flex flex-col gap-3 sm:items-start xl:items-end">
        <div class="flex w-full flex-wrap gap-2 sm:w-auto">
          <a href="<?= base_url('admin/events/create') ?>"
             class="inline-flex flex-1 items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition-shadow hover:shadow-lg sm:flex-none"
             style="background:linear-gradient(to right,#F59E0B,#FB923C)">
            Create Event
          </a>
          <a href="<?= base_url('admin/events/calendar') ?>"
             class="inline-flex flex-1 items-center justify-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 sm:flex-none">
            Calendar
          </a>
        </div>
        <div class="flex w-full flex-wrap gap-2 sm:w-auto">
          <a href="<?= base_url('admin/events/services') ?>"
             class="inline-flex flex-1 items-center justify-center rounded-lg bg-gray-100 px-3.5 py-2 text-xs font-semibold text-gray-600 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:flex-none">
            Services
          </a>
          <a href="<?= base_url('admin/events/packages') ?>"
             class="inline-flex flex-1 items-center justify-center rounded-lg bg-gray-100 px-3.5 py-2 text-xs font-semibold text-gray-600 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:flex-none">
            Packages
          </a>
          <a href="<?= base_url('admin/events/page') ?>"
             class="inline-flex flex-1 items-center justify-center rounded-lg bg-gray-100 px-3.5 py-2 text-xs font-semibold text-gray-600 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:flex-none">
            Gallery
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="grid gap-4 lg:grid-cols-3">
    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-900 dark:border-amber-900/30 dark:bg-amber-900/10 dark:text-amber-200">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-700/70 dark:text-amber-200/70">Inbox</p>
      <p class="mt-2 text-2xl font-semibold"><?= esc((string) ($counts['all'] ?? 0)) ?></p>
      <p class="mt-1 text-xs text-amber-800/80 dark:text-amber-100/70">Total public and offline event records.</p>
    </div>
    <div class="rounded-2xl border border-sky-200 bg-sky-50 px-4 py-4 text-sm text-sky-900 dark:border-sky-900/30 dark:bg-sky-900/10 dark:text-sky-200">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700/70 dark:text-sky-200/70">Services</p>
      <p class="mt-2 text-2xl font-semibold"><?= esc((string) ($serviceCount ?? 0)) ?></p>
      <p class="mt-1 text-xs text-sky-800/80 dark:text-sky-100/70">Active service cards available for the Events page.</p>
    </div>
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-900 dark:border-emerald-900/30 dark:bg-emerald-900/10 dark:text-emerald-200">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700/70 dark:text-emerald-200/70">Packages</p>
      <p class="mt-2 text-2xl font-semibold"><?= esc((string) ($packageCount ?? 0)) ?></p>
      <p class="mt-1 text-xs text-emerald-800/80 dark:text-emerald-100/70">Configurable event package options for the frontend.</p>
    </div>
  </div>

  <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-0 dark:border-gray-800">
    <?php
    $tabs = [
      'all' => 'All',
      'new' => 'New',
      'read' => 'Read',
      'replied' => 'Replied',
      'confirmed' => 'Confirmed',
      'cancelled' => 'Cancelled',
    ];
    foreach ($tabs as $key => $label):
      $isActive = ($status ?? 'all') === $key;
    ?>
      <a href="<?= base_url('admin/events?status=' . urlencode($key) . '&source=' . urlencode((string) ($source ?? 'all'))) ?>"
         class="border-b-2 px-4 py-2 text-sm font-medium -mb-px transition-colors <?= $isActive ? 'border-[#F59E0B] text-[#F59E0B]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' ?>">
        <?= esc($label) ?>
        <span class="ml-1 rounded-full px-1.5 py-0.5 text-[10px] <?= $isActive ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' ?>">
          <?= esc((string) ($counts[$key] ?? 0)) ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="flex flex-wrap gap-2">
    <?php foreach (['all' => 'All Sources', 'public' => 'Online', 'admin' => 'Offline'] as $sourceKey => $sourceLabel): ?>
      <?php $sourceActive = ($source ?? 'all') === $sourceKey; ?>
      <a href="<?= base_url('admin/events?status=' . urlencode((string) ($status ?? 'all')) . '&source=' . urlencode($sourceKey)) ?>"
         class="rounded-full px-3 py-1.5 text-xs font-medium transition <?= $sourceActive ? 'bg-[#F59E0B] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' ?>">
        <?= esc($sourceLabel) ?>
        <span class="ml-1 opacity-80"><?= esc((string) ($counts[$sourceKey] ?? $counts['all'] ?? 0)) ?></span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="border-b border-gray-100 p-4 dark:border-gray-800">
      <input type="text" id="searchInput" placeholder="Search by guest name, email, phone or event type..."
             class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:w-96" />
    </div>

    <?php if (! empty($enquiries)): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Guest</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 md:table-cell">Event Type</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 lg:table-cell">Event Date</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Guests</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:table-cell">Source</th>
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Submitted</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php foreach ($enquiries as $enquiry): ?>
              <tr class="border-b border-gray-50 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50 <?= ($enquiry['status'] ?? 'new') === 'new' ? 'font-semibold' : '' ?>">
                <td class="px-5 py-3.5">
                  <div class="font-medium text-gray-900 dark:text-white"><?= esc($enquiry['name'] ?? '—') ?></div>
                  <div class="mt-0.5 text-xs text-gray-400"><?= esc($enquiry['email'] ?: ($enquiry['phone'] ?? '')) ?></div>
                </td>
                <td class="hidden px-5 py-3.5 text-gray-600 dark:text-gray-300 md:table-cell"><?= esc($enquiry['event_type'] ?? '—') ?></td>
                <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 lg:table-cell">
                  <?= ! empty($enquiry['event_date']) ? esc(date('d M Y', strtotime($enquiry['event_date']))) : '—' ?>
                </td>
                <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 sm:table-cell"><?= esc((string) ($enquiry['guests'] ?? '—')) ?></td>
                <td class="hidden px-5 py-3.5 xl:table-cell">
                  <?php $sourceTone = ($enquiry['source'] ?? 'public') === 'admin' ? 'bg-violet-50 text-violet-700 dark:bg-violet-900/20 dark:text-violet-300' : 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-300'; ?>
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $sourceTone ?>">
                    <?= esc(($enquiry['source'] ?? 'public') === 'admin' ? 'Offline' : 'Online') ?>
                  </span>
                </td>
                <td class="px-5 py-3.5">
                  <?php
                    $statusTone = match ($enquiry['status'] ?? 'new') {
                      'read' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-400',
                      'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                      'confirmed' => 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400',
                      'cancelled' => 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400',
                      default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
                    };
                  ?>
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $statusTone ?>">
                    <?= esc($enquiry['status'] ?? 'new') ?>
                  </span>
                </td>
                <td class="hidden px-5 py-3.5 text-xs text-gray-400 sm:table-cell"><?= ! empty($enquiry['created_at']) ? esc(date('d M Y', strtotime($enquiry['created_at']))) : '—' ?></td>
                <td class="px-5 py-3.5 text-right">
                  <div class="flex justify-end gap-2">
                    <a href="<?= base_url('admin/events/' . $enquiry['id']) ?>"
                       class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">
                      View
                    </a>
                    <a href="<?= base_url('admin/events/' . $enquiry['id'] . '/edit') ?>"
                       class="inline-flex items-center gap-1 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                      Edit
                    </a>
                  </div>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 8l-7 5-7-5m14-2H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2z"/>
          </svg>
        </div>
        <p class="text-sm font-medium text-gray-900 dark:text-white">No event enquiries found yet</p>
        <p class="mt-1 text-sm text-gray-400">Once visitors submit the Events page form, their details will show up here.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => initSearch('searchInput', 'tableBody'));
</script>
