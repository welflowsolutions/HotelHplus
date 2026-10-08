<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail = app_setting('hotel_email', 'info@hotelhplus.in');
$successMessage = session('success') ?: 'We have received your request and our team will get back to you shortly.';
?>

<section class="page-hero thank-you-hero" aria-label="Thank you">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($hotelName) ?></span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Thank <em class="text-gold">You</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Thank You</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-20 lg:py-24 bg-ivory" aria-label="Submission confirmation">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-8 lg:gap-12 items-stretch">
      <div class="thank-panel reveal-left">
        <div class="thank-badge">
          <i class="fa-solid fa-circle-check text-3xl text-gold"></i>
        </div>
        <div class="ornament-left mb-6"><span class="section-tag">Message Received</span></div>
        <h2 class="font-display text-[clamp(2.4rem,5vw,4.3rem)] font-light text-ink leading-[1.05] mb-5">
          We have your<br><em class="text-gold">request.</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] max-w-xl mb-5">
          <?= esc($successMessage) ?>
        </p>
        <p class="text-ink/50 text-sm leading-[1.9] max-w-xl mb-10">
          For urgent assistance, you can call or email us directly and our team will help you right away.
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="<?= base_url('/') ?>" class="btn-gold">Back to Home</a>
          <a href="<?= base_url('rooms') ?>" class="btn-gold-outline">View Rooms</a>
          <a href="<?= base_url('contact') ?>" class="btn-thank-secondary">Contact Us</a>
        </div>
      </div>

      <div class="reveal-right">
        <div class="thank-side-card h-full">
          <p class="text-[10px] tracking-[0.24em] uppercase text-gold/70 mb-5">Direct Contact</p>
          <h3 class="font-display text-3xl font-light text-white mb-4">
            Need to speak with us<br><em class="text-gold">right now?</em>
          </h3>
          <p class="text-white/50 text-sm leading-[1.9] mb-8">
            We are available to help with room bookings, event enquiries, and general hotel assistance.
          </p>

          <div class="space-y-4">
            <a href="tel:<?= esc($hotelPhone) ?>" class="thank-contact-card">
              <span class="thank-contact-icon"><i class="fa-solid fa-phone"></i></span>
              <span>
                <span class="block text-[10px] tracking-[0.16em] uppercase text-white/35 mb-1">Call Us</span>
                <span class="text-white text-sm"><?= esc($hotelPhone) ?></span>
              </span>
            </a>
            <a href="mailto:<?= esc($hotelEmail) ?>" class="thank-contact-card">
              <span class="thank-contact-icon"><i class="fa-solid fa-envelope"></i></span>
              <span>
                <span class="block text-[10px] tracking-[0.16em] uppercase text-white/35 mb-1">Email Us</span>
                <span class="text-white text-sm"><?= esc($hotelEmail) ?></span>
              </span>
            </a>
          </div>

          <div class="mt-10 pt-8 border-t border-gold/10">
            <p class="text-white/35 text-sm leading-[1.8]">
              You can also continue browsing our rooms and facilities while we prepare a response.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
