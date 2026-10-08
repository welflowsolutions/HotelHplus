<?php
$activeSettingsTab = $activeSettingsTab ?? 'hotel';

$hotelName     = old('hotel_name', $settings['hotel_name'] ?? 'Hotel H Plus');
$hotelPhone    = old('hotel_phone', $settings['hotel_phone'] ?? '');
$hotelEmail    = old('hotel_email', $settings['hotel_email'] ?? '');
$hotelWhatsapp = old('hotel_whatsapp', $settings['hotel_whatsapp'] ?? $hotelPhone);
$hotelTagline  = old('hotel_tagline', $settings['hotel_tagline'] ?? 'Comfortable stays and thoughtful hospitality.');
$hotelAddress  = old('hotel_address', $settings['hotel_address'] ?? '');

$brandLogo            = old('brand_logo', $settings['brand_logo'] ?? '');
$brandFavicon         = old('brand_favicon', $settings['brand_favicon'] ?? '');
$brandHeaderSubtitle  = old('brand_header_subtitle', $settings['brand_header_subtitle'] ?? 'Kurukshetra');
$brandFooterText      = old('brand_footer_text', $settings['brand_footer_text'] ?? '');
$brandFacebook        = old('brand_facebook', $settings['brand_facebook'] ?? '');
$brandInstagram       = old('brand_instagram', $settings['brand_instagram'] ?? '');
$brandX               = old('brand_x', $settings['brand_x'] ?? '');
$seoMetaTitle         = old('seo_meta_title', $settings['seo_meta_title'] ?? $hotelName);
$seoMetaDescription   = old('seo_meta_description', $settings['seo_meta_description'] ?? $hotelTagline);
$seoMetaKeywords      = old('seo_meta_keywords', $settings['seo_meta_keywords'] ?? '');
$seoRobots            = old('seo_robots', $settings['seo_robots'] ?? 'index, follow');
$seoOgImage           = old('seo_og_image', $settings['seo_og_image'] ?? '');
$seoTwitterCard       = old('seo_twitter_card', $settings['seo_twitter_card'] ?? 'summary_large_image');
$seoHomeTitle         = old('seo_home_title', $settings['seo_home_title'] ?? $seoMetaTitle);
$seoHomeDescription   = old('seo_home_description', $settings['seo_home_description'] ?? $seoMetaDescription);
$seoAboutTitle        = old('seo_about_title', $settings['seo_about_title'] ?? 'About Us | ' . $hotelName);
$seoAboutDescription  = old('seo_about_description', $settings['seo_about_description'] ?? 'Learn about ' . $hotelName . ' and the hospitality experience we offer.');
$seoRoomsTitle        = old('seo_rooms_title', $settings['seo_rooms_title'] ?? 'Rooms & Suites | ' . $hotelName);
$seoRoomsDescription  = old('seo_rooms_description', $settings['seo_rooms_description'] ?? 'Explore the available room categories and stay options at ' . $hotelName . '.');
$seoTridentTitle      = old('seo_trident_title', $settings['seo_trident_title'] ?? 'Trident Banquet Hall | ' . $hotelName);
$seoTridentDescription= old('seo_trident_description', $settings['seo_trident_description'] ?? 'Explore Trident Banquet Hall for weddings, celebrations, and corporate events at ' . $hotelName . '.');
$seoGalleryTitle      = old('seo_gallery_title', $settings['seo_gallery_title'] ?? 'Gallery | ' . $hotelName);
$seoGalleryDescription= old('seo_gallery_description', $settings['seo_gallery_description'] ?? 'Browse the hotel gallery and see rooms, spaces, and hospitality moments from ' . $hotelName . '.');
$seoContactTitle      = old('seo_contact_title', $settings['seo_contact_title'] ?? 'Contact Us | ' . $hotelName);
$seoContactDescription= old('seo_contact_description', $settings['seo_contact_description'] ?? 'Get in touch with ' . $hotelName . ' for reservations, enquiries, and directions.');
$seoFaqTitle          = old('seo_faq_title', $settings['seo_faq_title'] ?? 'FAQ | ' . $hotelName);
$seoFaqDescription    = old('seo_faq_description', $settings['seo_faq_description'] ?? 'Frequently asked questions for guests staying at ' . $hotelName . '.');
$seoPrivacyTitle      = old('seo_privacy_title', $settings['seo_privacy_title'] ?? 'Privacy Policy | ' . $hotelName);
$seoPrivacyDescription= old('seo_privacy_description', $settings['seo_privacy_description'] ?? 'Privacy policy for ' . $hotelName . '.');
$seoTermsTitle        = old('seo_terms_title', $settings['seo_terms_title'] ?? 'Terms & Conditions | ' . $hotelName);
$seoTermsDescription  = old('seo_terms_description', $settings['seo_terms_description'] ?? 'Terms and conditions for bookings and services at ' . $hotelName . '.');
$seoThankYouTitle     = old('seo_thank_you_title', $settings['seo_thank_you_title'] ?? 'Thank You | ' . $hotelName);
$seoThankYouDescription = old('seo_thank_you_description', $settings['seo_thank_you_description'] ?? 'Thank you for contacting ' . $hotelName . '.');

$smtpHost      = old('smtp_host', $settings['smtp_host'] ?? '');
$smtpPort      = old('smtp_port', $settings['smtp_port'] ?? '587');
$smtpUser      = old('smtp_user', $settings['smtp_user'] ?? '');
$smtpPass      = old('smtp_pass', $settings['smtp_pass'] ?? '');
$smtpCrypto    = old('smtp_crypto', $settings['smtp_crypto'] ?? 'tls');
$smtpFromEmail = old('smtp_from_email', $settings['smtp_from_email'] ?? $hotelEmail);
$smtpFromName  = old('smtp_from_name', $settings['smtp_from_name'] ?? $hotelName);

$bookingAdminEmail      = old('booking_admin_email', $settings['booking_admin_email'] ?? $hotelEmail);
$bookingWhatsappNumber  = old('booking_whatsapp_number', $settings['booking_whatsapp_number'] ?? $hotelWhatsapp);
$bookingSubjectPrefix   = old('booking_subject_prefix', $settings['booking_subject_prefix'] ?? '[Hotel H Plus]');
$bookingAutoReply       = old('booking_auto_reply_enabled', $settings['booking_auto_reply_enabled'] ?? '1');
$bookingCheckinTime     = old('booking_checkin_time', $settings['booking_checkin_time'] ?? '13:00');
$bookingCheckoutTime    = old('booking_checkout_time', $settings['booking_checkout_time'] ?? '11:00');
$receiptInvoicePrefix   = old('receipt_invoice_prefix', $settings['receipt_invoice_prefix'] ?? 'HHP');
$receiptGstEnabled      = old('receipt_gst_enabled', $settings['receipt_gst_enabled'] ?? '0');
$receiptGstRate         = old('receipt_gst_rate', $settings['receipt_gst_rate'] ?? '12');
$receiptTaxLabel        = old('receipt_tax_label', $settings['receipt_tax_label'] ?? '');
$receiptTaxNumber       = old('receipt_tax_number', $settings['receipt_tax_number'] ?? '');
$receiptPdfStyle        = old('receipt_pdf_style', $settings['receipt_pdf_style'] ?? 'classic');
$emailBookingAutoReplySubject = old('email_template_booking_auto_reply_subject', $settings['email_template_booking_auto_reply_subject'] ?? 'Your booking request at {hotel_name}');
$emailBookingAutoReplyBody = old('email_template_booking_auto_reply_body', $settings['email_template_booking_auto_reply_body'] ?? "Hello {guest_name},\n\nThank you for your booking request at {hotel_name}. We have received your request and our team will confirm availability shortly.\n\nRoom: {room_name}\nStay: {checkin} to {checkout}\nRooms: {rooms_required}\nGuests: {guests}\n\nIf needed, you can reach us at {hotel_contact}.\n\nRegards,\n{hotel_name}");
$emailEventAutoReplySubject = old('email_template_event_auto_reply_subject', $settings['email_template_event_auto_reply_subject'] ?? 'Your event enquiry at {hotel_name}');
$emailEventAutoReplyBody = old('email_template_event_auto_reply_body', $settings['email_template_event_auto_reply_body'] ?? "Hello {guest_name},\n\nThank you for your event enquiry at {hotel_name}. Our events team has received your request and will get back to you shortly.\n\nEvent: {event_type}\nDate: {event_date}\nGuests: {guests}\n\nIf needed, you can reach us at {hotel_contact}.\n\nRegards,\n{hotel_name}");
$emailEventPaymentLinkSubject = old('email_template_event_payment_link_subject', $settings['email_template_event_payment_link_subject'] ?? 'Event payment link from {hotel_name}');
$emailEventPaymentLinkBody = old('email_template_event_payment_link_body', $settings['email_template_event_payment_link_body'] ?? "Hello {guest_name},\n\nYour event payment link from {hotel_name} is ready.\n\nPayment Code: {payment_code}\nEvent: {event_type}\nEvent Date: {event_date}\nAmount: {amount}\n\nPay securely here:\n{payment_link}\n\nRegards,\n{hotel_name}");
$guestLookupEnabled     = old('guest_lookup_enabled', $settings['guest_lookup_enabled'] ?? '1');
$paymentGatewayEnabled  = old('payment_gateway_enabled', $settings['payment_gateway_enabled'] ?? '0');
$paymentGatewayProvider = old('payment_gateway_provider', $settings['payment_gateway_provider'] ?? 'cashfree');
$paymentGatewayOptions  = payment_gateway_options();
$bookingEnabled         = old('booking_enabled', $settings['booking_enabled'] ?? '1');
$cashfreeAppId          = old('cashfree_app_id', $settings['cashfree_app_id'] ?? '');
$cashfreeSecretKey      = old('cashfree_secret_key', $settings['cashfree_secret_key'] ?? '');
$cashfreeEnvironment    = old('cashfree_environment', $settings['cashfree_environment'] ?? 'sandbox');
$cashfreeWebhookSecret  = old('cashfree_webhook_secret', $settings['cashfree_webhook_secret'] ?? '');
$cashfreeWebhookUrl     = base_url('payment/webhook/cashfree');
$razorpayKeyId          = old('razorpay_key_id', $settings['razorpay_key_id'] ?? '');
$razorpayKeySecret      = old('razorpay_key_secret', $settings['razorpay_key_secret'] ?? '');
$razorpayEnvironment    = old('razorpay_environment', $settings['razorpay_environment'] ?? 'sandbox');
$razorpayWebhookSecret  = old('razorpay_webhook_secret', $settings['razorpay_webhook_secret'] ?? '');
$razorpayWebhookUrl     = base_url('payment/webhook/razorpay');
$razorpayKeyPlaceholder = $razorpayEnvironment === 'production' ? 'rzp_live_...' : 'rzp_test_...';
$isPaymentGatewayActive = $paymentGatewayEnabled === '1';

$systemTimezone         = old('system_timezone', $settings['system_timezone'] ?? 'Asia/Kolkata');
$systemDateFormat       = old('system_date_format', $settings['system_date_format'] ?? 'd M Y');
$systemCurrencySymbol   = old('system_currency_symbol', $settings['system_currency_symbol'] ?? 'Rs.');
$systemRecordsPerPage   = old('system_records_per_page', $settings['system_records_per_page'] ?? '10');
$systemMaintenanceMode  = old('system_maintenance_mode', $settings['system_maintenance_mode'] ?? '0');
$systemDeveloperMode    = old('system_developer_mode', $settings['system_developer_mode'] ?? '0');
$developerOtpPending    = (bool) ($developerOtpPending ?? false);
$developerOtpEmail      = (string) ($developerOtpEmail ?? 'aarveyastudio@gmail.com');
$securityLoginMaxAttempts = old('security_login_max_attempts', $settings['security_login_max_attempts'] ?? '5');
$securityLoginLockMinutes = old('security_login_lock_minutes', $settings['security_login_lock_minutes'] ?? '15');
$securityRefundOtpMaxAttempts = old('security_refund_otp_max_attempts', $settings['security_refund_otp_max_attempts'] ?? '5');
$securityRefundOtpResendMinutes = old('security_refund_otp_resend_minutes', $settings['security_refund_otp_resend_minutes'] ?? '2');

