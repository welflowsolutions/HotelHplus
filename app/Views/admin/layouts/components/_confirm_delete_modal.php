<div id="confirmDeleteModal" role="dialog" aria-modal="true" aria-labelledby="confirmDeleteTitle" class="fixed inset-0 z-[210] hidden items-center justify-center bg-slate-950/65 p-4 backdrop-blur-sm">
  <div class="w-full max-w-sm rounded-3xl border border-slate-200 bg-white p-7 shadow-2xl dark:border-slate-700 dark:bg-[#111827]">
    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 dark:bg-red-900/20">
      <svg class="h-7 w-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12m-9 0V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m-7 0 1 12a1 1 0 0 0 1 .92h4a1 1 0 0 0 1-.92L16 7M10 11v6m4-6v6"/>
      </svg>
    </div>
    <h3 id="confirmDeleteTitle" class="mb-1 text-center text-lg font-bold text-slate-900 dark:text-white">Delete image?</h3>
    <p id="confirmDeleteText" class="mb-6 text-center text-sm text-slate-500 dark:text-slate-400">This media file will be removed from the library.</p>
    <div class="flex gap-3">
      <button data-close-confirm-delete type="button"
              class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Cancel
      </button>
      <button data-confirm-delete-submit type="button"
              class="flex-1 rounded-xl bg-red-500 px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-red-600">
        Delete
      </button>
    </div>
  </div>
</div>
