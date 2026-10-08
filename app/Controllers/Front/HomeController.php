<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\Payments\PaymentService;

class HomeController extends BaseController
{
    private const FALLBACK_ROOMS = [
        'deluxe' => [
            'name'        => 'Deluxe Room',
            'slug'        => 'deluxe',
            'description' => 'A comfortable room for solo travellers and couples with king bed, AC, Smart TV, Wi-Fi, attached bathroom, and convenient hotel access.',
            'price'       => '1800.00',
            'max_guests'  => 2,
            'amenities'   => ['King Bed', 'Air Conditioning', 'Smart TV', 'Free Wi-Fi', 'Attached Bathroom', 'Hot & Cold Water', 'Toiletries', 'Free Parking'],
            'image'       => null,
        ],
        'super-deluxe' => [
            'name'        => 'Super Deluxe Room',
            'slug'        => 'super-deluxe',
            'description' => 'An upgraded stay with added space, premium furnishings, plush bedding, modern bathroom, and all the essentials for a more relaxed stay.',
            'price'       => '2200.00',
            'max_guests'  => 2,
            'amenities'   => ['Premium King Bed', 'Air Conditioning', 'Smart TV', 'Free Wi-Fi', 'Attached Bathroom', 'Wardrobe', 'Toiletries', 'Room Service'],
            'image'       => null,
        ],
        'executive' => [
            'name'        => 'Executive Room',
            'slug'        => 'executive',
            'description' => 'A spacious premium room designed for families, business travellers, and guests who want more comfort, more room, and a more elevated stay.',
            'price'       => '3000.00',
            'max_guests'  => 3,
            'amenities'   => ['Luxury King Bed', 'Air Conditioning', 'Smart TV', 'Free Wi-Fi', 'Premium Bathroom', 'Seating Area', 'Tea Setup', 'Free Parking'],
            'image'       => null,
        ],
    ];

    private const FALLBACK_GALLERY = [
        ['category' => 'rooms', 'caption' => 'Deluxe Room', 'alt' => 'Deluxe room interior', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200&q=90'],
        ['category' => 'lobby', 'caption' => 'Hotel Lobby', 'alt' => 'Hotel lobby and pool view', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=1200&q=90'],
        ['category' => 'rooms', 'caption' => 'Super Deluxe Room', 'alt' => 'Super deluxe room interior', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1200&q=90'],
        ['category' => 'exterior', 'caption' => 'Hotel Exterior', 'alt' => 'Hotel exterior building view', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=90'],
        ['category' => 'dining', 'caption' => 'Dining Setup', 'alt' => 'Dining setup inside hotel', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1200&q=90'],
        ['category' => 'rooms', 'caption' => 'Executive Room', 'alt' => 'Executive room interior', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1200&q=90'],
        ['category' => 'lobby', 'caption' => 'Reception Area', 'alt' => 'Reception area inside hotel', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?w=1200&q=90'],
        ['category' => 'exterior', 'caption' => 'Night Facade', 'alt' => 'Hotel exterior at night', 'show_on_homepage' => false, 'filename' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=1200&q=90'],
    ];

    private function render(string $view, array $data = []): string
    {
        $data['footerRooms'] = $data['footerRooms'] ?? array_slice($this->activeRooms(), 0, 3);
        $data['currencySymbol'] = $data['currencySymbol'] ?? app_setting('system_currency_symbol', '₹');
        $data['content'] = view($view, $data);

        return view('front/layouts/app', $data);
    }

    private function db()
    {
        return \Config\Database::connect();
    }

    private function payments(): PaymentService
    {
        return service('paymentService');
    }

    private function activeRooms(): array
    {
        try {
            $rooms = $this->db()
                ->table('rooms')
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load rooms: {message}', ['message' => $e->getMessage()]);
            $rooms = [];
        }

        if ($rooms === []) {
            return array_map(fn (array $room): array => $this->normalizeRoom($room), array_values(self::FALLBACK_ROOMS));
        }

        return array_map(fn (array $room): array => $this->normalizeRoom($room), $rooms);
    }

    private function roomBySlug(string $slug): ?array
    {
        $fallback = self::FALLBACK_ROOMS[$slug] ?? null;

        try {
            $room = $this->db()
                ->table('rooms')
                ->where('slug', $slug)
                ->where('is_active', 1)
                ->get()
                ->getRowArray();
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load room by slug: {message}', ['message' => $e->getMessage()]);
            $room = null;
        }

        if ($room === null && $fallback === null) {
            return null;
        }

        return $this->normalizeRoom(array_merge($fallback ?? [], $room ?? []));
    }

    private function normalizeRoom(array $room): array
    {
        $amenities = $room['amenities'] ?? [];
        $galleryImages = $room['gallery_images'] ?? [];

        if (is_string($amenities) && $amenities !== '') {
            $decoded = json_decode($amenities, true);
            $amenities = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $amenities);
        }

        if (is_string($galleryImages) && $galleryImages !== '') {
            $decoded = json_decode($galleryImages, true);
            $galleryImages = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $galleryImages);
        }

        if (! is_array($amenities)) {
            $amenities = [];
        }

        if (! is_array($galleryImages)) {
            $galleryImages = [];
        }

        $amenities = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $amenities)));
        $galleryImages = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $galleryImages)));

        $room['amenities'] = $amenities;
        $room['image_url'] = $this->assetUrl($room['image'] ?? null, $this->roomMeta($room['slug'] ?? '')['hero']);
        $room['gallery_image_urls'] = array_values(array_unique(array_filter(array_map(
            fn (string $image): string => media_url($image),
            $galleryImages
        ))));
        $room['price_display'] = number_format((float) ($room['price'] ?? 0), 0);
        $room['type_label'] = $this->roomTypeLabel($room);
        $room['booking_open'] = (int) ($room['booking_open'] ?? 1);

        return $room;
    }

    private function paymentGatewayActive(): bool
    {
        return $this->payments()->gatewayModeActive();
    }

    private function paymentGatewayProvider(): string
    {
        return $this->payments()->currentProvider();
    }

    private function paymentGatewayReady(): bool
    {
        return $this->payments()->isReady();
    }

    private function websiteBookingEnabled(): bool
    {
        return $this->payments()->websiteBookingEnabled();
    }

    private function roomBookingAllowed(array $room): bool
    {
        if (! $this->paymentGatewayActive()) {
            return true;
        }

        return $this->paymentGatewayReady()
            && $this->websiteBookingEnabled()
            && (int) ($room['booking_open'] ?? 1) === 1;
    }

    private function bookingByCode(string $bookingCode): ?array
    {
        return $this->payments()->bookingByCode($bookingCode);
    }

    private function roomByBooking(array $booking): ?array
    {
        if (! empty($booking['room_id'])) {
            $room = $this->db()->table('rooms')->where('id', (int) $booking['room_id'])->get()->getRowArray();

            if ($room !== null) {
                return $this->normalizeRoom($room);
            }
        }

        $roomType = trim((string) ($booking['room_type'] ?? ''));

        if ($roomType === '') {
            return null;
        }

        $room = $this->db()->table('rooms')->where('name', $roomType)->where('is_active', 1)->get()->getRowArray();

        return $room ? $this->normalizeRoom($room) : null;
    }

    private function receiptPdfBuilder()
    {
        return service('receiptPdfBuilder');
    }

    private function roomTypeLabel(array $room): string
    {
        $name = trim((string) ($room['name'] ?? ''));
        $maxGuests = (int) ($room['max_guests'] ?? 0);

        if ($name !== '') {
            return $name;
        }

        if ($maxGuests > 0) {
            return $maxGuests . ' Guest' . ($maxGuests > 1 ? 's' : '');
        }

        return 'Room';
    }

    private function roomMeta(string $slug): array
    {
        $map = [
            'deluxe' => [
                'label' => 'Standard Room',
                'hero'  => 'assets/web/images/deluxe-room.webp',
            ],
            'super-deluxe' => [
                'label' => 'Popular Room',
                'hero'  => 'assets/web/images/super-deluxe-room.webp',
            ],
            'executive' => [
                'label' => 'Premium Room',
                'hero'  => 'assets/web/images/new/DSC_6631.webp',
            ],
        ];

        return $map[$slug] ?? [
            'label' => 'Room',
            'hero'  => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1800&q=85',
        ];
    }