$homeHeroEyebrow              = old('home_hero_eyebrow', $settings['home_hero_eyebrow'] ?? 'Best Hotel in Kurukshetra');
$homeHeroTitlePrefix          = old('home_hero_title_prefix', $settings['home_hero_title_prefix'] ?? 'Welcome to');
$homeHeroTitleHighlight       = old('home_hero_title_highlight', $settings['home_hero_title_highlight'] ?? $hotelName);
$homeHeroDescription          = old('home_hero_description', $settings['home_hero_description'] ?? 'A refined stay on Pipli Road, Kurukshetra, where comfort, hospitality, and thoughtful details come together beautifully.');
$homeHeroGuestCount           = old('home_hero_guest_count', $settings['home_hero_guest_count'] ?? '10,000+ guests');
$homeHeroReviewText           = old('home_hero_review_text', $settings['home_hero_review_text'] ?? '750+ Google Reviews');
$homeHeroImage                = old('home_hero_image', $settings['home_hero_image'] ?? 'assets/web/images/homepage-hero-bg.webp');
$homeHeroSecondaryImage       = old('home_hero_secondary_image', $settings['home_hero_secondary_image'] ?? 'assets/web/images/new/DSC_6631.webp');
$homeStatsRooms               = old('home_stats_rooms', $settings['home_stats_rooms'] ?? '15+');
$homeStatsStaff               = old('home_stats_staff', $settings['home_stats_staff'] ?? '10+');
$homeStatsHappyClients        = old('home_stats_happy_clients', $settings['home_stats_happy_clients'] ?? '100%');
$homeStatsReviews             = old('home_stats_reviews', $settings['home_stats_reviews'] ?? '750+');
$homeStatsBackgroundImage     = old('home_stats_background_image', $settings['home_stats_background_image'] ?? 'assets/web/images/homepage-hero-bg.webp');
$homeAboutEyebrow             = old('home_about_eyebrow', $settings['home_about_eyebrow'] ?? 'About Us');
$homeAboutTitle               = old('home_about_title', $settings['home_about_title'] ?? 'Experience Premium Comfort & Elegance');
$homeAboutHighlight           = old('home_about_highlight', $settings['home_about_highlight'] ?? 'Comfort & Elegance');
$homeAboutDescription         = old('home_about_description', $settings['home_about_description'] ?? 'Enjoy a peaceful and elegant stay at Hotel H Plus, Kurukshetra. Our well-furnished rooms, warm hospitality, and 24/7 service ensure a comfortable experience for families, business travelers, and guests seeking relaxation.');
$homeAboutMission             = old('home_about_mission', $settings['home_about_mission'] ?? 'To provide premium comfort, reliable service, and a welcoming environment for every guest who walks through our doors.');
$homeAboutVision              = old('home_about_vision', $settings['home_about_vision'] ?? 'To become the most trusted and preferred luxury hotel in Kurukshetra — a place guests return to again and again.');
$homeAboutValues              = old('home_about_values', $settings['home_about_values'] ?? 'Hospitality, cleanliness, safety, and unwavering guest satisfaction above everything else.');
$homeAboutImage               = old('home_about_image', $settings['home_about_image'] ?? 'assets/web/images/new/DSC_6608.webp');
$homeAboutSecondaryImage      = old('home_about_secondary_image', $settings['home_about_secondary_image'] ?? 'assets/web/images/new/DSC_6613.webp');
$homeRoomsEyebrow             = old('home_rooms_eyebrow', $settings['home_rooms_eyebrow'] ?? 'Rooms & Suites');
$homeRoomsTitle               = old('home_rooms_title', $settings['home_rooms_title'] ?? 'Indulge in Comfort Every Stay.');
$homeRoomsHighlight           = old('home_rooms_highlight', $settings['home_rooms_highlight'] ?? 'Every Stay.');
$homeRoomsDescription         = old('home_rooms_description', $settings['home_rooms_description'] ?? 'Experience ultimate relaxation, luxury, and world-class hospitality during every visit.');
$homeOfferEyebrow             = old('home_offer_eyebrow', $settings['home_offer_eyebrow'] ?? 'Today\'s Offer');
$homeOfferTitle               = old('home_offer_title', $settings['home_offer_title'] ?? 'Exclusive Limited-Time Offer This Month');
$homeOfferHighlight           = old('home_offer_highlight', $settings['home_offer_highlight'] ?? 'Offer This Month');
$homeOfferDescription         = old('home_offer_description', $settings['home_offer_description'] ?? 'Enjoy a special discounted stay at Hotel H Plus. Whether you\'re planning a family trip or a business visit, this is the perfect time to experience premium comfort at exceptional value.');
$homeOfferSecondaryDescription= old('home_offer_secondary_description', $settings['home_offer_secondary_description'] ?? 'Book now and take advantage of our limited-time savings before the offer ends.');
$homeOfferDiscountText        = old('home_offer_discount_text', $settings['home_offer_discount_text'] ?? '30%');
$homeOfferEnabled             = old('home_offer_enabled', $settings['home_offer_enabled'] ?? '1');
$homeOfferType                = old('home_offer_type', $settings['home_offer_type'] ?? 'both');
$homeOfferImage               = old('home_offer_image', $settings['home_offer_image'] ?? 'assets/web/images/new/DSC_6621.webp');
$homeCtaEyebrow               = old('home_cta_eyebrow', $settings['home_cta_eyebrow'] ?? 'Book Now');
$homeCtaTitle                 = old('home_cta_title', $settings['home_cta_title'] ?? 'Ready for a Luxurious Stay?');
$homeCtaHighlight             = old('home_cta_highlight', $settings['home_cta_highlight'] ?? 'Luxurious Stay?');
$homeCtaDescription           = old('home_cta_description', $settings['home_cta_description'] ?? 'Experience comfort, elegance, and warm hospitality at ' . $hotelName . '.');
$homeCtaBackgroundImage       = old('home_cta_background_image', $settings['home_cta_background_image'] ?? 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp');
$aboutStoryImage              = old('about_story_image', $settings['about_story_image'] ?? 'assets/web/images/new/DSC_6608.webp');
$aboutStorySecondaryImage     = old('about_story_secondary_image', $settings['about_story_secondary_image'] ?? 'assets/web/images/new/DSC_6614.webp');
$aboutTeamImage1              = old('about_team_image_1', $settings['about_team_image_1'] ?? '');
$aboutTeamImage2              = old('about_team_image_2', $settings['about_team_image_2'] ?? '');
$aboutTeamImage3              = old('about_team_image_3', $settings['about_team_image_3'] ?? '');
$aboutCtaBackgroundImage      = old('about_cta_background_image', $settings['about_cta_background_image'] ?? 'assets/web/images/new/PHOTO-2026-08-13-10-26-08.webp');
$legalPrivacyHeroImage        = old('legal_privacy_hero_image', $settings['legal_privacy_hero_image'] ?? '');
$legalTermsHeroImage          = old('legal_terms_hero_image', $settings['legal_terms_hero_image'] ?? '');
$roomDetailAboutEyebrow       = old('room_detail_about_eyebrow', $settings['room_detail_about_eyebrow'] ?? 'About This Room');
$roomDetailHeadingPrefix      = old('room_detail_heading_prefix', $settings['room_detail_heading_prefix'] ?? 'Comfortably designed for');
$roomDetailHeadingHighlight   = old('room_detail_heading_highlight', $settings['room_detail_heading_highlight'] ?? 'restful stays');
$roomDetailGuestSummaryTemplate = old('room_detail_guest_summary_template', $settings['room_detail_guest_summary_template'] ?? 'This room is suitable for up to {guests} guest{plural} and includes the key amenities expected for a smooth hotel experience.');
$roomDetailAmenitiesLabel     = old('room_detail_amenities_label', $settings['room_detail_amenities_label'] ?? 'Room Amenities');
$roomDetailPoliciesLabel      = old('room_detail_policies_label', $settings['room_detail_policies_label'] ?? 'Room Policies');
$roomDetailCancellationText   = old('room_detail_cancellation_text', $settings['room_detail_cancellation_text'] ?? 'Subject to reservation policy');
$roomDetailIdRequiredText     = old('room_detail_id_required_text', $settings['room_detail_id_required_text'] ?? 'Valid photo ID at check-in');
$tridentEventEmail            = old('event_email', $settings['event_email'] ?? $hotelEmail);
$tridentHeroEyebrow           = old('trident_hero_eyebrow', $settings['trident_hero_eyebrow'] ?? $hotelName);
$tridentHeroTitle             = old('trident_hero_title', $settings['trident_hero_title'] ?? 'Trident');
$tridentHeroHighlight         = old('trident_hero_highlight', $settings['trident_hero_highlight'] ?? 'Banquet Hall');
$tridentOverviewEyebrow       = old('trident_overview_eyebrow', $settings['trident_overview_eyebrow'] ?? 'The Venue');
$tridentOverviewTitle         = old('trident_overview_title', $settings['trident_overview_title'] ?? 'Where Every Celebration Becomes a');
$tridentOverviewHighlight     = old('trident_overview_highlight', $settings['trident_overview_highlight'] ?? 'Grand Memory');
$tridentOverviewDescription   = old('trident_overview_description', $settings['trident_overview_description'] ?? 'Trident Banquet Hall at ' . $hotelName . ' is a premium event venue in Kurukshetra, planned for weddings, receptions, conferences, and private celebrations that need scale, polish, and dependable service.');
$tridentOverviewSecondaryDescription = old('trident_overview_secondary_description', $settings['trident_overview_secondary_description'] ?? 'From decor coordination and in-house catering to guest flow and event-day support, our team helps you host a smooth and memorable occasion from start to finish.');
$tridentGuestCapacity         = old('trident_guest_capacity', $settings['trident_guest_capacity'] ?? '500+');
$tridentVenueArea             = old('trident_venue_area', $settings['trident_venue_area'] ?? '5000');
$tridentContactEyebrow        = old('trident_contact_eyebrow', $settings['trident_contact_eyebrow'] ?? 'Get In Touch');
$tridentContactTitle          = old('trident_contact_title', $settings['trident_contact_title'] ?? 'Enquire About');
$tridentContactHighlight      = old('trident_contact_highlight', $settings['trident_contact_highlight'] ?? 'Your Event');
$tridentContactDescription    = old('trident_contact_description', $settings['trident_contact_description'] ?? 'Share your event plan and our team will get back to you with availability and package guidance.');
$tridentCtaEyebrow            = old('trident_cta_eyebrow', $settings['trident_cta_eyebrow'] ?? 'Plan Your Event');
$tridentCtaTitle              = old('trident_cta_title', $settings['trident_cta_title'] ?? 'Ready to Plan Your');
$tridentCtaHighlight          = old('trident_cta_highlight', $settings['trident_cta_highlight'] ?? 'Dream Event?');
$tridentCtaDescription        = old('trident_cta_description', $settings['trident_cta_description'] ?? 'Our events team is available to help you plan the right setup, guest experience, and package for your occasion.');
$tridentGuestRanges           = old('trident_guest_ranges', $settings['trident_guest_ranges'] ?? "Up to 50\n50 - 150\n150 - 300\n300 - 500\n500+");
$tridentHeroImage             = old('trident_hero_image', $settings['trident_hero_image'] ?? 'assets/web/images/new/DSC_6616.webp');
$tridentSecondaryImage        = old('trident_secondary_image', $settings['trident_secondary_image'] ?? 'assets/web/images/new/DSC_6618.webp');
$tridentFeaturesImage         = old('trident_features_image', $settings['trident_features_image'] ?? 'assets/web/images/new/DSC_6617.webp');
$tridentGalleryImages         = old('trident_gallery_images', $settings['trident_gallery_images'] ?? "assets/web/images/new/DSC_6616.webp\nassets/web/images/new/DSC_6617.webp\nassets/web/images/new/DSC_6618.webp\nassets/web/images/new/DSC_6619.webp\nassets/web/images/new/PHOTO-2026-08-13-10-26-08.webp");
$mediaFiles                   = $mediaFiles ?? [];
$homeImageFields = [
    ['label' => 'Hero Main Image', 'name' => 'home_hero_image', 'value' => $homeHeroImage],
    ['label' => 'Hero Secondary Image', 'name' => 'home_hero_secondary_image', 'value' => $homeHeroSecondaryImage],
    ['label' => 'Stats Background Image', 'name' => 'home_stats_background_image', 'value' => $homeStatsBackgroundImage],
    ['label' => 'About Main Image', 'name' => 'home_about_image', 'value' => $homeAboutImage],
    ['label' => 'About Secondary Image', 'name' => 'home_about_secondary_image', 'value' => $homeAboutSecondaryImage],
    ['label' => 'Offer Image', 'name' => 'home_offer_image', 'value' => $homeOfferImage],
    ['label' => 'CTA Background Image', 'name' => 'home_cta_background_image', 'value' => $homeCtaBackgroundImage],
];
$aboutImageFields = [
    ['label' => 'Story Main Image', 'name' => 'about_story_image', 'value' => $aboutStoryImage],
    ['label' => 'Story Secondary Image', 'name' => 'about_story_secondary_image', 'value' => $aboutStorySecondaryImage],
    ['label' => 'Team Image 1', 'name' => 'about_team_image_1', 'value' => $aboutTeamImage1],
    ['label' => 'Team Image 2', 'name' => 'about_team_image_2', 'value' => $aboutTeamImage2],
    ['label' => 'Team Image 3', 'name' => 'about_team_image_3', 'value' => $aboutTeamImage3],
    ['label' => 'CTA Background Image', 'name' => 'about_cta_background_image', 'value' => $aboutCtaBackgroundImage],
];
$legalImageFields = [
    ['label' => 'Privacy Hero Image', 'name' => 'legal_privacy_hero_image', 'value' => $legalPrivacyHeroImage],
    ['label' => 'Terms Hero Image', 'name' => 'legal_terms_hero_image', 'value' => $legalTermsHeroImage],
];
?>

<div class="space-y-6">
  <div>
    <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">Settings</p>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Application Settings</h1>
    <p class="mt-1 max-w-2xl text-sm text-slate-500 dark:text-slate-400">
      Manage hotel details, reservations, billing, payment gateway, and system configuration in one place.
    </p>
  </div>

  <div class="grid gap-6 xl:grid-cols-[290px_minmax(0,1fr)]">
    <aside class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="mb-5 rounded-2xl bg-slate-50 p-4 dark:bg-slate-800/70">
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Admin Setup</p>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Choose a settings area to edit.</p>
      </div>

      <nav class="space-y-2">
        <button type="button" data-settings-nav="hotel" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l8-4 6 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/>
          </svg>
          Hotel Details
        </button>
        <button type="button" data-settings-nav="branding" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.8 5.68 6.27.91-4.54 4.43 1.07 6.24L12 17.77l-5.6 2.49 1.07-6.24L2.93 9.59l6.27-.91L12 3z"/>
          </svg>
          Branding
        </button>
        <button type="button" data-settings-nav="offers" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.761 0-5 1.567-5 3.5S9.239 15 12 15s5 1.567 5 3.5S14.761 22 12 22s-5-1.567-5-3.5M12 2v20"/>
          </svg>
          Offers
        </button>
        <button type="button" data-settings-nav="smtp" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-16 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
          </svg>
          SMTP Details
        </button>
        <button type="button" data-settings-nav="booking" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          Reservations
        </button>
        <button type="button" data-settings-nav="billing" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m-6-4h6m-7 8h8a2 2 0 002-2V7.5L14.5 4H8a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          Billing
        </button>
        <button type="button" data-settings-nav="paymentgateway" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 11h14M6 17h3m2 0h2m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"/>
          </svg>
          Payment Gateway
        </button>
        <button type="button" data-settings-nav="system" class="settings-nav-item flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-medium transition-all">
          <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          System
        </button>
      </nav>
    </aside>

    <div class="min-w-0">
      <form id="settings-panel-hotel" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="hotel" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l8-4 6 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Hotel Details</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Core business information used across the app.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <label for="hotel_name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hotel Name</label>
            <input id="hotel_name" name="hotel_name" type="text" value="<?= esc($hotelName) ?>" placeholder="Hotel H Plus"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="hotel_tagline" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Tagline</label>
            <input id="hotel_tagline" name="hotel_tagline" type="text" value="<?= esc($hotelTagline) ?>" placeholder="Comfortable stays and thoughtful hospitality."
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="hotel_phone" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
            <input id="hotel_phone" name="hotel_phone" type="text" value="<?= esc($hotelPhone) ?>" placeholder="+91 92530 72122"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="hotel_whatsapp" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">WhatsApp</label>
            <input id="hotel_whatsapp" name="hotel_whatsapp" type="text" value="<?= esc($hotelWhatsapp) ?>" placeholder="+91 92530 72122"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="hotel_email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
            <input id="hotel_email" name="hotel_email" type="email" value="<?= esc($hotelEmail) ?>" placeholder="info@hotelhplus.in"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="hotel_address" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Address</label>
            <textarea id="hotel_address" name="hotel_address" rows="4" placeholder="Opposite Sector-7, Pipli Road, Kurukshetra"
                      class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($hotelAddress) ?></textarea>
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Hotel Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-branding" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="branding" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.8 5.68 6.27.91-4.54 4.43 1.07 6.24L12 17.77l-5.6 2.49 1.07-6.24L2.93 9.59l6.27-.91L12 3z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Branding</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Logo links, footer copy, social profiles, and brand identity details.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="brand_logo" class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-300">Logo</label>
            <input id="brand_logo" name="brand_logo" type="hidden" value="<?= esc($brandLogo) ?>" data-media-value="brand_logo" />
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
              <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 text-center text-xs font-medium text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <img src="<?= $brandLogo !== '' ? esc(media_url($brandLogo)) : '' ?>" alt="Logo preview" data-media-preview="brand_logo" class="<?= $brandLogo === '' ? 'hidden' : '' ?> h-full w-full object-contain p-2" />
                <span data-media-empty="brand_logo" class="<?= $brandLogo !== '' ? 'hidden' : '' ?> px-3">No logo</span>
              </div>
              <div>
                <div class="mt-3 flex flex-wrap gap-2 sm:mt-0">
                  <button type="button" data-open-media-picker="brand_logo" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">
                    Choose from Media
                  </button>
                  <button type="button" data-clear-media="brand_logo" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Clear
                  </button>
                </div>
                <p class="mt-2 text-xs text-slate-400">Choose a logo image from the media library.</p>
              </div>
            </div>
          </div>
          <div>
            <label for="brand_favicon" class="mb-3 block text-sm font-medium text-slate-700 dark:text-slate-300">Favicon</label>
            <input id="brand_favicon" name="brand_favicon" type="hidden" value="<?= esc($brandFavicon) ?>" data-media-value="brand_favicon" />
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
              <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 text-center text-xs font-medium text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <img src="<?= $brandFavicon !== '' ? esc(media_url($brandFavicon)) : '' ?>" alt="Favicon preview" data-media-preview="brand_favicon" class="<?= $brandFavicon === '' ? 'hidden' : '' ?> h-full w-full object-contain p-3" />
                <span data-media-empty="brand_favicon" class="<?= $brandFavicon !== '' ? 'hidden' : '' ?> px-3">No favicon</span>
              </div>
              <div>
                <div class="mt-3 flex flex-wrap gap-2 sm:mt-0">
                  <button type="button" data-open-media-picker="brand_favicon" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">
                    Choose from Media
                  </button>
                  <button type="button" data-clear-media="brand_favicon" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Clear
                  </button>
                </div>
                <p class="mt-2 text-xs text-slate-400">Choose a favicon image from the media library.</p>
              </div>
            </div>
          </div>
          <div>
            <label for="brand_header_subtitle" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Header Subtitle</label>
            <input id="brand_header_subtitle" name="brand_header_subtitle" type="text" value="<?= esc($brandHeaderSubtitle) ?>" placeholder="Kurukshetra"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="brand_footer_text" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Footer Text</label>
            <input id="brand_footer_text" name="brand_footer_text" type="text" value="<?= esc($brandFooterText) ?>" placeholder="Hotel H Plus. All rights reserved."
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="brand_facebook" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Facebook URL</label>
            <input id="brand_facebook" name="brand_facebook" type="text" value="<?= esc($brandFacebook) ?>" placeholder="https://facebook.com/yourpage"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="brand_instagram" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Instagram URL</label>
            <input id="brand_instagram" name="brand_instagram" type="text" value="<?= esc($brandInstagram) ?>" placeholder="https://instagram.com/yourprofile"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="brand_x" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">X / Twitter URL</label>
            <input id="brand_x" name="brand_x" type="text" value="<?= esc($brandX) ?>" placeholder="https://x.com/yourprofile"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Branding Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-seo" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="seo" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-2v4m-7 4h14M5 19h14M7 9h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">SEO Manager</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Set site-wide SEO defaults and page-wise meta titles and descriptions.</p>
          </div>
        </div>

        <div class="grid gap-8">
          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Global Defaults</h3>
            </div>
            <div class="sm:col-span-2">
              <label for="seo_meta_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Default SEO Title</label>
              <input id="seo_meta_title" name="seo_meta_title" type="text" value="<?= esc($seoMetaTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div class="sm:col-span-2">
              <label for="seo_meta_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Default SEO Description</label>
              <textarea id="seo_meta_description" name="seo_meta_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoMetaDescription) ?></textarea>
            </div>
            <div class="sm:col-span-2">
              <label for="seo_meta_keywords" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Meta Keywords</label>
              <input id="seo_meta_keywords" name="seo_meta_keywords" type="text" value="<?= esc($seoMetaKeywords) ?>" placeholder="hotel, kurukshetra, banquet, rooms" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="seo_robots" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Robots</label>
              <input id="seo_robots" name="seo_robots" type="text" value="<?= esc($seoRobots) ?>" placeholder="index, follow" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="seo_twitter_card" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Twitter Card</label>
              <select id="seo_twitter_card" name="seo_twitter_card" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                <option value="summary_large_image" <?= $seoTwitterCard === 'summary_large_image' ? 'selected' : '' ?>>summary_large_image</option>
                <option value="summary" <?= $seoTwitterCard === 'summary' ? 'selected' : '' ?>>summary</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label for="seo_og_image" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Default OG Image Path / URL</label>
              <input id="seo_og_image" name="seo_og_image" type="text" value="<?= esc($seoOgImage) ?>" placeholder="uploads/seo/default-og.jpg" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Page SEO</h3>
            </div>
            <div><label for="seo_home_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Home Title</label><input id="seo_home_title" name="seo_home_title" type="text" value="<?= esc($seoHomeTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_home_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Home Description</label><textarea id="seo_home_description" name="seo_home_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoHomeDescription) ?></textarea></div>
            <div><label for="seo_about_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Title</label><input id="seo_about_title" name="seo_about_title" type="text" value="<?= esc($seoAboutTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_about_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Description</label><textarea id="seo_about_description" name="seo_about_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoAboutDescription) ?></textarea></div>
            <div><label for="seo_rooms_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Rooms Title</label><input id="seo_rooms_title" name="seo_rooms_title" type="text" value="<?= esc($seoRoomsTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_rooms_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Rooms Description</label><textarea id="seo_rooms_description" name="seo_rooms_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoRoomsDescription) ?></textarea></div>
            <div><label for="seo_trident_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Trident Title</label><input id="seo_trident_title" name="seo_trident_title" type="text" value="<?= esc($seoTridentTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_trident_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Trident Description</label><textarea id="seo_trident_description" name="seo_trident_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoTridentDescription) ?></textarea></div>
            <div><label for="seo_gallery_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gallery Title</label><input id="seo_gallery_title" name="seo_gallery_title" type="text" value="<?= esc($seoGalleryTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_gallery_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gallery Description</label><textarea id="seo_gallery_description" name="seo_gallery_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoGalleryDescription) ?></textarea></div>
            <div><label for="seo_contact_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Title</label><input id="seo_contact_title" name="seo_contact_title" type="text" value="<?= esc($seoContactTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_contact_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Description</label><textarea id="seo_contact_description" name="seo_contact_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoContactDescription) ?></textarea></div>
            <div><label for="seo_faq_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">FAQ Title</label><input id="seo_faq_title" name="seo_faq_title" type="text" value="<?= esc($seoFaqTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_faq_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">FAQ Description</label><textarea id="seo_faq_description" name="seo_faq_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoFaqDescription) ?></textarea></div>
            <div><label for="seo_privacy_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Privacy Title</label><input id="seo_privacy_title" name="seo_privacy_title" type="text" value="<?= esc($seoPrivacyTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_privacy_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Privacy Description</label><textarea id="seo_privacy_description" name="seo_privacy_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoPrivacyDescription) ?></textarea></div>
            <div><label for="seo_terms_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Terms Title</label><input id="seo_terms_title" name="seo_terms_title" type="text" value="<?= esc($seoTermsTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_terms_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Terms Description</label><textarea id="seo_terms_description" name="seo_terms_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoTermsDescription) ?></textarea></div>
            <div><label for="seo_thank_you_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Thank You Title</label><input id="seo_thank_you_title" name="seo_thank_you_title" type="text" value="<?= esc($seoThankYouTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="seo_thank_you_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Thank You Description</label><textarea id="seo_thank_you_description" name="seo_thank_you_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($seoThankYouDescription) ?></textarea></div>
          </section>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save SEO Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-smtp" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="smtp" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-16 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">SMTP Details</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Outgoing mail credentials and sender identity.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="smtp_host" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">SMTP Host</label>
            <input id="smtp_host" name="smtp_host" type="text" value="<?= esc($smtpHost) ?>" placeholder="smtp.gmail.com"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="smtp_port" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">SMTP Port</label>
            <input id="smtp_port" name="smtp_port" type="text" value="<?= esc($smtpPort) ?>" placeholder="587"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="smtp_user" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">SMTP Username</label>
            <input id="smtp_user" name="smtp_user" type="text" value="<?= esc($smtpUser) ?>" placeholder="mailer@hotelhplus.in"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="smtp_pass" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">SMTP Password</label>
            <input id="smtp_pass" name="smtp_pass" type="password" value="<?= esc($smtpPass) ?>" placeholder="App password or SMTP password"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="smtp_crypto" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Encryption</label>
            <select id="smtp_crypto" name="smtp_crypto"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="tls" <?= $smtpCrypto === 'tls' ? 'selected' : '' ?>>TLS</option>
              <option value="ssl" <?= $smtpCrypto === 'ssl' ? 'selected' : '' ?>>SSL</option>
              <option value="" <?= $smtpCrypto === '' ? 'selected' : '' ?>>None</option>
            </select>
          </div>
          <div>
            <label for="smtp_from_email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">From Email</label>
            <input id="smtp_from_email" name="smtp_from_email" type="email" value="<?= esc($smtpFromEmail) ?>" placeholder="noreply@hotelhplus.in"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="smtp_from_name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">From Name</label>
            <input id="smtp_from_name" name="smtp_from_name" type="text" value="<?= esc($smtpFromName) ?>" placeholder="Hotel H Plus"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save SMTP Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-homepage" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="homepage" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h4m10-11v10a1 1 0 01-1 1h-4m-4 0h4m-4 0v-6a1 1 0 011-1h2a1 1 0 011 1v6m-4 0H9"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Homepage Content</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage homepage copy, the offer badge text, and supporting content while room prices and teaser cards stay synced from the rooms table.</p>
          </div>
        </div>

        <div class="grid gap-8">
          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Hero Section</h3>
            </div>
            <div>
              <label for="home_hero_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Eyebrow</label>
              <input id="home_hero_eyebrow" name="home_hero_eyebrow" type="text" value="<?= esc($homeHeroEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="home_hero_title_prefix" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Title Prefix</label>
              <input id="home_hero_title_prefix" name="home_hero_title_prefix" type="text" value="<?= esc($homeHeroTitlePrefix) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div class="sm:col-span-2">
              <label for="home_hero_title_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Highlight Title</label>
              <input id="home_hero_title_highlight" name="home_hero_title_highlight" type="text" value="<?= esc($homeHeroTitleHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div class="sm:col-span-2">
              <label for="home_hero_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Description</label>
              <textarea id="home_hero_description" name="home_hero_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeHeroDescription) ?></textarea>
            </div>
            <div>
              <label for="home_hero_guest_count" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Guest Count Label</label>
              <input id="home_hero_guest_count" name="home_hero_guest_count" type="text" value="<?= esc($homeHeroGuestCount) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="home_hero_review_text" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Review Label</label>
              <input id="home_hero_review_text" name="home_hero_review_text" type="text" value="<?= esc($homeHeroReviewText) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Stats and About</h3>
            </div>
            <div><label for="home_stats_rooms" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Stats Rooms</label><input id="home_stats_rooms" name="home_stats_rooms" type="text" value="<?= esc($homeStatsRooms) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_stats_staff" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Stats Staff</label><input id="home_stats_staff" name="home_stats_staff" type="text" value="<?= esc($homeStatsStaff) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_stats_happy_clients" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Stats Happy Clients</label><input id="home_stats_happy_clients" name="home_stats_happy_clients" type="text" value="<?= esc($homeStatsHappyClients) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_stats_reviews" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Stats Reviews</label><input id="home_stats_reviews" name="home_stats_reviews" type="text" value="<?= esc($homeStatsReviews) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_about_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Eyebrow</label><input id="home_about_eyebrow" name="home_about_eyebrow" type="text" value="<?= esc($homeAboutEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_about_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Highlight</label><input id="home_about_highlight" name="home_about_highlight" type="text" value="<?= esc($homeAboutHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_about_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Title</label><input id="home_about_title" name="home_about_title" type="text" value="<?= esc($homeAboutTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_about_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Description</label><textarea id="home_about_description" name="home_about_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeAboutDescription) ?></textarea></div>
            <div class="sm:col-span-2"><label for="home_about_mission" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Mission</label><textarea id="home_about_mission" name="home_about_mission" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeAboutMission) ?></textarea></div>
            <div class="sm:col-span-2"><label for="home_about_vision" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Vision</label><textarea id="home_about_vision" name="home_about_vision" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeAboutVision) ?></textarea></div>
            <div class="sm:col-span-2"><label for="home_about_values" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Values</label><textarea id="home_about_values" name="home_about_values" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeAboutValues) ?></textarea></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Rooms, Offer and CTA</h3>
            </div>
            <div><label for="home_rooms_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Rooms Eyebrow</label><input id="home_rooms_eyebrow" name="home_rooms_eyebrow" type="text" value="<?= esc($homeRoomsEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_rooms_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Rooms Highlight</label><input id="home_rooms_highlight" name="home_rooms_highlight" type="text" value="<?= esc($homeRoomsHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_rooms_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Rooms Title</label><input id="home_rooms_title" name="home_rooms_title" type="text" value="<?= esc($homeRoomsTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_rooms_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Rooms Description</label><textarea id="home_rooms_description" name="home_rooms_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeRoomsDescription) ?></textarea></div>
            <div><label for="home_offer_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Eyebrow</label><input id="home_offer_eyebrow" name="home_offer_eyebrow" type="text" value="<?= esc($homeOfferEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_offer_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Highlight</label><input id="home_offer_highlight" name="home_offer_highlight" type="text" value="<?= esc($homeOfferHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_offer_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Title</label><input id="home_offer_title" name="home_offer_title" type="text" value="<?= esc($homeOfferTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_offer_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Description</label><textarea id="home_offer_description" name="home_offer_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeOfferDescription) ?></textarea></div>
            <div class="sm:col-span-2"><label for="home_offer_secondary_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Secondary Description</label><textarea id="home_offer_secondary_description" name="home_offer_secondary_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeOfferSecondaryDescription) ?></textarea></div>
            <div><label for="home_cta_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Eyebrow</label><input id="home_cta_eyebrow" name="home_cta_eyebrow" type="text" value="<?= esc($homeCtaEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="home_cta_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Highlight</label><input id="home_cta_highlight" name="home_cta_highlight" type="text" value="<?= esc($homeCtaHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_cta_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Title</label><input id="home_cta_title" name="home_cta_title" type="text" value="<?= esc($homeCtaTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="home_cta_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Description</label><textarea id="home_cta_description" name="home_cta_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($homeCtaDescription) ?></textarea></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Homepage Images</h3>
            </div>
            <?php foreach ($homeImageFields as $field): ?>
              <div>
                <label for="<?= esc($field['name']) ?>" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"><?= esc($field['label']) ?></label>
                <div class="space-y-3">
                  <input id="<?= esc($field['name']) ?>" name="<?= esc($field['name']) ?>" type="text" value="<?= esc($field['value']) ?>" data-media-value="<?= esc($field['name']) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                  <div class="flex flex-wrap items-center gap-3">
                    <img src="<?= esc(media_url((string) $field['value'])) ?>" alt="<?= esc($field['label']) ?> preview" data-media-preview="<?= esc($field['name']) ?>" class="<?= $field['value'] === '' ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-cover dark:border-slate-700 dark:bg-slate-800" />
                    <span data-media-empty="<?= esc($field['name']) ?>" class="<?= $field['value'] !== '' ? 'hidden ' : '' ?>text-xs text-slate-400">No image selected</span>
                    <button type="button" data-open-media-picker="<?= esc($field['name']) ?>" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
                    <button type="button" data-clear-media="<?= esc($field['name']) ?>" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </section>

          <section class="rounded-3xl border border-slate-200/80 bg-slate-50/40 p-5 dark:border-slate-700 dark:bg-slate-800/30">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Homepage Gallery Preview</h3>
                <p class="mt-1 text-xs text-slate-400">Homepage gallery images are now pulled automatically from the Gallery Page collection. Manage them once in Gallery Page and the homepage preview updates from the same source.</p>
              </div>
              <a href="<?= base_url('admin/pages/gallerypage') ?>" class="inline-flex items-center rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
                Manage Gallery
              </a>
            </div>
          </section>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Homepage Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-offers" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="offers" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.761 0-5 1.567-5 3.5S9.239 15 12 15s5 1.567 5 3.5S14.761 22 12 22s-5-1.567-5-3.5M12 2v20"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Offers & Discounts</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Control the homepage offer visibility, discount percentage, and how the offer should be applied.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="home_offer_enabled" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Status</label>
            <select id="home_offer_enabled" name="home_offer_enabled"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="1" <?= $homeOfferEnabled === '1' ? 'selected' : '' ?>>On</option>
              <option value="0" <?= $homeOfferEnabled === '0' ? 'selected' : '' ?>>Off</option>
            </select>
            <p class="mt-2 text-xs text-slate-400">When off, the homepage offer section is hidden.</p>
          </div>

          <div>
            <label for="home_offer_discount_text" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Percentage</label>
            <input id="home_offer_discount_text" name="home_offer_discount_text" type="text" value="<?= esc($homeOfferDiscountText) ?>" placeholder="30%"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <p class="mt-2 text-xs text-slate-400">Shown in the gold badge on the homepage offer card.</p>
          </div>

          <div class="sm:col-span-2">
            <label for="home_offer_type" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Offer Type</label>
            <select id="home_offer_type" name="home_offer_type"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="online" <?= $homeOfferType === 'online' ? 'selected' : '' ?>>Online</option>
              <option value="offline" <?= $homeOfferType === 'offline' ? 'selected' : '' ?>>Offline</option>
              <option value="both" <?= $homeOfferType === 'both' ? 'selected' : '' ?>>Both</option>
            </select>
            <p class="mt-2 text-xs text-slate-400">This label is shown below the offer CTA on the homepage.</p>
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Offer Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-booking" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="booking" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Reservations</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Room reservation notifications, stay timings, guest lookup, and auto replies.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="booking_admin_email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Admin Notification Email</label>
            <input id="booking_admin_email" name="booking_admin_email" type="email" value="<?= esc($bookingAdminEmail) ?>" placeholder="bookings@hotelhplus.in"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="booking_whatsapp_number" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">WhatsApp Number</label>
            <input id="booking_whatsapp_number" name="booking_whatsapp_number" type="text" value="<?= esc($bookingWhatsappNumber) ?>" placeholder="+91 92530 72122"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="booking_subject_prefix" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email Subject Prefix</label>
            <input id="booking_subject_prefix" name="booking_subject_prefix" type="text" value="<?= esc($bookingSubjectPrefix) ?>" placeholder="[Hotel H Plus]"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="booking_checkin_time" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Check-in Time</label>
            <input id="booking_checkin_time" name="booking_checkin_time" type="text" value="<?= esc($bookingCheckinTime) ?>" placeholder="13:00"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="booking_checkout_time" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Check-out Time</label>
            <input id="booking_checkout_time" name="booking_checkout_time" type="text" value="<?= esc($bookingCheckoutTime) ?>" placeholder="11:00"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="booking_auto_reply_enabled" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Auto Reply</label>
            <select id="booking_auto_reply_enabled" name="booking_auto_reply_enabled"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="1" <?= $bookingAutoReply === '1' ? 'selected' : '' ?>>Enabled</option>
              <option value="0" <?= $bookingAutoReply === '0' ? 'selected' : '' ?>>Disabled</option>
            </select>
          </div>
          <div>
            <label for="guest_lookup_enabled" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Guest Booking Lookup</label>
            <select id="guest_lookup_enabled" name="guest_lookup_enabled"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="1" <?= $guestLookupEnabled === '1' ? 'selected' : '' ?>>Enabled</option>
              <option value="0" <?= $guestLookupEnabled === '0' ? 'selected' : '' ?>>Disabled</option>
            </select>
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Reservation Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-billing" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="billing" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m-6-4h6m-7 8h8a2 2 0 002-2V7.5L14.5 4H8a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Billing</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Invoice prefix, GST toggle, GSTIN, and receipt tax display.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="receipt_invoice_prefix" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Invoice Prefix</label>
            <input id="receipt_invoice_prefix" name="receipt_invoice_prefix" type="text" value="<?= esc($receiptInvoicePrefix) ?>" placeholder="HHP"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="receipt_gst_enabled" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">GST Invoice</label>
            <select id="receipt_gst_enabled" name="receipt_gst_enabled"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="0" <?= $receiptGstEnabled === '0' ? 'selected' : '' ?>>Disabled</option>
              <option value="1" <?= $receiptGstEnabled === '1' ? 'selected' : '' ?>>Enabled</option>
            </select>
          </div>
          <div>
            <label for="receipt_gst_rate" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">GST Rate (%)</label>
            <input id="receipt_gst_rate" name="receipt_gst_rate" type="number" min="0" max="28" step="0.01" value="<?= esc($receiptGstRate) ?>" placeholder="12"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="receipt_tax_label" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">GST Label</label>
            <input id="receipt_tax_label" name="receipt_tax_label" type="text" value="<?= esc($receiptTaxLabel) ?>" placeholder="GSTIN"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="receipt_tax_number" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">GSTIN</label>
            <input id="receipt_tax_number" name="receipt_tax_number" type="text" value="<?= esc($receiptTaxNumber) ?>" placeholder="Hotel GST registration number"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Billing Settings
          </button>
        </div>
      </form>

      <?php if ($systemDeveloperMode === '1'): ?>
        <form id="settings-panel-emailtemplates" action="<?= base_url('admin/settings/update') ?>" method="POST"
              class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
          <?= csrf_field() ?>
          <input type="hidden" name="settings_tab" value="emailtemplates" />

          <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"/>
              </svg>
            </div>
            <div>
              <h2 class="text-lg font-bold text-slate-900 dark:text-white">Email Templates</h2>
              <p class="text-sm text-slate-500 dark:text-slate-400">Developer-mode reply templates for booking and event guest emails.</p>
            </div>
          </div>

          <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs leading-6 text-amber-900 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-100">
            Available placeholders: <span class="font-semibold">{hotel_name}</span>, <span class="font-semibold">{guest_name}</span>, <span class="font-semibold">{hotel_contact}</span>, <span class="font-semibold">{room_name}</span>, <span class="font-semibold">{checkin}</span>, <span class="font-semibold">{checkout}</span>, <span class="font-semibold">{rooms_required}</span>, <span class="font-semibold">{guests}</span>, <span class="font-semibold">{event_type}</span>, <span class="font-semibold">{event_date}</span>, <span class="font-semibold">{amount}</span>, <span class="font-semibold">{payment_code}</span>, <span class="font-semibold">{payment_link}</span>.
          </div>

          <div class="space-y-6">
            <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Booking Auto Reply</h3>
              <div class="mt-4 grid gap-5">
                <div>
                  <label for="email_template_booking_auto_reply_subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
                  <input id="email_template_booking_auto_reply_subject" name="email_template_booking_auto_reply_subject" type="text" value="<?= esc($emailBookingAutoReplySubject) ?>"
                         class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                <div>
                  <label for="email_template_booking_auto_reply_body" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Body</label>
                  <textarea id="email_template_booking_auto_reply_body" name="email_template_booking_auto_reply_body" rows="8"
                            class="w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($emailBookingAutoReplyBody) ?></textarea>
                </div>
              </div>
            </section>

            <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Event Auto Reply</h3>
              <div class="mt-4 grid gap-5">
                <div>
                  <label for="email_template_event_auto_reply_subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
                  <input id="email_template_event_auto_reply_subject" name="email_template_event_auto_reply_subject" type="text" value="<?= esc($emailEventAutoReplySubject) ?>"
                         class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                <div>
                  <label for="email_template_event_auto_reply_body" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Body</label>
                  <textarea id="email_template_event_auto_reply_body" name="email_template_event_auto_reply_body" rows="8"
                            class="w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($emailEventAutoReplyBody) ?></textarea>
                </div>
              </div>
            </section>

            <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
              <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Event Payment Link Email</h3>
              <div class="mt-4 grid gap-5">
                <div>
                  <label for="email_template_event_payment_link_subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
                  <input id="email_template_event_payment_link_subject" name="email_template_event_payment_link_subject" type="text" value="<?= esc($emailEventPaymentLinkSubject) ?>"
                         class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                <div>
                  <label for="email_template_event_payment_link_body" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Body</label>
                  <textarea id="email_template_event_payment_link_body" name="email_template_event_payment_link_body" rows="9"
                            class="w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($emailEventPaymentLinkBody) ?></textarea>
                </div>
              </div>
            </section>
          </div>

          <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
            <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
              Save Email Templates
            </button>
          </div>
        </form>

        <form id="settings-panel-receiptstyles" action="<?= base_url('admin/settings/update') ?>" method="POST"
              class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
          <?= csrf_field() ?>
          <input type="hidden" name="settings_tab" value="receiptstyles" />

          <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14h6m-6-4h6m-7 8h8a2 2 0 002-2V7.5L14.5 4H8a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <div>
              <h2 class="text-lg font-bold text-slate-900 dark:text-white">Receipt Styles</h2>
              <p class="text-sm text-slate-500 dark:text-slate-400">Choose the PDF receipt look used for booking and event payment receipts.</p>
            </div>
          </div>

          <div class="grid gap-4 lg:grid-cols-3">
            <?php
              $receiptStyleOptions = [
                  ['key' => 'classic', 'name' => 'Classic', 'description' => 'Current gold-and-ivory hotel receipt.', 'classes' => 'bg-[#f8f6f1] border-[#e5dbc7] text-slate-900', 'bar' => 'bg-slate-950 text-[#c49d3a]'],
                  ['key' => 'signature', 'name' => 'Signature', 'description' => 'Warmer premium look with a deeper amount band.', 'classes' => 'bg-[#f4f1ea] border-[#ceb888] text-slate-900', 'bar' => 'bg-[#2d2216] text-[#e0b044]'],
                  ['key' => 'minimal', 'name' => 'Minimal', 'description' => 'Clean invoice-style layout with restrained contrast.', 'classes' => 'bg-white border-slate-300 text-slate-900', 'bar' => 'bg-slate-100 text-slate-950'],
              ];
            ?>
            <?php foreach ($receiptStyleOptions as $option): ?>
              <label class="group cursor-pointer rounded-3xl border p-4 transition hover:-translate-y-0.5 hover:shadow-lg <?= $receiptPdfStyle === $option['key'] ? 'border-[#C99A30] ring-4 ring-[#C99A30]/15 dark:border-[#C99A30]' : 'border-slate-200 dark:border-slate-700' ?>">
                <input type="radio" name="receipt_pdf_style" value="<?= esc($option['key']) ?>" <?= $receiptPdfStyle === $option['key'] ? 'checked' : '' ?> class="sr-only" />
                <div class="rounded-2xl border px-4 py-5 <?= esc($option['classes']) ?>">
                  <div class="text-center">
                    <p class="text-lg font-bold"><?= esc($hotelName) ?></p>
                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.18em] opacity-70">Payment Receipt</p>
                  </div>
                  <div class="my-5 h-px border-t border-dashed opacity-40"></div>
                  <div class="rounded-xl px-3 py-4 text-center <?= esc($option['bar']) ?>">
                    <p class="text-[10px] font-bold uppercase opacity-70">Amount Paid</p>
                    <p class="mt-1 text-xl font-black">INR 2,200.00</p>
                  </div>
                  <div class="mt-5 space-y-2 text-xs">
                    <div class="flex justify-between"><span class="opacity-60">Guest</span><strong>Guest Name</strong></div>
                    <div class="flex justify-between"><span class="opacity-60">Status</span><strong>Paid</strong></div>
                  </div>
                </div>
                <div class="mt-4 flex items-start gap-3">
                  <span class="mt-1 h-4 w-4 rounded-full border <?= $receiptPdfStyle === $option['key'] ? 'border-[#C99A30] bg-[#C99A30]' : 'border-slate-300 dark:border-slate-600' ?>"></span>
                  <span>
                    <span class="block text-sm font-bold text-slate-900 dark:text-white"><?= esc($option['name']) ?></span>
                    <span class="mt-1 block text-xs leading-5 text-slate-500 dark:text-slate-400"><?= esc($option['description']) ?></span>
                  </span>
                </div>
              </label>
            <?php endforeach; ?>
          </div>

          <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
            <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
              Save Receipt Style
            </button>
          </div>
        </form>
      <?php endif; ?>

      <form id="settings-panel-paymentgateway" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="paymentgateway" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 11h14M6 17h3m2 0h2m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Payment Gateway</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Activate gateway-controlled booking when Cashfree or Razorpay is ready for sandbox testing or live production use.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <label for="payment_gateway_enabled" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gateway Status</label>
            <select id="payment_gateway_enabled" name="payment_gateway_enabled"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="0" <?= $paymentGatewayEnabled === '0' ? 'selected' : '' ?>>Inactive</option>
              <option value="1" <?= $paymentGatewayEnabled === '1' ? 'selected' : '' ?>>Active</option>
            </select>
            <p class="mt-2 text-xs text-slate-400">When inactive, website booking works exactly like the current request-based flow.</p>
          </div>

          <div class="sm:col-span-2">
            <label for="payment_gateway_provider" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gateway Name</label>
            <select id="payment_gateway_provider" name="payment_gateway_provider"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <?php foreach ($paymentGatewayOptions as $gatewayKey => $gatewayLabel): ?>
                <option value="<?= esc($gatewayKey) ?>" <?= $paymentGatewayProvider === $gatewayKey ? 'selected' : '' ?>><?= esc($gatewayLabel) ?></option>
              <?php endforeach; ?>
            </select>
            <p class="mt-2 text-xs text-slate-400">Select the gateway guests should use for online room payments.</p>
          </div>

          <div class="sm:col-span-2">
            <label for="booking_enabled" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Website Booking Status</label>
            <select id="booking_enabled" name="booking_enabled"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="1" <?= $bookingEnabled === '1' ? 'selected' : '' ?>>Booking On</option>
              <option value="0" <?= $bookingEnabled === '0' ? 'selected' : '' ?>>Booking Off</option>
            </select>
            <p class="mt-2 text-xs text-slate-400">This switch is only used when gateway mode is active.</p>
          </div>

          <div class="sm:col-span-2 border-t border-slate-100 pt-5 dark:border-slate-800" data-gateway-settings="cashfree">
            <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-slate-400">Cashfree</h3>
          </div>

          <div data-gateway-settings="cashfree">
            <label for="cashfree_app_id" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Cashfree App ID</label>
            <input id="cashfree_app_id" name="cashfree_app_id" type="text" value="<?= esc($cashfreeAppId) ?>" placeholder="Your Cashfree App ID"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div data-gateway-settings="cashfree">
            <label for="cashfree_environment" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Environment</label>
            <select id="cashfree_environment" name="cashfree_environment"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="sandbox" <?= $cashfreeEnvironment === 'sandbox' ? 'selected' : '' ?>>Sandbox</option>
              <option value="production" <?= $cashfreeEnvironment === 'production' ? 'selected' : '' ?>>Production</option>
            </select>
          </div>
          <div class="sm:col-span-2" data-gateway-settings="cashfree">
            <label for="cashfree_secret_key" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Cashfree Secret Key</label>
            <input id="cashfree_secret_key" name="cashfree_secret_key" type="password" value="<?= $cashfreeSecretKey !== '' ? '__KEEP_SECRET__' : '' ?>" placeholder="<?= $cashfreeSecretKey !== '' ? 'Saved - enter a new value to replace' : 'Your Cashfree Secret Key' ?>" autocomplete="new-password"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <?php if ($cashfreeSecretKey !== ''): ?>
              <p class="mt-2 text-xs text-slate-400">Secret is saved encrypted and hidden. Enter a new value only if you want to replace it.</p>
            <?php endif; ?>
          </div>
          <div class="sm:col-span-2" data-gateway-settings="cashfree">
            <label for="cashfree_webhook_secret" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Cashfree Webhook Secret</label>
            <input id="cashfree_webhook_secret" name="cashfree_webhook_secret" type="password" value="<?= $cashfreeWebhookSecret !== '' ? '__KEEP_SECRET__' : '' ?>" placeholder="<?= $cashfreeWebhookSecret !== '' ? 'Saved - enter a new value to replace' : 'Your Cashfree Webhook Secret' ?>" autocomplete="new-password"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <?php if ($cashfreeWebhookSecret !== ''): ?>
              <p class="mt-2 text-xs text-slate-400">Webhook secret is saved encrypted and hidden. Enter a new value only if you want to replace it.</p>
            <?php endif; ?>
          </div>
          <div class="sm:col-span-2" data-gateway-settings="cashfree">
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Cashfree Webhook URL</label>
            <input type="text" value="<?= esc($cashfreeWebhookUrl) ?>" readonly
                   class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-600 outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300" />
            <p class="mt-2 text-xs text-slate-400">Add this URL in your Cashfree dashboard so paid bookings update even if the guest never returns to the site.</p>
          </div>

          <div class="sm:col-span-2 border-t border-slate-100 pt-5 dark:border-slate-800" data-gateway-settings="razorpay">
            <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-slate-400">Razorpay</h3>
          </div>

          <div data-gateway-settings="razorpay">
            <label for="razorpay_key_id" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Razorpay Key ID</label>
            <input id="razorpay_key_id" name="razorpay_key_id" type="text" value="<?= esc($razorpayKeyId) ?>" placeholder="<?= esc($razorpayKeyPlaceholder) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div data-gateway-settings="razorpay">
            <label for="razorpay_environment" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Environment</label>
            <select id="razorpay_environment" name="razorpay_environment"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="sandbox" <?= $razorpayEnvironment === 'sandbox' ? 'selected' : '' ?>>Sandbox</option>
              <option value="production" <?= $razorpayEnvironment === 'production' ? 'selected' : '' ?>>Production</option>
            </select>
          </div>
          <div class="sm:col-span-2" data-gateway-settings="razorpay">
            <label for="razorpay_key_secret" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Razorpay Key Secret</label>
            <input id="razorpay_key_secret" name="razorpay_key_secret" type="password" value="<?= $razorpayKeySecret !== '' ? '__KEEP_SECRET__' : '' ?>" placeholder="<?= $razorpayKeySecret !== '' ? 'Saved - enter a new value to replace' : 'Your Razorpay Key Secret' ?>" autocomplete="new-password"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <?php if ($razorpayKeySecret !== ''): ?>
              <p class="mt-2 text-xs text-slate-400">Secret is saved encrypted and hidden. Enter a new value only if you want to replace it.</p>
            <?php endif; ?>
          </div>
          <div class="sm:col-span-2" data-gateway-settings="razorpay">
            <label for="razorpay_webhook_secret" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Razorpay Webhook Secret</label>
            <input id="razorpay_webhook_secret" name="razorpay_webhook_secret" type="password" value="<?= $razorpayWebhookSecret !== '' ? '__KEEP_SECRET__' : '' ?>" placeholder="<?= $razorpayWebhookSecret !== '' ? 'Saved - enter a new value to replace' : 'Your Razorpay Webhook Secret' ?>" autocomplete="new-password"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <?php if ($razorpayWebhookSecret !== ''): ?>
              <p class="mt-2 text-xs text-slate-400">Webhook secret is saved encrypted and hidden. Enter a new value only if you want to replace it.</p>
            <?php endif; ?>
          </div>
          <div class="sm:col-span-2" data-gateway-settings="razorpay">
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Razorpay Webhook URL</label>
            <input type="text" value="<?= esc($razorpayWebhookUrl) ?>" readonly
                   class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-600 outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300" />
            <p class="mt-2 text-xs text-slate-400">Add this URL in your Razorpay dashboard and subscribe to payment/order events for status sync.</p>
          </div>
        </div>

        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-900/40 dark:bg-amber-900/10 dark:text-amber-200">
          Gateway-controlled booking becomes available when gateway is active and the selected provider keys plus webhook secret are filled. Use sandbox/test keys for testing and production/live keys for real payments.
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Payment Gateway Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-aboutpage" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="aboutpage" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">About Page Images</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage the key About page visuals through the Media Library.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <?php foreach ($aboutImageFields as $field): ?>
            <div>
              <label for="<?= esc($field['name']) ?>" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"><?= esc($field['label']) ?></label>
              <div class="space-y-3">
                <input id="<?= esc($field['name']) ?>" name="<?= esc($field['name']) ?>" type="text" value="<?= esc($field['value']) ?>" data-media-value="<?= esc($field['name']) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                <div class="flex flex-wrap items-center gap-3">
                  <img src="<?= esc(media_url((string) $field['value'])) ?>" alt="<?= esc($field['label']) ?> preview" data-media-preview="<?= esc($field['name']) ?>" class="<?= $field['value'] === '' ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-cover dark:border-slate-700 dark:bg-slate-800" />
                  <span data-media-empty="<?= esc($field['name']) ?>" class="<?= $field['value'] !== '' ? 'hidden ' : '' ?>text-xs text-slate-400">No image selected</span>
                  <button type="button" data-open-media-picker="<?= esc($field['name']) ?>" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
                  <button type="button" data-clear-media="<?= esc($field['name']) ?>" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save About Page Images
          </button>
        </div>
      </form>

      <form id="settings-panel-legalpage" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="legalpage" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10l1 2h3v2H3V6h3l1-2Zm-1 4h12v10a2 2 0 01-2 2H8a2 2 0 01-2-2V8Z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Legal Page Images</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage the hero visuals for Privacy Policy and Terms &amp; Conditions.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <?php foreach ($legalImageFields as $field): ?>
            <div>
              <label for="<?= esc($field['name']) ?>" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300"><?= esc($field['label']) ?></label>
              <div class="space-y-3">
                <input id="<?= esc($field['name']) ?>" name="<?= esc($field['name']) ?>" type="text" value="<?= esc($field['value']) ?>" data-media-value="<?= esc($field['name']) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                <div class="flex flex-wrap items-center gap-3">
                  <img src="<?= esc(media_url((string) $field['value'])) ?>" alt="<?= esc($field['label']) ?> preview" data-media-preview="<?= esc($field['name']) ?>" class="<?= $field['value'] === '' ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-cover dark:border-slate-700 dark:bg-slate-800" />
                  <span data-media-empty="<?= esc($field['name']) ?>" class="<?= $field['value'] !== '' ? 'hidden ' : '' ?>text-xs text-slate-400">No image selected</span>
                  <button type="button" data-open-media-picker="<?= esc($field['name']) ?>" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
                  <button type="button" data-clear-media="<?= esc($field['name']) ?>" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Legal Page Images
          </button>
        </div>
      </form>

      <form id="settings-panel-roompage" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="roompage" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zm4-8h6m-6 4h8"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Room Page</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage the shared copy and policy content used across all room detail pages.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="room_detail_about_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">About Eyebrow</label>
            <input id="room_detail_about_eyebrow" name="room_detail_about_eyebrow" type="text" value="<?= esc($roomDetailAboutEyebrow) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="room_detail_amenities_label" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Amenities Label</label>
            <input id="room_detail_amenities_label" name="room_detail_amenities_label" type="text" value="<?= esc($roomDetailAmenitiesLabel) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="room_detail_heading_prefix" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Heading Prefix</label>
            <input id="room_detail_heading_prefix" name="room_detail_heading_prefix" type="text" value="<?= esc($roomDetailHeadingPrefix) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="room_detail_heading_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Heading Highlight</label>
            <input id="room_detail_heading_highlight" name="room_detail_heading_highlight" type="text" value="<?= esc($roomDetailHeadingHighlight) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="room_detail_guest_summary_template" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Guest Summary Template</label>
            <textarea id="room_detail_guest_summary_template" name="room_detail_guest_summary_template" rows="3"
                      class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($roomDetailGuestSummaryTemplate) ?></textarea>
            <p class="mt-2 text-xs text-slate-400">Use <code>{guests}</code> for the guest count and <code>{plural}</code> for automatic singular/plural handling.</p>
          </div>
          <div>
            <label for="room_detail_policies_label" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Policies Label</label>
            <input id="room_detail_policies_label" name="room_detail_policies_label" type="text" value="<?= esc($roomDetailPoliciesLabel) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Check-in / Check-out</label>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/70 px-4 py-3 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-400">
              Times are pulled from the <span class="font-medium text-slate-700 dark:text-slate-200">Booking</span> settings tab.
            </div>
          </div>
          <div>
            <label for="room_detail_cancellation_text" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Cancellation Text</label>
            <input id="room_detail_cancellation_text" name="room_detail_cancellation_text" type="text" value="<?= esc($roomDetailCancellationText) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="room_detail_id_required_text" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">ID Requirement Text</label>
            <input id="room_detail_id_required_text" name="room_detail_id_required_text" type="text" value="<?= esc($roomDetailIdRequiredText) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Room Page Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-tridentpage" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="tridentpage" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8M12 17v4M7 4h10l2 5-7 8-7-8 2-5Zm0 0 5 13 5-13"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Trident Page</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage the public banquet page content, enquiry form options, and page images.</p>
          </div>
        </div>

        <div class="grid gap-8">
          <section class="grid gap-5 sm:grid-cols-2">
            <div><label for="event_email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Event Email</label><input id="event_email" name="event_email" type="email" value="<?= esc($tridentEventEmail) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="trident_guest_capacity" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Guest Capacity</label><input id="trident_guest_capacity" name="trident_guest_capacity" type="text" value="<?= esc($tridentGuestCapacity) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_venue_area" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Venue Area</label><input id="trident_venue_area" name="trident_venue_area" type="text" value="<?= esc($tridentVenueArea) ?>" placeholder="5000" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div><label for="trident_hero_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Eyebrow</label><input id="trident_hero_eyebrow" name="trident_hero_eyebrow" type="text" value="<?= esc($tridentHeroEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="trident_hero_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Highlight</label><input id="trident_hero_highlight" name="trident_hero_highlight" type="text" value="<?= esc($tridentHeroHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_hero_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Title</label><input id="trident_hero_title" name="trident_hero_title" type="text" value="<?= esc($tridentHeroTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div><label for="trident_overview_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Overview Eyebrow</label><input id="trident_overview_eyebrow" name="trident_overview_eyebrow" type="text" value="<?= esc($tridentOverviewEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="trident_overview_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Overview Highlight</label><input id="trident_overview_highlight" name="trident_overview_highlight" type="text" value="<?= esc($tridentOverviewHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_overview_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Overview Title</label><input id="trident_overview_title" name="trident_overview_title" type="text" value="<?= esc($tridentOverviewTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_overview_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Overview Description</label><textarea id="trident_overview_description" name="trident_overview_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentOverviewDescription) ?></textarea></div>
            <div class="sm:col-span-2"><label for="trident_overview_secondary_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Overview Secondary Description</label><textarea id="trident_overview_secondary_description" name="trident_overview_secondary_description" rows="4" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentOverviewSecondaryDescription) ?></textarea></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div><label for="trident_contact_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Eyebrow</label><input id="trident_contact_eyebrow" name="trident_contact_eyebrow" type="text" value="<?= esc($tridentContactEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="trident_contact_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Highlight</label><input id="trident_contact_highlight" name="trident_contact_highlight" type="text" value="<?= esc($tridentContactHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_contact_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Title</label><input id="trident_contact_title" name="trident_contact_title" type="text" value="<?= esc($tridentContactTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_contact_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Contact Description</label><textarea id="trident_contact_description" name="trident_contact_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentContactDescription) ?></textarea></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div><label for="trident_cta_eyebrow" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Eyebrow</label><input id="trident_cta_eyebrow" name="trident_cta_eyebrow" type="text" value="<?= esc($tridentCtaEyebrow) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div><label for="trident_cta_highlight" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Highlight</label><input id="trident_cta_highlight" name="trident_cta_highlight" type="text" value="<?= esc($tridentCtaHighlight) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_cta_title" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Title</label><input id="trident_cta_title" name="trident_cta_title" type="text" value="<?= esc($tridentCtaTitle) ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" /></div>
            <div class="sm:col-span-2"><label for="trident_cta_description" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CTA Description</label><textarea id="trident_cta_description" name="trident_cta_description" rows="3" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentCtaDescription) ?></textarea></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Event Types</label>
              <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/70 px-4 py-3 text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/40 dark:text-slate-400">
                Event types now come directly from the <span class="font-medium text-slate-700 dark:text-slate-200">Trident event list</span>, so the frontend cards and enquiry form stay in sync.
              </div>
            </div>
            <div class="sm:col-span-2"><label for="trident_guest_ranges" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Guest Ranges</label><textarea id="trident_guest_ranges" name="trident_guest_ranges" rows="5" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentGuestRanges) ?></textarea><p class="mt-2 text-xs text-slate-400">One range per line. These appear in the frontend enquiry form.</p></div>
          </section>

          <section class="grid gap-5 sm:grid-cols-2">
            <div>
              <label for="trident_hero_image" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Hero Image</label>
              <div class="space-y-3">
                <input id="trident_hero_image" name="trident_hero_image" type="text" value="<?= esc($tridentHeroImage) ?>" data-media-value="trident_hero_image" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                <div class="flex flex-wrap items-center gap-3">
                  <img src="<?= esc(media_url($tridentHeroImage)) ?>" alt="Hero image preview" data-media-preview="trident_hero_image" class="<?= $tridentHeroImage === '' ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-cover dark:border-slate-700 dark:bg-slate-800" />
                  <span data-media-empty="trident_hero_image" class="<?= $tridentHeroImage !== '' ? 'hidden ' : '' ?>text-xs text-slate-400">No image selected</span>
                  <button type="button" data-open-media-picker="trident_hero_image" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
                  <button type="button" data-clear-media="trident_hero_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
                </div>
              </div>
            </div>
            <div>
              <label for="trident_secondary_image" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Secondary Image</label>
              <div class="space-y-3">
                <input id="trident_secondary_image" name="trident_secondary_image" type="text" value="<?= esc($tridentSecondaryImage) ?>" data-media-value="trident_secondary_image" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                <div class="flex flex-wrap items-center gap-3">
                  <img src="<?= esc(media_url($tridentSecondaryImage)) ?>" alt="Secondary image preview" data-media-preview="trident_secondary_image" class="<?= $tridentSecondaryImage === '' ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-cover dark:border-slate-700 dark:bg-slate-800" />
                  <span data-media-empty="trident_secondary_image" class="<?= $tridentSecondaryImage !== '' ? 'hidden ' : '' ?>text-xs text-slate-400">No image selected</span>
                  <button type="button" data-open-media-picker="trident_secondary_image" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
                  <button type="button" data-clear-media="trident_secondary_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
                </div>
              </div>
            </div>
            <div class="sm:col-span-2">
              <label for="trident_features_image" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Facilities Section Image</label>
              <div class="space-y-3">
                <input id="trident_features_image" name="trident_features_image" type="text" value="<?= esc($tridentFeaturesImage) ?>" data-media-value="trident_features_image" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                <div class="flex flex-wrap items-center gap-3">
                  <img src="<?= esc(media_url($tridentFeaturesImage)) ?>" alt="Facilities image preview" data-media-preview="trident_features_image" class="<?= $tridentFeaturesImage === '' ? 'hidden ' : '' ?>h-16 w-24 rounded-2xl border border-slate-200 bg-slate-50 object-cover dark:border-slate-700 dark:bg-slate-800" />
                  <span data-media-empty="trident_features_image" class="<?= $tridentFeaturesImage !== '' ? 'hidden ' : '' ?>text-xs text-slate-400">No image selected</span>
                  <button type="button" data-open-media-picker="trident_features_image" class="rounded-2xl bg-[#0D1117] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-[#C99A30] dark:text-slate-950">Choose from Media</button>
                  <button type="button" data-clear-media="trident_features_image" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</button>
                </div>
              </div>
            </div>
            <div class="sm:col-span-2"><label for="trident_gallery_images" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gallery Images</label><textarea id="trident_gallery_images" name="trident_gallery_images" rows="6" class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($tridentGalleryImages) ?></textarea><p class="mt-2 text-xs text-slate-400">One image path or full URL per line. You can paste Media paths here.</p></div>
          </section>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save Trident Page Settings
          </button>
        </div>
      </form>

      <form id="settings-panel-system" action="<?= base_url('admin/settings/update') ?>" method="POST"
            class="settings-page-panel hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-7">
        <?= csrf_field() ?>
        <input type="hidden" name="settings_tab" value="system" />

        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
          <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-r from-[#F59E0B] to-[#FB923C] text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">System</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Timezone, date display, admin listing size, maintenance mode, and developer tools.</p>
          </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label for="system_timezone" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Timezone</label>
            <input id="system_timezone" name="system_timezone" type="text" value="<?= esc($systemTimezone) ?>" placeholder="Asia/Kolkata"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="system_date_format" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Date Format</label>
            <input id="system_date_format" name="system_date_format" type="text" value="<?= esc($systemDateFormat) ?>" placeholder="d M Y"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="system_currency_symbol" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Currency Symbol</label>
            <input id="system_currency_symbol" name="system_currency_symbol" type="text" value="<?= esc($systemCurrencySymbol) ?>" placeholder="Rs."
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="system_records_per_page" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Records Per Page</label>
            <input id="system_records_per_page" name="system_records_per_page" type="text" value="<?= esc($systemRecordsPerPage) ?>" placeholder="10"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div class="sm:col-span-2">
            <label for="system_maintenance_mode" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Maintenance Mode</label>
            <select id="system_maintenance_mode" name="system_maintenance_mode"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
              <option value="0" <?= $systemMaintenanceMode === '0' ? 'selected' : '' ?>>Off</option>
              <option value="1" <?= $systemMaintenanceMode === '1' ? 'selected' : '' ?>>On</option>
            </select>
          </div>
          <div class="sm:col-span-2">
            <input type="hidden" name="system_developer_mode" value="0" />
            <label for="system_developer_mode" class="flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 dark:border-slate-700 dark:bg-slate-800">
              <span>
                <span class="block text-sm font-medium text-slate-700 dark:text-slate-300">Developer Mode</span>
                <span class="mt-1 block text-xs text-slate-400">Shows owner-only developer tools such as SEO Manager.</span>
              </span>
              <span class="relative inline-flex h-7 w-12 shrink-0 items-center">
                <input id="system_developer_mode" name="system_developer_mode" type="checkbox" value="1" <?= $systemDeveloperMode === '1' ? 'checked' : '' ?> class="peer sr-only" />
                <span class="absolute inset-0 rounded-full bg-slate-300 transition peer-checked:bg-[#C99A30] dark:bg-slate-700"></span>
                <span class="absolute left-1 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                </span>
            </label>
          </div>
          <?php if ($developerOtpPending) : ?>
            <div id="developer-mode-otp-panel" class="hidden sm:col-span-2 rounded-2xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-500/30 dark:bg-amber-500/10">
              <label for="developer_mode_otp" class="mb-2 block text-sm font-medium text-amber-900 dark:text-amber-200">Developer Mode OTP</label>
              <input id="developer_mode_otp" name="developer_mode_otp" type="text" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" autocomplete="one-time-code" placeholder="4-digit OTP"
                     class="w-full rounded-2xl border border-amber-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-amber-500/30 dark:bg-slate-900 dark:text-white" />
            </div>
          <?php endif; ?>
          <div class="sm:col-span-2 border-t border-slate-100 pt-5 dark:border-slate-800">
            <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Security Rate Limits</h3>
            <p class="mt-1 text-xs text-slate-400">Owners can tune lockout behavior based on property operations and support volume.</p>
          </div>
          <div>
            <label for="security_login_max_attempts" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Login Failed Attempts</label>
            <input id="security_login_max_attempts" name="security_login_max_attempts" type="number" min="1" max="20" value="<?= esc($securityLoginMaxAttempts) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="security_login_lock_minutes" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Login Lock Minutes</label>
            <input id="security_login_lock_minutes" name="security_login_lock_minutes" type="number" min="1" max="1440" value="<?= esc($securityLoginLockMinutes) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="security_refund_otp_max_attempts" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Refund OTP Attempts</label>
            <input id="security_refund_otp_max_attempts" name="security_refund_otp_max_attempts" type="number" min="1" max="20" value="<?= esc($securityRefundOtpMaxAttempts) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
          <div>
            <label for="security_refund_otp_resend_minutes" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Refund OTP Resend Minutes</label>
            <input id="security_refund_otp_resend_minutes" name="security_refund_otp_resend_minutes" type="number" min="1" max="60" value="<?= esc($securityRefundOtpResendMinutes) ?>"
                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
          </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-6 dark:border-slate-800">
          <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
            Save System Settings
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= view('admin/media/_picker_modal', [
  'modalId' => 'settingsMediaPickerModal',
  'searchId' => 'settingsMediaSearch',
  'emptyId' => 'settingsMediaSearchEmpty',
  'files' => $mediaFiles,
  'title' => 'Choose Image',
  'description' => 'Upload a new image or select one from the media library.',
  'showUploadPanel' => true,
  'uploadToggleId' => 'settingsMediaUploadToggle',
  'uploadToggleLabelId' => 'settingsMediaUploadToggleLabel',
  'uploadToggleIconId' => 'settingsMediaUploadToggleIcon',
  'uploadPanelId' => 'settingsMediaUploadPanel',
  'uploadInputId' => 'settings_media_file',
  'uploadActiveTab' => 'branding',
]) ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const activeSettingsTab = <?= json_encode($activeSettingsTab) ?> || 'hotel';
    const modal = document.getElementById('settingsMediaPickerModal');
    const searchInput = document.getElementById('settingsMediaSearch');
    const searchCount = modal ? modal.querySelector('[data-media-picker-count]') : null;
    const searchEmpty = document.getElementById('settingsMediaSearchEmpty');
    const baseUrl = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;
    const uploadPanel = document.getElementById('settingsMediaUploadPanel');
    const uploadToggle = document.getElementById('settingsMediaUploadToggle');
    const uploadToggleLabel = document.getElementById('settingsMediaUploadToggleLabel');
    const uploadToggleIcon = document.getElementById('settingsMediaUploadToggleIcon');
    const uploadForm = uploadPanel ? uploadPanel.querySelector('form') : null;
    const uploadInput = uploadPanel ? uploadPanel.querySelector('[data-file-input]') : null;
    const uploadFileName = uploadPanel ? uploadPanel.querySelector('[data-file-name]') : null;
    const uploadStatus = uploadPanel ? uploadPanel.querySelector('[data-upload-status]') : null;
    let uploading = false;
    let activeMediaTarget = null;

    function showSettingsPanel(panelName) {
      document.querySelectorAll('.settings-page-panel').forEach(function (panel) {
        panel.classList.add('hidden');
      });

      document.querySelectorAll('.settings-nav-item').forEach(function (button) {
        button.classList.remove('bg-gradient-to-r', 'from-[#F59E0B]', 'to-[#FB923C]', 'text-white', 'shadow-lg');
        button.classList.add('text-slate-600', 'hover:bg-slate-50', 'dark:text-slate-300', 'dark:hover:bg-slate-800');
      });

      const panel = document.getElementById('settings-panel-' + panelName);
      const nav = document.querySelector('[data-settings-nav="' + panelName + '"]');

      if (!panel || !nav) {
        return showSettingsPanel('hotel');
      }

      panel.classList.remove('hidden');
      nav.classList.add('bg-gradient-to-r', 'from-[#F59E0B]', 'to-[#FB923C]', 'text-white', 'shadow-lg');
      nav.classList.remove('text-slate-600', 'hover:bg-slate-50', 'dark:text-slate-300', 'dark:hover:bg-slate-800');
    }

    document.querySelectorAll('[data-settings-nav]').forEach(function (button) {
      button.addEventListener('click', function () {
        showSettingsPanel(button.getAttribute('data-settings-nav'));
      });
    });

    const gatewayProviderSelect = document.getElementById('payment_gateway_provider');
    const razorpayEnvironmentSelect = document.getElementById('razorpay_environment');
    const razorpayKeyIdInput = document.getElementById('razorpay_key_id');

    function syncRazorpayPlaceholders() {
      if (!razorpayEnvironmentSelect || !razorpayKeyIdInput) return;
      razorpayKeyIdInput.placeholder = razorpayEnvironmentSelect.value === 'production'
        ? 'rzp_live_...'
        : 'rzp_test_...';
    }

    function syncGatewaySettings() {
      const selectedGateway = gatewayProviderSelect ? gatewayProviderSelect.value : 'cashfree';

      document.querySelectorAll('[data-gateway-settings]').forEach(function (section) {
        section.classList.toggle('hidden', section.dataset.gatewaySettings !== selectedGateway);
      });

      syncRazorpayPlaceholders();
    }

    if (gatewayProviderSelect) {
      gatewayProviderSelect.addEventListener('change', syncGatewaySettings);
      syncGatewaySettings();
    }

    if (razorpayEnvironmentSelect) {
      razorpayEnvironmentSelect.addEventListener('change', syncRazorpayPlaceholders);
      syncRazorpayPlaceholders();
    }

    const developerModeToggle = document.getElementById('system_developer_mode');
    const developerModeOtpPanel = document.getElementById('developer-mode-otp-panel');
    const developerModeOtpInput = document.getElementById('developer_mode_otp');

    function syncDeveloperModeOtpPanel() {
      if (!developerModeToggle || !developerModeOtpPanel) return;

      const showOtpPanel = developerModeToggle.checked;
      developerModeOtpPanel.classList.toggle('hidden', !showOtpPanel);

      if (!showOtpPanel && developerModeOtpInput) {
        developerModeOtpInput.value = '';
      }
    }

    if (developerModeToggle) {
      developerModeToggle.addEventListener('change', syncDeveloperModeOtpPanel);
      syncDeveloperModeOtpPanel();
    }

    function setField(target, path) {
      const input = document.querySelector('[data-media-value="' + target + '"]');
      const preview = document.querySelector('[data-media-preview="' + target + '"]');
      const empty = document.querySelector('[data-media-empty="' + target + '"]');
      if (input) input.value = path;
      if (preview) {
        preview.src = path ? baseUrl + path.replace(/^\/+/, '') : '';
        preview.classList.toggle('hidden', !path);
      }
      if (empty) empty.classList.toggle('hidden', !!path);
    }

    function setModal(open) {
      if (!modal) return;
      modal.classList.toggle('hidden', !open);
      modal.classList.toggle('flex', open);
      document.body.classList.toggle('overflow-hidden', open);
    }

    function filterCards() {
      const cards = Array.from(document.querySelectorAll('#settingsMediaPickerModal [data-media-picker-card]'));
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

    function setUploadPanel(open) {
      if (!uploadPanel || !uploadToggle) return;
      uploadPanel.style.maxHeight = open ? uploadPanel.scrollHeight + 'px' : '0';
      uploadPanel.style.opacity = open ? '1' : '0';
      uploadPanel.style.transform = open ? 'translateY(0)' : 'translateY(-12px)';
      uploadPanel.style.pointerEvents = open ? 'auto' : 'none';
      uploadToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (uploadToggleLabel) uploadToggleLabel.textContent = open ? 'Close Upload' : 'Open Upload';
      if (uploadToggleIcon) uploadToggleIcon.style.transform = open ? 'rotate(45deg)' : 'rotate(0deg)';
    }

    function appendPickerFiles(files) {
      const grid = modal ? modal.querySelector('[data-media-picker-grid]') : null;
      const empty = modal ? modal.querySelector('[data-media-picker-empty]') : null;
      if (!grid) return;

      grid.classList.remove('hidden');

      (files || []).forEach(function (file) {
        const button = document.createElement('button');
        button.type = 'button';
        button.dataset.selectMediaPath = file.path || '';
        button.dataset.mediaPickerCard = '';
        button.dataset.mediaName = (file.original_name || '').toLowerCase();
        button.dataset.mediaPath = (file.path || '').toLowerCase();
        button.className = 'group overflow-hidden rounded-2xl border border-slate-200 bg-white text-left transition hover:-translate-y-0.5 hover:border-[#C99A30] hover:shadow-lg dark:border-slate-700 dark:bg-slate-900';
        button.innerHTML = '<span class="flex aspect-[4/3] items-center justify-center bg-slate-100 dark:bg-slate-800"><img class="h-full w-full object-contain p-4" /></span><span class="block p-3"><span class="block truncate text-sm font-semibold text-slate-900 dark:text-white"></span><span class="mt-1 block truncate text-xs text-slate-400"></span></span>';
        button.querySelector('img').src = file.url || '';
        button.querySelector('img').alt = file.alt_text || file.original_name || 'Media file';
        button.querySelector('.text-sm').textContent = file.original_name || file.file_name || 'Media file';
        button.querySelector('.text-xs').textContent = file.path || '';
        button.addEventListener('click', function () {
          if (!activeMediaTarget) return;
          setField(activeMediaTarget, button.dataset.selectMediaPath || '');
          setModal(false);
        });
        grid.prepend(button);
      });

      if (empty && (files || []).length) empty.classList.add('hidden');
      filterCards();
    }

    function syncUploadName(files) {
      if (!uploadFileName) return;
      const list = Array.from(files || uploadInput?.files || []);
      if (!list.length) {
        uploadFileName.textContent = '';
        return;
      }
      if (list.length === 1) {
        uploadFileName.textContent = list[0].name;
        return;
      }
      uploadFileName.textContent = list.length + ' files selected: ' + list.slice(0, 3).map(function (file) {
        return file.name;
      }).join(', ') + (list.length > 3 ? '...' : '');
    }

    async function uploadPickerFiles(files) {
      const list = Array.from(files || []);
      if (!uploadForm || !uploadInput || !list.length || uploading) return;

      uploading = true;
      syncUploadName(list);
      if (uploadStatus) uploadStatus.textContent = 'Uploading...';

      const body = new FormData();
      Array.from(uploadForm.elements).forEach(function (element) {
        if (!element.name || element === uploadInput || element.disabled) return;
        if ((element.type === 'checkbox' || element.type === 'radio') && !element.checked) return;
        body.append(element.name, element.value);
      });
      list.forEach(function (file) {
        body.append(uploadInput.name || 'media_files[]', file);
      });

      try {
        const response = await fetch(uploadForm.action, {
          method: 'POST',
          body,
          credentials: 'same-origin',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        const contentType = response.headers.get('content-type') || '';
        const payload = contentType.includes('application/json')
          ? await response.json()
          : { success: false, message: 'Upload failed. Please refresh and try again.' };

        if (payload.csrf && payload.csrf.hash) {
          document.querySelectorAll('input[name="<?= esc(csrf_token()) ?>"]').forEach(function (input) {
            input.value = payload.csrf.hash;
          });
        }

        if (!response.ok || !payload.success) {
          throw new Error(payload.message || 'Upload failed.');
        }

        appendPickerFiles(payload.files || []);
        if (typeof window.adminMediaUpload?.toast === 'function') {
          window.adminMediaUpload.toast(payload.message || 'Images uploaded successfully.');
        }
        uploadInput.value = '';
        syncUploadName();
        if (uploadStatus) uploadStatus.textContent = 'Upload starts automatically after browse or drop.';
      } catch (error) {
        if (typeof window.adminMediaUpload?.toast === 'function') {
          window.adminMediaUpload.toast(error.message || 'Upload failed.', 'error');
        }
        uploadInput.value = '';
        syncUploadName();
        if (uploadStatus) uploadStatus.textContent = 'Upload failed. Try again.';
      } finally {
        uploading = false;
      }
    }

    document.querySelectorAll('[data-open-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        activeMediaTarget = button.dataset.openMediaPicker;
        setModal(true);
        setUploadPanel(false);
      });
    });

    document.querySelectorAll('[data-clear-media]').forEach(function (button) {
      button.addEventListener('click', function () {
        setField(button.dataset.clearMedia, '');
      });
    });

    document.querySelectorAll('#settingsMediaPickerModal [data-select-media-path]').forEach(function (button) {
      button.addEventListener('click', function () {
        if (!activeMediaTarget) return;
        setField(activeMediaTarget, button.dataset.selectMediaPath || '');
        setModal(false);
      });
    });

    document.querySelectorAll('#settingsMediaPickerModal [data-close-media-picker]').forEach(function (button) {
      button.addEventListener('click', function () {
        setModal(false);
      });
    });

    if (modal) {
      modal.addEventListener('click', function (event) {
        if (event.target === modal) setModal(false);
      });
    }

    if (uploadToggle) {
      uploadToggle.addEventListener('click', function () {
        const expanded = uploadToggle.getAttribute('aria-expanded') === 'true';
        setUploadPanel(!expanded);
      });
    }

    if (uploadInput) {
      uploadInput.addEventListener('click', function () {
        uploadInput.value = '';
        syncUploadName();
        if (uploadStatus) uploadStatus.textContent = 'Upload starts automatically after browse or drop.';
      });
      uploadInput.addEventListener('change', function () {
        uploadPickerFiles(uploadInput.files);
      });
    }

    if (uploadPanel) {
      const dropZone = uploadPanel.querySelector('[data-drop-zone]');
      if (dropZone) {
        dropZone.addEventListener('click', function (event) {
          if (event.target.closest('[data-file-input]')) return;
          event.preventDefault();
          uploadInput?.click();
        });
        dropZone.addEventListener('dragover', function (event) {
          event.preventDefault();
          dropZone.classList.add('border-[#C99A30]', 'bg-[#C99A30]/5');
        });
        dropZone.addEventListener('dragleave', function () {
          dropZone.classList.remove('border-[#C99A30]', 'bg-[#C99A30]/5');
        });
        dropZone.addEventListener('drop', function (event) {
          event.preventDefault();
          dropZone.classList.remove('border-[#C99A30]', 'bg-[#C99A30]/5');
          if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files.length) {
            uploadPickerFiles(event.dataTransfer.files);
          }
        });
      }
    }

    if (searchInput) {
      searchInput.addEventListener('input', filterCards);
      filterCards();
    }

    showSettingsPanel(activeSettingsTab);
  });
</script>
