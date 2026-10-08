<div class="max-w-3xl space-y-5">

  <div class="flex items-center gap-3">
    <a href="<?= base_url('admin/trident') ?>"
       class="flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Trident Enquiry #<?= esc((string) $enq['id']) ?></h1>
      <p class="mt-0.5 text-xs text-gray-400"><?= ! empty($enq['created_at']) ? esc(date('d M Y, h:i A', strtotime($enq['created_at']))) : '—' ?></p>
    </div>
    <?php
      $statusTone = match ($enq['status'] ?? 'new') {
        'read' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-400',
        'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
        default => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
      };
    ?>
    <span class="ml-auto rounded-full px-3 py-1 text-xs font-medium <?= $statusTone ?>">
      <?= esc(ucfirst($enq['status'] ?? 'new')) ?>
    </span>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Enquiry Details</h2>
    <div class="grid gap-4 sm:grid-cols-2">
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Full Name</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($enq['name'] ?? '—') ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Event Type</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($enq['event_type'] ?? '—') ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Phone</p>
        <?php if (! empty($enq['phone'])): ?>
          <a href="tel:<?= esc($enq['phone']) ?>" class="text-sm font-medium text-gray-900 hover:text-[#F59E0B] dark:text-white"><?= esc($enq['phone']) ?></a>
        <?php else: ?>
          <p class="text-sm font-medium text-gray-900 dark:text-white">—</p>
        <?php endif; ?>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Email</p>
        <?php if (! empty($enq['email'])): ?>
          <a href="mailto:<?= esc($enq['email']) ?>" class="text-sm font-medium text-[#F59E0B] hover:underline"><?= esc($enq['email']) ?></a>
        <?php else: ?>
          <p class="text-sm font-medium text-gray-900 dark:text-white">—</p>
        <?php endif; ?>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Event Date</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= ! empty($enq['event_date']) ? esc(date('d M Y', strtotime($enq['event_date']))) : '—' ?></p>
      </div>
      <div>
        <p class="mb-0.5 text-xs text-gray-400">Expected Guests</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc((string) ($enq['guests'] ?? '—')) ?></p>
      </div>
    </div>
  </div>

  <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-900/30 dark:bg-amber-900/10 dark:text-amber-200">
    This is a guest enquiry record. Event cards shown on the frontend are managed separately in <a href="<?= base_url('admin/trident/events') ?>" class="font-semibold underline">Trident Event List</a>.
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Message</h2>
    <p class="whitespace-pre-line text-sm leading-relaxed text-gray-700 dark:text-gray-300"><?= esc($enq['message'] ?? 'No message shared.') ?></p>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</h2>
    <div class="flex flex-wrap gap-3">
      <?php if (! empty($enq['email'])): ?>
        <a href="mailto:<?= esc($enq['email']) ?>?subject=Trident Event Enquiry - <?= urlencode((string) app_setting('hotel_name', 'Hotel H Plus')) ?>"
           class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
           style="background:linear-gradient(to right,#F59E0B,#FB923C)">
          Email Guest
        </a>
      <?php endif; ?>

      <?php if (! empty($enq['phone'])): ?>
        <a href="https://wa.me/<?= esc(preg_replace('/[^0-9]/', '', (string) $enq['phone'])) ?>" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 rounded-xl bg-[#25D366] px-5 py-2.5 text-sm font-medium text-white transition-colors hover:bg-green-600">
          WhatsApp
        </a>
      <?php endif; ?>

      <?php if (service('adminPermissions')->canDeleteData()): ?>
        <form action="<?= base_url('admin/trident/' . $enq['id'] . '/delete') ?>" method="POST"
              data-confirm-delete-form
              data-delete-title="Delete Trident enquiry?"
              data-delete-message="This will permanently remove this Trident enquiry and cannot be undone."
              data-confirm-button="Delete Enquiry">
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
