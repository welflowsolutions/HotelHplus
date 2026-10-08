<div class="space-y-5">

  <div class="flex items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Trident Events</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400"><?= count($events) ?> event<?= count($events) !== 1 ? 's' : '' ?> configured for the frontend Trident page cards and enquiry type sync</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="<?= base_url('admin/settings?tab=tridentpage') ?>"
         class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        Trident Page Settings
      </a>
      <a href="<?= base_url('admin/trident') ?>"
         class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        View Enquiries
      </a>
      <a href="<?= base_url('admin/trident/events/create') ?>"
         class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
         style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Event
      </a>
    </div>
  </div>

  <?php if (empty($events)): ?>
    <div class="rounded-xl border border-dashed border-gray-200 bg-white p-16 text-center dark:border-gray-700 dark:bg-gray-900">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">
        <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4M7 4h10l2 5-7 8-7-8 2-5Zm0 0 5 13 5-13"/>
        </svg>
      </div>
      <p class="font-medium text-gray-900 dark:text-white">No Trident events yet</p>
      <p class="mt-1 mb-5 text-sm text-gray-400">These items are shown on the frontend event list and also feed the enquiry event-type options.</p>
      <div class="flex items-center justify-center gap-3 flex-wrap">
        <form action="<?= base_url('admin/trident/events/import-starter') ?>" method="POST">
          <?= csrf_field() ?>
          <button type="submit"
                  class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-5 py-2.5 text-sm font-medium text-amber-700 transition-colors hover:bg-amber-100">
            Import Starter Events
          </button>
        </form>
        <a href="<?= base_url('admin/trident/events/create') ?>"
           class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-medium text-white"
           style="background:linear-gradient(to right,#F59E0B,#FB923C)">
          Add First Event
        </a>
      </div>
    </div>
  <?php else: ?>
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
      <?php foreach ($events as $event): ?>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
          <div class="border-b border-gray-100 p-5 dark:border-gray-800">
            <div class="mb-4 flex items-start justify-between gap-3">
              <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-amber-200 bg-amber-50 text-amber-600 dark:border-amber-900/40 dark:bg-amber-900/10 dark:text-amber-300">
                <i class="fa-solid <?= esc($event['icon_class'] ?: 'fa-calendar-days') ?>"></i>
              </div>
              <span class="rounded-full px-2.5 py-0.5 text-[10px] font-semibold <?= ! empty($event['is_active']) ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                <?= ! empty($event['is_active']) ? 'Active' : 'Inactive' ?>
              </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?= esc($event['title']) ?></h3>
            <p class="mt-1 text-xs text-gray-400">Icon: <?= esc($event['icon_class']) ?> · Sort: <?= esc((string) ($event['sort_order'] ?? 0)) ?></p>
            <p class="mt-4 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-300"><?= esc($event['description']) ?></p>
          </div>
          <div class="flex gap-2 p-5">
            <a href="<?= base_url('admin/trident/events/edit/' . $event['id']) ?>"
               class="flex-1 rounded-lg border border-gray-200 py-2 text-center text-xs font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
              Edit
            </a>
            <?php if (service('adminPermissions')->canDeleteData()): ?>
              <form action="<?= base_url('admin/trident/events/delete/' . $event['id']) ?>" method="POST"
                    data-confirm-delete-form
                    data-delete-title="Delete Trident event?"
                    data-delete-message="This will permanently remove this Trident event."
                    data-confirm-button="Delete Event">
                <?= csrf_field() ?>
                <button type="submit"
                        class="rounded-lg border border-red-200 px-4 py-2 text-xs font-medium text-red-600 transition-colors hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20">
                  Delete
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>