    private function galleryImages(): array
    {
        $configuredRaw = app_setting('gallery_page_items', '__gallery_page_items_missing__');
        $hasConfiguredGallery = $configuredRaw !== '__gallery_page_items_missing__';
        $configuredItems = json_decode((string) $configuredRaw, true);

        if ($hasConfiguredGallery) {
            $images = array_values(array_filter(array_map(function ($item): ?array {
                if (! is_array($item)) {
                    return null;
                }

                $source = trim((string) ($item['path'] ?? ''));

                if ($source === '') {
                    return null;
                }

                return [
                    'filename' => $source,
                    'caption' => trim((string) ($item['caption'] ?? 'Hotel H Plus')) ?: 'Hotel H Plus',
                    'alt' => trim((string) ($item['alt'] ?? ($item['caption'] ?? 'Hotel H Plus'))) ?: 'Hotel H Plus',
                    'category' => trim((string) ($item['category'] ?? 'all')) ?: 'all',
                    'show_on_homepage' => filter_var($item['show_on_homepage'] ?? false, FILTER_VALIDATE_BOOLEAN),
                ];
            }, $configuredItems)));
        } else {
            try {
                $images = $this->db()
                    ->table('gallery')
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->get()
                    ->getResultArray();
            } catch (\Throwable $e) {
                log_message('error', 'Unable to load gallery images: {message}', ['message' => $e->getMessage()]);
                $images = [];
            }

            if ($images === []) {
                $images = self::FALLBACK_GALLERY;
            }
        }

        foreach ($images as &$image) {
            $source = $image['filename'] ?? null;
            $image['full_url'] = $this->assetUrl($source, (string) $source);
            $image['thumb_url'] = $image['full_url'];
            $image['caption'] = trim((string) ($image['caption'] ?? 'Hotel H Plus'));
            $image['alt'] = trim((string) ($image['alt'] ?? $image['caption'])) ?: $image['caption'];
            $image['category'] = trim((string) ($image['category'] ?? 'all')) ?: 'all';
            $image['show_on_homepage'] = (bool) ($image['show_on_homepage'] ?? false);
        }
        unset($image);

        return $images;
    }

