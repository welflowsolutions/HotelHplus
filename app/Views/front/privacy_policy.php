<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail = app_setting('hotel_email', 'info@hotelhplus.in');
$hotelAddress = app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra, Haryana');
$legalPage = $legalPage ?? [];
?>

<section class="page-hero legal-hero" style="--hero-bg:url('<?= esc($legalPage['privacyHeroImage'] ?? '') ?>')" aria-label="Privacy Policy">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50">Legal</span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Privacy <em class="text-gold">Policy</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Privacy Policy</li>
      </ol>
    </nav>
    <p class="text-white/30 text-xs mt-3 tracking-wide">Last updated: <?= esc(date('F Y')) ?></p>
  </div>
</section>

<section class="py-20 bg-ivory" aria-label="Privacy policy content">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-4 gap-16">
      <aside class="lg:col-span-1 hidden lg:block">
        <div class="sticky top-28">
          <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-4">Contents</p>
          <nav aria-label="Table of contents">
            <a href="#collect" class="toc-link">1. Information We Collect</a>
            <a href="#use" class="toc-link">2. How We Use It</a>
            <a href="#cookies" class="toc-link">3. Cookies</a>
            <a href="#sharing" class="toc-link">4. Data Sharing</a>
            <a href="#security" class="toc-link">5. Data Security</a>
            <a href="#rights" class="toc-link">6. Your Rights</a>
            <a href="#contact" class="toc-link">7. Contact Us</a>
          </nav>
          <div class="mt-8 p-5 border border-gold/15 bg-white">
            <p class="text-[10px] tracking-[0.12em] uppercase text-ink/40 mb-3">Need Help?</p>
            <a href="<?= base_url('contact') ?>" class="btn-gold text-[9px] py-2.5 px-5 w-full justify-center">Contact Us</a>
          </div>
        </div>
      </aside>

      <div class="lg:col-span-3">
        <div class="bg-white border border-gold/10 p-8 lg:p-12">
          <p class="text-ink/55 text-[15px] leading-[1.9] mb-10 pb-8 border-b border-gold/10">
            At <?= esc($hotelName) ?>, we are committed to handling your information responsibly. This policy explains how we collect, use, store, and protect personal information you share with us while using our website or contacting the hotel.
          </p>

          <div id="collect" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">1. Information We Collect</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9] mb-4">We collect information that you voluntarily provide when you submit booking, contact, or event enquiry forms. This may include your name, email address, phone number, stay dates, event details, and other information relevant to your request.</p>
            <p class="text-ink/60 text-[15px] leading-[1.9]">We may also collect limited technical information such as browser type, IP address, and usage patterns for website performance and security purposes.</p>
          </div>

          <div id="use" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">2. How We Use Your Information</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9] mb-4">The information we collect may be used to:</p>
            <ul class="space-y-2 mb-4">
              <li class="legal-list-item"><i class="fa-solid fa-check text-gold text-xs mt-1.5 flex-shrink-0"></i>Process booking and stay enquiries</li>
              <li class="legal-list-item"><i class="fa-solid fa-check text-gold text-xs mt-1.5 flex-shrink-0"></i>Respond to contact and event requests</li>
              <li class="legal-list-item"><i class="fa-solid fa-check text-gold text-xs mt-1.5 flex-shrink-0"></i>Provide service-related communication</li>
              <li class="legal-list-item"><i class="fa-solid fa-check text-gold text-xs mt-1.5 flex-shrink-0"></i>Improve website experience and hotel operations</li>
              <li class="legal-list-item"><i class="fa-solid fa-check text-gold text-xs mt-1.5 flex-shrink-0"></i>Meet applicable legal or compliance needs</li>
            </ul>
          </div>

          <div id="cookies" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">3. Cookies</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">Our website may use cookies or similar technologies to support site functionality, remember browsing preferences, and understand general site usage. You can control cookie settings through your browser.</p>
          </div>

          <div id="sharing" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">4. Data Sharing</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">We do not sell your personal information. Information may be shared only where needed to support hotel operations, service fulfilment, or legal obligations.</p>
          </div>

          <div id="security" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">5. Data Security</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">We use reasonable administrative and technical measures to protect the information submitted through our website and business operations. While we take care to protect your data, no online method can guarantee absolute security.</p>
          </div>

          <div id="rights" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">6. Your Rights</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">You may contact us to request correction or deletion of personal information you have shared with us, subject to legal and operational requirements.</p>
          </div>

          <div id="contact" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">7. Contact Us</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9] mb-5">For privacy-related questions, please contact us:</p>
            <div class="border border-gold/15 p-6 bg-ivory">
              <p class="font-display text-lg font-light text-ink mb-3"><?= esc($hotelName) ?></p>
              <div class="space-y-2">
                <p class="text-ink/60 text-sm flex items-center gap-3"><i class="fa-solid fa-location-dot text-gold text-xs w-4"></i><?= esc($hotelAddress) ?></p>
                <p class="text-ink/60 text-sm flex items-center gap-3"><i class="fa-solid fa-envelope text-gold text-xs w-4"></i><a href="mailto:<?= esc($hotelEmail) ?>" class="hover:text-gold transition-colors"><?= esc($hotelEmail) ?></a></p>
                <p class="text-ink/60 text-sm flex items-center gap-3"><i class="fa-solid fa-phone text-gold text-xs w-4"></i><a href="tel:<?= esc($hotelPhone) ?>" class="hover:text-gold transition-colors"><?= esc($hotelPhone) ?></a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
