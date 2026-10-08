<div class="space-y-5">
  <?php $paymentGatewayActive = app_setting('payment_gateway_enabled', '0') === '1'; ?>

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rooms</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5"><?= count($rooms) ?> room<?= count($rooms) !== 1 ? 's' : '' ?> configured</p>
    </div>
    <div class="flex items-center gap-3">
      <?php if (empty($rooms)): ?>
        <form action="<?= base_url('admin/rooms/import-starter') ?>" method="POST">
          <?= csrf_field() ?>
          <button type="submit"
                  class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-amber-200 text-amber-700 bg-amber-50 text-sm font-medium hover:bg-amber-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m14.836 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-14.837-2m14.837 2H15"/></svg>
            Import Starter Rooms
          </button>
        </form>
      <?php endif; ?>
      <a href="<?= base_url('admin/rooms/create') ?>"
         class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-medium transition-shadow hover:shadow-lg"
         style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Room
      </a>
    </div>
  </div>

  <?php if (!empty($rooms)): ?>
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($rooms as $room): ?>
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
      <!-- Image -->
      <div class="h-44 bg-gray-100 dark:bg-gray-800 overflow-hidden relative">
        <?php if (!empty($room['image'])): ?>
          <img src="<?= esc(media_url($room['image'])) ?>" alt="<?= esc($room['name']) ?>" class="w-full h-full object-cover" />
        <?php else: ?>
          <div class="w-full h-full flex items-center justify-center text-4xl">🛏️</div>
        <?php endif; ?>
        <span class="absolute top-3 right-3 px-2.5 py-0.5 rounded-full text-[10px] font-semibold
          <?= $room['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
          <?= $room['is_active'] ? 'Active' : 'Inactive' ?>
        </span>
      </div>
      <!-- Info -->
      <div class="p-5">
        <div class="flex items-start justify-between mb-1">
          <h3 class="font-bold text-gray-900 dark:text-white"><?= esc($room['name']) ?></h3>
          <span class="font-bold text-[#F59E0B]">₹<?= number_format($room['price']) ?></span>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
          Max <?= esc((string) $room['max_guests']) ?> guests · <?= esc((string) ($room['available_units'] ?? 1)) ?> unit<?= (int) ($room['available_units'] ?? 1) === 1 ? '' : 's' ?> · /<?= esc($room['slug']) ?>
        </p>
        <?php if ($paymentGatewayActive): ?>
          <p class="text-xs mb-3 <?= ! empty($room['booking_open']) ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' ?>">
            <?= ! empty($room['booking_open']) ? 'Booking Open' : 'Booking Close' ?>
          </p>
        <?php endif; ?>
        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2 mb-4"><?= esc($room['description'] ?? '') ?></p>
        <div class="flex gap-2 pt-3 border-t border-gray-100 dark:border-gray-800">
          <a href="<?= base_url('admin/rooms/edit/' . $room['id']) ?>"
             class="flex-1 py-2 text-center text-xs font-medium rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
            Edit
          </a>
          <?php if (service('adminPermissions')->canDeleteData()): ?>
            <form action="<?= base_url('admin/rooms/delete/' . $room['id']) ?>" method="POST"
                  data-confirm-delete-form
                  data-delete-title="Delete room?"
                  data-delete-message="This will permanently remove this room from the website."
                  data-confirm-button="Delete Room">
              <?= csrf_field() ?>
              <button type="submit"
                      class="px-4 py-2 text-xs font-medium rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 border border-red-200 dark:border-red-800 transition-colors">
                Delete
              </button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 p-16 text-center">
    <div class="text-4xl mb-4">🛏️</div>
    <p class="font-medium text-gray-900 dark:text-white">No rooms yet</p>
    <p class="text-sm text-gray-400 mt-1 mb-5">You can add rooms manually or import the current frontend starter rooms into admin.</p>
    <div class="flex items-center justify-center gap-3 flex-wrap">
      <form action="<?= base_url('admin/rooms/import-starter') ?>" method="POST">
        <?= csrf_field() ?>
        <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-amber-200 text-amber-700 bg-amber-50 text-sm font-medium hover:bg-amber-100 transition-colors">
          Import Starter Rooms
        </button>
      </form>
      <a href="<?= base_url('admin/rooms/create') ?>"
         class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-medium"
         style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        Add First Room
      </a>
    </div>
  </div>
  <?php endif; ?>

</div>
