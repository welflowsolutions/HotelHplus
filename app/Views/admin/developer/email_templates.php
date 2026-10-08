<?php
$settings = $settings ?? [];
$emailBookingAutoReplySubject = old('email_template_booking_auto_reply_subject', $settings['email_template_booking_auto_reply_subject'] ?? 'Your booking request at {hotel_name}');
$emailBookingAutoReplyBody = old('email_template_booking_auto_reply_body', $settings['email_template_booking_auto_reply_body'] ?? "Hello {guest_name},\n\nThank you for your booking request at {hotel_name}. We have received your request and our team will confirm availability shortly.\n\nRoom: {room_name}\nStay: {checkin} to {checkout}\nRooms: {rooms_required}\nGuests: {guests}\n\nIf needed, you can reach us at {hotel_contact}.\n\nRegards,\n{hotel_name}");
$emailEventAutoReplySubject = old('email_template_event_auto_reply_subject', $settings['email_template_event_auto_reply_subject'] ?? 'Your event enquiry at {hotel_name}');
$emailEventAutoReplyBody = old('email_template_event_auto_reply_body', $settings['email_template_event_auto_reply_body'] ?? "Hello {guest_name},\n\nThank you for your event enquiry at {hotel_name}. Our events team has received your request and will get back to you shortly.\n\nEvent: {event_type}\nDate: {event_date}\nGuests: {guests}\n\nIf needed, you can reach us at {hotel_contact}.\n\nRegards,\n{hotel_name}");
$emailEventPaymentLinkSubject = old('email_template_event_payment_link_subject', $settings['email_template_event_payment_link_subject'] ?? 'Event payment link from {hotel_name}');
$emailEventPaymentLinkBody = old('email_template_event_payment_link_body', $settings['email_template_event_payment_link_body'] ?? "Hello {guest_name},\n\nYour event payment link from {hotel_name} is ready.\n\nPayment Code: {payment_code}\nEvent: {event_type}\nEvent Date: {event_date}\nAmount: {amount}\n\nPay securely here:\n{payment_link}\n\nRegards,\n{hotel_name}");
?>

