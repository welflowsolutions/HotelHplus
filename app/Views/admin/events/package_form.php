<?php
$isEdit = isset($package['id']);
?>

<div class="space-y-5">
  <div class="flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <a href="<?= base_url('admin/events/packages') ?>"
         class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </a>
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?= $isEdit ? 'Edit Event Package' : 'Add Event Package' ?></h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Packages help guests compare event scales, inclusions, and pricing direction before they enquire.</p>
      </div>
    </div>
  </div>

  <form action="<?= $isEdit ? base_url('admin/events/packages/update/' . $package['id']) : base_url('admin/events/packages/store') ?>" method="POST"
        class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
    <?= csrf_field() ?>

    <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
      <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 .895-4 2s1.79 2 4 2 4 .895 4 2-1.79 2-4 2m0-10V6m0 12v-2"/>
        </svg>
      </div>
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Package Details</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Use one feature per line so the frontend package cards stay structured and easy to scan.</p>
      </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
      <div>
        <label for="title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Package Title</label>
        <input id="title" name="title" type="text" value="<?= esc(old('title', $package['title'] ?? '')) ?>"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div>
        <label for="subtitle" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subtitle</label>
        <input id="subtitle" name="subtitle" type="text" value="<?= esc(old('subtitle', $package['subtitle'] ?? '')) ?>"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div>
        <label for="guest_range" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Guest Range</label>
        <input id="guest_range" name="guest_range" type="text" value="<?= esc(old('guest_range', $package['guest_range'] ?? '')) ?>"
               placeholder="120 to 300 guests"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div>
        <label for="price_label" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Price Label</label>
        <input id="price_label" name="price_label" type="text" value="<?= esc(old('price_label', $package['price_label'] ?? '')) ?>"
               placeholder="From Rs. 95,000"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div class="sm:col-span-2">
        <label for="description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc(old('description', $package['description'] ?? '')) ?></textarea>
      </div>

      <div class="sm:col-span-2">
        <label for="features" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Package Features</label>
        <textarea id="features" name="features" rows="7"
                  class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc(old('features', is_array($package['features'] ?? null) ? implode("\n", $package['features']) : ($package['features'] ?? ''))) ?></textarea>
        <p class="mt-2 text-xs text-slate-400">One feature per line.</p>
      </div>

      <div>
        <label for="badge_text" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Badge Text</label>
        <input id="badge_text" name="badge_text" type="text" value="<?= esc(old('badge_text', $package['badge_text'] ?? '')) ?>"
               placeholder="Most Popular"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div>
        <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" value="<?= esc(old('sort_order', $package['sort_order'] ?? '0')) ?>"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div>
        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Featured Style</label>
        <label class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
          <input type="checkbox" name="is_featured" value="1" <?= old('is_featured', isset($package['is_featured']) ? (string) $package['is_featured'] : '0') ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
          Highlight this package on the frontend
        </label>
      </div>

      <div>
        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
        <label class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
          <input type="checkbox" name="is_active" value="1" <?= old('is_active', isset($package['is_active']) ? (string) $package['is_active'] : '1') ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
          Show this package on the frontend Events page
        </label>
      </div>
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
      <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
        <?= $isEdit ? 'Update Package' : 'Save Package' ?>
      </button>
      <a href="<?= base_url('admin/events/packages') ?>"
         class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Cancel
      </a>
    </div>
  </form>
</div>
