<?php
$eventsPage = $eventsPage ?? [];
$hotelName = $eventsPage['hotelName'] ?? app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone = $eventsPage['hotelPhone'] ?? app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail = $eventsPage['hotelEmail'] ?? app_setting('hotel_email', 'info@hotelhplus.in');
$hotelAddress = $eventsPage['hotelAddress'] ?? app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra');
$eventsEmail = $eventsPage['eventsEmail'] ?? $hotelEmail;
$whatsAppNumber = $eventsPage['whatsAppNumber'] ?? (preg_replace('/\D+/', '', $hotelPhone) ?: '919253072122');
$services = $eventsPage['services'] ?? [];
$packages = $eventsPage['packages'] ?? [];
$galleryImages = $eventsPage['galleryImages'] ?? [];
$featureBullets = $eventsPage['featureBullets'] ?? [];
$guestRanges = $eventsPage['guestRanges'] ?? [];
$eventTypes = $eventsPage['eventTypes'] ?? [];
?>

<section class="page-hero events-hero" aria-label="Events hero">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5">
      <span class="section-tag" style="color:#D4AE50"><?= esc($eventsPage['heroEyebrow'] ?? 'Events') ?></span>
    </div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.02] mb-5 max-w-5xl">
      <?= esc($eventsPage['heroTitle'] ?? 'Thoughtfully Planned') ?>
      <em class="text-gold"><?= esc($eventsPage['heroHighlight'] ?? 'Celebrations') ?></em>
    </h1>
    <p class="max-w-3xl text-[15px] leading-[1.9] text-white/65 mb-7">
      <?= esc($eventsPage['heroDescription'] ?? ('From family functions to corporate gatherings, host events with polished spaces, attentive coordination, and guest-first hospitality at ' . $hotelName . '.')) ?>
    </p>
    <div class="flex flex-wrap gap-4">
      <a href="#event-enquiry" class="btn-gold">Plan Your Event</a>
      <a href="tel:<?= esc($hotelPhone) ?>" class="btn-outline"><i class="fa-solid fa-phone text-[10px]"></i> Call Us</a>
    </div>
  </div>
</section>

