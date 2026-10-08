<?php
$roomName = $room['name'] ?? ($booking['room_type'] ?? 'Room');
$statusTone = match ($paymentStatus ?? 'pending') {
    'paid' => ['badge' => 'bg-emerald-100 text-emerald-700', 'panel' => 'border-emerald-200 bg-emerald-50', 'icon' => 'fa-circle-check', 'iconColor' => 'text-emerald-500'],
    'failed' => ['badge' => 'bg-rose-100 text-rose-700', 'panel' => 'border-rose-200 bg-rose-50', 'icon' => 'fa-circle-xmark', 'iconColor' => 'text-rose-500'],
    'cancelled' => ['badge' => 'bg-rose-100 text-rose-700', 'panel' => 'border-rose-200 bg-rose-50', 'icon' => 'fa-ban', 'iconColor' => 'text-rose-500'],
    default => ['badge' => 'bg-amber-100 text-amber-700', 'panel' => 'border-amber-200 bg-amber-50', 'icon' => 'fa-clock', 'iconColor' => 'text-amber-500'],
};
$receiptNumber = $receiptData['receipt_number'] ?? ($booking['booking_code'] ?? '—');
$paymentReference = $receiptData['payment_reference'] ?? '—';
$amountPaid = ($receiptData['currency'] ?? 'INR') . ' ' . ($receiptData['amount'] ?? '0.00');
$bookingCode = (string) ($booking['booking_code'] ?? '');
$hotelPhone = (string) app_setting('hotel_phone', '+91 92530 72122');
$hotelWhatsapp = preg_replace('/[^0-9]/', '', (string) app_setting('hotel_whatsapp', $hotelPhone));
$supportMessage = urlencode('I need help with booking ' . $bookingCode . ' payment status.');
$checkoutUrl = base_url('booking/checkout/' . $bookingCode . '?retry=1');
$roomUrl = ! empty($room['slug']) ? base_url('rooms/' . $room['slug']) : base_url('rooms');
?>

