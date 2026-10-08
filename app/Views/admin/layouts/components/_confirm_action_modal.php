<div id="confirmActionModal" role="dialog" aria-modal="true" aria-labelledby="confirmActionTitle" class="fixed inset-0 z-[210] hidden items-center justify-center bg-slate-950/65 p-4 backdrop-blur-sm">
  <div class="w-full max-w-sm rounded-3xl border border-slate-200 bg-white p-7 shadow-2xl dark:border-slate-700 dark:bg-[#111827]">
    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#C99A30]/10 dark:bg-[#C99A30]/15">
      <svg class="h-7 w-7 text-[#C99A30]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6M5.6 15A7 7 0 0 0 18 17.4M18.4 9A7 7 0 0 0 6 6.6"/>
      </svg>
    </div>
    <h3 id="confirmActionTitle" class="mb-1 text-center text-lg font-bold text-slate-900 dark:text-white">Confirm action?</h3>
    <p id="confirmActionText" class="mb-6 text-center text-sm text-slate-500 dark:text-slate-400">Please confirm before continuing.</p>
    <div class="flex gap-3">
      <button data-close-confirm-action type="button"
              class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Cancel
      </button>
      <button data-confirm-action-submit type="button"
              class="flex-1 rounded-xl bg-[#C99A30] px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-[#B58522]">
        Continue
      </button>
    </div>
  </div>
</div>
