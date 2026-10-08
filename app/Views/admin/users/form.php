<?php
$editing = is_array($user);
$selectedRole = old('usertype', $user['usertype'] ?? 'staff');
$inputClass = 'w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-[#F59E0B] focus:bg-white focus:ring-2 focus:ring-[#F59E0B]/25 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:bg-gray-800';
$roleDescriptions = [
    'owner' => 'Full access, including refunds, users, settings, and payment controls.',
    'admin' => 'Operational access for bookings, payments, rechecks, and exports.',
    'staff' => 'Limited access for viewing operational records without money actions.',
];
?>

<div class="mx-auto max-w-5xl space-y-5">
  <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-3">
      <a href="<?= base_url('admin/users') ?>"
         class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?= $editing ? 'Edit User' : 'Create User' ?></h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Manage admin access without changing the wider permission model.</p>
      </div>
    </div>
  </div>

  <form action="<?= $editing ? base_url('admin/users/' . $user['id'] . '/update') : base_url('admin/users/store') ?>" method="POST" class="space-y-5">
    <?= csrf_field() ?>

    <div class="grid gap-5 lg:grid-cols-[1fr_340px]">
      <section class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Identity</h2>
        </div>
        <div class="grid gap-5 p-6 sm:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
            <input name="name" value="<?= esc(old('name', $user['name'] ?? '')) ?>" placeholder="Aarav Sharma" required class="<?= $inputClass ?>">
          </div>
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
            <input name="username" value="<?= esc(old('username', $user['username'] ?? '')) ?>" placeholder="aarav.admin" required class="<?= $inputClass ?>">
          </div>
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input name="email" type="email" value="<?= esc(old('email', $user['email'] ?? '')) ?>" placeholder="admin@<?= esc(parse_url(base_url(), PHP_URL_HOST) ?: 'hotel.com') ?>" required class="<?= $inputClass ?>">
            <p class="mt-1.5 text-xs text-gray-400">Refund OTP requires a hotel-domain email for owner accounts.</p>
          </div>
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
            <input name="phone" value="<?= esc(old('phone', $user['phone'] ?? '')) ?>" placeholder="+91 90000 00000" class="<?= $inputClass ?>">
          </div>
          <?php if (! $editing): ?>
            <div class="sm:col-span-2">
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Initial Password</label>
              <input name="password" type="password" required minlength="8" placeholder="Minimum 8 characters" class="<?= $inputClass ?>">
              <p class="mt-1.5 text-xs text-gray-400">Ask the user to change this password after first login.</p>
            </div>
          <?php endif; ?>
        </div>
      </section>

      <aside class="space-y-5">
        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Access Role</h2>
          <div class="mt-4 space-y-2">
            <?php foreach ($roles as $key => $label): ?>
              <label data-role-card class="flex cursor-pointer gap-3 rounded-xl border px-4 py-3 transition <?= $selectedRole === $key ? 'border-[#C99A30] bg-[#C99A30]/10 dark:border-[#C99A30]/70' : 'border-gray-200 bg-gray-50 hover:border-[#C99A30]/50 dark:border-gray-800 dark:bg-gray-950/35' ?>">
                <input type="radio" name="usertype" value="<?= esc($key) ?>" <?= $selectedRole === $key ? 'checked' : '' ?> class="mt-1 h-4 w-4 border-gray-300 text-[#C99A30] focus:ring-[#C99A30]">
                <span>
                  <span class="block text-sm font-semibold text-gray-900 dark:text-white"><?= esc($label) ?></span>
                  <span class="mt-0.5 block text-xs leading-5 text-gray-500 dark:text-gray-400"><?= esc($roleDescriptions[$key] ?? '') ?></span>
                </span>
              </label>
            <?php endforeach; ?>
          </div>
        </section>

        <?php if ($editing): ?>
          <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Account</h2>
            <dl class="mt-4 space-y-3 text-sm">
              <div>
                <dt class="text-gray-400">Created</dt>
                <dd class="font-medium text-gray-900 dark:text-white"><?= ! empty($user['created_at']) ? esc(date('d M Y, h:i A', strtotime((string) $user['created_at']))) : '—' ?></dd>
              </div>
              <div>
                <dt class="text-gray-400">Last Updated</dt>
                <dd class="font-medium text-gray-900 dark:text-white"><?= ! empty($user['updated_at']) ? esc(date('d M Y, h:i A', strtotime((string) $user['updated_at']))) : '—' ?></dd>
              </div>
            </dl>
          </section>
        <?php endif; ?>
      </aside>
    </div>

    <div class="flex flex-col-reverse gap-3 rounded-xl border border-gray-200 bg-white px-6 py-4 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:flex-row sm:items-center sm:justify-between">
      <a href="<?= base_url('admin/users') ?>" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">Cancel</a>
      <button type="submit" class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium text-white transition-shadow hover:shadow-lg" style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        <?= $editing ? 'Update User' : 'Create User' ?>
      </button>
    </div>
  </form>

  <?php if ($editing): ?>
    <form action="<?= base_url('admin/users/' . $user['id'] . '/password') ?>" method="POST" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <?= csrf_field() ?>
      <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div class="max-w-xl">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Reset Password</h2>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Use this when a user is locked out. It does not change their role or profile details.</p>
        </div>
        <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
          <input name="password" type="password" required minlength="8" placeholder="New password" class="<?= $inputClass ?> sm:w-72">
          <button type="submit" class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-medium text-white transition-colors hover:bg-gray-800 dark:bg-white dark:text-gray-900">Update Password</button>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const cards = document.querySelectorAll('[data-role-card]');

  function syncRoleCards() {
    cards.forEach(function (card) {
      const input = card.querySelector('input[type="radio"]');
      const active = Boolean(input && input.checked);

      card.classList.toggle('border-[#C99A30]', active);
      card.classList.toggle('bg-[#C99A30]/10', active);
      card.classList.toggle('dark:border-[#C99A30]/70', active);
      card.classList.toggle('border-gray-200', ! active);
      card.classList.toggle('bg-gray-50', ! active);
      card.classList.toggle('hover:border-[#C99A30]/50', ! active);
      card.classList.toggle('dark:border-gray-800', ! active);
      card.classList.toggle('dark:bg-gray-950/35', ! active);
    });
  }

  cards.forEach(function (card) {
    card.addEventListener('change', syncRoleCards);
  });

  syncRoleCards();
});
</script>
