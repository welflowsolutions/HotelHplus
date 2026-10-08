<?php
$localImageAvailable = static function (string $url): bool {
    $value = trim($url);

    if ($value === '' || preg_match('#^https?://#i', $value) !== 1) {
        return $value !== '';
    }

    $baseHost = parse_url(base_url('/'), PHP_URL_HOST);
    $imageHost = parse_url($value, PHP_URL_HOST);

    if ($imageHost !== null && $baseHost !== null && strcasecmp($imageHost, $baseHost) !== 0) {
        return true;
    }

    $basePath = parse_url(base_url('/'), PHP_URL_PATH) ?: '/';
    $path = parse_url($value, PHP_URL_PATH) ?: '';

    if ($path === '') {
        return true;
    }

    if ($basePath !== '/' && str_starts_with($path, rtrim($basePath, '/') . '/')) {
        $path = substr($path, strlen(rtrim($basePath, '/')));
    }

    return is_file(FCPATH . ltrim($path, '/'));
};

$gallery = $room['gallery_image_urls'] ?? [];
$gallery[] = $room['image_url'] ?? '';
$gallery[] = media_url($roomMeta['hero'] ?? '');
$gallery = array_values(array_unique(array_filter(array_map(static fn ($image): string => trim((string) $image), $gallery))));
$gallery = array_values(array_filter($gallery, $localImageAvailable));
$roomPageContent = $roomPageContent ?? [];
$guestCount = (int) ($room['max_guests'] ?? 0);
$guestSummaryTemplate = (string) ($roomPageContent['guestSummaryTemplate'] ?? 'This room is suitable for up to {guests} guest{plural} and includes the key amenities expected for a smooth hotel experience.');
$guestSummary = str_replace(
    ['{guests}', '{plural}'],
    [($guestCount > 0 ? (string) $guestCount : '0'), $guestCount === 1 ? '' : 's'],
    $guestSummaryTemplate
);

$alsoConsider = array_values(array_filter($rooms ?? [], static function (array $item) use ($room): bool {
    return ($item['slug'] ?? null) !== ($room['slug'] ?? null);
}));
?>

