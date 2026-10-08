<div class="max-w-3xl space-y-5">

  <div class="flex items-center gap-3">
    <a href="<?= base_url('admin/bookings') ?>"
       class="flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Booking #<?= esc((string) $booking['id']) ?></h1>
      <p class="mt-0.5 text-xs text-gray-400"><?= ! empty($booking['created_at']) ? esc(date('d M Y, h:i A', strtotime($booking['created_at']))) : '—' ?></p>
    </div>
    <?php
      $statusTone = match ($booking['status'] ?? 'pending') {
        'confirmed' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
        'cancelled' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400',
        default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
      };
    ?>
    <span class="ml-auto rounded-full px-3 py-1 text-xs font-medium <?= $statusTone ?>">
      <?= esc(ucfirst($booking['status'] ?? 'pending')) ?>
    </span>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Guest Details</h2>
    <div class="grid gap-4 sm:grid-cols-2">
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Full Name</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($booking['name'] ?? '—') ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Room Type</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($booking['room_type'] ?? '—') ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Phone</p>
        <?php if (! empty($booking['phone'])): ?>
          <a href="tel:<?= esc($booking['phone']) ?>" class="text-sm font-medium text-gray-900 hover:text-[#F59E0B] dark:text-white"><?= esc($booking['phone']) ?></a>
        <?php else: ?>
          <p class="text-sm font-medium text-gray-900 dark:text-white">—</p>
        <?php endif; ?>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Email</p>
        <?php if (! empty($booking['email'])): ?>
          <a href="mailto:<?= esc($booking['email']) ?>" class="text-sm font-medium text-[#F59E0B] hover:underline"><?= esc($booking['email']) ?></a>
        <?php else: ?>
          <p class="text-sm font-medium text-gray-900 dark:text-white">—</p>
        <?php endif; ?>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Check-in</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= ! empty($booking['checkin']) ? esc(date('d M Y', strtotime($booking['checkin']))) : '—' ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Check-out</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= ! empty($booking['checkout']) ? esc(date('d M Y', strtotime($booking['checkout']))) : '—' ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Guests</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc((string) ($booking['guests'] ?? '—')) ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Rooms Required</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc((string) ($booking['rooms_required'] ?? 1)) ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Total Amount</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc((string) ($booking['currency'] ?? 'INR')) ?> <?= esc(number_format((float) ($booking['total_amount'] ?? 0), 2)) ?></p>
      </div>
    </div>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Payment Details</h2>
    <div class="grid gap-4 sm:grid-cols-2">
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Booking Code</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($booking['booking_code'] ?? '—') ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Gateway</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($booking['payment_gateway'] ?: 'Request Based') ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Payment Status</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc(ucwords(str_replace('_', ' ', (string) ($booking['payment_status'] ?? 'not_required')))) ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Payment Flow</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= ! empty($booking['payment_required']) ? 'Online Gateway' : 'Request Based' ?></p>
      </div>
    </div>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Notes</h2>
    <p class="whitespace-pre-line text-sm leading-relaxed text-gray-700 dark:text-gray-300"><?= esc($booking['notes'] ?? 'No notes shared.') ?></p>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</h2>
    <div class="flex flex-wrap gap-3">
      <?php if (! empty($refundLock)): ?>
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-900/50 dark:bg-amber-900/15 dark:text-amber-300">
          Booking status is locked because a refund has already been initiated. It must remain cancelled.
        </div>
      <?php else: ?>
        <form action="<?= base_url('admin/bookings/' . $booking['id'] . '/status') ?>" method="POST" class="flex flex-wrap items-center gap-3">
          <?= csrf_field() ?>
          <select name="status"
                  class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            <?php foreach (['pending', 'confirmed', 'cancelled'] as $statusOption): ?>
              <option value="<?= $statusOption ?>" <?= ($booking['status'] ?? 'pending') === $statusOption ? 'selected' : '' ?>><?= ucfirst($statusOption) ?></option>
            <?php endforeach; ?>
          </select>
          <button type="submit"
                  class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
                  style="background:linear-gradient(to right,#F59E0B,#FB923C)">
            Update Status
          </button>
        </form>
      <?php endif; ?>

      <?php if (! empty($booking['email'])): ?>
        <a href="mailto:<?= esc($booking['email']) ?>?subject=Booking Update - <?= urlencode((string) app_setting('hotel_name', 'Hotel H Plus')) ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">
          Email Guest
        </a>
      <?php endif; ?>

      <?php if (service('adminPermissions')->canDeleteData()): ?>
        <form action="<?= base_url('admin/bookings/' . $booking['id'] . '/delete') ?>" method="POST"
              data-confirm-delete-form
              data-delete-title="Delete booking?"
              data-delete-message="This will permanently remove this booking if it has no paid or refunded transaction."
              data-confirm-button="Delete Booking">
          <?= csrf_field() ?>
          <button type="submit"
                  class="inline-flex items-center gap-2 rounded-xl border border-red-200 px-5 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20">
            Delete
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
