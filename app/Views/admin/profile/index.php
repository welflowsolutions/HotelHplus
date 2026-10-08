<?php
$activePanel = $activePanel ?? 'info';
$name        = old('name', $user['name'] ?? '');
$username    = $user['username'] ?? '';
$phone       = old('phone', $user['phone'] ?? '');
$photo       = $user['profile_photo'] ?? null;
$photoUrl    = $photo ? media_url($photo) : null;
$initials    = strtoupper(substr($user['name'] ?? 'A', 0, 1));
$mediaFiles  = $mediaFiles ?? [];

$emailChangedAt     = $user['email_changed_at'] ?? null;
$nextEmailChangeAt  = $emailChangedAt ? strtotime($emailChangedAt . ' +30 days') : 0;
$canChangeEmail     = ! $nextEmailChangeAt || $nextEmailChangeAt <= time();
$nextEmailChangeText = $nextEmailChangeAt ? date('d M Y, h:i A', $nextEmailChangeAt) : '';
$email              = $canChangeEmail ? old('email', $user['email'] ?? '') : ($user['email'] ?? '');
$readonlyInputClass = ' cursor-not-allowed border-slate-200 bg-slate-100 text-slate-500 dark:border-slate-700 dark:bg-slate-800/70 dark:text-slate-400';
$normalInputClass   = ' border-slate-200 bg-slate-50 text-slate-900 focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white';
$passwordErrors     = is_array($passwordErrors ?? null) ? array_filter($passwordErrors) : [];
$passwordInputClass = 'w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white';
$passwordErrorState = ' border-red-400/80 focus:border-red-400 focus:ring-red-500/10 dark:border-red-500/70 dark:bg-slate-800';
?>

