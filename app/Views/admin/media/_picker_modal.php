<?php
$modalId = $modalId ?? 'mediaPickerModal';
$searchId = $searchId ?? 'mediaPickerSearch';
$emptyId = $emptyId ?? 'mediaPickerSearchEmpty';
$files = $files ?? [];
$title = $title ?? 'Choose Image';
$description = $description ?? 'Select an image from the media library.';
$showUploadPanel = $showUploadPanel ?? false;
$uploadToggleId = $uploadToggleId ?? ($modalId . 'UploadToggle');
$uploadToggleLabelId = $uploadToggleLabelId ?? ($modalId . 'UploadToggleLabel');
$uploadToggleIconId = $uploadToggleIconId ?? ($modalId . 'UploadToggleIcon');
$uploadPanelId = $uploadPanelId ?? ($modalId . 'UploadPanel');
$uploadInputId = $uploadInputId ?? ($modalId . 'UploadInput');
$uploadActiveTab = $uploadActiveTab ?? '';
?>

<div id="<?= esc($modalId) ?>" class="fixed inset-0 z-[1000] hidden items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm">
  <div class="flex min-h-[540px] max-h-[95vh] w-[90vw] max-w-none flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-800">
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white"><?= esc($title) ?></h2>
        <p class="text-sm text-slate-500 dark:text-slate-400"><?= esc($description) ?></p>
      </div>
      <div class="flex items-center gap-3">
        <?php if ($showUploadPanel): ?>
          <button type="button" id="<?= esc($uploadToggleId) ?>" class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-[#C99A30] hover:text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200" aria-expanded="false">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#0D1117] text-white dark:bg-[#C99A30] dark:text-slate-950">
              <svg id="<?= esc($uploadToggleIconId) ?>" class="h-4 w-4 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
              </svg>
            </span>
            <span id="<?= esc($uploadToggleLabelId) ?>">Open Upload</span>
          </button>
        <?php endif; ?>
        <a href="<?= base_url('admin/media') ?>" target="_blank" rel="noopener" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
          Open Media Library
        </a>
        <button type="button" data-close-media-picker class="rounded-xl border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <div class="overflow-y-auto p-6">
      <?php if ($showUploadPanel): ?>
        <div
          id="<?= esc($uploadPanelId) ?>"
          class="overflow-hidden transition-all duration-300 ease-out"
          style="max-height: 0; opacity: 0; transform: translateY(-12px); pointer-events: none;"
        >
          <form action="<?= base_url('admin/media/upload') ?>" method="POST" enctype="multipart/form-data" class="mb-6 space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60">
            <?= csrf_field() ?>
            <?php if ($uploadActiveTab !== ''): ?>
              <input type="hidden" name="active_settings_tab" value="<?= esc($uploadActiveTab) ?>" />
            <?php endif; ?>
            <label for="<?= esc($uploadInputId) ?>" data-drop-zone class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-white px-6 py-8 text-center transition hover:border-[#C99A30] hover:bg-[#C99A30]/5 dark:border-slate-700 dark:bg-slate-900/70 dark:hover:border-[#C99A30]">
              <input id="<?= esc($uploadInputId) ?>" name="media_files[]" type="file" accept=".jpg,.jpeg,.png,.gif,.webp,.avif,.ico,image/*" class="sr-only" data-file-input multiple />
              <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#0D1117] text-white dark:bg-[#C99A30] dark:text-slate-950">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 0-4 4m4-4 4 4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                </svg>
              </span>
              <span class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">Browse or drop image here</span>
              <span class="mt-1 text-xs text-slate-500 dark:text-slate-400">JPG, PNG, GIF, WebP, AVIF, or ICO up to 5 MB each</span>
              <span data-file-name class="mt-3 text-xs font-medium text-[#C99A30]"></span>
            </label>
            <div class="flex flex-col gap-2 border-t border-slate-200 pt-4 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between">
              <p class="text-xs text-slate-500 dark:text-slate-400">Upload here, then select the image below.</p>
              <p data-upload-status class="text-xs font-semibold text-[#C99A30]">Upload starts automatically after browse or drop.</p>
            </div>
          </form>
        </div>
      <?php endif; ?>

      <div class="mb-4 flex flex-col gap-3 border-b border-slate-200/80 pb-3 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
        <label class="relative block w-full md:max-w-md">
          <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
            </svg>
          </span>
          <input type="search" id="<?= esc($searchId) ?>" placeholder="Search filename or path" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-[#C99A30] focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900" />
        </label>
        <div class="text-sm text-slate-500 dark:text-slate-400">
          <span data-media-picker-count><?= count($files) ?></span> items
        </div>
      </div>

      <div data-media-picker-grid class="<?= empty($files) ? 'hidden ' : '' ?>grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach ($files as $file): ?>
          <button type="button" data-select-media-path="<?= esc($file['path']) ?>" data-media-picker-card data-media-name="<?= esc(strtolower($file['original_name'])) ?>" data-media-path="<?= esc(strtolower($file['path'])) ?>" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white text-left transition hover:-translate-y-0.5 hover:border-[#C99A30] hover:shadow-lg dark:border-slate-700 dark:bg-slate-900">
            <span class="flex aspect-[4/3] items-center justify-center bg-slate-100 dark:bg-slate-800">
              <img src="<?= esc(media_url($file['path'])) ?>" alt="<?= esc($file['alt_text'] ?: $file['original_name']) ?>" class="h-full w-full object-contain p-4" />
            </span>
            <span class="block p-3">
              <span class="block truncate text-sm font-semibold text-slate-900 dark:text-white"><?= esc($file['original_name']) ?></span>
              <span class="mt-1 block truncate text-xs text-slate-400"><?= esc($file['path']) ?></span>
            </span>
          </button>
        <?php endforeach; ?>
      </div>

      <div data-media-picker-empty class="<?= ! empty($files) ? 'hidden ' : '' ?>rounded-2xl border border-slate-200 bg-slate-50 p-10 text-center dark:border-slate-700 dark:bg-slate-800/40">
        <p class="text-sm font-semibold text-slate-900 dark:text-white">No media uploaded yet</p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Upload an image in the Media Library and it will appear here.</p>
      </div>

      <div id="<?= esc($emptyId) ?>" class="hidden rounded-2xl border border-slate-200 bg-slate-50 p-10 text-center dark:border-slate-700 dark:bg-slate-800/40">
        <p class="text-sm font-semibold text-slate-900 dark:text-white">No matching media found</p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try another filename or path.</p>
      </div>
    </div>
  </div>
</div>