<section class="py-24 bg-ivory" aria-label="Events Overview">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-20 items-center">
      <div class="relative hidden lg:block reveal-left">
        <div class="img-zoom-wrap events-primary-frame">
          <img src="<?= esc($eventsPage['heroImage'] ?? '') ?>" alt="Events venue overview" width="700" height="900" class="w-full h-[560px] object-cover" />
        </div>
        <div class="absolute -bottom-10 -right-10 border-4 border-ivory shadow-2xl img-zoom-wrap events-secondary-frame">
          <img src="<?= esc($eventsPage['secondaryImage'] ?? '') ?>" alt="Event setup detail" width="320" height="240" loading="lazy" class="w-56 h-44 object-cover" />
        </div>
        <div class="absolute top-8 -right-6 bg-ink text-white px-5 py-4 shadow-xl">
          <p class="font-display text-3xl font-light text-gold leading-none"><?= esc($eventsPage['capacityStat'] ?? '300+') ?></p>
          <p class="text-[9px] tracking-[0.2em] uppercase text-white/50 mt-1">Guest Capacity</p>
        </div>
      </div>

      <div class="reveal-right">
        <div class="ornament-left mb-6">
          <span class="section-tag"><?= esc($eventsPage['overviewEyebrow'] ?? 'Why Choose Us') ?></span>
        </div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.5rem)] font-light leading-[1.08] text-ink mb-6">
          <?= esc($eventsPage['overviewTitle'] ?? 'A Flexible Venue Designed For') ?><br />
          <em class="text-gold"><?= esc($eventsPage['overviewHighlight'] ?? 'Memorable Events') ?></em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-5">
          <?= esc($eventsPage['overviewDescription'] ?? '') ?>
        </p>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          <?= esc($eventsPage['overviewSecondaryDescription'] ?? '') ?>
        </p>

        <div class="grid grid-cols-2 gap-0.5 mb-10">
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><?= esc($eventsPage['capacityStat'] ?? '300+') ?></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Guest Capacity</p>
          </div>
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><?= esc($eventsPage['areaStat'] ?? 'Custom setups') ?></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Layout Flexibility</p>
          </div>
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><?= esc($eventsPage['responseTimeStat'] ?? 'Quick response') ?></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Response Time</p>
          </div>
          <div class="bg-white border border-gold/15 px-5 py-4">
            <p class="font-display text-2xl font-light text-gold leading-none"><?= esc($eventsPage['supportStat'] ?? 'Planning support') ?></p>
            <p class="text-[10px] tracking-[0.15em] uppercase text-ink/40 mt-1">Host Support</p>
          </div>
        </div>

        <div class="flex flex-wrap gap-4">
          <a href="#event-enquiry" class="btn-gold">Check Availability</a>
          <a href="mailto:<?= esc($eventsEmail) ?>" class="btn-gold-outline"><i class="fa-solid fa-envelope text-[10px]"></i> Email Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-ink" aria-label="Event types and services">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center max-w-3xl mx-auto mb-14 reveal">
      <div class="ornament mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($eventsPage['servicesEyebrow'] ?? 'Event Types') ?></span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-white mb-4">
        <?= esc($eventsPage['servicesTitle'] ?? 'Perfect for Every') ?> <em class="text-gold"><?= esc($eventsPage['servicesHighlight'] ?? 'Occasion') ?></em>
      </h2>
      <p class="text-white/50 text-[15px] leading-[1.9]">
        <?= esc($eventsPage['servicesDescription'] ?? '') ?>
      </p>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-0.5">
      <?php foreach ($services as $index => $service): ?>
        <article class="bg-ink-800 border border-gold/10 p-8 hover:border-gold/30 transition-colors reveal delay-<?= esc((string) (($index % 4) + 1)) ?>" style="background:#1A1A18">
          <div class="w-12 h-12 border border-gold/20 text-gold flex items-center justify-center mb-5">
            <i class="fa-solid <?= esc($service['icon_class'] ?? 'fa-calendar-days') ?>"></i>
          </div>
          <h3 class="font-display text-2xl font-light text-white mb-3"><?= esc($service['title'] ?? 'Event Service') ?></h3>
          <p class="text-white/45 text-sm leading-[1.9]"><?= esc($service['description'] ?? '') ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-24 bg-white" aria-label="Event planning support">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div class="img-zoom-wrap reveal-left events-story-frame">
        <img src="<?= esc($eventsPage['storyImage'] ?? '') ?>" alt="Event planning support" width="700" height="500" loading="lazy" class="w-full h-[460px] object-cover" />
      </div>

      <div class="reveal-right">
        <div class="ornament-left mb-6">
          <span class="section-tag">Planning Support</span>
        </div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light leading-[1.1] text-ink mb-5">
          Built Around Smooth <em class="text-gold">Guest Experiences</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          We shaped the Events page around what guests usually need to decide quickly: clear event types, package direction, visual confidence, and a short enquiry path that feels easy on mobile.
        </p>

        <div class="space-y-1">
          <?php foreach ($featureBullets as $index => $feature): ?>
            <div class="flex items-start gap-4 py-4 <?= $index < count($featureBullets) - 1 ? 'border-b border-gold/10' : '' ?>">
              <div class="w-9 h-9 border border-gold/20 flex items-center justify-center text-gold flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-check text-xs"></i>
              </div>
              <div>
                <p class="font-display text-lg font-light text-ink"><?= esc($feature) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-24 bg-ivory" aria-label="Event packages">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center max-w-3xl mx-auto mb-14 reveal">
      <div class="ornament mb-5"><span class="section-tag"><?= esc($eventsPage['packagesEyebrow'] ?? 'Packages') ?></span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink mb-4">
        <?= esc($eventsPage['packagesTitle'] ?? 'Flexible Options For') ?> <em class="text-gold"><?= esc($eventsPage['packagesHighlight'] ?? 'Different Event Scales') ?></em>
      </h2>
      <p class="text-ink/55 text-[15px] leading-[1.9]"><?= esc($eventsPage['packagesDescription'] ?? '') ?></p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
      <?php foreach ($packages as $index => $package): ?>
        <?php $featured = ! empty($package['is_featured']); ?>
        <article class="event-package-card <?= $featured ? 'is-featured' : '' ?> reveal delay-<?= esc((string) (($index % 3) + 1)) ?>">
          <?php if (! empty($package['badge_text'])): ?>
            <div class="event-package-badge"><?= esc($package['badge_text']) ?></div>
          <?php endif; ?>

          <div class="event-package-shell">
            <p class="event-package-subtitle"><?= esc($package['subtitle'] ?: 'Event Package') ?></p>
            <h3 class="font-display text-[2.2rem] font-light leading-tight text-ink mb-3"><?= esc($package['title'] ?? 'Package') ?></h3>
            <p class="text-[11px] tracking-[0.16em] uppercase text-ink/45 mb-4"><?= esc($package['guest_range'] ?: 'Flexible guest count') ?></p>
            <p class="font-display text-[2rem] font-light text-gold leading-none mb-4"><?= esc($package['price_label'] ?: 'Custom quote') ?></p>
            <p class="text-ink/60 text-sm leading-[1.8] mb-6"><?= esc($package['description'] ?? '') ?></p>

            <div class="space-y-0 mb-8">
              <?php foreach (($package['features'] ?? []) as $feature): ?>
                <div class="pkg-feature">
                  <i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i>
                  <span class="text-ink/65 text-sm"><?= esc($feature) ?></span>
                </div>
              <?php endforeach; ?>
            </div>

            <a href="#event-enquiry" class="<?= $featured ? 'btn-gold' : 'btn-gold-outline' ?> w-full justify-center">
              Request This Package
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ($galleryImages !== []): ?>
<section class="py-20 bg-white" aria-label="Events gallery">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-10 reveal">
      <div class="ornament mb-4"><span class="section-tag">Gallery</span></div>
      <h2 class="font-display text-[clamp(1.8rem,3.5vw,2.8rem)] font-light text-ink">A Glimpse of <em class="text-gold">Our Event Experience</em></h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-0.5 reveal">
      <?php foreach (array_slice($galleryImages, 0, 5) as $index => $image): ?>
        <div class="img-zoom-wrap">
          <img src="<?= esc($image) ?>" alt="Events gallery image <?= esc((string) ($index + 1)) ?>" width="400" height="320" loading="lazy" class="w-full h-44 object-cover" />
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section id="event-enquiry" class="py-24 bg-ivory" aria-label="Event enquiry form">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-16 items-start">
      <div class="reveal-left">
        <div class="ornament-left mb-6"><span class="section-tag"><?= esc($eventsPage['contactEyebrow'] ?? 'Get In Touch') ?></span></div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light leading-[1.1] text-ink mb-5">
          <?= esc($eventsPage['contactTitle'] ?? 'Tell Us About') ?><br /><em class="text-gold"><?= esc($eventsPage['contactHighlight'] ?? 'Your Event') ?></em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          <?= esc($eventsPage['contactDescription'] ?? '') ?>
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
              <a href="https://wa.me/<?= esc($whatsAppNumber) ?>?text=Hi%2C%20I%27d%20like%20to%20enquire%20about%20an%20event%20at%20<?= urlencode($hotelName) ?>." target="_blank" rel="noopener" class="text-[#25D366] text-sm hover:opacity-80 transition-opacity">Send a WhatsApp message</a>
            </div>
          </div>
          <div class="flex items-start gap-4 p-5 bg-white border border-gold/15">
            <div class="w-10 h-10 border border-gold/20 flex items-center justify-center text-gold flex-shrink-0"><i class="fa-solid fa-envelope text-sm"></i></div>
            <div>
              <p class="font-display text-base font-light text-ink">Email Us</p>
              <a href="mailto:<?= esc($eventsEmail) ?>" class="text-gold text-sm hover:text-gold-dark transition-colors"><?= esc($eventsEmail) ?></a>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal-right">
        <div class="events-form-shell">
          <?php if (session('success')): ?>
            <div class="bg-gold/10 border border-gold/30 px-6 py-4 mb-6 text-sm text-ink">
              <i class="fa-solid fa-circle-check text-gold mr-2"></i><?= esc(session('success')) ?>
            </div>
          <?php endif; ?>

          <?php if (session('error')): ?>
            <div class="bg-red-50 border border-red-200 px-6 py-4 mb-6 text-sm text-ink">
              <i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i><?= session('error') ?>
            </div>
          <?php endif; ?>

          <form action="<?= base_url('events/send') ?>" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
              <div>
                <label for="event-name" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Full Name <span class="text-gold">*</span></label>
                <input type="text" id="event-name" name="name" value="<?= esc(old('name')) ?>" class="form-field" placeholder="Your full name" autocomplete="name" required>
              </div>
              <div>
                <label for="event-phone" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Phone Number <span class="text-gold">*</span></label>
                <input type="tel" id="event-phone" name="phone" value="<?= esc(old('phone')) ?>" class="form-field" placeholder="+91 XXXXX XXXXX" autocomplete="tel" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="event-email" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Email Address <span class="text-gold">*</span></label>
              <input type="email" id="event-email" name="email" value="<?= esc(old('email')) ?>" class="form-field" placeholder="you@example.com" autocomplete="email" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
              <div>
                <label for="event-type" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Event Type <span class="text-gold">*</span></label>
                <select id="event-type" name="event_type" class="form-field form-select" required>
                  <option value="">Select event type</option>
                  <?php foreach ($eventTypes as $eventType): ?>
                    <option value="<?= esc($eventType) ?>" <?= old('event_type') === $eventType ? 'selected' : '' ?>><?= esc($eventType) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div>
                <label for="event-guests" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Guest Range</label>
                <select id="event-guests" name="guests" class="form-field form-select">
                  <option value="">Select guest range</option>
                  <?php foreach ($guestRanges as $range): ?>
                    <option value="<?= esc($range) ?>" <?= old('guests') === $range ? 'selected' : '' ?>><?= esc($range) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="event-date" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Preferred Date</label>
              <input type="date" id="event-date" name="event_date" value="<?= esc(old('event_date')) ?>" class="form-field">
            </div>

            <div class="mb-6">
              <label for="event-message" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Tell us what you need</label>
              <textarea id="event-message" name="message" rows="5" class="form-field resize-none" placeholder="Share your event style, preferred date, guest count, and any package or setup ideas..."><?= esc(old('message')) ?></textarea>
            </div>

            <button type="submit" class="btn-gold w-full justify-center text-[11px]">
              <i class="fa-solid fa-paper-plane text-[10px]"></i>
              Send Event Enquiry
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="events-cta py-24" aria-label="Events call to action" style="--events-cta-bg:url('<?= esc($eventsPage['ctaBackgroundImage'] ?? '') ?>')">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="max-w-3xl text-center mx-auto reveal">
      <div class="ornament mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($eventsPage['ctaEyebrow'] ?? 'Plan Your Event') ?></span></div>
      <h2 class="font-display text-[clamp(2.2rem,5vw,4.5rem)] font-light text-white leading-[1.05] mb-5">
        <?= esc($eventsPage['ctaTitle'] ?? 'Ready to Start Planning') ?> <em class="text-gold"><?= esc($eventsPage['ctaHighlight'] ?? 'With Us?') ?></em>
      </h2>
      <p class="text-white/70 text-[15px] leading-[1.9] mb-8">
        <?= esc($eventsPage['ctaDescription'] ?? '') ?>
      </p>
      <div class="flex flex-wrap items-center justify-center gap-4">
        <a href="#event-enquiry" class="btn-gold">Enquire Now</a>
        <a href="<?= base_url('contact') ?>" class="btn-outline">Contact Hotel</a>
      </div>
    </div>
  </div>
</section>