<section class="page-hero thank-you-hero" aria-label="Booking payment status">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50">Booking Status</span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      <?= esc($statusLabel ?? 'Payment Status') ?>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li><a href="<?= base_url('rooms') ?>" class="hover:text-gold transition-colors">Rooms</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Payment Status</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-20 lg:py-24 bg-ivory">
  <div class="max-w-6xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-8 lg:gap-10 items-start">
      <div class="space-y-6 reveal-left">
        <div class="rounded-[28px] border <?= esc($statusTone['panel']) ?> p-8 lg:p-10">
          <div class="flex flex-wrap items-center gap-4 mb-5">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-white/80">
              <i class="fa-solid <?= esc($statusTone['icon']) ?> <?= esc($statusTone['iconColor']) ?> text-2xl"></i>
            </span>
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium <?= esc($statusTone['badge']) ?>">
              <?= esc($statusLabel ?? 'Payment Status') ?>
            </span>
            <?php if (($paymentStatus ?? '') === 'paid'): ?>
              <span class="text-xs text-ink/45">Booking reference created</span>
            <?php endif; ?>
          </div>

          <h2 class="font-display text-[clamp(2rem,4vw,3.4rem)] font-light text-ink leading-[1.08] mb-4">
            <?= esc($roomName) ?><br><em class="text-gold"><?= esc($statusLabel ?? 'Payment Status') ?></em>
          </h2>
          <p class="text-ink/65 text-[15px] leading-[1.9] mb-8">
            <?= ($paymentStatus ?? '') === 'paid'
                ? 'Your payment has been received successfully. Your booking reference has been created for hotel confirmation.'
                : esc($statusMessage ?? '') ?>
          </p>

          <div class="grid sm:grid-cols-2 gap-4">
            <div class="rounded-2xl border border-gold/10 bg-white/70 px-5 py-4">
              <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Receipt Number</p>
              <p class="text-sm font-medium text-ink"><?= esc($receiptNumber) ?></p>
            </div>
            <div class="rounded-2xl border border-gold/10 bg-white/70 px-5 py-4">
              <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Guest</p>
              <p class="text-sm font-medium text-ink"><?= esc($booking['name'] ?? '—') ?></p>
            </div>
            <div class="rounded-2xl border border-gold/10 bg-white/70 px-5 py-4">
              <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Payment Reference</p>
              <p class="text-sm font-medium text-ink break-all"><?= esc($paymentReference) ?></p>
            </div>
            <div class="rounded-2xl border border-gold/10 bg-white/70 px-5 py-4">
              <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Amount</p>
              <p class="text-sm font-medium text-ink"><?= esc($amountPaid) ?></p>
            </div>
          </div>

          <div class="mt-8 flex flex-wrap gap-4">
            <?php if (! empty($canRetry)): ?>
              <a href="<?= esc($checkoutUrl) ?>" class="btn-gold">Retry Payment</a>
            <?php endif; ?>
            <?php if (in_array(($paymentStatus ?? ''), ['pending', 'initiated'], true)): ?>
              <a href="<?= esc($checkoutUrl) ?>" class="btn-gold">Continue Payment</a>
            <?php endif; ?>
            <?php if (in_array(($paymentStatus ?? ''), ['pending', 'initiated'], true)): ?>
              <a href="<?= current_url() ?>" class="btn-dark">Refresh Status</a>
            <?php endif; ?>
            <?php if (($paymentStatus ?? '') === 'paid'): ?>
              <a href="<?= base_url('booking/receipt/' . $bookingCode) ?>" class="btn-dark">Download Receipt</a>
              <a href="tel:<?= esc($hotelPhone) ?>" class="btn-gold-outline">Call Hotel</a>
            <?php endif; ?>
            <?php if (($paymentStatus ?? '') !== 'paid'): ?>
              <a href="https://wa.me/<?= esc($hotelWhatsapp) ?>?text=<?= esc($supportMessage) ?>" target="_blank" rel="noopener" class="btn-gold-outline">WhatsApp Support</a>
              <a href="tel:<?= esc($hotelPhone) ?>" class="btn-gold-outline">Call Hotel</a>
            <?php endif; ?>
            <a href="<?= esc($roomUrl) ?>" class="btn-gold-outline">Back to Room</a>
          </div>
        </div>
      </div>

      <div class="space-y-6 reveal-right">
        <div class="rounded-[28px] border border-gold/12 bg-white p-8">
          <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <p class="text-[10px] tracking-[0.24em] uppercase text-gold/70">Booking Summary</p>
            <?php if (($paymentStatus ?? '') === 'paid'): ?>
              <span class="inline-flex rounded-full bg-gold/10 px-3 py-1 text-[10px] font-medium uppercase tracking-[0.12em] text-gold">Awaiting hotel confirmation</span>
            <?php endif; ?>
          </div>
          <div class="space-y-5">
            <div class="flex items-center justify-between border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm">Room</span>
              <span class="text-ink text-sm"><?= esc($roomName) ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm">Check-in</span>
              <span class="text-ink text-sm"><?= esc($receiptData['checkin'] ?? '—') ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm">Check-out</span>
              <span class="text-ink text-sm"><?= esc($receiptData['checkout'] ?? '—') ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm">Guests</span>
              <span class="text-ink text-sm"><?= esc($receiptData['guests'] ?? '1') ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm">Rooms</span>
              <span class="text-ink text-sm"><?= esc($receiptData['rooms_required'] ?? '1') ?></span>
            </div>
            <div class="flex items-center justify-between border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm">Nights</span>
              <span class="text-ink text-sm"><?= esc($receiptData['nights'] ?? '1') ?></span>
            </div>
            <div class="flex items-center justify-between pt-2">
              <span class="text-ink text-base">Total</span>
              <span class="font-display text-4xl font-light text-gold"><?= esc($amountPaid) ?></span>
            </div>
          </div>
        </div>

        <div class="rounded-[28px] border border-gold/12 bg-ink p-8">
          <p class="text-[10px] tracking-[0.24em] uppercase text-gold/70 mb-5">What This Means</p>
          <?php if (($paymentStatus ?? '') === 'paid'): ?>
            <p class="text-white/55 text-sm leading-[1.9]">
              Payment is complete. Our team will review the booking details and contact you if confirmation is needed. Please carry a valid photo ID at check-in.
            </p>
          <?php elseif (in_array(($paymentStatus ?? ''), ['failed', 'cancelled'], true)): ?>
            <p class="text-white/55 text-sm leading-[1.9]">
              No charge should be treated as successful for this booking yet. Retry payment using the same booking reference, or contact the hotel team for quick help.
            </p>
          <?php else: ?>
            <p class="text-white/55 text-sm leading-[1.9]">
              The payment result is still being checked. If you already completed payment, refresh this page after a moment. If checkout was closed, continue payment using the same booking reference.
            </p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
