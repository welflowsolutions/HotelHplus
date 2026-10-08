<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class PagesController extends BaseController
{
    private const FALLBACK_GALLERY_ITEMS = [
        ['path' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200&q=90', 'caption' => 'Deluxe Room', 'category' => 'rooms', 'alt' => 'Deluxe room interior', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=1200&q=90', 'caption' => 'Hotel Lobby', 'category' => 'lobby', 'alt' => 'Hotel lobby and pool view', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1200&q=90', 'caption' => 'Super Deluxe Room', 'category' => 'rooms', 'alt' => 'Super deluxe room interior', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=90', 'caption' => 'Hotel Exterior', 'category' => 'exterior', 'alt' => 'Hotel exterior building view', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1200&q=90', 'caption' => 'Dining Setup', 'category' => 'dining', 'alt' => 'Dining setup inside hotel', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1200&q=90', 'caption' => 'Executive Room', 'category' => 'rooms', 'alt' => 'Executive room interior', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?w=1200&q=90', 'caption' => 'Reception Area', 'category' => 'lobby', 'alt' => 'Reception area inside hotel', 'show_on_homepage' => false],
        ['path' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=1200&q=90', 'caption' => 'Night Facade', 'category' => 'exterior', 'alt' => 'Hotel exterior at night', 'show_on_homepage' => false],
    ];

    private const PAGE_DEFINITIONS = [
        'homepage' => [
            'title' => 'Homepage',
            'description' => 'Hero, stats, offer, CTA, and homepage gallery preview.',
        ],
        'aboutpage' => [
            'title' => 'About Page',
            'description' => 'About page visuals and supporting image slots.',
        ],
        'legalpage' => [
            'title' => 'Legal Pages',
            'description' => 'Privacy Policy and Terms & Conditions hero visuals.',
        ],
        'tridentpage' => [
            'title' => 'Trident Page',
            'description' => 'Trident page image slots and gallery visuals.',
        ],
        'gallerypage' => [
            'title' => 'Gallery Page',
            'description' => 'Frontend gallery images, captions, and filter categories.',
        ],
    ];

    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    private function adminPageKey(string $tab): string
    {
        return $tab === 'gallerypage' ? 'gallery' : 'pages';
    }

    private function editorReturnUrl(string $tab): string
    {
        return $tab === 'gallerypage'
            ? base_url('admin/gallery')
            : base_url('admin/pages');
    }

    private function editorReturnLabel(string $tab): string
    {
        return $tab === 'gallerypage' ? 'Gallery' : 'Pages';
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessPagesAllowed()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $settingsRows = $db->table('settings')->get()->getResultArray();
        $settings = array_column($settingsRows, 'updated_at', 'key');

        $pages = [];

        foreach (self::PAGE_DEFINITIONS as $key => $definition) {
            if ($key === 'gallerypage') {
                continue;
            }
            $updatedAt = null;

            foreach ($this->keysByTab()[$key] ?? [] as $settingKey) {
                if (! empty($settings[$settingKey])) {
                    $updatedAt = $settings[$settingKey];
                    break;
                }
            }

            $pages[] = [
                'key' => $key,
                'title' => $definition['title'],
                'description' => $definition['description'],
                'editUrl' => base_url('admin/pages/' . $key),
                'updatedAt' => $updatedAt,
            ];
        }

        return $this->render('admin/pages/list', [
            'title' => 'Pages',
            'page' => 'pages',
            'pagesList' => $pages,
        ]);
    }

    public function edit(string $tab): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessPagesAllowed()) {
            return $redirect;
        }

        $tab = $this->normalizeTab($tab);
        $rows = \Config\Database::connect()->table('settings')->get()->getResultArray();
        $settings = array_column($rows, 'value', 'key');
        $mediaFiles = \Config\Database::connect()->tableExists('media_files')
            ? (new MediaController())->mediaFiles()
            : [];

        return $this->render('admin/pages/index', [
            'title' => self::PAGE_DEFINITIONS[$tab]['title'],
            'page' => $this->adminPageKey($tab),
            'settings' => $settings,
            'mediaFiles' => $mediaFiles,
            'galleryPageFallbackItems' => self::FALLBACK_GALLERY_ITEMS,
            'activePagesTab' => $tab,
            'isStandaloneEditor' => true,
            'editorMeta' => self::PAGE_DEFINITIONS[$tab],
            'editorReturnUrl' => $this->editorReturnUrl($tab),
            'editorReturnLabel' => $this->editorReturnLabel($tab),
        ]);
    }

    public function update(?string $tab = null)
    {
        if ($redirect = $this->denyUnlessPagesAllowed()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $postedTab = (string) ($this->request->getPost('pages_tab') ?? '');
        $tab = $this->normalizeTab($tab ?: $postedTab);
        $keys = $this->keysByTab()[$tab] ?? $this->keysByTab()['homepage'];

        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $exists = $db->table('settings')->where('key', $key)->countAllResults();

            if ($exists) {
                $db->table('settings')->where('key', $key)->update([
                    'value'      => $value,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $db->table('settings')->insert([
                    'key'        => $key,
                    'value'      => $value,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $message = (self::PAGE_DEFINITIONS[$tab]['title'] ?? 'Page') . ' saved successfully.';

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'tab' => $tab,
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }

        $redirectUrl = $tab === 'gallerypage'
            ? base_url('admin/gallery')
            : base_url('admin/pages/' . $tab);

        return redirect()->to($redirectUrl)
            ->with('active_pages_tab', $tab)
            ->with('success', $message);
    }

    private function denyUnlessPagesAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('pages.manage')) {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }

    private function normalizeTab(string $tab): string
    {
        $tab = trim($tab);

        if (! array_key_exists($tab, self::PAGE_DEFINITIONS)) {
            return 'homepage';
        }

        return $tab;
    }

    private function keysByTab(): array
    {
        return [
            'homepage' => [
                'home_hero_image',
                'home_hero_secondary_image',
                'home_stats_background_image',
                'home_about_image',
                'home_about_secondary_image',
                'home_offer_image',
                'home_cta_background_image',
            ],
            'aboutpage' => [
                'about_story_image',
                'about_story_secondary_image',
                'about_team_image_1',
                'about_team_image_2',
                'about_team_image_3',
                'about_cta_background_image',
            ],
            'legalpage' => [
                'legal_privacy_hero_image',
                'legal_terms_hero_image',
            ],
            'tridentpage' => [
                'trident_hero_image',
                'trident_secondary_image',
                'trident_features_image',
                'trident_gallery_images',
            ],
            'gallerypage' => [
                'gallery_page_items',
            ],
        ];
    }
}
