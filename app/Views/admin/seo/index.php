<div class="space-y-6">
  <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">SEO Manager</p>
      <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Page SEO</h1>
      <p class="mt-1 max-w-3xl text-sm text-slate-500 dark:text-slate-400">Manage tracked frontend routes, scan public pages, and keep SEO coverage organized as the site grows.</p>
    </div>
    <div class="flex flex-wrap gap-3">
      <a href="<?= base_url('admin/seo-manager') ?>#route-scanner" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Scan Routes
      </a>
      <a href="<?= base_url('admin/seo-manager/global') ?>" class="inline-flex items-center justify-center rounded-2xl bg-[#C99A30] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#d5ab4a]">
        Global SEO
      </a>
    </div>
  </div>

  <div class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5 dark:border-slate-800">
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Tracked Pages</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Open a tracked frontend route to manage its SEO, social preview, and advanced settings.</p>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
        <thead class="bg-slate-50/80 dark:bg-slate-800/40">
          <tr>
            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Page</th>
            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Status</th>
            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Strength</th>
            <th class="w-[260px] min-w-[260px] px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
          <?php foreach (($pages ?? []) as $item): ?>
            <?php
              $strengthClass = match (($item['strength']['tone'] ?? 'slate')) {
                'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300',
                'amber' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300',
                default => 'border-rose-200 bg-rose-50 text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300',
              };
            ?>
            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30">
              <td class="px-6 py-4">
                <div class="font-medium text-slate-900 dark:text-white"><?= esc($item['label']) ?></div>
                <div class="text-xs text-slate-400"><?= esc($item['url']) ?></div>
              </td>
              <td class="px-6 py-4">
                <div class="flex flex-wrap gap-2">
                  <?php foreach (($item['badges'] ?? []) as $badge): ?>
                    <?php
                      $badgeClass = match ($badge['tone'] ?? 'slate') {
                        'amber' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300',
                        'rose' => 'border-rose-200 bg-rose-50 text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300',
                        'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300',
                        default => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300',
                      };
                    ?>
                    <span class="inline-flex rounded-full border px-2.5 py-1 text-[11px] font-semibold <?= $badgeClass ?>"><?= esc($badge['label']) ?></span>
                  <?php endforeach; ?>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex rounded-full border px-2.5 py-1 text-[11px] font-semibold <?= $strengthClass ?>"><?= esc($item['strength']['label'] ?? 'Unknown') ?></span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex justify-end gap-2">
                  <a href="<?= base_url('admin/seo-manager/' . $item['key']) ?>" class="inline-flex items-center rounded-xl border border-[#C99A30]/30 px-4 py-2 text-sm font-medium text-[#C99A30] transition hover:bg-[#C99A30] hover:text-white">
                    Edit SEO
                  </a>
                  <form action="<?= base_url('admin/seo-manager/untrack/' . $item['key']) ?>" method="POST" onsubmit="return confirm('Remove <?= esc(addslashes($item['label'])) ?> from active SEO tracking?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="inline-flex items-center rounded-xl border border-rose-200 px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/30 dark:text-rose-300 dark:hover:bg-rose-500/10">
                      Untrack
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <section id="route-scanner" class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Route Scanner</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Only new or disabled frontend routes appear here so you can add them to SEO tracking when needed.</p>
      </div>
      <span class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-500 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300"><?= count($scanRows ?? []) ?> routes available</span>
    </div>

    <?php if (! empty($scanRows)): ?>
      <form action="<?= base_url('admin/seo-manager/sync-routes') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
            <thead class="bg-slate-50/80 dark:bg-slate-800/40">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Page</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Strength</th>
                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
              <?php foreach (($scanRows ?? []) as $row): ?>
                <?php
                  $strengthClass = match (($row['strength']['tone'] ?? 'slate')) {
                    'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300',
                    'amber' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300',
                    'rose' => 'border-rose-200 bg-rose-50 text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300',
                    default => 'border-slate-200 bg-slate-50 text-slate-600 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300',
                  };
                ?>
                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/30">
                  <td class="px-6 py-4">
                    <div class="font-medium text-slate-900 dark:text-white"><?= esc($row['route_label']) ?></div>
                    <div class="text-xs text-slate-400"><?= esc($row['route_path']) ?></div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] font-semibold text-slate-600 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300">
                      <?= ! empty($row['disabled']) ? 'Disabled' : 'Not Added' ?>
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <span class="inline-flex rounded-full border px-2.5 py-1 text-[11px] font-semibold <?= $strengthClass ?>"><?= esc($row['strength']['label'] ?? 'Unknown') ?></span>
                  </td>
                  <td class="w-[260px] min-w-[260px] px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-3">
                      <button type="button" data-route-toggle data-label-add="<?= esc(! empty($row['disabled']) ? 'Re-enable Route' : 'Add Route') ?>" data-label-remove="Remove Route" class="inline-flex w-[130px] min-w-[130px] max-w-[130px] items-center justify-center rounded-xl border border-[#C99A30]/30 px-3 py-2 text-xs font-medium text-[#C99A30] transition hover:bg-[#C99A30] hover:text-white">
                        <?= esc(! empty($row['disabled']) ? 'Re-enable Route' : 'Add Route') ?>
                      </button>
                      <input type="checkbox" name="routes[]" value="<?= esc($row['route_key']) ?>" data-route-checkbox <?= empty($row['disabled']) ? 'checked' : '' ?> class="h-5 w-5 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30] dark:border-slate-600 dark:bg-slate-800" />
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 px-6 py-5 dark:border-slate-800">
          <p class="text-sm text-slate-500 dark:text-slate-400">Tracked routes stay above. Only routes not currently managed appear here for quick adding or re-enabling.</p>
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">
            Sync Selected Routes
          </button>
        </div>
      </form>
    <?php else: ?>
      <div class="px-6 py-10 text-center">
        <p class="text-sm font-semibold text-slate-900 dark:text-white">All detected frontend routes are already tracked</p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Run a route scan again after adding new public pages or re-enable disabled routes when needed.</p>
      </div>
    <?php endif; ?>
  </section>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-route-toggle]').forEach(function (button) {
      const row = button.closest('tr');
      const checkbox = row ? row.querySelector('[data-route-checkbox]') : null;
      if (!checkbox) return;

      function syncRouteToggle() {
        const addLabel = button.dataset.labelAdd || 'Add Route';
        const removeLabel = button.dataset.labelRemove || 'Remove Route';
        button.textContent = checkbox.checked ? removeLabel : addLabel;
        button.classList.toggle('bg-[#C99A30]', checkbox.checked);
        button.classList.toggle('text-white', checkbox.checked);
        button.classList.toggle('border-[#C99A30]', checkbox.checked);
        button.classList.toggle('text-[#C99A30]', !checkbox.checked);
      }

      button.addEventListener('click', function () {
        checkbox.checked = !checkbox.checked;
        syncRouteToggle();
      });

      checkbox.addEventListener('change', syncRouteToggle);
      syncRouteToggle();
    });
  });
</script>
