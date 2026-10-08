<div class="space-y-6">
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">SEO Manager</p>
      <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white"><?= esc($pageLabel) ?> SEO</h1>
      <p class="mt-1 max-w-3xl text-sm text-slate-500 dark:text-slate-400">Manage search appearance, social previews, and advanced crawl rules for this page. Empty fields inherit from Global SEO.</p>
    </div>
    <div class="flex flex-wrap gap-3">
      <a href="<?= base_url('admin/seo-manager/global') ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
        Global SEO
      </a>
      <a href="<?= base_url('admin/seo-manager') ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
        Back to Pages
      </a>
    </div>
  </div>

  <form action="<?= base_url('admin/seo-manager/' . $pageKey) ?>" method="POST" class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
    <?= csrf_field() ?>

    <div class="space-y-6">
      <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-2v4m-7 4h14M5 19h14M7 9h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white"><?= esc($pageLabel) ?></h2>
            <p class="text-sm text-slate-500 dark:text-slate-400"><?= esc($pageUrl) ?></p>
          </div>
        </div>

        <div class="grid gap-5">
          <div>
            <label for="seo_focus_keyword" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Focus Keyword</label>
            <input id="seo_focus_keyword" name="seo_focus_keyword" type="text" value="<?= esc($seoFocusKeyword) ?>" placeholder="best hotel in kurukshetra" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <p class="mt-2 text-xs text-slate-400">Optional. Use one main phrase so the editor can give lightweight SEO checks.</p>
          </div>

          <div>
            <div class="mb-2 flex items-center justify-between gap-3">
              <label for="seo_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300">SEO Title</label>
              <span class="text-xs text-slate-400"><span data-char-count-for="seo_title">0</span>/60</span>
            </div>
            <input id="seo_title" name="seo_title" type="text" value="<?= esc($seoTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
              <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 font-semibold text-slate-500 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300"><?= $seoTitle !== '' ? 'Page Override Active' : 'Using Global Default' ?></span>
              <span class="text-slate-400">Global title: <?= esc($defaultTitle ?: 'Not set') ?></span>
            </div>
          </div>

          <div>
            <div class="mb-2 flex items-center justify-between gap-3">
              <label for="seo_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Meta Description</label>
              <span class="text-xs text-slate-400"><span data-char-count-for="seo_description">0</span>/160</span>
            </div>
            <textarea id="seo_description" name="seo_description" rows="5" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoDescription) ?></textarea>
            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
              <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 font-semibold text-slate-500 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300"><?= $seoDescription !== '' ? 'Page Override Active' : 'Using Global Default' ?></span>
              <span class="text-slate-400">Global description: <?= esc($defaultDescription ?: 'Not set') ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10m-7 4h4M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Social Preview</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Control how this page looks when shared on Facebook, X, WhatsApp, and other platforms.</p>
          </div>
        </div>

        <div class="grid gap-5">
          <div>
            <div class="mb-2 flex items-center justify-between gap-3">
              <label for="seo_og_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300">OG Title</label>
              <span class="text-xs text-slate-400"><span data-char-count-for="seo_og_title">0</span>/60</span>
            </div>
            <input id="seo_og_title" name="seo_og_title" type="text" value="<?= esc($seoOgTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>

          <div>
            <div class="mb-2 flex items-center justify-between gap-3">
              <label for="seo_og_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300">OG Description</label>
              <span class="text-xs text-slate-400"><span data-char-count-for="seo_og_description">0</span>/160</span>
            </div>
            <textarea id="seo_og_description" name="seo_og_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoOgDescription) ?></textarea>
          </div>

          <div>
            <label for="seo_og_image" class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-300">Social Share Image Override</label>
            <input id="seo_og_image" name="seo_og_image" type="hidden" value="<?= esc($seoOgImage) ?>" data-media-value="seo_og_image" />
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
              <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 text-center text-xs font-medium text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <img src="<?= $seoOgImage !== '' ? esc(media_url($seoOgImage)) : '' ?>" alt="Social share image preview" data-media-preview="seo_og_image" class="<?= $seoOgImage === '' ? 'hidden' : '' ?> h-full w-full object-contain p-2" />
                <span data-media-empty="seo_og_image" class="<?= $seoOgImage !== '' ? 'hidden' : '' ?> px-3">Use global</span>
              </div>
              <div>
                <div class="mt-3 flex flex-wrap gap-2 sm:mt-0">
                  <button type="button" data-open-media-picker="seo_og_image" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">
                    Choose from Media
                  </button>
                  <button type="button" data-clear-media="seo_og_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Use Global
                  </button>
                </div>
                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                  <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 font-semibold text-slate-500 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-300"><?= $seoOgImage !== '' ? 'Page Override Active' : 'Using Branding Default' ?></span>
                  <span class="text-slate-400">Empty will inherit the default social share image from Global SEO.</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <details class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm open:pb-7 dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <summary class="cursor-pointer list-none text-lg font-bold text-slate-900 dark:text-white">
          <span class="flex items-center justify-between gap-3">
            <span>Advanced SEO</span>
            <span class="text-sm font-medium text-slate-400">Canonical, robots, and card controls</span>
          </span>
        </summary>
        <div class="mt-6 grid gap-5 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <label for="seo_canonical_url" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Canonical URL</label>
            <input id="seo_canonical_url" name="seo_canonical_url" type="url" value="<?= esc($seoCanonicalUrl) ?>" placeholder="<?= esc($pageUrl) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="seo_robots" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Robots</label>
            <select id="seo_robots" name="seo_robots" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="" <?= $seoRobots === '' ? 'selected' : '' ?>>Use Global (<?= esc($defaultRobots) ?>)</option>
              <option value="index, follow" <?= $seoRobots === 'index, follow' ? 'selected' : '' ?>>index, follow</option>
              <option value="noindex, follow" <?= $seoRobots === 'noindex, follow' ? 'selected' : '' ?>>noindex, follow</option>
              <option value="index, nofollow" <?= $seoRobots === 'index, nofollow' ? 'selected' : '' ?>>index, nofollow</option>
              <option value="noindex, nofollow" <?= $seoRobots === 'noindex, nofollow' ? 'selected' : '' ?>>noindex, nofollow</option>
            </select>
          </div>
          <div>
            <label for="seo_twitter_card" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Twitter Card</label>
            <select id="seo_twitter_card" name="seo_twitter_card" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="" <?= $seoTwitterCard === '' ? 'selected' : '' ?>>Use Global (<?= esc($defaultTwitterCard) ?>)</option>
              <option value="summary_large_image" <?= $seoTwitterCard === 'summary_large_image' ? 'selected' : '' ?>>summary_large_image</option>
              <option value="summary" <?= $seoTwitterCard === 'summary' ? 'selected' : '' ?>>summary</option>
            </select>
          </div>
        </div>
      </details>

      <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="<?= esc($pageUrl) ?>" target="_blank" rel="noopener" class="text-sm font-medium text-slate-500 transition hover:text-[#C99A30] dark:text-slate-400 dark:hover:text-[#d5ab4a]">
          View page
        </a>
        <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
          Save SEO
        </button>
      </div>
    </div>

    <aside class="space-y-6">
      <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Keyword Checks</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Simple page-level checks based on your focus keyword.</p>
        <div id="seoKeywordChecks" class="mt-5 grid gap-2"></div>
      </section>

      <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Search Preview</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Preview how this page may appear in search results.</p>
        <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/60">
          <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400"><?= esc($pageUrl) ?></p>
          <p id="seoSearchPreviewTitle" class="mt-2 text-lg font-medium leading-snug text-[#1a0dab] dark:text-[#8ab4f8]"></p>
          <p id="seoSearchPreviewDescription" class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300"></p>
        </div>
      </section>

      <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Social Preview</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Preview the shared card using page overrides or inherited defaults.</p>
        <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-800/60">
          <div class="aspect-[1.91/1] bg-slate-100 dark:bg-slate-800">
            <img id="seoSocialPreviewImage" src="<?= esc($seoOgImage !== '' ? media_url($seoOgImage) : media_url($defaultOgImage, '')) ?>" alt="Social preview" class="h-full w-full object-cover <?= ($seoOgImage === '' && $defaultOgImage === '') ? 'hidden' : '' ?>" />
            <div id="seoSocialPreviewEmpty" class="<?= ($seoOgImage === '' && $defaultOgImage === '') ? '' : 'hidden ' ?>flex h-full items-center justify-center text-sm text-slate-400">No social image selected</div>
          </div>
          <div class="space-y-2 border-t border-slate-200 p-4 dark:border-slate-700">
            <p class="text-xs uppercase tracking-[0.18em] text-slate-400"><?= parse_url($pageUrl, PHP_URL_HOST) ?: $pageUrl ?></p>
            <p id="seoSocialPreviewTitle" class="text-base font-semibold leading-snug text-slate-900 dark:text-white"></p>
            <p id="seoSocialPreviewDescription" class="text-sm leading-6 text-slate-500 dark:text-slate-400"></p>
          </div>
        </div>
      </section>
    </aside>
  </form>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'seoEditMediaPickerModal',
  'searchId' => 'seoEditMediaSearch',
  'emptyId' => 'seoEditMediaSearchEmpty',
  'files' => $mediaFiles ?? [],
  'title' => 'Choose SEO Image',
  'description' => 'Select a saved social share image from the media library.',
  'showUploadPanel' => true,
  'uploadToggleId' => 'seoEditMediaUploadToggle',
  'uploadToggleLabelId' => 'seoEditMediaUploadToggleLabel',
  'uploadToggleIconId' => 'seoEditMediaUploadToggleIcon',
  'uploadPanelId' => 'seoEditMediaUploadPanel',
  'uploadInputId' => 'seo_edit_media_file',
]) ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('seoEditMediaPickerModal');
    const searchInput = document.getElementById('seoEditMediaSearch');
    const searchCount = modal ? modal.querySelector('[data-media-picker-count]') : null;
    const searchEmpty = document.getElementById('seoEditMediaSearchEmpty');
    const uploadPanel = document.getElementById('seoEditMediaUploadPanel');
    const uploadToggle = document.getElementById('seoEditMediaUploadToggle');
    const uploadToggleLabel = document.getElementById('seoEditMediaUploadToggleLabel');
    const uploadToggleIcon = document.getElementById('seoEditMediaUploadToggleIcon');
    const uploadForm = uploadPanel ? uploadPanel.querySelector('form') : null;
    const uploadInput = document.getElementById('seo_edit_media_file');
    const uploadFileName = uploadPanel ? uploadPanel.querySelector('[data-file-name]') : null;
    const uploadStatus = uploadPanel ? uploadPanel.querySelector('[data-upload-status]') : null;
    const mediaGrid = modal ? modal.querySelector('[data-media-picker-grid]') : null;
    const mediaEmptyState = modal ? modal.querySelector('[data-media-picker-empty]') : null;
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    const fallbackOgImage = <?= json_encode($defaultOgImage !== '' ? media_url($defaultOgImage) : '') ?>;
    const keywordChecks = document.getElementById('seoKeywordChecks');
    let activeMediaTarget = null;

    function currentTitle() {
      return document.getElementById('seo_title')?.value.trim() || <?= json_encode((string) ($defaultTitle ?? '')) ?> || 'Untitled page';
    }

    function currentDescription() {
      return document.getElementById('seo_description')?.value.trim() || <?= json_encode((string) ($defaultDescription ?? '')) ?> || 'No description provided.';
    }

    function currentOgTitle() {
      return document.getElementById('seo_og_title')?.value.trim() || currentTitle();
    }

    function currentOgDescription() {
      return document.getElementById('seo_og_description')?.value.trim() || currentDescription();
    }

    function currentOgImage() {
      const path = document.getElementById('seo_og_image')?.value.trim() || '';
      return path ? baseUrl + path.replace(/^\/+/, '') : fallbackOgImage;
    }

    function updatePreviews() {
      const searchTitle = document.getElementById('seoSearchPreviewTitle');
      const searchDescription = document.getElementById('seoSearchPreviewDescription');
      const socialTitle = document.getElementById('seoSocialPreviewTitle');
      const socialDescription = document.getElementById('seoSocialPreviewDescription');
      const socialImage = document.getElementById('seoSocialPreviewImage');
      const socialEmpty = document.getElementById('seoSocialPreviewEmpty');
      const ogImage = currentOgImage();

      if (searchTitle) searchTitle.textContent = currentTitle();
      if (searchDescription) searchDescription.textContent = currentDescription();
      if (socialTitle) socialTitle.textContent = currentOgTitle();
      if (socialDescription) socialDescription.textContent = currentOgDescription();
      if (socialImage) {
        socialImage.src = ogImage || '';
        socialImage.classList.toggle('hidden', !ogImage);
      }
      if (socialEmpty) socialEmpty.classList.toggle('hidden', !!ogImage);
    }

    function updateKeywordChecks() {
      if (!keywordChecks) return;
      const keyword = (document.getElementById('seo_focus_keyword')?.value || '').trim().toLowerCase();
      const title = (document.getElementById('seo_title')?.value || '').trim().toLowerCase();
      const description = (document.getElementById('seo_description')?.value || '').trim().toLowerCase();
      const ogTitle = (document.getElementById('seo_og_title')?.value || '').trim().toLowerCase();

      if (keyword === '') {
        keywordChecks.innerHTML = '<div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-300">Add a focus keyword to enable lightweight SEO checks.</div>';
        return;
      }

      const checks = [
        { label: 'Keyword appears in SEO title', ok: title.includes(keyword) },
        { label: 'Keyword appears in meta description', ok: description.includes(keyword) },
        { label: 'Keyword appears in OG title', ok: ogTitle === '' || ogTitle.includes(keyword) },
      ];

      keywordChecks.innerHTML = checks.map(function (check) {
        const tone = check.ok
          ? 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300'
          : 'border-rose-200 bg-rose-50 text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300';
        const status = check.ok ? 'Good' : 'Missing';
        return '<div class="rounded-2xl border px-4 py-3 text-sm ' + tone + '"><div class="flex items-center justify-between gap-3"><span>' + check.label + '</span><span class="text-xs font-semibold uppercase tracking-[0.16em]">' + status + '</span></div></div>';
      }).join('');
    }

    function updateCounters() {
      document.querySelectorAll('[data-char-count-for]').forEach(function (counter) {
        const target = document.getElementById(counter.dataset.charCountFor);
        counter.textContent = String(target ? target.value.length : 0);
      });
    }

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
      updatePreviews();
    }

    function setModal(open) {
      if (!modal) return;
      modal.classList.toggle('hidden', !open);
      modal.classList.toggle('flex', open);
      document.body.classList.toggle('overflow-hidden', open);
    }

    function setUploadPanel(open) {
      if (!uploadPanel || !uploadToggle) return;
      uploadPanel.style.maxHeight = open ? '22rem' : '0px';
      uploadPanel.style.opacity = open ? '1' : '0';
      uploadPanel.style.transform = open ? 'translateY(0)' : 'translateY(-12px)';
      uploadPanel.style.pointerEvents = open ? 'auto' : 'none';
      uploadToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (uploadToggleLabel) uploadToggleLabel.textContent = open ? 'Hide Upload' : 'Open Upload';
      if (uploadToggleIcon) uploadToggleIcon.classList.toggle('rotate-45', open);
    }

    function filterCards() {
      const cards = Array.from(document.querySelectorAll('#seoEditMediaPickerModal [data-media-picker-card]'));
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
      if (!mediaGrid || !Array.isArray(files) || files.length === 0) return;
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

    document.querySelectorAll('#seo_focus_keyword, #seo_title, #seo_description, #seo_og_title, #seo_og_description').forEach(function (field) {
      field.addEventListener('input', function () {
        updateCounters();
        updatePreviews();
        updateKeywordChecks();
      });
    });

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

    document.querySelectorAll('#seoEditMediaPickerModal [data-select-media-path]').forEach(function (button) {
      bindMediaCardSelection(button);
    });

    document.querySelectorAll('#seoEditMediaPickerModal [data-close-media-picker]').forEach(function (button) {
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

    updateCounters();
    updatePreviews();
    updateKeywordChecks();
  });
</script>
