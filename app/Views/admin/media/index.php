<div class="space-y-6">
  <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">Media</p>
      <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Media Library</h1>
      <p class="mt-1 max-w-2xl text-sm text-slate-500 dark:text-slate-400">Upload reusable images for logos, favicons, SEO images, and admin selections.</p>
    </div>
    <button
      type="button"
      data-panel-toggle
      data-panel-target="mediaUploadPanel"
      data-open-label="Open Upload"
      data-close-label="Close Upload"
      aria-expanded="false"
      class="inline-flex items-center justify-center gap-2 self-start rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-[#C99A30] hover:text-[#C99A30] dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-[#C99A30] dark:hover:text-[#E2B44A] sm:self-auto"
    >
      <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#C99A30] text-slate-950 shadow-[0_8px_24px_rgba(201,154,48,.22)]">
        <svg data-panel-toggle-icon class="h-4 w-4 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
      </span>
      <span data-panel-toggle-label>Open Upload</span>
    </button>
  </div>

  <div
    id="mediaUploadPanel"
    data-collapsible-panel
    aria-hidden="true"
    class="overflow-hidden transition-all duration-300 ease-out"
    style="max-height: 0; opacity: 0; transform: translateY(-12px); pointer-events: none;"
  >
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <form action="<?= base_url('admin/media/upload') ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?>
        <label for="media_file" data-drop-zone class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center transition hover:border-[#C99A30] hover:bg-[#C99A30]/5 dark:border-slate-700 dark:bg-slate-800/70 dark:hover:border-[#C99A30]">
          <input id="media_file" name="media_files[]" type="file" accept=".jpg,.jpeg,.png,.gif,.webp,.avif,.ico,image/*" class="sr-only" data-file-input multiple />
          <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#0D1117] text-white dark:bg-[#C99A30] dark:text-slate-950">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m0 0-4 4m4-4 4 4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
            </svg>
          </span>
          <span class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">Browse or drop image here</span>
          <span class="mt-1 text-xs text-slate-500 dark:text-slate-400">JPG, PNG, GIF, WebP, AVIF, or ICO up to 5 MB each</span>
          <span data-file-name class="mt-3 text-xs font-medium text-[#C99A30]"></span>
        </label>
        <div class="flex flex-col gap-2 border-t border-slate-100 pt-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
          <p class="text-xs text-slate-500 dark:text-slate-400">Images are stored in <span class="font-semibold text-slate-700 dark:text-slate-300">public/uploads/media</span>.</p>
          <p data-upload-status class="text-xs font-semibold text-[#C99A30]">Upload starts automatically after browse or drop.</p>
        </div>
      </form>
    </section>
  </div>

  <section class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-3 border-b border-slate-200/80 p-4 dark:border-slate-800 md:flex-row md:items-center md:justify-between">
      <label class="relative block w-full md:max-w-md">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
          </svg>
        </span>
        <input type="search" data-media-search placeholder="Search filename, path, or alt text" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-[#C99A30] focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900" />
      </label>
      <div class="text-sm text-slate-500 dark:text-slate-400">
        <span data-media-search-count><?= count($files) ?></span> items
      </div>
    </div>

    <div class="p-4 sm:p-5">
      <section data-media-grid class="<?= empty($files) ? 'hidden ' : '' ?>grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <?php foreach ($files as $file): ?>
          <article
            data-media-card
            data-media-id="<?= (int) $file['id'] ?>"
            data-media-url="<?= esc($file['url']) ?>"
            data-media-name="<?= esc($file['original_name']) ?>"
            data-media-path="<?= esc($file['path']) ?>"
            data-media-alt="<?= esc($file['alt_text']) ?>"
            data-media-width="<?= esc((string) ($file['width'] ?? '')) ?>"
            data-media-height="<?= esc((string) ($file['height'] ?? '')) ?>"
            data-media-mime="<?= esc((string) ($file['mime_type'] ?? '')) ?>"
            data-media-webp-enabled="<?= ! empty($file['webp_enabled']) ? '1' : '0' ?>"
            data-media-webp-convertible="<?= ! empty($file['webp_convertible']) ? '1' : '0' ?>"
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-slate-800 dark:bg-slate-900"
          >
            <button type="button" data-open-media-editor class="flex w-full aspect-[4/3] items-center justify-center bg-slate-100 text-left dark:bg-slate-800">
              <img src="<?= esc($file['url']) ?>" alt="<?= esc($file['alt_text'] ?: $file['original_name']) ?>" class="h-full w-full object-contain p-4" />
            </button>
            <div class="space-y-3 p-4">
              <div>
                <button type="button" data-open-media-editor class="block w-full truncate text-left text-sm font-semibold text-slate-900 transition hover:text-[#C99A30] dark:text-white dark:hover:text-[#E2B44A]"><?= esc($file['original_name']) ?></button>
                <p class="mt-1 truncate text-xs text-slate-400"><?= esc($file['path']) ?></p>
                <p data-media-alt-preview class="<?= $file['alt_text'] === '' ? 'hidden ' : '' ?>mt-2 line-clamp-2 text-xs text-slate-500 dark:text-slate-400"><?= esc($file['alt_text']) ?></p>
              </div>
              <div class="flex flex-wrap items-center gap-2">
                <button type="button" data-open-media-editor class="rounded-xl border border-[#C99A30]/40 bg-[#C99A30]/10 px-3 py-2 text-xs font-semibold text-[#C99A30] transition hover:bg-[#C99A30] hover:text-slate-950">Edit</button>
                <button type="button" data-copy-media-path="<?= esc($file['path']) ?>" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Copy Path</button>
                <?php if (service('adminPermissions')->canDeleteData()): ?>
                  <form action="<?= base_url('admin/media/delete/' . $file['id']) ?>" method="POST" data-confirm-delete-form data-confirm-delete-ajax="true" data-delete-label="<?= esc($file['original_name']) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="rounded-xl border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/60 dark:text-red-300 dark:hover:bg-red-950/30">Delete</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </section>

      <section data-media-empty-state class="<?= ! empty($files) ? 'hidden ' : '' ?>rounded-2xl border border-slate-200 bg-white p-10 text-center dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold text-slate-900 dark:text-white">No media uploaded yet</p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Upload your first logo, favicon, or image asset above.</p>
      </section>

      <section data-media-search-empty class="hidden rounded-2xl border border-slate-200 bg-white p-10 text-center dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold text-slate-900 dark:text-white">No matching media found</p>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try another filename, path, or alt text.</p>
      </section>
    </div>
  </section>

  <div id="mediaEditorModal" class="fixed inset-0 z-[220] hidden items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm">
    <div class="flex h-[94vh] w-[94vw] max-h-[94vh] max-w-[94vw] flex-col overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-[#111827]">
      <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-700">
        <div>
          <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#C99A30]">Media Editor</p>
          <h3 class="mt-1 text-lg font-bold text-slate-900 dark:text-white">Media details</h3>
        </div>
        <button type="button" data-close-media-editor class="rounded-xl border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="grid min-h-0 flex-1 gap-0 md:grid-cols-[minmax(0,1.25fr)_380px]">
        <div class="min-h-0 overflow-auto bg-slate-950/95 p-6">
          <div class="flex min-h-[420px] items-center justify-center">
            <img id="mediaEditorImage" src="" alt="" class="block max-h-[78vh] max-w-full rounded-[20px] object-contain shadow-[0_24px_80px_rgba(0,0,0,.28)]" />
          </div>
        </div>

        <div class="min-h-0 overflow-auto border-t border-slate-200 p-6 dark:border-slate-700 lg:border-l lg:border-t-0">
          <form id="mediaEditorForm" class="space-y-5">
            <div>
              <p id="mediaEditorName" class="truncate text-base font-semibold text-slate-900 dark:text-white"></p>
              <p id="mediaEditorPath" class="mt-1 truncate text-xs text-slate-400"></p>
            </div>
            <label class="block">
              <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Alt text</span>
              <input id="mediaEditorAlt" name="alt_text" type="text" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#C99A30] focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:focus:bg-slate-900" />
            </label>
            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-800">
              <input id="mediaEditorUseWebp" name="use_webp" type="checkbox" value="1" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
              <span class="min-w-0">
                <span class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Use WebP copy</span>
                <span id="mediaEditorWebpHint" class="mt-1 block text-xs text-slate-500 dark:text-slate-400">Generate and use a WebP version for supported frontend rendering.</span>
              </span>
            </label>
            <p id="mediaEditorMeta" class="text-xs text-slate-400"></p>
            <div class="flex flex-wrap gap-3">
              <button type="submit" class="rounded-xl bg-[#C99A30] px-4 py-3 text-sm font-semibold text-slate-950 transition hover:brightness-105">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
