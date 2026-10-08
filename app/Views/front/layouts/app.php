<?php
$hotelName       = app_setting('hotel_name', 'Hotel H Plus');
$hotelTagline    = app_setting('hotel_tagline', 'Comfortable stays and thoughtful hospitality.');
$hotelPhone      = app_setting('hotel_phone', '+91 92530 72122');
$hotelEmail      = app_setting('hotel_email', 'info@hotelhplus.in');
$hotelAddress    = app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra');
$hotelWhatsapp   = preg_replace('/[^0-9]/', '', (string) app_setting('hotel_whatsapp', $hotelPhone));
$favicon         = app_setting('brand_favicon', '/favicon.ico');
$metaDescription = $metaDescription ?? app_setting('seo_meta_description', $hotelTagline);
$metaKeywords    = $metaKeywords ?? app_setting('seo_meta_keywords', '');
$metaRobots      = $metaRobots ?? app_setting('seo_robots', 'index, follow');
$ogImage         = $ogImage ?? app_setting('seo_og_image', 'assets/web/images/og-default.jpg');
$twitterCard     = $twitterCard ?? app_setting('seo_twitter_card', 'summary_large_image');
$canonicalUrl    = $canonicalUrl ?? current_url();
$ogTitle         = $ogTitle ?? ($title ?? $hotelName);
$ogDescription   = $ogDescription ?? $metaDescription;
$googleSiteVerification = trim((string) app_setting('seo_google_verification', ''));
$bingSiteVerification   = trim((string) app_setting('seo_bing_verification', ''));
$jsonLdEnabled   = app_setting('seo_json_ld_enabled', '1') === '1';
$jsonLdCustom    = trim((string) app_setting('seo_json_ld_custom', ''));
$activePage      = $activePage ?? 'home';
$headerTheme     = $headerTheme ?? 'dark';
$bodyClass       = $bodyClass ?? '';
$styles          = $styles ?? '';
$scripts         = $scripts ?? '';
$pageStyles     = $pageStyles ?? [];
$pageScripts    = $pageScripts ?? [];
$pageStyles     = is_array($pageStyles) ? $pageStyles : [$pageStyles];
$pageScripts    = is_array($pageScripts) ? $pageScripts : [$pageScripts];
$jsonLdItems    = $jsonLdItems ?? [];
$jsonLdItems    = is_array($jsonLdItems) ? $jsonLdItems : [$jsonLdItems];

if (trim((string) $ogImage) === '' || trim((string) $ogImage) === 'assets/web/images/og-default.svg') {
  $ogImage = 'assets/web/images/og-default.jpg';
}

$jsonLdGraph = [
  '@context' => 'https://schema.org',
  '@type' => 'Hotel',
  'name' => $hotelName,
  'description' => $metaDescription,
  'url' => base_url('/'),
  'telephone' => $hotelPhone,
  'email' => $hotelEmail,
  'address' => [
    '@type' => 'PostalAddress',
    'streetAddress' => $hotelAddress,
    'addressCountry' => 'IN',
  ],
];

if (trim((string) $ogImage) !== '') {
  $jsonLdGraph['image'] = preg_match('#^https?://#i', (string) $ogImage) ? $ogImage : base_url(ltrim((string) $ogImage, '/'));
}

$faviconUrl = trim((string) $favicon) !== ''
  ? (preg_match('#^https?://#i', (string) $favicon) ? $favicon : base_url(ltrim((string) $favicon, '/')))
  : base_url('favicon.ico');

$ogImageUrl = trim((string) $ogImage) !== ''
  ? (preg_match('#^https?://#i', (string) $ogImage) ? $ogImage : base_url(ltrim((string) $ogImage, '/')))
  : '';

$sameAs = array_values(array_filter([
  app_setting('brand_facebook', ''),
  app_setting('brand_instagram', ''),
  app_setting('brand_x', ''),
], static fn ($url) => trim((string) $url) !== '' && trim((string) $url) !== '#'));

