<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompleteSeoSetupSeeder extends Seeder
{
    private function saveSetting(string $key, string $value): void
    {
        $payload = [
            'value' => $value,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $exists = $this->db->table('settings')->where('key', $key)->countAllResults() > 0;

        if ($exists) {
            $this->db->table('settings')->where('key', $key)->update($payload);
        } else {
            $this->db->table('settings')->insert([
                'key' => $key,
            ] + $payload);
        }
    }

    private function syncRobotsFile(array $settings): void
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
        ];

        if (($settings['seo_sitemap_enabled'] ?? '1') === '1') {
            $lines[] = 'Sitemap: ' . rtrim((string) env('app.baseURL', 'http://localhost:8080/'), '/') . '/sitemap_index.xml';
        }

        $extra = trim((string) ($settings['seo_robots_txt'] ?? ''));

        if ($extra !== '') {
            $lines[] = '';
            $lines[] = $extra;
        }

        file_put_contents(FCPATH . 'robots.txt', implode("\n", $lines) . "\n");
    }

    public function run(): void
    {
        $hotelName = 'Hotel H Plus';
        $defaultOgImage = 'assets/web/images/og-default.jpg';

        $globalSettings = [
            'brand_favicon' => '/favicon.ico',
            'seo_meta_title' => $hotelName . ' Kurukshetra | Hotel, Rooms and Banquet Hall',
            'seo_meta_description' => 'Book a comfortable stay at ' . $hotelName . ' Kurukshetra for premium rooms, warm hospitality, and Trident Banquet Hall for weddings and events.',
            'seo_meta_keywords' => 'hotel in kurukshetra, best hotel in kurukshetra, rooms in kurukshetra, deluxe room in kurukshetra, banquet hall in kurukshetra, trident banquet hall',
            'seo_robots' => 'index, follow',
            'seo_twitter_card' => 'summary_large_image',
            'seo_og_image' => $defaultOgImage,
            'seo_robots_txt' => 'Disallow: /admin/',
            'seo_sitemap_enabled' => '1',
            'seo_sitemap_include_rooms' => '1',
            'seo_sitemap_include_legal' => '1',
            'seo_sitemap_include_thank_you' => '0',
            'seo_json_ld_enabled' => '1',
            'seo_json_ld_custom' => '',
        ];

        $pages = [
            'home' => [
                'title' => $hotelName . ' Kurukshetra | Best Hotel Near Pipli Road',
                'description' => 'Stay at ' . $hotelName . ' Kurukshetra for elegant rooms, premium comfort, and dependable hospitality near Pipli Road, local landmarks, and key travel routes.',
                'keyword' => 'best hotel in kurukshetra',
            ],
            'about' => [
                'title' => 'About ' . $hotelName . ' Kurukshetra | Comfort and Hospitality',
                'description' => 'Discover ' . $hotelName . ' Kurukshetra, a comfort-focused hotel known for clean rooms, guest-friendly service, and a convenient location for business and family stays.',
                'keyword' => 'hotel h plus kurukshetra',
            ],
            'rooms' => [
                'title' => 'Rooms in Kurukshetra | Deluxe, Super Deluxe and Executive',
                'description' => 'Explore Deluxe, Super Deluxe, and Executive rooms at ' . $hotelName . ' Kurukshetra with modern amenities, comfortable interiors, and reliable service for every stay.',
                'keyword' => 'rooms in kurukshetra',
            ],
            'rooms_deluxe' => [
                'title' => 'Deluxe Room in Kurukshetra | ' . $hotelName,
                'description' => 'Book the Deluxe Room at ' . $hotelName . ' Kurukshetra for a neat, comfortable stay with essential amenities and easy hotel access.',
                'keyword' => 'deluxe room in kurukshetra',
            ],
            'rooms_super_deluxe' => [
                'title' => 'Super Deluxe Room in Kurukshetra | ' . $hotelName,
                'description' => 'Choose the Super Deluxe Room at ' . $hotelName . ' Kurukshetra for added space, upgraded comfort, and a more premium stay experience.',
                'keyword' => 'super deluxe room in kurukshetra',
            ],
            'rooms_executive' => [
                'title' => 'Executive Room in Kurukshetra | ' . $hotelName,
                'description' => 'Enjoy a spacious Executive Room at ' . $hotelName . ' Kurukshetra, ideal for families, business travellers, and guests wanting extra comfort.',
                'keyword' => 'executive room in kurukshetra',
            ],
            'trident' => [
                'title' => 'Banquet Hall in Kurukshetra | Trident at ' . $hotelName,
                'description' => 'Explore Trident Banquet Hall at ' . $hotelName . ' Kurukshetra for weddings, parties, corporate events, and celebrations with hospitality support.',
                'keyword' => 'banquet hall in kurukshetra',
            ],
            'gallery' => [
                'title' => $hotelName . ' Gallery | Rooms, Interiors and Hotel Spaces',
                'description' => 'View the gallery of ' . $hotelName . ' Kurukshetra including rooms, interiors, guest areas, and venue spaces before you book your stay or event.',
                'keyword' => 'hotel gallery kurukshetra',
            ],
            'contact' => [
                'title' => 'Contact ' . $hotelName . ' Kurukshetra | Bookings and Enquiries',
                'description' => 'Contact ' . $hotelName . ' Kurukshetra for room bookings, banquet enquiries, directions, pricing, and guest support.',
                'keyword' => 'contact hotel kurukshetra',
            ],
            'faq' => [
                'title' => 'FAQ | ' . $hotelName . ' Kurukshetra',
                'description' => 'Read answers about rooms, bookings, check-in, guest support, and common stay questions at ' . $hotelName . ' Kurukshetra.',
                'keyword' => 'hotel faq kurukshetra',
            ],
            'privacy' => [
                'title' => 'Privacy Policy | ' . $hotelName,
                'description' => 'Review the privacy policy for ' . $hotelName . ' to understand how booking, enquiry, and guest information is handled.',
                'keyword' => 'hotel privacy policy',
            ],
            'terms' => [
                'title' => 'Terms and Conditions | ' . $hotelName,
                'description' => 'Read the booking, stay, and service terms for guests of ' . $hotelName . ' Kurukshetra.',
                'keyword' => 'hotel booking terms',
            ],
            'thank_you' => [
                'title' => 'Thank You | ' . $hotelName,
                'description' => 'Thank you for contacting ' . $hotelName . '. Our team will get back to you shortly regarding your booking or enquiry.',
                'keyword' => 'hotel enquiry confirmation',
            ],
        ];

        foreach ($globalSettings as $key => $value) {
            $this->saveSetting($key, $value);
        }

        foreach ($pages as $pageKey => $page) {
            $this->saveSetting('seo_' . $pageKey . '_title', $page['title']);
            $this->saveSetting('seo_' . $pageKey . '_description', $page['description']);
            $this->saveSetting('seo_' . $pageKey . '_focus_keyword', $page['keyword']);
            $this->saveSetting('seo_' . $pageKey . '_og_title', $page['title']);
            $this->saveSetting('seo_' . $pageKey . '_og_description', $page['description']);
            $this->saveSetting('seo_' . $pageKey . '_og_image', '');
            $this->saveSetting('seo_' . $pageKey . '_canonical_url', '');
            $this->saveSetting('seo_' . $pageKey . '_robots', '');
            $this->saveSetting('seo_' . $pageKey . '_twitter_card', '');
        }

        $this->syncRobotsFile($globalSettings);
    }
}
