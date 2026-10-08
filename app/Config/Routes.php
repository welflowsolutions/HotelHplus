<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── Front-end (public) ───────────────────────────────────────────────────
$routes->get('/',                   'Front\HomeController::index');
$routes->get('about',               'Front\HomeController::about');
$routes->get('rooms',               'Front\HomeController::rooms');
$routes->get('rooms/(:segment)',    'Front\HomeController::roomDetail/$1');
$routes->get('events',              'Front\HomeController::events');
// Trident page is currently disabled for the public website.
// Keep Front\HomeController::trident and front/trident.php for future reuse.
// $routes->get('trident',          'Front\HomeController::trident');
$routes->get('gallery',             'Front\HomeController::gallery');
$routes->get('contact',             'Front\HomeController::contact');
$routes->get('contact/send',        'Front\HomeController::contactSendDirect');
$routes->post('contact/send',       'Front\HomeController::contactSend');
$routes->get('booking/send',        'Front\HomeController::bookingSendDirect');
$routes->post('booking/send',       'Front\HomeController::bookingSend');
$routes->get('booking/checkout/(:segment)', 'Front\HomeController::bookingCheckout/$1');
$routes->get('booking/payment/return', 'Front\HomeController::bookingPaymentReturn');
$routes->get('booking/payment-status/(:segment)', 'Front\HomeController::bookingPaymentStatus/$1');
$routes->get('booking/receipt/(:segment)', 'Front\HomeController::bookingReceipt/$1');
$routes->get('booking/lookup',      'Front\HomeController::bookingLookup');
$routes->post('booking/lookup',     'Front\HomeController::bookingLookupPost');
$routes->get('event-payment/(:segment)', 'Front\EventPaymentController::checkout/$1');
$routes->get('event-payment/return', 'Front\EventPaymentController::paymentReturn');
$routes->get('event-payment/status/(:segment)', 'Front\EventPaymentController::status/$1');
$routes->get('event-payment/receipt/(:segment)', 'Front\EventPaymentController::receipt/$1');
$routes->post('event-payment/razorpay/verify', 'Front\EventPaymentController::razorpayVerify');
$routes->post('payment/razorpay/verify', 'Front\PaymentController::razorpayVerify');
$routes->post('payment/webhook/(:segment)', 'Front\PaymentController::webhook/$1');
$routes->get('events/send',         'Front\HomeController::eventsSendDirect');
$routes->post('events/send',        'Front\HomeController::eventsSend');
// $routes->post('trident/send',    'Front\HomeController::tridentSend');
$routes->get('subscribe',           'Front\HomeController::subscribeDirect');
$routes->post('subscribe',          'Front\HomeController::subscribe');
$routes->get('faq',                 'Front\HomeController::faq');
$routes->get('privacy-policy',      'Front\HomeController::privacyPolicy');
$routes->get('terms-conditions',    'Front\HomeController::termsConditions');
$routes->get('thank-you',           'Front\HomeController::thankYou');
$routes->get('sitemap.xml',         'Front\SeoController::sitemapIndex');
$routes->get('sitemap_index.xml',   'Front\SeoController::sitemapIndex');
$routes->get('page-sitemap.xml',    'Front\SeoController::pageSitemap');
$routes->get('room-sitemap.xml',    'Front\SeoController::roomSitemap');
$routes->get('image-sitemap.xml',   'Front\SeoController::imageSitemap');
$routes->get('robots.txt',          'Front\SeoController::robots');

// ─── Admin Auth (public — no filter) ──────────────────────────────────────
$routes->get( 'admin/login',  'Admin\AuthController::loginForm');
$routes->post('admin/login',  'Admin\AuthController::loginPost');
$routes->get( 'admin/logout', 'Admin\AuthController::logout');