if ($sameAs !== []) {
  $jsonLdGraph['sameAs'] = $sameAs;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? $hotelName) ?></title>
  <meta name="description" content="<?= esc($metaDescription) ?>" />
  <?php if (trim((string) $metaKeywords) !== ''): ?>
  <meta name="keywords" content="<?= esc($metaKeywords) ?>" />
  <?php endif; ?>
  <?php if ($googleSiteVerification !== ''): ?>
  <meta name="google-site-verification" content="<?= esc($googleSiteVerification) ?>" />
  <?php endif; ?>
  <?php if ($bingSiteVerification !== ''): ?>
  <meta name="msvalidate.01" content="<?= esc($bingSiteVerification) ?>" />
  <?php endif; ?>
  <meta name="robots" content="<?= esc($metaRobots) ?>" />
  <link rel="canonical" href="<?= esc($canonicalUrl) ?>" />
  <meta property="og:title" content="<?= esc($ogTitle) ?>" />
  <meta property="og:description" content="<?= esc($ogDescription) ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?= esc($canonicalUrl) ?>" />
  <?php if ($ogImageUrl !== ''): ?>
  <meta property="og:image" content="<?= esc($ogImageUrl) ?>" />
  <?php endif; ?>
  <meta name="twitter:card" content="<?= esc($twitterCard) ?>" />
  <meta name="twitter:title" content="<?= esc($ogTitle) ?>" />
  <meta name="twitter:description" content="<?= esc($ogDescription) ?>" />
  <?php if ($ogImageUrl !== ''): ?>
  <meta name="twitter:image" content="<?= esc($ogImageUrl) ?>" />
  <?php endif; ?>
  <?php if ($jsonLdEnabled): ?>
  <script type="application/ld+json"><?= json_encode($jsonLdGraph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <?php foreach ($jsonLdItems as $jsonLdItem): ?>
    <?php if (is_array($jsonLdItem) && $jsonLdItem !== []): ?>
  <script type="application/ld+json"><?= json_encode($jsonLdItem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php if ($jsonLdCustom !== ''): ?>
  <script type="application/ld+json"><?= $jsonLdCustom ?></script>
  <?php endif; ?>
  <?php endif; ?>
  <link rel="shortcut icon" type="image/png" href="<?= esc($faviconUrl) ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/web/css/tailwind.css') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/web/css/custom.css') ?>" />
  <?php foreach ($pageStyles as $pageStyle): ?>
    <?php if (trim((string) $pageStyle) !== ''): ?>
      <link rel="stylesheet" href="<?= base_url(ltrim((string) $pageStyle, '/')) ?>" />
    <?php endif; ?>
  <?php endforeach; ?>
  <?php if (trim((string) $styles) !== ''): ?>
  <style>
    <?= $styles ?>
  </style>
  <?php endif; ?>
</head>
<body class="<?= esc($bodyClass) ?>">
  <?= view('front/layouts/components/_header', ['activePage' => $activePage, 'headerTheme' => $headerTheme]) ?>
  <main>
    <?= $content ?? '' ?>
  </main>
  <?= view('front/layouts/components/_footer', ['footerRooms' => $footerRooms ?? [], 'currencySymbol' => $currencySymbol ?? app_setting('system_currency_symbol', '₹')]) ?>

  <a href="https://wa.me/<?= esc($hotelWhatsapp) ?>?text=<?= urlencode('Hello, I would like to enquire about booking a room at ' . $hotelName . '.') ?>"
    target="_blank" rel="noopener"
    class="whatsapp-btn fixed bottom-6 right-6 bg-[#25D366] text-white flex items-center justify-center z-50"
    style="width:52px;height:52px;border-radius:50%;" aria-label="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp text-2xl"></i>
  </a>

  <button id="scroll-top" onclick="window.scrollTo({top:0,behavior:'smooth'})"
    class="fixed bottom-6 right-24 w-10 h-10 border border-gold/40 text-gold flex items-center justify-center opacity-0 pointer-events-none z-40 hover:bg-gold hover:text-white hover:border-gold transition-all duration-300 bg-ivory"
    aria-label="Scroll to top">
    <i class="fa-solid fa-chevron-up text-xs"></i>
  </button>

  <script src="<?= base_url('assets/web/js/custom.js') ?>"></script>
  <?php foreach ($pageScripts as $pageScript): ?>
    <?php if (trim((string) $pageScript) !== ''): ?>
      <script src="<?= base_url(ltrim((string) $pageScript, '/')) ?>"></script>
    <?php endif; ?>
  <?php endforeach; ?>
  <?php if (trim((string) $scripts) !== ''): ?>
  <script>
    <?= $scripts ?>
  </script>
  <?php endif; ?>
</body>
</html>
