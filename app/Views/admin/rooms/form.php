<?php
$isEdit    = ! empty($room);
$action    = $isEdit
    ? base_url('admin/rooms/update/' . $room['id'])
    : base_url('admin/rooms/store');
$amenities = $isEdit && ! empty($room['amenities'])
    ? implode("\n", json_decode($room['amenities'], true) ?? [])
    : '';
$roomImage = (string) ($room['image'] ?? '');
$roomImageUrl = $roomImage !== '' ? base_url($roomImage) : '';
$mediaFiles = $mediaFiles ?? [];
$galleryImages = json_decode((string) ($room['gallery_images'] ?? '[]'), true);
$galleryImages = is_array($galleryImages) ? array_values(array_filter(array_map(static fn ($item): string => trim((string) $item), $galleryImages))) : [];
$paymentGatewayActive = app_setting('payment_gateway_enabled', '0') === '1';
?>

<div class="mx-auto max-w-5xl space-y-6">
  <div class="flex items-start gap-4">
    <a href="<?= base_url('admin/rooms') ?>"
       class="mt-1 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div class="min-w-0">
      <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white"><?= $isEdit ? 'Edit Room' : 'Add New Room' ?></h1>
      <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
        Manage the room name, URL, pricing, guest capacity, amenities, display image, and visibility.
      </p>
    </div>
  </div>

  <form action="<?= $action ?>" method="POST" enctype="multipart/form-data"
        class="overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <?= csrf_field() ?>

    <div class="border-b border-slate-100 px-6 py-5 dark:border-slate-800 sm:px-7">
      <div class="flex items-center gap-3">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v11a1 1 0 01-1 1h-6v-7H10v7H4a1 1 0 01-1-1V10z"/>
          </svg>
        </div>
        <div>
          <h2 class="text-lg font-bold text-slate-900 dark:text-white">Room Details</h2>
          <p class="text-sm text-slate-500 dark:text-slate-400">Keep this room ready for the frontend room list and detail page.</p>
        </div>
      </div>
    </div>

    <div class="space-y-8 px-6 py-6 sm:px-7 sm:py-7">
      <section class="grid gap-5 lg:grid-cols-2">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Room Name <span class="text-amber-500">*</span></label>
          <input type="text" name="name" required
                 value="<?= esc(old('name', $room['name'] ?? '')) ?>"
                 placeholder="Deluxe Room"
                 class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        </div>
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">URL Slug <span class="text-amber-500">*</span></label>
          <input type="text" name="slug" required
                 value="<?= esc(old('slug', $room['slug'] ?? '')) ?>"
                 placeholder="deluxe-room"
                 class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          <p class="mt-2 text-xs text-slate-400">Frontend URL: <span class="text-slate-500 dark:text-slate-300">/rooms/<?= esc(old('slug', $room['slug'] ?? 'your-room')) ?></span></p>
        </div>
      </section>

      <section class="grid gap-5 lg:grid-cols-2">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Price Per Night (₹) <span class="text-amber-500">*</span></label>
          <input type="number" name="price" required min="0" step="0.01"
                 value="<?= esc(old('price', $room['price'] ?? '')) ?>"
                 placeholder="1800"
                 class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
          <div>
          <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Max Guests</label>
          <select name="max_guests"
                  class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            <?php foreach ([1, 2, 3, 4, 5] as $n): ?>
              <option value="<?= $n ?>" <?= (int) old('max_guests', $room['max_guests'] ?? 2) === $n ? 'selected' : '' ?>>
                <?= $n ?> Guest<?= $n > 1 ? 's' : '' ?>
              </option>
            <?php endforeach; ?>
          </select>
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Available Units</label>
            <input type="number" name="available_units" min="1" max="500"
                   value="<?= esc(old('available_units', $room['available_units'] ?? 1)) ?>"
                   placeholder="15"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <p class="mt-2 text-xs text-slate-400">Total rooms available in this room type.</p>
          </div>
        </div>
      </section>

      <section class="space-y-5">
        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
          <textarea name="description" rows="5"
                    placeholder="Describe the room, comfort level, and what kind of stay it suits best."
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc(old('description', $room['description'] ?? '')) ?></textarea>
        </div>

        <div>
          <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Amenities</label>
          <textarea name="amenities" rows="7"
                    placeholder="One amenity per line&#10;King Bed&#10;Air Conditioning&#10;Free Wi-Fi"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($amenities) ?></textarea>
          <p class="mt-2 text-xs text-slate-400">One amenity per line. These appear on the room detail page.</p>
        </div>
      </section>

      <section class="grid gap-5 xl:grid-cols-[1.2fr_.8fr]">
        <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5 dark:border-slate-700 dark:bg-slate-800/50">
          <div class="mb-4">
            <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Room Image</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Choose a clean room photo from the media library for the frontend list and detail page.</p>
          </div>

          <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
            <div class="flex h-44 w-full max-w-[220px] items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-slate-300 bg-white dark:border-slate-700 dark:bg-slate-900">
              <?php if ($roomImageUrl !== ''): ?>
                <img id="roomImagePreview" src="<?= esc(media_url($roomImage, $roomImageUrl)) ?>" alt="<?= esc($room['name'] ?? 'Room image') ?>" class="h-full w-full object-cover" />
              <?php else: ?>
                <div id="roomImageEmpty" class="px-6 text-center">
                  <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <p class="text-sm font-medium text-slate-500 dark:text-slate-400">No image selected</p>
                </div>
              <?php endif; ?>
              <?php if ($roomImageUrl === ''): ?>
                <img id="roomImagePreview" src="" alt="Room image preview" class="hidden h-full w-full object-cover" />
              <?php endif; ?>
            </div>

            <div class="min-w-0 flex-1">
              <input id="roomImagePathInput" type="hidden" name="image_path" value="<?= esc($roomImage) ?>" />
              <div class="flex flex-wrap gap-2">
                <button type="button" data-open-media-picker="room_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                  Choose from Media
                </button>
                <button type="button" data-clear-media="room_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                  Clear
                </button>
              </div>
              <p id="roomImagePathLabel" class="mt-3 break-all text-xs text-slate-500 dark:text-slate-400"><?= esc($roomImage) ?></p>
              <p class="mt-2 text-xs text-slate-400">Images for rooms are managed through the media library. Your selected media path will be saved with the room.</p>
            </div>
          </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5 dark:border-slate-700 dark:bg-slate-800/50">
          <div class="mb-4">
            <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Display Settings</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Control the room order and whether it appears on the website.</p>
          </div>

          <div class="space-y-5">
            <div>
              <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Sort Order</label>
              <input type="number" name="sort_order" min="0"
                     value="<?= esc(old('sort_order', $room['sort_order'] ?? 0)) ?>"
                     class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-900 dark:text-white" />
            </div>

            <label class="flex items-start gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 transition hover:border-[#C99A30]/40 dark:border-slate-700 dark:bg-slate-900">
              <div class="relative mt-0.5">
                <input type="checkbox" name="is_active" value="1" class="peer sr-only" <?= (old('is_active', $room['is_active'] ?? 1)) ? 'checked' : '' ?> />
                <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#C99A30] dark:bg-slate-700"></div>
                <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></div>
              </div>
              <div>
                <p class="text-sm font-medium text-slate-800 dark:text-slate-100">Active on website</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Turn this off to hide the room from frontend without deleting it.</p>
              </div>
            </label>

            <?php if ($paymentGatewayActive): ?>
              <label class="flex items-start gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 transition hover:border-[#C99A30]/40 dark:border-slate-700 dark:bg-slate-900">
                <div class="relative mt-0.5">
                  <input type="checkbox" name="booking_open" value="1" class="peer sr-only" <?= (old('booking_open', $room['booking_open'] ?? 1)) ? 'checked' : '' ?> />
                  <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#C99A30] dark:bg-slate-700"></div>
                  <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></div>
                </div>
                <div>
                  <p class="text-sm font-medium text-slate-800 dark:text-slate-100"><?= (old('booking_open', $room['booking_open'] ?? 1)) ? 'Booking Open' : 'Booking Close' ?></p>
                  <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Used only when payment gateway mode is active to control whether this room can be booked.</p>
                </div>
              </label>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5 dark:border-slate-700 dark:bg-slate-800/50">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
          <div>
            <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Room Gallery</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">These images are shown as thumbnails on the room detail page.</p>
          </div>
          <div class="flex flex-wrap gap-2">
            <button type="button" data-open-media-picker="room_gallery" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
              Add from Media
            </button>
            <button type="button" id="clearRoomGalleryBtn" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
              Clear Gallery
            </button>
          </div>
        </div>

        <input id="roomGalleryImagesInput" type="hidden" name="gallery_images" value="<?= esc(json_encode($galleryImages, JSON_UNESCAPED_SLASHES)) ?>" />

        <div id="roomGalleryGrid" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
          <?php foreach ($galleryImages as $index => $image): ?>
            <div class="room-gallery-item group overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900" data-gallery-image="<?= esc($image) ?>">
              <div class="relative aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-800">
                <img src="<?= esc(media_url($image)) ?>" alt="Room gallery image <?= $index + 1 ?>" class="h-full w-full object-cover" />
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

        <div id="roomGalleryEmpty" class="<?= $galleryImages !== [] ? 'hidden ' : '' ?>rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-10 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900/40 dark:text-slate-400">
          No gallery images selected yet.
        </div>
      </section>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-100 px-6 py-5 dark:border-slate-800 sm:px-7">
      <a href="<?= base_url('admin/rooms') ?>"
         class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Cancel
      </a>
      <button type="submit"
              class="rounded-2xl bg-[#0D1117] px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
        <?= $isEdit ? 'Save Changes' : 'Create Room' ?>
      </button>
    </div>
  </form>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'roomMediaPickerModal',
  'searchId' => 'roomMediaSearch',
  'emptyId' => 'roomMediaSearchEmpty',
  'files' => $mediaFiles,
  'title' => 'Choose Room Media',
  'description' => 'Select images from the media library for the room cover or gallery.',
]) ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    const mediaPickerModal = document.getElementById('roomMediaPickerModal');
    const mediaSearchInput = document.getElementById('roomMediaSearch');
    const mediaSearchCount = mediaPickerModal ? mediaPickerModal.querySelector('[data-media-picker-count]') : null;
    const mediaSearchEmpty = document.getElementById('roomMediaSearchEmpty');
    const roomImagePathInput = document.getElementById('roomImagePathInput');
    const roomImagePathLabel = document.getElementById('roomImagePathLabel');
    const roomImagePreview = document.getElementById('roomImagePreview');
    const roomImageEmpty = document.getElementById('roomImageEmpty');
    const galleryInput = document.getElementById('roomGalleryImagesInput');
    const galleryGrid = document.getElementById('roomGalleryGrid');
    const galleryEmpty = document.getElementById('roomGalleryEmpty');
    const clearGalleryBtn = document.getElementById('clearRoomGalleryBtn');
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
      const cards = Array.from(document.querySelectorAll('#roomMediaPickerModal [data-media-picker-card]'));
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

    function setRoomImage(path) {
      if (roomImagePathInput) roomImagePathInput.value = path;
      if (roomImagePathLabel) roomImagePathLabel.textContent = path;

      if (!roomImagePreview) return;

      if (path) {
        roomImagePreview.src = mediaUrl(path);
        roomImagePreview.classList.remove('hidden');
        if (roomImageEmpty) roomImageEmpty.classList.add('hidden');
      } else {
        roomImagePreview.src = '';
        roomImagePreview.classList.add('hidden');
        if (roomImageEmpty) roomImageEmpty.classList.remove('hidden');
      }
    }

    function readGallery() {
      try {
        const parsed = JSON.parse(galleryInput?.value || '[]');
        return Array.isArray(parsed) ? parsed.filter(Boolean) : [];
      } catch (error) {
        return [];
      }
    }

    function writeGallery(images) {
      if (galleryInput) {
        galleryInput.value = JSON.stringify(images);
      }
    }

    function renderGallery() {
      const images = readGallery();
      if (!galleryGrid || !galleryEmpty) return;

      galleryGrid.innerHTML = '';
      galleryEmpty.classList.toggle('hidden', images.length !== 0);

      images.forEach(function (image, index) {
        const item = document.createElement('div');
        item.className = 'room-gallery-item group overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900';
        item.innerHTML =
          '<div class="relative aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-800">' +
            '<img src="' + mediaUrl(image) + '" alt="Room gallery image ' + (index + 1) + '" class="h-full w-full object-cover" />' +
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
        setMediaPicker(true);
      });
    });

    document.querySelectorAll('[data-clear-media]').forEach(function (button) {
      button.addEventListener('click', function () {
        if (button.dataset.clearMedia === 'room_image') {
          setRoomImage('');
        }
      });
    });

    document.querySelectorAll('#roomMediaPickerModal [data-select-media-path]').forEach(function (button) {
      button.addEventListener('click', function () {
        const path = button.dataset.selectMediaPath || '';
        if (!path) return;

        if (activeMediaTarget === 'room_image') {
          setRoomImage(path);
        } else if (activeMediaTarget === 'room_gallery') {
          const images = readGallery();
          if (!images.includes(path)) {
            images.push(path);
            writeGallery(images);
            renderGallery();
          }
        }

        setMediaPicker(false);
      });
    });

    document.querySelectorAll('#roomMediaPickerModal [data-close-media-picker]').forEach(function (button) {
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
