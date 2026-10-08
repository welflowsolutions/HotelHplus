<?php
$compact = $compact ?? false;
$light   = $light ?? false;
$text    = $light ? 'text-white' : 'text-slate-950 dark:text-white';
$muted   = $light ? 'text-white/45' : 'text-slate-400 dark:text-slate-500';
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$brandLogo = trim((string) app_setting('brand_logo', ''));
$brandLogoUrl = media_url($brandLogo);
$brandMark = strtoupper(str_replace(' ', ' ', $hotelName));
$brandLocation = app_setting('hotel_address', 'Kurukshetra');
$brandLocation = trim((string) explode(',', $brandLocation)[count(explode(',', $brandLocation)) - 1]);
?>
<div class="inline-flex items-center gap-3">
  <?php if ($brandLogoUrl !== ''): ?>
    <img src="<?= esc($brandLogoUrl) ?>" alt="<?= esc($hotelName) ?>" class="h-11 w-auto shrink-0 object-contain" />
  <?php else: ?>
    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#D4AE50] to-[#A97919] text-white shadow-[0_10px_30px_rgba(180,132,28,0.25)]">
      <svg class="h-7 w-7" viewBox="0 0 32 32" fill="none" aria-hidden="true">
        <path d="M7 7v18M25 7v18M7 16h18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
        <path d="M21.5 9.5v7M18 13h7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
  <?php endif; ?>

  <?php if (! $compact && $brandLogoUrl === ''): ?>
    <span class="nav-label min-w-0 leading-none">
      <span class="block whitespace-nowrap text-lg font-bold tracking-[0.18em] <?= $text ?>">
        <?= esc($brandMark) ?>
      </span>
      <span class="mt-1.5 block whitespace-nowrap text-[9px] font-semibold uppercase tracking-[0.3em] <?= $muted ?>">
        <?= esc($brandLocation ?: 'Hospitality') ?>
      </span>
    </span>
  <?php endif; ?>
</div>