<div class="space-y-6">
  <div>
    <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">Account</p>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Profile</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage your personal account details and password.</p>
  </div>

  <div class="grid gap-6 xl:grid-cols-[290px_minmax(0,1fr)]">
    <aside class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="mb-5 flex items-center gap-4 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/70">
        <div id="profileSidebarAvatar" class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-[#D4AE50] to-[#A97919] text-lg font-bold text-white">
          <?php if ($photoUrl): ?>
            <img src="<?= $photoUrl ?>" alt="<?= esc($name) ?>" class="h-full w-full object-cover" />
          <?php else: ?>
            <?= esc($initials) ?>
          <?php endif; ?>
        </div>
        <div class="min-w-0">
          <p class="truncate text-sm font-semibold text-slate-900 dark:text-white"><?= esc($name) ?></p>
          <p class="truncate text-xs text-slate-500 dark:text-slate-400">@<?= esc($username) ?></p>
          <p class="mt-1 inline-flex rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.18em] text-amber-700 dark:bg-amber-900/20 dark:text-amber-300"><?= esc($user['usertype'] ?? 'admin') ?></p>
        </div>
      </div>

      <nav class="space-y-2">
        <button type="button" data-profile-nav="info" class="profile-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          Profile Info
        </button>
        <button type="button" data-profile-nav="password" class="profile-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
          Change Password
        </button>
      </nav>
    </aside>

    <div class="min-w-0">
      <form id="profile-panel-info" action="<?= base_url('admin/profile/update') ?>" method="POST" enctype="multipart/form-data"
            class="profile-page-panel rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Profile Info</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Update your name, contact details and profile photo.</p>
          </div>
        </div>

        <div class="space-y-5">
          <div>
            <label class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-300">Profile Photo</label>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
              <div id="profilePageAvatar" class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 text-2xl font-bold text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <?php if ($photoUrl): ?>
                  <img src="<?= $photoUrl ?>" alt="<?= esc($name) ?>" class="h-full w-full object-cover" />
                <?php else: ?>
                  <?= esc($initials) ?>
                <?php endif; ?>
              </div>
              <div>
                <input id="profilePhotoPathInput" name="profile_photo_path" type="hidden" value="<?= esc($photo ?? '') ?>" />
                <div class="flex flex-wrap gap-2">
                  <button type="button" data-open-media-picker="profile_photo" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">
                    Choose from Media
                  </button>
                  <button type="button" data-clear-media="profile_photo" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Clear
                  </button>
                </div>
                <p class="mt-2 text-xs text-slate-400">Choose an image from the media library.</p>
              </div>
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label for="name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
              <input id="name" name="name" type="text" value="<?= esc($name) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="username" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
              <input id="username" name="username" type="text" value="<?= esc($username) ?>" readonly aria-readonly="true" class="w-full rounded-2xl px-4 py-3 text-sm outline-none transition<?= $readonlyInputClass ?>" />
              <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Username is fixed for login continuity and audit records.</p>
            </div>
            <div>
              <label for="email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
              <input id="email" name="email" type="email" value="<?= esc($email) ?>"<?= $canChangeEmail ? '' : ' readonly aria-readonly="true"' ?> class="w-full rounded-2xl px-4 py-3 text-sm outline-none transition<?= $canChangeEmail ? $normalInputClass : $readonlyInputClass ?>" />
              <?php if ($canChangeEmail): ?>
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Email can be changed once every 30 days.</p>
              <?php else: ?>
                <p class="mt-2 text-xs text-amber-700 dark:text-amber-300">Email can be changed again after <?= esc($nextEmailChangeText) ?>.</p>
              <?php endif; ?>
            </div>
            <div>
              <label for="phone" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
              <input id="phone" name="phone" type="text" value="<?= esc($phone) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
          </div>

          <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-4 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-400">
            Your role is <span class="font-semibold text-slate-700 dark:text-slate-200"><?= esc($user['usertype'] ?? 'admin') ?></span>. This page updates only your personal account information.
          </div>

          <div class="flex justify-end pt-2">
            <button type="submit" class="rounded-2xl bg-[#0D1117] px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
              Save Profile
            </button>
          </div>
        </div>
      </form>

      <form id="profile-panel-password" action="<?= base_url('admin/profile/password') ?>" method="POST" novalidate
            class="profile-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Change Password</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Use your current password, then choose a stronger new one.</p>
          </div>
        </div>

        <div class="grid max-w-xl gap-4">
          <div>
            <label for="current_password" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Current Password</label>
            <input id="current_password" name="current_password" type="password" required autocomplete="current-password" class="<?= $passwordInputClass . (! empty($passwordErrors['current_password']) ? $passwordErrorState : '') ?>" />
            <p id="current_password_error" class="mt-1.5 <?= ! empty($passwordErrors['current_password']) ? '' : 'hidden ' ?>text-xs font-medium text-red-500 dark:text-red-400"><?= esc($passwordErrors['current_password'] ?? '') ?></p>
          </div>
          <div>
            <label for="new_password" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">New Password</label>
            <input id="new_password" name="new_password" type="password" required minlength="8" autocomplete="new-password" class="<?= $passwordInputClass . (! empty($passwordErrors['new_password']) ? $passwordErrorState : '') ?>" />
            <p id="new_password_error" class="mt-1.5 <?= ! empty($passwordErrors['new_password']) ? '' : 'hidden ' ?>text-xs font-medium text-red-500 dark:text-red-400"><?= esc($passwordErrors['new_password'] ?? '') ?></p>
          </div>
          <div>
            <label for="new_password_confirmation" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm New Password</label>
            <input id="new_password_confirmation" name="new_password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="<?= $passwordInputClass . (! empty($passwordErrors['new_password_confirmation']) ? $passwordErrorState : '') ?>" />
            <p id="new_password_confirmation_error" class="mt-1.5 <?= ! empty($passwordErrors['new_password_confirmation']) ? '' : 'hidden ' ?>text-xs font-medium text-red-500 dark:text-red-400"><?= esc($passwordErrors['new_password_confirmation'] ?? '') ?></p>
          </div>
          <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-4 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-400">
            Minimum 8 characters. Use a mix of letters, numbers, and symbols if possible.
          </div>
          <div class="flex justify-end pt-2">
            <button type="submit" class="rounded-2xl bg-[#0D1117] px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
              Update Password
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'profileMediaPickerModal',
  'searchId' => 'profileMediaSearch',
  'emptyId' => 'profileMediaSearchEmpty',
  'files' => $mediaFiles,
  'title' => 'Choose Profile Photo',
  'description' => 'Select a saved image from the media library for this admin account.',
  'showUploadPanel' => true,
  'uploadToggleId' => 'profileMediaUploadToggle',
  'uploadToggleLabelId' => 'profileMediaUploadToggleLabel',
  'uploadToggleIconId' => 'profileMediaUploadToggleIcon',
  'uploadPanelId' => 'profileMediaUploadPanel',
  'uploadInputId' => 'profile_settings_media_file',
]) ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const activePanel = <?= json_encode($activePanel) ?> || 'info';
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    const mediaPickerModal = document.getElementById('profileMediaPickerModal');
    const mediaSearchInput = document.getElementById('profileMediaSearch');
    const mediaSearchCount = mediaPickerModal ? mediaPickerModal.querySelector('[data-media-picker-count]') : null;
    const mediaSearchEmpty = document.getElementById('profileMediaSearchEmpty');
    const profileInitials = <?= json_encode(esc($initials)) ?>;
    const uploadPanel = document.getElementById('profileMediaUploadPanel');
    const uploadToggle = document.getElementById('profileMediaUploadToggle');
    const uploadToggleLabel = document.getElementById('profileMediaUploadToggleLabel');
    const uploadToggleIcon = document.getElementById('profileMediaUploadToggleIcon');
    const uploadForm = uploadPanel ? uploadPanel.querySelector('form') : null;
    const uploadInput = document.getElementById('profile_settings_media_file');
    const uploadFileName = uploadPanel ? uploadPanel.querySelector('[data-file-name]') : null;
    const uploadStatus = uploadPanel ? uploadPanel.querySelector('[data-upload-status]') : null;
    const mediaGrid = mediaPickerModal ? mediaPickerModal.querySelector('[data-media-picker-grid]') : null;
    const mediaEmptyState = mediaPickerModal ? mediaPickerModal.querySelector('[data-media-picker-empty]') : null;
    const passwordForm = document.getElementById('profile-panel-password');
    let activeMediaTarget = null;

    function showProfilePanel(panelName) {
      document.querySelectorAll('.profile-page-panel').forEach(function (panel) {
        panel.classList.add('hidden');
      });

      document.querySelectorAll('.profile-nav-item').forEach(function (button) {
        button.classList.remove('bg-gradient-to-r', 'from-[#F59E0B]', 'to-[#FB923C]', 'text-white', 'shadow-lg');
        button.classList.add('text-slate-600', 'hover:bg-slate-50', 'dark:text-slate-300', 'dark:hover:bg-slate-800');
      });

      const panel = document.getElementById('profile-panel-' + panelName);
      const nav = document.querySelector('[data-profile-nav="' + panelName + '"]');

      if (!panel || !nav) {
        return showProfilePanel('info');
      }

      panel.classList.remove('hidden');
      nav.classList.add('bg-gradient-to-r', 'from-[#F59E0B]', 'to-[#FB923C]', 'text-white', 'shadow-lg');
      nav.classList.remove('text-slate-600', 'hover:bg-slate-50', 'dark:text-slate-300', 'dark:hover:bg-slate-800');
    }

    document.querySelectorAll('[data-profile-nav]').forEach(function (button) {
      button.addEventListener('click', function () {
        showProfilePanel(button.getAttribute('data-profile-nav'));
      });
    });

    function setProfileMedia(path) {
      const pathInput = document.getElementById('profilePhotoPathInput');
      if (pathInput) pathInput.value = path;

      ['profilePageAvatar', 'profileSidebarAvatar'].forEach(function (id) {
        const container = document.getElementById(id);
        if (!container) return;

        if (path) {
          container.innerHTML = '<img src="' + baseUrl + path.replace(/^\/+/, '') + '" alt="Profile preview" class="h-full w-full object-cover" />';
        } else {
          container.textContent = profileInitials;
        }
      });
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

      if (uploadToggleLabel) {
        uploadToggleLabel.textContent = open ? 'Hide Upload' : 'Open Upload';
      }

      if (uploadToggleIcon) {
        uploadToggleIcon.classList.toggle('rotate-45', open);
      }
    }

    function setMediaPicker(open) {
      if (!mediaPickerModal) return;
      mediaPickerModal.classList.toggle('hidden', !open);
      mediaPickerModal.classList.toggle('flex', open);
      document.body.classList.toggle('overflow-hidden', open);
    }

    function setPasswordFieldError(fieldId, message) {
      const input = document.getElementById(fieldId);
      const error = document.getElementById(fieldId + '_error');

      if (!input || !error) {
        return;
      }

      input.classList.remove('border-red-300', 'bg-red-50/70', 'focus:border-red-400', 'focus:ring-red-500/10', 'dark:border-red-500/60', 'dark:bg-red-950/20');

      if (message) {
        input.classList.add('border-red-300', 'bg-red-50/70', 'focus:border-red-400', 'focus:ring-red-500/10', 'dark:border-red-500/60', 'dark:bg-red-950/20');
        error.textContent = message;
        error.classList.remove('hidden');
      } else {
        error.textContent = '';
        error.classList.add('hidden');
      }
    }

    function validatePasswordForm() {
      if (!passwordForm) {
        return true;
      }

      const currentPassword = document.getElementById('current_password');
      const newPassword = document.getElementById('new_password');
      const confirmPassword = document.getElementById('new_password_confirmation');
      let isValid = true;

      setPasswordFieldError('current_password', '');
      setPasswordFieldError('new_password', '');
      setPasswordFieldError('new_password_confirmation', '');

      if (!currentPassword.value.trim()) {
        setPasswordFieldError('current_password', 'Current password is required.');
        isValid = false;
      }

      if (!newPassword.value.trim()) {
        setPasswordFieldError('new_password', 'New password is required.');
        isValid = false;
      } else if (newPassword.value.length < 8) {
        setPasswordFieldError('new_password', 'New password must be at least 8 characters.');
        isValid = false;
      }

      if (!confirmPassword.value.trim()) {
        setPasswordFieldError('new_password_confirmation', 'Please confirm your new password.');
        isValid = false;
      } else if (confirmPassword.value.length < 8) {
        setPasswordFieldError('new_password_confirmation', 'Confirmation must be at least 8 characters.');
        isValid = false;
      } else if (newPassword.value !== confirmPassword.value) {
        setPasswordFieldError('new_password_confirmation', 'New password and confirm password must match.');
        isValid = false;
      }

      return isValid;
    }

    function filterMediaCards() {
      const cards = Array.from(document.querySelectorAll('#profileMediaPickerModal [data-media-picker-card]'));
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

    function bindMediaCardSelection(card) {
      card.addEventListener('click', function () {
        if (activeMediaTarget === 'profile_photo') {
          setProfileMedia(card.dataset.selectMediaPath || '');
          setMediaPicker(false);
        }
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
        card.innerHTML = ''
          + '<span class="flex aspect-[4/3] items-center justify-center bg-slate-100 dark:bg-slate-800">'
          + '<img src="' + (file.url || '') + '" alt="' + (file.alt_text || file.original_name || 'Media image') + '" class="h-full w-full object-contain p-4" />'
          + '</span>'
          + '<span class="block border-t border-slate-200 px-4 py-3 text-xs text-slate-500 dark:border-slate-700 dark:text-slate-400">'
          + (file.original_name || '')
          + '</span>';
        bindMediaCardSelection(card);
        mediaGrid.prepend(card);
      });

      mediaGrid.classList.remove('hidden');
      if (mediaEmptyState) {
        mediaEmptyState.classList.add('hidden');
      }

      filterMediaCards();
    }

    function syncUploadName(files) {
      if (!uploadFileName) {
        return;
      }

      if (!files || !files.length) {
        uploadFileName.textContent = '';
        return;
      }

      uploadFileName.textContent = files.length === 1 ? files[0].name : files.length + ' files selected';
    }

    async function uploadPickerFiles(files) {
      if (!uploadForm || !uploadInput || !files || !files.length) {
        return;
      }

      const formData = new FormData(uploadForm);
      formData.delete('media_files[]');

      Array.from(files).forEach(function (file) {
        formData.append('media_files[]', file);
      });

      if (uploadStatus) {
        uploadStatus.textContent = 'Uploading...';
      }

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

        if (uploadStatus) {
          uploadStatus.textContent = payload.message || 'Upload complete.';
        }

        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(payload.message || 'Media uploaded.', 'success');
        }
      } catch (error) {
        if (uploadStatus) {
          uploadStatus.textContent = error.message || 'Upload failed.';
        }

        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(error.message || 'Upload failed.', 'error');
        }
      }
    }

    document.querySelectorAll('[data-open-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        activeMediaTarget = button.dataset.openMediaPicker;
        setUploadPanel(false);
        setMediaPicker(true);
      });
    });

    document.querySelectorAll('[data-clear-media]').forEach(function (button) {
      button.addEventListener('click', function () {
        if (button.dataset.clearMedia === 'profile_photo') {
          setProfileMedia('');
        }
      });
    });

    document.querySelectorAll('#profileMediaPickerModal [data-select-media-path]').forEach(function (button) {
      bindMediaCardSelection(button);
    });

    document.querySelectorAll('#profileMediaPickerModal [data-close-media-picker]').forEach(function (button) {
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

    if (passwordForm) {
      ['current_password', 'new_password', 'new_password_confirmation'].forEach(function (fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) {
          return;
        }

        field.addEventListener('input', function () {
          validatePasswordForm();
        });

        field.addEventListener('blur', function () {
          validatePasswordForm();
        });
      });

      passwordForm.addEventListener('submit', function (event) {
        if (!validatePasswordForm()) {
          event.preventDefault();
        }
      });
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

    showProfilePanel(activePanel);
  });
</script>
