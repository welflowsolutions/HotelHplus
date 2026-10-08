<?php
$grouped = [];
foreach ($permissionCatalog as $key => $meta) {
    if (str_contains((string) $key, '.delete')) {
        continue;
    }

    $grouped[$meta['group'] ?? 'Other'][$key] = $meta;
}
?>

<div class="mx-auto max-w-6xl space-y-5">
  <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#C99A30]">Users</p>
      <h1 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">Role Permissions</h1>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Owner access is fixed. Admin and Staff permissions can be adjusted here.</p>
    </div>
    <a href="<?= base_url('admin/users') ?>" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Back to Users</a>
  </div>

  <form action="<?= base_url('admin/users/permissions') ?>" method="POST" class="space-y-5">
    <?= csrf_field() ?>

    <?php foreach ($grouped as $group => $items): ?>
      <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><?= esc($group) ?></h2>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
          <?php foreach ($items as $permission => $meta): ?>
            <div class="grid gap-4 px-5 py-4 lg:grid-cols-[minmax(0,1fr)_160px_160px] lg:items-center">
              <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= esc($meta['label'] ?? $permission) ?></p>
                <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-400"><?= esc($meta['description'] ?? $permission) ?></p>
                <p class="mt-1 font-mono text-[11px] text-gray-400"><?= esc($permission) ?></p>
              </div>
              <?php foreach ($roles as $role => $label): ?>
                <?php $checked = in_array($permission, $rolePermissions[$role] ?? [], true); ?>
                <label class="flex cursor-pointer items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-700 dark:border-gray-800 dark:bg-gray-950/35 dark:text-gray-200">
                  <span><?= esc($label) ?></span>
                  <span class="relative inline-flex h-6 w-11 items-center">
                    <input type="checkbox" name="permissions[<?= esc($role) ?>][]" value="<?= esc($permission) ?>" <?= $checked ? 'checked' : '' ?> class="peer sr-only">
                    <span class="absolute inset-0 rounded-full bg-gray-300 transition peer-checked:bg-[#C99A30] dark:bg-gray-700"></span>
                    <span class="absolute left-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                  </span>
                </label>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>

    <div class="flex justify-end rounded-xl border border-gray-200 bg-white px-5 py-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <button type="submit" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition hover:shadow-lg" style="background:linear-gradient(to right,#F59E0B,#FB923C)">Save Permissions</button>
    </div>
  </form>
</div>
