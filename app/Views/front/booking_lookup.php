<section class="page-hero thank-you-hero" aria-label="Find your booking">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50">Booking Lookup</span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Find Your Booking
    </h1>
    <p class="max-w-2xl text-white/60 text-base leading-[1.8]">
      Use your booking code with the email or phone number used during booking.
    </p>
  </div>
</section>

<section class="py-20 lg:py-24 bg-ivory">
  <div class="max-w-3xl mx-auto px-6 lg:px-10">
    <div class="rounded-[28px] border border-gold/12 bg-white p-8 lg:p-10">
      <?php if (! empty($lookupDisabled)): ?>
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-800">
          Guest booking lookup is currently disabled. Please contact the hotel team for booking status.
        </div>
      <?php else: ?>
        <form action="<?= base_url('booking/lookup') ?>" method="POST" class="space-y-5">
          <?= csrf_field() ?>
          <div>
            <label for="booking_code" class="mb-2 block text-sm font-medium text-ink">Booking Code</label>
            <input id="booking_code" name="booking_code" value="<?= old('booking_code') ?>" placeholder="BKG..."
                   class="w-full rounded-2xl border border-gold/15 bg-white px-5 py-4 text-sm text-ink outline-none transition focus:border-gold focus:ring-4 focus:ring-gold/10" required />
          </div>
          <div>
            <label for="identity" class="mb-2 block text-sm font-medium text-ink">Email or Phone</label>
            <input id="identity" name="identity" value="<?= old('identity') ?>" placeholder="name@example.com or mobile number"
                   class="w-full rounded-2xl border border-gold/15 bg-white px-5 py-4 text-sm text-ink outline-none transition focus:border-gold focus:ring-4 focus:ring-gold/10" required />
            <p class="mt-2 text-xs text-ink/45">For privacy, both details must match before status is shown.</p>
          </div>
          <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-gold">View Booking</button>
            <a href="<?= base_url('rooms') ?>" class="btn-gold-outline">Back to Rooms</a>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>