<div class="space-y-6">
  <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">Developer Tools</p>
      <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Email Templates</h1>
      <p class="mt-1 max-w-3xl text-sm text-slate-500 dark:text-slate-400">Manage guest-facing reply templates used by booking, events, and payment link emails.</p>
    </div>
    <a href="<?= base_url('admin/settings?tab=system') ?>" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
      Developer Settings
    </a>
  </div>

  <form action="<?= base_url('admin/settings/update') ?>" method="POST" class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <?= csrf_field() ?>
    <input type="hidden" name="settings_tab" value="emailtemplates" />

    <div class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 dark:border-slate-800 lg:flex-row lg:items-center lg:justify-between">
      <div>
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Template Library</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Preview first, then switch to edit mode when template text needs changes.</p>
      </div>
      <div class="inline-flex rounded-2xl border border-slate-200 bg-slate-50 p-1 dark:border-slate-700 dark:bg-slate-800">
        <button type="button" data-email-template-mode="preview" class="email-template-mode rounded-xl px-4 py-2 text-sm font-semibold transition">
          Preview
        </button>
        <button type="button" data-email-template-mode="edit" class="email-template-mode rounded-xl px-4 py-2 text-sm font-semibold transition">
          HTML / Text
        </button>
      </div>
    </div>

    <div class="p-6">
      <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs leading-6 text-amber-900 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-100">
        Available placeholders: <span class="font-semibold">{hotel_name}</span>, <span class="font-semibold">{guest_name}</span>, <span class="font-semibold">{hotel_contact}</span>, <span class="font-semibold">{room_name}</span>, <span class="font-semibold">{checkin}</span>, <span class="font-semibold">{checkout}</span>, <span class="font-semibold">{rooms_required}</span>, <span class="font-semibold">{guests}</span>, <span class="font-semibold">{event_type}</span>, <span class="font-semibold">{event_date}</span>, <span class="font-semibold">{amount}</span>, <span class="font-semibold">{payment_code}</span>, <span class="font-semibold">{payment_link}</span>.
      </div>

      <div data-email-template-preview-panel class="grid gap-6 xl:grid-cols-3">
        <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
          <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Booking Auto Reply</h3>
          <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
            <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Subject</p>
              <p data-template-preview-subject="booking" class="mt-1 text-sm font-bold text-slate-900 dark:text-white"></p>
            </div>
            <div data-template-preview-body="booking" class="min-h-[360px] space-y-4 px-4 py-5 text-sm leading-6 text-slate-700 dark:text-slate-200"></div>
          </div>
        </section>

        <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
          <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Event Auto Reply</h3>
          <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
            <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Subject</p>
              <p data-template-preview-subject="event" class="mt-1 text-sm font-bold text-slate-900 dark:text-white"></p>
            </div>
            <div data-template-preview-body="event" class="min-h-[360px] space-y-4 px-4 py-5 text-sm leading-6 text-slate-700 dark:text-slate-200"></div>
          </div>
        </section>

        <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
          <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Event Payment Link</h3>
          <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
            <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
              <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Subject</p>
              <p data-template-preview-subject="payment" class="mt-1 text-sm font-bold text-slate-900 dark:text-white"></p>
            </div>
            <div data-template-preview-body="payment" class="min-h-[360px] space-y-4 px-4 py-5 text-sm leading-6 text-slate-700 dark:text-slate-200"></div>
          </div>
        </section>
      </div>

      <div data-email-template-edit-panel class="hidden grid gap-6 xl:grid-cols-3">
        <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
          <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Booking Auto Reply</h3>
          <div class="mt-4 space-y-4">
            <div>
              <label for="email_template_booking_auto_reply_subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
              <input id="email_template_booking_auto_reply_subject" data-template-subject="booking" name="email_template_booking_auto_reply_subject" type="text" value="<?= esc($emailBookingAutoReplySubject) ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="email_template_booking_auto_reply_body" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Body</label>
              <textarea id="email_template_booking_auto_reply_body" data-template-body="booking" name="email_template_booking_auto_reply_body" rows="14" class="w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($emailBookingAutoReplyBody) ?></textarea>
            </div>
          </div>
        </section>

        <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
          <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Event Auto Reply</h3>
          <div class="mt-4 space-y-4">
            <div>
              <label for="email_template_event_auto_reply_subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
              <input id="email_template_event_auto_reply_subject" data-template-subject="event" name="email_template_event_auto_reply_subject" type="text" value="<?= esc($emailEventAutoReplySubject) ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="email_template_event_auto_reply_body" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Body</label>
              <textarea id="email_template_event_auto_reply_body" data-template-body="event" name="email_template_event_auto_reply_body" rows="14" class="w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($emailEventAutoReplyBody) ?></textarea>
            </div>
          </div>
        </section>

        <section class="rounded-3xl border border-slate-200/80 bg-slate-50/50 p-5 dark:border-slate-700 dark:bg-slate-800/30">
          <h3 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Event Payment Link</h3>
          <div class="mt-4 space-y-4">
            <div>
              <label for="email_template_event_payment_link_subject" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
              <input id="email_template_event_payment_link_subject" data-template-subject="payment" name="email_template_event_payment_link_subject" type="text" value="<?= esc($emailEventPaymentLinkSubject) ?>" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            </div>
            <div>
              <label for="email_template_event_payment_link_body" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Body</label>
              <textarea id="email_template_event_payment_link_body" data-template-body="payment" name="email_template_event_payment_link_body" rows="14" class="w-full resize-y rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white"><?= esc($emailEventPaymentLinkBody) ?></textarea>
            </div>
          </div>
        </section>
      </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 px-6 py-5 dark:border-slate-800">
      <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
        Save Email Templates
      </button>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const previewPanel = document.querySelector('[data-email-template-preview-panel]');
    const editPanel = document.querySelector('[data-email-template-edit-panel]');
    const modeButtons = Array.from(document.querySelectorAll('[data-email-template-mode]'));
    const sampleValues = {
      hotel_name: 'Hotel H Plus',
      guest_name: 'Raj Kumar',
      hotel_contact: '+91 92530 72122',
      room_name: 'Deluxe Room',
      checkin: '24 Jul 2026',
      checkout: '25 Jul 2026',
      rooms_required: '2',
      guests: '4',
      event_type: 'Wedding Reception',
      event_date: '31 Jul 2026',
      amount: 'INR 5,000.00',
      payment_code: 'EVP260724ABC',
      payment_link: 'https://hotelhplus.in/event-payment/EVP260724ABC'
    };

    function escapeHtml(value) {
      return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    function renderTemplate(value, asHtml) {
      let rendered = String(value || '');

      Object.keys(sampleValues).forEach(function (key) {
        const token = new RegExp('\\{' + key + '\\}', 'g');
        const replacement = key === 'payment_link' && asHtml
          ? '<a class="font-semibold text-[#C99A30] underline" href="' + escapeHtml(sampleValues[key]) + '">' + escapeHtml(sampleValues[key]) + '</a>'
          : escapeHtml(sampleValues[key]);
        rendered = rendered.replace(token, replacement);
      });

      if (!asHtml) {
        return rendered;
      }

      return rendered
        .split(/\n{2,}/)
        .map(function (paragraph) {
          return '<p>' + paragraph.replace(/\n/g, '<br>') + '</p>';
        })
        .join('');
    }

    function refreshPreviews() {
      ['booking', 'event', 'payment'].forEach(function (key) {
        const subjectInput = document.querySelector('[data-template-subject="' + key + '"]');
        const bodyInput = document.querySelector('[data-template-body="' + key + '"]');
        const subjectPreview = document.querySelector('[data-template-preview-subject="' + key + '"]');
        const bodyPreview = document.querySelector('[data-template-preview-body="' + key + '"]');

        if (subjectInput && subjectPreview) {
          subjectPreview.textContent = renderTemplate(subjectInput.value, false);
        }

        if (bodyInput && bodyPreview) {
          bodyPreview.innerHTML = renderTemplate(bodyInput.value, true);
        }
      });
    }

    function setMode(mode) {
      const isEdit = mode === 'edit';
      if (previewPanel) previewPanel.classList.toggle('hidden', isEdit);
      if (editPanel) editPanel.classList.toggle('hidden', !isEdit);

      modeButtons.forEach(function (button) {
        const active = button.getAttribute('data-email-template-mode') === mode;
        button.classList.toggle('bg-[#C99A30]', active);
        button.classList.toggle('text-slate-950', active);
        button.classList.toggle('shadow-sm', active);
        button.classList.toggle('text-slate-500', !active);
        button.classList.toggle('dark:text-slate-300', !active);
      });

      refreshPreviews();
    }

    document.querySelectorAll('[data-template-subject], [data-template-body]').forEach(function (field) {
      field.addEventListener('input', refreshPreviews);
    });

    modeButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        setMode(button.getAttribute('data-email-template-mode') || 'preview');
      });
    });

    setMode('preview');
  });
</script>
