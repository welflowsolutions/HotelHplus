<?php
$settings = $settings ?? [];
$mediaFiles = $mediaFiles ?? [];
$eventsGalleryImages = old('events_gallery_images', $settings['events_gallery_images'] ?? "assets/web/images/new/DSC_6616.webp\nassets/web/images/new/DSC_6617.webp\nassets/web/images/new/DSC_6618.webp\nassets/web/images/new/DSC_6619.webp\nassets/web/images/new/PHOTO-2026-08-13-10-26-08.webp");
$galleryImages = preg_split('/\r\n|\r|\n/', (string) $eventsGalleryImages);
$galleryImages = array_values(array_filter(array_map(static fn ($item): string => trim((string) $item), $galleryImages)));
?>

<div class="space-y-5">
  <div class="flex items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Glimpse Gallery</h1>
      <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Only manage the images used in the “A Glimpse of Our Event Experience” section here.</p>
    </div>
    <a href="<?= base_url('admin/events') ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Events
    </a>
  </div>

  <form action="<?= base_url('admin/events/page') ?>" method="POST" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
    <?= csrf_field() ?>

    <div class="rounded-3xl border border-slate-200/80 bg-slate-50/40 p-5 dark:border-slate-700 dark:bg-slate-800/30">
      <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
          <h2 class="text-base font-semibold text-slate-900 dark:text-white">Gallery Images</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">These images appear on the public Events page gallery only.</p>
        </div>
        <div class="flex flex-wrap gap-2">
          <button type="button" data-open-media-picker="events_gallery" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Add from Media
          </button>
          <button type="button" id="clearEventsGalleryBtn" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
            Clear Gallery
          </button>
        </div>
      </div>

      <div class="mb-4">
        <h2 class="text-base font-semibold text-slate-900 dark:text-white">Gallery Image Paths</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Use the media picker to build this gallery visually.</p>
      </div>

      <label for="events_gallery_images" class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-300">A Glimpse of Our Event Experience</label>
      <textarea id="events_gallery_images" name="events_gallery_images" rows="10" class="hidden"><?= esc($eventsGalleryImages) ?></textarea>

      <div id="eventsGalleryGrid" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php foreach ($galleryImages as $index => $image): ?>
          <div class="events-gallery-item group overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900" data-gallery-image="<?= esc($image) ?>">
            <div class="relative aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-800">
              <img src="<?= esc(media_url($image)) ?>" alt="Events gallery image <?= $index + 1 ?>" class="h-full w-full object-cover" />
              <button type="button" class="absolute right-3 top-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-950/70 text-white opacity-0 transition group-hover:opacity-100" data-remove-gallery-image="<?= esc($image) ?>">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
            <div class="p-3">
              <p class="truncate text-xs text-slate-500 dark:text-slate-400"><?= esc($image) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div id="eventsGalleryEmpty" class="<?= $galleryImages !== [] ? 'hidden ' : '' ?>rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-10 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900/40 dark:text-slate-400">
        No gallery images selected yet.
      </div>
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
      <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Gallery Images</button>
    </div>
  </form>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'eventsGalleryMediaPickerModal',
  'searchId' => 'eventsGalleryMediaSearch',
  'emptyId' => 'eventsGalleryMediaSearchEmpty',
  'files' => $mediaFiles,
  'title' => 'Choose Gallery Images',
  'description' => 'Select images from the media library for the Events gallery.',
]) ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    const mediaPickerModal = document.getElementById('eventsGalleryMediaPickerModal');
    const mediaSearchInput = document.getElementById('eventsGalleryMediaSearch');
    const mediaSearchCount = mediaPickerModal ? mediaPickerModal.querySelector('[data-media-picker-count]') : null;
    const mediaSearchEmpty = document.getElementById('eventsGalleryMediaSearchEmpty');
    const galleryInput = document.getElementById('events_gallery_images');
    const galleryGrid = document.getElementById('eventsGalleryGrid');
    const galleryEmpty = document.getElementById('eventsGalleryEmpty');
    const clearGalleryBtn = document.getElementById('clearEventsGalleryBtn');
    let activeMediaTarget = null;

    function mediaUrl(path) {
      if (!path) return '';
      return /^https?:\/\//i.test(path) ? path : baseUrl + path.replace(/^\/+/, '');
    }

    function setMediaPicker(open) {
      if (!mediaPickerModal) return;
      mediaPickerModal.classList.toggle('hidden', !open);
      mediaPickerModal.classList.toggle('flex', open);
      document.body.classList.toggle('overflow-hidden', open);
    }

    function filterMediaCards() {
      const cards = Array.from(document.querySelectorAll('#eventsGalleryMediaPickerModal [data-media-picker-card]'));
      const query = (mediaSearchInput?.value || '').trim().toLowerCase();
      let visible = 0;

      cards.forEach(function (card) {
        const haystack = [(card.dataset.mediaName || ''), (card.dataset.mediaPath || '')].join(' ');
        const match = query === '' || haystack.includes(query);
        card.hidden = !match;
        if (match) visible += 1;
      });

      if (mediaSearchCount) mediaSearchCount.textContent = String(visible);
      if (mediaSearchEmpty) mediaSearchEmpty.classList.toggle('hidden', !(query !== '' && visible === 0));
    }

    function readGallery() {
      return (galleryInput?.value || '')
        .split(/\r\n|\r|\n/)
        .map(function (item) { return item.trim(); })
        .filter(Boolean);
    }

    function writeGallery(images) {
      if (galleryInput) {
        galleryInput.value = images.join('\n');
      }
    }

    function renderGallery() {
      const images = readGallery();
      if (!galleryGrid || !galleryEmpty) return;

      galleryGrid.innerHTML = '';
      galleryEmpty.classList.toggle('hidden', images.length !== 0);

      images.forEach(function (image, index) {
        const item = document.createElement('div');
        item.className = 'events-gallery-item group overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900';
        item.innerHTML =
          '<div class="relative aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-800">' +
            '<img src="' + mediaUrl(image) + '" alt="Events gallery image ' + (index + 1) + '" class="h-full w-full object-cover" />' +
            '<button type="button" class="absolute right-3 top-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-950/70 text-white opacity-0 transition group-hover:opacity-100" data-remove-gallery-index="' + index + '">' +
              '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>' +
            '</button>' +
          '</div>' +
          '<div class="p-3"><p class="truncate text-xs text-slate-500 dark:text-slate-400">' + image + '</p></div>';
        galleryGrid.appendChild(item);
      });

      galleryGrid.querySelectorAll('[data-remove-gallery-index]').forEach(function (button) {
        button.addEventListener('click', function () {
          const images = readGallery();
          const index = Number(button.dataset.removeGalleryIndex);
          images.splice(index, 1);
          writeGallery(images);
          renderGallery();
        });
      });
    }

    document.querySelectorAll('[data-open-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        activeMediaTarget = button.dataset.openMediaPicker;
        if (activeMediaTarget === 'events_gallery') {
          setMediaPicker(true);
        }
      });
    });

    document.querySelectorAll('#eventsGalleryMediaPickerModal [data-select-media-path]').forEach(function (button) {
      button.addEventListener('click', function () {
        const path = button.dataset.selectMediaPath || '';
        if (!path || activeMediaTarget !== 'events_gallery') return;

        const images = readGallery();
        if (!images.includes(path)) {
          images.push(path);
          writeGallery(images);
          renderGallery();
        }

        setMediaPicker(false);
      });
    });

    document.querySelectorAll('#eventsGalleryMediaPickerModal [data-close-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        setMediaPicker(false);
      });
    });

    if (mediaPickerModal) {
      mediaPickerModal.addEventListener('click', function (event) {
        if (event.target === mediaPickerModal) setMediaPicker(false);
      });
    }

    if (mediaSearchInput) {
      mediaSearchInput.addEventListener('input', filterMediaCards);
      filterMediaCards();
    }

    if (clearGalleryBtn) {
      clearGalleryBtn.addEventListener('click', function () {
        writeGallery([]);
        renderGallery();
      });
    }

    renderGallery();
  });
</script>
