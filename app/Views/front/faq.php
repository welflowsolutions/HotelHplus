<?php
$hotelName = app_setting('hotel_name', 'Hotel H Plus');
$hotelPhone = app_setting('hotel_phone', '+91 92530 72122');
?>

<section class="page-hero faq-hero" aria-label="FAQ">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50">Help Centre</span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Frequently Asked <em class="text-gold">Questions</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">FAQ</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-20 bg-ivory" aria-label="FAQ sections">
  <div class="max-w-4xl mx-auto px-6 lg:px-10">
    <div class="text-center mb-14 reveal">
      <div class="ornament mb-6"><span class="section-tag">Got Questions?</span></div>
      <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-light text-ink mb-4">
        Everything You Need to <em class="text-gold">Know</em>
      </h2>
      <p class="text-ink/55 text-[15px] leading-relaxed max-w-xl mx-auto">
        If you do not see your answer here, call us at <a href="tel:<?= esc($hotelPhone) ?>" class="text-gold hover:text-gold-dark transition-colors font-medium"><?= esc($hotelPhone) ?></a> or reach us through the <a href="<?= base_url('contact') ?>" class="text-gold hover:text-gold-dark transition-colors font-medium">contact page</a>.
      </p>
    </div>

    <div class="flex flex-wrap justify-center gap-0 border-b border-gold/15 mb-12" role="tablist">
      <button class="cat-btn active" data-cat="all" onclick="filterFaq(this,'all')" role="tab" aria-selected="true">All</button>
      <button class="cat-btn" data-cat="stay" onclick="filterFaq(this,'stay')" role="tab" aria-selected="false">Stays</button>
      <button class="cat-btn" data-cat="checkin" onclick="filterFaq(this,'checkin')" role="tab" aria-selected="false">Check-in</button>
      <button class="cat-btn" data-cat="amenities" onclick="filterFaq(this,'amenities')" role="tab" aria-selected="false">Amenities</button>
      <button class="cat-btn" data-cat="events" onclick="filterFaq(this,'events')" role="tab" aria-selected="false">Events</button>
      <button class="cat-btn" data-cat="location" onclick="filterFaq(this,'location')" role="tab" aria-selected="false">Location</button>
    </div>

    <div id="faq-list" class="reveal">
      <div class="faq-group" data-cat="stay">
        <p class="faq-group-title">Stays &amp; Bookings</p>
        <?= view('front/layouts/components/_faq_items', ['items' => [
          ['How do I make a reservation at ' . $hotelName . '?', 'You can book by calling us directly, sending a WhatsApp message, or submitting an enquiry through the contact page. Our team confirms availability and final booking details with you.'],
          ['What is your cancellation policy?', 'Cancellations made early can usually be adjusted more smoothly. Final booking and refund terms depend on the type of reservation and confirmation shared by the hotel team at the time of booking.'],
          ['Are room rates inclusive of taxes?', 'Displayed room pricing should be treated as the quoted base for your enquiry. Our team shares the full confirmed rate with applicable taxes before final confirmation.'],
          ['Can I request a specific room or floor?', 'Yes. You can mention your preference while booking and we will try to accommodate it based on availability on your stay dates.'],
        ]]) ?>
      </div>

      <div class="faq-group" data-cat="checkin">
        <p class="faq-group-title">Check-in &amp; Check-out</p>
        <?= view('front/layouts/components/_faq_items', ['items' => [
          ['What are the check-in and check-out times?', 'Standard check-in begins at 12:00 PM and check-out is by 11:00 AM. Early check-in or late check-out may be possible depending on availability.'],
          ['What ID is required at check-in?', 'Guests should carry a valid government-issued photo ID for check-in verification.'],
          ['Is early check-in available?', 'Yes, early check-in can be requested in advance and is subject to room readiness and availability on the day.'],
        ]]) ?>
      </div>

      <div class="faq-group" data-cat="amenities">
        <p class="faq-group-title">Amenities &amp; Services</p>
        <?= view('front/layouts/components/_faq_items', ['items' => [
          ['Is Wi-Fi available at the hotel?', 'Yes, Wi-Fi is available for guests staying at the hotel.'],
          ['Is parking available?', 'Yes, parking is available for hotel guests and event visitors.'],
          ['Do you offer room service?', 'Yes, room service support is available for in-house guests.'],
          ['Are all rooms air-conditioned?', 'Yes, our rooms are designed for comfortable stays and include air-conditioning.'],
          ['Do you allow pets?', 'Please contact the hotel directly before booking if you need clarity on pet-related requests, as approval may depend on the stay type and current policy.'],
          ['Is there an in-house dining option?', 'Yes, food and dining support is available at the property for guests and select event requirements.'],
        ]]) ?>
      </div>

      <div class="faq-group" data-cat="events">
        <p class="faq-group-title">Events &amp; Celebrations</p>
        <?= view('front/layouts/components/_faq_items', ['items' => [
          ['What types of events can be planned through the hotel?', 'We can help guide enquiries for weddings, receptions, family celebrations, business meets, and social gatherings depending on availability and current offerings.'],
          ['Do you provide in-house event support?', 'Yes, event-related support such as guest coordination, catering guidance, and hospitality planning can be discussed with the team during enquiry.'],
          ['How do I enquire about an event?', 'Use the Events page enquiry form or contact the hotel team directly. We will guide you on availability, requirements, and next steps.'],
          ['Can guest count and setup be customised?', 'Yes, guest count, layout preferences, and service expectations can be discussed in advance so the team can suggest the right arrangement.'],
          ['Should event details be confirmed early?', 'Yes, it is best to confirm guest count, timings, decor expectations, and service needs in advance for smoother planning.'],
        ]]) ?>
      </div>

      <div class="faq-group" data-cat="location">
        <p class="faq-group-title">Location &amp; Getting Here</p>
        <?= view('front/layouts/components/_faq_items', ['items' => [
          ['Where is ' . $hotelName . ' located?', $hotelName . ' is located on Pipli Road, Kurukshetra, with convenient access from the main city and highway routes.'],
          ['How far is the hotel from Kurukshetra Railway Station?', 'The hotel is a short drive from Kurukshetra Railway Station. Travel time depends on traffic and your arrival hour.'],
          ['What nearby attractions can guests visit?', 'Guests often visit Kurukshetra landmarks, religious sites, and local city points while staying here.'],
          ['Do you offer airport transfer support?', 'Please contact the hotel team before arrival if you need transport guidance so we can suggest the best local travel option available.'],
        ]]) ?>
      </div>
    </div>

    <div class="mt-16 bg-ink text-white p-10 text-center reveal">
      <p class="font-display text-2xl font-light text-white mb-2">Still Have a Question?</p>
      <p class="text-white/45 text-sm mb-8">Our team is available to help with booking, stay details, and event enquiries.</p>
      <div class="flex flex-wrap justify-center gap-4">
        <a href="<?= base_url('contact') ?>" class="btn-gold">Contact Us</a>
        <a href="tel:<?= esc($hotelPhone) ?>" class="btn-gold-outline faq-call-btn"><i class="fa-solid fa-phone text-[10px]"></i> <?= esc($hotelPhone) ?></a>
      </div>
    </div>
  </div>
</section>
