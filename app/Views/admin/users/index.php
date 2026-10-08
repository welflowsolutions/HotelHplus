<div class="space-y-5">
  <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Users</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Owner-managed admin access and operational roles.</p>
    </div>
    <div class="flex flex-wrap gap-2">
      <a href="<?= base_url('admin/users/permissions') ?>" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Permissions</a>
      <a href="<?= base_url('admin/users/create') ?>"
         class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg"
         style="background:linear-gradient(to right,#F59E0B,#FB923C)">Create User</a>
    </div>
  </div>

  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="border-b border-gray-100 bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 dark:text-gray-400">
          <tr>
            <th class="px-5 py-3">User</th>
            <th class="px-5 py-3">Role</th>
            <th class="hidden px-5 py-3 md:table-cell">Phone</th>
            <th class="hidden px-5 py-3 lg:table-cell">Last Login</th>
            <th class="hidden px-5 py-3 lg:table-cell">Updated</th>
            <th class="px-5 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          <?php foreach ($users as $user): ?>
            <tr>
              <td class="px-5 py-3.5">
                <div class="font-medium text-gray-900 dark:text-white"><?= esc($user['name'] ?? '—') ?></div>
                <div class="mt-0.5 text-xs text-gray-400"><?= esc($user['email'] ?? '') ?> · <?= esc($user['username'] ?? '') ?></div>
              </td>
              <td class="px-5 py-3.5">
                <span class="rounded-full bg-[#C99A30]/10 px-2.5 py-0.5 text-xs font-semibold text-[#A87412] dark:text-[#E2B44A]">
                  <?= esc($roles[$user['usertype'] ?? 'staff'] ?? ucfirst((string) ($user['usertype'] ?? 'staff'))) ?>
                </span>
              </td>
              <td class="hidden px-5 py-3.5 text-gray-500 dark:text-gray-400 md:table-cell"><?= esc($user['phone'] ?? '—') ?></td>
              <td class="hidden px-5 py-3.5 text-xs text-gray-400 lg:table-cell">
                <?= ! empty($user['last_login_at']) ? esc(date('d M Y, h:i A', strtotime((string) $user['last_login_at']))) : 'Never' ?>
              </td>
              <td class="hidden px-5 py-3.5 text-xs text-gray-400 lg:table-cell"><?= ! empty($user['updated_at']) ? esc(date('d M Y, h:i A', strtotime((string) $user['updated_at']))) : '—' ?></td>
              <td class="px-5 py-3.5 text-right">
                <a href="<?= base_url('admin/users/' . $user['id'] . '/edit') ?>" class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors hover:bg-amber-50 hover:text-amber-700 dark:bg-gray-800 dark:text-gray-300">Edit</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
