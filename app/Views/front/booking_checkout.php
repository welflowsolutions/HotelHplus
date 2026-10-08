<?php
$bookingCode = $booking['booking_code'] ?? '';
$gatewayLabel = $gatewayLabel ?? 'Payment Gateway';
$checkoutReady = ! empty($checkoutReady);
$gatewayEnvironment = $gatewayEnvironment ?? 'production';
$roomName = $room['name'] ?? ($booking['room_type'] ?? 'Room');
$amount = number_format((float) ($booking['total_amount'] ?? 0), 2);
$currency = $booking['currency'] ?? 'INR';
$nights = (int) ($bookingNights ?? 1);
$roomsRequired = max(1, (int) ($booking['rooms_required'] ?? 1));
$checkoutSessionId = $checkoutSessionId ?? '';
$checkoutScriptUrl = $checkoutScriptUrl ?? '';
$checkoutAutoStart = ! empty($checkoutAutoStart);
$gatewayProvider = $gatewayProvider ?? 'cashfree';
$checkoutPayload = is_array($checkoutPayload ?? null) ? $checkoutPayload : [];
$razorpayCheckout = is_array($checkoutPayload['checkout'] ?? null) ? $checkoutPayload['checkout'] : [];
?>

<section class="page-hero thank-you-hero" aria-label="Secure room payment">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
    <div class="ornament-left mb-5"><span class="section-tag" style="color:#D4AE50"><?= esc($gatewayLabel) ?></span></div>
    <h1 class="font-display text-[clamp(2.8rem,6vw,5rem)] font-light text-white leading-[1.05] mb-5">
      Complete <em class="text-gold">Payment</em>
    </h1>
    <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-white/40">
        <li><a href="<?= base_url('/') ?>" class="hover:text-gold transition-colors">Home</a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li><a href="<?= base_url('rooms/' . ($room['slug'] ?? 'rooms')) ?>" class="hover:text-gold transition-colors"><?= esc($roomName) ?></a></li>
        <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
        <li class="text-gold">Payment</li>
      </ol>
    </nav>
  </div>
</section>

