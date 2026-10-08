<?php
$paymentCode = (string) ($eventPayment['payment_code'] ?? '');
$status = (string) ($eventPayment['payment_status'] ?? 'pending');
$tone = match ($status) {
    'paid' => ['panel' => 'border-emerald-200 bg-emerald-50', 'badge' => 'bg-emerald-100 text-emerald-700', 'icon' => 'fa-circle-check', 'iconColor' => 'text-emerald-500'],
    'failed', 'cancelled' => ['panel' => 'border-rose-200 bg-rose-50', 'badge' => 'bg-rose-100 text-rose-700', 'icon' => 'fa-circle-xmark', 'iconColor' => 'text-rose-500'],
    default => ['panel' => 'border-amber-200 bg-amber-50', 'badge' => 'bg-amber-100 text-amber-700', 'icon' => 'fa-clock', 'iconColor' => 'text-amber-500'],
};
$statusTitle = match ($status) {
    'paid' => 'Payment Received',
    'cancelled' => 'Payment Link Cancelled',
    'failed' => 'Payment Not Completed',
    default => 'Payment Pending',
};
$statusMessage = match ($status) {
    'paid' => 'Your event payment has been received successfully. Please keep this payment code for reference.',
    'cancelled' => 'This event payment link is no longer active. Please contact the hotel team for a fresh payment link or updated payment instructions.',
    'failed' => 'Your event payment could not be completed. You can retry securely or contact the hotel team for help.',
    default => 'Your event payment is not marked paid yet. If you completed payment, refresh after a moment or contact the hotel team.',
};
$amountPaid = ($receiptData['currency'] ?? 'INR') . ' ' . ($receiptData['amount'] ?? '0.00');
?>

<section class="page-hero thank-you-hero" aria-label="Event payment status">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50">Event Payment</span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Payment <em class="text-gold">Status</em>
    </h1>
  </div>
</section>

<section class="py-20 lg:py-24 bg-ivory">
  <div class="max-w-5xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-8">
      <div class="rounded-[28px] border <?= esc($tone['panel']) ?> p-8 lg:p-10">
        <div class="flex flex-wrap items-center gap-4 mb-5">
          <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-white/80">
            <i class="fa-solid <?= esc($tone['icon']) ?> <?= esc($tone['iconColor']) ?> text-2xl"></i>
          </span>
          <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium <?= esc($tone['badge']) ?>">
            <?= esc(ucwords(str_replace('_', ' ', $status))) ?>
          </span>
        </div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink leading-[1.08] mb-4">
          <?= esc($statusTitle) ?><br><em class="text-gold"><?= esc($amountPaid) ?></em>
        </h2>
        <p class="text-ink/65 text-[15px] leading-[1.9] mb-8">
          <?= esc($statusMessage) ?>
        </p>
        <div class="flex flex-wrap gap-4">
          <?php if ($status === 'paid'): ?>
            <a href="<?= base_url('event-payment/receipt/' . $paymentCode) ?>" class="btn-dark">Download Receipt</a>
          <?php elseif ($status !== 'cancelled'): ?>
            <a href="<?= base_url('event-payment/' . $paymentCode) ?>" class="btn-gold">Try Payment Again</a>
          <?php endif; ?>
          <a href="<?= base_url('events') ?>" class="btn-gold-outline">Back to Events</a>
        </div>
      </div>

      <div class="rounded-[28px] border border-gold/12 bg-white p-8">
        <p class="text-[10px] tracking-[0.24em] uppercase text-gold/70 mb-5">Payment Summary</p>
        <div class="space-y-5">
          <?php foreach ([
            'Payment Code' => $paymentCode,
            'Guest' => $eventPayment['customer_name'] ?? '—',
            'Event Date' => ! empty($eventPayment['event_date']) ? date('d M Y', strtotime((string) $eventPayment['event_date'])) : 'To be confirmed',
            'Guests' => $eventPayment['guests'] ?: '—',
            'Payment Ref.' => $receiptData['payment_reference'] ?? '—',
          ] as $label => $value): ?>
            <div class="flex items-center justify-between gap-4 border-b border-gold/10 pb-4">
              <span class="text-ink/45 text-sm"><?= esc($label) ?></span>
              <span class="text-ink text-sm text-right break-all"><?= esc((string) $value) ?></span>
            </div>
          <?php endforeach; ?>
          <div class="flex items-center justify-between pt-2">
            <span class="text-ink text-base">Total</span>
            <span class="font-display text-4xl font-light text-gold"><?= esc($amountPaid) ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
