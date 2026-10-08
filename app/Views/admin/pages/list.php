<?php
$pagesList = $pagesList ?? [];
?>

<div class="space-y-6">
  <div>
    <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">Pages</p>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Website Pages</h1>
    <p class="mt-1 max-w-2xl text-sm text-slate-500 dark:text-slate-400">
      Choose a page and open its dedicated editor to update frontend copy and image slots.
    </p>
  </div>

  <div class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="border-b border-slate-100 px-6 py-5 dark:border-slate-800">
      <h2 class="text-lg font-bold text-slate-900 dark:text-white">Page List</h2>
      <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Each page opens in a full editor view.</p>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
        <thead class="bg-slate-50/70 dark:bg-slate-800/40">
          <tr>
            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Page</th>
            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">What It Controls</th>
            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Last Updated</th>
            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <?php foreach ($pagesList as $pageItem): ?>
            <tr class="transition hover:bg-slate-50/70 dark:hover:bg-slate-800/30">
              <td class="px-6 py-5">
                <p class="text-sm font-semibold text-slate-900 dark:text-white"><?= esc($pageItem['title']) ?></p>
              </td>
              <td class="px-6 py-5">
                <p class="max-w-xl text-sm text-slate-500 dark:text-slate-400"><?= esc($pageItem['description']) ?></p>
              </td>
              <td class="px-6 py-5">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                  <?= ! empty($pageItem['updatedAt']) ? esc(date('d M Y, h:i A', strtotime((string) $pageItem['updatedAt']))) : 'Not updated yet' ?>
                </p>
              </td>
              <td class="px-6 py-5 text-right">
                <a href="<?= esc($pageItem['editUrl']) ?>" class="inline-flex items-center rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
                  Edit Page
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
