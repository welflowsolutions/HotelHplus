<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$galleryPayload = json_encode(array_map(static function (array $image): array {
    return [
        'src'      => $image['full_url'],
        'caption'  => $image['caption'],
        'alt'      => $image['alt'] ?? $image['caption'],
        'category' => $image['category'],
    ];
}, $images), JSON_UNESCAPED_SLASHES);
?>

<section class="page-hero gallery-hero" aria-label="Gallery hero">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($hotelName) ?></span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Our <em class="text-gold">Gallery</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Gallery</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-12 bg-ivory" aria-label="Gallery introduction">
  <div class="max-w-2xl mx-auto px-6 text-center reveal">
    <div class="ornament mb-6"><span class="section-tag">Our Gallery</span></div>
    <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-light leading-[1.1] text-ink mb-4">
      A glimpse of <em class="text-gold">our spaces.</em>
    </h2>
    <p class="text-ink/60 text-[15px] leading-[1.9]">
      Explore rooms, shared spaces, and the overall atmosphere that shape the <?= esc($hotelName) ?> experience.
    </p>
  </div>
</section>

<section class="py-6 bg-ivory" aria-label="Gallery filter">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="flex flex-wrap justify-center gap-0 border-b border-gold/15" role="tablist" aria-label="Filter gallery by category">
      <button class="filter-btn active" data-filter="all" onclick="filterGallery(this, 'all')">All</button>
      <button class="filter-btn" data-filter="rooms" onclick="filterGallery(this, 'rooms')">Rooms</button>
      <button class="filter-btn" data-filter="lobby" onclick="filterGallery(this, 'lobby')">Lobby</button>
      <button class="filter-btn" data-filter="exterior" onclick="filterGallery(this, 'exterior')">Exterior</button>
      <button class="filter-btn" data-filter="dining" onclick="filterGallery(this, 'dining')">Dining</button>
      <button class="filter-btn" data-filter="events" onclick="filterGallery(this, 'events')">Events</button>
    </div>
  </div>
</section>

<section class="pb-24 bg-ivory" aria-label="Photo gallery">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="columns-2 md:columns-3 lg:columns-4 gallery-columns">
      <?php foreach ($images as $index => $image): ?>
        <div
          class="gallery-item break-inside-avoid mb-3 reveal"
          data-cat="<?= esc($image['category']) ?>"
          data-src="<?= esc($image['full_url']) ?>"
          data-label="<?= esc($image['caption']) ?>"
          data-index="<?= $index ?>"
          onclick="openLightbox(<?= $index ?>)"
        >
          <img src="<?= esc($image['thumb_url']) ?>" alt="<?= esc($image['alt'] ?? $image['caption']) ?>" class="w-full object-cover">
          <div class="gallery-overlay">
            <i class="fa-solid fa-magnifying-glass-plus text-white text-xl"></i>
            <span class="text-white text-[10px] tracking-[0.2em] uppercase"><?= esc($image['category']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div id="lightbox">
  <button id="lb-close" type="button" onclick="closeLightbox()"><i class="fa-solid fa-xmark"></i></button>
  <button id="lb-prev" type="button" onclick="stepLightbox(-1)"><i class="fa-solid fa-chevron-left"></i></button>
  <img id="lb-image" src="" alt="">
  <button id="lb-next" type="button" onclick="stepLightbox(1)"><i class="fa-solid fa-chevron-right"></i></button>
  <div id="lb-caption"></div>
</div>

<script type="application/json" id="gallery-items-data"><?= $galleryPayload ?></script>
