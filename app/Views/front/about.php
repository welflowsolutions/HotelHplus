<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$aboutPage = $aboutPage ?? [];
?>
<section class="page-hero about-hero" aria-label="About Us hero">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5">
      <span class="section-tag" style="color:#D4AE50"><?= esc($hotelName) ?></span>
    </div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      About <em class="text-gold">Us</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">About</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-28 bg-ivory" aria-label="Our Story">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-20 items-center">
      <div class="relative hidden lg:block reveal-left">
        <div class="img-zoom-wrap" style="clip-path: polygon(0 0,100% 0,100% 95%,95% 100%,0 100%)">
          <img src="<?= esc($aboutPage['storyImage'] ?? '') ?>"
            alt="Hotel H Plus building exterior" width="700" height="900"
            class="w-full h-[580px] object-cover" />
        </div>
        <div class="absolute -bottom-10 -right-10 border-4 border-ivory shadow-2xl img-zoom-wrap"
             style="clip-path: polygon(0 0,100% 0,100% 100%,5% 100%,0 95%)">
          <img src="<?= esc($aboutPage['storySecondaryImage'] ?? '') ?>"
            alt="Hotel room detail" width="320" height="240" loading="lazy"
            class="w-56 h-44 object-cover" />
        </div>
        <div class="absolute top-8 -right-6 bg-ink text-white px-5 py-4 shadow-xl">
          <p class="font-display text-3xl font-light text-gold leading-none">15+</p>
          <p class="text-[9px] tracking-[0.2em] uppercase text-white/50 mt-1">Years of Service</p>
        </div>
      </div>

      <div class="reveal-right">
        <div class="ornament-left mb-6">
          <span class="section-tag">About Us</span>
        </div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.5rem)] font-light leading-[1.1] text-ink mb-6">
          Experience Premium<br />
          <em class="text-gold">Comfort &amp; Elegance</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-5">
          <?= esc($hotelName) ?> is a premium destination on Pipli Road, Kurukshetra, offering a refined stay for families, business travelers, and pilgrims alike. Since our founding, we have dedicated ourselves to elevating the hospitality experience in the region.
        </p>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          Our thoughtfully designed rooms, attentive staff, and world-class amenities ensure that each guest feels at home while experiencing the finest comforts. We take pride in being a trusted hotel choice near the sacred city of Kurukshetra.
        </p>

        <div class="mb-10 border border-gold/20" role="tablist" aria-label="About tabs">
          <div class="flex border-b border-gold/20">
            <button onclick="switchTab(this,'mission')" role="tab" aria-selected="true" aria-controls="tab-mission"
              class="tab-btn flex-1 py-3 text-[10px] tracking-[0.18em] uppercase font-medium text-gold border-b-2 border-gold bg-gold/5 transition-all">
              Mission
            </button>
            <button onclick="switchTab(this,'vision')" role="tab" aria-selected="false" aria-controls="tab-vision"
              class="tab-btn flex-1 py-3 text-[10px] tracking-[0.18em] uppercase font-medium text-ink/40 border-b-2 border-transparent hover:text-gold transition-all">
              Vision
            </button>
            <button onclick="switchTab(this,'values')" role="tab" aria-selected="false" aria-controls="tab-values"
              class="tab-btn flex-1 py-3 text-[10px] tracking-[0.18em] uppercase font-medium text-ink/40 border-b-2 border-transparent hover:text-gold transition-all">
              Values
            </button>
          </div>
          <div id="tab-mission" class="tab-panel p-6 text-ink/60 text-sm leading-relaxed">
            To provide premium comfort, reliable service, and a genuinely welcoming environment for every guest who chooses <?= esc($hotelName) ?>.
          </div>
          <div id="tab-vision" class="tab-panel hidden p-6 text-ink/60 text-sm leading-relaxed">
            To become the most trusted and preferred hotel in Kurukshetra, with a reputation built on consistency, comfort, and care.
          </div>
          <div id="tab-values" class="tab-panel hidden p-6 text-ink/60 text-sm leading-relaxed">
            Genuine hospitality, impeccable cleanliness, guest safety, and unwavering satisfaction guide every decision we make.
          </div>
        </div>

        <div class="flex flex-wrap gap-4 items-center">
          <a href="<?= base_url('contact') ?>" class="btn-gold">Reserve Now</a>
          <a href="<?= base_url('rooms') ?>" class="btn-gold-outline">View Rooms</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-14 bg-ink" aria-label="Hotel statistics">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid grid-cols-2 lg:grid-cols-4">
      <div class="stat-item px-8 py-4 text-center reveal delay-1">
        <p class="font-display text-5xl font-light text-gold leading-none">50<span class="text-2xl">+</span></p>
        <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Available Rooms</p>
      </div>
      <div class="stat-item px-8 py-4 text-center reveal delay-2">
        <p class="font-display text-5xl font-light text-gold leading-none">150<span class="text-2xl">+</span></p>
        <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Staff Members</p>
      </div>
      <div class="stat-item px-8 py-4 text-center reveal delay-3">
        <p class="font-display text-5xl font-light text-gold leading-none">100<span class="text-2xl">%</span></p>
        <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Happy Clients</p>
      </div>
      <div class="stat-item px-8 py-4 text-center reveal delay-4">
        <p class="font-display text-5xl font-light text-gold leading-none">750<span class="text-2xl">+</span></p>
        <p class="text-[10px] tracking-[0.2em] uppercase text-white/40 mt-2">Guest Reviews</p>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-white" aria-label="Why Choose Hotel H Plus">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto mb-16 reveal">
      <div class="ornament mb-6">
        <span class="section-tag">Why Choose Us</span>
      </div>
      <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light leading-[1.1] text-ink mb-5">
        The H Plus <em class="text-gold">Difference</em>
      </h2>
      <p class="text-ink/60 text-[15px] leading-[1.9]">We go beyond the expected to craft experiences that stay with you long after checkout. Here is why our guests keep coming back.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-0.5">
      <div class="feature-card reveal delay-1">
        <div class="w-12 h-12 border border-gold/30 flex items-center justify-center mb-5 text-gold">
          <i class="fa-solid fa-location-dot"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Prime Location</h3>
        <p class="text-ink/60 text-sm leading-[1.9]">Strategically located on Pipli Road, Kurukshetra, with easy access to key religious sites, markets, and highways.</p>
      </div>
      <div class="feature-card reveal delay-2">
        <div class="w-12 h-12 border border-gold/30 flex items-center justify-center mb-5 text-gold">
          <i class="fa-solid fa-star"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Premium Quality</h3>
        <p class="text-ink/60 text-sm leading-[1.9]">From furnishings to finishes, every part of the stay is arranged for comfort, elegance, and practical convenience.</p>
      </div>
      <div class="feature-card reveal delay-3">
        <div class="w-12 h-12 border border-gold/30 flex items-center justify-center mb-5 text-gold">
          <i class="fa-solid fa-clock"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">24/7 Service</h3>
        <p class="text-ink/60 text-sm leading-[1.9]">Our front desk and support team are available throughout the day and night whenever guests need assistance.</p>
      </div>
      <div class="feature-card reveal delay-1">
        <div class="w-12 h-12 border border-gold/30 flex items-center justify-center mb-5 text-gold">
          <i class="fa-solid fa-people-roof"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Family Friendly</h3>
        <p class="text-ink/60 text-sm leading-[1.9]">Spacious room types and a warm atmosphere make the property comfortable for couples, families, and group travelers.</p>
      </div>
      <div class="feature-card reveal delay-2">
        <div class="w-12 h-12 border border-gold/30 flex items-center justify-center mb-5 text-gold">
          <i class="fa-solid fa-tag"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Best Value</h3>
        <p class="text-ink/60 text-sm leading-[1.9]">Exceptional comfort at transparent pricing, so guests get a premium stay that still feels practical and worthwhile.</p>
      </div>
      <div class="feature-card reveal delay-3">
        <div class="w-12 h-12 border border-gold/30 flex items-center justify-center mb-5 text-gold">
          <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Safe &amp; Secure</h3>
        <p class="text-ink/60 text-sm leading-[1.9]">Security systems and attentive staff help create a comfortable environment for solo travelers, families, and business guests.</p>
      </div>
    </div>
  </div>
</section>

<section class="relative py-32 bg-cover bg-center bg-fixed overflow-hidden about-cta" style="background-image:url('<?= esc($aboutPage['ctaBackgroundImage'] ?? '') ?>')" aria-label="Call to action">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
    <div class="ornament mb-8">
      <span class="section-tag" style="color:#D4AE50"><?= esc($hotelName) ?></span>
    </div>
    <h2 class="font-display text-[clamp(2.5rem,6vw,5rem)] font-light text-white leading-[1.05] mb-8">
      Ready for a <em class="text-gold">Luxurious Stay?</em>
    </h2>
    <p class="text-white/50 text-base leading-relaxed max-w-lg mx-auto mb-10">
      Book your stay at <?= esc($hotelName) ?> and experience the comfort and hospitality Kurukshetra has to offer.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?= base_url('contact') ?>" class="btn-gold">Reserve Now</a>
      <a href="<?= base_url('rooms') ?>" class="btn-outline">View Rooms</a>
    </div>
  </div>
</section>