<section class="page-hero room-detail-hero" style="--hero-bg:url('<?= esc($room['image_url'] ?? $roomMeta['hero']) ?>')" aria-label="<?= esc($room['name']) ?>">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($roomMeta['label']) ?></span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      <?= esc($room['name']) ?>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex flex-wrap items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li><a href="<?= base_url('rooms') ?>" class="hover:text-gold transition-colors">Rooms</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold"><?= esc($room['name']) ?></li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-16 bg-ivory">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-3 gap-14">
      <div class="lg:col-span-2">
        <div class="mb-3 reveal">
          <div class="img-zoom-wrap" id="main-img-wrap">
            <img id="main-room-image"
              src="<?= esc($gallery[0]) ?>"
              alt="<?= esc($room['name']) ?> main view"
              class="w-full h-[420px] lg:h-[520px] object-cover">
          </div>
        </div>

        <?php if (count($gallery) > 1): ?>
          <div class="grid grid-cols-4 gap-2 mb-10 reveal">
            <?php foreach (array_slice($gallery, 0, 4) as $index => $image): ?>
              <img
                src="<?= esc($image) ?>"
                alt="<?= esc($room['name']) ?> view <?= $index + 1 ?>"
                class="thumb <?= $index === 0 ? 'active' : '' ?> w-full h-20 object-cover"
                onclick="swapRoomImage(this, '<?= esc($image, 'js') ?>')"
              >
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="mb-10 reveal">
          <div class="ornament-left mb-5"><span class="section-tag"><?= esc($roomPageContent['aboutEyebrow'] ?? 'About This Room') ?></span></div>
          <h2 class="font-display text-[clamp(1.8rem,3vw,2.5rem)] font-light text-ink mb-5">
            <?= esc($roomPageContent['headingPrefix'] ?? 'Comfortably designed for') ?><br><em class="text-gold"><?= esc($roomPageContent['headingHighlight'] ?? 'restful stays') ?></em>
          </h2>
          <p class="text-ink/60 text-[15px] leading-[1.9] mb-4">
            <?= esc($room['description']) ?>
          </p>
          <p class="text-ink/60 text-[15px] leading-[1.9]">
            <?= esc($guestSummary) ?>
          </p>
        </div>

        <div class="mb-10 reveal">
          <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-5"><?= esc($roomPageContent['amenitiesLabel'] ?? 'Room Amenities') ?></p>
          <div class="grid sm:grid-cols-2 gap-x-8">
            <?php foreach ($room['amenities'] as $amenity): ?>
              <div class="amenity-row">
                <i class="fa-solid fa-check text-gold text-xs w-5 flex-shrink-0"></i>
                <span class="text-ink/70 text-sm"><?= esc($amenity) ?></span>
              </div>
            <?php endforeach; ?>
            <div class="amenity-row">
              <i class="fa-solid fa-check text-gold text-xs w-5 flex-shrink-0"></i>
              <span class="text-ink/70 text-sm">Up to <?= esc($room['max_guests']) ?> Guest<?= (int) $room['max_guests'] > 1 ? 's' : '' ?></span>
            </div>
          </div>
        </div>

        <div class="bg-white border border-gold/15 p-6 reveal">
          <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70 mb-5"><?= esc($roomPageContent['policiesLabel'] ?? 'Room Policies') ?></p>
          <div class="grid sm:grid-cols-2 gap-4">
            <div class="flex items-start gap-3">
              <i class="fa-solid fa-right-to-bracket text-gold text-xs mt-1 w-4 flex-shrink-0"></i>
              <div><p class="text-xs font-medium text-ink tracking-wide">Check-in</p><p class="text-ink/50 text-sm"><?= esc($roomPageContent['checkinTime'] ?? '01:00 PM') ?> onwards</p></div>
            </div>
            <div class="flex items-start gap-3">
              <i class="fa-solid fa-right-from-bracket text-gold text-xs mt-1 w-4 flex-shrink-0"></i>
              <div><p class="text-xs font-medium text-ink tracking-wide">Check-out</p><p class="text-ink/50 text-sm">By <?= esc($roomPageContent['checkoutTime'] ?? '11:00 AM') ?></p></div>
            </div>
            <div class="flex items-start gap-3">
              <i class="fa-solid fa-ban text-gold text-xs mt-1 w-4 flex-shrink-0"></i>
              <div><p class="text-xs font-medium text-ink tracking-wide">Cancellation</p><p class="text-ink/50 text-sm"><?= esc($roomPageContent['cancellationText'] ?? 'Subject to reservation policy') ?></p></div>
            </div>
            <div class="flex items-start gap-3">
              <i class="fa-solid fa-id-card text-gold text-xs mt-1 w-4 flex-shrink-0"></i>
              <div><p class="text-xs font-medium text-ink tracking-wide">ID Required</p><p class="text-ink/50 text-sm"><?= esc($roomPageContent['idRequiredText'] ?? 'Valid photo ID at check-in') ?></p></div>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-1">
        <div class="sticky-bar reveal-right">
          <div id="room-booking" class="bg-white border border-gold/20 p-5 lg:p-6 shadow-xl">
            <div class="flex items-baseline gap-2 mb-1">
              <span class="font-display text-3xl font-light text-gold leading-none">₹<?= esc($room['price_display']) ?></span>
              <span class="text-ink/40 text-sm">/ night</span>
            </div>
            <p class="text-[10px] tracking-[0.12em] uppercase text-ink/30 mb-4">
              <?= ! empty($paymentGatewayActive) ? 'Room Booking' : 'Booking Request' ?>
            </p>

            <?php if (session('error')): ?>
              <div class="bg-red-50 border border-red-200 px-4 py-3 mb-4 text-sm text-ink">
                <i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i><?= session('error') ?>
              </div>
            <?php endif; ?>

            <?php if (! empty($paymentGatewayActive) && empty($paymentGatewayReady)): ?>
              <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800 mb-4">
                Online booking will appear here after payment gateway setup is completed.
              </div>
            <?php elseif (! empty($paymentGatewayActive) && empty($websiteBookingEnabled)): ?>
              <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700 mb-4">
                Booking is currently turned off on the website.
              </div>
            <?php elseif (! empty($paymentGatewayActive) && empty($roomBookingAllowed)): ?>
              <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700 mb-4">
                Booking is currently closed for this room.
              </div>
            <?php else: ?>
              <form action="<?= base_url('booking/send') ?>" method="post" class="space-y-3" data-booking-form data-nightly-rate="<?= esc((string) ($room['price'] ?? 0)) ?>" data-currency="INR" data-max-guests-per-room="<?= esc((string) max(1, (int) ($room['max_guests'] ?? 1))) ?>" data-available-units="<?= esc((string) max(1, (int) ($room['available_units'] ?? 1))) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="room_type" value="<?= esc($room['name']) ?>">
                <input type="hidden" name="room_slug" value="<?= esc($room['slug'] ?? '') ?>">

                <div class="rounded-2xl border border-gold/10 bg-ivory px-4 py-3">
                  <div class="flex items-center justify-between gap-4">
                    <div class="min-w-0">
                      <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Total payable</p>
                      <p class="text-xs text-ink/45 truncate">
                        <span data-booking-summary-nights>Select dates</span>
                        <span class="mx-1 text-gold/50">•</span>
                        <span data-booking-summary-rooms><?= esc((string) old('rooms_required', 1)) ?> Room<?= (int) old('rooms_required', 1) > 1 ? 's' : '' ?></span>
                        <span class="mx-1 text-gold/50">•</span>
                        <span data-booking-summary-guests><?= esc((string) old('guests', min(2, (int) $room['max_guests']))) ?> Guests</span>
                      </p>
                    </div>
                    <span class="font-display text-2xl font-light text-gold whitespace-nowrap" data-booking-summary-total>Choose dates</span>
                  </div>
                </div>

                <p class="text-[10px] tracking-[0.18em] uppercase text-gold/80 pt-1">Guest Details</p>
                <div class="grid sm:grid-cols-2 gap-2">
                  <div>
                  <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Name <span class="text-gold">*</span></label>
                  <input type="text" name="name" value="<?= esc(old('name')) ?>" required autocomplete="name" placeholder="Your full name" class="form-field">
                  </div>
                  <div>
                    <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Phone <span class="text-gold">*</span></label>
                    <input type="tel" name="phone" value="<?= esc(old('phone')) ?>" required autocomplete="tel" inputmode="tel" placeholder="+91 XXXXX XXXXX" class="form-field">
                  </div>
                </div>
                <div>
                  <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Email<?= ! empty($paymentGatewayActive) ? ' <span class="text-gold">*</span>' : '' ?></label>
                  <input type="email" name="email" value="<?= esc(old('email')) ?>" <?= ! empty($paymentGatewayActive) ? 'required' : '' ?> autocomplete="email" placeholder="you@example.com" class="form-field">
                </div>
                <p class="text-[10px] tracking-[0.18em] uppercase text-gold/80 pt-1">Stay Details</p>
                <div class="stay-details-row">
                  <div>
                    <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Check-in</label>
                    <input type="date" name="checkin" value="<?= esc(old('checkin')) ?>" required class="form-field date-field" data-checkin-input>
                  </div>
                  <div>
                    <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Check-out</label>
                    <input type="date" name="checkout" value="<?= esc(old('checkout')) ?>" required class="form-field date-field" data-checkout-input>
                  </div>
                  <div class="stay-guests-field">
                    <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Guests</label>
                    <input type="number" name="guests" value="<?= esc((string) old('guests', min(2, (int) $room['max_guests']))) ?>" min="1" max="500" step="1" inputmode="numeric" required class="form-field" data-guests-input>
                  </div>
                  <div class="stay-rooms-field">
                    <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Rooms Required</label>
                    <input
                      type="number"
                      name="rooms_required"
                      value="<?= esc((string) old('rooms_required', 1)) ?>"
                      min="1"
                      max="<?= esc((string) max(1, (int) ($room['available_units'] ?? 1))) ?>"
                      step="1"
                      inputmode="numeric"
                      required
                      class="form-field"
                      data-rooms-input
                    >
                    <p class="mt-1 text-[11px] text-ink/40">Max <?= esc((string) max(1, (int) ($room['available_units'] ?? 1))) ?> room<?= max(1, (int) ($room['available_units'] ?? 1)) > 1 ? 's' : '' ?></p>
                  </div>
                </div>
                <p class="hidden rounded-2xl border border-gold/15 bg-gold/5 px-3 py-2 text-[11px] leading-relaxed text-ink/55" data-capacity-message>
                  Please call the hotel for this group size.
                  <a href="tel:<?= esc(app_setting('hotel_phone', '+91 92530 72122')) ?>" class="text-gold hover:underline">Call now</a>
                </p>
                <div>
                  <label class="block text-[10px] tracking-[0.15em] uppercase text-ink/40 mb-1">Notes</label>
                  <textarea name="notes" rows="2" class="form-field resize-none" placeholder="Special requests"><?= esc(old('notes')) ?></textarea>
                </div>
                <?php if (! empty($paymentGatewayActive)): ?>
                  <p class="rounded-2xl border border-gold/10 bg-gold/5 px-3 py-2 text-[11px] leading-relaxed text-ink/55">
                    You will continue to <?= esc($paymentGatewayLabel ?? 'the payment gateway') ?> secure checkout after reviewing this amount.
                  </p>
                <?php endif; ?>
                <button type="submit" class="btn-gold w-full justify-center text-[11px]" data-booking-submit><?= ! empty($paymentGatewayActive) ? 'Proceed to Secure Payment' : 'Book Now' ?></button>
              </form>
            <?php endif; ?>

            <div class="mt-5 pt-5 border-t border-gold/10 space-y-3">
              <a href="tel:<?= esc(app_setting('hotel_phone', '+91 92530 72122')) ?>" class="flex items-center gap-2 text-ink/50 text-xs hover:text-gold transition-colors">
                <i class="fa-solid fa-phone text-gold text-[10px] w-4"></i> <?= esc(app_setting('hotel_phone', '+91 92530 72122')) ?>
              </a>
              <a href="https://wa.me/<?= esc(preg_replace('/[^0-9]/', '', (string) app_setting('hotel_whatsapp', app_setting('hotel_phone', '+91 92530 72122')))) ?>?text=<?= urlencode("I'd like to book the {$room['name']}.") ?>" target="_blank" rel="noopener" class="flex items-center gap-2 text-ink/50 text-xs hover:text-[#25D366] transition-colors">
                <i class="fa-brands fa-whatsapp text-[#25D366] text-sm w-4"></i> Book via WhatsApp
              </a>
            </div>
          </div>

          <?php if (! empty($alsoConsider)): ?>
            <div class="mt-5 bg-ink p-6">
              <p class="text-[9px] tracking-[0.2em] uppercase text-gold/60 mb-4">Also Consider</p>
              <?php foreach (array_slice($alsoConsider, 0, 2) as $index => $option): ?>
                <a href="<?= base_url('rooms/' . $option['slug']) ?>" class="flex items-center justify-between py-3 <?= $index === 0 ? 'border-b border-gold/10' : '' ?> hover:text-gold transition-colors group">
                  <div>
                    <p class="text-white/80 text-sm group-hover:text-gold transition-colors"><?= esc($option['name']) ?></p>
                    <p class="text-white/35 text-xs"><?= esc(implode(', ', array_slice($option['amenities'], 0, 2))) ?></p>
                  </div>
                  <span class="font-display text-lg text-gold">₹<?= esc($option['price_display']) ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-16 bg-white" aria-label="Guest reviews for <?= esc($room['name']) ?>">
  <div class="max-w-5xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-10">
      <p class="section-tag justify-center mb-2">Guest Reviews</p>
      <h2 class="font-display text-2xl font-light text-ink">What Guests Say About the <em class="text-gold"><?= esc($room['name']) ?></em></h2>
    </div>
    <div class="grid md:grid-cols-3 gap-0.5">
      <?php
      $reviews = [
          ['name' => 'Anita Sharma', 'city' => 'Kurukshetra', 'text' => 'Clean, comfortable room with everything you need. Great value for money and the staff were very helpful.'],
          ['name' => 'Mohan Das', 'city' => 'Delhi', 'text' => 'The room was spotless, the bed was comfortable, and the overall stay felt smooth and well managed.'],
          ['name' => 'Kavita Jain', 'city' => 'Chandigarh', 'text' => 'Excellent location, friendly staff and a well-maintained room. Good hotel for the price.'],
      ];
      foreach ($reviews as $review): ?>
        <div class="bg-ivory border border-gold/10 p-6 relative hover:border-gold/25 transition-colors">
          <span class="font-display text-[4.5rem] leading-none text-gold/10 absolute top-1 left-4 select-none">"</span>
          <div class="flex gap-0.5 mb-4">
            <i class="fa-solid fa-star text-[#FBBC05] text-[10px]"></i>
            <i class="fa-solid fa-star text-[#FBBC05] text-[10px]"></i>
            <i class="fa-solid fa-star text-[#FBBC05] text-[10px]"></i>
            <i class="fa-solid fa-star text-[#FBBC05] text-[10px]"></i>
            <i class="fa-solid fa-star text-[#FBBC05] text-[10px]"></i>
          </div>
          <p class="text-ink/60 text-sm leading-[1.85] mb-5 italic">"<?= esc($review['text']) ?>"</p>
          <div class="flex items-center gap-2.5 pt-4 border-t border-gold/10">
            <div class="w-9 h-9 rounded-full bg-ink/10 flex items-center justify-center text-ink/70 text-xs font-semibold">
              <?= esc(strtoupper(substr($review['name'], 0, 1))) ?>
            </div>
            <div>
              <p class="font-display text-sm font-light text-ink"><?= esc($review['name']) ?></p>
              <p class="text-[9px] tracking-[0.12em] uppercase text-ink/30"><?= esc($review['city']) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-20 bg-ink text-center">
  <div class="max-w-2xl mx-auto px-6">
    <p class="font-display text-[clamp(2rem,5vw,3.5rem)] font-light text-white mb-4">
      Ready to <em class="text-gold">Check In?</em>
    </p>
    <p class="text-white/45 text-sm mb-8">Call us, WhatsApp, or fill the form above and we will get back to you with booking details.</p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?= base_url('contact') ?>" class="btn-gold">Send Enquiry</a>
      <a href="tel:<?= esc(app_setting('hotel_phone', '+91 92530 72122')) ?>" class="btn-gold-outline room-call-btn"><i class="fa-solid fa-phone text-[10px]"></i> Call Now</a>
    </div>
  </div>
</section>
