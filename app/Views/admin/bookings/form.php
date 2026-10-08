<div class="max-w-5xl space-y-5">
  <div class="flex items-center gap-3">
    <a href="<?= base_url('admin/bookings') ?>" class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manual Booking</h1>
      <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Create walk-in or phone bookings without changing the public booking flow.</p>
    </div>
  </div>

  <form action="<?= base_url('admin/bookings/store') ?>" method="POST" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
    <?= csrf_field() ?>
    <div class="grid gap-5 lg:grid-cols-2">
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="name">Guest Name</label>
        <input id="name" name="name" value="<?= old('name') ?>" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="phone">Phone</label>
        <input id="phone" name="phone" value="<?= old('phone') ?>" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= old('email') ?>" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="room_id">Room</label>
        <select id="room_id" name="room_id" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
          <option value="">Select room</option>
          <?php foreach ($rooms as $room): ?>
            <option value="<?= esc((string) $room['id']) ?>" <?= old('room_id') == $room['id'] ? 'selected' : '' ?>>
              <?= esc($room['name']) ?> · <?= esc((string) ($room['available_units'] ?? 1)) ?> unit<?= (int) ($room['available_units'] ?? 1) === 1 ? '' : 's' ?> · INR <?= esc(number_format((float) ($room['price'] ?? 0), 2)) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="checkin">Check-in</label>
        <input id="checkin" name="checkin" type="date" value="<?= old('checkin') ?>" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="checkout">Check-out</label>
        <input id="checkout" name="checkout" type="date" value="<?= old('checkout') ?>" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="guests">Guests</label>
        <input id="guests" name="guests" type="number" min="1" max="500" value="<?= old('guests', '2') ?>" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="rooms_required">Rooms Required</label>
        <input id="rooms_required" name="rooms_required" type="number" min="1" max="500" value="<?= old('rooms_required', '1') ?>" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="status">Initial Status</label>
        <select id="status" name="status" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
          <option value="pending" <?= old('status', 'pending') === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="confirmed" <?= old('status') === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
        </select>
      </div>
      <div class="lg:col-span-2">
        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300" for="notes">Internal Notes</label>
        <textarea id="notes" name="notes" rows="4" class="w-full resize-none rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white"><?= old('notes') ?></textarea>
      </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3 border-t border-gray-100 pt-5 dark:border-gray-800">
      <button type="submit" class="rounded-xl bg-[#F59E0B] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#d88a06]">Create Booking</button>
      <a href="<?= base_url('admin/bookings') ?>" class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">Cancel</a>
    </div>
  </form>
</div>
