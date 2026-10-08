<div class="space-y-5">

  <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Trident Enquiries</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Guest submissions from the frontend Trident enquiry form.</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="<?= base_url('admin/settings?tab=tridentpage') ?>"
         class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        Trident Page Settings
      </a>
      <a href="<?= base_url('admin/trident/events') ?>"
         class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
         style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4M7 4h10l2 5-7 8-7-8 2-5Zm0 0 5 13 5-13"/></svg>
        Manage Event List
      </a>
    </div>
  </div>

  <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-900/30 dark:bg-amber-900/10 dark:text-amber-200">
    Frontend event cards come from the admin event list. Right now <?= esc((string) ($eventCount ?? 0)) ?> event<?= ($eventCount ?? 0) !== 1 ? 's are' : ' is' ?> configured there.
  </div>

  <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-0 dark:border-gray-800">
    <?php
    $tabs = [
      'all' => 'All',
      'new' => 'New',
      'read' => 'Read',
      'replied' => 'Replied',
    ];
    foreach ($tabs as $key => $label):
      $isActive = $status === $key;
    ?>
      <a href="?status=<?= $key ?>"
         class="border-b-2 px-4 py-2 text-sm font-medium -mb-px transition-colors <?= $isActive ? 'border-[#F59E0B] text-[#F59E0B]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' ?>">
        <?= esc($label) ?>
        <span class="ml-1 rounded-full px-1.5 py-0.5 text-[10px] <?= $isActive ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' ?>">
          <?= esc((string) ($counts[$key] ?? 0)) ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="border-b border-gray-100 p-4 dark:border-gray-800">
      <input type="text" id="searchInput" placeholder="Search by name, phone, email or event type…"
             class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:w-80" />
    </div>

    <?php if (! empty($enquiries)): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Guest</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 md:table-cell">Event</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 lg:table-cell">Event Date</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Guests</th>
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Date</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php foreach ($enquiries as $enq): ?>
              <tr class="border-b border-gray-50 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50 <?= ($enq['status'] ?? 'new') === 'new' ? 'font-semibold' : '' ?>">
                <td class="px-5 py-3.5">
                  <div class="font-medium text-gray-900 dark:text-white"><?= esc($enq['name'] ?? '—') ?></div>
                  <div class="mt-0.5 text-xs text-gray-400"><?= esc($enq['email'] ?: ($enq['phone'] ?? '')) ?></div>
                </td>
                <td class="hidden px-5 py-3.5 text-gray-600 dark:text-gray-300 md:table-cell"><?= esc($enq['event_type'] ?? '—') ?></td>
                <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 lg:table-cell">
                  <?= ! empty($enq['event_date']) ? esc(date('d M Y', strtotime($enq['event_date']))) : '—' ?>
                </td>
                <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 sm:table-cell"><?= esc((string) ($enq['guests'] ?? '—')) ?></td>
                <td class="px-5 py-3.5">
                  <?php
                    $statusTone = match ($enq['status'] ?? 'new') {
                      'read' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-400',
                      'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                      default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
                    };
                  ?>
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $statusTone ?>">
                    <?= esc($enq['status'] ?? 'new') ?>
                  </span>
                </td>
                <td class="hidden px-5 py-3.5 text-xs text-gray-400 sm:table-cell"><?= ! empty($enq['created_at']) ? esc(date('d M Y', strtotime($enq['created_at']))) : '—' ?></td>
                <td class="px-5 py-3.5 text-right">
                  <a href="<?= base_url('admin/trident/' . $enq['id']) ?>"
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4M7 4h10l2 5-7 8-7-8 2-5Zm0 0 5 13 5-13M5 9h14"/>
          </svg>
        </div>
        <p class="text-sm font-medium text-gray-900 dark:text-white">No Trident event enquiries found</p>
        <p class="mt-1 text-sm text-gray-400">Banquet and event enquiries from the website will appear here.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => initSearch('searchInput', 'tableBody'));
</script>
