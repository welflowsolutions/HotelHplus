<div class="space-y-5">
  <div class="flex items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Event Services</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400"><?= count($services) ?> service<?= count($services) !== 1 ? 's' : '' ?> configured for the public Events page and enquiry type sync.</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="<?= base_url('admin/events') ?>" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Events
      </a>
      <a href="<?= base_url('admin/events/services/create') ?>" class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg" style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Service
      </a>
    </div>
  </div>

  <?php if (empty($services)): ?>
    <div class="rounded-xl border border-dashed border-gray-200 bg-white p-16 text-center dark:border-gray-700 dark:bg-gray-900">
      <p class="font-medium text-gray-900 dark:text-white">No event services yet</p>
      <p class="mt-1 mb-5 text-sm text-gray-400">These cards appear on the public Events page and feed the event-type dropdown in the enquiry form.</p>
      <div class="flex items-center justify-center gap-3 flex-wrap">
        <form action="<?= base_url('admin/events/services/import-starter') ?>" method="POST">
          <?= csrf_field() ?>
          <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-5 py-2.5 text-sm font-medium text-amber-700 transition-colors hover:bg-amber-100">Import Starter Services</button>
        </form>
        <a href="<?= base_url('admin/events/services/create') ?>" class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-medium text-white" style="background:linear-gradient(to right,#F59E0B,#FB923C)">Add First Service</a>
      </div>
    </div>
  <?php else: ?>
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
      <?php foreach ($services as $service): ?>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
          <div class="border-b border-gray-100 p-5 dark:border-gray-800">
            <div class="mb-4 flex items-start justify-between gap-3">
              <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-amber-200 bg-amber-50 text-amber-600 dark:border-amber-900/40 dark:bg-amber-900/10 dark:text-amber-300">
                <i class="fa-solid <?= esc($service['icon_class'] ?: 'fa-calendar-days') ?>"></i>
              </div>
              <span class="rounded-full px-2.5 py-0.5 text-[10px] font-semibold <?= ! empty($service['is_active']) ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                <?= ! empty($service['is_active']) ? 'Active' : 'Inactive' ?>
              </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?= esc($service['title']) ?></h3>
            <p class="mt-1 text-xs text-gray-400">Icon: <?= esc($service['icon_class']) ?> · Sort: <?= esc((string) ($service['sort_order'] ?? 0)) ?></p>
            <p class="mt-4 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-300"><?= esc($service['description']) ?></p>
          </div>
          <div class="flex gap-2 p-5">
            <a href="<?= base_url('admin/events/services/edit/' . $service['id']) ?>" class="flex-1 rounded-lg border border-gray-200 py-2 text-center text-xs font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Edit</a>
            <?php if (service('adminPermissions')->canDeleteData()): ?>
              <form action="<?= base_url('admin/events/services/delete/' . $service['id']) ?>" method="POST"
                    data-confirm-delete-form
                    data-delete-title="Delete event service?"
                    data-delete-message="This will permanently remove this event service."
                    data-confirm-button="Delete Service">
                <?= csrf_field() ?>
                <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-xs font-medium text-red-600 transition-colors hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20">Delete</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
