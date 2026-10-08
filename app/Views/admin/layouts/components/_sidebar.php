<?php
$navItems = [
    ['page' => 'dashboard', 'label' => 'Dashboard', 'url' => base_url('admin/dashboard'), 'path' => 'M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z'],
    ['page' => 'enquiries', 'label' => 'Enquiries', 'url' => base_url('admin/enquiries'), 'path' => 'M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z'],
    ['page' => 'bookings', 'label' => 'Bookings', 'url' => base_url('admin/bookings'), 'path' => 'M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z'],
    ['page' => 'payments', 'label' => 'Payments', 'url' => base_url('admin/payments'), 'path' => 'M3 8h18M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm2 8h4m6 0h.01'],
    ['page' => 'subscribers', 'label' => 'Subscribers', 'url' => base_url('admin/subscribers'), 'path' => 'M4 6h16M4 12h16M4 18h10m6 0h.01M17 17h4v4h-4z'],
    ['page' => 'rooms', 'label' => 'Rooms', 'url' => base_url('admin/rooms'), 'path' => 'M3 20v-8m0 4h18m0 4v-8M5 12V6a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v6m0 0V8a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v4'],
    ['page' => 'events', 'label' => 'Events', 'url' => base_url('admin/events'), 'path' => 'M8 7V5a2 2 0 1 1 4 0v2m4 0V5a2 2 0 1 1 4 0v2M4 11h16M6 21h12a2 2 0 0 0 2-2V9H4v10a2 2 0 0 0 2 2Zm4-6h4m-6 4h8'],
    ['page' => 'trident', 'label' => 'Trident', 'url' => base_url('admin/trident'), 'path' => 'M8 21h8m-4-4v4M7 4h10l2 5-7 8-7-8 2-5Zm0 0 5 13 5-13M5 9h14'],
    ['page' => 'media', 'label' => 'Media Library', 'url' => base_url('admin/media'), 'path' => 'M4 7h4l2-2h4l2 2h4v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Zm8 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z'],
    ['page' => 'gallery', 'label' => 'Gallery', 'url' => base_url('admin/gallery'), 'path' => 'M4 6h16v12H4V6Zm0 0 4 4 3-3 5 5 4-4M9 10.5h.01'],
    ['page' => 'activity_logs', 'label' => 'Activity Logs', 'url' => base_url('admin/activity-logs'), 'path' => 'M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM7 7h.01M7 12h.01M7 17h.01'],
    ['page' => 'users', 'label' => 'Users', 'url' => base_url('admin/users'), 'path' => 'M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0ZM4 21a8 8 0 0 1 16 0M19 8v6m3-3h-6'],
    ['page' => 'settings', 'label' => 'Settings', 'url' => base_url('admin/settings'), 'path' => 'M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm7.4-3.5a7.5 7.5 0 0 0-.08-1.08l2-1.56-2-3.46-2.46 1a7.7 7.7 0 0 0-1.86-1.08L14.65 3h-4l-.35 2.82A7.7 7.7 0 0 0 8.44 6.9l-2.46-1-2 3.46 2 1.56A7.5 7.5 0 0 0 5.9 12c0 .37.03.73.08 1.08l-2 1.56 2 3.46 2.46-1a7.7 7.7 0 0 0 1.86 1.08l.35 2.82h4l.35-2.82a7.7 7.7 0 0 0 1.86-1.08l2.46 1 2-3.46-2-1.56c.05-.35.08-.71.08-1.08Z'],
];
$canManageUsers = service('adminPermissions')->can('users.manage');
$canViewActivityLogs = service('adminPermissions')->can('activity_logs.view');
$canViewSubscribers = service('adminPermissions')->can('subscribers.view');
$canManageMedia = service('adminPermissions')->can('media.manage');
$canManageRooms = service('adminPermissions')->can('rooms.manage');
$canManageEvents = service('adminPermissions')->can('events.manage');
$canManageTrident = service('adminPermissions')->can('trident.manage');
$canManageSettings = service('adminPermissions')->can('settings.manage');
$developerModeEnabled = app_setting('system_developer_mode', '0') === '1';
$canManageSeo = service('adminPermissions')->can('seo.manage') && $developerModeEnabled;
$developerItems = [
    ['page' => 'seo', 'label' => 'SEO Manager', 'url' => base_url('admin/seo-manager'), 'path' => 'M11 5h2m-1-2v4m-7 4h14M5 19h14M7 9h10a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2Z', 'show' => $canManageSeo],
    ['page' => 'emailtemplates', 'label' => 'Email Templates', 'url' => base_url('admin/email-templates'), 'path' => 'M4 6h16M4 12h10M4 18h16', 'show' => $developerModeEnabled && $canManageSettings],
    ['page' => 'receiptstyles', 'label' => 'Receipt Styles', 'url' => base_url('admin/receipt-styles'), 'path' => 'M9 14h6m-6-4h6m-7 8h8a2 2 0 0 0 2-2V7.5L14.5 4H8a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z', 'show' => $developerModeEnabled && $canManageSettings],
];
$developerItems = array_values(array_filter($developerItems, static fn (array $item): bool => (bool) ($item['show'] ?? false)));
$navItems = array_values(array_filter($navItems, static function (array $item) use (
    $canManageUsers,
    $canViewActivityLogs,
    $canViewSubscribers,
    $canManageMedia,
    $canManageRooms,
    $canManageEvents,
    $canManageTrident,
    $canManageSettings
): bool {
    return match ($item['page'] ?? '') {
        'users' => $canManageUsers,
        'activity_logs' => $canViewActivityLogs,
        'subscribers' => $canViewSubscribers,
        'media', 'gallery' => $canManageMedia,
        'rooms' => $canManageRooms,
        'events' => $canManageEvents,
        'trident' => $canManageTrident,
        'settings' => $canManageSettings,
        default => true,
    };
}));
?>

