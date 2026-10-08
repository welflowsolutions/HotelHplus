<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuickSeoPolishSeeder extends Seeder
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

    public function run(): void
    {
        $hotelName = 'Hotel H Plus';

        $updates = [
            'seo_meta_title' => $hotelName . ' Kurukshetra | Hotel, Rooms and Banquet Hall',
            'seo_meta_description' => 'Book a comfortable stay at ' . $hotelName . ' Kurukshetra for premium rooms, warm hospitality, and Trident Banquet Hall for weddings and events.',

            'seo_home_title' => $hotelName . ' Kurukshetra | Best Hotel Near Pipli Road',
            'seo_home_description' => 'Stay at ' . $hotelName . ' Kurukshetra for elegant rooms, premium comfort, and dependable hospitality near Pipli Road, local landmarks, and key travel routes.',
            'seo_home_focus_keyword' => 'best hotel in kurukshetra',

            'seo_about_title' => 'About ' . $hotelName . ' Kurukshetra | Comfort and Hospitality',
            'seo_about_description' => 'Discover ' . $hotelName . ' Kurukshetra, a comfort-focused hotel known for clean rooms, guest-friendly service, and a convenient location for business and family stays.',
            'seo_about_focus_keyword' => 'hotel h plus kurukshetra',

            'seo_rooms_title' => 'Rooms in Kurukshetra | Deluxe, Super Deluxe and Executive',
            'seo_rooms_description' => 'Explore Deluxe, Super Deluxe, and Executive rooms at ' . $hotelName . ' Kurukshetra with modern amenities, comfortable interiors, and reliable service for every stay.',
            'seo_rooms_focus_keyword' => 'rooms in kurukshetra',

            'seo_rooms_deluxe_title' => 'Deluxe Room in Kurukshetra | ' . $hotelName,
            'seo_rooms_deluxe_description' => 'Book the Deluxe Room at ' . $hotelName . ' Kurukshetra for a neat, comfortable stay with essential amenities and easy hotel access.',
            'seo_rooms_deluxe_focus_keyword' => 'deluxe room in kurukshetra',

            'seo_rooms_super_deluxe_title' => 'Super Deluxe Room in Kurukshetra | ' . $hotelName,
            'seo_rooms_super_deluxe_description' => 'Choose the Super Deluxe Room at ' . $hotelName . ' Kurukshetra for added space, upgraded comfort, and a more premium stay experience.',
            'seo_rooms_super_deluxe_focus_keyword' => 'super deluxe room in kurukshetra',

            'seo_rooms_executive_title' => 'Executive Room in Kurukshetra | ' . $hotelName,
            'seo_rooms_executive_description' => 'Enjoy a spacious Executive Room at ' . $hotelName . ' Kurukshetra, ideal for families, business travellers, and guests wanting extra comfort.',
            'seo_rooms_executive_focus_keyword' => 'executive room in kurukshetra',

            'seo_trident_title' => 'Banquet Hall in Kurukshetra | Trident at ' . $hotelName,
            'seo_trident_description' => 'Explore Trident Banquet Hall at ' . $hotelName . ' Kurukshetra for weddings, parties, corporate events, and celebrations with hospitality support.',
            'seo_trident_focus_keyword' => 'banquet hall in kurukshetra',

            'seo_gallery_title' => $hotelName . ' Gallery | Rooms, Interiors and Hotel Spaces',
            'seo_gallery_description' => 'View the gallery of ' . $hotelName . ' Kurukshetra including rooms, interiors, guest areas, and venue spaces before you book your stay or event.',
            'seo_gallery_focus_keyword' => 'hotel gallery kurukshetra',

            'seo_contact_title' => 'Contact ' . $hotelName . ' Kurukshetra | Bookings and Enquiries',
            'seo_contact_description' => 'Contact ' . $hotelName . ' Kurukshetra for room bookings, banquet enquiries, directions, pricing, and guest support.',
            'seo_contact_focus_keyword' => 'contact hotel kurukshetra',
        ];

        foreach ($updates as $key => $value) {
            $this->saveSetting($key, $value);
        }
    }
}