<section class="py-20 lg:py-24 bg-ivory">
  <div class="max-w-6xl mx-auto px-6 lg:px-10">
    <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-8 lg:gap-10">
      <div class="bg-white border border-gold/15 p-8 lg:p-10 reveal-left">
        <div class="ornament-left mb-5"><span class="section-tag">Booking Summary</span></div>
        <h2 class="font-display text-[clamp(2rem,4vw,3.4rem)] font-light text-ink leading-[1.08] mb-4">
          <?= esc($roomName) ?><br><em class="text-gold">Secure your stay</em>
        </h2>
        <p class="text-ink/60 text-[15px] leading-[1.9] mb-8">
          Your payment is received first, and the hotel team still reviews the booking for final confirmation based on availability.
        </p>

        <div class="grid sm:grid-cols-2 gap-4 mb-8">
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Booking Code</p>
            <p class="text-sm font-medium text-ink"><?= esc($bookingCode) ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Stay Dates</p>
            <p class="text-sm font-medium text-ink"><?= esc(date('d M Y', strtotime((string) $booking['checkin']))) ?> - <?= esc(date('d M Y', strtotime((string) $booking['checkout']))) ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Guests</p>
            <p class="text-sm font-medium text-ink"><?= esc((string) ($booking['guests'] ?? 1)) ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Rooms</p>
            <p class="text-sm font-medium text-ink"><?= esc((string) $roomsRequired) ?> Room<?= $roomsRequired > 1 ? 's' : '' ?></p>
          </div>
          <div class="rounded-2xl border border-gold/10 bg-ivory px-5 py-4">
            <p class="text-[10px] tracking-[0.16em] uppercase text-ink/35 mb-1">Duration</p>
            <p class="text-sm font-medium text-ink"><?= esc((string) $nights) ?> Night<?= $nights > 1 ? 's' : '' ?></p>
          </div>
        </div>

        <?php if (session('error')): ?>
          <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700 mb-6">
            <?= esc((string) session('error')) ?>
          </div>
        <?php endif; ?>

        <?php if (! $checkoutReady): ?>
          <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700 mb-6">
            We could not prepare the payment session just now. You can refresh this page and try again.
          </div>
        <?php else: ?>
          <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-700 mb-6">
            Secure checkout is ready. Use the button below to continue payment<?= $checkoutAutoStart ? ', or wait a moment for automatic launch' : '' ?>.
          </div>
        <?php endif; ?>

        <div class="flex flex-wrap gap-4">
          <button
            type="button"
            id="pay-now-button"
            class="btn-gold<?= $checkoutReady ? '' : ' opacity-60 pointer-events-none' ?>"
            <?= $checkoutReady ? '' : 'disabled' ?>
          >
            Pay <?= esc($currency) ?> <?= esc($amount) ?>
          </button>
          <a href="<?= base_url('rooms/' . ($room['slug'] ?? 'rooms')) ?>" class="btn-gold-outline">Back to Room</a>
        </div>
      </div>

      <div class="bg-ink p-8 lg:p-10 reveal-right">
        <p class="text-[10px] tracking-[0.24em] uppercase text-gold/70 mb-5">Payment Details</p>
        <div class="space-y-5">
          <div class="flex items-center justify-between border-b border-gold/10 pb-4">
            <span class="text-white/50 text-sm">Nightly rate</span>
            <span class="text-white text-sm"><?= esc($currency) ?> <?= esc(number_format((float) ($nightlyRate ?? 0), 2)) ?></span>
          </div>
          <div class="flex items-center justify-between border-b border-gold/10 pb-4">
            <span class="text-white/50 text-sm">Nights</span>
            <span class="text-white text-sm"><?= esc((string) $nights) ?></span>
          </div>
          <div class="flex items-center justify-between border-b border-gold/10 pb-4">
            <span class="text-white/50 text-sm">Rooms</span>
            <span class="text-white text-sm"><?= esc((string) $roomsRequired) ?></span>
          </div>
          <div class="flex items-center justify-between border-b border-gold/10 pb-4">
            <span class="text-white/50 text-sm">Gateway</span>
            <span class="text-white text-sm"><?= esc($gatewayLabel) ?></span>
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

        <div class="mt-8 pt-8 border-t border-gold/10">
          <p class="text-white/45 text-sm leading-[1.9]">
            After payment, you’ll return here and we’ll verify the transaction before showing the final booking message.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ($checkoutReady && $checkoutScriptUrl !== '' && $gatewayProvider === 'cashfree' && $checkoutSessionId !== ''): ?>
  <script src="<?= esc($checkoutScriptUrl) ?>"></script>
  <script>
    (function () {
      var checkoutButton = document.getElementById('pay-now-button');
      var paymentSessionId = <?= json_encode($checkoutSessionId, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      var environment = <?= json_encode($gatewayEnvironment, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

      if (typeof Cashfree !== 'function' || !checkoutButton) {
        return;
      }

      var cashfree = Cashfree({ mode: environment });
      var launchCheckout = function () {
        cashfree.checkout({
          paymentSessionId: paymentSessionId,
          redirectTarget: '_self'
        }).catch(function () {
          window.location.reload();
        });
      };

      checkoutButton.addEventListener('click', launchCheckout);
      <?php if ($checkoutAutoStart): ?>
      window.setTimeout(launchCheckout, 350);
      <?php endif; ?>
    }());
  </script>
<?php endif; ?>

<?php if ($checkoutReady && $checkoutScriptUrl !== '' && $gatewayProvider === 'razorpay' && ! empty($razorpayCheckout)): ?>
  <script src="<?= esc($checkoutScriptUrl) ?>"></script>
  <script>
    (function () {
      var checkoutButton = document.getElementById('pay-now-button');
      var checkoutOptions = <?= json_encode($razorpayCheckout, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      var verifyUrl = <?= json_encode(base_url('payment/razorpay/verify'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      var bookingCode = <?= json_encode($bookingCode, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      var csrfHeader = <?= json_encode(csrf_header(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      var csrfHash = <?= json_encode(csrf_hash(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

      if (typeof Razorpay !== 'function' || !checkoutButton) {
        return;
      }

      var setButtonBusy = function (busy) {
        checkoutButton.disabled = busy;
        checkoutButton.classList.toggle('opacity-60', busy);
      };

      var redirectToStatus = function () {
        window.location.href = <?= json_encode(base_url('booking/payment-status/' . $bookingCode), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      };

      var launchCheckout = function () {
        checkoutOptions.handler = function (response) {
          setButtonBusy(true);

          fetch(verifyUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              [csrfHeader]: csrfHash,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
              booking_code: bookingCode,
              razorpay_order_id: response.razorpay_order_id,
              razorpay_payment_id: response.razorpay_payment_id,
              razorpay_signature: response.razorpay_signature
            })
          })
            .then(function (res) { return res.json(); })
            .then(function (data) {
              window.location.href = data.redirect_url || <?= json_encode(base_url('booking/payment-status/' . $bookingCode . '?source=razorpay'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
            })
            .catch(redirectToStatus);
        };

        checkoutOptions.modal = checkoutOptions.modal || {};
        checkoutOptions.modal.ondismiss = redirectToStatus;

        new Razorpay(checkoutOptions).open();
      };

      checkoutButton.addEventListener('click', launchCheckout);
      <?php if ($checkoutAutoStart): ?>
      window.setTimeout(launchCheckout, 350);
      <?php endif; ?>
    }());
  </script>
<?php endif; ?>
