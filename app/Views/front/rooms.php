<?php $roomCount = count($rooms ?? []); ?>

<section class="page-hero rooms-hero" aria-label="Rooms hero">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5">
      <span class="section-tag" style="color:#D4AE50">Hotel H Plus</span>
    </div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Rooms &amp; <em class="text-gold">Suites</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Rooms</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-16 bg-ivory" aria-label="Rooms introduction">
  <div class="max-w-3xl mx-auto px-6 text-center reveal">
    <div class="ornament mb-6">
      <span class="section-tag">Our Accommodations</span>
    </div>
    <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light leading-[1.1] text-ink mb-5">
      Indulge in Comfort and Luxury<br>
      <em class="text-gold">Every Stay.</em>
    </h2>
    <p class="text-ink/60 text-[15px] leading-[1.9]">
      Each room at Hotel H Plus is designed to offer the perfect balance of comfort, style, and functionality. From our thoughtfully appointed Deluxe Rooms to our spacious Executive Rooms, every stay is crafted for an exceptional experience.
    </p>
  </div>
</section>

<?php if ($roomCount > 0): ?>
  <section class="pb-16 bg-ivory" aria-label="Room comparison table">
    <div class="max-w-6xl mx-auto px-6 lg:px-10">
      <div class="text-center mb-8 reveal">
        <p class="text-[9px] tracking-[0.25em] uppercase text-gold/70">Compare</p>
        <h2 class="font-display text-2xl font-light text-ink mt-1">Room Comparison</h2>
      </div>

      <div class="comparison-shell reveal">
        <p class="comparison-scroll-hint">Swipe to compare rooms</p>
        <div class="overflow-x-auto pt-5 comparison-scroll">
        <table class="w-full min-w-[760px] border-collapse comparison-table" role="table">
          <thead>
            <tr>
              <th class="comparison-feature-head text-left py-5 pr-6 pl-8 text-[10px] tracking-[0.2em] uppercase text-ink/35 font-medium border-b border-gold/15 w-40">Feature</th>
              <?php foreach ($rooms as $index => $room): ?>
                <?php
                $isFeatured = $index === 1;
                $typeLabel = $index === 0 ? 'Standard' : ($index === 1 ? 'Popular' : 'Premium');
                ?>
                <th class="comparison-room-head py-5 px-5 text-center border-b <?= $isFeatured ? 'comparison-room-head-featured border-b-2 border-gold bg-gold/5 relative' : 'border-gold/15' ?>">
                  <?php if ($isFeatured): ?>
                    <div class="comparison-badge absolute -top-3 left-1/2 -translate-x-1/2 bg-gold text-white text-[8px] tracking-[0.18em] uppercase px-4 py-1.5 whitespace-nowrap">Most Popular</div>
                  <?php endif; ?>
                  <a href="<?= base_url('rooms/' . $room['slug']) ?>" class="group block comparison-room-link">
                    <span class="block text-[9px] tracking-[0.24em] uppercase <?= $isFeatured ? 'text-gold/75' : 'text-ink/40 group-hover:text-gold' ?> transition-colors"><?= esc($typeLabel) ?></span>
                    <span class="block font-display text-[2rem] leading-[1.05] font-light text-ink group-hover:text-gold transition-colors mt-2"><?= esc($room['name']) ?></span>
                    <span class="block font-display text-[2.15rem] leading-none font-light text-gold mt-4">₹<?= esc($room['price_display']) ?><span class="text-base text-ink/30">/night</span></span>
                  </a>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody class="text-sm comparison-table-body">
            <tr class="comparison-row border-b border-gold/8 hover:bg-gold/3 transition-colors">
              <td class="comparison-label py-4 pr-6 pl-8 text-[11px] tracking-[0.14em] uppercase text-ink/45">Max Guests</td>
              <?php foreach ($rooms as $index => $room): ?>
                <td class="comparison-value py-4 px-5 text-center text-ink/70 <?= $index === 1 ? 'comparison-value-featured bg-gold/5' : '' ?>"><?= esc($room['max_guests']) ?></td>
              <?php endforeach; ?>
            </tr>
            <tr class="comparison-row border-b border-gold/8 hover:bg-gold/3 transition-colors">
              <td class="comparison-label py-4 pr-6 pl-8 text-[11px] tracking-[0.14em] uppercase text-ink/45">Bed</td>
              <?php foreach ($rooms as $index => $room): ?>
                <td class="comparison-value py-4 px-5 text-center text-ink/70 <?= $index === 1 ? 'comparison-value-featured bg-gold/5' : '' ?>">
                  <?= esc($room['amenities'][0] ?? 'Comfort Bed') ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr class="comparison-row border-b border-gold/8 hover:bg-gold/3 transition-colors">
              <td class="comparison-label py-4 pr-6 pl-8 text-[11px] tracking-[0.14em] uppercase text-ink/45">Top Amenities</td>
              <?php foreach ($rooms as $index => $room): ?>
                <td class="comparison-value comparison-amenities py-4 px-5 text-center text-ink/70 <?= $index === 1 ? 'comparison-value-featured bg-gold/5' : '' ?>">
                  <?= esc(implode(' · ', array_slice($room['amenities'], 0, 3))) ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr class="comparison-cta-row">
              <td class="pt-7 pr-6 pl-8"></td>
              <?php foreach ($rooms as $index => $room): ?>
                <td class="pt-7 px-5 text-center <?= $index === 1 ? 'comparison-value-featured bg-gold/5' : '' ?>">
                  <a href="<?= base_url('rooms/' . $room['slug'] . '#room-booking') ?>" class="<?= $index === 1 ? 'bg-gold text-white hover:bg-gold-dark shadow-[0_16px_30px_rgba(184,150,46,0.22)]' : 'border border-gold/40 text-gold hover:bg-gold hover:text-white bg-white/80' ?> inline-flex items-center justify-center gap-1.5 text-[10px] tracking-[0.18em] uppercase px-5 py-3 transition-colors w-full comparison-cta">
                    Reserve Now
                  </a>
                </td>
              <?php endforeach; ?>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<section class="pb-24 bg-white" aria-label="Room categories">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 space-y-24">
    <?php foreach ($rooms as $index => $room): ?>
      <?php
      $reverse = $index % 2 === 1;
      $typeLabel = $index === 0 ? 'Standard' : ($index === 1 ? 'Popular' : 'Premium');
      ?>
      <div id="<?= esc($room['slug']) ?>" class="grid lg:grid-cols-2 gap-16 items-center">
        <div class="<?= $reverse ? 'lg:order-2 reveal-right' : 'reveal-left' ?> relative">
          <div class="img-zoom-wrap" style="clip-path: polygon(0 0,100% 0,100% 95%,95% 100%,0 100%)">
            <img src="<?= esc($room['image_url']) ?>"
              alt="<?= esc($room['name']) ?> at Hotel H Plus" width="800" height="600" loading="lazy"
              class="w-full h-[520px] object-cover" />
          </div>
          <div class="absolute top-5 left-5 bg-ink/85 backdrop-blur-sm text-white px-4 py-2">
            <span class="text-[10px] tracking-[0.2em] uppercase font-medium"><?= esc($typeLabel) ?></span>
          </div>
          <div class="absolute -bottom-4 -right-4 bg-gold text-white px-5 py-4 shadow-xl">
            <p class="font-display text-2xl font-light leading-none">₹<?= esc($room['price_display']) ?></p>
            <p class="text-[9px] tracking-[0.15em] uppercase text-white/70 mt-0.5">per night</p>
          </div>
        </div>

        <div class="<?= $reverse ? 'lg:order-1 reveal-left' : 'reveal-right' ?>">
          <div class="ornament-left mb-5">
            <span class="section-tag"><?= esc($typeLabel) ?></span>
          </div>
          <h2 class="font-display text-[clamp(2rem,3.5vw,3rem)] font-light leading-[1.1] text-ink mb-4">
            <?= esc($room['name']) ?>
          </h2>
          <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
            <?= esc($room['description']) ?>
          </p>

          <div class="mb-8">
            <?php foreach (array_slice($room['amenities'], 0, 6) as $amenity): ?>
              <div class="amenity-row">
                <i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i>
                <span class="text-ink/70 text-sm"><?= esc($amenity) ?></span>
              </div>
            <?php endforeach; ?>
            <div class="amenity-row">
              <i class="fa-solid fa-check text-gold text-xs w-4 flex-shrink-0"></i>
              <span class="text-ink/70 text-sm">Up to <?= esc($room['max_guests']) ?> Guest<?= (int) $room['max_guests'] > 1 ? 's' : '' ?></span>
            </div>
          </div>

          <div class="flex flex-wrap gap-4 items-center">
            <a href="<?= base_url('rooms/' . $room['slug']) ?>" class="btn-dark">View Details</a>
            <a href="<?= base_url('rooms/' . $room['slug'] . '#room-booking') ?>" class="btn-gold-outline">Reserve Now</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