    private function assetUrl(?string $path, string $fallback = ''): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return $fallback;
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return base_url(ltrim($path, '/'));
    }

    private function thankYouMessageData(): array
    {
        return $this->seoPageData(
            'thank_you',
            'Thank You | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Thank you for contacting ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('thank-you'),
                'metaRobots' => 'noindex, nofollow',
            ]
        ) + [
            'activePage'      => '',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/thank-you.css'],
        ];
    }

    private function seoTitle(string $pageKey, string $fallback): string
    {
        return app_setting('seo_' . $pageKey . '_title', $fallback);
    }

    private function seoDescription(string $pageKey, string $fallback): string
    {
        return app_setting('seo_' . $pageKey . '_description', $fallback);
    }

    private function seoPageData(string $pageKey, string $fallbackTitle, string $fallbackDescription, array $overrides = []): array
    {
        $title = $this->seoTitle($pageKey, $fallbackTitle);
        $description = $this->seoDescription($pageKey, $fallbackDescription);
        $canonicalFallback = $overrides['canonicalUrl'] ?? current_url();

        return [
            'title' => $title,
            'metaDescription' => $description,
            'ogTitle' => app_setting('seo_' . $pageKey . '_og_title', '') ?: $title,
            'ogDescription' => app_setting('seo_' . $pageKey . '_og_description', '') ?: $description,
            'ogImage' => app_setting('seo_' . $pageKey . '_og_image', '') ?: app_setting('seo_og_image', ''),
            'metaRobots' => app_setting('seo_' . $pageKey . '_robots', '') ?: app_setting('seo_robots', 'index, follow'),
            'twitterCard' => app_setting('seo_' . $pageKey . '_twitter_card', '') ?: app_setting('seo_twitter_card', 'summary_large_image'),
            'canonicalUrl' => app_setting('seo_' . $pageKey . '_canonical_url', '') ?: $canonicalFallback,
        ] + $overrides;
    }

    private function absoluteUrl(string $path): string
    {
        return preg_match('#^https?://#i', $path) === 1 ? $path : base_url(ltrim($path, '/'));
    }

    private function breadcrumbSchema(array $items): array
    {
        $positions = [];

        foreach (array_values($items) as $index => $item) {
            $positions[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => (string) ($item['name'] ?? ''),
                'item' => $this->absoluteUrl((string) ($item['url'] ?? '/')),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $positions,
        ];
    }

    private function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => app_setting('hotel_name', 'Hotel H Plus'),
            'url' => base_url('/'),
            'potentialAction' => [
                '@type' => 'ReserveAction',
                'target' => base_url('rooms'),
                'name' => 'Reserve a room',
            ],
        ];
    }

    private function faqItems(): array
    {
        $hotelName = app_setting('hotel_name', 'Hotel H Plus');

        return [
            ['How do I make a reservation at ' . $hotelName . '?', 'You can book by calling us directly, sending a WhatsApp message, or submitting an enquiry through the contact page. Our team confirms availability and final booking details with you.'],
            ['What is your cancellation policy?', 'Cancellations made early can usually be adjusted more smoothly. Final booking and refund terms depend on the type of reservation and confirmation shared by the hotel team at the time of booking.'],
            ['Are room rates inclusive of taxes?', 'Displayed room pricing should be treated as the quoted base for your enquiry. Our team shares the full confirmed rate with applicable taxes before final confirmation.'],
            ['Can I request a specific room or floor?', 'Yes. You can mention your preference while booking and we will try to accommodate it based on availability on your stay dates.'],
            ['What are the check-in and check-out times?', 'Standard check-in begins at 12:00 PM and check-out is by 11:00 AM. Early check-in or late check-out may be possible depending on availability.'],
            ['What ID is required at check-in?', 'Guests should carry a valid government-issued photo ID for check-in verification.'],
            ['Is Wi-Fi available at the hotel?', 'Yes, Wi-Fi is available for guests staying at the hotel.'],
            ['Is parking available?', 'Yes, parking is available for hotel guests and event visitors.'],
            ['Do you offer room service?', 'Yes, room service support is available for in-house guests.'],
            ['Where is ' . $hotelName . ' located?', $hotelName . ' is located on Pipli Road, Kurukshetra, with convenient access from the main city and highway routes.'],
        ];
    }

    private function faqSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static fn (array $item): array => [
                '@type' => 'Question',
                'name' => $item[0],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item[1],
                ],
            ], $this->faqItems()),
        ];
    }

    private function roomSchema(array $room): array
    {
        $price = (float) ($room['price'] ?? 0);
        $image = trim((string) ($room['image_url'] ?? ''));
        $slug = trim((string) ($room['slug'] ?? ''));

        return [
            '@context' => 'https://schema.org',
            '@type' => 'HotelRoom',
            'name' => (string) ($room['name'] ?? 'Room'),
            'description' => (string) ($room['description'] ?? ''),
            'url' => base_url('rooms/' . $slug),
            'image' => $image !== '' ? $this->absoluteUrl($image) : null,
            'occupancy' => [
                '@type' => 'QuantitativeValue',
                'maxValue' => (int) ($room['max_guests'] ?? 0),
                'unitText' => 'guests',
            ],
            'amenityFeature' => array_map(static fn (string $amenity): array => [
                '@type' => 'LocationFeatureSpecification',
                'name' => $amenity,
                'value' => true,
            ], array_values($room['amenities'] ?? [])),
            'containedInPlace' => [
                '@type' => 'Hotel',
                'name' => app_setting('hotel_name', 'Hotel H Plus'),
                'url' => base_url('/'),
                'telephone' => app_setting('hotel_phone', '+91 92530 72122'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra'),
                    'addressCountry' => 'IN',
                ],
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => base_url('rooms/' . $slug),
                'price' => $price > 0 ? number_format($price, 2, '.', '') : null,
                'priceCurrency' => 'INR',
                'availability' => ((int) ($room['booking_open'] ?? 1) === 1) ? 'https://schema.org/InStock' : 'https://schema.org/SoldOut',
            ],
        ];
    }

    private function tridentSchema(array $tridentPage): array
    {
        $capacity = (int) preg_replace('/\D+/', '', (string) ($tridentPage['guestCapacity'] ?? '500'));

        return [
            '@context' => 'https://schema.org',
            '@type' => 'EventVenue',
            'name' => 'Trident Banquet Hall',
            'description' => (string) ($tridentPage['overviewDescription'] ?? ''),
            'url' => base_url('trident'),
            'telephone' => (string) ($tridentPage['hotelPhone'] ?? app_setting('hotel_phone', '+91 92530 72122')),
            'email' => (string) ($tridentPage['eventEmail'] ?? app_setting('hotel_email', 'info@hotelhplus.in')),
            'maximumAttendeeCapacity' => $capacity > 0 ? $capacity : null,
            'image' => $this->absoluteUrl((string) ($tridentPage['heroImage'] ?? 'assets/web/images/homepage-hero-bg.webp')),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => (string) ($tridentPage['hotelAddress'] ?? app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra')),
                'addressCountry' => 'IN',
            ],
            'amenityFeature' => [
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Air-conditioned hall', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'In-house catering', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'Parking', 'value' => true],
                ['@type' => 'LocationFeatureSpecification', 'name' => 'AV and sound support', 'value' => true],
            ],
        ];
    }

    private function formattedTimeSetting(string $key, string $default): string
    {
        $value = trim((string) app_setting($key, $default));

        if ($value === '') {
            $value = $default;
        }

        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return $value;
        }

        return date('h:i A', $timestamp);
    }

    private function roomPageContent(): array
    {
        return [
            'aboutEyebrow' => app_setting('room_detail_about_eyebrow', 'About This Room'),
            'headingPrefix' => app_setting('room_detail_heading_prefix', 'Comfortably designed for'),
            'headingHighlight' => app_setting('room_detail_heading_highlight', 'restful stays'),
            'guestSummaryTemplate' => app_setting('room_detail_guest_summary_template', 'This room is suitable for up to {guests} guest{plural} and includes the key amenities expected for a smooth hotel experience.'),
            'amenitiesLabel' => app_setting('room_detail_amenities_label', 'Room Amenities'),
            'policiesLabel' => app_setting('room_detail_policies_label', 'Room Policies'),
            'checkinTime' => $this->formattedTimeSetting('booking_checkin_time', '13:00'),
            'checkoutTime' => $this->formattedTimeSetting('booking_checkout_time', '11:00'),
            'cancellationText' => app_setting('room_detail_cancellation_text', 'Subject to reservation policy'),
            'idRequiredText' => app_setting('room_detail_id_required_text', 'Valid photo ID at check-in'),
        ];
    }

    private function tridentEvents(): array
    {
        $fallback = [
            [
                'title' => 'Weddings & Receptions',
                'description' => 'Elegant celebrations with venue styling, dining coordination, and room for every moment to unfold beautifully.',
                'icon_class' => 'fa-heart',
            ],
            [
                'title' => 'Corporate Events',
                'description' => 'Professional setups for launches, annual meets, business dinners, and team events handled with precision.',
                'icon_class' => 'fa-briefcase',
            ],
            [
                'title' => 'Conferences',
                'description' => 'Flexible seating, sound support, and large-capacity planning for conferences and formal gatherings.',
                'icon_class' => 'fa-chalkboard-user',
            ],
            [
                'title' => 'Birthday Parties',
                'description' => 'Well-organised private functions with custom themes, hospitality support, and easy guest comfort.',
                'icon_class' => 'fa-cake-candles',
            ],
            [
                'title' => 'Social Gatherings',
                'description' => 'Family celebrations, reunions, and community events hosted in a refined and comfortable setting.',
                'icon_class' => 'fa-people-group',
            ],
            [
                'title' => 'Award Ceremonies',
                'description' => 'Formal evenings, stage-led programs, and recognition events with strong on-ground coordination.',
                'icon_class' => 'fa-trophy',
            ],
        ];

        if (! $this->db()->tableExists('trident_events')) {
            return $fallback;
        }

        try {
            $events = $this->db()
                ->table('trident_events')
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load Trident events: {message}', ['message' => $e->getMessage()]);
            $events = [];
        }

        if ($events === []) {
            return $fallback;
        }

        return array_map(static function (array $event): array {
            return [
                'title' => trim((string) ($event['title'] ?? 'Event')),
                'description' => trim((string) ($event['description'] ?? '')),
                'icon_class' => trim((string) ($event['icon_class'] ?? 'fa-calendar-days')) ?: 'fa-calendar-days',
            ];
        }, $events);
    }

    private function eventServices(): array
    {
        $fallback = [
            [
                'title' => 'Weddings & Receptions',
                'description' => 'Thoughtful celebration planning, guest comfort, and polished coordination for milestone gatherings.',
                'icon_class' => 'fa-heart',
            ],
            [
                'title' => 'Corporate Meets',
                'description' => 'Professional environments for launches, conferences, team meets, and business dinners.',
                'icon_class' => 'fa-briefcase',
            ],
            [
                'title' => 'Birthday Celebrations',
                'description' => 'Flexible event setups for birthdays, anniversaries, and intimate social occasions.',
                'icon_class' => 'fa-cake-candles',
            ],
            [
                'title' => 'Family Gatherings',
                'description' => 'Warm hospitality and practical planning support for reunions and community celebrations.',
                'icon_class' => 'fa-people-group',
            ],
        ];

        if (! $this->db()->tableExists('event_services')) {
            return $fallback;
        }

        try {
            $services = $this->db()
                ->table('event_services')
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load event services: {message}', ['message' => $e->getMessage()]);
            $services = [];
        }

        if ($services === []) {
            return $fallback;
        }

        return array_map(static function (array $service): array {
            return [
                'title' => trim((string) ($service['title'] ?? 'Event Service')),
                'description' => trim((string) ($service['description'] ?? '')),
                'icon_class' => trim((string) ($service['icon_class'] ?? 'fa-calendar-days')) ?: 'fa-calendar-days',
            ];
        }, $services);
    }

    private function eventPackages(): array
    {
        $fallback = [
            [
                'title' => 'Essential Package',
                'subtitle' => 'For intimate gatherings',
                'guest_range' => 'Up to 120 guests',
                'price_label' => 'From Rs. 45,000',
                'description' => 'A clean, practical setup for smaller celebrations and focused events.',
                'features' => ['Venue setup', 'Guest seating', 'Basic decor support', 'Parking assistance'],
                'badge_text' => '',
                'is_featured' => 0,
            ],
            [
                'title' => 'Signature Package',
                'subtitle' => 'Best for most events',
                'guest_range' => '120 to 300 guests',
                'price_label' => 'From Rs. 95,000',
                'description' => 'A more complete package with better presentation, smoother coordination, and added guest comfort.',
                'features' => ['Venue setup', 'Enhanced decor support', 'Dining coordination', 'AV assistance', 'Guest flow support'],
                'badge_text' => 'Most Popular',
                'is_featured' => 1,
            ],
            [
                'title' => 'Grand Package',
                'subtitle' => 'For larger celebrations',
                'guest_range' => '300+ guests',
                'price_label' => 'Custom quote',
                'description' => 'Tailored planning for larger weddings, conferences, and social occasions.',
                'features' => ['Full-event coordination', 'Premium decor planning', 'Custom layout', 'Vendor coordination', 'Dedicated support team'],
                'badge_text' => '',
                'is_featured' => 0,
            ],
        ];

        if (! $this->db()->tableExists('event_packages')) {
            return $fallback;
        }

        try {
            $packages = $this->db()
                ->table('event_packages')
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load event packages: {message}', ['message' => $e->getMessage()]);
            $packages = [];
        }

        if ($packages === []) {
            return $fallback;
        }

        return array_map(function (array $package): array {
            $features = $package['features'] ?? '';
            if (is_string($features)) {
                $decoded = json_decode($features, true);
                $features = is_array($decoded) ? $decoded : preg_split('/\r\n|\r|\n/', $features);
            }

            if (! is_array($features)) {
                $features = [];
            }

            return [
                'title' => trim((string) ($package['title'] ?? 'Package')),
                'subtitle' => trim((string) ($package['subtitle'] ?? '')),
                'guest_range' => trim((string) ($package['guest_range'] ?? '')),
                'price_label' => trim((string) ($package['price_label'] ?? '')),
                'description' => trim((string) ($package['description'] ?? '')),
                'features' => array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $features))),
                'badge_text' => trim((string) ($package['badge_text'] ?? '')),
                'is_featured' => (int) ($package['is_featured'] ?? 0),
            ];
        }, $packages);
    }

    private function homeContent(): array
    {
        $hotelName = app_setting('hotel_name', 'Hotel H Plus');
        $galleryItems = $this->galleryImages();
        $homepageSelectedImages = array_values(array_filter(
            $galleryItems,
            static fn (array $image): bool => (bool) ($image['show_on_homepage'] ?? false)
        ));
        $homepageSourceImages = $homepageSelectedImages !== []
            ? array_slice($homepageSelectedImages, 0, 6)
            : array_slice($galleryItems, 0, 6);

        $galleryPreviewImages = array_map(
            static fn (array $image): array => [
                'src' => (string) ($image['full_url'] ?? ''),
                'alt' => (string) ($image['alt'] ?? $image['caption'] ?? 'Hotel H Plus'),
            ],
            $homepageSourceImages
        );
        $galleryPreviewImages = array_values(array_filter($galleryPreviewImages, static fn (array $image): bool => $image['src'] !== ''));

        return [
            'heroEyebrow'              => app_setting('home_hero_eyebrow', 'Best Hotel in Kurukshetra'),
            'heroTitlePrefix'          => app_setting('home_hero_title_prefix', 'Welcome to'),
            'heroTitleHighlight'       => app_setting('home_hero_title_highlight', $hotelName),
            'heroDescription'          => app_setting('home_hero_description', 'A refined stay on Pipli Road, Kurukshetra, where comfort, hospitality, and thoughtful details come together beautifully.'),
            'heroGuestCount'           => app_setting('home_hero_guest_count', '10,000+ guests'),
            'heroReviewText'           => app_setting('home_hero_review_text', '750+ Google Reviews'),
            'heroImage'                => $this->assetUrl(app_setting('home_hero_image', 'assets/web/images/homepage-hero-bg.webp')),
            'heroSecondaryImage'       => $this->assetUrl(app_setting('home_hero_secondary_image', 'assets/web/images/new/DSC_6631.webp')),
            'statsRooms'               => app_setting('home_stats_rooms', '15+'),
            'statsStaff'               => app_setting('home_stats_staff', '10+'),
            'statsHappyClients'        => app_setting('home_stats_happy_clients', '100%'),
            'statsReviews'             => app_setting('home_stats_reviews', '750+'),
            'statsBackgroundImage'     => $this->assetUrl(app_setting('home_stats_background_image', 'assets/web/images/homepage-hero-bg.webp')),
            'aboutEyebrow'             => app_setting('home_about_eyebrow', 'About Us'),
            'aboutTitle'               => app_setting('home_about_title', 'Experience Premium Comfort & Elegance'),
            'aboutHighlight'           => app_setting('home_about_highlight', 'Comfort & Elegance'),
            'aboutDescription'         => app_setting('home_about_description', 'Enjoy a peaceful and elegant stay at Hotel H Plus, Kurukshetra. Our well-furnished rooms, warm hospitality, and 24/7 service ensure a comfortable experience for families, business travelers, and guests seeking relaxation.'),
            'aboutMission'             => app_setting('home_about_mission', 'To provide premium comfort, reliable service, and a welcoming environment for every guest who walks through our doors.'),
            'aboutVision'              => app_setting('home_about_vision', 'To become the most trusted and preferred luxury hotel in Kurukshetra — a place guests return to again and again.'),
            'aboutValues'              => app_setting('home_about_values', 'Hospitality, cleanliness, safety, and unwavering guest satisfaction above everything else.'),
            'aboutImage'               => $this->assetUrl(app_setting('home_about_image', 'assets/web/images/new/DSC_6608.webp')),
            'aboutSecondaryImage'      => $this->assetUrl(app_setting('home_about_secondary_image', 'assets/web/images/new/DSC_6613.webp')),
            'roomsEyebrow'             => app_setting('home_rooms_eyebrow', 'Rooms & Suites'),
            'roomsTitle'               => app_setting('home_rooms_title', 'Indulge in Comfort Every Stay.'),
            'roomsHighlight'           => app_setting('home_rooms_highlight', 'Every Stay.'),
            'roomsDescription'         => app_setting('home_rooms_description', 'Experience ultimate relaxation, luxury, and world-class hospitality during every visit.'),
            'offerEyebrow'             => app_setting('home_offer_eyebrow', 'Today\'s Offer'),
            'offerTitle'               => app_setting('home_offer_title', 'Exclusive Limited-Time Offer This Month'),
            'offerHighlight'           => app_setting('home_offer_highlight', 'Offer This Month'),
            'offerDescription'         => app_setting('home_offer_description', 'Enjoy a special discounted stay at Hotel H Plus. Whether you\'re planning a family trip or a business visit, this is the perfect time to experience premium comfort at exceptional value.'),
            'offerSecondaryDescription'=> app_setting('home_offer_secondary_description', 'Book now and take advantage of our limited-time savings before the offer ends.'),
            'offerEnabled'             => app_setting('home_offer_enabled', '1') === '1',
            'offerDiscountText'        => app_setting('home_offer_discount_text', '30%'),
            'offerType'                => app_setting('home_offer_type', 'both'),
            'offerTypeLabel'           => match (app_setting('home_offer_type', 'both')) {
                'online' => 'Available for online booking',
                'offline' => 'Available for offline booking',
                default => 'Available for online and offline booking',
            },
            'offerImage'               => $this->assetUrl(app_setting('home_offer_image', 'assets/web/images/new/DSC_6621.webp')),
            'ctaEyebrow'               => app_setting('home_cta_eyebrow', 'Book Now'),
            'ctaTitle'                 => app_setting('home_cta_title', 'Ready for a Luxurious Stay?'),
            'ctaHighlight'             => app_setting('home_cta_highlight', 'Luxurious Stay?'),
            'ctaDescription'           => app_setting('home_cta_description', 'Experience comfort, elegance, and warm hospitality at ' . $hotelName . '.'),
            'ctaBackgroundImage'       => $this->assetUrl(app_setting('home_cta_background_image', 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp')),
            'galleryImages'            => array_slice($galleryPreviewImages, 0, 6),
        ];
    }

    private function aboutPageContent(): array
    {
        return [
            'storyImage' => $this->assetUrl(app_setting('about_story_image', 'assets/web/images/new/DSC_6608.webp')),
            'storySecondaryImage' => $this->assetUrl(app_setting('about_story_secondary_image', 'assets/web/images/new/DSC_6614.webp')),
            'teamImage1' => $this->assetUrl(app_setting('about_team_image_1', ''), 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=500&q=80'),
            'teamImage2' => $this->assetUrl(app_setting('about_team_image_2', ''), 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=500&q=80'),
            'teamImage3' => $this->assetUrl(app_setting('about_team_image_3', ''), 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=500&q=80'),
            'ctaBackgroundImage' => $this->assetUrl(app_setting('about_cta_background_image', 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp')),
        ];
    }

    private function legalPageContent(): array
    {
        return [
            'privacyHeroImage' => $this->assetUrl(app_setting('legal_privacy_hero_image', ''), 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1800&q=85'),
            'termsHeroImage' => $this->assetUrl(app_setting('legal_terms_hero_image', ''), 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1800&q=85'),
        ];
    }

    private function multilineSetting(string $key, array $fallback): array
    {
        $value = trim((string) app_setting($key, ''));

        if ($value === '') {
            return $fallback;
        }

        $items = preg_split('/\r\n|\r|\n/', $value) ?: [];
        $items = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $items)));

        return $items !== [] ? $items : $fallback;
    }

    private function tridentPageContent(): array
    {
        $hotelName = app_setting('hotel_name', 'Hotel H Plus');
        $hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
        $hotelWhatsapp = app_setting('hotel_whatsapp', $hotelPhone);
        $hotelEmail = app_setting('hotel_email', 'info@hotelhplus.in');
        $tridentEvents = $this->tridentEvents();
        $fallbackGallery = [
            'assets/web/images/new/DSC_6616.webp',
            'assets/web/images/new/DSC_6617.webp',
            'assets/web/images/new/DSC_6618.webp',
            'assets/web/images/new/DSC_6619.webp',
            'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp',
        ];

        return [
            'hotelName' => $hotelName,
            'hotelPhone' => $hotelPhone,
            'hotelEmail' => $hotelEmail,
            'hotelAddress' => app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra'),
            'eventEmail' => app_setting('event_email', $hotelEmail),
            'whatsAppNumber' => preg_replace('/\D+/', '', $hotelWhatsapp) ?: '919253072122',
            'heroEyebrow' => app_setting('trident_hero_eyebrow', $hotelName),
            'heroTitle' => app_setting('trident_hero_title', 'Trident'),
            'heroHighlight' => app_setting('trident_hero_highlight', 'Banquet Hall'),
            'overviewEyebrow' => app_setting('trident_overview_eyebrow', 'The Venue'),
            'overviewTitle' => app_setting('trident_overview_title', 'Where Every Celebration Becomes a'),
            'overviewHighlight' => app_setting('trident_overview_highlight', 'Grand Memory'),
            'overviewDescription' => app_setting('trident_overview_description', 'Trident Banquet Hall at ' . $hotelName . ' is a premium event venue in Kurukshetra, planned for weddings, receptions, conferences, and private celebrations that need scale, polish, and dependable service.'),
            'overviewSecondaryDescription' => app_setting('trident_overview_secondary_description', 'From decor coordination and in-house catering to guest flow and event-day support, our team helps you host a smooth and memorable occasion from start to finish.'),
            'guestCapacity' => app_setting('trident_guest_capacity', '500+'),
            'venueArea' => app_setting('trident_venue_area', '5000'),
            'contactEyebrow' => app_setting('trident_contact_eyebrow', 'Get In Touch'),
            'contactTitle' => app_setting('trident_contact_title', 'Enquire About'),
            'contactHighlight' => app_setting('trident_contact_highlight', 'Your Event'),
            'contactDescription' => app_setting('trident_contact_description', 'Share your event plan and our team will get back to you with availability and package guidance.'),
            'ctaEyebrow' => app_setting('trident_cta_eyebrow', 'Plan Your Event'),
            'ctaTitle' => app_setting('trident_cta_title', 'Ready to Plan Your'),
            'ctaHighlight' => app_setting('trident_cta_highlight', 'Dream Event?'),
            'ctaDescription' => app_setting('trident_cta_description', 'Our events team is available to help you plan the right setup, guest experience, and package for your occasion.'),
            'events' => $tridentEvents,
            'eventTypes' => [
                ...array_values(array_map(static fn (array $event): string => $event['title'], $tridentEvents)),
                'Other',
            ],
            'guestRanges' => $this->multilineSetting('trident_guest_ranges', [
                'Up to 50',
                '50 - 150',
                '150 - 300',
                '300 - 500',
                '500+',
            ]),
            'heroImage' => $this->assetUrl(
                app_setting('trident_hero_image', ''),
                'assets/web/images/new/DSC_6616.webp'
            ),
            'secondaryImage' => $this->assetUrl(
                app_setting('trident_secondary_image', ''),
                'assets/web/images/new/DSC_6618.webp'
            ),
            'featuresImage' => $this->assetUrl(
                app_setting('trident_features_image', ''),
                'assets/web/images/new/DSC_6617.webp'
            ),
            'galleryImages' => array_map(
                fn (string $image): string => $this->assetUrl($image, $image),
                $this->multilineSetting('trident_gallery_images', $fallbackGallery)
            ),
        ];
    }

    private function eventsPageContent(): array
    {
        $hotelName = app_setting('hotel_name', 'Hotel H Plus');
        $hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
        $hotelWhatsapp = app_setting('hotel_whatsapp', $hotelPhone);
        $hotelEmail = app_setting('hotel_email', 'info@hotelhplus.in');
        $services = $this->eventServices();
        $packages = $this->eventPackages();

        return [
            'hotelName' => $hotelName,
            'hotelPhone' => $hotelPhone,
            'hotelEmail' => $hotelEmail,
            'hotelAddress' => app_setting('hotel_address', 'Opposite Sector-7, Pipli Road, Kurukshetra'),
            'eventsEmail' => app_setting('events_email', $hotelEmail),
            'whatsAppNumber' => preg_replace('/\D+/', '', $hotelWhatsapp) ?: '919253072122',
            'heroEyebrow' => app_setting('events_hero_eyebrow', 'Events'),
            'heroTitle' => app_setting('events_hero_title', 'Thoughtfully Planned'),
            'heroHighlight' => app_setting('events_hero_highlight', 'Celebrations'),
            'heroDescription' => app_setting('events_hero_description', 'From family functions to corporate gatherings, host events with polished spaces, attentive coordination, and guest-first hospitality at ' . $hotelName . '.'),
            'overviewEyebrow' => app_setting('events_overview_eyebrow', 'Why Choose Us'),
            'overviewTitle' => app_setting('events_overview_title', 'A Flexible Venue Designed For'),
            'overviewHighlight' => app_setting('events_overview_highlight', 'Memorable Events'),
            'overviewDescription' => app_setting('events_overview_description', 'Our events offering is built for celebrations and meetings that need comfort, coordination, and a dependable team.'),
            'overviewSecondaryDescription' => app_setting('events_overview_secondary_description', 'Guests benefit from practical layouts, easy access, on-ground support, and hospitality standards that make planning smoother for hosts.'),
            'capacityStat' => app_setting('events_capacity_stat', '300+'),
            'areaStat' => app_setting('events_area_stat', 'Custom setups'),
            'responseTimeStat' => app_setting('events_response_time_stat', 'Quick response'),
            'supportStat' => app_setting('events_support_stat', 'Planning support'),
            'servicesEyebrow' => app_setting('events_services_eyebrow', 'Event Types'),
            'servicesTitle' => app_setting('events_services_title', 'Perfect for Every'),
            'servicesHighlight' => app_setting('events_services_highlight', 'Occasion'),
            'servicesDescription' => app_setting('events_services_description', 'Choose the setup that fits your guest size, tone, and event format.'),
            'packagesEyebrow' => app_setting('events_packages_eyebrow', 'Packages'),
            'packagesTitle' => app_setting('events_packages_title', 'Flexible Options For'),
            'packagesHighlight' => app_setting('events_packages_highlight', 'Different Event Scales'),
            'packagesDescription' => app_setting('events_packages_description', 'Use these as planning references. Final pricing and inclusions can be tailored based on guest count, layout, and service requirements.'),
            'featureBullets' => $this->multilineSetting('events_feature_bullets', [
                'Decor coordination support',
                'Dining and catering assistance',
                'Parking convenience for guests',
                'Flexible seating layouts',
                'Audio-visual support for meetings',
                'On-ground coordination team',
            ]),
            'contactEyebrow' => app_setting('events_contact_eyebrow', 'Get In Touch'),
            'contactTitle' => app_setting('events_contact_title', 'Tell Us About'),
            'contactHighlight' => app_setting('events_contact_highlight', 'Your Event'),
            'contactDescription' => app_setting('events_contact_description', 'Share your event details and we will get back to you with the right setup guidance and availability.'),
            'ctaEyebrow' => app_setting('events_cta_eyebrow', 'Plan Your Event'),
            'ctaTitle' => app_setting('events_cta_title', 'Ready to Start Planning'),
            'ctaHighlight' => app_setting('events_cta_highlight', 'With Us?'),
            'ctaDescription' => app_setting('events_cta_description', 'Speak with our team to discuss dates, guest count, packages, and the event experience you want to create.'),
            'guestRanges' => $this->multilineSetting('events_guest_ranges', [
                'Up to 50',
                '50 - 120',
                '120 - 250',
                '250+',
            ]),
            'heroImage' => $this->assetUrl(app_setting('events_hero_image', 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp')),
            'secondaryImage' => $this->assetUrl(app_setting('events_secondary_image', 'assets/web/images/new/DSC_6618.webp')),
            'storyImage' => $this->assetUrl(app_setting('events_story_image', 'assets/web/images/new/DSC_6617.webp')),
            'ctaBackgroundImage' => $this->assetUrl(app_setting('events_cta_background_image', 'assets/web/images/homepage-hero-bg.webp')),
            'galleryImages' => array_map(
                fn (string $image): string => $this->assetUrl($image, $image),
                $this->multilineSetting('events_gallery_images', [
                    'assets/web/images/new/DSC_6616.webp',
                    'assets/web/images/new/DSC_6617.webp',
                    'assets/web/images/new/DSC_6618.webp',
                    'assets/web/images/new/DSC_6619.webp',
                    'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp',
                ])
            ),
            'services' => $services,
            'eventTypes' => [
                ...array_values(array_map(static fn (array $service): string => $service['title'], $services)),
                'Other',
            ],
            'packages' => $packages,
        ];
    }

    public function index(): string
    {
        $rooms = $this->activeRooms();

        return $this->render('front/home', $this->seoPageData(
            'home',
            app_setting('seo_meta_title', app_setting('hotel_name', 'Hotel H Plus')),
            app_setting('seo_meta_description', app_setting('hotel_tagline', 'Comfortable stays and thoughtful hospitality.')),
            [
                'canonicalUrl' => base_url('/'),
                'jsonLdItems' => [
                    $this->websiteSchema(),
                ],
            ]
        ) + [
            'activePage'      => 'home',
            'headerTheme'     => 'dark',
            'pageStyles'      => ['assets/web/css/home.css'],
            'pageScripts'     => ['assets/web/js/home.js'],
            'rooms'           => $rooms,
            'footerRooms'     => array_slice($rooms, 0, 3),
            'homeContent'     => $this->homeContent(),
        ]);
    }

    public function about(): string
    {
        return $this->render('front/about', $this->seoPageData(
            'about',
            'About Us | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Learn about ' . app_setting('hotel_name', 'Hotel H Plus') . ' and the hospitality experience we offer.',
            [
                'canonicalUrl' => base_url('about'),
            ]
        ) + [
            'activePage'      => 'about',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/about.css'],
            'aboutPage'       => $this->aboutPageContent(),
        ]);
    }

    public function rooms(): string
    {
        $rooms = $this->activeRooms();

        return $this->render('front/rooms', $this->seoPageData(
            'rooms',
            'Rooms & Suites | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Explore the available room categories and stay options at ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('rooms'),
                'jsonLdItems' => [
                    $this->breadcrumbSchema([
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'Rooms', 'url' => 'rooms'],
                    ]),
                ],
            ]
        ) + [
            'activePage'      => 'rooms',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/rooms.css'],
            'rooms'           => $rooms,
        ]);
    }

    public function roomDetail(string $slug): string
    {
        return $this->renderRoomDetail($slug);
    }

    public function events(): string
    {
        return $this->render('front/events', $this->seoPageData(
            'events',
            'Events | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Plan celebrations, social gatherings, and corporate events with ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('events'),
            ]
        ) + [
            'activePage'      => 'events',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/events.css'],
            'eventsPage'      => $this->eventsPageContent(),
        ]);
    }

    public function trident(): string
    {
        $tridentPage = $this->tridentPageContent();

        return $this->render('front/trident', $this->seoPageData(
            'trident',
            'Trident Banquet Hall | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Explore Trident Banquet Hall for weddings, celebrations, and corporate events at ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('trident'),
                'jsonLdItems' => [
                    $this->tridentSchema($tridentPage),
                    $this->breadcrumbSchema([
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'Trident Banquet Hall', 'url' => 'trident'],
                    ]),
                ],
            ]
        ) + [
            'activePage'      => 'trident',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/trident.css'],
            'tridentPage'     => $tridentPage,
        ]);
    }

    public function gallery(): string
    {
        return $this->render('front/gallery', $this->seoPageData(
            'gallery',
            'Gallery | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Browse the hotel gallery and see rooms, spaces, and hospitality moments from ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('gallery'),
            ]
        ) + [
            'activePage'      => 'gallery',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/gallery.css'],
            'pageScripts'     => ['assets/web/js/gallery.js'],
            'images'          => $this->galleryImages(),
        ]);
    }

    public function contact(): string
    {
        return $this->render('front/contact', $this->seoPageData(
            'contact',
            'Contact Us | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Get in touch with ' . app_setting('hotel_name', 'Hotel H Plus') . ' for reservations, enquiries, and directions.',
            [
                'canonicalUrl' => base_url('contact'),
                'jsonLdItems' => [
                    $this->breadcrumbSchema([
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'Contact', 'url' => 'contact'],
                    ]),
                ],
            ]
        ) + [
            'activePage'      => 'contact',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/contact.css'],
            'rooms'           => $this->activeRooms(),
        ]);
    }

    public function faq(): string
    {
        return $this->render('front/faq', $this->seoPageData(
            'faq',
            'FAQ | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Frequently asked questions for guests staying at ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('faq'),
                'jsonLdItems' => [
                    $this->faqSchema(),
                    $this->breadcrumbSchema([
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'FAQ', 'url' => 'faq'],
                    ]),
                ],
            ]
        ) + [
            'activePage'      => '',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/faq.css'],
            'pageScripts'     => ['assets/web/js/faq.js'],
        ]);
    }

    public function privacyPolicy(): string
    {
        return $this->render('front/privacy_policy', $this->seoPageData(
            'privacy',
            'Privacy Policy | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Privacy policy for ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('privacy-policy'),
            ]
        ) + [
            'activePage'      => '',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/legal.css'],
            'legalPage'       => $this->legalPageContent(),
        ]);
    }

    public function termsConditions(): string
    {
        return $this->render('front/terms_conditions', $this->seoPageData(
            'terms',
            'Terms & Conditions | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Terms and conditions for bookings and services at ' . app_setting('hotel_name', 'Hotel H Plus') . '.',
            [
                'canonicalUrl' => base_url('terms-conditions'),
            ]
        ) + [
            'activePage'      => '',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/legal.css'],
            'legalPage'       => $this->legalPageContent(),
        ]);
    }

    public function thankYou(): string
    {
        return $this->render('front/thank_you', $this->thankYouMessageData());
    }

    private function renderRoomDetail(string $slug): string
    {
        $room = $this->roomBySlug($slug);

        if ($room === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $pageKey = 'rooms_' . trim((string) preg_replace('/[^a-z0-9]+/i', '_', strtolower($slug)), '_');

        if ($pageKey === 'rooms_') {
            $pageKey = 'rooms_detail';
        }

        return $this->render('front/room_detail', $this->seoPageData(
            $pageKey,
            $room['name'] . ' | ' . app_setting('hotel_name', 'Hotel H Plus'),
            $room['description'] ?: ('Stay in the ' . $room['name'] . ' at ' . app_setting('hotel_name', 'Hotel H Plus') . '.'),
            [
                'canonicalUrl' => base_url('rooms/' . $slug),
                'ogImage' => app_setting('seo_' . $pageKey . '_og_image', '') ?: ($room['image'] ?? ''),
                'jsonLdItems' => [
                    $this->roomSchema($room),
                    $this->breadcrumbSchema([
                        ['name' => 'Home', 'url' => '/'],
                        ['name' => 'Rooms', 'url' => 'rooms'],
                        ['name' => (string) ($room['name'] ?? 'Room'), 'url' => 'rooms/' . $slug],
                    ]),
                ],
            ]
        ) + [
            'activePage'      => 'rooms',
            'headerTheme'     => 'light',
            'pageStyles'      => ['assets/web/css/room-detail.css'],
            'pageScripts'     => ['assets/web/js/room-detail.js'],
            'room'            => $room,
            'paymentGatewayActive' => $this->paymentGatewayActive(),
            'paymentGatewayReady' => $this->paymentGatewayReady(),
            'paymentGatewayLabel' => $this->payments()->currentGatewayLabel(),
            'roomBookingAllowed' => $this->roomBookingAllowed($room),
            'websiteBookingEnabled' => $this->websiteBookingEnabled(),
            'roomMeta'        => $this->roomMeta($slug),
            'roomPageContent' => $this->roomPageContent(),
            'rooms'           => $this->activeRooms(),
        ]);
    }

    public function contactSend()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[80]',
            'last_name'  => 'permit_empty|max_length[80]',
            'email'      => 'required|valid_email|max_length[180]',
            'phone'      => 'permit_empty|max_length[20]',
            'subject'    => 'required|max_length[255]',
            'message'    => 'required',
            'room_type'  => 'permit_empty|max_length[80]',
            'checkin'    => 'permit_empty|valid_date[Y-m-d]',
            'checkout'   => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('contact'))
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $data = [
            'first_name' => trim((string) $this->request->getPost('first_name')),
            'last_name'  => trim((string) $this->request->getPost('last_name')),
            'email'      => trim((string) $this->request->getPost('email')),
            'phone'      => trim((string) $this->request->getPost('phone')),
            'subject'    => trim((string) $this->request->getPost('subject')),
            'message'    => trim((string) $this->request->getPost('message')),
            'room_type'  => trim((string) $this->request->getPost('room_type')),
            'checkin'    => $this->request->getPost('checkin') ?: null,
            'checkout'   => $this->request->getPost('checkout') ?: null,
            'status'     => 'new',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        \Config\Database::connect()->table('enquiries')->insert($data);

        $mailer = service('appMailer');

        if (! $mailer->sendEnquiryAdminNotification($data)) {
            log_message('error', 'Failed to send admin enquiry notification email.');
        }

        if (! $mailer->sendEnquiryAutoReply($data)) {
            log_message('warning', 'Customer auto-reply email was not sent.');
        }

        return redirect()->to(base_url('thank-you'))
            ->with('success', 'Your enquiry has been sent successfully.');
    }

    public function contactSendDirect()
    {
        return redirect()->to(base_url('contact'))
            ->with('error', 'Please use the contact form to send your enquiry.');
    }

    public function bookingSend()
    {
        $failureRedirect = fn () => redirect()->to($this->bookingFormUrl())->withInput();
        $rules = [
            'name'      => 'required|min_length[2]|max_length[160]',
            'phone'     => 'required|max_length[20]',
            'email'     => $this->paymentGatewayActive() ? 'required|valid_email|max_length[180]' : 'permit_empty|valid_email|max_length[180]',
            'room_slug' => 'permit_empty|max_length[120]',
            'room_type' => 'required|max_length[80]',
            'checkin'   => 'required|valid_date[Y-m-d]',
            'checkout'  => 'required|valid_date[Y-m-d]',
            'guests'    => 'required|integer|greater_than[0]|less_than_equal_to[500]',
            'rooms_required' => 'permit_empty|integer|greater_than[0]|less_than_equal_to[500]',
        ];

        if (! $this->validate($rules)) {
            return $failureRedirect()->with('error', $this->validator->listErrors());
        }

        $checkin = (string) $this->request->getPost('checkin');
        $checkout = (string) $this->request->getPost('checkout');
        $guests = max(1, (int) $this->request->getPost('guests'));
        $roomsRequired = max(1, (int) ($this->request->getPost('rooms_required') ?: 1));

        if ($checkout <= $checkin) {
            return $failureRedirect()->with('error', 'Checkout date must be after check-in date.');
        }

        $roomType = trim((string) $this->request->getPost('room_type'));
        $roomSlug = trim((string) $this->request->getPost('room_slug'));
        $roomBuilder = $this->db()->table('rooms')->where('is_active', 1);
        $room = $roomSlug !== ''
            ? $roomBuilder->where('slug', $roomSlug)->get()->getRowArray()
            : $this->db()->table('rooms')->where('name', $roomType)->where('is_active', 1)->get()->getRowArray();

        if (! $room) {
            return $failureRedirect()->with('error', 'Selected room is not available.');
        }

        if ($roomsRequired > max(1, (int) ($room['available_units'] ?? 1))) {
            return $failureRedirect()->with('error', 'This room type has only ' . max(1, (int) ($room['available_units'] ?? 1)) . ' room(s) in total.');
        }

        $maxGuestsPerRoom = max(1, (int) ($room['max_guests'] ?? 1));
        $minimumRooms = (int) ceil($guests / $maxGuestsPerRoom);

        if ($roomsRequired < $minimumRooms) {
            return $failureRedirect()->with('error', $guests . ' guest(s) require at least ' . $minimumRooms . ' room(s) for this room type.');
        }

        $availability = $this->roomAvailability($room, $checkin, $checkout, $roomsRequired);

        if (! $availability['available']) {
            return $failureRedirect()->with('error', 'Only ' . $availability['remaining'] . ' room(s) are available for at least one selected night. Please reduce rooms or choose different dates.');
        }

        if ($this->paymentGatewayActive()) {
            if (! $this->paymentGatewayReady()) {
                return $failureRedirect()->with('error', 'Booking is not available right now because payment gateway setup is incomplete.');
            }

            if (! $this->websiteBookingEnabled()) {
                return $failureRedirect()->with('error', 'Booking is currently turned off on the website.');
            }

            if (! $room || (int) ($room['booking_open'] ?? 1) !== 1) {
                return $failureRedirect()->with('error', 'Booking is currently closed for this room.');
            }
        }

        $paymentRequired = $this->paymentGatewayActive() ? 1 : 0;
        $amount = $this->payments()->calculateRoomAmount($room, $checkin, $checkout, $roomsRequired);

        $data = [
            'booking_code'     => $this->payments()->buildBookingCode(),
            'name'             => trim((string) $this->request->getPost('name')),
            'phone'            => trim((string) $this->request->getPost('phone')),
            'email'            => trim((string) $this->request->getPost('email')),
            'room_type'        => $roomType,
            'room_id'          => $room['id'] ?? null,
            'checkin'          => $checkin,
            'checkout'         => $checkout,
            'guests'           => $guests,
            'rooms_required'   => $roomsRequired,
            'total_amount'     => $amount['total_amount'],
            'currency'         => $amount['currency'],
            'payment_required' => $paymentRequired,
            'payment_gateway'  => $paymentRequired ? $this->paymentGatewayProvider() : null,
            'payment_status'   => $paymentRequired ? 'initiated' : 'not_required',
            'status'           => 'pending',
            'notes'            => trim((string) $this->request->getPost('notes')),
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        $this->db()->table('bookings')->insert($data);
        $bookingId = (int) $this->db()->insertID();
        $data['id'] = $bookingId;

        if ($paymentRequired === 1) {
            return redirect()->to(base_url('booking/checkout/' . $data['booking_code'] . '?autostart=1'));
        }

        $mailer = service('appMailer');

        if (! $mailer->sendBookingAdminNotification($data)) {
            log_message('error', 'Failed to send admin booking notification email.');
        }

        if (! $mailer->sendBookingAutoReply($data)) {
            log_message('warning', 'Booking auto-reply email was not sent.');
        }

        return redirect()->to(base_url('thank-you'))->with('success', 'Your booking request has been sent.');
    }

    public function bookingSendDirect()
    {
        return redirect()->to(base_url('rooms'))
            ->with('error', 'Please choose a room and submit the booking form.');
    }

    private function bookingFormUrl(): string
    {
        $roomSlug = trim((string) $this->request->getPost('room_slug'));

        if ($roomSlug === '') {
            return base_url('rooms');
        }

        return base_url('rooms/' . rawurlencode($roomSlug));
    }

    private function roomAvailability(array $room, string $checkin, string $checkout, int $requestedUnits = 1): array
    {
        $roomId = (int) ($room['id'] ?? 0);
        $availableUnits = max(1, (int) ($room['available_units'] ?? 1));
        $requestedUnits = max(1, $requestedUnits);

        if ($roomId <= 0 || ! $this->db()->tableExists('bookings')) {
            return [
                'available' => true,
                'available_units' => $availableUnits,
                'booked_units' => 0,
                'remaining' => $availableUnits,
            ];
        }

        $maxBookedUnits = 0;
        $start = new \DateTimeImmutable($checkin);
        $end = new \DateTimeImmutable($checkout);
        $useRoomsRequired = $this->db()->fieldExists('rooms_required', 'bookings');

        for ($date = $start; $date < $end; $date = $date->modify('+1 day')) {
            $dateValue = $date->format('Y-m-d');
            $builder = $this->db()->table('bookings')
                ->where('room_id', $roomId)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('checkin <=', $dateValue)
                ->where('checkout >', $dateValue);

            $bookedUnits = $useRoomsRequired
                ? (int) ($builder->selectSum('rooms_required', 'booked_units')->get()->getRowArray()['booked_units'] ?? 0)
                : $builder->countAllResults();

            $maxBookedUnits = max($maxBookedUnits, $bookedUnits);

            if ($bookedUnits + $requestedUnits > $availableUnits) {
                return [
                    'available' => false,
                    'available_units' => $availableUnits,
                    'booked_units' => $bookedUnits,
                    'remaining' => max(0, $availableUnits - $bookedUnits),
                ];
            }
        }

        return [
            'available' => true,
            'available_units' => $availableUnits,
            'booked_units' => $maxBookedUnits,
            'remaining' => max(0, $availableUnits - $maxBookedUnits),
        ];
    }

    public function bookingCheckout(string $bookingCode)
    {
        $booking = $this->bookingByCode($bookingCode);

        if ($booking === null) {
            return redirect()->to(base_url('rooms'))->with('error', 'Booking not found.');
        }

        if ((int) ($booking['payment_required'] ?? 0) !== 1) {
            return redirect()->to(base_url('thank-you'))->with('success', 'Your booking request has already been submitted.');
        }

        if (! $this->paymentGatewayActive() || ! $this->paymentGatewayReady()) {
            $fallbackRoom = $this->roomByBooking($booking);
            $fallbackUrl = $fallbackRoom ? base_url('rooms/' . $fallbackRoom['slug']) : base_url('rooms');

            return redirect()->to($fallbackUrl)->with('error', 'Online booking is not available right now.');
        }

        if (($booking['payment_status'] ?? '') === 'paid') {
            return redirect()->to(base_url('booking/payment-status/' . $bookingCode));
        }

        $room = $this->roomByBooking($booking);

        if ($room === null) {
            return redirect()->to(base_url('rooms'))->with('error', 'Room details could not be found for this booking.');
        }

        $amount = $this->payments()->calculateRoomAmount($room, (string) $booking['checkin'], (string) $booking['checkout'], (int) ($booking['rooms_required'] ?? 1));
        $expectedTotal = round((float) ($amount['total_amount'] ?? 0), 2);

        if (round((float) ($booking['total_amount'] ?? 0), 2) !== $expectedTotal) {
            $booking['total_amount'] = $expectedTotal;
            $booking['currency'] = (string) ($amount['currency'] ?? 'INR');
            $this->db()->table('bookings')->where('id', (int) $booking['id'])->update([
                'total_amount' => $booking['total_amount'],
                'currency' => $booking['currency'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $checkout = $this->payments()->prepareCheckout($booking, $room);

        return $this->render('front/booking_checkout', [
            'title'              => 'Complete Payment',
            'activePage'         => 'rooms',
            'headerTheme'        => 'light',
            'metaRobots'         => 'noindex, nofollow',
            'canonicalUrl'       => base_url('rooms/' . ($room['slug'] ?? '')),
            'room'               => $room,
            'booking'            => $booking,
            'bookingNights'      => $amount['nights'],
            'nightlyRate'        => $amount['nightly_rate'],
            'gatewayLabel'       => $this->payments()->currentGatewayLabel(),
            'gatewayEnvironment' => $this->payments()->currentGateway()?->environment() ?? 'production',
            'gatewayProvider'     => $this->payments()->currentProvider(),
            'checkoutReady'      => $checkout->success,
            'checkoutSessionId'  => $checkout->sessionToken,
            'checkoutPayload'    => $checkout->responsePayload,
            'checkoutScriptUrl'  => $this->payments()->checkoutScriptUrl(),
            'checkoutAutoStart'  => $this->request->getGet('autostart') === '1' && ! session()->has('error'),
        ]);
    }

    public function bookingPaymentReturn()
    {
        $bookingCode = trim((string) $this->request->getGet('booking'));
        $gatewayOrderId = trim((string) $this->request->getGet('order_id'));

        if ($bookingCode === '') {
            return redirect()->to(base_url('rooms'))->with('error', 'Invalid payment return request.');
        }

        $booking = $this->bookingByCode($bookingCode);

        if ($booking === null) {
            return redirect()->to(base_url('rooms'))->with('error', 'Booking not found for payment verification.');
        }

        $result = $this->payments()->verifyBookingPayment($booking, $gatewayOrderId !== '' ? $gatewayOrderId : null);
        $booking = $this->bookingByCode($bookingCode) ?? $booking;

        if ($result->status === 'paid') {
            $this->payments()->sendBookingNotificationsIfNeeded($booking);
        }

        return redirect()->to(base_url('booking/payment-status/' . $bookingCode . '?source=return'));
    }

    public function bookingPaymentStatus(string $bookingCode)
    {
        $booking = $this->bookingByCode($bookingCode);

        if ($booking === null) {
            return redirect()->to(base_url('rooms'))->with('error', 'Booking not found.');
        }

        $room = $this->roomByBooking($booking);
        $transaction = $this->payments()->latestTransaction((int) $booking['id']);
        $paymentStatus = (string) ($booking['payment_status'] ?? 'not_required');

        if ($transaction !== null && in_array($paymentStatus, ['initiated', 'pending'], true)) {
            $verification = $this->payments()->verifyBookingPayment($booking, (string) ($transaction['gateway_order_id'] ?? ''));
            $booking = $this->bookingByCode($bookingCode) ?? $booking;
            $transaction = $this->payments()->latestTransaction((int) $booking['id']);
            $paymentStatus = (string) ($booking['payment_status'] ?? 'not_required');

            if ($verification->status === 'paid') {
                $this->payments()->sendBookingNotificationsIfNeeded($booking);
            }
        }

        return $this->render('front/booking_status', [
            'title'             => 'Booking Payment Status',
            'activePage'        => 'rooms',
            'headerTheme'       => 'light',
            'bodyClass'         => 'bg-ivory',
            'metaRobots'        => 'noindex, nofollow',
            'canonicalUrl'      => base_url('rooms/' . ($room['slug'] ?? '')),
            'pageStyles'        => ['assets/web/css/room-detail.css'],
            'booking'           => $booking,
            'room'              => $room,
            'transaction'       => $transaction,
            'paymentStatus'     => $paymentStatus,
            'statusLabel'       => $this->payments()->bookingStatusLabel($paymentStatus),
            'statusMessage'     => $this->payments()->bookingStatusMessage($booking),
            'canRetry'          => $this->payments()->bookingCanRetry($booking),
            'receiptData'       => $this->payments()->receiptData($booking, $room, $transaction),
        ]);
    }

    public function bookingLookup(): string
    {
        if (app_setting('guest_lookup_enabled', '1') !== '1') {
            return $this->render('front/booking_lookup', $this->seoPageData(
                'booking_lookup',
                'Find Booking | ' . app_setting('hotel_name', 'Hotel H Plus'),
                'Find your booking status using your booking code and registered email or phone number.',
                [
                    'canonicalUrl' => base_url('booking/lookup'),
                    'metaRobots' => 'noindex, nofollow',
                ]
            ) + [
                'activePage' => 'rooms',
                'headerTheme' => 'light',
                'bodyClass' => 'bg-ivory',
                'pageStyles' => ['assets/web/css/room-detail.css'],
                'lookupDisabled' => true,
            ]);
        }

        return $this->render('front/booking_lookup', $this->seoPageData(
            'booking_lookup',
            'Find Booking | ' . app_setting('hotel_name', 'Hotel H Plus'),
            'Find your booking status using your booking code and registered email or phone number.',
            [
                'canonicalUrl' => base_url('booking/lookup'),
                'metaRobots' => 'noindex, nofollow',
            ]
        ) + [
            'activePage' => 'rooms',
            'headerTheme' => 'light',
            'bodyClass' => 'bg-ivory',
            'pageStyles' => ['assets/web/css/room-detail.css'],
            'lookupDisabled' => false,
        ]);
    }

    public function bookingLookupPost()
    {
        if (app_setting('guest_lookup_enabled', '1') !== '1') {
            return redirect()->to(base_url('booking/lookup'))->with('error', 'Guest booking lookup is currently disabled.');
        }

        if (! $this->validate([
            'booking_code' => 'required|max_length[60]',
            'identity' => 'required|max_length[180]',
        ])) {
            return redirect()->to(base_url('booking/lookup'))->withInput()->with('error', 'Enter your booking code and email or phone number.');
        }

        $bookingCode = trim((string) $this->request->getPost('booking_code'));
        $identity = strtolower(trim((string) $this->request->getPost('identity')));
        $booking = $this->bookingByCode($bookingCode);

        if (! $booking || ! $this->bookingIdentityMatches($booking, $identity)) {
            return redirect()->to(base_url('booking/lookup'))->withInput()->with('error', 'We could not find a booking with those details.');
        }

        return redirect()->to(base_url('booking/payment-status/' . rawurlencode((string) ($booking['booking_code'] ?? $bookingCode))));
    }

    public function bookingReceipt(string $bookingCode)
    {
        $booking = $this->bookingByCode($bookingCode);

        if ($booking === null) {
            return redirect()->to(base_url('rooms'))->with('error', 'Receipt not found.');
        }

        if ((string) ($booking['payment_status'] ?? '') !== 'paid') {
            return redirect()->to(base_url('booking/payment-status/' . $bookingCode))->with('error', 'Receipt becomes available after successful payment.');
        }

        $room = $this->roomByBooking($booking);
        $transaction = $this->payments()->latestTransaction((int) $booking['id']);
        $receipt = $this->payments()->receiptData($booking, $room, $transaction);
        $pdf = $this->receiptPdfBuilder()->build($receipt);
        $filename = 'receipt-' . preg_replace('/[^A-Za-z0-9\-]/', '', (string) ($booking['booking_code'] ?? 'booking')) . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('X-Robots-Tag', 'noindex, nofollow')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($pdf);
    }

    private function bookingIdentityMatches(array $booking, string $identity): bool
    {
        $identityDigits = preg_replace('/\D+/', '', $identity) ?? '';
        $email = strtolower(trim((string) ($booking['email'] ?? '')));
        $phoneDigits = preg_replace('/\D+/', '', (string) ($booking['phone'] ?? '')) ?? '';

        if ($email !== '' && $identity === $email) {
            return true;
        }

        return $identityDigits !== '' && $phoneDigits !== '' && str_ends_with($phoneDigits, $identityDigits);
    }

    public function tridentSend()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[160]',
            'phone'      => 'required|max_length[20]',
            'email'      => 'required|valid_email|max_length[180]',
            'event_type' => 'required|max_length[100]',
            'event_date' => 'permit_empty|valid_date[Y-m-d]',
            'guests'     => 'permit_empty|max_length[30]',
            'message'    => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('trident'))->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'name'       => trim((string) $this->request->getPost('name')),
            'phone'      => trim((string) $this->request->getPost('phone')),
            'email'      => trim((string) $this->request->getPost('email')),
            'event_type' => trim((string) $this->request->getPost('event_type')),
            'event_date' => $this->request->getPost('event_date') ?: null,
            'guests'     => trim((string) $this->request->getPost('guests')),
            'message'    => trim((string) $this->request->getPost('message')),
            'status'     => 'new',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db()->table('trident_enquiries')->insert($data);

        $mailer = service('appMailer');

        if (! $mailer->sendTridentAdminNotification($data)) {
            log_message('error', 'Failed to send admin Trident enquiry notification email.');
        }

        if (! $mailer->sendTridentAutoReply($data)) {
            log_message('warning', 'Trident enquiry auto-reply email was not sent.');
        }

        return redirect()->to(base_url('thank-you'))->with('success', 'Your event enquiry has been sent successfully.');
    }

    public function eventsSend()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[160]',
            'phone'      => 'required|max_length[20]',
            'email'      => 'required|valid_email|max_length[180]',
            'event_type' => 'required|max_length[120]',
            'event_date' => 'permit_empty|valid_date[Y-m-d]',
            'guests'     => 'permit_empty|max_length[30]',
            'message'    => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('events'))->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'name'       => trim((string) $this->request->getPost('name')),
            'phone'      => trim((string) $this->request->getPost('phone')),
            'email'      => trim((string) $this->request->getPost('email')),
            'event_type' => trim((string) $this->request->getPost('event_type')),
            'event_date' => $this->request->getPost('event_date') ?: null,
            'guests'     => trim((string) $this->request->getPost('guests')),
            'message'    => trim((string) $this->request->getPost('message')),
            'status'     => 'new',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db()->table('event_enquiries')->insert($data);

        $mailer = service('appMailer');

        if (! $mailer->sendEventAdminNotification($data)) {
            log_message('error', 'Failed to send admin event enquiry notification email.');
        }

        if (! $mailer->sendEventAutoReply($data)) {
            log_message('warning', 'Event enquiry auto-reply email was not sent.');
        }

        return redirect()->to(base_url('thank-you'))->with('success', 'Your event enquiry has been sent successfully.');
    }

    public function eventsSendDirect()
    {
        return redirect()->to(base_url('events'))
            ->with('error', 'Please use the event enquiry form to submit your request.');
    }

    public function subscribe()
    {
        $returnUrl = $this->safeFrontendReturnUrl();
        $rules = [
            'full_name' => 'required|min_length[2]|max_length[120]',
            'email' => 'required|valid_email|max_length[180]',
        ];

        if (! $this->validate($rules)) {
            $errors = implode(' ', array_values($this->validator->getErrors()));

            return redirect()->to($returnUrl)
                ->withInput()
                ->with('newsletter_error', $errors ?: 'Please check your name and email address.');
        }

        $db = $this->db();

        if (! $db->tableExists('subscribers')) {
            return redirect()->to($returnUrl)
                ->withInput()
                ->with('newsletter_error', 'Subscriber list is not ready yet. Please try again in a moment.');
        }

        $fullName = trim((string) $this->request->getPost('full_name'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $now = date('Y-m-d H:i:s');

        $existing = $db->table('subscribers')->where('email', $email)->get()->getRowArray();

        if ($existing) {
            $db->table('subscribers')
                ->where('id', $existing['id'])
                ->update([
                    'full_name' => $fullName,
                    'email' => $email,
                    'status' => 'active',
                    'subscribed_at' => $existing['subscribed_at'] ?: $now,
                    'updated_at' => $now,
                ]);

            return redirect()->to($returnUrl)->with('newsletter_success', 'You are already subscribed. We refreshed your details.');
        }

        $db->table('subscribers')->insert([
            'full_name' => $fullName,
            'email' => $email,
            'status' => 'active',
            'subscribed_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $mailer = service('appMailer');
        if (! $mailer->sendSubscriberWelcome([
            'full_name' => $fullName,
            'email' => $email,
        ])) {
            log_message('warning', 'Subscriber welcome email was not sent.');
        }

        return redirect()->to($returnUrl)->with('newsletter_success', 'Thanks for subscribing.');
    }

    public function subscribeDirect()
    {
        return redirect()->to(base_url('/'))
            ->with('newsletter_error', 'Please use the newsletter form to subscribe.');
    }

    private function safeFrontendReturnUrl(): string
    {
        $returnUrl = trim((string) $this->request->getPost('return_url'));

        if ($returnUrl === '') {
            return base_url('/');
        }

        $baseHost = parse_url(base_url('/'), PHP_URL_HOST);
        $returnHost = parse_url($returnUrl, PHP_URL_HOST);

        if ($returnHost !== null && $returnHost !== false && $returnHost !== $baseHost) {
            return base_url('/');
        }

        return $returnUrl;
    }

}
