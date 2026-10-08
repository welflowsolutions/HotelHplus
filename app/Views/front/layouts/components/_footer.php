<?php
$hotelName      = app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone     = app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail     = app_setting('hotel_email', 'info@hotelhplus.in');
$hotelAddress   = app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra');
$hotelTagline   = app_setting('hotel_tagline', 'Best hotel near Pipli Road, Kurukshetra. Premium comfort, warm hospitality, 24/7 service.');
$footerDescription = 'Hotel H Plus in Kurukshetra offers refined comfort, warm hospitality, and elegant stays for families, business travellers, pilgrims, and leisure guests.';
$footerText     = app_setting('brand_footer_text', 'Hotel H Plus. All rights reserved.');
$facebook       = app_setting('brand_facebook', '#');
$instagram      = app_setting('brand_instagram', '#');
$xLink          = app_setting('brand_x', '#');
$brandLogo      = trim((string) app_setting('brand_logo', ''));
$brandLogoUrl   = media_url($brandLogo);
$brandSub       = strtoupper(trim((string) app_setting('brand_header_subtitle', 'KURUKSHETRA')));
$currencySymbol = $currencySymbol ?? app_setting('system_currency_symbol', '₹');
$footerRooms    = is_array($footerRooms ?? null) ? array_slice($footerRooms, 0, 3) : [];
?>
<footer style="background:#0A0A09" class="text-white pt-20 pb-8" aria-label="Footer">
  <div class="border-b border-gold/15 pb-12 mb-14">
    <?php
      $newsletterSuccess = session()->getFlashdata('newsletter_success');
      $newsletterError = session()->getFlashdata('newsletter_error');
    ?>
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
      <div class="max-w-2xl mx-auto text-center">
        <p class="text-[10px] tracking-[0.28em] uppercase text-gold/70 mb-4">Newsletter</p>
        <p class="font-display text-[2.6rem] md:text-[3rem] leading-[0.95] font-light text-white mb-4">Stay <em class="text-gold">Updated</em></p>
        <p class="text-white/45 text-sm md:text-[15px] leading-7 max-w-xl mx-auto">Subscribe for exclusive offers, fresh updates, and thoughtful hospitality news from Hotel H Plus.</p>
      </div>
      <div class="w-full max-w-2xl mx-auto mt-10">
        <form action="<?= base_url('subscribe') ?>" method="post" class="grid gap-3 md:grid-cols-2">
          <?= csrf_field() ?>
          <input type="hidden" name="return_url" value="<?= esc(current_url()) ?>">
          <input type="text" name="full_name" value="<?= esc(old('full_name')) ?>" placeholder="Your full name" aria-label="Full name for subscription"
            class="min-w-0 bg-white/5 border border-gold/20 px-5 py-4 text-sm text-white placeholder-white/30 outline-none focus:border-gold/50 focus:bg-white/[0.07] transition-colors text-left" />
          <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="Your email address" aria-label="Email for subscription"
            class="min-w-0 bg-white/5 border border-gold/20 px-5 py-4 text-sm text-white placeholder-white/30 outline-none focus:border-gold/50 focus:bg-white/[0.07] transition-colors text-left" />
          <div class="md:col-span-2 flex justify-center pt-3">
            <button type="submit" class="newsletter-submit bg-gold text-white px-10 py-4 text-[10px] tracking-[0.24em] uppercase font-medium hover:bg-gold-dark transition-colors whitespace-nowrap min-w-[240px] shadow-[0_18px_40px_rgba(184,150,46,0.18)]">Subscribe</button>
          </div>
        </form>
        <?php if ($newsletterSuccess): ?>
          <p class="mt-4 text-center text-xs tracking-[0.12em] uppercase text-gold/90"><?= esc($newsletterSuccess) ?></p>
        <?php endif; ?>
        <?php if ($newsletterError): ?>
          <p class="mt-4 text-center text-xs tracking-[0.04em] text-rose-300"><?= esc($newsletterError) ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
      <div>
        <div class="mb-5 max-w-[140px]">
          <a href="<?= base_url('/') ?>" class="block">
            <?php if ($brandLogoUrl !== ''): ?>
              <img src="<?= esc($brandLogoUrl) ?>" alt="Hotel H Plus" class="h-auto w-full object-contain" />
            <?php else: ?>
              <span class="font-display text-2xl font-light tracking-[0.18em] text-white">HOTEL <span class="text-gold font-semibold">H+</span></span>
            <?php endif; ?>
          </a>
        </div>
        <p class="text-white/35 text-sm leading-[1.8] mb-6"><?= esc($footerDescription) ?></p>
        <div class="flex gap-3">
          <?php if ($instagram !== '#'): ?>
            <a href="<?= esc($instagram) ?>" target="_blank" rel="noopener" aria-label="Instagram" class="w-8 h-8 border border-gold/20 flex items-center justify-center hover:border-gold hover:text-gold text-white/40 transition-colors">
              <i class="fa-brands fa-instagram text-xs"></i>
            </a>
          <?php endif; ?>
          <?php if ($facebook !== '#'): ?>
            <a href="<?= esc($facebook) ?>" target="_blank" rel="noopener" aria-label="Facebook" class="w-8 h-8 border border-gold/20 flex items-center justify-center hover:border-gold hover:text-gold text-white/40 transition-colors">
              <i class="fa-brands fa-facebook-f text-xs"></i>
            </a>
          <?php endif; ?>
          <?php if ($xLink !== '#'): ?>
            <a href="<?= esc($xLink) ?>" target="_blank" rel="noopener" aria-label="X" class="w-8 h-8 border border-gold/20 flex items-center justify-center hover:border-gold hover:text-gold text-white/40 transition-colors">
              <i class="fa-brands fa-x-twitter text-xs"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>
      <div>
        <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-5">Navigation</p>
        <ul class="space-y-3">
          <li><a href="<?= base_url('/') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">Home</a></li>
          <li><a href="<?= base_url('about') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">About Us</a></li>
          <li><a href="<?= base_url('rooms') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">Rooms &amp; Suites</a></li>
          <li><a href="<?= base_url('events') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">Events</a></li>
          <li><a href="<?= base_url('gallery') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">Gallery</a></li>
          <li><a href="<?= base_url('contact') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">Contact</a></li>
        </ul>
      </div>
      <div>
        <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-5">Our Rooms</p>
        <ul class="space-y-3">
          <?php foreach ($footerRooms as $room): ?>
            <li>
              <a href="<?= base_url('rooms/' . ($room['slug'] ?? '')) ?>" class="text-white/40 text-sm hover:text-gold transition-colors">
                <?= esc($room['name'] ?? 'Room') ?>
                <?php if (! empty($room['price_display'])): ?>
                  <span class="text-gold/50"><?= esc($currencySymbol) . esc($room['price_display']) ?></span>
                <?php endif; ?>
              </a>
            </li>
          <?php endforeach; ?>
          <li class="border-t border-white/5 pt-3">
            <a href="<?= base_url('booking/lookup') ?>" class="text-white/40 text-sm hover:text-gold transition-colors">
              Find Booking
            </a>
          </li>
        </ul>
      </div>
      <div>
        <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-5">Contact</p>
        <ul class="space-y-4">
          <li class="flex items-start gap-3">
            <i class="fa-solid fa-location-dot text-gold mt-1 text-xs flex-shrink-0"></i>
            <span class="text-white/40 text-sm leading-relaxed"><?= esc($hotelAddress) ?></span>
          </li>
          <li class="flex items-center gap-3">
            <i class="fa-solid fa-phone text-gold text-xs flex-shrink-0"></i>
            <a href="tel:<?= esc($hotelPhone) ?>" class="text-white/40 text-sm hover:text-gold transition-colors"><?= esc($hotelPhone) ?></a>
          </li>
          <li class="flex items-center gap-3">
            <i class="fa-solid fa-envelope text-gold text-xs flex-shrink-0"></i>
            <a href="mailto:<?= esc($hotelEmail) ?>" class="text-white/40 text-sm hover:text-gold transition-colors"><?= esc($hotelEmail) ?></a>
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
      <div class="flex flex-col items-center gap-2 sm:items-start">
        <p class="text-white/20 text-[11px] tracking-[0.12em]">© <?= date('Y') ?> <?= esc($footerText) ?></p>
        <p class="text-white/20 text-[11px] tracking-[0.12em]">
          Created by
          <a href="https://aarveya.com" target="_blank" rel="noopener" class="hover:text-gold transition-colors">
            Aarveya Digital
          </a>
        </p>
      </div>
      <div class="flex gap-6">
        <a href="<?= base_url('faq') ?>" class="text-white/20 text-[11px] tracking-[0.1em] hover:text-gold transition-colors uppercase">FAQ</a>
        <a href="<?= base_url('privacy-policy') ?>" class="text-white/20 text-[11px] tracking-[0.1em] hover:text-gold transition-colors uppercase">Privacy Policy</a>
        <a href="<?= base_url('terms-conditions') ?>" class="text-white/20 text-[11px] tracking-[0.1em] hover:text-gold transition-colors uppercase">Terms</a>
      </div>
    </div>
  </div>
</footer>
