(function () {
  'use strict';

  const root = document.documentElement;
  const storedTheme = localStorage.getItem('adminTheme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
    root.classList.add('dark');
  }

  window.dismissToast = function (toast) {
    if (!toast) return;
    toast.classList.remove('show');
    window.setTimeout(() => toast.remove(), 250);
  };

  window.initSearch = function (inputId, tableBodyId) {
    const input = document.getElementById(inputId);
    const tableBody = document.getElementById(tableBodyId);
    if (!input || !tableBody) return;

    input.addEventListener('input', function () {
      const query = input.value.trim().toLowerCase();
      tableBody.querySelectorAll('tr').forEach(function (row) {
        row.hidden = !row.textContent.toLowerCase().includes(query);
      });
    });
  };

  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarBrand = document.getElementById('sidebarBrand');
    const overlay = document.getElementById('overlay');
    const desktopQuery = window.matchMedia('(min-width: 1024px)');
    let desktopCollapsed = localStorage.getItem('adminSidebarCollapsed') === 'true';

    document.querySelectorAll('.nav-link').forEach(function (link) {
      if (link.dataset.page === document.body.dataset.page) {
        link.classList.add('bg-[#C99A30]', 'text-white', 'shadow-[0_8px_24px_rgba(201,154,48,.18)]');
        link.classList.remove('text-white/60');
        link.setAttribute('aria-current', 'page');
      }
    });

    function setMobileSidebar(open) {
      if (!sidebar || !overlay) return;
      sidebar.classList.toggle('-translate-x-full', !open);
      overlay.classList.toggle('hidden', !open);
      document.body.classList.toggle('overflow-hidden', open);
      if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', String(open));
    }

    function applyDesktopSidebar() {
      if (!sidebar || !mainContent || !desktopQuery.matches) return;
      const labels = sidebar.querySelectorAll('.nav-label');
      sidebar.style.width = desktopCollapsed ? '88px' : '284px';
      mainContent.style.marginLeft = desktopCollapsed ? '88px' : '284px';
      labels.forEach(function (label) {
        label.classList.toggle('hidden', desktopCollapsed);
      });
      if (sidebarBrand) {
        sidebarBrand.classList.toggle('justify-center', desktopCollapsed);
        sidebarBrand.classList.toggle('px-2', !desktopCollapsed);
        sidebarBrand.classList.toggle('px-0', desktopCollapsed);
      }
      if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', String(!desktopCollapsed));
    }

    function syncResponsiveState() {
      if (desktopQuery.matches) {
        setMobileSidebar(false);
        sidebar.classList.remove('-translate-x-full');
        document.body.classList.remove('overflow-hidden');
        applyDesktopSidebar();
      } else {
        if (sidebar) {
          sidebar.style.width = '';
          sidebar.querySelectorAll('.nav-label').forEach(label => label.classList.remove('hidden'));
        }
        if (mainContent) mainContent.style.marginLeft = '';
        setMobileSidebar(false);
      }
    }

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', function () {
        if (desktopQuery.matches) {
          desktopCollapsed = !desktopCollapsed;
          localStorage.setItem('adminSidebarCollapsed', String(desktopCollapsed));
          applyDesktopSidebar();
        } else {
          setMobileSidebar(sidebar.classList.contains('-translate-x-full'));
        }
      });
    }

    if (overlay) overlay.addEventListener('click', () => setMobileSidebar(false));
    desktopQuery.addEventListener('change', syncResponsiveState);
    syncResponsiveState();

    const themeToggle = document.getElementById('themeToggle');
    const moonIcon = document.getElementById('moonIcon');
    const sunIcon = document.getElementById('sunIcon');

    function syncThemeIcon() {
      const dark = root.classList.contains('dark');
      if (moonIcon) moonIcon.classList.toggle('hidden', dark);
      if (sunIcon) sunIcon.classList.toggle('hidden', !dark);
    }

    if (themeToggle) {
      themeToggle.addEventListener('click', function () {
        root.classList.toggle('dark');
        localStorage.setItem('adminTheme', root.classList.contains('dark') ? 'dark' : 'light');
        syncThemeIcon();
      });
    }
    syncThemeIcon();

    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const chevron = document.getElementById('chevron');

    function closeProfileMenu() {
      if (!profileDropdown || !profileBtn) return;
      profileDropdown.classList.add('hidden');
      profileBtn.setAttribute('aria-expanded', 'false');
      if (chevron) chevron.style.transform = '';
    }

    if (profileBtn && profileDropdown) {
      profileBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        const opening = profileDropdown.classList.contains('hidden');
        profileDropdown.classList.toggle('hidden', !opening);
        profileBtn.setAttribute('aria-expanded', String(opening));
        if (chevron) chevron.style.transform = opening ? 'rotate(180deg)' : '';
      });
      profileDropdown.addEventListener('click', event => event.stopPropagation());
      document.addEventListener('click', closeProfileMenu);
    }

    const logoutModal = document.getElementById('logoutModal');
    const openLogoutButtons = document.querySelectorAll('[data-open-logout]');
    const closeLogoutButton = document.querySelector('[data-close-logout]');
    const confirmDeleteModal = document.getElementById('confirmDeleteModal');
    const closeConfirmDeleteButton = document.querySelector('[data-close-confirm-delete]');
    const submitConfirmDeleteButton = document.querySelector('[data-confirm-delete-submit]');
    const confirmDeleteTitle = document.getElementById('confirmDeleteTitle');
    const confirmDeleteText = document.getElementById('confirmDeleteText');
    const confirmActionModal = document.getElementById('confirmActionModal');
    const closeConfirmActionButton = document.querySelector('[data-close-confirm-action]');
    const submitConfirmActionButton = document.querySelector('[data-confirm-action-submit]');
    const confirmActionTitle = document.getElementById('confirmActionTitle');
    const confirmActionText = document.getElementById('confirmActionText');
    let pendingDeleteForm = null;
    let pendingActionForm = null;

    function setLogoutModal(open) {
      if (!logoutModal) return;
      logoutModal.classList.toggle('hidden', !open);
      logoutModal.classList.toggle('flex', open);
      syncBodyLock();
      if (open && closeLogoutButton) closeLogoutButton.focus();
    }

    function setConfirmDeleteModal(open, form = null) {
      if (!confirmDeleteModal) return;
      pendingDeleteForm = open ? form : null;
      confirmDeleteModal.classList.toggle('hidden', !open);
      confirmDeleteModal.classList.toggle('flex', open);
      if (open) {
        const label = form?.dataset.deleteLabel || 'this image';
        const title = form?.dataset.deleteTitle || 'Delete image?';
        const message = form?.dataset.deleteMessage || ('This will permanently remove ' + label + ' from the media library.');
        const confirmLabel = form?.dataset.confirmButton || 'Delete';

        if (confirmDeleteTitle) confirmDeleteTitle.textContent = title;
        if (confirmDeleteText) confirmDeleteText.textContent = message;
        if (submitConfirmDeleteButton) submitConfirmDeleteButton.textContent = confirmLabel;
      } else {
        if (confirmDeleteTitle) confirmDeleteTitle.textContent = 'Delete image?';
        if (confirmDeleteText) confirmDeleteText.textContent = 'This media file will be removed from the library.';
        if (submitConfirmDeleteButton) submitConfirmDeleteButton.textContent = 'Delete';
      }
      syncBodyLock();
      if (open && closeConfirmDeleteButton) closeConfirmDeleteButton.focus();
    }

    function modalIsOpen(modal) {
      return Boolean(modal && modal.classList.contains('flex'));
    }

    function syncBodyLock() {
      document.body.classList.toggle('overflow-hidden', modalIsOpen(logoutModal) || modalIsOpen(confirmDeleteModal) || modalIsOpen(confirmActionModal));
    }

    function setConfirmActionModal(open, form = null) {
      if (!confirmActionModal) return;
      pendingActionForm = open ? form : null;
      confirmActionModal.classList.toggle('hidden', !open);
      confirmActionModal.classList.toggle('flex', open);
      if (open) {
        const title = form?.dataset.confirmTitle || 'Confirm action?';
        const message = form?.dataset.confirmMessage || 'Please confirm before continuing.';
        const confirmLabel = form?.dataset.confirmButton || 'Continue';

        if (confirmActionTitle) confirmActionTitle.textContent = title;
        if (confirmActionText) confirmActionText.textContent = message;
        if (submitConfirmActionButton) submitConfirmActionButton.textContent = confirmLabel;
      } else {
        if (confirmActionTitle) confirmActionTitle.textContent = 'Confirm action?';
        if (confirmActionText) confirmActionText.textContent = 'Please confirm before continuing.';
        if (submitConfirmActionButton) submitConfirmActionButton.textContent = 'Continue';
      }
      syncBodyLock();
      if (open && closeConfirmActionButton) closeConfirmActionButton.focus();
    }

    openLogoutButtons.forEach(button => button.addEventListener('click', () => setLogoutModal(true)));
    if (closeLogoutButton) closeLogoutButton.addEventListener('click', () => setLogoutModal(false));
    if (logoutModal) {
      logoutModal.addEventListener('click', function (event) {
        if (event.target === logoutModal) setLogoutModal(false);
      });
    }

    if (closeConfirmDeleteButton) {
      closeConfirmDeleteButton.addEventListener('click', () => setConfirmDeleteModal(false));
    }
    if (submitConfirmDeleteButton) {
      submitConfirmDeleteButton.addEventListener('click', function () {
        if (!pendingDeleteForm) return;
        const form = pendingDeleteForm;
        setConfirmDeleteModal(false);
        if (form.dataset.confirmDeleteAjax === 'true' && typeof window.handleConfirmDeleteForm === 'function') {
          window.handleConfirmDeleteForm(form);
          return;
        }
        form.submit();
      });
    }
    if (confirmDeleteModal) {
      confirmDeleteModal.addEventListener('click', function (event) {
        if (event.target === confirmDeleteModal) setConfirmDeleteModal(false);
      });
    }
    if (closeConfirmActionButton) {
      closeConfirmActionButton.addEventListener('click', () => setConfirmActionModal(false));
    }
    if (submitConfirmActionButton) {
      submitConfirmActionButton.addEventListener('click', function () {
        if (!pendingActionForm) return;
        const form = pendingActionForm;
        setConfirmActionModal(false);
        form.submit();
      });
    }
    if (confirmActionModal) {
      confirmActionModal.addEventListener('click', function (event) {
        if (event.target === confirmActionModal) setConfirmActionModal(false);
      });
    }

    document.addEventListener('submit', function (event) {
      const form = event.target;
      if (!(form instanceof HTMLFormElement) || !form.matches('[data-confirm-delete-form]')) return;
      event.preventDefault();
      setConfirmDeleteModal(true, form);
    });

    document.addEventListener('submit', function (event) {
      const form = event.target;
      if (!(form instanceof HTMLFormElement) || !form.matches('[data-confirm-action-form]')) return;
      event.preventDefault();
      setConfirmActionModal(true, form);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key !== 'Escape') return;
      closeProfileMenu();
      setMobileSidebar(false);
      setLogoutModal(false);
      setConfirmDeleteModal(false);
      setConfirmActionModal(false);
    });

    document.querySelectorAll('details.admin-actions[open]').forEach(function (dropdown) {
      document.addEventListener('click', function (event) {
        if (!dropdown.contains(event.target)) dropdown.removeAttribute('open');
      });
    });

    document.querySelectorAll('.admin-toast').forEach(function (toast, index) {
      window.setTimeout(() => toast.classList.add('show'), 80 * (index + 1));
      window.setTimeout(() => window.dismissToast(toast), 4200 + (index * 200));
    });
  });
}());
