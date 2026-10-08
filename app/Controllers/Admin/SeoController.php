<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SeoPageModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class SeoController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    private function settings(): array
    {
        $rows = \Config\Database::connect()->table('settings')->get()->getResultArray();

        return array_column($rows, 'value', 'key');
    }

    private function saveSetting(string $key, ?string $value): void
    {
        $db = \Config\Database::connect();
        $exists = $db->table('settings')->where('key', $key)->countAllResults();
        $payload = ['value' => $value, 'updated_at' => date('Y-m-d H:i:s')];

        if ($exists) {
            $db->table('settings')->where('key', $key)->update($payload);
            return;
        }

        $db->table('settings')->insert(['key' => $key] + $payload);
    }

    private function seoPagesModel(): SeoPageModel
    {
        return new SeoPageModel();
    }

    private function mediaFiles(): array
    {
        return \Config\Database::connect()->tableExists('media_files')
            ? (new MediaController())->mediaFiles()
            : [];
    }

    private function routeKeyOverrides(): array
    {
        return [
            '/' => 'home',
            '/about' => 'about',
            '/rooms' => 'rooms',
            '/rooms/deluxe' => 'rooms_deluxe',
            '/rooms/super-deluxe' => 'rooms_super_deluxe',
            '/rooms/executive' => 'rooms_executive',
            '/events' => 'events',
            // '/trident' => 'trident',
            '/gallery' => 'gallery',
            '/contact' => 'contact',
            '/faq' => 'faq',
            '/privacy-policy' => 'privacy',
            '/terms-conditions' => 'terms',
            '/thank-you' => 'thank_you',
        ];
    }

    private function routeLabelOverrides(): array
    {
        return [
            'home' => 'Home',
            'about' => 'About',
            'rooms' => 'Rooms',
            'rooms_deluxe' => 'Deluxe Room',
            'rooms_super_deluxe' => 'Super Deluxe Room',
            'rooms_executive' => 'Executive Room',
            'events' => 'Events',
            // 'trident' => 'Trident',
            'gallery' => 'Gallery',
            'contact' => 'Contact',
            'faq' => 'FAQ',
            'privacy' => 'Privacy Policy',
            'terms' => 'Terms & Conditions',
            'thank_you' => 'Thank You',
        ];
    }

    private function isSeoEligibleRoute(string $path, string $handler): bool
    {
        $normalizedPath = $path === '' ? '/' : $path;
        $normalizedHandler = ltrim($handler, '\\');

        if ($normalizedPath !== '/' && str_starts_with($normalizedPath, '/admin')) {
            return false;
        }

        if (str_contains($normalizedPath, '(:')) {
            return false;
        }

        if (str_starts_with($normalizedHandler, 'Admin\\') || str_starts_with($normalizedHandler, 'Admin/')) {
            return false;
        }

        if (in_array($normalizedPath, ['/sitemap.xml', '/robots.txt'], true)) {
            return false;
        }

        return true;
    }

    private function makeRouteKey(string $path, string $handler): string
    {
        $normalizedPath = $path === '' ? '/' : $path;
        $overrides = $this->routeKeyOverrides();

        if (isset($overrides[$normalizedPath])) {
            return $overrides[$normalizedPath];
        }

        [$controller, $method] = array_pad(explode('::', $handler, 2), 2, 'index');
        $controller = preg_replace('/Controller$/', '', basename(str_replace('\\', '/', $controller))) ?: 'page';
        $key = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $controller . '_' . $method), '_'));

        return $key !== '' ? $key : 'page_' . md5($handler);
    }

    private function makeRouteLabel(string $path, string $handler): string
    {
        $key = $this->makeRouteKey($path, $handler);
        $overrides = $this->routeLabelOverrides();

        if (isset($overrides[$key])) {
            return $overrides[$key];
        }

        $normalizedPath = trim($path, '/');
        if ($normalizedPath === '') {
            return 'Home';
        }

        return ucwords(str_replace(['-', '_', '/'], ' ', $normalizedPath));
    }

    private function discoverRoutes(): array
    {
        $routesFile = APPPATH . 'Config/Routes.php';

        if (! is_file($routesFile)) {
            return [];
        }

        $contents = (string) file_get_contents($routesFile);
        preg_match_all('/\$routes->get\(\s*[\'"]([^\'"]*)[\'"]\s*,\s*[\'"]([^\'"]+)[\'"]/', $contents, $matches, PREG_SET_ORDER);

        $routes = [];

        foreach ($matches as $match) {
            $path = trim((string) ($match[1] ?? ''));
            $handler = trim((string) ($match[2] ?? ''));

            if ($path === '') {
                $path = '/';
            } elseif ($path[0] !== '/') {
                $path = '/' . $path;
            }

            if (! $this->isSeoEligibleRoute($path, $handler)) {
                continue;
            }

            $key = $this->makeRouteKey($path, $handler);
            $routes[$key] = [
                'route_key' => $key,
                'route_label' => $this->makeRouteLabel($path, $handler),
                'route_path' => $path,
                'route_handler' => $handler,
            ];
        }

        ksort($routes);

        return array_values($routes);
    }

    private function ensureTrackedPagesSeeded(): void
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('seo_pages')) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $existingPages = [];

        foreach ($this->seoPagesModel()->findAll() as $page) {
            $routeKey = trim((string) ($page['route_key'] ?? ''));

            if ($routeKey !== '') {
                $existingPages[$routeKey] = $page;
            }
        }

        foreach ($this->discoverRoutes() as $route) {
            $existing = $existingPages[$route['route_key']] ?? null;

            if ($existing === null) {
                $this->seoPagesModel()->insert([
                    'route_key' => $route['route_key'],
                    'route_label' => $route['route_label'],
                    'route_path' => $route['route_path'],
                    'route_handler' => $route['route_handler'],
                    'scan_status' => 'active',
                    'last_scanned_at' => $now,
                ]);

                continue;
            }

            $payload = [];

            foreach (['route_label', 'route_path', 'route_handler'] as $field) {
                if (($existing[$field] ?? null) !== $route[$field]) {
                    $payload[$field] = $route[$field];
                }
            }

            if ($payload !== []) {
                $this->seoPagesModel()->update((int) $existing['id'], $payload);
            }
        }
    }

    private function trackedPages(): array
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('seo_pages')) {
            return [];
        }

        $this->ensureTrackedPagesSeeded();

        return $this->seoPagesModel()
            ->whereIn('scan_status', ['active', 'missing'])
            ->orderBy('route_label', 'ASC')
            ->findAll();
    }

    private function routeStrength(array $settings, string $pageKey): array
    {
        $effectiveTitle = trim((string) ($settings['seo_' . $pageKey . '_title'] ?? $settings['seo_meta_title'] ?? ''));
        $effectiveDescription = trim((string) ($settings['seo_' . $pageKey . '_description'] ?? $settings['seo_meta_description'] ?? ''));
        $focusKeyword = trim((string) ($settings['seo_' . $pageKey . '_focus_keyword'] ?? ''));
        $effectiveOgImage = trim((string) ($settings['seo_' . $pageKey . '_og_image'] ?? $settings['seo_og_image'] ?? ''));

        $score = 0;
        $score += $effectiveTitle !== '' ? 1 : 0;
        $score += $effectiveDescription !== '' ? 1 : 0;
        $score += $focusKeyword !== '' ? 1 : 0;
        $score += $effectiveOgImage !== '' ? 1 : 0;

        return match (true) {
            $score >= 4 => ['label' => 'Strong', 'tone' => 'emerald'],
            $score === 3 => ['label' => 'Good', 'tone' => 'amber'],
            $score === 2 => ['label' => 'Weak', 'tone' => 'rose'],
            default => ['label' => 'Missing', 'tone' => 'rose'],
        };
    }

    private function pageStatus(array $settings, string $pageKey): array
    {
        $title = trim((string) ($settings['seo_' . $pageKey . '_title'] ?? ''));
        $description = trim((string) ($settings['seo_' . $pageKey . '_description'] ?? ''));
        $keyword = trim((string) ($settings['seo_' . $pageKey . '_focus_keyword'] ?? ''));

        $badges = [];

        if ($title === '' && $description === '') {
            $badges[] = ['label' => 'Using Global Defaults', 'tone' => 'slate'];
        } else {
            $badges[] = ['label' => 'Custom Override Active', 'tone' => 'amber'];
        }

        if ($title === '') {
            $badges[] = ['label' => 'Missing Title Override', 'tone' => 'rose'];
        }

        if ($description === '') {
            $badges[] = ['label' => 'Missing Description Override', 'tone' => 'rose'];
        }

        if ($keyword === '') {
            $badges[] = ['label' => 'No Focus Keyword', 'tone' => 'slate'];
        } else {
            $badges[] = ['label' => 'Focus Keyword Set', 'tone' => 'emerald'];
        }

        return $badges;
    }

    private function scanRows(array $settings): array
    {
        $trackedPages = $this->trackedPages();
        $trackedByHandler = [];
        $trackedByKey = [];

        foreach ($trackedPages as $page) {
            $trackedByHandler[$page['route_handler']] = $page;
            $trackedByKey[$page['route_key']] = $page;
        }

        $rows = [];

        foreach ($this->discoverRoutes() as $route) {
            $existing = $trackedByHandler[$route['route_handler']] ?? $trackedByKey[$route['route_key']] ?? null;
            $isDisabled = $existing !== null && ($existing['scan_status'] ?? '') === 'disabled';
            $tracked = $existing !== null && ! $isDisabled;
            $strength = $tracked
                ? $this->routeStrength($settings, $existing['route_key'])
                : ($isDisabled && ! empty($existing['route_key'])
                    ? $this->routeStrength($settings, $existing['route_key'])
                    : ['label' => 'Pending', 'tone' => 'slate']);

            if ($tracked) {
                continue;
            }

            $rows[] = [
                'route_key' => $route['route_key'],
                'route_label' => $route['route_label'],
                'route_path' => $route['route_path'],
                'route_handler' => $route['route_handler'],
                'disabled' => $isDisabled,
                'strength' => $strength,
            ];
        }

        return $rows;
    }

    private function globalSettingsData(array $settings): array
    {
        return [
            'favicon' => $settings['brand_favicon'] ?? '',
            'defaultTitle' => $settings['seo_meta_title'] ?? '',
            'defaultDescription' => $settings['seo_meta_description'] ?? '',
            'defaultKeywords' => $settings['seo_meta_keywords'] ?? '',
            'defaultRobots' => $settings['seo_robots'] ?? 'index, follow',
            'defaultOgImage' => $settings['seo_og_image'] ?? '',
            'defaultTwitterCard' => $settings['seo_twitter_card'] ?? 'summary_large_image',
            'googleVerification' => $settings['seo_google_verification'] ?? '',
            'bingVerification' => $settings['seo_bing_verification'] ?? '',
            'robotsTxt' => $settings['seo_robots_txt'] ?? '',
            'sitemapEnabled' => $settings['seo_sitemap_enabled'] ?? '1',
            'sitemapIncludeLegal' => $settings['seo_sitemap_include_legal'] ?? '1',
            'sitemapIncludeThankYou' => $settings['seo_sitemap_include_thank_you'] ?? '0',
            'sitemapIncludeRooms' => $settings['seo_sitemap_include_rooms'] ?? '1',
            'jsonLdEnabled' => $settings['seo_json_ld_enabled'] ?? '1',
            'jsonLdCustom' => $settings['seo_json_ld_custom'] ?? '',
            'mediaFiles' => $this->mediaFiles(),
            'sitemapUrl' => base_url('sitemap.xml'),
            'robotsUrl' => base_url('robots.txt'),
        ];
    }

    private function syncRobotsFile(?array $settings = null): void
    {
        $settings ??= $this->settings();

        $lines = [
            'User-agent: *',
            'Allow: /',
        ];

        if (($settings['seo_sitemap_enabled'] ?? '1') === '1') {
            $lines[] = 'Sitemap: ' . base_url('sitemap_index.xml');
        }

        $extra = trim((string) ($settings['seo_robots_txt'] ?? ''));

        if ($extra !== '') {
            $lines[] = '';
            $lines[] = $extra;
        }

        file_put_contents(FCPATH . 'robots.txt', implode("\n", $lines) . "\n");
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $settings = $this->settings();
        $pages = [];

        foreach ($this->trackedPages() as $page) {
            $pages[] = [
                'key' => $page['route_key'],
                'label' => $page['route_label'],
                'url' => base_url(ltrim($page['route_path'], '/')),
                'path' => $page['route_path'],
                'title' => $settings['seo_' . $page['route_key'] . '_title'] ?? '',
                'description' => $settings['seo_' . $page['route_key'] . '_description'] ?? '',
                'focusKeyword' => $settings['seo_' . $page['route_key'] . '_focus_keyword'] ?? '',
                'badges' => array_merge(
                    $this->pageStatus($settings, $page['route_key']),
                    ($page['scan_status'] ?? 'active') !== 'active' ? [['label' => 'Route Missing', 'tone' => 'rose']] : []
                ),
                'strength' => $this->routeStrength($settings, $page['route_key']),
            ];
        }

        return $this->render('admin/seo/index', [
            'title' => 'SEO Manager',
            'page' => 'seo',
            'pages' => $pages,
            'scanRows' => $this->scanRows($settings),
        ]);
    }

    public function syncRoutes()
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $selectedKeys = array_values(array_filter((array) $this->request->getPost('routes')));
        $now = date('Y-m-d H:i:s');
        $model = $this->seoPagesModel();
        $discovered = $this->discoverRoutes();
        $trackedPages = $this->trackedPages();
        $trackedByHandler = [];

        foreach ($trackedPages as $page) {
            $trackedByHandler[$page['route_handler']] = $page;
        }

        $discoveredHandlers = [];

        foreach ($discovered as $route) {
            $discoveredHandlers[] = $route['route_handler'];
            $existing = $trackedByHandler[$route['route_handler']] ?? $model->where('route_key', $route['route_key'])->first();

            if ($existing) {
                $shouldReactivate = ($existing['scan_status'] ?? '') === 'disabled' && in_array($route['route_key'], $selectedKeys, true);
                $model->update($existing['id'], [
                    'route_key' => $existing['route_key'],
                    'route_label' => $route['route_label'],
                    'route_path' => $route['route_path'],
                    'route_handler' => $route['route_handler'],
                    'scan_status' => $shouldReactivate ? 'active' : ($existing['scan_status'] ?? 'active'),
                    'last_scanned_at' => $now,
                ]);
                continue;
            }

            if (in_array($route['route_key'], $selectedKeys, true)) {
                $model->insert([
                    'route_key' => $route['route_key'],
                    'route_label' => $route['route_label'],
                    'route_path' => $route['route_path'],
                    'route_handler' => $route['route_handler'],
                    'scan_status' => 'active',
                    'last_scanned_at' => $now,
                ]);
            }
        }

        foreach ($trackedPages as $page) {
            if (! in_array($page['route_handler'], $discoveredHandlers, true)) {
                $model->update($page['id'], [
                    'scan_status' => 'missing',
                    'last_scanned_at' => $now,
                ]);
            }
        }

        return redirect()->to(base_url('admin/seo-manager'))
            ->with('success', 'Routes scanned and SEO pages updated successfully.');
    }

    public function untrack(string $pageKey)
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $page = $this->seoPagesModel()->where('route_key', $pageKey)->first();

        if ($page === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->seoPagesModel()->update($page['id'], [
            'scan_status' => 'disabled',
            'last_scanned_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/seo-manager'))
            ->with('success', $page['route_label'] . ' removed from active SEO tracking.');
    }

    public function global(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $settings = $this->settings();
        $this->syncRobotsFile($settings);

        return $this->render('admin/seo/global', [
            'title' => 'Global SEO',
            'page' => 'seo',
        ] + $this->globalSettingsData($settings));
    }

    public function edit(string $pageKey): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $page = $this->seoPagesModel()->where('route_key', $pageKey)->first();

        if ($page === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $settings = $this->settings();

        return $this->render('admin/seo/edit', [
            'title' => 'Edit SEO',
            'page' => 'seo',
            'pageKey' => $page['route_key'],
            'pageLabel' => $page['route_label'],
            'pageUrl' => base_url(ltrim($page['route_path'], '/')),
            'seoTitle' => old('seo_title', $settings['seo_' . $page['route_key'] . '_title'] ?? ''),
            'seoDescription' => old('seo_description', $settings['seo_' . $page['route_key'] . '_description'] ?? ''),
            'seoFocusKeyword' => old('seo_focus_keyword', $settings['seo_' . $page['route_key'] . '_focus_keyword'] ?? ''),
            'seoOgTitle' => old('seo_og_title', $settings['seo_' . $page['route_key'] . '_og_title'] ?? ''),
            'seoOgDescription' => old('seo_og_description', $settings['seo_' . $page['route_key'] . '_og_description'] ?? ''),
            'seoOgImage' => old('seo_og_image', $settings['seo_' . $page['route_key'] . '_og_image'] ?? ''),
            'seoCanonicalUrl' => old('seo_canonical_url', $settings['seo_' . $page['route_key'] . '_canonical_url'] ?? ''),
            'seoRobots' => old('seo_robots', $settings['seo_' . $page['route_key'] . '_robots'] ?? ''),
            'seoTwitterCard' => old('seo_twitter_card', $settings['seo_' . $page['route_key'] . '_twitter_card'] ?? ''),
            'defaultTitle' => $settings['seo_meta_title'] ?? '',
            'defaultDescription' => $settings['seo_meta_description'] ?? '',
            'defaultRobots' => $settings['seo_robots'] ?? 'index, follow',
            'defaultTwitterCard' => $settings['seo_twitter_card'] ?? 'summary_large_image',
            'defaultOgImage' => $settings['seo_og_image'] ?? '',
            'mediaFiles' => $this->mediaFiles(),
        ]);
    }

    public function update(string $pageKey)
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $page = $this->seoPagesModel()->where('route_key', $pageKey)->first();

        if ($page === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->saveSetting('seo_' . $pageKey . '_title', trim((string) $this->request->getPost('seo_title')));
        $this->saveSetting('seo_' . $pageKey . '_description', trim((string) $this->request->getPost('seo_description')));
        $this->saveSetting('seo_' . $pageKey . '_focus_keyword', trim((string) $this->request->getPost('seo_focus_keyword')));
        $this->saveSetting('seo_' . $pageKey . '_og_title', trim((string) $this->request->getPost('seo_og_title')));
        $this->saveSetting('seo_' . $pageKey . '_og_description', trim((string) $this->request->getPost('seo_og_description')));
        $this->saveSetting('seo_' . $pageKey . '_og_image', trim((string) $this->request->getPost('seo_og_image')));
        $this->saveSetting('seo_' . $pageKey . '_canonical_url', trim((string) $this->request->getPost('seo_canonical_url')));
        $this->saveSetting('seo_' . $pageKey . '_robots', trim((string) $this->request->getPost('seo_robots')));
        $this->saveSetting('seo_' . $pageKey . '_twitter_card', trim((string) $this->request->getPost('seo_twitter_card')));

        return redirect()->to(base_url('admin/seo-manager/' . $pageKey))
            ->with('success', $page['route_label'] . ' SEO updated successfully.');
    }

    public function updateGlobal()
    {
        if ($redirect = $this->denyUnlessSeoAllowed()) {
            return $redirect;
        }

        $keys = [
            'brand_favicon',
            'seo_meta_title',
            'seo_meta_description',
            'seo_meta_keywords',
            'seo_robots',
            'seo_og_image',
            'seo_twitter_card',
            'seo_google_verification',
            'seo_bing_verification',
            'seo_robots_txt',
            'seo_json_ld_custom',
        ];

        foreach ($keys as $key) {
            $this->saveSetting($key, trim((string) $this->request->getPost($key)));
        }

        $this->saveSetting('seo_sitemap_enabled', $this->request->getPost('seo_sitemap_enabled') ? '1' : '0');
        $this->saveSetting('seo_sitemap_include_legal', $this->request->getPost('seo_sitemap_include_legal') ? '1' : '0');
        $this->saveSetting('seo_sitemap_include_thank_you', $this->request->getPost('seo_sitemap_include_thank_you') ? '1' : '0');
        $this->saveSetting('seo_sitemap_include_rooms', $this->request->getPost('seo_sitemap_include_rooms') ? '1' : '0');
        $this->saveSetting('seo_json_ld_enabled', $this->request->getPost('seo_json_ld_enabled') ? '1' : '0');
        $this->syncRobotsFile();

        return redirect()->to(base_url('admin/seo-manager/global'))
            ->with('success', 'Global SEO settings updated successfully.');
    }

    private function denyUnlessSeoAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('seo.manage') && app_setting('system_developer_mode', '0') === '1') {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }
}
