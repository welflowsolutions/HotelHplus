<?php
$activePage = $activePage ?? 'home';
$isHome = $activePage === 'home';
$hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
$brandLogo = trim((string) app_setting('brand_logo', ''));
$brandLogoUrl = media_url($brandLogo);
$brandSub = strtoupper(trim((string) app_setting('brand_header_subtitle', 'KURUKSHETRA')));
$routes = [
    'home' => ['label' => 'Home', 'url' => base_url('/')],
    'about' => ['label' => 'About', 'url' => base_url('about')],
    'rooms' => ['label' => 'Rooms', 'url' => base_url('rooms')],
    'events' => ['label' => 'Events', 'url' => base_url('events')],
    'gallery' => ['label' => 'Gallery', 'url' => base_url('gallery')],
    'contact' => ['label' => 'Contact', 'url' => base_url('contact')],
];
?>
<?php if ($isHome): ?>
  <!-- ═══════════════════════════════ HEADER ═══════════════════════════════ -->
  <header id="header" data-header-theme="dark" class="fixed top-0 left-0 right-0 z-50 bg-transparent py-6 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
      <div class="header-row flex items-center justify-between">

        <!-- Logo -->
        <a href="<?= $routes['home']['url'] ?>" class="header-brand flex flex-col leading-none" aria-label="Hotel H Plus Home">
          <?php if ($brandLogoUrl !== ''): ?>
            <img src="<?= esc($brandLogoUrl) ?>" alt="Hotel H Plus" class="header-brand-logo h-11 w-auto object-contain" />
          <?php else: ?>
            <span class="font-display text-2xl font-light tracking-[0.18em] text-white" id="logo-text">
              HOTEL <span class="text-gold font-semibold">H<span class="text-gold-light">+</span></span>
            </span>
            <span class="text-[8px] tracking-[0.3em] uppercase text-white/60 mt-0.5" id="logo-sub"><?= esc($brandSub) ?></span>
          <?php endif; ?>
        </a>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center gap-10" aria-label="Main navigation">
          <a href="<?= $routes['home']['url'] ?>" class="nav-link active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors">Home</a>
          <a href="<?= $routes['about']['url'] ?>" class="nav-link text-[11px] tracking-[0.18em] uppercase font-medium text-white/90 hover:text-gold transition-colors">About</a>
          <a href="<?= $routes['rooms']['url'] ?>" class="nav-link text-[11px] tracking-[0.18em] uppercase font-medium text-white/90 hover:text-gold transition-colors">Rooms</a>
          <a href="<?= $routes['events']['url'] ?>" class="nav-link text-[11px] tracking-[0.18em] uppercase font-medium text-white/90 hover:text-gold transition-colors">Events</a>
          <a href="<?= $routes['gallery']['url'] ?>" class="nav-link text-[11px] tracking-[0.18em] uppercase font-medium text-white/90 hover:text-gold transition-colors">Gallery</a>
          <a href="<?= $routes['contact']['url'] ?>" class="nav-link text-[11px] tracking-[0.18em] uppercase font-medium text-white/90 hover:text-gold transition-colors">Contact</a>
        </nav>

        <!-- CTA -->
        <div class="hidden lg:flex items-center gap-5">
          <a href="tel:<?= esc($hotelPhone) ?>" id="header-phone" class="text-[11px] tracking-[0.15em] uppercase text-white/70 hover:text-gold transition-colors">
            <i class="fa-solid fa-phone mr-2 text-gold"></i><?= esc($hotelPhone) ?>
          </a>
          <a href="<?= $routes['contact']['url'] ?>" class="btn-gold text-[10px]">Reserve Now</a>
        </div>

        <!-- Mobile Toggle -->
        <button id="menu-toggle" class="header-menu-toggle lg:hidden w-8 flex flex-col gap-1.5 group" aria-label="Open menu" aria-expanded="false">
          <span class="h-px bg-white group-hover:bg-gold transition-colors block w-full"></span>
          <span class="h-px bg-white group-hover:bg-gold transition-colors block w-3/4 ml-auto"></span>
          <span class="h-px bg-white group-hover:bg-gold transition-colors block w-full"></span>
        </button>
      </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="mobile-menu" data-menu-theme="dark" class="mobile-menu-panel lg:hidden hidden fixed inset-x-0 bg-ink/95 backdrop-blur-md border-t border-gold/20 px-6 py-6 shadow-2xl">
      <nav class="flex flex-col gap-5" aria-label="Mobile navigation">
        <a href="<?= $routes['home']['url'] ?>" class="text-xs tracking-[0.2em] uppercase text-gold">Home</a>
        <a href="<?= $routes['about']['url'] ?>" class="text-xs tracking-[0.2em] uppercase text-white/70 hover:text-gold transition-colors">About</a>
        <a href="<?= $routes['rooms']['url'] ?>" class="text-xs tracking-[0.2em] uppercase text-white/70 hover:text-gold transition-colors">Rooms</a>
        <a href="<?= $routes['events']['url'] ?>" class="text-xs tracking-[0.2em] uppercase text-white/70 hover:text-gold transition-colors">Events</a>
        <a href="<?= $routes['gallery']['url'] ?>" class="text-xs tracking-[0.2em] uppercase text-white/70 hover:text-gold transition-colors">Gallery</a>
        <a href="<?= $routes['contact']['url'] ?>" class="text-xs tracking-[0.2em] uppercase text-white/70 hover:text-gold transition-colors">Contact</a>
        <a href="<?= $routes['contact']['url'] ?>" class="btn-gold mt-2 w-fit text-[10px]">Reserve Now</a>
      </nav>
    </div>
  </header>
