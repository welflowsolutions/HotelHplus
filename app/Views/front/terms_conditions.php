<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$legalPage = $legalPage ?? [];
?>

<section class="page-hero legal-hero" style="--hero-bg:url('<?= esc($legalPage['termsHeroImage'] ?? '') ?>')" aria-label="Terms and Conditions">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50">Legal</span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Terms &amp; <em class="text-gold">Conditions</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Terms &amp; Conditions</li>
      </ol>
    </nav>
    <p class="text-white/30 text-xs mt-3 tracking-wide">Last updated: <?= esc(date('F Y')) ?></p>
  </div>
</section>

<section class="py-20 bg-ivory" aria-label="Terms content">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-4 gap-16">
      <aside class="lg:col-span-1 hidden lg:block">
        <div class="sticky top-28">
          <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-4">Contents</p>
          <nav aria-label="Table of contents">
            <a href="#reservations" class="toc-link">1. Reservations</a>
            <a href="#checkin" class="toc-link">2. Check-in &amp; Check-out</a>
            <a href="#cancellation" class="toc-link">3. Cancellation</a>
            <a href="#payment" class="toc-link">4. Payment Terms</a>
            <a href="#conduct" class="toc-link">5. Guest Conduct</a>
            <a href="#liability" class="toc-link">6. Liability</a>
            <a href="#events" class="toc-link">7. Event Bookings</a>
            <a href="#law" class="toc-link">8. Governing Law</a>
          </nav>
          <div class="mt-8 p-5 border border-gold/15 bg-white">
            <p class="text-[10px] tracking-[0.12em] uppercase text-ink/40 mb-3">Questions?</p>
            <a href="<?= base_url('contact') ?>" class="btn-gold text-[9px] py-2.5 px-5 w-full justify-center">Contact Us</a>
          </div>
        </div>
      </aside>

      <div class="lg:col-span-3">
        <div class="bg-white border border-gold/10 p-8 lg:p-12">
          <p class="text-ink/55 text-[15px] leading-[1.9] mb-10 pb-8 border-b border-gold/10">
            Please read these terms carefully before booking a stay, submitting an enquiry, or using services offered by <?= esc($hotelName) ?>. By using our website or confirming a booking, you agree to these terms.
          </p>

          <div id="reservations" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">1. Reservations &amp; Bookings</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">All bookings are subject to availability and final confirmation from the hotel team. Submitting a request alone does not guarantee a confirmed reservation until the hotel responds and booking requirements are met.</p>
          </div>

          <div id="checkin" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">2. Check-in &amp; Check-out</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9] mb-4">Standard check-in begins at 12:00 PM and check-out is by 11:00 AM. Early check-in or late check-out may be available depending on room readiness and hotel approval.</p>
            <div class="highlight-box">
              <p class="text-ink/70 text-sm leading-relaxed"><strong class="text-ink">Valid identification may be required at check-in.</strong> Guests are expected to provide accurate contact and stay details during the booking process.</p>
            </div>
          </div>

          <div id="cancellation" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">3. Cancellation Policy</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">Cancellation handling depends on the booking type, timing, and any terms shared during confirmation. Special dates, group stays, or event-linked reservations may carry different cancellation rules.</p>
          </div>

          <div id="payment" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">4. Payment Terms</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">Advance payment or deposit may be required to secure a reservation. Final payment expectations are communicated by the hotel depending on the booking, room category, and package selected.</p>
          </div>

          <div id="conduct" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">5. Guest Conduct</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">Guests are expected to behave respectfully and lawfully while on hotel premises. The hotel reserves the right to refuse service or ask a guest to leave in cases of disruptive, unsafe, or damaging conduct.</p>
          </div>

          <div id="liability" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">6. Liability</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">The hotel is not responsible for indirect losses, unexpected disruptions, or events outside reasonable control. Guests remain responsible for their own belongings and for damage caused during their stay or event use.</p>
          </div>

          <div id="events" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">7. Event Bookings</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9] mb-4">Event bookings are subject to availability, scope, and hotel approval. Pricing, deposits, coordination requirements, and cancellation handling are shared by the team during the event confirmation process.</p>
            <div class="highlight-box">
              <p class="text-ink/70 text-sm leading-relaxed"><strong class="text-ink">Event details should be confirmed in advance.</strong> Final guest counts, decor, catering, timing, and operational requirements may affect the final event arrangement.</p>
            </div>
          </div>

          <div id="law" class="prose-section">
            <h2 class="font-display text-2xl font-light text-ink mb-4">8. Governing Law</h2>
            <p class="text-ink/60 text-[15px] leading-[1.9]">These terms are governed by applicable laws in India. Any dispute related to bookings, services, or use of hotel facilities will be handled under the appropriate local legal jurisdiction.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
