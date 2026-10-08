<div class="space-y-6">
  <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Subscribers</h1>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Names and email addresses collected from the website subscribe form.</p>
    </div>
  </div>

  <div class="grid gap-4 md:grid-cols-3">
    <div class="rounded-2xl border border-amber-200/60 bg-amber-50 p-5 dark:border-amber-900/40 dark:bg-amber-900/10">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-700 dark:text-amber-300">Total</p>
      <p class="mt-3 text-3xl font-semibold text-amber-900 dark:text-amber-100"><?= esc((string) ($counts['total'] ?? 0)) ?></p>
      <p class="mt-2 text-sm text-amber-700/80 dark:text-amber-200/70">All subscriber records saved so far.</p>
    </div>
    <div class="rounded-2xl border border-emerald-200/60 bg-emerald-50 p-5 dark:border-emerald-900/40 dark:bg-emerald-900/10">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-700 dark:text-emerald-300">Active</p>
      <p class="mt-3 text-3xl font-semibold text-emerald-900 dark:text-emerald-100"><?= esc((string) ($counts['active'] ?? 0)) ?></p>
      <p class="mt-2 text-sm text-emerald-700/80 dark:text-emerald-200/70">Currently active email subscribers.</p>
    </div>
    <div class="rounded-2xl border border-sky-200/60 bg-sky-50 p-5 dark:border-sky-900/40 dark:bg-sky-900/10">
      <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-700 dark:text-sky-300">Today</p>
      <p class="mt-3 text-3xl font-semibold text-sky-900 dark:text-sky-100"><?= esc((string) ($counts['today'] ?? 0)) ?></p>
      <p class="mt-2 text-sm text-sky-700/80 dark:text-sky-200/70">New subscriptions received today.</p>
    </div>
  </div>

  <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="border-b border-gray-100 p-4 dark:border-gray-800">
      <input type="text" id="searchInput" placeholder="Search by full name or email..."
             class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:w-80" />
    </div>

    <?php if (! empty($subscribers)): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Subscriber</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 md:table-cell">Status</th>
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Subscribed</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php foreach ($subscribers as $subscriber): ?>
              <tr class="border-b border-gray-50 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50">
                <td class="px-5 py-4">
                  <div class="font-medium text-gray-900 dark:text-white"><?= esc($subscriber['full_name'] ?? '—') ?></div>
                  <div class="mt-0.5 text-xs text-gray-400"><?= esc($subscriber['email'] ?? '') ?></div>
                </td>
                <td class="hidden px-5 py-4 md:table-cell">
                  <?php $isActive = ($subscriber['status'] ?? 'active') === 'active'; ?>
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $isActive ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' ?>">
                    <?= esc($subscriber['status'] ?? 'active') ?>
                  </span>
                </td>
                <td class="px-5 py-4 text-sm text-gray-500 dark:text-gray-400">
                  <?= ! empty($subscriber['subscribed_at']) ? esc(date('d M Y, h:i A', strtotime($subscriber['subscribed_at']))) : '—' ?>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/>
          </svg>
        </div>
        <p class="text-sm font-medium text-gray-900 dark:text-white">No subscribers yet</p>
        <p class="mt-1 text-sm text-gray-400">New subscriber names and emails will appear here after website signups.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => initSearch('searchInput', 'tableBody'));
</script>