<?php else: ?>
  <!-- HEADER -->
  <header id="header" data-header-theme="light" class="fixed top-0 left-0 right-0 z-50 bg-ivory/95 backdrop-blur-md py-6 transition-all duration-300" style="box-shadow: 0 1px 0 rgba(184,150,46,0.15);">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
      <div class="header-row flex items-center justify-between">
        <a href="<?= $routes['home']['url'] ?>" class="header-brand flex flex-col leading-none" aria-label="Hotel H Plus Home">
          <?php if ($brandLogoUrl !== ''): ?>
            <img src="<?= esc($brandLogoUrl) ?>" alt="Hotel H Plus" class="header-brand-logo h-11 w-auto object-contain" />
          <?php else: ?>
            <span id="logo-text" class="font-display text-2xl font-light tracking-[0.18em] text-ink">HOTEL <span class="text-gold font-semibold">H+</span></span>
            <span id="logo-sub" class="text-[8px] tracking-[0.3em] uppercase text-ink/30 mt-0.5"><?= esc($brandSub) ?></span>
          <?php endif; ?>
        </a>
        <nav class="hidden lg:flex items-center gap-10" aria-label="Main navigation">
          <a href="<?= $routes['home']['url'] ?>" class="nav-link<?= $activePage === 'home' ? ' active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors' : ' text-[11px] tracking-[0.18em] uppercase font-medium text-ink/70 hover:text-gold transition-colors' ?>">Home</a>
          <a href="<?= $routes['about']['url'] ?>" class="nav-link<?= $activePage === 'about' ? ' active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors' : ' text-[11px] tracking-[0.18em] uppercase font-medium text-ink/70 hover:text-gold transition-colors' ?>">About</a>
          <a href="<?= $routes['rooms']['url'] ?>" class="nav-link<?= $activePage === 'rooms' ? ' active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors' : ' text-[11px] tracking-[0.18em] uppercase font-medium text-ink/70 hover:text-gold transition-colors' ?>">Rooms</a>
          <a href="<?= $routes['events']['url'] ?>" class="nav-link<?= $activePage === 'events' ? ' active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors' : ' text-[11px] tracking-[0.18em] uppercase font-medium text-ink/70 hover:text-gold transition-colors' ?>">Events</a>
          <a href="<?= $routes['gallery']['url'] ?>" class="nav-link<?= $activePage === 'gallery' ? ' active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors' : ' text-[11px] tracking-[0.18em] uppercase font-medium text-ink/70 hover:text-gold transition-colors' ?>">Gallery</a>
          <a href="<?= $routes['contact']['url'] ?>" class="nav-link<?= $activePage === 'contact' ? ' active text-[11px] tracking-[0.18em] uppercase font-medium text-gold transition-colors' : ' text-[11px] tracking-[0.18em] uppercase font-medium text-ink/70 hover:text-gold transition-colors' ?>">Contact</a>
        </nav>
        <div class="hidden lg:flex items-center gap-5">
          <a href="tel:<?= esc($hotelPhone) ?>" id="header-phone" class="text-[11px] tracking-[0.15em] uppercase text-ink/40 hover:text-gold transition-colors">
            <i class="fa-solid fa-phone mr-2 text-gold"></i><?= esc($hotelPhone) ?>
          </a>
          <a href="<?= $routes['contact']['url'] ?>" class="btn-gold text-[10px]">Reserve Now</a>
        </div>
        <button id="menu-toggle" class="header-menu-toggle lg:hidden w-8 flex flex-col gap-1.5 group" aria-label="Open menu" aria-expanded="false">
          <span class="h-px bg-ink group-hover:bg-gold transition-colors block w-full"></span>
          <span class="h-px bg-ink group-hover:bg-gold transition-colors block w-3/4 ml-auto"></span>
          <span class="h-px bg-ink group-hover:bg-gold transition-colors block w-full"></span>
        </button>
      </div>
    </div>
    <div id="mobile-menu" data-menu-theme="light" class="mobile-menu-panel lg:hidden hidden fixed inset-x-0 bg-ivory/98 backdrop-blur-md border-t border-gold/20 px-6 py-6 shadow-2xl">
      <nav class="flex flex-col gap-5" aria-label="Mobile navigation">
        <a href="<?= $routes['home']['url'] ?>" class="text-xs tracking-[0.2em] uppercase <?= $activePage === 'home' ? 'text-gold' : 'text-ink/70 hover:text-gold transition-colors' ?>">Home</a>
        <a href="<?= $routes['about']['url'] ?>" class="text-xs tracking-[0.2em] uppercase <?= $activePage === 'about' ? 'text-gold' : 'text-ink/70 hover:text-gold transition-colors' ?>">About</a>
        <a href="<?= $routes['rooms']['url'] ?>" class="text-xs tracking-[0.2em] uppercase <?= $activePage === 'rooms' ? 'text-gold' : 'text-ink/70 hover:text-gold transition-colors' ?>">Rooms</a>
        <a href="<?= $routes['events']['url'] ?>" class="text-xs tracking-[0.2em] uppercase <?= $activePage === 'events' ? 'text-gold' : 'text-ink/70 hover:text-gold transition-colors' ?>">Events</a>
        <a href="<?= $routes['gallery']['url'] ?>" class="text-xs tracking-[0.2em] uppercase <?= $activePage === 'gallery' ? 'text-gold' : 'text-ink/70 hover:text-gold transition-colors' ?>">Gallery</a>
        <a href="<?= $routes['contact']['url'] ?>" class="text-xs tracking-[0.2em] uppercase <?= $activePage === 'contact' ? 'text-gold' : 'text-ink/70 hover:text-gold transition-colors' ?>">Contact</a>
        <a href="<?= $routes['contact']['url'] ?>" class="btn-gold mt-2 w-fit text-[10px]">Reserve Now</a>
      </nav>
    </div>
  </header>
<?php endif; ?>
