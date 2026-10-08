<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeoStarterSeeder extends Seeder
{
    private function currentSettings(): array
    {
        $rows = $this->db->table('settings')->get()->getResultArray();

        return array_column($rows, 'value', 'key');
    }

    private function saveIfEmpty(string $key, string $value, array $settings): void
    {
        $current = trim((string) ($settings[$key] ?? ''));

        if ($current !== '') {
            return;
        }

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

    public function run(): void
    {
        $settings = $this->currentSettings();
        $hotelName = trim((string) ($settings['hotel_name'] ?? 'Hotel H Plus')) ?: 'Hotel H Plus';
        $hotelTagline = trim((string) ($settings['hotel_tagline'] ?? 'Comfortable stays and thoughtful hospitality.')) ?: 'Comfortable stays and thoughtful hospitality.';
        $hotelAddress = trim((string) ($settings['hotel_address'] ?? 'Opposite Sector-7, Pipli Road, Kurukshetra')) ?: 'Opposite Sector-7, Pipli Road, Kurukshetra';

        $defaults = [
            'seo_meta_title' => $hotelName . ' Kurukshetra | Premium Stay Near Pipli Road',
            'seo_meta_description' => 'Stay at ' . $hotelName . ' in Kurukshetra for comfortable rooms, warm hospitality, and easy access near Pipli Road and key city landmarks.',
            'seo_meta_keywords' => 'hotel in kurukshetra, hotel h plus kurukshetra, rooms in kurukshetra, hotel near pipli road, banquet hall in kurukshetra',
            'seo_robots' => 'index, follow',
            'seo_twitter_card' => 'summary_large_image',
            'brand_footer_text' => $hotelName . '. All rights reserved.',
        ];

        $pages = [
            'home' => [
                'title' => $hotelName . ' Kurukshetra | Best Hotel Near Pipli Road',
                'description' => 'Book your stay at ' . $hotelName . ' Kurukshetra for elegant rooms, premium comfort, and dependable hospitality in a convenient city location.',
                'focus_keyword' => 'best hotel in kurukshetra',
            ],
            'about' => [
                'title' => 'About ' . $hotelName . ' | Hospitality in Kurukshetra',
                'description' => 'Learn about ' . $hotelName . ', a comfort-focused hotel in Kurukshetra offering thoughtful stays, quality service, and a convenient address at ' . $hotelAddress . '.',
                'focus_keyword' => 'hotel h plus kurukshetra',
            ],
            'rooms' => [
                'title' => 'Rooms at ' . $hotelName . ' | Stay in Kurukshetra',
                'description' => 'Explore room options at ' . $hotelName . ' including deluxe, super deluxe, and executive stays designed for comfort, convenience, and value.',
                'focus_keyword' => 'hotel rooms in kurukshetra',
            ],
            'rooms_deluxe' => [
                'title' => 'Deluxe Room | ' . $hotelName . ' Kurukshetra',
                'description' => 'Choose the Deluxe Room at ' . $hotelName . ' for a comfortable stay in Kurukshetra with practical amenities and a calm, welcoming setting.',
                'focus_keyword' => 'deluxe room in kurukshetra',
            ],
            'rooms_super_deluxe' => [
                'title' => 'Super Deluxe Room | ' . $hotelName . ' Kurukshetra',
                'description' => 'Enjoy extra comfort in the Super Deluxe Room at ' . $hotelName . ' with upgraded space, modern essentials, and a polished stay experience.',
                'focus_keyword' => 'super deluxe room in kurukshetra',
            ],
            'rooms_executive' => [
                'title' => 'Executive Room | ' . $hotelName . ' Kurukshetra',
                'description' => 'Book the Executive Room at ' . $hotelName . ' for a spacious premium stay in Kurukshetra suited for families, business guests, and longer visits.',
                'focus_keyword' => 'executive room in kurukshetra',
            ],
            'trident' => [
                'title' => 'Trident Banquet Hall | ' . $hotelName . ' Kurukshetra',
                'description' => 'Host weddings, parties, and corporate events at Trident Banquet Hall by ' . $hotelName . ' in Kurukshetra with a polished venue and guest-ready hospitality.',
                'focus_keyword' => 'banquet hall in kurukshetra',
            ],
            'gallery' => [
                'title' => 'Gallery | ' . $hotelName . ' Kurukshetra',
                'description' => 'Browse photos of rooms, interiors, guest spaces, and hospitality moments at ' . $hotelName . ' in Kurukshetra.',
                'focus_keyword' => 'hotel gallery kurukshetra',
            ],
            'contact' => [
                'title' => 'Contact ' . $hotelName . ' | Reservations and Enquiries',
                'description' => 'Contact ' . $hotelName . ' for reservations, booking support, directions, banquet enquiries, and general hotel assistance in Kurukshetra.',
                'focus_keyword' => 'contact hotel in kurukshetra',
            ],
            'faq' => [
                'title' => 'FAQ | ' . $hotelName . ' Kurukshetra',
                'description' => 'Read frequently asked questions about rooms, bookings, check-in details, and guest services at ' . $hotelName . ' Kurukshetra.',
                'focus_keyword' => 'hotel faq kurukshetra',
            ],
            'privacy' => [
                'title' => 'Privacy Policy | ' . $hotelName,
                'description' => 'Review the privacy policy for ' . $hotelName . ' to understand how guest information, enquiries, and booking details are handled.',
                'focus_keyword' => 'hotel privacy policy',
            ],
            'terms' => [
                'title' => 'Terms and Conditions | ' . $hotelName,
                'description' => 'Read the terms and conditions for bookings, stays, and services offered by ' . $hotelName . ' in Kurukshetra.',
                'focus_keyword' => 'hotel booking terms',
            ],
            'thank_you' => [
                'title' => 'Thank You | ' . $hotelName,
                'description' => 'Thank you for contacting ' . $hotelName . '. Our team will connect with you shortly regarding your booking or enquiry.',
                'focus_keyword' => 'hotel enquiry confirmation',
            ],
        ];

        foreach ($defaults as $key => $value) {
            $this->saveIfEmpty($key, $value, $settings);
        }

        foreach ($pages as $pageKey => $page) {
            $this->saveIfEmpty('seo_' . $pageKey . '_title', $page['title'], $settings);
            $this->saveIfEmpty('seo_' . $pageKey . '_description', $page['description'], $settings);
            $this->saveIfEmpty('seo_' . $pageKey . '_focus_keyword', $page['focus_keyword'], $settings);
        }

        $this->saveIfEmpty('home_hero_eyebrow', 'Best Hotel in Kurukshetra', $settings);
        $this->saveIfEmpty('hotel_tagline', $hotelTagline, $settings);
    }
}
