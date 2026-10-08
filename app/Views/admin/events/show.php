<div class="w-full space-y-5">
  <div class="flex flex-wrap items-start gap-3">
    <a href="<?= base_url('admin/events') ?>"
       class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Event #<?= esc((string) $enquiry['id']) ?></h1>
      <p class="mt-1 text-sm text-gray-400"><?= ! empty($enquiry['created_at']) ? esc(date('d M Y, h:i A', strtotime($enquiry['created_at']))) : '—' ?></p>
    </div>
    <?php
      $statusTone = match ($enquiry['status'] ?? 'new') {
        'read' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-400',
        'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
        'confirmed' => 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400',
        'cancelled' => 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400',
        default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
      };
      $sourceTone = ($enquiry['source'] ?? 'public') === 'admin'
        ? 'bg-violet-50 text-violet-700 dark:bg-violet-900/20 dark:text-violet-300'
        : 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-300';
    ?>
    <div class="ml-auto flex flex-wrap gap-2">
      <span class="rounded-full px-3 py-1 text-xs font-medium <?= $sourceTone ?>">
        <?= esc(($enquiry['source'] ?? 'public') === 'admin' ? 'Offline' : 'Online') ?>
      </span>
      <span class="rounded-full px-3 py-1 text-xs font-medium <?= $statusTone ?>">
        <?= esc(ucwords(str_replace('_', ' ', (string) ($enquiry['status'] ?? 'new')))) ?>
      </span>
    </div>
  </div>

  <?php if (($enquiry['source'] ?? 'public') === 'public'): ?>
    <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-3.5 text-sm text-amber-800 dark:border-amber-900/30 dark:bg-amber-900/10 dark:text-amber-200">
      This enquiry came from the public <a href="<?= base_url('events') ?>" class="font-semibold underline" target="_blank" rel="noopener">Events page</a>. Confirm it when the guest finalizes the event.
    </div>
  <?php else: ?>
    <div class="rounded-xl border border-violet-200 bg-violet-50 px-5 py-3.5 text-sm text-violet-800 dark:border-violet-900/30 dark:bg-violet-900/10 dark:text-violet-200">
      This event was created manually by admin for offline coordination.
    </div>
  <?php endif; ?>

  <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
    <section class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Event Details</h2>
      </div>
      <div class="grid gap-px bg-gray-100 dark:bg-gray-800 sm:grid-cols-2 lg:grid-cols-3">
        <?php
          $detailItems = [
            ['Full Name', $enquiry['name'] ?? '—', null],
            ['Event Type', $enquiry['event_type'] ?? '—', null],
            ['Phone', $enquiry['phone'] ?? '—', ! empty($enquiry['phone']) ? 'tel:' . $enquiry['phone'] : null],
            ['Email', $enquiry['email'] ?? '—', ! empty($enquiry['email']) ? 'mailto:' . $enquiry['email'] : null],
            ['Preferred Date', ! empty($enquiry['event_date']) ? date('d M Y', strtotime($enquiry['event_date'])) : '—', null],
            ['Expected Guests', (string) ($enquiry['guests'] ?? '—'), null],
            ['Source', ($enquiry['source'] ?? 'public') === 'admin' ? 'Offline / Admin' : 'Online Enquiry', null],
          ];
        ?>
        <?php foreach ($detailItems as [$label, $value, $href]): ?>
          <div class="bg-white px-6 py-5 dark:bg-gray-900">
            <p class="text-xs font-medium text-gray-400"><?= esc($label) ?></p>
            <?php if ($href): ?>
              <a href="<?= esc($href) ?>" class="mt-1 block break-words text-sm font-semibold text-[#F59E0B] hover:underline"><?= esc((string) $value) ?></a>
            <?php else: ?>
              <p class="mt-1 break-words text-sm font-semibold text-gray-900 dark:text-white"><?= esc((string) $value) ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="border-t border-gray-100 px-6 py-5 dark:border-gray-800">
        <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Message</h2>
        <p class="whitespace-pre-line text-sm leading-relaxed text-gray-700 dark:text-gray-300"><?= esc($enquiry['message'] ?? 'No message shared.') ?></p>
      </div>
    </section>

    <aside class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Quick Actions</h2>
      <div class="space-y-3">
        <a href="<?= base_url('admin/events/' . $enquiry['id'] . '/edit') ?>"
           class="flex w-full items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
          Edit Event
        </a>

        <form action="<?= base_url('admin/events/' . $enquiry['id'] . '/status') ?>" method="POST" class="rounded-xl border border-gray-100 p-3 dark:border-gray-800">
          <?= csrf_field() ?>
          <label for="quick_status" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-400">Status</label>
          <div class="flex gap-2">
            <select id="quick_status" name="status"
                    class="min-w-0 flex-1 rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
              <?php foreach (['read' => 'Follow-up', 'replied' => 'Quoted', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled'] as $value => $label): ?>
                <option value="<?= esc($value) ?>" <?= ($enquiry['status'] ?? '') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="rounded-lg bg-[#F59E0B] px-3 py-2 text-xs font-semibold text-white hover:bg-[#d88a06]">
              Save
            </button>
          </div>
        </form>

        <?php if (! empty($enquiry['email'])): ?>
          <a href="mailto:<?= esc($enquiry['email']) ?>?subject=Event Enquiry - <?= urlencode((string) app_setting('hotel_name', 'Hotel H Plus')) ?>"
             class="flex w-full items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold text-white transition-shadow hover:shadow-lg"
             style="background:linear-gradient(to right,#F59E0B,#FB923C)">
            Email Guest
          </a>
        <?php endif; ?>

        <?php if (! empty($enquiry['phone'])): ?>
          <a href="https://wa.me/<?= esc(preg_replace('/[^0-9]/', '', (string) $enquiry['phone'])) ?>" target="_blank" rel="noopener"
             class="flex w-full items-center justify-center rounded-xl bg-[#25D366] px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-green-600">
            WhatsApp
          </a>
        <?php endif; ?>

        <?php if (service('adminPermissions')->canDeleteData()): ?>
          <form action="<?= base_url('admin/events/' . $enquiry['id'] . '/delete') ?>" method="POST"
                data-confirm-delete-form
                data-delete-title="Delete event enquiry?"
                data-delete-message="This will permanently remove this event enquiry and cannot be undone."
                data-confirm-button="Delete Enquiry">
            <?= csrf_field() ?>
            <button type="submit"
                    class="flex w-full items-center justify-center rounded-xl border border-red-200 px-5 py-3 text-sm font-semibold text-red-600 transition-colors hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20">
              Delete Enquiry
            </button>
          </form>
        <?php endif; ?>
      </div>
    </aside>
  </div>

  <?php $paymentSummary = $paymentSummary ?? []; ?>
  <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 dark:border-emerald-900/30 dark:bg-emerald-900/10">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700/70 dark:text-emerald-200/70">Advance Received</p>
      <p class="mt-2 text-2xl font-bold text-emerald-800 dark:text-emerald-200">INR <?= esc(number_format((float) ($paymentSummary['paid_amount'] ?? 0), 2)) ?></p>
      <p class="mt-1 text-xs text-emerald-700/70 dark:text-emerald-100/70"><?= esc((string) ($paymentSummary['paid_count'] ?? 0)) ?> paid record<?= (int) ($paymentSummary['paid_count'] ?? 0) === 1 ? '' : 's' ?></p>
    </div>
    <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 dark:border-amber-900/30 dark:bg-amber-900/10">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-700/70 dark:text-amber-200/70">Pending Links</p>
      <p class="mt-2 text-2xl font-bold text-amber-800 dark:text-amber-200">INR <?= esc(number_format((float) ($paymentSummary['pending_amount'] ?? 0), 2)) ?></p>
      <p class="mt-1 text-xs text-amber-700/70 dark:text-amber-100/70"><?= esc((string) ($paymentSummary['pending_count'] ?? 0)) ?> active link<?= (int) ($paymentSummary['pending_count'] ?? 0) === 1 ? '' : 's' ?></p>
    </div>
    <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 dark:border-red-900/30 dark:bg-red-900/10">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-700/70 dark:text-red-200/70">Cancelled Links</p>
      <p class="mt-2 text-2xl font-bold text-red-800 dark:text-red-200"><?= esc((string) ($paymentSummary['cancelled_count'] ?? 0)) ?></p>
      <p class="mt-1 text-xs text-red-700/70 dark:text-red-100/70">INR <?= esc(number_format((float) ($paymentSummary['cancelled_amount'] ?? 0), 2)) ?> cancelled</p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white px-5 py-4 dark:border-gray-800 dark:bg-gray-900">
      <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">Payment Records</p>
      <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white"><?= esc((string) ($paymentSummary['total_count'] ?? 0)) ?></p>
      <p class="mt-1 text-xs text-gray-400">Online links and manual advances</p>
    </div>
  </section>

  <section class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="flex flex-wrap items-start justify-between gap-3 border-b border-gray-100 px-6 py-5 dark:border-gray-800">
      <div>
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Event Payments</h2>
        <p class="mt-1 text-xs text-gray-400">Create an online link or record an offline advance without changing the enquiry flow.</p>
      </div>
      <?php if (! empty($eventPayments)): ?>
        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
          <?= count($eventPayments) ?> record<?= count($eventPayments) === 1 ? '' : 's' ?>
        </span>
      <?php endif; ?>
    </div>

    <div class="grid gap-px bg-gray-100 dark:bg-gray-800 xl:grid-cols-2">
      <div class="bg-white p-6 dark:bg-gray-900">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Online Payment Link</h3>
        <p class="mt-1 text-sm text-gray-400">Send Razorpay/Cashfree checkout to the guest.</p>
        <form action="<?= base_url('admin/events/' . $enquiry['id'] . '/payment-link') ?>" method="POST" class="mt-5 space-y-4">
          <?= csrf_field() ?>
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label for="amount" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
              <input id="amount" name="amount" type="number" min="1" step="0.01" value="<?= old('amount') ?>" placeholder="Token or advance"
                     class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div>
              <label for="notes" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Internal Note</label>
              <input id="notes" name="notes" type="text" value="<?= old('notes') ?>" placeholder="Wedding advance"
                     class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
          </div>
          <button type="submit"
                  class="inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold text-white transition-shadow hover:shadow-lg"
                  style="background:linear-gradient(to right,#F59E0B,#FB923C)">
            Create Payment Link
          </button>
        </form>
      </div>

      <div class="bg-white p-6 dark:bg-gray-900">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Manual Advance</h3>
        <p class="mt-1 text-sm text-gray-400">Record cash, UPI, or bank transfer already received.</p>
        <form action="<?= base_url('admin/events/' . $enquiry['id'] . '/manual-payment') ?>" method="POST" class="mt-5 space-y-4">
          <?= csrf_field() ?>
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label for="manual_amount" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
              <input id="manual_amount" name="manual_amount" type="number" min="1" step="0.01" value="<?= old('manual_amount') ?>" placeholder="Advance amount"
                     class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div>
              <label for="manual_method" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Method</label>
              <select id="manual_method" name="manual_method"
                      class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <?php foreach (['cash' => 'Cash', 'gpay' => 'GPay', 'phonepe' => 'PhonePe', 'bank_transfer' => 'Bank Transfer', 'other' => 'Other'] as $value => $label): ?>
                  <option value="<?= esc($value) ?>" <?= old('manual_method', 'cash') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label for="manual_received_on" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Received On</label>
              <input id="manual_received_on" name="manual_received_on" type="date" value="<?= old('manual_received_on', date('Y-m-d')) ?>"
                     class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div>
              <label for="manual_reference" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Reference / UTR</label>
              <input id="manual_reference" name="manual_reference" type="text" value="<?= old('manual_reference') ?>" placeholder="Optional reference"
                     class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
          </div>
          <div>
            <label for="manual_notes" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Internal Note</label>
            <input id="manual_notes" name="manual_notes" type="text" value="<?= old('manual_notes') ?>" placeholder="Example: Advance received after call"
                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
          </div>
          <button type="submit"
                  class="inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold text-white transition-shadow hover:shadow-lg"
                  style="background:linear-gradient(to right,#F59E0B,#FB923C)">
            Record Manual Advance
          </button>
        </form>
      </div>
    </div>

    <div class="px-6 py-5">
      <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Payment Records</h3>
      <?php if (! empty($eventPayments)): ?>
        <div class="grid gap-3 lg:grid-cols-2">
          <?php foreach ($eventPayments as $payment): ?>
            <?php
              $link = base_url('event-payment/' . $payment['payment_code']);
              $isManual = ($payment['payment_gateway'] ?? '') === 'manual';
              $isPaid = ($payment['payment_status'] ?? '') === 'paid';
              $paymentStatus = (string) ($payment['payment_status'] ?? 'created');
              $canShareLink = ! $isManual && ! in_array($paymentStatus, ['paid', 'cancelled'], true);
              $canCancelLink = ! $isManual && in_array($paymentStatus, ['created', 'pending'], true);
              $statusTone = match ($paymentStatus) {
                'paid' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                'cancelled', 'failed' => 'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400',
                default => 'bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
              };
              $shareMessage = 'Hello ' . trim((string) ($payment['customer_name'] ?? $enquiry['name'] ?? '')) . ', please use this secure event payment link: ' . $link;
              $emailSubject = 'Event Payment Link - ' . (string) app_setting('hotel_name', 'Hotel H Plus');
              $emailBody = $shareMessage . "\n\nAmount: INR " . number_format((float) ($payment['amount'] ?? 0), 2);
              $shareEmail = trim((string) (($payment['customer_email'] ?? '') ?: ($enquiry['email'] ?? '')));
              $phoneDigits = preg_replace('/[^0-9]/', '', (string) ($payment['customer_phone'] ?? $enquiry['phone'] ?? ''));
              if (strlen($phoneDigits) === 10) {
                $phoneDigits = '91' . $phoneDigits;
              }
            ?>
            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-950/40">
              <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                  <p class="text-base font-semibold text-gray-900 dark:text-white">INR <?= esc(number_format((float) ($payment['amount'] ?? 0), 2)) ?></p>
                  <p class="mt-1 break-all text-xs text-gray-400"><?= esc($payment['payment_code'] ?? '') ?></p>
                </div>
                <span class="rounded-full px-2.5 py-1 text-xs font-medium <?= $statusTone ?>">
                  <?= esc(ucwords(str_replace('_', ' ', $paymentStatus))) ?>
                </span>
              </div>
              <div class="mt-3 grid gap-2 text-xs text-gray-400 sm:grid-cols-2">
                <p>Type: <?= esc($isManual ? 'Manual' : 'Online Link') ?></p>
                <p>Method: <?= esc($isManual ? ucwords(str_replace('_', ' ', (string) ($payment['payment_method'] ?? 'Manual'))) : ucfirst((string) ($payment['payment_gateway'] ?? 'Gateway'))) ?></p>
                <?php if ($isManual): ?>
                  <p class="sm:col-span-2">Reference: <?= esc((string) ($payment['payment_reference'] ?: '—')) ?></p>
                <?php endif; ?>
              </div>
              <div class="mt-4 flex flex-wrap gap-2">
                <?php if ($isPaid): ?>
                  <a href="<?= base_url('event-payment/receipt/' . $payment['payment_code']) ?>" target="_blank" rel="noopener"
                     class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300">
                    Receipt
                  </a>
                <?php elseif ($paymentStatus === 'cancelled'): ?>
                  <a href="<?= base_url('event-payment/status/' . $payment['payment_code']) ?>" target="_blank" rel="noopener"
                     class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300">
                    View Status
                  </a>
                <?php elseif ($canShareLink): ?>
                  <a href="<?= esc($link) ?>" target="_blank" rel="noopener"
                     class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300">
                    Open Link
                  </a>
                  <?php if ($phoneDigits !== ''): ?>
                    <a href="https://wa.me/<?= esc($phoneDigits) ?>?text=<?= rawurlencode($shareMessage) ?>" target="_blank" rel="noopener"
                       class="rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-300">
                      WhatsApp
                    </a>
                  <?php endif; ?>
                  <?php if ($shareEmail !== ''): ?>
                    <a href="mailto:<?= esc($shareEmail) ?>?subject=<?= rawurlencode($emailSubject) ?>&body=<?= rawurlencode($emailBody) ?>"
                       class="rounded-lg bg-sky-100 px-3 py-1.5 text-xs font-medium text-sky-700 hover:bg-sky-200 dark:bg-sky-900/20 dark:text-sky-300">
                      Email
                    </a>
                  <?php endif; ?>
                  <button type="button" data-copy-event-payment-link="<?= esc($link) ?>"
                          class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300">
                    Copy Link
                  </button>
                <?php endif; ?>
                <?php if ($canCancelLink): ?>
                  <form action="<?= base_url('admin/events/' . $enquiry['id'] . '/payments/' . $payment['id'] . '/cancel') ?>" method="POST"
                        data-confirm-action-form
                        data-confirm-title="Cancel payment link?"
                        data-confirm-message="This will stop the guest from using this payment link. Paid and manual records will stay untouched."
                        data-confirm-button="Cancel Link">
                    <?= csrf_field() ?>
                    <button type="submit"
                            class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20">
                      Cancel Link
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="rounded-xl border border-dashed border-gray-200 px-5 py-8 text-center dark:border-gray-800">
          <p class="text-sm font-medium text-gray-700 dark:text-gray-200">No payment records yet</p>
          <p class="mt-1 text-xs text-gray-400">Create a link or record a manual advance when the guest confirms.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>

<script>
  document.addEventListener('click', function (event) {
    const button = event.target.closest('[data-copy-event-payment-link]');
    if (!button) return;

    const link = button.dataset.copyEventPaymentLink || '';
    if (!link) return;

    const originalText = button.textContent;
    const setCopied = function () {
      button.textContent = 'Copied';
      window.setTimeout(function () {
        button.textContent = originalText;
      }, 1600);
    };

    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(link).then(setCopied).catch(function () {
        const field = document.createElement('textarea');
        field.value = link;
        field.setAttribute('readonly', 'readonly');
        field.style.position = 'fixed';
        field.style.opacity = '0';
        document.body.appendChild(field);
        field.select();
        document.execCommand('copy');
        field.remove();
        setCopied();
      });
      return;
    }

    const field = document.createElement('textarea');
    field.value = link;
    field.setAttribute('readonly', 'readonly');
    field.style.position = 'fixed';
    field.style.opacity = '0';
    document.body.appendChild(field);
    field.select();
    document.execCommand('copy');
    field.remove();
    setCopied();
  });
</script>