<aside id="sidebar" class="sidebar fixed left-0 top-0 z-50 flex h-screen w-[284px] -translate-x-full flex-col border-r border-slate-800 bg-[#0D1117] px-4 text-white lg:translate-x-0">

  <div id="sidebarBrand" class="flex min-h-[88px] items-center border-b border-white/10 px-2 transition-all duration-300">
    <a href="<?= base_url('admin/dashboard') ?>" class="inline-flex">
      <?= view('admin/layouts/components/_brand', ['light' => true]) ?>
    </a>
  </div>

  <nav class="no-scrollbar flex-1 overflow-y-auto py-6">
    <p class="nav-label mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.24em] text-white/35">Hotel Management</p>
    <ul class="flex flex-col gap-1.5">

      <?php foreach ($navItems as $index => $item) : ?>
        <?php if ($index === 7) : ?>
          <li class="my-3"><div class="border-t border-white/10"></div></li>
        <?php endif; ?>
        <li>
          <a href="<?= $item['url'] ?>"
             data-page="<?= $item['page'] ?>"
             title="<?= esc($item['label']) ?>"
             class="nav-link group flex items-center gap-3 rounded-xl px-3 py-3 text-white/60 transition-all hover:bg-white/[0.06] hover:text-white">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="<?= $item['path'] ?>"/>
            </svg>
            <span class="nav-label whitespace-nowrap text-sm font-medium"><?= esc($item['label']) ?></span>
          </a>
        </li>
      <?php endforeach; ?>

    </ul>

    <?php if ($developerItems !== []): ?>
      <div class="my-5 border-t border-white/10"></div>
      <p class="nav-label mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.24em] text-white/35">Developer Tools</p>
      <ul class="flex flex-col gap-1.5">
        <?php foreach ($developerItems as $item) : ?>
          <li>
            <a href="<?= $item['url'] ?>"
               data-page="<?= $item['page'] ?>"
               title="<?= esc($item['label']) ?>"
               class="nav-link group flex items-center gap-3 rounded-xl px-3 py-3 text-white/60 transition-all hover:bg-white/[0.06] hover:text-white">
              <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="<?= $item['path'] ?>"/>
              </svg>
              <span class="nav-label whitespace-nowrap text-sm font-medium"><?= esc($item['label']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </nav>

  <div class="border-t border-white/10 py-5">
    <div class="flex items-center gap-3 rounded-xl bg-white/[0.04] px-3 py-3">
      <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#C99A30] text-sm font-bold text-white">
        <?php if (session()->get('admin_photo')): ?>
          <img src="<?= base_url(session()->get('admin_photo')) ?>" alt="<?= esc(session()->get('admin_name') ?? 'Admin') ?>" class="h-full w-full rounded-xl object-cover" />
        <?php else: ?>
          <?= strtoupper(substr(session()->get('admin_name') ?? 'A', 0, 1)) ?>
        <?php endif; ?>
      </div>
      <div class="nav-label min-w-0">
        <p class="truncate text-sm font-medium text-white"><?= esc(session()->get('admin_name') ?? 'Admin') ?></p>
        <p class="truncate text-xs text-white/35"><?= esc(session()->get('admin_usertype') ?? 'admin') ?></p>
      </div>
    </div>
  </div>

</aside>

<!-- Mobile overlay -->
<button id="overlay" type="button" aria-label="Close navigation" class="fixed inset-0 z-40 hidden bg-slate-950/65 backdrop-blur-sm lg:hidden"></button>
