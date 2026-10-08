<?php
$paymentCode = (string) ($eventPayment['payment_code'] ?? '');
$amount = number_format((float) ($eventPayment['amount'] ?? 0), 2);
$currency = (string) ($eventPayment['currency'] ?? 'INR');
$checkoutReady = ! empty($checkoutReady);
$gatewayProvider = $gatewayProvider ?? 'cashfree';
$gatewayEnvironment = $gatewayEnvironment ?? 'production';
$checkoutSessionId = $checkoutSessionId ?? '';
$checkoutScriptUrl = $checkoutScriptUrl ?? '';
$checkoutPayload = is_array($checkoutPayload ?? null) ? $checkoutPayload : [];
$razorpayCheckout = is_array($checkoutPayload['checkout'] ?? null) ? $checkoutPayload['checkout'] : [];
?>

<section class="page-hero thank-you-hero" aria-label="Secure event payment">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($gatewayLabel ?? 'Payment Gateway') ?></span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Complete <em class="text-gold">Event Payment</em>
    </h1>
  </div>
</section>

<section class="py-20 lg:py-24 bg-ivory">
  <div class="max-w-5xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-8">
      <div class="bg-white border border-gold/15 p-8 lg:p-10">
        <div class="ornament-left mb-5"><span class="section-tag">Event Payment</span></div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.2rem)] font-light text-ink leading-[1.08] mb-4">
          <?= esc($eventPayment['event_type'] ?? 'Event') ?><br><em class="text-gold">Payment Link</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          This payment link was created by the hotel team after reviewing your event enquiry.
        </p>

        <div class="grid sm:grid-cols-2 gap-4 mb-8">
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Payment Code</p>
            <p class="text-sm font-medium text-ink"><?= esc($paymentCode) ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Guest</p>
            <p class="text-sm font-medium text-ink"><?= esc($eventPayment['customer_name'] ?? 'Guest') ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Event Date</p>
            <p class="text-sm font-medium text-ink"><?= ! empty($eventPayment['event_date']) ? esc(date('d M Y', strtotime((string) $eventPayment['event_date']))) : 'To be confirmed' ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Guests</p>
            <p class="text-sm font-medium text-ink"><?= esc($eventPayment['guests'] ?: '—') ?></p>
          </div>
        </div>

        <?php if (! $checkoutReady): ?>
          <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700 mb-6">
            We could not prepare the payment session just now. Please contact the hotel team.
          </div>
        <?php endif; ?>

        <button type="button" id="event-pay-now-button" class="btn-gold<?= $checkoutReady ? '' : ' opacity-60 pointer-events-none' ?>" <?= $checkoutReady ? '' : 'disabled' ?>>
          Pay <?= esc($currency) ?> <?= esc($amount) ?>
        </button>
      </div>

      <div class="bg-ink p-8 lg:p-10">
        <p class="text-[10px] tracking-[0.24em] uppercase text-gold/70 mb-5">Payment Details</p>
        <div class="space-y-5">
          <div class="flex items-center justify-between border-b border-gold/10 pb-4">
            <span class="text-white/50 text-sm">Gateway</span>
            <span class="text-white text-sm"><?= esc($gatewayLabel ?? 'Payment Gateway') ?></span>
          </div>
          <div class="flex items-center justify-between border-b border-gold/10 pb-4">
            <span class="text-white/50 text-sm">Mode</span>
            <span class="text-white text-sm capitalize"><?= esc($gatewayEnvironment) ?></span>
          </div>
          <div class="flex items-center justify-between pt-2">
            <span class="text-white text-base">Total payable</span>
            <span class="font-display text-4xl font-light text-gold"><?= esc($currency) ?> <?= esc($amount) ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ($checkoutReady && $checkoutScriptUrl !== '' && $gatewayProvider === 'cashfree' && $checkoutSessionId !== ''): ?>
  <script src="<?= esc($checkoutScriptUrl) ?>"></script>
  <script>
    (function () {
      var button = document.getElementById('event-pay-now-button');
      if (typeof Cashfree !== 'function' || !button) return;
      var cashfree = Cashfree({ mode: <?= json_encode($gatewayEnvironment) ?> });
      button.addEventListener('click', function () {
        cashfree.checkout({ paymentSessionId: <?= json_encode($checkoutSessionId) ?>, redirectTarget: '_self' }).catch(function () {
          window.location.reload();
        });
      });
    }());
  </script>
<?php endif; ?>

<?php if ($checkoutReady && $checkoutScriptUrl !== '' && $gatewayProvider === 'razorpay' && ! empty($razorpayCheckout)): ?>
  <script src="<?= esc($checkoutScriptUrl) ?>"></script>
  <script>
    (function () {
      var button = document.getElementById('event-pay-now-button');
      var options = <?= json_encode($razorpayCheckout, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      if (typeof Razorpay !== 'function' || !button) return;
      button.addEventListener('click', function () {
        options.handler = function (response) {
          fetch(<?= json_encode(base_url('event-payment/razorpay/verify')) ?>, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              <?= json_encode(csrf_header()) ?>: <?= json_encode(csrf_hash()) ?>,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
              payment_code: <?= json_encode($paymentCode) ?>,
              razorpay_order_id: response.razorpay_order_id,
              razorpay_payment_id: response.razorpay_payment_id,
              razorpay_signature: response.razorpay_signature
            })
          }).then(function (res) { return res.json(); }).then(function (data) {
            window.location.href = data.redirect_url || <?= json_encode(base_url('event-payment/status/' . $paymentCode)) ?>;
          }).catch(function () {
            window.location.href = <?= json_encode(base_url('event-payment/status/' . $paymentCode)) ?>;
          });
        };
        options.modal = options.modal || {};
        options.modal.ondismiss = function () {
          window.location.href = <?= json_encode(base_url('event-payment/status/' . $paymentCode)) ?>;
        };
        new Razorpay(options).open();
      });
    }());
  </script>
<?php endif; ?>
