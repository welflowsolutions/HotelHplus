<div class="space-y-5">

  <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bookings</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Room booking requests submitted from the website</p>
    </div>
    <div class="flex flex-wrap gap-2">
      <a href="<?= base_url('admin/bookings/calendar') ?>" class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">Calendar</a>
      <a href="<?= base_url('admin/bookings/create') ?>" class="rounded-xl bg-[#F59E0B] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#d88a06]">Manual Booking</a>
    </div>
  </div>

  <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-0 dark:border-gray-800">
    <?php
    $tabs = [
      'all' => 'All',
      'pending' => 'Pending',
      'confirmed' => 'Confirmed',
      'cancelled' => 'Cancelled',
    ];
    foreach ($tabs as $key => $label):
      $isActive = $status === $key;
    ?>
      <a href="?status=<?= $key ?>"
         class="border-b-2 px-4 py-2 text-sm font-medium -mb-px transition-colors <?= $isActive ? 'border-[#F59E0B] text-[#F59E0B]' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' ?>">
        <?= esc($label) ?>
        <span class="ml-1 rounded-full px-1.5 py-0.5 text-[10px] <?= $isActive ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' ?>">
          <?= esc((string) ($counts[$key] ?? 0)) ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="border-b border-gray-100 p-4 dark:border-gray-800">
      <input type="text" id="searchInput" placeholder="Search by guest, email, phone or room…"
             class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:w-80" />
    </div>

    <?php if (! empty($bookings)): ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table">
          <thead>
            <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50">
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Guest</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 md:table-cell">Room</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 lg:table-cell">Dates</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Rooms / Guests</th>
              <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 lg:table-cell">Payment</th>
              <th class="hidden px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 sm:table-cell">Date</th>
              <th class="px-5 py-3"></th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php foreach ($bookings as $booking): ?>
              <tr class="border-b border-gray-50 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800/50 <?= ($booking['status'] ?? 'pending') === 'pending' ? 'font-semibold' : '' ?>">
                <td class="px-5 py-3.5">
                  <div class="font-medium text-gray-900 dark:text-white"><?= esc($booking['name'] ?? '—') ?></div>
                  <div class="mt-0.5 text-xs text-gray-400"><?= esc($booking['email'] ?: ($booking['phone'] ?? '')) ?></div>
                </td>
                <td class="hidden px-5 py-3.5 text-gray-600 dark:text-gray-300 md:table-cell"><?= esc($booking['room_type'] ?? '—') ?></td>
                <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 lg:table-cell">
                  <?php if (! empty($booking['checkin']) && ! empty($booking['checkout'])): ?>
                    <?= esc(date('d M Y', strtotime($booking['checkin']))) ?> - <?= esc(date('d M Y', strtotime($booking['checkout']))) ?>
                  <?php else: ?>
                    —
                  <?php endif; ?>
                </td>
                <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 sm:table-cell">
                  <?= esc((string) ($booking['rooms_required'] ?? 1)) ?> room<?= (int) ($booking['rooms_required'] ?? 1) > 1 ? 's' : '' ?>
                  <div class="mt-0.5 text-xs text-gray-400"><?= esc((string) ($booking['guests'] ?? '—')) ?> guest<?= (int) ($booking['guests'] ?? 1) > 1 ? 's' : '' ?></div>
                </td>
                <td class="px-5 py-3.5">
                  <?php
                    $statusTone = match ($booking['status'] ?? 'pending') {
                      'confirmed' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                      'cancelled' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400',
                      default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
                    };
                  ?>
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $statusTone ?>">
                    <?= esc($booking['status'] ?? 'pending') ?>
                  </span>
                </td>
                <td class="hidden px-5 py-3.5 lg:table-cell">
                  <?php
                    $paymentStatus = $booking['payment_status'] ?? 'not_required';
                    $paymentTone = match ($paymentStatus) {
                      'paid' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                      'failed', 'cancelled' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400',
                      'pending', 'initiated' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
                      default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
                    };
                  ?>
                  <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?= $paymentTone ?>">
                    <?= esc(str_replace('_', ' ', $paymentStatus)) ?>
                  </span>
                </td>
                <td class="hidden px-5 py-3.5 text-xs text-gray-400 sm:table-cell"><?= ! empty($booking['created_at']) ? esc(date('d M Y', strtotime($booking['created_at']))) : '—' ?></td>
                <td class="px-5 py-3.5 text-right">
                  <a href="<?= base_url('admin/bookings/' . $booking['id']) ?>"
                     class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-amber-900/20 dark:hover:text-amber-400">
                    View
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="py-16 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">
          <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"/>
          </svg>
        </div>
        <p class="text-sm font-medium text-gray-900 dark:text-white">No booking requests found</p>
        <p class="mt-1 text-sm text-gray-400">Room booking requests from the website will appear here.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => initSearch('searchInput', 'tableBody'));
</script>
