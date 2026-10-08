<div class="space-y-6">
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">SEO Manager</p>
      <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Global SEO</h1>
      <p class="mt-1 max-w-3xl text-sm text-slate-500 dark:text-slate-400">Manage site-wide SEO settings, favicon, sitemap, and robots configuration for the whole website.</p>
    </div>
    <a href="<?= base_url('admin/seo-manager') ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
      Back to Pages
    </a>
  </div>

  <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
    <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
      <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-2v4m-7 4h14M5 19h14M7 9h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2z"/>
        </svg>
      </div>
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Website SEO Settings</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">These values apply across the whole website and work as fallback defaults for page SEO.</p>
      </div>
    </div>

    <form action="<?= base_url('admin/seo-manager/global') ?>" method="POST" class="grid gap-5 sm:grid-cols-2">
      <?= csrf_field() ?>
      <div class="sm:col-span-2">
        <label for="brand_favicon" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Favicon Path / URL</label>
        <div class="space-y-3">
          <input id="brand_favicon" name="brand_favicon" type="text" value="<?= esc($favicon ?? '') ?>" placeholder="uploads/favicon.ico" data-media-value="brand_favicon" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          <div class="flex flex-wrap items-center gap-3">
            <img src="<?= esc(media_url($favicon ?? '')) ?>" alt="Favicon preview" data-media-preview="brand_favicon" class="<?= empty($favicon) ? 'hidden ' : '' ?>h-14 w-14 rounded-2xl border border-slate-200 bg-slate-50 object-contain p-2 dark:border-slate-700 dark:bg-slate-800" />
            <span data-media-empty="brand_favicon" class="<?= ! empty($favicon) ? 'hidden ' : '' ?>text-xs text-slate-400">No favicon selected</span>
            <button type="button" data-open-media-picker="brand_favicon" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
            <button type="button" data-clear-media="brand_favicon" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
          </div>
        </div>
      </div>
      <div class="sm:col-span-2">
        <label for="seo_meta_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Default SEO Title</label>
        <input id="seo_meta_title" name="seo_meta_title" type="text" value="<?= esc($defaultTitle ?? '') ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>
      <div class="sm:col-span-2">
        <label for="seo_meta_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Default SEO Description</label>
        <textarea id="seo_meta_description" name="seo_meta_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($defaultDescription ?? '') ?></textarea>
      </div>
      <div class="sm:col-span-2">
        <label for="seo_meta_keywords" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Meta Keywords</label>
        <input id="seo_meta_keywords" name="seo_meta_keywords" type="text" value="<?= esc($defaultKeywords ?? '') ?>" placeholder="hotel, kurukshetra, banquet, rooms" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>
      <div>
        <label for="seo_robots" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Meta Robots</label>
        <input id="seo_robots" name="seo_robots" type="text" value="<?= esc($defaultRobots ?? 'index, follow') ?>" placeholder="index, follow" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>
      <div>
        <label for="seo_twitter_card" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Twitter Card</label>
        <select id="seo_twitter_card" name="seo_twitter_card" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
          <option value="summary_large_image" <?= ($defaultTwitterCard ?? '') === 'summary_large_image' ? 'selected' : '' ?>>summary_large_image</option>
          <option value="summary" <?= ($defaultTwitterCard ?? '') === 'summary' ? 'selected' : '' ?>>summary</option>
        </select>
      </div>
      <div>
        <label for="seo_google_verification" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Google Verification</label>
        <input id="seo_google_verification" name="seo_google_verification" type="text" value="<?= esc($googleVerification ?? '') ?>" placeholder="Google Search Console code" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>
      <div>
        <label for="seo_bing_verification" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Bing Verification</label>
        <input id="seo_bing_verification" name="seo_bing_verification" type="text" value="<?= esc($bingVerification ?? '') ?>" placeholder="Bing Webmaster code" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
      </div>
      <div class="sm:col-span-2">
        <label for="seo_og_image" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Default OG Image Path / URL</label>
        <div class="space-y-3">
          <input id="seo_og_image" name="seo_og_image" type="text" value="<?= esc($defaultOgImage ?? '') ?>" placeholder="uploads/seo/default-og.jpg" data-media-value="seo_og_image" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          <div class="flex flex-wrap items-center gap-3">
            <img src="<?= esc(media_url($defaultOgImage ?? '')) ?>" alt="OG image preview" data-media-preview="seo_og_image" class="<?= empty($defaultOgImage) ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-contain p-2 dark:border-slate-700 dark:bg-slate-800" />
            <span data-media-empty="seo_og_image" class="<?= ! empty($defaultOgImage) ? 'hidden ' : '' ?>text-xs text-slate-400">No OG image selected</span>
            <button type="button" data-open-media-picker="seo_og_image" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
            <button type="button" data-clear-media="seo_og_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
          </div>
        </div>
      </div>
      <div class="sm:col-span-2 grid gap-5">
        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-800/60">
          <div class="mb-4">
            <p class="text-sm font-semibold text-slate-900 dark:text-white">Dynamic Sitemap</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Generated automatically from frontend pages and active room pages.</p>
          </div>
          <label class="mb-4 flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
            <input type="checkbox" name="seo_sitemap_enabled" value="1" <?= ($sitemapEnabled ?? '1') === '1' ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
            <span>
              <span class="block text-sm font-medium text-slate-900 dark:text-white">Enable Sitemap</span>
              <span class="block text-xs text-slate-400">Turn the public dynamic sitemap on or off.</span>
            </span>
          </label>
          <div class="grid gap-3 sm:grid-cols-3">
            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
              <input type="checkbox" name="seo_sitemap_include_rooms" value="1" <?= ($sitemapIncludeRooms ?? '1') === '1' ? 'checked' : '' ?> class="mt-1 h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
              <span>
                <span class="block text-sm font-medium text-slate-900 dark:text-white">Room Pages</span>
                <span class="block text-xs text-slate-400">Include active room detail pages.</span>
              </span>
            </label>
            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
              <input type="checkbox" name="seo_sitemap_include_legal" value="1" <?= ($sitemapIncludeLegal ?? '1') === '1' ? 'checked' : '' ?> class="mt-1 h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
              <span>
                <span class="block text-sm font-medium text-slate-900 dark:text-white">Legal Pages</span>
                <span class="block text-xs text-slate-400">Include privacy and terms pages.</span>
              </span>
            </label>
            <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
              <input type="checkbox" name="seo_sitemap_include_thank_you" value="1" <?= ($sitemapIncludeThankYou ?? '0') === '1' ? 'checked' : '' ?> class="mt-1 h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
              <span>
                <span class="block text-sm font-medium text-slate-900 dark:text-white">Thank You Page</span>
                <span class="block text-xs text-slate-400">Usually best left out.</span>
              </span>
            </label>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Sitemap URL</p>
            <a href="<?= esc($sitemapUrl) ?>" target="_blank" rel="noopener" class="mt-2 inline-flex break-all text-sm font-medium text-[#C99A30] hover:text-[#d5ab4a]"><?= esc($sitemapUrl) ?></a>
          </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-800/60">
          <div class="mb-4">
            <p class="text-sm font-semibold text-slate-900 dark:text-white">Robots.txt</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Control additional crawl rules while the system keeps the sitemap link in place.</p>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Robots URL</p>
            <a href="<?= esc($robotsUrl) ?>" target="_blank" rel="noopener" class="mt-2 inline-flex break-all text-sm font-medium text-[#C99A30] hover:text-[#d5ab4a]"><?= esc($robotsUrl) ?></a>
          </div>
          <div class="mt-4">
            <label for="seo_robots_txt" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Extra Rules</label>
            <textarea id="seo_robots_txt" name="seo_robots_txt" rows="8" placeholder="Disallow: /admin/" class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-900/70 dark:text-white"><?= esc($robotsTxt ?? '') ?></textarea>
            <p class="mt-2 text-xs text-slate-400">Add only custom rules here. Basic user-agent and sitemap lines are generated automatically.</p>
          </div>
        </section>
      </div>
      <section class="sm:col-span-2 rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-800/60">
        <div class="mb-4">
          <p class="text-sm font-semibold text-slate-900 dark:text-white">JSON-LD Structured Data</p>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Auto-generates Hotel structured data from your website settings and can include an optional custom JSON-LD block.</p>
        </div>
        <label class="mb-4 flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-700 dark:bg-slate-900/70">
          <input type="checkbox" name="seo_json_ld_enabled" value="1" <?= ($jsonLdEnabled ?? '1') === '1' ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30]" />
          <span>
            <span class="block text-sm font-medium text-slate-900 dark:text-white">Enable JSON-LD</span>
            <span class="block text-xs text-slate-400">Outputs structured data in the frontend `<head>` for search engines.</span>
          </span>
        </label>
        <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 dark:border-slate-700 dark:bg-slate-900/70">
          <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Auto Schema</p>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">The system auto-builds a `Hotel` schema using hotel name, description, phone, email, address, OG image, and social links.</p>
        </div>
        <div class="mt-4">
          <label for="seo_json_ld_custom" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Custom JSON-LD</label>
          <textarea id="seo_json_ld_custom" name="seo_json_ld_custom" rows="8" placeholder='{"@context":"https://schema.org","@type":"FAQPage"}' class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-900/70 dark:text-white"><?= esc($jsonLdCustom ?? '') ?></textarea>
          <p class="mt-2 text-xs text-slate-400">Optional. Add a valid JSON-LD object here if you want extra schema beyond the auto-generated hotel schema.</p>
        </div>
      </section>
      <div class="sm:col-span-2 flex justify-end">
        <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
          Save Global SEO
        </button>
      </div>
    </form>
  </div>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'seoGlobalMediaPickerModal',
  'searchId' => 'seoGlobalMediaSearch',
  'emptyId' => 'seoGlobalMediaSearchEmpty',
  'files' => $mediaFiles ?? [],
  'title' => 'Choose SEO Image',
  'description' => 'Select a saved favicon or social share image from the media library.',
  'showUploadPanel' => true,
  'uploadToggleId' => 'seoGlobalMediaUploadToggle',
  'uploadToggleLabelId' => 'seoGlobalMediaUploadToggleLabel',
  'uploadToggleIconId' => 'seoGlobalMediaUploadToggleIcon',
  'uploadPanelId' => 'seoGlobalMediaUploadPanel',
  'uploadInputId' => 'seo_global_media_file',
]) ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('seoGlobalMediaPickerModal');
    const searchInput = document.getElementById('seoGlobalMediaSearch');
    const searchCount = modal ? modal.querySelector('[data-media-picker-count]') : null;
    const searchEmpty = document.getElementById('seoGlobalMediaSearchEmpty');
    const uploadPanel = document.getElementById('seoGlobalMediaUploadPanel');
    const uploadToggle = document.getElementById('seoGlobalMediaUploadToggle');
    const uploadToggleLabel = document.getElementById('seoGlobalMediaUploadToggleLabel');
    const uploadToggleIcon = document.getElementById('seoGlobalMediaUploadToggleIcon');
    const uploadForm = uploadPanel ? uploadPanel.querySelector('form') : null;
    const uploadInput = document.getElementById('seo_global_media_file');
    const uploadFileName = uploadPanel ? uploadPanel.querySelector('[data-file-name]') : null;
    const uploadStatus = uploadPanel ? uploadPanel.querySelector('[data-upload-status]') : null;
    const mediaGrid = modal ? modal.querySelector('[data-media-picker-grid]') : null;
    const mediaEmptyState = modal ? modal.querySelector('[data-media-picker-empty]') : null;
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    let activeMediaTarget = null;

    function setField(target, path) {
      const input = document.querySelector('[data-media-value="' + target + '"]');
      const preview = document.querySelector('[data-media-preview="' + target + '"]');
      const empty = document.querySelector('[data-media-empty="' + target + '"]');
      if (input) input.value = path;
      if (preview) {
        preview.src = path ? baseUrl + path.replace(/^\/+/, '') : '';
        preview.classList.toggle('hidden', !path);
      }
      if (empty) empty.classList.toggle('hidden', !!path);
    }

    function setModal(open) {
      if (!modal) return;
      modal.classList.toggle('hidden', !open);
      modal.classList.toggle('flex', open);
      document.body.classList.toggle('overflow-hidden', open);
    }

    function setUploadPanel(open) {
      if (!uploadPanel || !uploadToggle) {
        return;
      }

      uploadPanel.style.maxHeight = open ? '22rem' : '0px';
      uploadPanel.style.opacity = open ? '1' : '0';
      uploadPanel.style.transform = open ? 'translateY(0)' : 'translateY(-12px)';
      uploadPanel.style.pointerEvents = open ? 'auto' : 'none';
      uploadToggle.setAttribute('aria-expanded', open ? 'true' : 'false');

      if (uploadToggleLabel) uploadToggleLabel.textContent = open ? 'Hide Upload' : 'Open Upload';
      if (uploadToggleIcon) uploadToggleIcon.classList.toggle('rotate-45', open);
    }

    function filterCards() {
      const cards = Array.from(document.querySelectorAll('#seoGlobalMediaPickerModal [data-media-picker-card]'));
      const query = (searchInput?.value || '').trim().toLowerCase();
      let visible = 0;
      cards.forEach(function (card) {
        const haystack = [(card.dataset.mediaName || ''), (card.dataset.mediaPath || '')].join(' ');
        const match = query === '' || haystack.includes(query);
        card.hidden = !match;
        if (match) visible += 1;
      });
      if (searchCount) searchCount.textContent = String(visible);
      if (searchEmpty) searchEmpty.classList.toggle('hidden', !(query !== '' && visible === 0));
    }

    function bindMediaCardSelection(card) {
      card.addEventListener('click', function () {
        if (!activeMediaTarget) return;
        setField(activeMediaTarget, card.dataset.selectMediaPath || '');
        setModal(false);
      });
    }

    function appendPickerFiles(files) {
      if (!mediaGrid || !Array.isArray(files) || files.length === 0) {
        return;
      }

      files.forEach(function (file) {
        const card = document.createElement('button');
        card.type = 'button';
        card.dataset.selectMediaPath = file.path || '';
        card.dataset.mediaPickerCard = '';
        card.dataset.mediaName = (file.original_name || '').toLowerCase();
        card.dataset.mediaPath = (file.path || '').toLowerCase();
        card.className = 'group overflow-hidden rounded-2xl border border-slate-200 bg-white text-left transition hover:-translate-y-0.5 hover:border-[#C99A30] hover:shadow-lg dark:border-slate-700 dark:bg-slate-900';
        card.innerHTML =
          '<span class="flex aspect-[4/3] items-center justify-center bg-slate-100 dark:bg-slate-800">' +
            '<img src="' + (file.url || '') + '" alt="' + (file.alt_text || file.original_name || 'Media image') + '" class="h-full w-full object-contain p-4" />' +
          '</span>' +
          '<span class="block p-3">' +
            '<span class="block truncate text-sm font-semibold text-slate-900 dark:text-white">' + (file.original_name || '') + '</span>' +
            '<span class="mt-1 block truncate text-xs text-slate-400">' + (file.path || '') + '</span>' +
          '</span>';
        bindMediaCardSelection(card);
        mediaGrid.prepend(card);
      });

      mediaGrid.classList.remove('hidden');
      if (mediaEmptyState) mediaEmptyState.classList.add('hidden');
      filterCards();
    }

    function syncUploadName(files) {
      if (!uploadFileName) return;
      if (!files || !files.length) {
        uploadFileName.textContent = '';
        return;
      }
      uploadFileName.textContent = files.length === 1 ? files[0].name : files.length + ' files selected';
    }

    async function uploadPickerFiles(files) {
      if (!uploadForm || !uploadInput || !files || !files.length) return;

      const formData = new FormData(uploadForm);
      formData.delete('media_files[]');
      Array.from(files).forEach(function (file) {
        formData.append('media_files[]', file);
      });

      if (uploadStatus) uploadStatus.textContent = 'Uploading...';

      try {
        const response = await fetch(uploadForm.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        const payload = await response.json();

        if (payload && payload.csrf && payload.csrf.hash) {
          document.querySelectorAll('input[name="' + payload.csrf.token + '"]').forEach(function (field) {
            field.value = payload.csrf.hash;
          });
        }

        if (!response.ok || !payload.success) {
          throw new Error(payload.message || 'Upload failed.');
        }

        appendPickerFiles(payload.files || []);
        uploadInput.value = '';
        syncUploadName([]);
        if (uploadStatus) uploadStatus.textContent = payload.message || 'Upload complete.';
        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(payload.message || 'Media uploaded.', 'success');
        }
      } catch (error) {
        if (uploadStatus) uploadStatus.textContent = error.message || 'Upload failed.';
        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(error.message || 'Upload failed.', 'error');
        }
      }
    }

    document.querySelectorAll('[data-open-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        activeMediaTarget = button.dataset.openMediaPicker;
        setUploadPanel(false);
        setModal(true);
      });
    });

    document.querySelectorAll('[data-clear-media]').forEach(function (button) {
      button.addEventListener('click', function () {
        setField(button.dataset.clearMedia, '');
      });
    });

    document.querySelectorAll('#seoGlobalMediaPickerModal [data-select-media-path]').forEach(function (button) {
      bindMediaCardSelection(button);
    });

    document.querySelectorAll('#seoGlobalMediaPickerModal [data-close-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        setModal(false);
      });
    });

    if (modal) {
      modal.addEventListener('click', function (event) {
        if (event.target === modal) setModal(false);
      });
    }

    if (searchInput) {
      searchInput.addEventListener('input', filterCards);
      filterCards();
    }

    if (uploadToggle) {
      uploadToggle.addEventListener('click', function () {
        const isOpen = uploadToggle.getAttribute('aria-expanded') === 'true';
        setUploadPanel(!isOpen);
      });
    }

    if (uploadInput) {
      uploadInput.addEventListener('change', function () {
        syncUploadName(uploadInput.files);
        if (uploadInput.files && uploadInput.files.length) {
          uploadPickerFiles(uploadInput.files);
        }
      });
    }

    if (uploadPanel) {
      const dropZone = uploadPanel.querySelector('[data-drop-zone]');
      if (dropZone) {
        ['dragenter', 'dragover'].forEach(function (eventName) {
          dropZone.addEventListener(eventName, function (event) {
            event.preventDefault();
            dropZone.classList.add('border-[#C99A30]', 'bg-[#C99A30]/5');
          });
        });

        ['dragleave', 'dragend', 'drop'].forEach(function (eventName) {
          dropZone.addEventListener(eventName, function (event) {
            event.preventDefault();
            dropZone.classList.remove('border-[#C99A30]', 'bg-[#C99A30]/5');
          });
        });

        dropZone.addEventListener('drop', function (event) {
          const files = event.dataTransfer ? event.dataTransfer.files : null;
          syncUploadName(files);
          if (files && files.length) {
            uploadPickerFiles(files);
          }
        });
      }
    }
  });
</script>
