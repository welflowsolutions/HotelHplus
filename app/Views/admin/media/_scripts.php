<script>
	  document.addEventListener('DOMContentLoaded', function () {
	    const csrfInput = document.querySelector('input[name="<?= esc(csrf_token()) ?>"]');
	    const canDeleteMedia = <?= service('adminPermissions')->canDeleteData() ? 'true' : 'false' ?>;

    function syncCsrf(payload) {
      if (!payload || !payload.csrf) return;
      const hash = payload.csrf.hash || '';
      if (!hash) return;

      document.querySelectorAll('input[name="<?= esc(csrf_token()) ?>"]').forEach(function (input) {
        input.value = hash;
      });
    }

    function showToast(message, type) {
      if (!message) return;

      let container = document.getElementById('toastContainer');
      if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'fixed left-4 right-4 top-4 z-[1000] flex flex-col gap-3 pointer-events-none sm:left-auto sm:w-full sm:max-w-sm';
        document.body.appendChild(container);
      }

      const cls = type === 'error'
        ? 'border-red-200 bg-red-50 text-red-800'
        : 'border-green-200 bg-green-50 text-green-800';

      const toast = document.createElement('div');
      toast.className = 'admin-toast pointer-events-auto rounded-2xl border ' + cls + ' shadow-xl';
      toast.innerHTML = '<div class="flex items-start gap-3 px-4 py-3"><div class="min-w-0 flex-1"><p class="text-sm font-semibold"></p><p class="mt-1 text-sm leading-5"></p></div><button type="button" class="text-current/70 hover:text-current" aria-label="Dismiss"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></div>';
      toast.querySelector('p.text-sm.font-semibold').textContent = type === 'error' ? 'Error' : 'Success';
      toast.querySelector('p.mt-1').textContent = message;
      toast.querySelector('button').addEventListener('click', function () {
        window.dismissToast(toast);
      });
      container.appendChild(toast);
      window.setTimeout(function () {
        toast.classList.add('show');
      }, 30);
      window.setTimeout(function () {
        window.dismissToast(toast);
      }, 4200);
    }

    function mediaCard(file) {
      const article = document.createElement('article');
      article.dataset.mediaCard = '';
      article.dataset.mediaId = file.id || '';
      article.dataset.mediaUrl = file.url || '';
      article.dataset.mediaName = file.original_name || file.file_name || 'Media file';
      article.dataset.mediaPath = file.path || '';
      article.dataset.mediaAlt = file.alt_text || '';
      article.dataset.mediaWidth = file.width || '';
      article.dataset.mediaHeight = file.height || '';
      article.dataset.mediaMime = file.mime_type || '';
      article.dataset.mediaWebpEnabled = file.webp_enabled ? '1' : '0';
      article.dataset.mediaWebpConvertible = file.webp_convertible ? '1' : '0';
      article.className = 'overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-slate-800 dark:bg-slate-900';
	      article.innerHTML = '<button type="button" data-open-media-editor class="flex w-full aspect-[4/3] items-center justify-center bg-slate-100 text-left dark:bg-slate-800"><img class="h-full w-full object-contain p-4" /></button><div class="space-y-3 p-4"><div><button type="button" data-open-media-editor-title class="block w-full truncate text-left text-sm font-semibold text-slate-900 transition hover:text-[#C99A30] dark:text-white dark:hover:text-[#E2B44A]"></button><p class="mt-1 truncate text-xs text-slate-400"></p><p data-media-alt-preview class="mt-2 hidden line-clamp-2 text-xs text-slate-500 dark:text-slate-400"></p></div><div class="flex flex-wrap items-center gap-2"><button type="button" data-open-media-editor class="rounded-xl border border-[#C99A30]/40 bg-[#C99A30]/10 px-3 py-2 text-xs font-semibold text-[#C99A30] transition hover:bg-[#C99A30] hover:text-slate-950">Edit</button><button type="button" data-copy-media-path="" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Copy Path</button>' + (canDeleteMedia ? '<form method="POST" data-confirm-delete-form data-confirm-delete-ajax="true" data-delete-label="this image"><input type="hidden" name="<?= esc(csrf_token()) ?>" value=""><button type="submit" class="rounded-xl border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 dark:border-red-900/60 dark:text-red-300 dark:hover:bg-red-950/30">Delete</button></form>' : '') + '</div></div>';
      article.querySelector('img').src = file.url || '';
      article.querySelector('img').alt = file.alt_text || file.original_name || 'Media file';
      article.querySelector('[data-open-media-editor-title]').textContent = file.original_name || file.file_name || 'Media file';
      article.querySelector('p.mt-1').textContent = file.path || '';
      article.querySelector('[data-copy-media-path]').dataset.copyMediaPath = file.path || '';
      const altPreview = article.querySelector('[data-media-alt-preview]');
      if (file.alt_text) {
        altPreview.textContent = file.alt_text;
        altPreview.classList.remove('hidden');
      }
	      const deleteForm = article.querySelector('[data-confirm-delete-form]');
	      if (deleteForm) {
	        deleteForm.action = <?= json_encode(rtrim(base_url(), '/') . '/admin/media/delete/') ?> + file.id;
	        deleteForm.dataset.deleteLabel = file.original_name || 'this image';
	        deleteForm.querySelector('input[name="<?= esc(csrf_token()) ?>"]').value = csrfInput ? csrfInput.value : '';
	      }

      return article;
    }

    function appendFiles(files) {
      const mediaGrid = document.querySelector('[data-media-grid]');
      const emptyState = document.querySelector('[data-media-empty-state]');
      if (!mediaGrid) return;

      mediaGrid.classList.remove('hidden');
      (files || []).forEach(function (file) {
        mediaGrid.prepend(mediaCard(file));
      });

      if (emptyState && (files || []).length) {
        emptyState.classList.add('hidden');
      }

      document.dispatchEvent(new CustomEvent('media:cards-updated'));
    }

    function removeMediaCard(form) {
      const card = form.closest('[data-media-card]');
      if (!card) return;

      card.remove();
      document.dispatchEvent(new CustomEvent('media:cards-updated'));
    }

    document.querySelectorAll('[data-panel-toggle]').forEach(function (button) {
      const targetId = button.dataset.panelTarget;
      const panel = targetId ? document.getElementById(targetId) : null;
      const label = button.querySelector('[data-panel-toggle-label]');
      const icon = button.querySelector('[data-panel-toggle-icon]');
      if (!panel) return;

      function setOpen(open) {
        button.setAttribute('aria-expanded', open ? 'true' : 'false');
        panel.setAttribute('aria-hidden', open ? 'false' : 'true');
        panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '0px';
        panel.style.opacity = open ? '1' : '0';
        panel.style.transform = open ? 'translateY(0)' : 'translateY(-12px)';
        panel.style.pointerEvents = open ? 'auto' : 'none';
        if (label) {
          label.textContent = open ? (button.dataset.closeLabel || 'Close') : (button.dataset.openLabel || 'Open');
        }
        if (icon) {
          icon.style.transform = open ? 'rotate(45deg)' : '';
        }
      }

      setOpen(false);

      button.addEventListener('click', function () {
        const open = button.getAttribute('aria-expanded') !== 'true';
        setOpen(open);
      });

      window.addEventListener('resize', function () {
        if (button.getAttribute('aria-expanded') === 'true') {
          panel.style.maxHeight = panel.scrollHeight + 'px';
        }
      });
    });

    document.querySelectorAll('[data-drop-zone]').forEach(function (zone) {
      const input = zone.querySelector('[data-file-input]');
      const fileName = zone.querySelector('[data-file-name]');
      const form = zone.closest('form');
      const status = form ? form.querySelector('[data-upload-status]') : null;
      let uploading = false;
      if (!input || !form) return;

      function syncName(files) {
        if (!fileName) return;
        const list = Array.from(files || input.files || []);
        if (!list.length) {
          fileName.textContent = '';
          return;
        }

        if (list.length === 1) {
          fileName.textContent = list[0].name;
          return;
        }

        fileName.textContent = list.length + ' files selected: ' + list.slice(0, 3).map(function (file) {
          return file.name;
        }).join(', ') + (list.length > 3 ? '...' : '');
      }

      async function uploadFiles(files) {
        const list = Array.from(files || []);
        if (!list.length || uploading) return;

        uploading = true;
        syncName(list);
        if (status) status.textContent = 'Uploading...';

        const body = new FormData();
        Array.from(form.elements).forEach(function (element) {
          if (!element.name || element === input || element.disabled) return;
          if ((element.type === 'checkbox' || element.type === 'radio') && !element.checked) return;
          body.append(element.name, element.value);
        });
        list.forEach(function (file) {
          body.append(input.name || 'media_files[]', file);
        });

        try {
          const response = await fetch(form.action, {
            method: 'POST',
            body,
            credentials: 'same-origin',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            }
          });

          const contentType = response.headers.get('content-type') || '';
          const payload = contentType.includes('application/json')
            ? await response.json()
            : { success: false, message: 'Upload failed. Please refresh and try again.' };

          syncCsrf(payload);

          if (!response.ok || !payload.success) {
            throw new Error(payload.message || 'Upload failed.');
          }

          appendFiles(payload.files || []);
          showToast(payload.message || 'Images uploaded successfully.', 'success');
          input.value = '';
          syncName();
          if (status) status.textContent = 'Upload starts automatically after browse or drop.';
        } catch (error) {
          input.value = '';
          syncName();
          if (status) status.textContent = 'Upload failed. Try again.';
          showToast(error.message || 'Upload failed.', 'error');
        } finally {
          uploading = false;
        }
      }

      zone.addEventListener('click', function (event) {
        if (event.target.closest('[data-file-input]')) return;
        event.preventDefault();
        input.click();
      });

      input.addEventListener('click', function () {
        input.value = '';
        syncName();
        if (status) status.textContent = 'Upload starts automatically after browse or drop.';
      });

      input.addEventListener('change', function () {
        uploadFiles(input.files);
      });

      zone.addEventListener('dragover', function (event) {
        event.preventDefault();
        zone.classList.add('border-[#C99A30]', 'bg-[#C99A30]/5');
      });

      zone.addEventListener('dragleave', function () {
        zone.classList.remove('border-[#C99A30]', 'bg-[#C99A30]/5');
      });

      zone.addEventListener('drop', function (event) {
        event.preventDefault();
        zone.classList.remove('border-[#C99A30]', 'bg-[#C99A30]/5');
        if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files.length) {
          uploadFiles(event.dataTransfer.files);
        }
      });
    });

    const searchInput = document.querySelector('[data-media-search]');
    const searchCount = document.querySelector('[data-media-search-count]');
    const mediaEmpty = document.querySelector('[data-media-empty-state]');
    const mediaSearchEmpty = document.querySelector('[data-media-search-empty]');
    const modal = document.getElementById('mediaEditorModal');
    const modalImage = document.getElementById('mediaEditorImage');
    const modalName = document.getElementById('mediaEditorName');
    const modalPath = document.getElementById('mediaEditorPath');
    const modalMeta = document.getElementById('mediaEditorMeta');
    const modalAlt = document.getElementById('mediaEditorAlt');
    const modalUseWebp = document.getElementById('mediaEditorUseWebp');
    const modalWebpHint = document.getElementById('mediaEditorWebpHint');
    const closeButtons = document.querySelectorAll('[data-close-media-editor]');
    let activeCard = null;
    let activeMedia = null;

    function cardData(article) {
      return {
        id: article.dataset.mediaId || '',
        url: article.dataset.mediaUrl || '',
        name: article.dataset.mediaName || '',
        path: article.dataset.mediaPath || '',
        altText: article.dataset.mediaAlt || '',
        width: parseInt(article.dataset.mediaWidth || '0', 10) || null,
        height: parseInt(article.dataset.mediaHeight || '0', 10) || null,
        mimeType: article.dataset.mediaMime || '',
        webpEnabled: article.dataset.mediaWebpEnabled === '1',
        webpConvertible: article.dataset.mediaWebpConvertible === '1',
      };
    }

    function updateCard(article, file) {
      article.dataset.mediaId = file.id || '';
      article.dataset.mediaUrl = file.url || '';
      article.dataset.mediaName = file.original_name || file.file_name || '';
      article.dataset.mediaPath = file.path || '';
      article.dataset.mediaAlt = file.alt_text || '';
      article.dataset.mediaWidth = file.width || '';
      article.dataset.mediaHeight = file.height || '';
      article.dataset.mediaMime = file.mime_type || '';
      article.dataset.mediaWebpEnabled = file.webp_enabled ? '1' : '0';
      article.dataset.mediaWebpConvertible = file.webp_convertible ? '1' : '0';

      const preview = article.querySelector('img');
      if (preview) {
        preview.src = file.url || '';
        preview.alt = file.alt_text || file.original_name || 'Media file';
      }

      const title = article.querySelector('[data-open-media-editor-title], button[data-open-media-editor].block');
      if (title) title.textContent = file.original_name || file.file_name || 'Media file';

      const path = article.querySelector('p.mt-1');
      if (path) path.textContent = file.path || '';

      const altPreview = article.querySelector('[data-media-alt-preview]');
      if (altPreview) {
        altPreview.textContent = file.alt_text || '';
        altPreview.classList.toggle('hidden', !file.alt_text);
      }
    }

    function filterCards() {
      const cards = Array.from(document.querySelectorAll('[data-media-card]'));
      const query = (searchInput?.value || '').trim().toLowerCase();
      let visible = 0;

      cards.forEach(function (card) {
        const haystack = [card.dataset.mediaName, card.dataset.mediaPath, card.dataset.mediaAlt].join(' ').toLowerCase();
        const match = query === '' || haystack.includes(query);
        card.hidden = !match;
        if (match) visible += 1;
      });

      if (searchCount) searchCount.textContent = String(visible);
      if (mediaSearchEmpty) mediaSearchEmpty.classList.toggle('hidden', !(query !== '' && visible === 0));
      const hasCards = cards.length !== 0;
      if (mediaEmpty) mediaEmpty.classList.toggle('hidden', hasCards);
      const mediaGrid = document.querySelector('[data-media-grid]');
      if (mediaGrid) mediaGrid.classList.toggle('hidden', !hasCards);
    }

    function closeEditor() {
      activeCard = null;
      activeMedia = null;
      modal.classList.add('hidden');
      modal.classList.remove('show');
      document.body.classList.remove('overflow-hidden');
      modalImage.src = '';
    }

    function setEditorMeta(media) {
      const sizeText = media.width && media.height ? media.width + ' x ' + media.height : 'Dimensions unavailable';
      const formatText = media.mimeType ? media.mimeType.replace('image/', '').toUpperCase() : 'Unknown';
      modalMeta.textContent = sizeText + ' • ' + formatText + (media.webpEnabled ? ' • WebP active' : ' • Original active');
    }

    function openEditor(article) {
      activeCard = article;
      activeMedia = cardData(article);
      modal.classList.remove('hidden');
      modal.classList.add('show');
      document.body.classList.add('overflow-hidden');
      modalName.textContent = activeMedia.name;
      modalPath.textContent = activeMedia.path;
      modalAlt.value = activeMedia.altText;
      modalUseWebp.checked = !!activeMedia.webpEnabled;
      modalUseWebp.disabled = !activeMedia.webpConvertible;
      modalWebpHint.textContent = activeMedia.webpConvertible
        ? 'Generate and use a WebP version for supported frontend rendering.'
        : (activeMedia.webpEnabled ? 'This file already uses WebP.' : 'This file type cannot be converted to WebP.');
      setEditorMeta(activeMedia);
      modalImage.src = activeMedia.url;
    }

    async function saveChanges(event) {
      event.preventDefault();
      if (!activeMedia) return;

      const body = new FormData();
      body.append(<?= json_encode(csrf_token()) ?>, csrfInput ? csrfInput.value : '');
      body.append('alt_text', modalAlt.value.trim());
      body.append('use_webp', (modalUseWebp.checked && !modalUseWebp.disabled) ? '1' : '0');

      const response = await fetch(<?= json_encode(rtrim(base_url(), '/') . '/admin/media/update/') ?> + activeMedia.id, {
        method: 'POST',
        body,
        credentials: 'same-origin',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      });

      const contentType = response.headers.get('content-type') || '';
      const payload = contentType.includes('application/json')
        ? await response.json()
        : { success: false, message: 'Your session token expired. Please refresh the page and try again.' };

      syncCsrf(payload);

      if (!response.ok || !payload.success) {
        throw new Error(payload.message || 'Could not save media changes.');
      }

      if (payload.file && activeCard) {
        updateCard(activeCard, payload.file);
        activeMedia = cardData(activeCard);
        modalPath.textContent = activeMedia.path;
        modalUseWebp.checked = !!activeMedia.webpEnabled;
        setEditorMeta(activeMedia);
        modalImage.src = activeMedia.url;
      }

      showToast(payload.message || 'Media updated successfully.', 'success');
    }

    if (searchInput) {
      searchInput.addEventListener('input', filterCards);
      filterCards();
    }

    document.addEventListener('click', function (event) {
      const trigger = event.target.closest('[data-open-media-editor], [data-open-media-editor-title]');
      if (trigger) {
        const article = trigger.closest('[data-media-card]');
        if (article) openEditor(article);
      }

      if (event.target === modal) closeEditor();
    });

    closeButtons.forEach(function (button) {
      button.addEventListener('click', closeEditor);
    });

    document.getElementById('mediaEditorForm').addEventListener('submit', function (event) {
      saveChanges(event).catch(function (error) {
        showToast(error.message || 'Could not save media changes.', 'error');
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && modal.classList.contains('show')) {
        closeEditor();
      }
    });

    window.handleConfirmDeleteForm = async function (form) {
      if (!(form instanceof HTMLFormElement)) return;

      const body = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body,
          credentials: 'same-origin',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        const contentType = response.headers.get('content-type') || '';
        const payload = contentType.includes('application/json')
          ? await response.json()
          : { success: false, message: 'Delete failed. Please refresh and try again.' };

        syncCsrf(payload);

        if (!response.ok || !payload.success) {
          throw new Error(payload.message || 'Delete failed.');
        }

        removeMediaCard(form);
        showToast(payload.message || 'Image deleted successfully.', 'success');
        filterCards();
      } catch (error) {
        showToast(error.message || 'Delete failed.', 'error');
      }
    };

    document.addEventListener('click', function (event) {
      const copyButton = event.target.closest('[data-copy-media-path]');
      if (!copyButton) return;

      const path = copyButton.dataset.copyMediaPath || '';
      if (!path) return;

      navigator.clipboard.writeText(path).then(function () {
        showToast('Media path copied.', 'success');
      }).catch(function () {
        window.prompt('Copy media path', path);
      });
    });
  });
</script>
