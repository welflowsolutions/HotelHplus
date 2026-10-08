<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class SeoController extends BaseController
{
    private const OPTIONAL_KEYS = [
        'privacy' => 'seo_sitemap_include_legal',
        'terms' => 'seo_sitemap_include_legal',
        'thank_you' => 'seo_sitemap_include_thank_you',
    ];

    private const PAGE_ROUTES = [
        '/' => 'home',
        '/about' => 'about',
        '/rooms' => 'rooms',
        '/events' => 'events',
        '/gallery' => 'gallery',
        '/contact' => 'contact',
        '/booking/lookup' => 'booking_lookup',
        '/faq' => 'faq',
        '/privacy-policy' => 'privacy',
        '/terms-conditions' => 'terms',
        '/thank-you' => 'thank_you',
    ];

    private const PAGE_PRIORITIES = [
        'home' => '1.0',
        'rooms' => '0.9',
        'events' => '0.8',
        'about' => '0.8',
        'gallery' => '0.7',
        'contact' => '0.7',
        'booking_lookup' => '0.4',
        'faq' => '0.5',
        'privacy' => '0.3',
        'terms' => '0.3',
        'thank_you' => '0.2',
    ];

    private const ROUTE_VIEW_FILES = [
        'home' => 'home.php',
        'about' => 'about.php',
        'rooms' => 'rooms.php',
        'events' => 'events.php',
        'gallery' => 'gallery.php',
        'contact' => 'contact.php',
        'booking_lookup' => 'booking_lookup.php',
        'faq' => 'faq.php',
        'privacy' => 'privacy_policy.php',
        'terms' => 'terms_conditions.php',
        'thank_you' => 'thank_you.php',
    ];

    private function db()
    {
        return \Config\Database::connect();
    }

    private function sitemapEnabled(): bool
    {
        return app_setting('seo_sitemap_enabled', '1') === '1';
    }

    private function xmlResponse(string $body)
    {
        return $this->response
            ->setContentType('application/xml')
            ->setBody($body);
    }

    private function lastmod(?string $date = null): string
    {
        $timestamp = $date ? strtotime($date) : false;

        return date(DATE_W3C, $timestamp ?: time());
    }

    private function isIndexable(string $routeKey): bool
    {
        $robots = strtolower(trim((string) (app_setting('seo_' . $routeKey . '_robots', '') ?: app_setting('seo_robots', 'index, follow'))));

        return ! str_contains($robots, 'noindex');
    }

    private function includeOptional(string $routeKey): bool
    {
        $setting = self::OPTIONAL_KEYS[$routeKey] ?? null;

        if ($setting === null) {
            return true;
        }

        return app_setting($setting, $setting === 'seo_sitemap_include_thank_you' ? '0' : '1') === '1';
    }

    private function normalizePath(string $path): string
    {
        return $path === '/' ? '/' : '/' . trim($path, '/');
    }

    private function absoluteImage(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '';
        }

        return preg_match('#^https?://#i', $path) === 1 ? $path : base_url(ltrim($path, '/'));
    }

    private function addUrlNode(\SimpleXMLElement $xml, array $url, bool $includeHints = true): void
    {
        $node = $xml->addChild('url');
        $node->addChild('loc', htmlspecialchars((string) $url['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8'));
        $node->addChild('lastmod', (string) ($url['lastmod'] ?? $this->lastmod()));

        if ($includeHints && ! empty($url['changefreq'])) {
            $node->addChild('changefreq', (string) $url['changefreq']);
        }

        if ($includeHints && ! empty($url['priority'])) {
            $node->addChild('priority', (string) $url['priority']);
        }

        foreach ($url['images'] ?? [] as $image) {
            $imageNode = $node->addChild('image:image', null, 'http://www.google.com/schemas/sitemap-image/1.1');
            $imageNode->addChild('image:loc', htmlspecialchars($image['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8'), 'http://www.google.com/schemas/sitemap-image/1.1');

            if (! empty($image['title'])) {
                $imageNode->addChild('image:title', htmlspecialchars($image['title'], ENT_XML1 | ENT_COMPAT, 'UTF-8'), 'http://www.google.com/schemas/sitemap-image/1.1');
            }

            if (! empty($image['caption'])) {
                $imageNode->addChild('image:caption', htmlspecialchars($image['caption'], ENT_XML1 | ENT_COMPAT, 'UTF-8'), 'http://www.google.com/schemas/sitemap-image/1.1');
            }
        }
    }

    private function urlset(array $urls, bool $includeImageNamespace = false, bool $includeHints = true): string
    {
        $xml = new \SimpleXMLElement($includeImageNamespace
            ? '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"/>'
            : '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>'
        );

        foreach ($this->uniqueUrls($urls) as $url) {
            $this->addUrlNode($xml, $url, $includeHints);
        }

        return $xml->asXML() ?: '';
    }

    private function uniqueUrls(array $urls): array
    {
        $unique = [];

        foreach ($urls as $url) {
            $loc = trim((string) ($url['loc'] ?? ''));

            if ($loc !== '') {
                $unique[$loc] = $url;
            }
        }

        return array_values($unique);
    }

    private function fallbackPageUrls(): array
    {
        $urls = [];

        foreach (self::PAGE_ROUTES as $path => $routeKey) {
            if (! $this->includeOptional($routeKey) || ! $this->isIndexable($routeKey)) {
                continue;
            }

            $urls[] = [
                'loc' => base_url($path === '/' ? '/' : ltrim($path, '/')),
                'lastmod' => $this->pageLastmod($routeKey),
                'changefreq' => $path === '/' ? 'daily' : ($routeKey === 'contact' ? 'monthly' : 'weekly'),
                'priority' => self::PAGE_PRIORITIES[$routeKey] ?? '0.6',
            ];
        }

        return $urls;
    }

    private function pageTimestamp(string $routeKey, array $page = []): ?int
    {
        $timestamps = [];

        foreach (['updated_at', 'last_scanned_at'] as $field) {
            $value = trim((string) ($page[$field] ?? ''));
            $timestamp = $value !== '' ? strtotime($value) : false;

            if ($timestamp) {
                $timestamps[] = $timestamp;
            }
        }

        $files = [
            APPPATH . 'Controllers/Front/HomeController.php',
            APPPATH . 'Views/front/layouts/app.php',
        ];

        $viewFile = self::ROUTE_VIEW_FILES[$routeKey] ?? null;

        if ($viewFile !== null) {
            $files[] = APPPATH . 'Views/front/' . $viewFile;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                $timestamp = filemtime($file);

                if ($timestamp) {
                    $timestamps[] = $timestamp;
                }
            }
        }

        if ($timestamps === []) {
            return null;
        }

        return max($timestamps);
    }

    private function pageLastmod(string $routeKey, array $page = []): string
    {
        $timestamp = $this->pageTimestamp($routeKey, $page);

        return date(DATE_W3C, $timestamp ?: time());
    }

    private function pageUrls(): array
    {
        if (! $this->db()->tableExists('seo_pages')) {
            return $this->fallbackPageUrls();
        }

        try {
            $pages = $this->db()
                ->table('seo_pages')
                ->select('route_key, route_path, updated_at, last_scanned_at')
                ->where('scan_status', 'active')
                ->orderBy('route_label', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable) {
            return $this->fallbackPageUrls();
        }

        $urls = [];
        $seenRouteKeys = [];

        foreach ($pages as $page) {
            $routeKey = trim((string) ($page['route_key'] ?? ''));
            $routePath = $this->normalizePath((string) ($page['route_path'] ?? ''));

            if (! isset(self::PAGE_ROUTES[$routePath]) || self::PAGE_ROUTES[$routePath] !== $routeKey) {
                continue;
            }

            if (! $this->includeOptional($routeKey) || ! $this->isIndexable($routeKey)) {
                continue;
            }

            $seenRouteKeys[$routeKey] = true;
            $urls[] = [
                'loc' => base_url($routePath === '/' ? '/' : ltrim($routePath, '/')),
                'lastmod' => $this->pageLastmod($routeKey, $page),
                'changefreq' => $routePath === '/' ? 'daily' : ($routeKey === 'contact' ? 'monthly' : 'weekly'),
                'priority' => self::PAGE_PRIORITIES[$routeKey] ?? '0.6',
            ];
        }

        foreach (self::PAGE_ROUTES as $path => $routeKey) {
            if (isset($seenRouteKeys[$routeKey]) || ! $this->includeOptional($routeKey) || ! $this->isIndexable($routeKey)) {
                continue;
            }

            $urls[] = [
                'loc' => base_url($path === '/' ? '/' : ltrim($path, '/')),
                'lastmod' => $this->pageLastmod($routeKey),
                'changefreq' => $path === '/' ? 'daily' : ($routeKey === 'contact' ? 'monthly' : 'weekly'),
                'priority' => self::PAGE_PRIORITIES[$routeKey] ?? '0.6',
            ];
        }

        return $urls !== [] ? $this->uniqueUrls($urls) : $this->fallbackPageUrls();
    }

    private function rooms(): array
    {
        try {
            if (! $this->db()->tableExists('rooms')) {
                return [];
            }

            return $this->db()
                ->table('rooms')
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable) {
            return [];
        }
    }

    private function roomUrls(): array
    {
        if (app_setting('seo_sitemap_include_rooms', '1') !== '1') {
            return [];
        }

        $urls = [];

        foreach ($this->rooms() as $room) {
            $slug = trim((string) ($room['slug'] ?? ''));
            $routeKey = 'rooms_' . trim((string) preg_replace('/[^a-z0-9]+/i', '_', strtolower($slug)), '_');

            if ($slug === '' || ! $this->isIndexable($routeKey)) {
                continue;
            }

            $urls[] = [
                'loc' => base_url('rooms/' . $slug),
                'lastmod' => $this->lastmod((string) ($room['updated_at'] ?? '')),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        return $urls;
    }

    private function roomImages(array $room): array
    {
        $images = [];
        $name = trim((string) ($room['name'] ?? 'Room'));

        foreach ([$room['image'] ?? ''] as $image) {
            $url = $this->absoluteImage((string) $image);
            if ($url !== '') {
                $images[$url] = ['loc' => $url, 'title' => $name, 'caption' => $name . ' at ' . app_setting('hotel_name', 'Hotel H Plus')];
            }
        }

        $galleryImages = $room['gallery_images'] ?? [];
        if (is_string($galleryImages) && $galleryImages !== '') {
            $decoded = json_decode($galleryImages, true);
            $galleryImages = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $galleryImages);
        }

        foreach ((array) $galleryImages as $image) {
            $url = $this->absoluteImage((string) $image);
            if ($url !== '') {
                $images[$url] = ['loc' => $url, 'title' => $name, 'caption' => $name . ' gallery image'];
            }
        }

        return array_values($images);
    }

    private function configuredGalleryImages(): array
    {
        $images = [];
        $configuredRaw = app_setting('gallery_page_items', '');
        $configuredItems = json_decode((string) $configuredRaw, true);

        if (is_array($configuredItems)) {
            foreach ($configuredItems as $item) {
                if (! is_array($item)) {
                    continue;
                }

                $url = $this->absoluteImage((string) ($item['path'] ?? ''));
                if ($url !== '') {
                    $images[$url] = [
                        'loc' => $url,
                        'title' => (string) ($item['alt'] ?? $item['caption'] ?? 'Hotel H Plus gallery image'),
                        'caption' => (string) ($item['caption'] ?? 'Hotel H Plus'),
                    ];
                }
            }
        }

        if ($images !== [] || ! $this->db()->tableExists('gallery')) {
            return array_values($images);
        }

        try {
            $rows = $this->db()->table('gallery')->orderBy('sort_order', 'ASC')->get()->getResultArray();
        } catch (\Throwable) {
            $rows = [];
        }

        foreach ($rows as $row) {
            $url = $this->absoluteImage((string) ($row['filename'] ?? ''));
            if ($url !== '') {
                $images[$url] = [
                    'loc' => $url,
                    'title' => (string) ($row['caption'] ?? 'Hotel H Plus gallery image'),
                    'caption' => (string) ($row['caption'] ?? 'Hotel H Plus'),
                ];
            }
        }

        return array_values($images);
    }

    private function pageImages(): array
    {
        return [
            '/' => [
                ['loc' => $this->absoluteImage(app_setting('home_hero_image', 'assets/web/images/homepage-hero-bg.webp')), 'title' => 'Hotel H Plus Kurukshetra'],
                ['loc' => $this->absoluteImage(app_setting('home_about_image', 'assets/web/images/about-main-image.webp')), 'title' => 'Hotel H Plus interior'],
                ['loc' => $this->absoluteImage(app_setting('home_offer_image', 'assets/web/images/home-offer-image.webp')), 'title' => 'Hotel H Plus offer'],
            ],
            '/about' => [
                ['loc' => $this->absoluteImage(app_setting('about_story_image', 'assets/web/images/about-main-image.webp')), 'title' => 'Hotel H Plus exterior'],
                ['loc' => $this->absoluteImage(app_setting('about_story_secondary_image', 'assets/web/images/about-accent-image.webp')), 'title' => 'Hotel H Plus room detail'],
            ],
            '/privacy-policy' => [
                ['loc' => $this->absoluteImage(app_setting('legal_privacy_hero_image', '')), 'title' => 'Hotel H Plus privacy policy'],
            ],
            '/terms-conditions' => [
                ['loc' => $this->absoluteImage(app_setting('legal_terms_hero_image', '')), 'title' => 'Hotel H Plus terms and conditions'],
            ],
        ];
    }

    private function imageUrls(): array
    {
        $urls = [];

        foreach ($this->pageUrls() as $url) {
            $path = parse_url((string) $url['loc'], PHP_URL_PATH) ?: '/';
            $images = array_values(array_filter($this->pageImages()[$path] ?? [], static fn (array $image): bool => trim((string) ($image['loc'] ?? '')) !== ''));

            if ($path === '/gallery') {
                $images = array_merge($images, $this->configuredGalleryImages());
            }

            if ($images !== []) {
                $urls[] = $url + ['images' => $images];
            }
        }

        foreach ($this->rooms() as $room) {
            $slug = trim((string) ($room['slug'] ?? ''));
            $routeKey = 'rooms_' . trim((string) preg_replace('/[^a-z0-9]+/i', '_', strtolower($slug)), '_');

            if ($slug === '' || ! $this->isIndexable($routeKey)) {
                continue;
            }

            $images = $this->roomImages($room);

            if ($images !== []) {
                $urls[] = [
                    'loc' => base_url('rooms/' . $slug),
                    'lastmod' => $this->lastmod((string) ($room['updated_at'] ?? '')),
                    'images' => $images,
                ];
            }
        }

        return $urls;
    }

    private function sitemapIndexEntry(string $loc, array $urls): ?array
    {
        if ($urls === []) {
            return null;
        }

        $lastmod = max(array_map(static fn (array $url): int => strtotime((string) ($url['lastmod'] ?? '')) ?: time(), $urls));

        return [
            'loc' => base_url($loc),
            'lastmod' => date(DATE_W3C, $lastmod),
        ];
    }

    public function sitemapIndex()
    {
        if (! $this->sitemapEnabled()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $entries = array_values(array_filter([
            $this->sitemapIndexEntry('page-sitemap.xml', $this->pageUrls()),
            $this->sitemapIndexEntry('room-sitemap.xml', $this->roomUrls()),
            $this->sitemapIndexEntry('image-sitemap.xml', $this->imageUrls()),
        ]));

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($entries as $entry) {
            $node = $xml->addChild('sitemap');
            $node->addChild('loc', htmlspecialchars((string) $entry['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8'));
            $node->addChild('lastmod', (string) $entry['lastmod']);
        }

        return $this->xmlResponse($xml->asXML() ?: '');
    }

    public function pageSitemap()
    {
        if (! $this->sitemapEnabled()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->xmlResponse($this->urlset($this->pageUrls()));
    }

    public function roomSitemap()
    {
        if (! $this->sitemapEnabled()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->xmlResponse($this->urlset($this->roomUrls()));
    }

    public function imageSitemap()
    {
        if (! $this->sitemapEnabled()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->xmlResponse($this->urlset($this->imageUrls(), true, false));
    }

    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
        ];

        if ($this->sitemapEnabled()) {
            $lines[] = 'Sitemap: ' . base_url('sitemap_index.xml');
        }

        $extra = trim((string) app_setting('seo_robots_txt', ''));

        if ($extra !== '') {
            $lines[] = '';
            $lines[] = $extra;
        }

        return $this->response
            ->setContentType('text/plain')
            ->setBody(implode("\n", $lines) . "\n");
    }
}
