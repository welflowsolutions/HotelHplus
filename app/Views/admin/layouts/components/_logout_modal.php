<div id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutTitle" class="fixed inset-0 z-[200] hidden items-center justify-center bg-slate-950/65 p-4 backdrop-blur-sm">
  <div class="w-full max-w-sm rounded-3xl border border-slate-200 bg-white p-7 shadow-2xl dark:border-slate-700 dark:bg-[#111827]">
    <div class="flex items-center justify-center w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl mx-auto mb-4">
      <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
      </svg>
    </div>
    <h3 id="logoutTitle" class="mb-1 text-center text-lg font-bold text-slate-900 dark:text-white">Sign out?</h3>
    <p class="mb-6 text-center text-sm text-slate-500 dark:text-slate-400">You will need to sign in again to manage <?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?>.</p>
    <div class="flex gap-3">
      <button data-close-logout type="button"
              class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Cancel
      </button>
      <a href="<?= base_url('admin/logout') ?>"
         class="flex-1 rounded-xl bg-red-500 px-4 py-2.5 text-center text-sm font-medium text-white transition-colors hover:bg-red-600">
        Sign Out
      </a>
    </div>
  </div>
</div>
