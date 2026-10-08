<?php
$adminName  = session()->get('admin_name')  ?? 'Admin';
$adminEmail = session()->get('admin_email') ?? '';
$adminPhoto = session()->get('admin_photo');
$adminType  = session()->get('admin_usertype') ?? 'admin';
$initials   = implode('', array_map(fn($p) => strtoupper(substr($p, 0, 1)), array_filter(explode(' ', trim($adminName)))));
$initials   = substr($initials, 0, 2) ?: 'A';
?>
<header class="sticky top-0 z-30 flex w-full border-b border-slate-200/80 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-[#0D1117]/90">
  <div class="flex min-h-[72px] w-full items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

    <button id="sidebarToggle"
            type="button"
            aria-label="Toggle navigation"
            aria-expanded="false"
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <div class="mr-auto min-w-0">
      <p class="truncate text-sm font-semibold text-slate-900 dark:text-white sm:text-base"><?= esc($title ?? 'Admin') ?></p>
      <p class="hidden text-xs text-slate-400 sm:block"><?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?> administration</p>
    </div>

    <div class="flex items-center gap-3">

      <a href="<?= base_url() ?>" target="_blank" rel="noopener"
         class="hidden items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white md:flex">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        View Site
      </a>

      <button id="themeToggle"
              type="button"
              aria-label="Toggle dark mode"
              class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">
        <svg id="moonIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
        <svg id="sunIcon" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3V1m0 22v-2m9-9h2M1 12h2m15.36-6.36 1.42-1.42M4.22 19.78l1.42-1.42m12.72 0 1.42 1.42M4.22 4.22l1.42 1.42M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/></svg>
      </button>

      <div class="relative">
        <button id="profileBtn"
                type="button"
                aria-haspopup="menu"
                aria-expanded="false"
                class="flex items-center gap-3 rounded-xl p-1.5 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 sm:pr-3">
          <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#D4AE50] to-[#A97919] text-sm font-semibold text-white shadow">
            <?php if ($adminPhoto): ?>
              <img src="<?= base_url($adminPhoto) ?>" alt="<?= esc($adminName) ?>" class="h-full w-full rounded-xl object-cover" />
            <?php else: ?>
              <?= $initials ?>
            <?php endif; ?>
          </div>
          <span class="hidden max-w-32 truncate text-sm font-medium text-slate-700 dark:text-slate-300 sm:block"><?= esc($adminName) ?></span>
          <svg id="chevron" class="hidden h-4 w-4 text-slate-400 transition-transform sm:block"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>

        <div id="profileDropdown" role="menu"
             class="absolute right-0 z-50 mt-2 hidden w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white py-2 shadow-2xl dark:border-slate-700 dark:bg-[#111827]">
          <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
            <p class="text-sm font-medium text-slate-900 dark:text-white"><?= esc($adminName) ?></p>
            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400"><?= esc($adminEmail) ?></p>
            <p class="mt-2 inline-flex rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-amber-700 dark:bg-amber-900/20 dark:text-amber-300"><?= esc($adminType) ?></p>
          </div>
          <div class="py-2">
            <a href="<?= base_url('admin/profile') ?>"
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              Profile
            </a>
            <a href="<?= base_url('admin/settings') ?>"
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Settings
            </a>
          </div>
          <div class="border-t border-slate-100 pt-2 dark:border-slate-800">
            <button data-open-logout type="button"
                    class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
              Logout
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</header>
