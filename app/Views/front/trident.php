<?php
$tridentPage = $tridentPage ?? [];
$hotelName = $tridentPage['hotelName'] ?? app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone = $tridentPage['hotelPhone'] ?? app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail = $tridentPage['hotelEmail'] ?? app_setting('hotel_email', 'info@hotelhplus.in');
$hotelAddress = $tridentPage['hotelAddress'] ?? app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra');
$eventEmail = $tridentPage['eventEmail'] ?? app_setting('event_email', $hotelEmail);
$whatsAppNumber = $tridentPage['whatsAppNumber'] ?? (preg_replace('/\D+/', '', $hotelPhone) ?: '919253072122');
$eventTypes = $tridentPage['eventTypes'] ?? [];
$guestRanges = $tridentPage['guestRanges'] ?? [];
$galleryImages = $tridentPage['galleryImages'] ?? [];
$tridentEvents = $tridentPage['events'] ?? [];
?>

<section class="page-hero trident-hero" aria-label="Trident Banquet Hall hero">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($tridentPage['heroEyebrow'] ?? $hotelName) ?></span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      <?= esc($tridentPage['heroTitle'] ?? 'Trident') ?> <em class="text-gold"><?= esc($tridentPage['heroHighlight'] ?? 'Banquet Hall') ?></em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Trident</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-28 bg-ivory" aria-label="Venue Overview">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-20 items-center">
      <div class="relative hidden lg:block reveal-left">
        <div class="img-zoom-wrap" style="clip-path:polygon(0 0,100% 0,100% 95%,95% 100%,0 100%)">
          <img src="<?= esc($tridentPage['heroImage'] ?? base_url('assets/web/images/new/DSC_6616.webp')) ?>" alt="Trident Banquet Hall" width="700" height="900" class="w-full h-[540px] object-cover" />
        </div>
        <div class="absolute -bottom-10 -right-10 border-4 border-ivory shadow-2xl img-zoom-wrap" style="clip-path:polygon(0 0,100% 0,100% 100%,5% 100%,0 95%)">
          <img src="<?= esc($tridentPage['secondaryImage'] ?? base_url('assets/web/images/new/DSC_6608.webp')) ?>" alt="Banquet setup" width="320" height="240" loading="lazy" class="w-52 h-40 object-cover" />
        </div>
        <div class="absolute top-8 -right-6 bg-ink text-white px-5 py-4 shadow-xl">
          <p class="font-display text-3xl font-light text-gold leading-none"><?= esc($tridentPage['guestCapacity'] ?? '500+') ?></p>
          <p class="text-[9px] tracking-[0.2em] uppercase text-white/50 mt-1">Guest Capacity</p>
        </div>
      </div>

      <div class="reveal-right">
        <div class="ornament-left mb-6"><span class="section-tag"><?= esc($tridentPage['overviewEyebrow'] ?? 'The Venue') ?></span></div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.5rem)] font-light leading-[1.1] text-ink mb-6">
          <?= esc($tridentPage['overviewTitle'] ?? 'Where Every Celebration Becomes a') ?><br /><em class="text-gold"><?= esc($tridentPage['overviewHighlight'] ?? 'Grand Memory') ?></em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-5">
          <?= esc($tridentPage['overviewDescription'] ?? ('Trident Banquet Hall at ' . $hotelName . ' is a premium event venue in Kurukshetra, planned for weddings, receptions, conferences, and private celebrations that need scale, polish, and dependable service.')) ?>
        </p>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          <?= esc($tridentPage['overviewSecondaryDescription'] ?? 'From decor coordination and in-house catering to guest flow and event-day support, our team helps you host a smooth and memorable occasion from start to finish.') ?>
        </p>
        <div class="grid grid-cols-2 gap-0.5 mb-10">
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><?= esc($tridentPage['guestCapacity'] ?? '500+') ?></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Guests Capacity</p>
          </div>
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><?= esc($tridentPage['venueArea'] ?? '5000') ?></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Sq. Ft. Venue Area</p>
          </div>
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><i class="fa-solid fa-utensils text-xl"></i></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">In-house Catering</p>
          </div>
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><i class="fa-solid fa-car text-xl"></i></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Free Parking</p>
          </div>
        </div>
        <div class="flex flex-wrap gap-4">
          <a href="<?= base_url('contact') ?>" class="btn-gold">Enquire Now</a>
          <a href="tel:<?= esc($hotelPhone) ?>" class="btn-gold-outline"><i class="fa-solid fa-phone text-[10px]"></i> Call Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-ink" aria-label="Events We Host">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
      <div class="ornament mb-5"><span class="section-tag" style="color:#D4AE50">Event Types</span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-white">
        Perfect for Every <em class="text-gold">Occasion</em>
      </h2>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-0.5">
      <?php foreach ($tridentEvents as $index => $event): ?>
        <div class="bg-ink-800 border border-gold/10 p-8 hover:border-gold/30 transition-colors reveal delay-<?= esc((string) (($index % 6) + 1)) ?>" style="background:#1A1A18">
          <div class="w-12 h-12 border border-gold/20 text-gold flex items-center justify-center mb-5"><i class="fa-solid <?= esc($event['icon_class'] ?? 'fa-calendar-days') ?>"></i></div>
          <h3 class="font-display text-xl font-light text-white mb-3"><?= esc($event['title'] ?? 'Event') ?></h3>
          <p class="text-white/45 text-sm leading-relaxed"><?= esc($event['description'] ?? '') ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-24 bg-white" aria-label="Venue Features">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-16 reveal">
      <div class="ornament mb-5"><span class="section-tag">Facilities</span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink">
        Everything You Need <em class="text-gold">In One Place</em>
      </h2>
    </div>
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div class="img-zoom-wrap reveal-left" style="clip-path:polygon(0 0,100% 0,100% 95%,95% 100%,0 100%)">
        <img src="<?= esc($tridentPage['featuresImage'] ?? base_url('assets/web/images/new/DSC_6617.webp')) ?>" alt="Banquet venue interior" width="700" height="500" loading="lazy" class="w-full h-[440px] object-cover" />
      </div>
      <div class="reveal-right">
        <?php
        $features = [
            ['fa-snowflake', 'AC Hall', 'Fully air-conditioned venue for year-round comfort.'],
            ['fa-utensils', 'In-House Catering', 'Multi-cuisine menu options for social and formal occasions.'],
            ['fa-tv', 'AV & Sound System', 'Professional sound and presentation support for large events.'],
            ['fa-star', 'Stage & Podium', 'Stage-ready setup for performances, speeches, and ceremonies.'],
            ['fa-spa', 'Bridal Suite', 'A private preparation room for wedding and reception events.'],
            ['fa-car', 'Ample Parking', 'Convenient parking support for large guest movement.'],
            ['fa-wand-magic-sparkles', 'Decor Services', 'Decor coordination available for themed and elegant events.'],
            ['fa-headset', 'Event Support', 'A dedicated team helps manage setup and day-of coordination.'],
        ];
        foreach ($features as $index => [$icon, $title, $text]):
        ?>
          <div class="flex items-start gap-4 py-4 <?= $index < count($features) - 1 ? 'border-b border-gold/10' : '' ?>">
            <div class="w-9 h-9 border border-gold/20 flex items-center justify-center text-gold flex-shrink-0 mt-0.5"><i class="fa-solid <?= esc($icon) ?> text-xs"></i></div>
            <div>
              <p class="font-display text-lg font-light text-ink"><?= esc($title) ?></p>
              <p class="text-ink/50 text-sm"><?= esc($text) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-ivory" aria-label="Packages">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-6 reveal">
      <div class="ornament mb-5"><span class="section-tag">Pricing</span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink mb-4">
        Transparent Packages,<br /><em class="text-gold">No Hidden Costs</em>
      </h2>
      <p class="text-ink/55 text-[15px] leading-relaxed max-w-xl mx-auto">We offer flexible event packages based on guest count, decor, and catering needs. Contact us for a personalised quote.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-0.5 mt-12">
      <div class="bg-white border border-gold/15 p-8 reveal delay-1">
        <p class="text-[9px] tracking-[0.25em] uppercase text-ink/40 mb-5">Essentials</p>
        <h3 class="font-display text-2xl font-light text-ink mb-2">Basic Package</h3>
        <p class="text-ink/50 text-sm mb-6">Suitable for up to <strong class="text-ink">150 guests</strong></p>
        <div class="mb-8">
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Venue Rental</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Basic Decor</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">AC Hall</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Parking Support</span></div>
        </div>
        <div class="border-t border-gold/10 pt-6 flex items-end justify-between">
          <div>
            <p class="text-[9px] tracking-[0.15em] uppercase text-ink/30 mb-1">Starting at</p>
            <p class="font-display text-3xl font-light text-gold leading-none">Rs. 50,000</p>
          </div>
          <a href="<?= base_url('contact') ?>" class="btn-gold-outline text-[9px] py-2.5 px-5">Get Quote</a>
        </div>
      </div>

      <div class="bg-ink border border-gold/30 p-8 relative reveal delay-2" style="background:#111010">
        <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gold text-white text-[9px] tracking-[0.2em] uppercase px-4 py-1.5">Most Popular</div>
        <p class="text-[9px] tracking-[0.25em] uppercase text-gold/60 mb-5">Recommended</p>
        <h3 class="font-display text-2xl font-light text-white mb-2">Standard Package</h3>
        <p class="text-white/45 text-sm mb-6">Suitable for up to <strong class="text-white">300 guests</strong></p>
        <div class="mb-8">
          <div class="flex items-center gap-2.5 py-2 border-b border-gold/10"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-white/60 text-sm">Venue Rental</span></div>
          <div class="flex items-center gap-2.5 py-2 border-b border-gold/10"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-white/60 text-sm">Premium Decor</span></div>
          <div class="flex items-center gap-2.5 py-2 border-b border-gold/10"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-white/60 text-sm">Veg Catering</span></div>
          <div class="flex items-center gap-2.5 py-2 border-b border-gold/10"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-white/60 text-sm">AV Setup</span></div>
          <div class="flex items-center gap-2.5 py-2 border-b border-gold/10"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-white/60 text-sm">Bridal Suite</span></div>
          <div class="flex items-center gap-2.5 py-2"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-white/60 text-sm">Free Parking</span></div>
        </div>
        <div class="border-t border-gold/15 pt-6 flex items-end justify-between">
          <div>
            <p class="text-[9px] tracking-[0.15em] uppercase text-white/25 mb-1">Starting at</p>
            <p class="font-display text-3xl font-light text-gold leading-none">Rs. 1,20,000</p>
          </div>
          <a href="<?= base_url('contact') ?>" class="btn-gold text-[9px] py-2.5 px-5">Get Quote</a>
        </div>
      </div>

      <div class="bg-white border border-gold/15 p-8 reveal delay-3">
        <p class="text-[9px] tracking-[0.25em] uppercase text-ink/40 mb-5">All Inclusive</p>
        <h3 class="font-display text-2xl font-light text-ink mb-2">Premium Package</h3>
        <p class="text-ink/50 text-sm mb-6">Suitable for up to <strong class="text-ink">500 guests</strong></p>
        <div class="mb-8">
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Full Venue Rental</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Luxury Decor</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Veg + Non-Veg Catering</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Full AV + Lighting</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Bridal Suite + Stage</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Dedicated Coordinator</span></div>
          <div class="pkg-feature"><i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i><span class="text-ink/65 text-sm">Parking for Large Events</span></div>
        </div>
        <div class="border-t border-gold/10 pt-6 flex items-end justify-between">
          <div>
            <p class="text-[9px] tracking-[0.15em] uppercase text-ink/30 mb-1">Starting at</p>
            <p class="font-display text-3xl font-light text-gold leading-none">Rs. 2,50,000</p>
          </div>
          <a href="<?= base_url('contact') ?>" class="btn-gold-outline text-[9px] py-2.5 px-5">Get Quote</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-20 bg-white" aria-label="Venue gallery">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-10 reveal">
      <div class="ornament mb-4"><span class="section-tag">Gallery</span></div>
      <h2 class="font-display text-[clamp(1.8rem,3.5vw,2.8rem)] font-light text-ink">A Glimpse of <em class="text-gold">Trident</em></h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-0.5 reveal">
      <?php foreach (array_slice($galleryImages, 0, 5) as $index => $image): ?>
        <div class="img-zoom-wrap"><img src="<?= esc($image) ?>" alt="Trident gallery image <?= esc((string) ($index + 1)) ?>" width="400" loading="lazy" class="w-full h-40 object-cover" /></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="enquire" class="py-24 bg-ivory" aria-label="Event enquiry form">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-16 items-start">
      <div class="reveal-left">
        <div class="ornament-left mb-6"><span class="section-tag"><?= esc($tridentPage['contactEyebrow'] ?? 'Get In Touch') ?></span></div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light leading-[1.1] text-ink mb-5">
          <?= esc($tridentPage['contactTitle'] ?? 'Enquire About') ?><br /><em class="text-gold"><?= esc($tridentPage['contactHighlight'] ?? 'Your Event') ?></em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          <?= esc($tridentPage['contactDescription'] ?? 'Share your event plan and our team will get back to you with availability and package guidance.') ?>
        </p>
        <div class="space-y-5">
          <div class="flex items-start gap-4 p-5 bg-white border border-gold/15">
            <div class="w-10 h-10 border border-gold/20 flex items-center justify-center text-gold flex-shrink-0"><i class="fa-solid fa-phone text-sm"></i></div>
            <div>
              <p class="font-display text-base font-light text-ink">Call Us Directly</p>
              <a href="tel:<?= esc($hotelPhone) ?>" class="text-gold text-sm hover:text-gold-dark transition-colors"><?= esc($hotelPhone) ?></a>
            </div>
          </div>
          <div class="flex items-start gap-4 p-5 bg-white border border-gold/15">
            <div class="w-10 h-10 border border-gold/20 flex items-center justify-center text-[#25D366] flex-shrink-0"><i class="fa-brands fa-whatsapp text-sm"></i></div>
            <div>
              <p class="font-display text-base font-light text-ink">WhatsApp Us</p>
              <a href="https://wa.me/<?= esc($whatsAppNumber) ?>?text=Hi%2C%20I%27d%20like%20to%20enquire%20about%20Trident%20Banquet%20Hall." target="_blank" rel="noopener" class="text-[#25D366] text-sm hover:opacity-80 transition-opacity">Send a WhatsApp message</a>
            </div>
          </div>
          <div class="flex items-start gap-4 p-5 bg-white border border-gold/15">
            <div class="w-10 h-10 border border-gold/20 flex items-center justify-center text-gold flex-shrink-0"><i class="fa-solid fa-envelope text-sm"></i></div>
            <div>
              <p class="font-display text-base font-light text-ink">Email Us</p>
              <a href="mailto:<?= esc($eventEmail) ?>" class="text-gold text-sm hover:text-gold-dark transition-colors"><?= esc($eventEmail) ?></a>
            </div>
          </div>
          <div class="flex items-start gap-4 p-5 bg-white border border-gold/15">
            <div class="w-10 h-10 border border-gold/20 flex items-center justify-center text-gold flex-shrink-0"><i class="fa-solid fa-location-dot text-sm"></i></div>
            <div>
              <p class="font-display text-base font-light text-ink">Venue Address</p>
              <p class="text-ink/60 text-sm leading-relaxed"><?= esc($hotelAddress) ?></p>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal-right">
        <?php if (session('error')): ?>
          <div class="bg-red-50 border border-red-200 px-6 py-4 mb-6 text-sm text-ink">
            <i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i><?= session('error') ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('trident/send') ?>" method="post" class="bg-white border border-gold/15 p-8">
          <?= csrf_field() ?>
          <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-6">Event Enquiry Form</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
            <div>
              <label for="t-name" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Your Name <span class="text-gold">*</span></label>
              <input type="text" id="t-name" name="name" required value="<?= esc(old('name')) ?>" placeholder="Full name" class="form-field" />
            </div>
            <div>
              <label for="t-phone" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Phone <span class="text-gold">*</span></label>
              <input type="tel" id="t-phone" name="phone" required value="<?= esc(old('phone')) ?>" placeholder="+91 XXXXX XXXXX" class="form-field" />
            </div>
          </div>
          <div class="mb-3">
            <label for="t-email" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Email Address <span class="text-gold">*</span></label>
            <input type="email" id="t-email" name="email" required value="<?= esc(old('email')) ?>" placeholder="your@email.com" class="form-field" />
          </div>
          <div class="mb-3">
            <label for="t-event" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Event Type <span class="text-gold">*</span></label>
            <select id="t-event" name="event_type" required class="form-field form-select">
              <option value="">Select event type</option>
              <?php foreach ($eventTypes as $type): ?>
                <option value="<?= esc($type) ?>" <?= old('event_type') === $type ? 'selected' : '' ?>><?= esc($type) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
            <div>
              <label for="t-date" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Event Date</label>
              <input type="date" id="t-date" name="event_date" value="<?= esc(old('event_date')) ?>" min="<?= esc(date('Y-m-d')) ?>" class="form-field" />
            </div>
            <div>
              <label for="t-guests" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Expected Guests</label>
              <select id="t-guests" name="guests" class="form-field form-select">
                <option value="">Select range</option>
                <?php foreach ($guestRanges as $range): ?>
                  <option value="<?= esc($range) ?>" <?= old('guests') === $range ? 'selected' : '' ?>><?= esc($range) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="mb-6">
            <label for="t-message" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Additional Requirements</label>
            <textarea id="t-message" name="message" rows="4" placeholder="Catering preferences, decor ideas, special requests..." class="form-field trident-textarea"><?= esc(old('message')) ?></textarea>
          </div>
          <button type="submit" class="btn-gold w-full justify-center text-[11px]">
            <i class="fa-solid fa-paper-plane text-[10px]"></i> Send Enquiry
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-white" aria-label="Client testimonials">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-14 reveal">
      <div class="ornament mb-5"><span class="section-tag">What Clients Say</span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-light text-ink">
        Celebrated by <em class="text-gold">Every Guest</em>
      </h2>
    </div>
    <div class="grid md:grid-cols-3 gap-0.5">
      <div class="bg-ivory border border-gold/10 p-8 relative hover:border-gold/30 transition-colors reveal delay-1">
        <span class="quote-mark">"</span>
        <div class="flex gap-0.5 mb-5">
          <i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i>
        </div>
        <p class="text-ink/60 text-sm leading-[1.9] mb-6 italic">"We hosted our daughter's wedding reception at Trident and the experience felt organised from beginning to end. Food, decor, and guest handling were all excellent."</p>
        <div class="flex items-center gap-3 pt-5 border-t border-gold/10">
          <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold font-semibold">R</div>
          <div>
            <p class="font-display text-base font-light text-ink">Ramesh Gupta</p>
            <p class="text-[10px] tracking-[0.12em] uppercase text-ink/30">Wedding - 350 Guests</p>
          </div>
        </div>
      </div>
      <div class="bg-ink border border-gold/20 p-8 relative hover:border-gold/40 transition-colors reveal delay-2" style="background:#111010">
        <span class="quote-mark trident-quote-dark">"</span>
        <div class="flex gap-0.5 mb-5">
          <i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i>
        </div>
        <p class="text-white/60 text-sm leading-[1.9] mb-6 italic">"Our annual business event was handled professionally. The venue flow, audio support, and catering coordination made planning much easier for us."</p>
        <div class="flex items-center gap-3 pt-5 border-t border-gold/15">
          <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold font-semibold">P</div>
          <div>
            <p class="font-display text-base font-light text-white">Priya Malhotra</p>
            <p class="text-[10px] tracking-[0.12em] uppercase text-white/25">Corporate Event - 180 Guests</p>
          </div>
        </div>
      </div>
      <div class="bg-ivory border border-gold/10 p-8 relative hover:border-gold/30 transition-colors reveal delay-3">
        <span class="quote-mark">"</span>
        <div class="flex gap-0.5 mb-5">
          <i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star text-[#FBBC05] text-xs"></i><i class="fa-solid fa-star-half-stroke text-[#FBBC05] text-xs"></i>
        </div>
        <p class="text-ink/60 text-sm leading-[1.9] mb-6 italic">"For our large family gathering, the space was comfortable, the team stayed attentive, and parking and food service were handled really well."</p>
        <div class="flex items-center gap-3 pt-5 border-t border-gold/10">
          <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold font-semibold">S</div>
          <div>
            <p class="font-display text-base font-light text-ink">Sunil Kapoor</p>
            <p class="text-[10px] tracking-[0.12em] uppercase text-ink/30">Family Reunion - 200 Guests</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="relative py-32 overflow-hidden trident-cta" aria-label="Enquire now">
  <div class="relative max-w-3xl mx-auto px-6 text-center">
    <div class="ornament mb-8"><span class="section-tag" style="color:#D4AE50"><?= esc($tridentPage['ctaEyebrow'] ?? 'Plan Your Event') ?></span></div>
    <h2 class="font-display text-[clamp(2.5rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      <?= esc($tridentPage['ctaTitle'] ?? 'Ready to Plan Your') ?><br /><em class="text-gold"><?= esc($tridentPage['ctaHighlight'] ?? 'Dream Event?') ?></em>
    </h2>
    <p class="text-white/45 text-base leading-relaxed max-w-lg mx-auto mb-10"><?= esc($tridentPage['ctaDescription'] ?? 'Our events team is available to help you plan the right setup, guest experience, and package for your occasion.') ?></p>
    <div class="flex flex-wrap gap-4 justify-center">
      <a href="<?= base_url('contact') ?>" class="btn-gold">Enquire Now</a>
      <a href="tel:<?= esc($hotelPhone) ?>" class="btn-outline"><i class="fa-solid fa-phone text-[10px]"></i> Call Us</a>
    </div>
  </div>
</section>
