<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail = app_setting('hotel_email', 'info@hotelhplus.in');
$hotelAddress = app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra');
?>

<section class="page-hero contact-hero" aria-label="Contact hero">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5">
      <span class="section-tag" style="color:#D4AE50"><?= esc($hotelName) ?></span>
    </div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Contact <em class="text-gold">Us</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Contact</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-16 bg-ivory" aria-label="Contact information">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid sm:grid-cols-3 gap-6">
      <div class="info-card reveal delay-1">
        <div class="w-12 h-12 border border-gold/20 flex items-center justify-center mx-auto mb-5 text-gold">
          <i class="fa-solid fa-hotel"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Visit &amp; Explore</h3>
        <p class="text-ink/60 text-sm leading-[1.8]"><?= nl2br(esc($hotelAddress)) ?></p>
        <a href="https://maps.google.com/maps?q=<?= urlencode($hotelAddress) ?>" target="_blank" rel="noopener"
          class="inline-flex items-center gap-2 mt-4 text-[10px] tracking-[0.18em] uppercase text-gold hover:text-gold-dark transition-colors">
          Get Directions <i class="fa-solid fa-arrow-right text-[8px]"></i>
        </a>
      </div>

      <div class="info-card reveal delay-2">
        <div class="w-12 h-12 border border-gold/20 flex items-center justify-center mx-auto mb-5 text-gold">
          <i class="fa-solid fa-phone"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Give a Call</h3>
        <p class="text-ink/60 text-sm leading-[1.8] mb-1">Available 24 hours, 7 days</p>
        <a href="tel:<?= esc($hotelPhone) ?>" class="text-gold font-medium text-sm hover:text-gold-dark transition-colors"><?= esc($hotelPhone) ?></a>
      </div>

      <div class="info-card reveal delay-3">
        <div class="w-12 h-12 border border-gold/20 flex items-center justify-center mx-auto mb-5 text-gold">
          <i class="fa-solid fa-envelope"></i>
        </div>
        <h3 class="font-display text-xl font-light text-ink mb-3">Send an Email</h3>
        <p class="text-ink/60 text-sm leading-[1.8] mb-1">We respond within 24 hours</p>
        <a href="mailto:<?= esc($hotelEmail) ?>" class="text-gold font-medium text-sm hover:text-gold-dark transition-colors"><?= esc($hotelEmail) ?></a>
      </div>
    </div>
  </div>
</section>

<section class="py-20 bg-white" aria-label="Enquiry form and location">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-16">
      <div class="reveal-left">
        <div class="ornament-left mb-5">
          <span class="section-tag">Get In Touch</span>
        </div>
        <h2 class="font-display text-[clamp(2rem,3.5vw,3rem)] font-light leading-[1.1] text-ink mb-4">
          Send Us a <em class="text-gold">Message</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          Fill in the form below and our team will get back to you within 24 hours. For immediate assistance, call us directly at <a href="tel:<?= esc($hotelPhone) ?>" class="text-gold hover:text-gold-dark transition-colors"><?= esc($hotelPhone) ?></a>.
        </p>

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

        <form action="<?= base_url('contact/send') ?>" method="post" novalidate>
          <?= csrf_field() ?>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
            <div>
              <label for="first-name" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">First Name <span class="text-gold">*</span></label>
              <input type="text" id="first-name" name="first_name" value="<?= esc(old('first_name')) ?>" class="form-field" placeholder="First name" autocomplete="given-name" required>
            </div>
            <div>
              <label for="last-name" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Last Name <span class="text-gold">*</span></label>
              <input type="text" id="last-name" name="last_name" value="<?= esc(old('last_name')) ?>" class="form-field" placeholder="Last name" autocomplete="family-name" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Email Address <span class="text-gold">*</span></label>
            <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" class="form-field" placeholder="your@email.com" autocomplete="email" required>
          </div>

          <div class="mb-3">
            <label for="phone" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Phone Number <span class="text-ink/30">(optional)</span></label>
            <input type="tel" id="phone" name="phone" value="<?= esc(old('phone')) ?>" class="form-field" placeholder="+91 XXXXX XXXXX" autocomplete="tel">
          </div>

          <div class="mb-3">
            <label for="subject" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Subject <span class="text-gold">*</span></label>
            <input type="text" id="subject" name="subject" value="<?= esc(old('subject')) ?>" class="form-field" placeholder="Room enquiry / Special request..." required>
          </div>

          <div class="mb-3">
            <label for="room-type" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Room Interest</label>
            <select id="room-type" name="room_type" class="form-field">
              <option value="">Select Room Type</option>
              <?php foreach ($rooms as $room): ?>
                <option value="<?= esc($room['name']) ?>" <?= old('room_type') === $room['name'] ? 'selected' : '' ?>>
                  <?= esc($room['name']) ?><?php if (! empty($room['price_display'])): ?> (₹<?= esc($room['price_display']) ?>/night)<?php endif; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
            <div>
              <label for="checkin" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Check-in Date</label>
              <input type="date" id="checkin" name="checkin" value="<?= esc(old('checkin')) ?>" class="form-field">
            </div>
            <div>
              <label for="checkout" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Check-out Date</label>
              <input type="date" id="checkout" name="checkout" value="<?= esc(old('checkout')) ?>" class="form-field">
            </div>
          </div>

          <div class="mb-6">
            <label for="message" class="block text-[10px] tracking-[0.15em] uppercase text-ink/50 mb-1.5">Message <span class="text-gold">*</span></label>
            <textarea id="message" name="message" rows="5" class="form-field resize-none" placeholder="Tell us about your requirements, special requests or any questions..." required><?= esc(old('message')) ?></textarea>
          </div>

          <button type="submit" class="btn-gold w-full justify-center text-[11px]">
            <i class="fa-solid fa-paper-plane text-[10px]"></i>
            Send Enquiry
          </button>
        </form>
      </div>

      <div class="reveal-right">
        <div class="ornament-left mb-5">
          <span class="section-tag">Visit Us</span>
        </div>
        <h2 class="font-display text-[clamp(2rem,3.5vw,3rem)] font-light leading-[1.1] text-ink mb-4">
          Find us on <em class="text-gold">Pipli Road</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          We are easy to reach for both city travellers and highway guests. You can use the map below, call us directly, or message on WhatsApp for assistance.
        </p>
        <div class="border border-gold/15 overflow-hidden min-h-[420px]">
          <iframe
            title="Hotel map"
            class="w-full h-[420px]"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=<?= urlencode($hotelAddress) ?>&output=embed">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>