// ─── Admin Panel (protected by adminAuth filter) ───────────────────────────
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('',          'Admin\DashboardController::index'); // /admin → dashboard

    // Enquiries (contact form submissions)
    $routes->get( 'enquiries',           'Admin\EnquiryController::index');
    $routes->get( 'enquiries/(:num)',    'Admin\EnquiryController::show/$1');
    $routes->post('enquiries/(:num)/delete', 'Admin\EnquiryController::delete/$1');

    // Bookings
    $routes->get( 'bookings',             'Admin\BookingController::index');
    $routes->get( 'bookings/calendar',    'Admin\BookingController::calendar');
    $routes->get( 'bookings/create',      'Admin\BookingController::create');
    $routes->post('bookings/store',       'Admin\BookingController::store');
    $routes->get( 'bookings/(:num)',      'Admin\BookingController::show/$1');
    $routes->post('bookings/(:num)/status','Admin\BookingController::updateStatus/$1');
    $routes->post('bookings/(:num)/delete','Admin\BookingController::delete/$1');

    // Payments
    $routes->get( 'payments',             'Admin\PaymentManagerController::index');
    $routes->get( 'payments/export',      'Admin\PaymentManagerController::export');
    $routes->get( 'payments/(:num)',      'Admin\PaymentManagerController::show/$1');
    $routes->post('payments/(:num)/recheck', 'Admin\PaymentManagerController::recheck/$1');
    $routes->post('payments/(:num)/refund', 'Admin\PaymentManagerController::refund/$1');
    $routes->post('payments/(:num)/refund/verify', 'Admin\PaymentManagerController::verifyRefundOtp/$1');
    $routes->post('payments/refunds/(:num)/recheck', 'Admin\PaymentManagerController::recheckRefund/$1');

    // Subscribers
    $routes->get('subscribers', 'Admin\SubscriberController::index');

    // Activity logs
    $routes->get('activity-logs', 'Admin\ActivityLogController::index');

    // Users
    $routes->get( 'users',                 'Admin\UserController::index');
    $routes->get( 'users/permissions',     'Admin\UserController::permissions');
    $routes->post('users/permissions',     'Admin\UserController::updatePermissions');
    $routes->get( 'users/create',          'Admin\UserController::create');
    $routes->post('users/store',           'Admin\UserController::store');
    $routes->get( 'users/(:num)/edit',     'Admin\UserController::edit/$1');
    $routes->post('users/(:num)/update',   'Admin\UserController::update/$1');
    $routes->post('users/(:num)/password', 'Admin\UserController::password/$1');

    // Rooms
    $routes->get( 'rooms',               'Admin\RoomController::index');
    $routes->get( 'rooms/create',        'Admin\RoomController::create');
    $routes->post('rooms/import-starter','Admin\RoomController::importStarterRooms');
    $routes->post('rooms/store',         'Admin\RoomController::store');
    $routes->get( 'rooms/edit/(:num)',   'Admin\RoomController::edit/$1');
    $routes->post('rooms/update/(:num)', 'Admin\RoomController::update/$1');
    $routes->post('rooms/delete/(:num)', 'Admin\RoomController::delete/$1');

    // Media
    $routes->get( 'media',                'Admin\MediaController::index');
    $routes->post('media/upload',         'Admin\MediaController::upload');
    $routes->post('media/update/(:num)',  'Admin\MediaController::update/$1');
    $routes->post('media/delete/(:num)',  'Admin\MediaController::delete/$1');

    // Trident event enquiries
    $routes->get( 'trident',                    'Admin\TridentController::index');
    $routes->get( 'trident/events',             'Admin\TridentController::events');
    $routes->get( 'trident/events/create',      'Admin\TridentController::createEvent');
    $routes->post('trident/events/import-starter', 'Admin\TridentController::importStarterEvents');
    $routes->post('trident/events/store',       'Admin\TridentController::storeEvent');
    $routes->get( 'trident/events/edit/(:num)', 'Admin\TridentController::editEvent/$1');
    $routes->post('trident/events/update/(:num)','Admin\TridentController::updateEvent/$1');
    $routes->post('trident/events/delete/(:num)','Admin\TridentController::deleteEvent/$1');
    $routes->get( 'trident/(:num)',             'Admin\TridentController::show/$1');
    $routes->post('trident/(:num)/delete',      'Admin\TridentController::delete/$1');

    // Events
    $routes->get( 'events',                         'Admin\EventsController::index');
    $routes->get( 'events/calendar',                'Admin\EventsController::calendar');
    $routes->get( 'events/create',                  'Admin\EventsController::create');
    $routes->post('events/store',                   'Admin\EventsController::store');
    $routes->get( 'events/(:num)/edit',             'Admin\EventsController::edit/$1');
    $routes->post('events/(:num)/update',           'Admin\EventsController::update/$1');
    $routes->post('events/(:num)/status',           'Admin\EventsController::updateStatus/$1');
    $routes->get( 'events/page',                    'Admin\EventsController::page');
    $routes->post('events/page',                    'Admin\EventsController::updatePage');
    $routes->get( 'events/services',                'Admin\EventsController::services');
    $routes->get( 'events/services/create',         'Admin\EventsController::createService');
    $routes->post('events/services/import-starter', 'Admin\EventsController::importStarterServices');
    $routes->post('events/services/store',          'Admin\EventsController::storeService');
    $routes->get( 'events/services/edit/(:num)',    'Admin\EventsController::editService/$1');
    $routes->post('events/services/update/(:num)',  'Admin\EventsController::updateService/$1');
    $routes->post('events/services/delete/(:num)',  'Admin\EventsController::deleteService/$1');
    $routes->get( 'events/packages',                'Admin\EventsController::packages');
    $routes->get( 'events/packages/create',         'Admin\EventsController::createPackage');
    $routes->post('events/packages/import-starter', 'Admin\EventsController::importStarterPackages');
    $routes->post('events/packages/store',          'Admin\EventsController::storePackage');
    $routes->get( 'events/packages/edit/(:num)',    'Admin\EventsController::editPackage/$1');
    $routes->post('events/packages/update/(:num)',  'Admin\EventsController::updatePackage/$1');
    $routes->post('events/packages/delete/(:num)',  'Admin\EventsController::deletePackage/$1');
    $routes->get( 'events/(:num)',                  'Admin\EventsController::show/$1');
    $routes->post('events/(:num)/payment-link',     'Admin\EventsController::createPaymentLink/$1');
    $routes->post('events/(:num)/manual-payment',   'Admin\EventsController::recordManualPayment/$1');
    $routes->post('events/(:num)/payments/(:num)/cancel', 'Admin\EventsController::cancelPaymentLink/$1/$2');
    $routes->post('events/(:num)/delete',           'Admin\EventsController::delete/$1');

    // Settings
    $routes->get( 'settings',            'Admin\SettingsController::index');
    $routes->post('settings/update',     'Admin\SettingsController::update');
    $routes->get( 'email-templates',     'Admin\SettingsController::emailTemplates');
    $routes->get( 'receipt-styles',      'Admin\SettingsController::receiptStyles');

    // Pages
    $routes->get( 'pages',               'Admin\PagesController::index');
    $routes->get( 'pages/(:segment)',    'Admin\PagesController::edit/$1');
    $routes->post('pages/update',        'Admin\PagesController::update');
    $routes->post('pages/(:segment)/update', 'Admin\PagesController::update/$1');
    $routes->get( 'gallery',             'Admin\PagesController::edit/gallerypage');
    $routes->post('gallery/update',      'Admin\PagesController::update/gallerypage');

    // SEO Manager
    $routes->get( 'seo-manager',                 'Admin\SeoController::index');
    $routes->get( 'seo-manager/global',          'Admin\SeoController::global');
    $routes->post('seo-manager/global',          'Admin\SeoController::updateGlobal');
    $routes->post('seo-manager/sync-routes',     'Admin\SeoController::syncRoutes');
    $routes->post('seo-manager/untrack/(:segment)', 'Admin\SeoController::untrack/$1');
    $routes->get( 'seo-manager/(:segment)',      'Admin\SeoController::edit/$1');
    $routes->post('seo-manager/(:segment)',      'Admin\SeoController::update/$1');

    // Profile
    $routes->get( 'profile',             'Admin\ProfileController::index');
    $routes->post('profile/update',      'Admin\ProfileController::update');
    $routes->post('profile/password',    'Admin\ProfileController::updatePassword');
});
