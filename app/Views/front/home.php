<?php
$hotelName      = app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone     = app_setting('hotel_phone', '+91 92530 72122');
$currencySymbol = $currencySymbol ?? app_setting('system_currency_symbol', '₹');
$homeContent    = $homeContent ?? [];
$rooms          = array_values($rooms ?? []);
$homeRooms      = array_slice($rooms, 0, 3);
$aboutTitlePrefix = trim(str_replace((string) ($homeContent['aboutHighlight'] ?? ''), '', (string) ($homeContent['aboutTitle'] ?? 'Experience Premium Comfort & Elegance')));
$roomsTitlePrefix = trim(str_replace((string) ($homeContent['roomsHighlight'] ?? ''), '', (string) ($homeContent['roomsTitle'] ?? 'Indulge in Comfort Every Stay.')));
$offerTitlePrefix = trim(str_replace((string) ($homeContent['offerHighlight'] ?? ''), '', (string) ($homeContent['offerTitle'] ?? 'Exclusive Limited-Time Offer This Month')));
$ctaTitlePrefix   = trim(str_replace((string) ($homeContent['ctaHighlight'] ?? ''), '', (string) ($homeContent['ctaTitle'] ?? 'Ready for a Luxurious Stay?')));
?>

<!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
    <section class="hero-section flex flex-col justify-between items-start" aria-label="Welcome to Hotel H Plus">
      <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full pt-32 pb-24">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

          <!-- Left: Content -->
          <div class="lg:col-span-7 text-white">
            <div class="ornament-left mb-8">
              <span class="section-tag" style="color:#D4AE50"><?= esc($homeContent['heroEyebrow'] ?? 'Best Hotel in Kurukshetra') ?></span>
            </div>
            <h1 class="font-display text-[clamp(3rem,8vw,6.5rem)] font-light leading-[0.95] tracking-[-0.01em] mb-6">
              <?= esc($homeContent['heroTitlePrefix'] ?? 'Welcome to') ?><br />
              <em class="text-gold not-italic"><?= esc($homeContent['heroTitleHighlight'] ?? $hotelName) ?></em>
            </h1>
            <p class="text-white/65 text-base lg:text-lg leading-relaxed max-w-lg mb-10 font-light">
              <?= esc($homeContent['heroDescription'] ?? 'A refined stay on Pipli Road, Kurukshetra, where comfort, hospitality, and thoughtful details come together beautifully.') ?>
            </p>
            <div class="flex flex-wrap gap-4 items-center mb-14">
              <a href="<?= base_url('rooms') ?>" class="btn-gold">Explore Rooms</a>
              <a href="tel:<?= esc($hotelPhone) ?>" class="btn-outline">
                <i class="fa-solid fa-phone text-[10px]"></i> <?= esc($hotelPhone) ?>
              </a>
            </div>
            <!-- Social proof -->
            <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-white/10">
              <!-- Avatar stack -->
              <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                  <span class="w-8 h-8 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-white text-[10px] font-semibold">A</span>
                  <span class="w-8 h-8 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-white text-[10px] font-semibold">R</span>
                  <span class="w-8 h-8 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-white text-[10px] font-semibold">S</span>
                  <span class="w-8 h-8 rounded-full bg-gold border border-white/30 flex items-center justify-center text-white text-[10px] font-semibold">+</span>
                </div>
                <p class="text-[11px] text-white/50 tracking-wide"><?= esc($homeContent['heroGuestCount'] ?? '10,000+ guests') ?></p>
              </div>

              <!-- Divider -->
              <div class="hidden sm:block w-px h-8 bg-white/15"></div>

              <!-- Google Reviews badge -->
              <div class="flex items-center gap-3 bg-white/8 backdrop-blur-sm border border-white/15 px-4 py-2.5" style="background:rgba(255,255,255,0.07)">
                <!-- Google G icon -->
                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                  <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                  <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                  <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                  <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <div>
                  <div class="flex items-center gap-1 mb-0.5">
                    <i class="fa-solid fa-star text-[#FBBC05] text-[9px]"></i>
                    <i class="fa-solid fa-star text-[#FBBC05] text-[9px]"></i>
                    <i class="fa-solid fa-star text-[#FBBC05] text-[9px]"></i>
                    <i class="fa-solid fa-star text-[#FBBC05] text-[9px]"></i>
                    <i class="fa-solid fa-star text-[#FBBC05] text-[9px]"></i>
                    <span class="text-white font-medium text-[11px] ml-1">4.9</span>
                  </div>
                  <p class="text-white/40 text-[9px] tracking-wide leading-none"><?= esc($homeContent['heroReviewText'] ?? '750+ Google Reviews') ?></p>
                </div>
              </div>
            </div>
          </div>

          <!-- Right: Minimal accent images -->
          <div class="lg:col-span-5 hidden lg:flex justify-end">
            <div class="relative ml-auto w-full max-w-[430px] min-h-[560px] xl:min-h-[620px]">
              <div class="absolute bottom-8 right-28 img-zoom-wrap w-36 xl:w-40 border border-white/20 opacity-95 shadow-[0_18px_40px_rgba(0,0,0,0.38)] z-[1]" style="clip-path: polygon(8% 0, 100% 0, 100% 92%, 92% 100%, 0 100%, 0 8%)">
                <img src="<?= base_url('assets/web/images/new/DSC_6624.webp') ?>"
                  alt="Luxury hotel room interior" width="400" height="300"
                  class="w-full h-24 xl:h-28 object-cover" />
              </div>

              <div class="absolute bottom-0 right-2 img-zoom-wrap w-40 xl:w-48 border border-white/15 shadow-[0_24px_50px_rgba(0,0,0,0.42)]" style="clip-path: polygon(10% 0, 100% 0, 100% 100%, 0 100%, 0 10%)">
                <img src="<?= esc($homeContent['heroSecondaryImage'] ?? base_url('assets/web/images/new/DSC_6631.webp')) ?>"
                  alt="Hotel premium room" width="400" height="300"
                  class="w-full h-24 xl:h-28 object-cover" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── Hero Booking Widget ── -->
      <div class="w-full px-6 lg:px-10 pb-12 mt-auto">
        <div class="max-w-7xl mx-auto">
          <form id="hero-book-form" onsubmit="heroBook(event)" novalidate data-rooms-url="<?= base_url('rooms') ?>"
            class="grid grid-cols-2 lg:grid-cols-5 gap-0 border border-gold/30 bg-ink/70 backdrop-blur-md">

            <!-- Check-in -->
            <div class="border-r border-gold/20 px-5 py-4">
              <label class="block text-[9px] tracking-[0.22em] uppercase text-gold/70 mb-1">Check-in</label>
              <input type="date" id="hero-ci" name="checkin"
                class="hero-book-control w-full bg-transparent text-white text-sm outline-none placeholder-white/30 cursor-pointer"
                style="color-scheme:dark" />
            </div>

            <!-- Check-out -->
            <div class="border-r border-gold/20 px-5 py-4">
              <label class="block text-[9px] tracking-[0.22em] uppercase text-gold/70 mb-1">Check-out</label>
              <input type="date" id="hero-co" name="checkout"
                class="hero-book-control w-full bg-transparent text-white text-sm outline-none cursor-pointer"
                style="color-scheme:dark" />
            </div>

            <!-- Guests -->
            <div class="border-r border-gold/20 px-5 py-4 col-span-2 lg:col-span-1">
              <label class="block text-[9px] tracking-[0.22em] uppercase text-gold/70 mb-1">Guests</label>
              <select name="guests"
                class="hero-book-control w-full bg-transparent text-white text-sm outline-none cursor-pointer"
                style="color-scheme:dark">
                <option value="1">1 Guest</option>
                <option value="2" selected>2 Guests</option>
                <option value="3">3 Guests</option>
                <option value="4">4+ Guests</option>
              </select>
            </div>

            <!-- Room Type -->
            <div class="border-r border-gold/20 px-5 py-4 col-span-2 lg:col-span-1">
              <label class="block text-[9px] tracking-[0.22em] uppercase text-gold/70 mb-1">Room Type</label>
              <select name="room_type"
                class="hero-book-control w-full bg-transparent text-white text-sm outline-none cursor-pointer"
                style="color-scheme:dark">
                <option value="">Any Room</option>
                <?php foreach ($homeRooms as $room): ?>
                  <option value="<?= esc($room['slug']) ?>"><?= esc($room['name']) ?> - <?= esc($currencySymbol) . esc($room['price_display'] ?? '0') ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Submit -->
            <button type="submit"
              class="col-span-2 lg:col-span-1 bg-gold hover:bg-gold-dark transition-colors text-white text-[10px] tracking-[0.2em] uppercase font-medium px-6 py-4 flex items-center justify-center gap-2">
              <i class="fa-solid fa-search text-xs"></i>
              Check Availability
            </button>

          </form>
          <p id="hero-book-error" class="hidden text-gold/70 text-[11px] tracking-wide mt-2 pl-1">
            <i class="fa-solid fa-circle-exclamation mr-1"></i> Please select check-in and check-out dates.
          </p>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 scroll-indicator" aria-hidden="true">
        <span class="text-[9px] tracking-[0.25em] uppercase text-white/40">Scroll</span>
        <div class="w-px h-12 bg-gradient-to-b from-white/40 to-transparent"></div>
      </div>
    </section>

    <!-- ── Gold ornament rule ── -->
    <div aria-hidden="true" style="height:2px;background:linear-gradient(to right,transparent 0%,#B8962E 25%,#D4AE50 50%,#B8962E 75%,transparent 100%)"></div>

    <!-- ═══════════════════════════════ STATS ═══════════════════════════════ -->
    <section class="relative py-14 overflow-hidden" aria-label="Hotel statistics">
      <!-- Continue the hero background for a seamless top block -->
      <div class="absolute inset-0 bg-cover bg-center bg-fixed home-parallax-bg" style="background:linear-gradient(160deg, rgba(17,16,16,0.94) 0%, rgba(17,16,16,0.78) 55%, rgba(17,16,16,0.58) 100%), url('/assets/web/images/homepage-hero-bg.webp') center/cover no-repeat fixed;"></div>
      <div class="relative max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid grid-cols-2 lg:grid-cols-4">
          <div class="stat-item px-8 py-4 text-center reveal delay-1">
            <p class="font-display text-5xl font-light text-gold leading-none"><?= esc($homeContent['statsRooms'] ?? '15+') ?></p>
            <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Available Rooms</p>
          </div>
          <div class="stat-item px-8 py-4 text-center reveal delay-2">
            <p class="font-display text-5xl font-light text-gold leading-none"><?= esc($homeContent['statsStaff'] ?? '10+') ?></p>
            <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Staff Members</p>
          </div>
          <div class="stat-item px-8 py-4 text-center reveal delay-3">
            <p class="font-display text-5xl font-light text-gold leading-none"><?= esc($homeContent['statsHappyClients'] ?? '100%') ?></p>
            <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Happy Clients</p>
          </div>
          <div class="stat-item px-8 py-4 text-center reveal delay-4">
            <p class="font-display text-5xl font-light text-gold leading-none"><?= esc($homeContent['statsReviews'] ?? '750+') ?></p>
            <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Guest Reviews</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ ABOUT ═══════════════════════════════ -->
    <section class="py-28 bg-ivory" aria-label="About Hotel H Plus">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid lg:grid-cols-2 gap-20 items-center">

          <!-- Images -->
          <div class="relative hidden lg:block reveal-left">
            <div class="img-zoom-wrap" style="clip-path: polygon(0 0,100% 0,100% 95%,95% 100%,0 100%)">
              <img src="<?= esc($homeContent['aboutImage'] ?? '') ?>"
                alt="Hotel H Plus interior" width="700" height="900"
                class="w-full h-[560px] object-cover" />
            </div>
            <!-- Floating secondary image -->
            <div class="absolute -bottom-10 -right-10 border-4 border-ivory shadow-2xl img-zoom-wrap"
                 style="clip-path: polygon(0 0,100% 0,100% 100%,5% 100%,0 95%)">
              <img src="<?= esc($homeContent['aboutSecondaryImage'] ?? '') ?>"
                alt="Hotel room detail" width="320" height="240"
                class="w-52 h-40 object-cover" />
            </div>
            <!-- Badge -->
            <div class="absolute top-8 -right-6 bg-ink text-white px-5 py-3">
              <p class="font-display text-2xl font-light text-gold leading-none">Premium</p>
              <p class="text-[9px] tracking-[0.2em] uppercase text-white/50 mt-1">Trusted Hospitality</p>
            </div>
          </div>

          <!-- Content -->
          <div class="reveal-right">
            <div class="ornament-left mb-6">
              <span class="section-tag"><?= esc($homeContent['aboutEyebrow'] ?? 'About Us') ?></span>
            </div>
            <h2 class="font-display text-[clamp(2rem,4vw,3.5rem)] font-light leading-[1.1] text-ink mb-6">
              <?= esc($aboutTitlePrefix !== '' ? $aboutTitlePrefix : ($homeContent['aboutTitle'] ?? 'Experience Premium')) ?><br />
              <em class="text-gold"><?= esc($homeContent['aboutHighlight'] ?? 'Comfort & Elegance') ?></em>
            </h2>
            <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
              <?= esc($homeContent['aboutDescription'] ?? 'Enjoy a peaceful and elegant stay at Hotel H Plus, Kurukshetra. Our well-furnished rooms, warm hospitality, and 24/7 service ensure a comfortable experience for families, business travelers, and guests seeking relaxation.') ?>
            </p>

            <!-- Tabs -->
            <div class="mb-10 border border-gold/20" role="tablist">
              <div class="flex border-b border-gold/20">
                <button onclick="switchTab(this,'mission')" role="tab" aria-selected="true"
                  class="tab-btn flex-1 py-3 text-[10px] tracking-[0.18em] uppercase font-medium text-gold border-b-2 border-gold bg-gold/5 transition-all">
                  Mission
                </button>
                <button onclick="switchTab(this,'vision')" role="tab" aria-selected="false"
                  class="tab-btn flex-1 py-3 text-[10px] tracking-[0.18em] uppercase font-medium text-ink/40 border-b-2 border-transparent hover:text-gold transition-all">
                  Vision
                </button>
                <button onclick="switchTab(this,'value')" role="tab" aria-selected="false"
                  class="tab-btn flex-1 py-3 text-[10px] tracking-[0.18em] uppercase font-medium text-ink/40 border-b-2 border-transparent hover:text-gold transition-all">
                  Values
                </button>
              </div>
              <div id="tab-mission" class="tab-panel p-5 text-ink/60 text-sm leading-relaxed">
                <?= esc($homeContent['aboutMission'] ?? 'To provide premium comfort, reliable service, and a welcoming environment for every guest who walks through our doors.') ?>
              </div>
              <div id="tab-vision" class="tab-panel hidden p-5 text-ink/60 text-sm leading-relaxed">
                <?= esc($homeContent['aboutVision'] ?? 'To become the most trusted and preferred luxury hotel in Kurukshetra — a place guests return to again and again.') ?>
              </div>
              <div id="tab-value" class="tab-panel hidden p-5 text-ink/60 text-sm leading-relaxed">
                <?= esc($homeContent['aboutValues'] ?? 'Hospitality, cleanliness, safety, and unwavering guest satisfaction above everything else.') ?>
              </div>
            </div>

            <div class="flex flex-wrap gap-4 items-center">
              <a href="<?= base_url('about') ?>" class="btn-gold-outline">Read More</a>
              <a href="tel:<?= esc($hotelPhone) ?>" class="text-[11px] tracking-[0.12em] uppercase text-ink/50 hover:text-gold transition-colors flex items-center gap-2">
                <i class="fa-solid fa-phone text-gold text-[10px]"></i> <?= esc($hotelPhone) ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ ROOMS ═══════════════════════════════ -->
    <section class="py-28 bg-ink" aria-label="Rooms and Suites">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">

        <!-- Header row -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-16 gap-6">
          <div class="reveal">
            <div class="ornament-left mb-5">
              <span class="section-tag" style="color:#D4AE50"><?= esc($homeContent['roomsEyebrow'] ?? 'Rooms & Suites') ?></span>
            </div>
            <h2 class="font-display text-[clamp(2rem,5vw,4rem)] font-light leading-[1.05] text-white">
              <?= esc($roomsTitlePrefix !== '' ? $roomsTitlePrefix : ($homeContent['roomsTitle'] ?? 'Indulge in Comfort')) ?><br /><em class="text-gold"><?= esc($homeContent['roomsHighlight'] ?? 'Every Stay.') ?></em>
            </h2>
          </div>
          <div class="text-right reveal">
            <p class="text-white/40 text-sm leading-relaxed max-w-xs mb-4"><?= esc($homeContent['roomsDescription'] ?? 'Experience ultimate relaxation, luxury, and world-class hospitality during every visit.') ?></p>
            <a href="<?= base_url('rooms') ?>" class="text-[10px] tracking-[0.2em] uppercase text-gold hover:text-gold-light transition-colors flex items-center gap-2 justify-end">
              View All Rooms <i class="fa-solid fa-arrow-right text-[8px]"></i>
            </a>
          </div>
        </div>

        <!-- Room Cards -->
        <div class="grid md:grid-cols-3 gap-0.5">
          <?php foreach ($homeRooms as $index => $room): ?>
            <?php
              $slug = $room['slug'] ?? '';
              $isFeatured = $index === 1;
              $badge = $room['type_label'] ?? 'Room';
              $amenities = array_slice($room['amenities'] ?? [], 0, 5);
              $roomCardImage = $room['image_url'] ?? '';
            ?>
            <article class="room-card group<?= $isFeatured ? ' reveal delay-2' : ' bg-ink-800 reveal delay-' . ($index + 1) ?>"<?= $isFeatured ? ' style="background:#0D0D0B"' : '' ?>>
              <div class="relative h-64 overflow-hidden">
                <img src="<?= esc($roomCardImage) ?>"
                  alt="<?= esc($room['name'] ?? 'Room') ?>" width="700" height="500"
                  class="card-img w-full h-full object-cover" />
                <div class="card-overlay"></div>
                <div class="absolute top-4 left-4 <?= $isFeatured ? 'bg-gold' : 'bg-ink/80 backdrop-blur-sm' ?> px-3 py-1">
                  <span class="text-[9px] tracking-[0.2em] uppercase <?= $isFeatured ? 'text-white' : 'text-white/70' ?>"><?= esc($badge) ?></span>
                </div>
              </div>
              <div class="p-7 <?= $isFeatured ? 'border border-gold/25' : 'border border-gold/10' ?> border-t-0">
                <h3 class="font-display text-2xl font-light text-white mb-2"><?= esc($room['name'] ?? 'Room') ?></h3>
                <p class="text-white/40 text-sm leading-relaxed mb-5"><?= esc($room['description'] ?? 'Comfortable stay with premium amenities.') ?></p>
                <div class="flex flex-wrap gap-2 mb-6">
                  <?php foreach ($amenities as $amenity): ?>
                    <span class="text-[9px] tracking-[0.12em] uppercase <?= $isFeatured ? 'text-gold border border-gold/40' : 'text-gold/70 border border-gold/20 hover:bg-gold hover:text-white hover:border-gold transition-colors' ?> px-2.5 py-1 cursor-default"><?= esc($amenity) ?></span>
                  <?php endforeach; ?>
                </div>
                <div class="flex flex-col items-start gap-4 pt-5 sm:flex-row sm:items-center sm:justify-between <?= $isFeatured ? 'border-t border-gold/20' : 'border-t border-gold/10' ?>">
                  <div>
                    <span class="font-display text-3xl font-light text-gold"><?= esc($currencySymbol) . esc($room['price_display'] ?? '0') ?></span>
                    <span class="text-white/30 text-xs ml-1">/ night</span>
                  </div>
                  <div class="flex flex-wrap gap-2">
                    <a href="<?= base_url('rooms/' . $slug) ?>" class="text-[9px] tracking-[0.12em] uppercase text-gold/60 hover:text-gold transition-colors py-2.5 px-3 border border-gold/20 hover:border-gold/50">Details</a>
                    <a href="<?= base_url('contact') ?>" class="<?= $isFeatured ? 'btn-gold' : 'btn-gold-outline' ?> text-[9px] py-2.5 px-4">Reserve Now</a>
                  </div>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ OFFER BANNER ═══════════════════════════════ -->
    <?php if (($homeContent['offerEnabled'] ?? true)): ?>
    <section class="py-24 bg-ivory" aria-label="Special offer">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
          <div class="lg:col-span-6 reveal-left">
            <div class="ornament-left mb-5">
              <span class="section-tag"><?= esc($homeContent['offerEyebrow'] ?? 'Today\'s Offer') ?></span>
            </div>
            <h2 class="font-display text-[clamp(2rem,4vw,3.5rem)] font-light leading-[1.1] text-ink mb-5">
              <?= esc($offerTitlePrefix !== '' ? $offerTitlePrefix : ($homeContent['offerTitle'] ?? 'Exclusive Limited-Time')) ?><br /><em class="text-gold"><?= esc($homeContent['offerHighlight'] ?? 'Offer This Month') ?></em>
            </h2>
            <p class="text-ink/55 text-[15px] leading-[1.9] mb-5">
              <?= esc($homeContent['offerDescription'] ?? 'Enjoy a special discounted stay at Hotel H Plus. Whether you\'re planning a family trip or a business visit, this is the perfect time to experience premium comfort at exceptional value.') ?>
            </p>
            <p class="text-ink/55 text-[15px] leading-[1.9] mb-8">
              <?= esc($homeContent['offerSecondaryDescription'] ?? 'Book now and take advantage of our limited-time savings before the offer ends.') ?>
            </p>
            <a href="<?= base_url('rooms') ?>" class="btn-gold">Reserve Now</a>
            <p class="mt-3 text-[11px] uppercase tracking-[0.18em] text-ink/35">
              <?= esc($homeContent['offerTypeLabel'] ?? 'Available for online and offline booking') ?>
            </p>
          </div>
          <div class="lg:col-span-6 flex justify-center lg:justify-end reveal-right">
            <div class="relative">
              <div class="img-zoom-wrap" style="clip-path:polygon(0 0,100% 0,100% 95%,5% 100%)">
                <img src="<?= esc($homeContent['offerImage'] ?? '') ?>"
                  alt="Hotel offer" width="600" height="450"
                  class="w-full max-w-md h-80 object-cover" />
              </div>
              <!-- Discount badge -->
              <div class="absolute top-3 right-3 lg:-top-6 lg:-right-4 w-24 h-24 bg-gold flex flex-col items-center justify-center">
                <span class="text-[9px] tracking-[0.15em] uppercase text-white/70">Save Up To</span>
                <span class="font-display text-3xl font-semibold text-white leading-none"><?= esc($homeContent['offerDiscountText'] ?? '30%') ?></span>
                <span class="text-[9px] tracking-[0.2em] uppercase text-white/70">Off</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- ═══════════════════════════════ SERVICES ═══════════════════════════════ -->
    <section class="py-24 bg-white" aria-label="Our Services">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="text-center mb-16 reveal">
          <div class="ornament mb-5">
            <span class="section-tag">Our Services</span>
          </div>
          <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink">Quality Services for <em class="text-gold">Every Guest</em></h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-px bg-ink/5">
          <div class="bg-white p-10 text-center reveal delay-1 group hover:bg-ink transition-colors duration-300">
            <i class="fa-solid fa-wifi text-2xl text-gold mb-5 block group-hover:text-gold-light transition-colors"></i>
            <h3 class="font-display text-xl font-light text-ink group-hover:text-white transition-colors mb-2">Free Wi-Fi</h3>
            <p class="text-ink/50 text-sm leading-relaxed group-hover:text-white/50 transition-colors">High-speed internet across all rooms and common areas.</p>
          </div>
          <div class="bg-white p-10 text-center reveal delay-2 group hover:bg-ink transition-colors duration-300">
            <i class="fa-solid fa-utensils text-2xl text-gold mb-5 block group-hover:text-gold-light transition-colors"></i>
            <h3 class="font-display text-xl font-light text-ink group-hover:text-white transition-colors mb-2">Restaurant</h3>
            <p class="text-ink/50 text-sm leading-relaxed group-hover:text-white/50 transition-colors">Delicious multi-cuisine meals served fresh every day.</p>
          </div>
          <div class="bg-white p-10 text-center reveal delay-3 group hover:bg-ink transition-colors duration-300">
            <i class="fa-solid fa-car text-2xl text-gold mb-5 block group-hover:text-gold-light transition-colors"></i>
            <h3 class="font-display text-xl font-light text-ink group-hover:text-white transition-colors mb-2">Free Parking</h3>
            <p class="text-ink/50 text-sm leading-relaxed group-hover:text-white/50 transition-colors">Spacious, secure parking facility for all guests.</p>
          </div>
          <div class="bg-white p-10 text-center reveal delay-4 group hover:bg-ink transition-colors duration-300">
            <i class="fa-solid fa-concierge-bell text-2xl text-gold mb-5 block group-hover:text-gold-light transition-colors"></i>
            <h3 class="font-display text-xl font-light text-ink group-hover:text-white transition-colors mb-2">24/7 Service</h3>
            <p class="text-ink/50 text-sm leading-relaxed group-hover:text-white/50 transition-colors">Round-the-clock room service and concierge support.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ TESTIMONIALS ═══════════════════════════════ -->
    <section class="py-24 bg-ivory" aria-label="Guest testimonials">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="text-center mb-16 reveal">
          <div class="ornament mb-5">
            <span class="section-tag">Guest Reviews</span>
          </div>
          <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink">What Our <em class="text-gold">Guests Say</em></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white p-8 border border-gold/10 relative reveal delay-1">
            <span class="quote-mark">"</span>
            <div class="flex gap-0.5 mb-4">
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
            </div>
            <p class="text-ink/60 text-sm leading-[1.9] mb-6 italic font-light">"Exceptional stay — the rooms are beautifully maintained, the staff are warm and professional. We'll definitely come back."</p>
            <div class="flex items-center gap-3 border-t border-gold/10 pt-5">
              <span class="w-10 h-10 rounded-full border border-gold/20 bg-gold/10 text-gold flex items-center justify-center text-xs font-semibold">PS</span>
              <div>
                <p class="font-display text-base text-ink">Priya Sharma</p>
                <p class="text-[10px] tracking-[0.12em] uppercase text-ink/30">Kurukshetra</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 border border-gold/10 relative reveal delay-2">
            <span class="quote-mark">"</span>
            <div class="flex gap-0.5 mb-4">
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
            </div>
            <p class="text-ink/60 text-sm leading-[1.9] mb-6 italic font-light">"Best value hotel in Kurukshetra. Clean, comfortable, great food and the location near Pipli Road is very convenient."</p>
            <div class="flex items-center gap-3 border-t border-gold/10 pt-5">
              <span class="w-10 h-10 rounded-full border border-gold/20 bg-gold/10 text-gold flex items-center justify-center text-xs font-semibold">RV</span>
              <div>
                <p class="font-display text-base text-ink">Rahul Verma</p>
                <p class="text-[10px] tracking-[0.12em] uppercase text-ink/30">Delhi</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-8 border border-gold/10 relative reveal delay-3">
            <span class="quote-mark">"</span>
            <div class="flex gap-0.5 mb-4">
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star text-gold text-xs"></i>
              <i class="fa-solid fa-star-half-stroke text-gold text-xs"></i>
            </div>
            <p class="text-ink/60 text-sm leading-[1.9] mb-6 italic font-light">"The Executive Room exceeded all expectations. Spacious, luxurious and the 24/7 service is genuinely impressive."</p>
            <div class="flex items-center gap-3 border-t border-gold/10 pt-5">
              <span class="w-10 h-10 rounded-full border border-gold/20 bg-gold/10 text-gold flex items-center justify-center text-xs font-semibold">SK</span>
              <div>
                <p class="font-display text-base text-ink">Sunita Kaur</p>
                <p class="text-[10px] tracking-[0.12em] uppercase text-ink/30">Chandigarh</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ GALLERY TEASER ═══════════════════════════════ -->
    <section class="py-24 bg-ink" aria-label="Gallery preview">
      <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-12 gap-6">
          <div class="reveal">
            <div class="ornament-left mb-5">
              <span class="section-tag" style="color:#D4AE50">Our Gallery</span>
            </div>
            <h2 class="font-display text-[clamp(2rem,4vw,3.5rem)] font-light text-white">
              A Glimpse of <em class="text-gold">Luxury.</em>
            </h2>
          </div>
          <a href="<?= base_url('gallery') ?>" class="btn-gold-outline text-[9px] reveal" style="color:#D4AE50;border-color:#D4AE50">View All Photos</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-0.5 reveal">
          <div class="img-zoom-wrap col-span-1 row-span-2">
            <img src="<?= esc($homeContent['galleryImages'][0]['src'] ?? '') ?>" alt="<?= esc($homeContent['galleryImages'][0]['alt'] ?? 'Hotel H Plus gallery image') ?>" width="500" height="600" class="w-full h-full object-cover min-h-[250px]" loading="lazy" />
          </div>
          <div class="img-zoom-wrap"><img src="<?= esc($homeContent['galleryImages'][1]['src'] ?? '') ?>" alt="<?= esc($homeContent['galleryImages'][1]['alt'] ?? 'Hotel H Plus gallery image') ?>" width="400" height="300" class="w-full h-48 object-cover" loading="lazy" /></div>
          <div class="img-zoom-wrap"><img src="<?= esc($homeContent['galleryImages'][2]['src'] ?? '') ?>" alt="<?= esc($homeContent['galleryImages'][2]['alt'] ?? 'Hotel H Plus gallery image') ?>" width="400" height="300" class="w-full h-48 object-cover" loading="lazy" /></div>
          <div class="img-zoom-wrap"><img src="<?= esc($homeContent['galleryImages'][3]['src'] ?? '') ?>" alt="<?= esc($homeContent['galleryImages'][3]['alt'] ?? 'Hotel H Plus gallery image') ?>" width="400" height="300" class="w-full h-48 object-cover" loading="lazy" /></div>
          <div class="img-zoom-wrap"><img src="<?= esc($homeContent['galleryImages'][4]['src'] ?? '') ?>" alt="<?= esc($homeContent['galleryImages'][4]['alt'] ?? 'Hotel H Plus gallery image') ?>" width="400" height="300" class="w-full h-48 object-cover" loading="lazy" /></div>
          <div class="img-zoom-wrap"><img src="<?= esc($homeContent['galleryImages'][5]['src'] ?? '') ?>" alt="<?= esc($homeContent['galleryImages'][5]['alt'] ?? 'Hotel H Plus gallery image') ?>" width="400" height="300" class="w-full h-48 object-cover" loading="lazy" /></div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════ CTA ═══════════════════════════════ -->
    <section class="relative py-28 overflow-hidden" aria-label="Call to action">
      <div class="absolute inset-0 bg-cover bg-center bg-fixed home-parallax-bg"
           style="background-image:url('<?= esc($homeContent['ctaBackgroundImage'] ?? '') ?>')"></div>
      <div class="absolute inset-0 bg-ink/80"></div>
      <div class="relative max-w-3xl mx-auto px-6 text-center">
        <div class="ornament mb-6">
          <span class="section-tag" style="color:#D4AE50"><?= esc($homeContent['ctaEyebrow'] ?? 'Book Now') ?></span>
        </div>
        <h2 class="font-display text-[clamp(2.5rem,6vw,5rem)] font-light text-white leading-[1.0] mb-4">
          <?= esc($ctaTitlePrefix !== '' ? $ctaTitlePrefix : ($homeContent['ctaTitle'] ?? 'Ready for a')) ?><br /><em class="text-gold"><?= esc($homeContent['ctaHighlight'] ?? 'Luxurious Stay?') ?></em>
        </h2>
        <p class="text-white/50 text-base mb-10 font-light"><?= esc($homeContent['ctaDescription'] ?? ('Experience comfort, elegance, and warm hospitality at ' . $hotelName . '.')) ?></p>
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="<?= base_url('contact') ?>" class="btn-gold">Reserve Now</a>
          <a href="<?= base_url('rooms') ?>" class="btn-outline">View Rooms</a>
        </div>
      </div>
    </section>
