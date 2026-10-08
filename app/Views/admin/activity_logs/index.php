<div class="space-y-5">
  <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Activity Logs</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Latest <?= count($logs) ?> admin actions across settings, payment config, and rooms.</p>
    </div>
  </div>

  <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <?php if ($logs === []): ?>
      <div class="p-12 text-center">
        <p class="font-medium text-gray-900 dark:text-white">No activity recorded yet</p>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Logs will appear here after tracked admin actions.</p>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
          <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:bg-gray-950/40 dark:text-gray-400">
            <tr>
              <th class="px-4 py-3">Time</th>
              <th class="px-4 py-3">Admin</th>
              <th class="px-4 py-3">Action</th>
              <th class="px-4 py-3">Summary</th>
              <th class="px-4 py-3">IP</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            <?php foreach ($logs as $log): ?>
              <?php
                $changes = json_decode((string) ($log['changes'] ?? ''), true);
                $changedKeys = is_array($changes['changed_keys'] ?? null) ? $changes['changed_keys'] : [];
              ?>
              <tr class="align-top">
                <td class="whitespace-nowrap px-4 py-3 text-gray-500 dark:text-gray-400">
                  <?= esc(date('d M Y, h:i A', strtotime((string) $log['created_at']))) ?>
                </td>
                <td class="whitespace-nowrap px-4 py-3 text-gray-700 dark:text-gray-200">
                  <?= esc($log['admin_name'] ?: 'Admin') ?>
                </td>
                <td class="whitespace-nowrap px-4 py-3">
                  <span class="rounded-full bg-[#C99A30]/10 px-2.5 py-1 text-xs font-semibold text-[#A87412] dark:text-[#E2B44A]">
                    <?= esc($log['action']) ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                  <p class="font-medium"><?= esc($log['summary']) ?></p>
                  <?php if ($changedKeys !== []): ?>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"><?= esc(implode(', ', $changedKeys)) ?></p>
                  <?php endif; ?>
                </td>
                <td class="whitespace-nowrap px-4 py-3 text-gray-500 dark:text-gray-400">
                  <?= esc($log['ip_address'] ?: '-') ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
