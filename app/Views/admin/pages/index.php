<?php
$activePagesTab = $activePagesTab ?? 'homepage';
$isStandaloneEditor = $isStandaloneEditor ?? false;
$editorMeta = $editorMeta ?? [
    'title' => 'Page Editor',
    'description' => 'Update page content and image slots.',
];
$editorSectionsMap = [
    'homepage' => ['homepage-images' => 'Page Images'],
    'aboutpage' => ['about-images' => 'Images'],
    'legalpage' => ['legal-images' => 'Hero Images'],
    'tridentpage' => ['trident-images' => 'Images'],
    'gallerypage' => ['gallery-page-items' => 'Gallery Items'],
];
$editorSections = $editorSectionsMap[$activePagesTab] ?? [];

$hotelName = old('hotel_name', $settings['hotel_name'] ?? 'Hotel H Plus');
$hotelEmail = old('hotel_email', $settings['hotel_email'] ?? 'info@hotelhplus.in');

$homeHeroEyebrow = old('home_hero_eyebrow', $settings['home_hero_eyebrow'] ?? 'Best Hotel in Kurukshetra');
$homeHeroTitlePrefix = old('home_hero_title_prefix', $settings['home_hero_title_prefix'] ?? 'Welcome to');
$homeHeroTitleHighlight = old('home_hero_title_highlight', $settings['home_hero_title_highlight'] ?? $hotelName);
$homeHeroDescription = old('home_hero_description', $settings['home_hero_description'] ?? 'A refined stay on Pipli Road, Kurukshetra, where comfort, hospitality, and thoughtful details come together beautifully.');
$homeHeroGuestCount = old('home_hero_guest_count', $settings['home_hero_guest_count'] ?? '10,000+ guests');
$homeHeroReviewText = old('home_hero_review_text', $settings['home_hero_review_text'] ?? '750+ Google Reviews');
$homeHeroImage = old('home_hero_image', $settings['home_hero_image'] ?? 'assets/web/images/homepage-hero-bg.webp');
$homeHeroSecondaryImage = old('home_hero_secondary_image', $settings['home_hero_secondary_image'] ?? 'assets/web/images/new/DSC_6631.webp');
$homeStatsRooms = old('home_stats_rooms', $settings['home_stats_rooms'] ?? '15+');
$homeStatsStaff = old('home_stats_staff', $settings['home_stats_staff'] ?? '10+');
$homeStatsHappyClients = old('home_stats_happy_clients', $settings['home_stats_happy_clients'] ?? '100%');
$homeStatsReviews = old('home_stats_reviews', $settings['home_stats_reviews'] ?? '750+');
$homeStatsBackgroundImage = old('home_stats_background_image', $settings['home_stats_background_image'] ?? 'assets/web/images/homepage-hero-bg.webp');
$homeAboutEyebrow = old('home_about_eyebrow', $settings['home_about_eyebrow'] ?? 'About Us');
$homeAboutTitle = old('home_about_title', $settings['home_about_title'] ?? 'Experience Premium Comfort & Elegance');
$homeAboutHighlight = old('home_about_highlight', $settings['home_about_highlight'] ?? 'Comfort & Elegance');
$homeAboutDescription = old('home_about_description', $settings['home_about_description'] ?? 'Enjoy a peaceful and elegant stay at Hotel H Plus, Kurukshetra. Our well-furnished rooms, warm hospitality, and 24/7 service ensure a comfortable experience for families, business travelers, and guests seeking relaxation.');
$homeAboutMission = old('home_about_mission', $settings['home_about_mission'] ?? 'To provide premium comfort, reliable service, and a welcoming environment for every guest who walks through our doors.');
$homeAboutVision = old('home_about_vision', $settings['home_about_vision'] ?? 'To become the most trusted and preferred luxury hotel in Kurukshetra — a place guests return to again and again.');
$homeAboutValues = old('home_about_values', $settings['home_about_values'] ?? 'Hospitality, cleanliness, safety, and unwavering guest satisfaction above everything else.');
$homeAboutImage = old('home_about_image', $settings['home_about_image'] ?? 'assets/web/images/new/DSC_6608.webp');
$homeAboutSecondaryImage = old('home_about_secondary_image', $settings['home_about_secondary_image'] ?? 'assets/web/images/new/DSC_6613.webp');
$homeRoomsEyebrow = old('home_rooms_eyebrow', $settings['home_rooms_eyebrow'] ?? 'Rooms & Suites');
$homeRoomsTitle = old('home_rooms_title', $settings['home_rooms_title'] ?? 'Indulge in Comfort Every Stay.');
$homeRoomsHighlight = old('home_rooms_highlight', $settings['home_rooms_highlight'] ?? 'Every Stay.');
$homeRoomsDescription = old('home_rooms_description', $settings['home_rooms_description'] ?? 'Experience ultimate relaxation, luxury, and world-class hospitality during every visit.');
$homeOfferEyebrow = old('home_offer_eyebrow', $settings['home_offer_eyebrow'] ?? 'Today\'s Offer');
$homeOfferTitle = old('home_offer_title', $settings['home_offer_title'] ?? 'Exclusive Limited-Time Offer This Month');
$homeOfferHighlight = old('home_offer_highlight', $settings['home_offer_highlight'] ?? 'Offer This Month');
$homeOfferDescription = old('home_offer_description', $settings['home_offer_description'] ?? 'Enjoy a special discounted stay at Hotel H Plus. Whether you\'re planning a family trip or a business visit, this is the perfect time to experience premium comfort at exceptional value.');
$homeOfferSecondaryDescription = old('home_offer_secondary_description', $settings['home_offer_secondary_description'] ?? 'Book now and take advantage of our limited-time savings before the offer ends.');
$homeOfferDiscountText = old('home_offer_discount_text', $settings['home_offer_discount_text'] ?? '30%');
$homeOfferImage = old('home_offer_image', $settings['home_offer_image'] ?? 'assets/web/images/new/DSC_6621.webp');
$homeCtaEyebrow = old('home_cta_eyebrow', $settings['home_cta_eyebrow'] ?? 'Book Now');
$homeCtaTitle = old('home_cta_title', $settings['home_cta_title'] ?? 'Ready for a Luxurious Stay?');
$homeCtaHighlight = old('home_cta_highlight', $settings['home_cta_highlight'] ?? 'Luxurious Stay?');
$homeCtaDescription = old('home_cta_description', $settings['home_cta_description'] ?? 'Experience comfort, elegance, and warm hospitality at ' . $hotelName . '.');
$homeCtaBackgroundImage = old('home_cta_background_image', $settings['home_cta_background_image'] ?? 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp');

$aboutStoryImage = old('about_story_image', $settings['about_story_image'] ?? 'assets/web/images/new/DSC_6608.webp');
$aboutStorySecondaryImage = old('about_story_secondary_image', $settings['about_story_secondary_image'] ?? 'assets/web/images/new/DSC_6614.webp');
$aboutTeamImage1 = old('about_team_image_1', $settings['about_team_image_1'] ?? '');
$aboutTeamImage2 = old('about_team_image_2', $settings['about_team_image_2'] ?? '');
$aboutTeamImage3 = old('about_team_image_3', $settings['about_team_image_3'] ?? '');
$aboutCtaBackgroundImage = old('about_cta_background_image', $settings['about_cta_background_image'] ?? 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp');

$legalPrivacyHeroImage = old('legal_privacy_hero_image', $settings['legal_privacy_hero_image'] ?? '');
$legalTermsHeroImage = old('legal_terms_hero_image', $settings['legal_terms_hero_image'] ?? '');

$roomDetailAboutEyebrow = old('room_detail_about_eyebrow', $settings['room_detail_about_eyebrow'] ?? 'About This Room');
$roomDetailHeadingPrefix = old('room_detail_heading_prefix', $settings['room_detail_heading_prefix'] ?? 'Comfortably designed for');
$roomDetailHeadingHighlight = old('room_detail_heading_highlight', $settings['room_detail_heading_highlight'] ?? 'restful stays');
$roomDetailGuestSummaryTemplate = old('room_detail_guest_summary_template', $settings['room_detail_guest_summary_template'] ?? 'This room is suitable for up to {guests} guest{plural} and includes the key amenities expected for a smooth hotel experience.');
$roomDetailAmenitiesLabel = old('room_detail_amenities_label', $settings['room_detail_amenities_label'] ?? 'Room Amenities');
$roomDetailPoliciesLabel = old('room_detail_policies_label', $settings['room_detail_policies_label'] ?? 'Room Policies');
$roomDetailCancellationText = old('room_detail_cancellation_text', $settings['room_detail_cancellation_text'] ?? 'Subject to reservation policy');
$roomDetailIdRequiredText = old('room_detail_id_required_text', $settings['room_detail_id_required_text'] ?? 'Valid photo ID at check-in');

$tridentEventEmail = old('event_email', $settings['event_email'] ?? $hotelEmail);
$tridentHeroEyebrow = old('trident_hero_eyebrow', $settings['trident_hero_eyebrow'] ?? $hotelName);
$tridentHeroTitle = old('trident_hero_title', $settings['trident_hero_title'] ?? 'Trident');
$tridentHeroHighlight = old('trident_hero_highlight', $settings['trident_hero_highlight'] ?? 'Banquet Hall');
$tridentOverviewEyebrow = old('trident_overview_eyebrow', $settings['trident_overview_eyebrow'] ?? 'The Venue');
$tridentOverviewTitle = old('trident_overview_title', $settings['trident_overview_title'] ?? 'Where Every Celebration Becomes a');
$tridentOverviewHighlight = old('trident_overview_highlight', $settings['trident_overview_highlight'] ?? 'Grand Memory');
$tridentOverviewDescription = old('trident_overview_description', $settings['trident_overview_description'] ?? 'Trident Banquet Hall at ' . $hotelName . ' is a premium event venue in Kurukshetra, planned for weddings, receptions, conferences, and private celebrations that need scale, polish, and dependable service.');
$tridentOverviewSecondaryDescription = old('trident_overview_secondary_description', $settings['trident_overview_secondary_description'] ?? 'From decor coordination and in-house catering to guest flow and event-day support, our team helps you host a smooth and memorable occasion from start to finish.');
$tridentGuestCapacity = old('trident_guest_capacity', $settings['trident_guest_capacity'] ?? '500+');
$tridentVenueArea = old('trident_venue_area', $settings['trident_venue_area'] ?? '5000');
$tridentContactEyebrow = old('trident_contact_eyebrow', $settings['trident_contact_eyebrow'] ?? 'Get In Touch');
$tridentContactTitle = old('trident_contact_title', $settings['trident_contact_title'] ?? 'Enquire About');
$tridentContactHighlight = old('trident_contact_highlight', $settings['trident_contact_highlight'] ?? 'Your Event');
$tridentContactDescription = old('trident_contact_description', $settings['trident_contact_description'] ?? 'Share your event plan and our team will get back to you with availability and package guidance.');
$tridentCtaEyebrow = old('trident_cta_eyebrow', $settings['trident_cta_eyebrow'] ?? 'Plan Your Event');
$tridentCtaTitle = old('trident_cta_title', $settings['trident_cta_title'] ?? 'Ready to Plan Your');
$tridentCtaHighlight = old('trident_cta_highlight', $settings['trident_cta_highlight'] ?? 'Dream Event?');
$tridentCtaDescription = old('trident_cta_description', $settings['trident_cta_description'] ?? 'Our events team is available to help you plan the right setup, guest experience, and package for your occasion.');
$tridentGuestRanges = old('trident_guest_ranges', $settings['trident_guest_ranges'] ?? "Up to 50\n50 - 150\n150 - 300\n300 - 500\n500+");
$tridentHeroImage = old('trident_hero_image', $settings['trident_hero_image'] ?? 'assets/web/images/new/DSC_6616.webp');
$tridentSecondaryImage = old('trident_secondary_image', $settings['trident_secondary_image'] ?? 'assets/web/images/new/DSC_6618.webp');
$tridentFeaturesImage = old('trident_features_image', $settings['trident_features_image'] ?? 'assets/web/images/new/DSC_6617.webp');
$tridentGalleryImages = old('trident_gallery_images', $settings['trident_gallery_images'] ?? "assets/web/images/new/DSC_6616.webp\nassets/web/images/new/DSC_6617.webp\nassets/web/images/new/DSC_6618.webp\nassets/web/images/new/DSC_6619.webp\nassets/web/images/new/PHOTO-2026-08-13-10-26-08.webp");
$galleryPageFallbackItems = $galleryPageFallbackItems ?? [];
$galleryPageStoredValue = array_key_exists('gallery_page_items', $settings) ? $settings['gallery_page_items'] : null;
$galleryPageItemsJson = old(
    'gallery_page_items',
    $galleryPageStoredValue !== null
        ? $galleryPageStoredValue
        : json_encode($galleryPageFallbackItems, JSON_UNESCAPED_SLASHES)
);
$galleryPageItems = json_decode((string) $galleryPageItemsJson, true);
$galleryPageItems = is_array($galleryPageItems) ? array_values(array_filter($galleryPageItems, static fn ($item) => is_array($item) && trim((string) ($item['path'] ?? '')) !== '')) : [];
$galleryCategoryOptions = [
    'all' => 'All',
    'rooms' => 'Rooms',
    'lobby' => 'Lobby',
    'exterior' => 'Exterior',
    'dining' => 'Dining',
    'events' => 'Events',
];
$editorReturnUrl = $editorReturnUrl ?? base_url('admin/pages');
$editorReturnLabel = $editorReturnLabel ?? 'Pages';
$isGalleryStandaloneEditor = $isStandaloneEditor && $activePagesTab === 'gallerypage';

$mediaFiles = $mediaFiles ?? [];

$homeImageFields = [
    ['label' => 'Hero Main Image', 'name' => 'home_hero_image', 'value' => $homeHeroImage, 'fallback' => ''],
    ['label' => 'Hero Secondary Image', 'name' => 'home_hero_secondary_image', 'value' => $homeHeroSecondaryImage, 'fallback' => ''],
    ['label' => 'Stats Background Image', 'name' => 'home_stats_background_image', 'value' => $homeStatsBackgroundImage, 'fallback' => ''],
    ['label' => 'About Main Image', 'name' => 'home_about_image', 'value' => $homeAboutImage, 'fallback' => ''],
    ['label' => 'About Secondary Image', 'name' => 'home_about_secondary_image', 'value' => $homeAboutSecondaryImage, 'fallback' => ''],
    ['label' => 'Offer Image', 'name' => 'home_offer_image', 'value' => $homeOfferImage, 'fallback' => ''],
    ['label' => 'CTA Background Image', 'name' => 'home_cta_background_image', 'value' => $homeCtaBackgroundImage, 'fallback' => ''],
];
$aboutImageFields = [
    ['label' => 'Story Main Image', 'name' => 'about_story_image', 'value' => $aboutStoryImage, 'fallback' => ''],
    ['label' => 'Story Secondary Image', 'name' => 'about_story_secondary_image', 'value' => $aboutStorySecondaryImage, 'fallback' => ''],
    ['label' => 'Team Image 1', 'name' => 'about_team_image_1', 'value' => $aboutTeamImage1, 'fallback' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=500&q=80'],
    ['label' => 'Team Image 2', 'name' => 'about_team_image_2', 'value' => $aboutTeamImage2, 'fallback' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=500&q=80'],
    ['label' => 'Team Image 3', 'name' => 'about_team_image_3', 'value' => $aboutTeamImage3, 'fallback' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=500&q=80'],
    ['label' => 'CTA Background Image', 'name' => 'about_cta_background_image', 'value' => $aboutCtaBackgroundImage, 'fallback' => ''],
];
$legalImageFields = [
    ['label' => 'Privacy Hero Image', 'name' => 'legal_privacy_hero_image', 'value' => $legalPrivacyHeroImage, 'fallback' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1800&q=85'],
    ['label' => 'Terms Hero Image', 'name' => 'legal_terms_hero_image', 'value' => $legalTermsHeroImage, 'fallback' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1800&q=85'],
];

$renderMediaPickerField = static function (array $field, string $spanClass = ''): string {
    $value = (string) ($field['value'] ?? '');
    $fallback = trim((string) ($field['fallback'] ?? ''));
    $label = (string) ($field['label'] ?? 'Image');
    $name = (string) ($field['name'] ?? '');
    $previewUrl = $value !== '' ? media_url($value) : $fallback;
    $hasImage = $previewUrl !== '';
    $isFallback = $value === '' && $fallback !== '';
    $wrapperClass = trim($spanClass . ' rounded-3xl border border-slate-200/80 bg-slate-50/40 p-4 dark:border-slate-700 dark:bg-slate-800/30');

    ob_start();
    ?>
    <div class="<?= esc($wrapperClass) ?>">
      <label class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-300"><?= esc($label) ?></label>
      <input id="<?= esc($name) ?>" name="<?= esc($name) ?>" type="hidden" value="<?= esc($value) ?>" data-media-value="<?= esc($name) ?>" />
      <div class="flex flex-col gap-4 xl:flex-row xl:items-center">
        <div class="flex h-28 w-full max-w-[180px] items-center justify-center overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-white dark:border-slate-600 dark:bg-slate-900">
          <img src="<?= esc($previewUrl) ?>" alt="<?= esc($label) ?> preview" data-media-preview="<?= esc($name) ?>" class="<?= $hasImage ? '' : 'hidden ' ?>h-full w-full object-cover" />
          <span data-media-empty="<?= esc($name) ?>" class="<?= $hasImage ? 'hidden ' : '' ?>px-4 text-center text-xs font-medium text-slate-400">No image selected</span>
        </div>
        <div class="min-w-0 flex-1">
          <p data-media-status="<?= esc($name) ?>" class="text-sm text-slate-500 dark:text-slate-400">
            <?= $value !== '' ? 'Custom image selected from Media Library.' : ($isFallback ? 'Frontend fallback image currently in use.' : 'Choose an image from Media Library.') ?>
          </p>
          <?php if ($fallback !== ''): ?>
            <p data-media-fallback-note="<?= esc($name) ?>" class="mt-1 text-xs text-slate-400 <?= $isFallback ? '' : 'hidden ' ?>">
              This preview shows the current frontend fallback image.
            </p>
          <?php endif; ?>
          <div class="mt-3 flex flex-wrap items-center gap-3">
            <button type="button" data-open-media-picker="<?= esc($name) ?>" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
            <button type="button" data-clear-media="<?= esc($name) ?>" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
          </div>
          <?php if ($fallback !== ''): ?>
            <input type="hidden" data-media-fallback="<?= esc($name) ?>" value="<?= esc($fallback) ?>" />
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php

    return (string) ob_get_clean();
};
?>

<div class="space-y-6">
  <div>
    <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80"><?= esc($isGalleryStandaloneEditor ? 'Gallery' : 'Pages') ?></p>
    <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
          <?= esc($isStandaloneEditor ? ($editorMeta['title'] ?? 'Page Editor') : 'Website Pages') ?>
        </h1>
        <p class="mt-1 max-w-2xl text-sm text-slate-500 dark:text-slate-400">
          <?= esc($isStandaloneEditor ? ($editorMeta['description'] ?? 'Update page content and image slots.') : 'Manage page-specific frontend content and image slots in one place.') ?>
        </p>
      </div>
      <?php if ($isStandaloneEditor): ?>
        <a href="<?= esc($editorReturnUrl) ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
          Back To <?= esc($editorReturnLabel) ?>
        </a>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($isStandaloneEditor && $editorSections !== [] && ! $isGalleryStandaloneEditor): ?>
    <div class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <span class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Jump To</span>
      <?php foreach ($editorSections as $sectionId => $sectionLabel): ?>
        <button type="button" data-editor-jump="<?= esc($sectionId) ?>" class="inline-flex items-center rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-[#C99A30] hover:text-[#C99A30] dark:border-slate-700 dark:text-slate-300 dark:hover:border-[#C99A30] dark:hover:text-[#C99A30]">
          <?= esc($sectionLabel) ?>
        </button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="grid gap-6 <?= $isStandaloneEditor ? 'xl:grid-cols-1' : 'xl:grid-cols-[290px_minmax(0,1fr)]' ?>">
    <?php if (! $isStandaloneEditor): ?>
    <aside class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="mb-5 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/70">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Page Manager</p>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Choose a page area to edit.</p>
      </div>

      <nav class="space-y-2">
        <?php
        $pageTabs = [
            'homepage' => 'Homepage',
            'aboutpage' => 'About Page',
            'legalpage' => 'Legal Pages',
            'tridentpage' => 'Trident Page',
        ];
        ?>
        <?php foreach ($pageTabs as $tabKey => $tabLabel): ?>
          <button type="button" data-pages-nav="<?= esc($tabKey) ?>" class="pages-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
            <span class="h-2 w-2 rounded-full bg-current opacity-70"></span>
            <?= esc($tabLabel) ?>
          </button>
        <?php endforeach; ?>
      </nav>
    </aside>
    <?php endif; ?>

    <div class="min-w-0">
      <form id="pages-panel-homepage" action="<?= base_url('admin/pages/homepage/update') ?>" method="POST" class="pages-panel rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="pages_tab" value="homepage" />
        <?php if ($isStandaloneEditor): ?>
          <div class="-mx-1 mb-6 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-sm dark:border-slate-700 dark:bg-slate-900/95">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Editing <?= esc($editorMeta['title'] ?? 'Page') ?></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Update the fields below and save when you are done.</p>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <a href="<?= esc($editorReturnUrl) ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Back To <?= esc($editorReturnLabel) ?></a>
                <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Homepage</button>
              </div>
            </div>
          </div>
        <?php else: ?>
        <div class="mb-6 border-b border-slate-100 pb-5 dark:border-slate-800">
          <h2 class="text-lg font-bold text-slate-900 dark:text-white">Homepage</h2>
          <p class="text-sm text-slate-500 dark:text-slate-400">Hero, stats, offer, CTA, and homepage gallery preview.</p>
        </div>
        <?php endif; ?>
        <div class="grid gap-8">
          <section id="homepage-images" class="scroll-mt-28 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2"><h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Homepage Images</h3></div>
            <?php foreach ($homeImageFields as $field): ?>
              <?= $renderMediaPickerField($field) ?>
            <?php endforeach; ?>
          </section>

          <section id="homepage-gallery" class="scroll-mt-28 rounded-3xl border border-slate-200/80 bg-slate-50/40 p-5 dark:border-slate-700 dark:bg-slate-800/30">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Homepage Gallery Preview</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">The homepage now automatically shows the first six images from the Gallery Page collection. Manage gallery photos, captions, and categories in the Gallery Page editor only.</p>
              </div>
              <a href="<?= base_url('admin/gallery') ?>" class="inline-flex items-center rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
                Manage Gallery
              </a>
            </div>
          </section>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800"><button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Homepage</button></div>
      </form>

      <form id="pages-panel-aboutpage" action="<?= base_url('admin/pages/aboutpage/update') ?>" method="POST" class="pages-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?><input type="hidden" name="pages_tab" value="aboutpage" />
        <?php if ($isStandaloneEditor): ?>
          <div class="-mx-1 mb-6 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-sm dark:border-slate-700 dark:bg-slate-900/95">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Editing <?= esc($editorMeta['title'] ?? 'Page') ?></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage page visuals from the media library.</p>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <a href="<?= esc($editorReturnUrl) ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Back To <?= esc($editorReturnLabel) ?></a>
                <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save About Page</button>
              </div>
            </div>
          </div>
        <?php else: ?>
        <div class="mb-6 border-b border-slate-100 pb-5 dark:border-slate-800"><h2 class="text-lg font-bold text-slate-900 dark:text-white">About Page</h2><p class="text-sm text-slate-500 dark:text-slate-400">Manage About page visuals from Media Library.</p></div>
        <?php endif; ?>
        <div id="about-images" class="scroll-mt-28 grid gap-5 sm:grid-cols-2">
          <?php foreach ($aboutImageFields as $field): ?>
            <?= $renderMediaPickerField($field) ?>
          <?php endforeach; ?>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800"><button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save About Page</button></div>
      </form>

      <form id="pages-panel-legalpage" action="<?= base_url('admin/pages/legalpage/update') ?>" method="POST" class="pages-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?><input type="hidden" name="pages_tab" value="legalpage" />
        <?php if ($isStandaloneEditor): ?>
          <div class="-mx-1 mb-6 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-sm dark:border-slate-700 dark:bg-slate-900/95">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Editing <?= esc($editorMeta['title'] ?? 'Page') ?></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Update the shared hero visuals for privacy and terms pages.</p>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <a href="<?= esc($editorReturnUrl) ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Back To <?= esc($editorReturnLabel) ?></a>
                <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Legal Pages</button>
              </div>
            </div>
          </div>
        <?php else: ?>
        <div class="mb-6 border-b border-slate-100 pb-5 dark:border-slate-800"><h2 class="text-lg font-bold text-slate-900 dark:text-white">Legal Pages</h2><p class="text-sm text-slate-500 dark:text-slate-400">Privacy and Terms hero images.</p></div>
        <?php endif; ?>
        <div id="legal-images" class="scroll-mt-28 grid gap-5 sm:grid-cols-2">
          <?php foreach ($legalImageFields as $field): ?>
            <?= $renderMediaPickerField($field) ?>
          <?php endforeach; ?>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800"><button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Legal Pages</button></div>
      </form>

      <form id="pages-panel-tridentpage" action="<?= base_url('admin/pages/tridentpage/update') ?>" method="POST" class="pages-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?><input type="hidden" name="pages_tab" value="tridentpage" />
        <?php if ($isStandaloneEditor): ?>
          <div class="-mx-1 mb-6 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-sm dark:border-slate-700 dark:bg-slate-900/95">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div>
                <p class="text-sm font-semibold text-slate-900 dark:text-white">Editing <?= esc($editorMeta['title'] ?? 'Page') ?></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Manage Trident page content, contact copy, and image slots.</p>
              </div>
              <div class="flex flex-wrap items-center gap-3">
                <a href="<?= esc($editorReturnUrl) ?>" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Back To <?= esc($editorReturnLabel) ?></a>
                <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Trident Page</button>
              </div>
            </div>
          </div>
        <?php else: ?>
        <div class="mb-6 border-b border-slate-100 pb-5 dark:border-slate-800"><h2 class="text-lg font-bold text-slate-900 dark:text-white">Trident Page</h2><p class="text-sm text-slate-500 dark:text-slate-400">Frontend page content and image slots for Trident.</p></div>
        <?php endif; ?>
        <div class="grid gap-8">
          <section id="trident-images" class="scroll-mt-28 grid gap-5 sm:grid-cols-2">
            <?php
            $tridentImageFields = [
              ['label' => 'Hero Image', 'name' => 'trident_hero_image', 'value' => $tridentHeroImage, 'fallback' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=700&q=85'],
              ['label' => 'Secondary Image', 'name' => 'trident_secondary_image', 'value' => $tridentSecondaryImage, 'fallback' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=320&q=80'],
              ['label' => 'Facilities Section Image', 'name' => 'trident_features_image', 'value' => $tridentFeaturesImage, 'fallback' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=700&q=85'],
            ];
            ?>
            <?php foreach ($tridentImageFields as $field): ?>
              <?= $renderMediaPickerField($field, $field['name'] === 'trident_features_image' ? 'sm:col-span-2' : '') ?>
            <?php endforeach; ?>
            <div class="sm:col-span-2"><label for="trident_gallery_images" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gallery Images</label><textarea id="trident_gallery_images" name="trident_gallery_images" rows="6" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentGalleryImages) ?></textarea><p class="mt-2 text-xs text-slate-400">One image path or URL per line.</p></div>
          </section>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800"><button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">Save Trident Page</button></div>
      </form>

      <form id="pages-panel-gallerypage" action="<?= base_url('admin/pages/gallerypage/update') ?>" method="POST" class="pages-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?><input type="hidden" name="pages_tab" value="gallerypage" />
        <section id="gallery-page-items" class="scroll-mt-28 space-y-5">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Gallery Images</h3>
              <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">These items power the `/gallery` page image grid and lightbox. The current frontend fallback images are loaded here by default so they can be replaced or removed.</p>
            </div>
            <div class="flex shrink-0 flex-wrap items-center gap-2 lg:justify-end">
              <button type="button" data-open-media-picker="gallery_page_items" class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Add from Media</button>
            </div>
          </div>

          <input id="galleryPageItemsInput" type="hidden" name="gallery_page_items" value="<?= esc(json_encode($galleryPageItems, JSON_UNESCAPED_SLASHES)) ?>" />

          <div id="galleryPageGrid" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"></div>
          <div id="galleryPageEmpty" class="<?= $galleryPageItems !== [] ? 'hidden ' : '' ?>rounded-2xl border border-dashed border-slate-300 bg-white/70 px-5 py-10 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900/40 dark:text-slate-400">
            No gallery images selected. Add from Media or keep the default fallback items.
          </div>
        </section>
      </form>
    </div>
  </div>
</div>

<div id="galleryItemEditorModal" class="fixed inset-0 z-[1005] hidden items-center justify-center bg-slate-950/75 p-4 backdrop-blur-sm">
  <div class="flex max-h-[90vh] w-full max-w-5xl flex-col overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900">
    <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-6 py-5 dark:border-slate-800">
      <div>
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Gallery Item</p>
        <h2 id="galleryItemEditorTitle" class="mt-1 text-xl font-semibold text-slate-900 dark:text-white">Edit Gallery Item</h2>
      </div>
      <button type="button" data-close-gallery-item-editor class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
        Close
      </button>
    </div>

    <div class="grid flex-1 overflow-y-auto lg:grid-cols-[minmax(0,1.15fr)_minmax(360px,0.85fr)]">
      <div class="bg-slate-100 dark:bg-slate-950">
        <div class="relative flex h-full min-h-[320px] items-center justify-center overflow-hidden bg-slate-100 p-6 dark:bg-slate-950">
          <img id="galleryItemEditorPreview" src="" alt="Gallery item preview" class="max-h-[68vh] w-full rounded-2xl object-contain" />
          <div id="galleryItemEditorSource" class="absolute left-5 top-5 inline-flex max-w-[calc(100%-2.5rem)] items-center rounded-full bg-slate-950/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-white backdrop-blur">
            Media Library Image
          </div>
        </div>
      </div>

      <div class="space-y-5 p-6">
        <input id="galleryItemEditorIndex" type="hidden" value="" />

        <div>
          <label for="galleryItemEditorCaption" class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Caption</label>
          <input id="galleryItemEditorCaption" type="text" placeholder="Optional lightbox caption" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        </div>

        <div>
          <label for="galleryItemEditorAlt" class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Alt Text</label>
          <input id="galleryItemEditorAlt" type="text" placeholder="Describe the image for accessibility" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
        </div>

        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">
          <input id="galleryItemEditorShowOnHomepage" type="checkbox" class="mt-1 h-4 w-4 rounded border-slate-300 text-[#C99A30] focus:ring-[#C99A30] dark:border-slate-600 dark:bg-slate-900" />
          <span class="min-w-0">
            <span class="block text-sm font-medium text-slate-900 dark:text-white">Show on Homepage</span>
            <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">If none selected, homepage uses first 6.</span>
          </span>
        </label>

        <div>
          <label for="galleryItemEditorCategory" class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Category</label>
          <select id="galleryItemEditorCategory" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            <?php foreach ($galleryCategoryOptions as $key => $label): ?>
              <option value="<?= esc($key) ?>"><?= esc($label) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Image Path</label>
          <p id="galleryItemEditorPath" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400"></p>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5 dark:border-slate-800">
          <button type="button" id="galleryItemEditorSave" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Info
          </button>
          <button type="button" id="galleryItemEditorRemove" class="rounded-2xl border border-red-200 px-4 py-2.5 text-sm font-medium text-red-500 transition hover:bg-red-50 dark:border-red-900/60 dark:hover:bg-red-950/30">
            Remove
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'pagesMediaPickerModal',
  'searchId' => 'pagesMediaSearch',
  'emptyId' => 'pagesMediaSearchEmpty',
  'files' => $mediaFiles,
  'title' => 'Choose Media File',
  'description' => 'Select an existing media item and map it into the selected page field.',
  'showUploadPanel' => true,
  'uploadToggleId' => 'pagesMediaUploadToggle',
  'uploadToggleLabelId' => 'pagesMediaUploadToggleLabel',
  'uploadToggleIconId' => 'pagesMediaUploadToggleIcon',
  'uploadPanelId' => 'pagesMediaUploadPanel',
  'uploadInputId' => 'pages_settings_media_file',
]) ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const activePagesTab = <?= json_encode($activePagesTab) ?> || 'homepage';
  const isStandaloneEditor = <?= json_encode($isStandaloneEditor) ?>;
  const modal = document.getElementById('pagesMediaPickerModal');
  const searchInput = document.getElementById('pagesMediaSearch');
  const searchCount = modal ? modal.querySelector('[data-media-picker-count]') : null;
  const searchEmpty = document.getElementById('pagesMediaSearchEmpty');
  const uploadPanel = document.getElementById('pagesMediaUploadPanel');
  const uploadToggle = document.getElementById('pagesMediaUploadToggle');
  const uploadToggleLabel = document.getElementById('pagesMediaUploadToggleLabel');
  const uploadToggleIcon = document.getElementById('pagesMediaUploadToggleIcon');
  const uploadForm = uploadPanel ? uploadPanel.querySelector('form') : null;
  const uploadInput = document.getElementById('pages_settings_media_file');
  const uploadFileName = uploadPanel ? uploadPanel.querySelector('[data-file-name]') : null;
  const uploadStatus = uploadPanel ? uploadPanel.querySelector('[data-upload-status]') : null;
  const mediaGrid = modal ? modal.querySelector('[data-media-picker-grid]') : null;
  const mediaEmptyState = modal ? modal.querySelector('[data-media-picker-empty]') : null;
  const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
  const galleryCategoryOptions = <?= json_encode($galleryCategoryOptions) ?>;
  const galleryPageInput = document.getElementById('galleryPageItemsInput');
  const galleryPageGrid = document.getElementById('galleryPageGrid');
  const galleryPageEmpty = document.getElementById('galleryPageEmpty');
  const galleryItemEditorModal = document.getElementById('galleryItemEditorModal');
  const galleryItemEditorIndex = document.getElementById('galleryItemEditorIndex');
  const galleryItemEditorTitle = document.getElementById('galleryItemEditorTitle');
  const galleryItemEditorPreview = document.getElementById('galleryItemEditorPreview');
  const galleryItemEditorSource = document.getElementById('galleryItemEditorSource');
  const galleryItemEditorCaption = document.getElementById('galleryItemEditorCaption');
  const galleryItemEditorAlt = document.getElementById('galleryItemEditorAlt');
  const galleryItemEditorShowOnHomepage = document.getElementById('galleryItemEditorShowOnHomepage');
  const galleryItemEditorCategory = document.getElementById('galleryItemEditorCategory');
  const galleryItemEditorPath = document.getElementById('galleryItemEditorPath');
  const galleryItemEditorSave = document.getElementById('galleryItemEditorSave');
  const galleryItemEditorRemove = document.getElementById('galleryItemEditorRemove');
  const galleryPageForm = document.getElementById('pages-panel-gallerypage');
  let activeMediaTarget = null;

  function showPagesPanel(panelName) {
    document.querySelectorAll('.pages-panel').forEach(function (panel) {
      panel.classList.add('hidden');
    });

    if (!isStandaloneEditor) {
      document.querySelectorAll('.pages-nav-item').forEach(function (button) {
        button.classList.remove('bg-gradient-to-r', 'from-[#F59E0B]', 'to-[#FB923C]', 'text-white', 'shadow-lg');
        button.classList.add('text-slate-600', 'hover:bg-slate-50', 'dark:text-slate-300', 'dark:hover:bg-slate-800');
      });
    }

    const panel = document.getElementById('pages-panel-' + panelName);
    const nav = isStandaloneEditor ? null : document.querySelector('[data-pages-nav="' + panelName + '"]');

    if (!panel) {
      return showPagesPanel('homepage');
    }

    panel.classList.remove('hidden');

    if (nav) {
      nav.classList.add('bg-gradient-to-r', 'from-[#F59E0B]', 'to-[#FB923C]', 'text-white', 'shadow-lg');
      nav.classList.remove('text-slate-600', 'hover:bg-slate-50', 'dark:text-slate-300', 'dark:hover:bg-slate-800');
    }
  }

  if (!isStandaloneEditor) {
    document.querySelectorAll('[data-pages-nav]').forEach(function (button) {
      button.addEventListener('click', function () {
        showPagesPanel(button.getAttribute('data-pages-nav'));
      });
    });
  }

  function setField(target, path) {
    const input = document.querySelector('[data-media-value="' + target + '"]');
    const preview = document.querySelector('[data-media-preview="' + target + '"]');
    const empty = document.querySelector('[data-media-empty="' + target + '"]');
    const status = document.querySelector('[data-media-status="' + target + '"]');
    const fallbackInput = document.querySelector('[data-media-fallback="' + target + '"]');
    const fallbackNote = document.querySelector('[data-media-fallback-note="' + target + '"]');
    const fallbackPath = fallbackInput ? fallbackInput.value : '';
    const activePath = path || fallbackPath;
    if (input) input.value = path;
    if (preview) {
      preview.src = activePath
        ? (/^https?:\/\//i.test(activePath) ? activePath : baseUrl + activePath.replace(/^\/+/, ''))
        : '';
      preview.classList.toggle('hidden', !activePath);
    }
    if (empty) empty.classList.toggle('hidden', !!activePath);
    if (status) {
      status.textContent = path
        ? 'Custom image selected from Media Library.'
        : (fallbackPath ? 'Frontend fallback image currently in use.' : 'Choose an image from Media Library.');
    }
    if (fallbackNote) {
      fallbackNote.classList.toggle('hidden', !!path || !fallbackPath);
    }
  }

  function setModal(open) {
    if (!modal) return;
    modal.classList.toggle('hidden', !open);
    modal.classList.toggle('flex', open);
    document.body.classList.toggle(
      'overflow-hidden',
      open || (galleryItemEditorModal && !galleryItemEditorModal.classList.contains('hidden'))
    );
  }

  function setGalleryItemEditorModal(open) {
    if (!galleryItemEditorModal) return;
    galleryItemEditorModal.classList.toggle('hidden', !open);
    galleryItemEditorModal.classList.toggle('flex', open);
    document.body.classList.toggle('overflow-hidden', open || (modal && !modal.classList.contains('hidden')));
  }

  function setUploadPanel(open) {
    if (!uploadPanel || !uploadToggle) {
      return;
    }

    uploadPanel.style.maxHeight = open ? '22rem' : '0px';
    uploadPanel.style.opacity = open ? '1' : '0';
    uploadPanel.style.transform = open ? 'translateY(0)' : 'translateY(-12px)';
    uploadPanel.style.pointerEvents = open ? 'auto' : 'none';
    uploadToggle.setAttribute('aria-expanded', open ? 'true' : 'false');

    if (uploadToggleLabel) {
      uploadToggleLabel.textContent = open ? 'Hide Upload' : 'Open Upload';
    }

    if (uploadToggleIcon) {
      uploadToggleIcon.classList.toggle('rotate-45', open);
    }
  }

  function mediaUrl(path) {
    if (!path) return '';
    return /^https?:\/\//i.test(path) ? path : baseUrl + path.replace(/^\/+/, '');
  }

  function readGalleryPageItems() {
    try {
      const parsed = JSON.parse(galleryPageInput?.value || '[]');
      return Array.isArray(parsed) ? parsed.filter(function (item) {
        return item && item.path;
      }) : [];
    } catch (error) {
      return [];
    }
  }

  function writeGalleryPageItems(items) {
    if (galleryPageInput) {
      galleryPageInput.value = JSON.stringify(items);
    }
  }

  function syncCsrfFields(payload) {
    if (!payload || !payload.csrf || !payload.csrf.hash) {
      return;
    }

    const tokenName = payload.csrf.token || payload.csrf.name;
    if (!tokenName) {
      return;
    }

    document.querySelectorAll('input[name="' + tokenName + '"]').forEach(function (field) {
      field.value = payload.csrf.hash;
    });
  }

  async function persistGalleryPageItems(successMessage) {
    if (!galleryPageForm || !galleryPageInput) {
      return false;
    }

    const formData = new FormData(galleryPageForm);
    formData.set('pages_tab', 'gallerypage');
    formData.set('gallery_page_items', galleryPageInput.value || '[]');

    const response = await fetch(galleryPageForm.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    });

    const payload = await response.json();

    syncCsrfFields(payload);

    if (!response.ok || !payload.success) {
      throw new Error((payload && payload.message) || 'Gallery save failed.');
    }

    if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
      window.adminMediaUpload.toast(successMessage || payload.message || 'Gallery saved.', 'success');
    }

    return true;
  }

  function openGalleryItemEditor(index) {
    const items = readGalleryPageItems();
    const item = items[index];
    if (!item) return;

    if (galleryItemEditorIndex) galleryItemEditorIndex.value = String(index);
    if (galleryItemEditorTitle) galleryItemEditorTitle.textContent = item.caption || ('Edit Gallery Item ' + (index + 1));
    if (galleryItemEditorPreview) {
      galleryItemEditorPreview.src = mediaUrl(item.path || '');
      galleryItemEditorPreview.alt = item.alt || item.caption || ('Gallery item ' + (index + 1));
    }
    if (galleryItemEditorSource) {
      galleryItemEditorSource.textContent = /^https?:\/\//i.test(item.path || '') ? 'Frontend fallback image' : 'Media Library image';
    }
    if (galleryItemEditorCaption) galleryItemEditorCaption.value = item.caption || '';
    if (galleryItemEditorAlt) galleryItemEditorAlt.value = item.alt || item.caption || '';
    if (galleryItemEditorShowOnHomepage) galleryItemEditorShowOnHomepage.checked = Boolean(item.show_on_homepage);
    if (galleryItemEditorCategory) galleryItemEditorCategory.value = item.category || 'all';
    if (galleryItemEditorPath) galleryItemEditorPath.textContent = item.path || '';

    setGalleryItemEditorModal(true);
  }

  async function saveGalleryItemEditor(closeAfterSave = true) {
    const index = Number(galleryItemEditorIndex?.value || '-1');
    const items = readGalleryPageItems();

    if (!items[index]) return;

    items[index].caption = galleryItemEditorCaption ? galleryItemEditorCaption.value.trim() : (items[index].caption || '');
    items[index].alt = galleryItemEditorAlt ? galleryItemEditorAlt.value.trim() : (items[index].alt || '');
    items[index].category = galleryItemEditorCategory ? galleryItemEditorCategory.value : (items[index].category || 'all');
    items[index].show_on_homepage = galleryItemEditorShowOnHomepage ? galleryItemEditorShowOnHomepage.checked : Boolean(items[index].show_on_homepage);

    writeGalleryPageItems(items);
    renderGalleryPageItems();

    if (galleryItemEditorSave) {
      galleryItemEditorSave.disabled = true;
      galleryItemEditorSave.textContent = 'Saving...';
    }

    try {
      await persistGalleryPageItems('Gallery info saved.');

      if (closeAfterSave) {
        setGalleryItemEditorModal(false);
      }
    } catch (error) {
      if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
        window.adminMediaUpload.toast(error.message || 'Gallery save failed.', 'error');
      }
    } finally {
      if (galleryItemEditorSave) {
        galleryItemEditorSave.disabled = false;
        galleryItemEditorSave.textContent = 'Save Info';
      }
    }
  }

  function renderGalleryPageItems() {
    if (!galleryPageGrid || !galleryPageEmpty) return;

    const items = readGalleryPageItems();
    galleryPageGrid.innerHTML = '';
    galleryPageEmpty.classList.toggle('hidden', items.length !== 0);

    items.forEach(function (item, index) {
      const wrap = document.createElement('div');
      wrap.className = 'overflow-hidden rounded-3xl border border-slate-200/80 bg-white/95 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg dark:border-slate-700 dark:bg-slate-900/90';
      const itemPath = item.path || '';
      const categoryValue = item.category || 'all';
      const sourceBadge = /^https?:\/\//i.test(itemPath) ? 'Frontend fallback image' : 'Media Library image';
      const safeCaption = String(item.caption || '').replace(/"/g, '&quot;');
      const homepageBadge = item.show_on_homepage ? '<span class="inline-flex items-center rounded-full bg-[#C99A30]/15 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-[#C99A30]">Homepage</span>' : '';
      wrap.innerHTML =
        '<div class="relative group">' +
          '<div class="relative aspect-[4/5] overflow-hidden bg-slate-100 dark:bg-slate-800">' +
            '<img src="' + mediaUrl(itemPath) + '" alt="' + (String(item.alt || item.caption || ('Gallery image ' + (index + 1))).replace(/"/g, '&quot;')) + '" class="h-full w-full object-cover" />' +
            '<div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/15 to-transparent opacity-0 transition duration-200 group-hover:opacity-100"></div>' +
            '<div class="absolute left-4 top-4 inline-flex max-w-[calc(100%-2rem)] items-center rounded-full bg-slate-950/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-white backdrop-blur">' + sourceBadge + '</div>' +
            '<div class="absolute inset-x-4 bottom-4 flex items-center justify-between gap-3 opacity-0 transition duration-200 group-hover:opacity-100">' +
              '<div class="min-w-0">' +
                '<p class="truncate text-sm font-semibold text-white">' + (safeCaption || ('Gallery Item ' + (index + 1))) + '</p>' +
                '<p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">' + galleryCategoryOptions[categoryValue] + '</p>' +
              '</div>' +
              '<button type="button" class="shrink-0 rounded-2xl bg-white/95 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-white" data-edit-gallery-page-index="' + index + '">Edit</button>' +
            '</div>' +
          '</div>' +
          '<div class="border-t border-slate-200/80 p-4 dark:border-slate-800">' +
            '<div class="flex items-center justify-between gap-3">' +
              '<div class="min-w-0">' +
                '<p class="truncate text-base font-semibold text-slate-900 dark:text-white">' + (safeCaption || ('Gallery Item ' + (index + 1))) + '</p>' +
                '<div class="mt-2 flex flex-wrap items-center gap-2">' +
                  homepageBadge +
                  '<span class="inline-flex items-center rounded-full border border-slate-200 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500 dark:border-slate-700 dark:text-slate-300">' + galleryCategoryOptions[categoryValue] + '</span>' +
                '</div>' +
              '</div>' +
              '<button type="button" class="rounded-2xl border border-slate-200 px-3.5 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 xl:hidden" data-edit-gallery-page-index="' + index + '">Edit</button>' +
            '</div>' +
          '</div>' +
        '</div>';

      galleryPageGrid.appendChild(wrap);
    });

    galleryPageGrid.querySelectorAll('[data-edit-gallery-page-index]').forEach(function (button) {
      button.addEventListener('click', function () {
        openGalleryItemEditor(Number(button.dataset.editGalleryPageIndex));
      });
    });
  }

  function filterCards() {
    const cards = Array.from(document.querySelectorAll('#pagesMediaPickerModal [data-media-picker-card]'));
    const query = (searchInput?.value || '').trim().toLowerCase();
    let visible = 0;
    cards.forEach(function (card) {
      const haystack = [(card.dataset.mediaName || ''), (card.dataset.mediaPath || '')].join(' ');
      const match = query === '' || haystack.includes(query);
      card.hidden = !match;
      if (match) visible += 1;
    });
    if (searchCount) searchCount.textContent = String(visible);
    if (searchEmpty) searchEmpty.classList.toggle('hidden', !(query !== '' && visible === 0));
  }

  async function handleSelectedMediaPath(path) {
    if (!activeMediaTarget) return;

    if (activeMediaTarget === 'gallery_page_items') {
      if (!path) return;
      const items = readGalleryPageItems();
      if (!items.some(function (item) { return item.path === path; })) {
        items.push({
          path: path,
          caption: '',
          alt: '',
          category: 'all',
          show_on_homepage: false
        });
        writeGalleryPageItems(items);
        renderGalleryPageItems();

        try {
          await persistGalleryPageItems('Gallery image added.');
        } catch (error) {
          if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
            window.adminMediaUpload.toast(error.message || 'Gallery save failed.', 'error');
          }
        }
      }
    } else if (activeMediaTarget.indexOf('gallery_page_items_replace:') === 0) {
      const index = Number(activeMediaTarget.split(':')[1] || '-1');
      const items = readGalleryPageItems();
      if (!path || !items[index]) return;
      items[index].path = path;
      writeGalleryPageItems(items);
      renderGalleryPageItems();
      try {
        await persistGalleryPageItems('Gallery image updated.');
        openGalleryItemEditor(index);
      } catch (error) {
        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(error.message || 'Gallery save failed.', 'error');
        }
      }
    } else {
      setField(activeMediaTarget, path);
    }

    setModal(false);
  }

  function bindMediaCardSelection(card) {
    card.addEventListener('click', function () {
      handleSelectedMediaPath(card.dataset.selectMediaPath || '');
    });
  }

  function appendPickerFiles(files) {
    if (!mediaGrid || !Array.isArray(files) || files.length === 0) {
      return;
    }

    files.forEach(function (file) {
      const card = document.createElement('button');
      card.type = 'button';
      card.dataset.selectMediaPath = file.path || '';
      card.dataset.mediaPickerCard = '';
      card.dataset.mediaName = (file.original_name || '').toLowerCase();
      card.dataset.mediaPath = (file.path || '').toLowerCase();
      card.className = 'group overflow-hidden rounded-2xl border border-slate-200 bg-white text-left transition hover:-translate-y-0.5 hover:border-[#C99A30] hover:shadow-lg dark:border-slate-700 dark:bg-slate-900';
      card.innerHTML =
        '<span class="flex aspect-[4/3] items-center justify-center bg-slate-100 dark:bg-slate-800">' +
          '<img src="' + (file.url || '') + '" alt="' + (file.alt_text || file.original_name || 'Media image') + '" class="h-full w-full object-contain p-4" />' +
        '</span>' +
        '<span class="block p-3">' +
          '<span class="block truncate text-sm font-semibold text-slate-900 dark:text-white">' + (file.original_name || '') + '</span>' +
          '<span class="mt-1 block truncate text-xs text-slate-400">' + (file.path || '') + '</span>' +
        '</span>';
      bindMediaCardSelection(card);
      mediaGrid.prepend(card);
    });

    mediaGrid.classList.remove('hidden');
    if (mediaEmptyState) {
      mediaEmptyState.classList.add('hidden');
    }

    filterCards();
  }

  function syncUploadName(files) {
    if (!uploadFileName) {
      return;
    }

    if (!files || !files.length) {
      uploadFileName.textContent = '';
      return;
    }

    uploadFileName.textContent = files.length === 1 ? files[0].name : files.length + ' files selected';
  }

  async function uploadPickerFiles(files) {
    if (!uploadForm || !uploadInput || !files || !files.length) {
      return;
    }

    const formData = new FormData(uploadForm);
    formData.delete('media_files[]');

    Array.from(files).forEach(function (file) {
      formData.append('media_files[]', file);
    });

    if (uploadStatus) {
      uploadStatus.textContent = 'Uploading...';
    }

    try {
      const response = await fetch(uploadForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      });

      const payload = await response.json();

      syncCsrfFields(payload);

      if (!response.ok || !payload.success) {
        throw new Error(payload.message || 'Upload failed.');
      }

      appendPickerFiles(payload.files || []);
      uploadInput.value = '';
      syncUploadName([]);

      if (uploadStatus) {
        uploadStatus.textContent = payload.message || 'Upload complete.';
      }

      if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
        window.adminMediaUpload.toast(payload.message || 'Media uploaded.', 'success');
      }
    } catch (error) {
      if (uploadStatus) {
        uploadStatus.textContent = error.message || 'Upload failed.';
      }

      if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
        window.adminMediaUpload.toast(error.message || 'Upload failed.', 'error');
      }
    }
  }

  document.querySelectorAll('[data-open-media-picker]').forEach(function (button) {
    button.addEventListener('click', function () {
      activeMediaTarget = button.dataset.openMediaPicker;
      setUploadPanel(false);
      setModal(true);
    });
  });

  document.querySelectorAll('[data-clear-media]').forEach(function (button) {
    button.addEventListener('click', function () {
      setField(button.dataset.clearMedia, '');
    });
  });

  document.querySelectorAll('#pagesMediaPickerModal [data-select-media-path]').forEach(function (button) {
    bindMediaCardSelection(button);
  });

  document.querySelectorAll('#pagesMediaPickerModal [data-close-media-picker]').forEach(function (button) {
    button.addEventListener('click', function () {
      setModal(false);
    });
  });

  if (modal) {
    modal.addEventListener('click', function (event) {
      if (event.target === modal) setModal(false);
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterCards);
    filterCards();
  }

  if (uploadToggle) {
    uploadToggle.addEventListener('click', function () {
      const isOpen = uploadToggle.getAttribute('aria-expanded') === 'true';
      setUploadPanel(!isOpen);
    });
  }

  if (uploadInput) {
    uploadInput.addEventListener('change', function () {
      syncUploadName(uploadInput.files);
      if (uploadInput.files && uploadInput.files.length) {
        uploadPickerFiles(uploadInput.files);
      }
    });
  }

  if (uploadPanel) {
    const dropZone = uploadPanel.querySelector('[data-drop-zone]');
    if (dropZone) {
      ['dragenter', 'dragover'].forEach(function (eventName) {
        dropZone.addEventListener(eventName, function (event) {
          event.preventDefault();
          dropZone.classList.add('border-[#C99A30]', 'bg-[#C99A30]/5');
        });
      });

      ['dragleave', 'dragend', 'drop'].forEach(function (eventName) {
        dropZone.addEventListener(eventName, function (event) {
          event.preventDefault();
          dropZone.classList.remove('border-[#C99A30]', 'bg-[#C99A30]/5');
        });
      });

      dropZone.addEventListener('drop', function (event) {
        const files = event.dataTransfer ? event.dataTransfer.files : null;
        syncUploadName(files);
        if (files && files.length) {
          uploadPickerFiles(files);
        }
      });
    }
  }

  if (galleryItemEditorCaption) {
    galleryItemEditorCaption.addEventListener('input', function () {
      if (galleryItemEditorTitle) {
        const index = Number(galleryItemEditorIndex?.value || '-1');
        galleryItemEditorTitle.textContent = galleryItemEditorCaption.value.trim() || ('Edit Gallery Item ' + (index + 1));
      }
    });
  }

  if (galleryItemEditorAlt) {
    galleryItemEditorAlt.addEventListener('input', function () {
      if (galleryItemEditorPreview) {
        const index = Number(galleryItemEditorIndex?.value || '-1');
        galleryItemEditorPreview.alt = galleryItemEditorAlt.value.trim() || galleryItemEditorCaption?.value.trim() || ('Gallery item ' + (index + 1));
      }
    });
  }

  if (galleryItemEditorSave) {
    galleryItemEditorSave.addEventListener('click', async function () {
      await saveGalleryItemEditor(true);
    });
  }

  if (galleryItemEditorRemove) {
    galleryItemEditorRemove.addEventListener('click', async function () {
      const index = Number(galleryItemEditorIndex?.value || '-1');
      const items = readGalleryPageItems();
      if (!items[index]) return;
      items.splice(index, 1);
      writeGalleryPageItems(items);
      renderGalleryPageItems();

      const originalText = galleryItemEditorRemove.textContent;
      galleryItemEditorRemove.disabled = true;
      galleryItemEditorRemove.textContent = 'Removing...';

      try {
        await persistGalleryPageItems('Gallery image removed.');
        setGalleryItemEditorModal(false);
      } catch (error) {
        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(error.message || 'Gallery remove failed.', 'error');
        }
      } finally {
        galleryItemEditorRemove.disabled = false;
        galleryItemEditorRemove.textContent = originalText;
      }
    });
  }

  const clearGalleryPageBtn = document.querySelector('[data-clear-gallery-page-items]');
  if (clearGalleryPageBtn) {
    clearGalleryPageBtn.addEventListener('click', async function () {
      const items = readGalleryPageItems();
      if (!items.length) {
        return;
      }

      const originalText = clearGalleryPageBtn.textContent;
      clearGalleryPageBtn.disabled = true;
      clearGalleryPageBtn.textContent = 'Clearing...';

      writeGalleryPageItems([]);
      renderGalleryPageItems();

      try {
        await persistGalleryPageItems('Gallery cleared.');
      } catch (error) {
        if (window.adminMediaUpload && typeof window.adminMediaUpload.toast === 'function') {
          window.adminMediaUpload.toast(error.message || 'Gallery clear failed.', 'error');
        }
      } finally {
        clearGalleryPageBtn.disabled = false;
        clearGalleryPageBtn.textContent = originalText;
      }
    });
  }

  document.querySelectorAll('[data-close-gallery-item-editor]').forEach(function (button) {
    button.addEventListener('click', function () {
      setGalleryItemEditorModal(false);
    });
  });

  if (galleryItemEditorModal) {
    galleryItemEditorModal.addEventListener('click', function (event) {
      if (event.target === galleryItemEditorModal) {
        setGalleryItemEditorModal(false);
      }
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      if (galleryItemEditorModal && !galleryItemEditorModal.classList.contains('hidden')) {
        setGalleryItemEditorModal(false);
      } else if (modal && !modal.classList.contains('hidden')) {
        setModal(false);
      }
    }
  });

  document.querySelectorAll('[data-editor-jump]').forEach(function (button) {
    button.addEventListener('click', function () {
      const targetId = button.getAttribute('data-editor-jump');
      const target = targetId ? document.getElementById(targetId) : null;
      const scrollContainer = document.querySelector('main.admin-surface');

      if (!target || !scrollContainer) {
        return;
      }

      const topOffset = 32;
      const containerRect = scrollContainer.getBoundingClientRect();
      const targetRect = target.getBoundingClientRect();
      const targetTop = (targetRect.top - containerRect.top) + scrollContainer.scrollTop - topOffset;

      scrollContainer.scrollTo({
        top: Math.max(targetTop, 0),
        behavior: 'smooth',
      });
    });
  });

  showPagesPanel(activePagesTab);
  renderGalleryPageItems();
});
</script>
