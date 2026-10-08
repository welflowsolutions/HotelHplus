<?php
$isEdit = isset($event['id']);
?>

<div class="space-y-5">
  <div class="flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <a href="<?= base_url('admin/trident/events') ?>"
         class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </a>
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?= $isEdit ? 'Edit Trident Event' : 'Add Trident Event' ?></h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">These cards appear in the frontend “Events We Host” section and their titles also feed the enquiry form event-type list.</p>
      </div>
    </div>
  </div>

  <form action="<?= $isEdit ? base_url('admin/trident/events/update/' . $event['id']) : base_url('admin/trident/events/store') ?>" method="POST"
        class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
    <?= csrf_field() ?>

    <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
      <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4M7 4h10l2 5-7 8-7-8 2-5Zm0 0 5 13 5-13"/>
        </svg>
      </div>
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Event Details</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Keep this short and strong so the frontend event cards stay clean.</p>
      </div>
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
      <div class="sm:col-span-2">
        <label for="title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Event Title</label>
        <input id="title" name="title" type="text" value="<?= esc(old('title', $event['title'] ?? '')) ?>"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div class="sm:col-span-2">
        <label for="description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc(old('description', $event['description'] ?? '')) ?></textarea>
      </div>

      <div>
        <label for="icon_class" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Font Awesome Icon Class</label>
        <input id="icon_class" name="icon_class" type="text" value="<?= esc(old('icon_class', $event['icon_class'] ?? 'fa-calendar-days')) ?>"
               placeholder="fa-heart"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        <p class="mt-2 text-xs text-slate-400">Examples: <code>fa-heart</code>, <code>fa-briefcase</code>, <code>fa-cake-candles</code>, <code>fa-trophy</code>.</p>
      </div>

      <div>
        <label for="sort_order" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" value="<?= esc(old('sort_order', $event['sort_order'] ?? '0')) ?>"
               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>

      <div class="sm:col-span-2">
        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
        <label class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
          <input type="checkbox" name="is_active" value="1" <?= old('is_active', isset($event['is_active']) ? (string) $event['is_active'] : '1') ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
          Show this event on the frontend Trident page
        </label>
      </div>
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
      <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
        <?= $isEdit ? 'Update Event' : 'Save Event' ?>
      </button>
      <a href="<?= base_url('admin/trident/events') ?>"
         class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Cancel
      </a>
    </div>
  </form>
</div>
