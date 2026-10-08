<?php
$event = $event ?? null;
$isEdit = is_array($event);
$formAction = $isEdit ? base_url('admin/events/' . $event['id'] . '/update') : base_url('admin/events/store');
$heading = $isEdit ? 'Edit Event' : 'Create Event';
$subheading = $isEdit ? 'Update event details, status, and internal planning notes.' : 'Add walk-in, phone, WhatsApp, or offline event bookings to the same event manager.';
?>

<div class="space-y-5">
  <div class="flex flex-wrap items-start gap-3">
    <a href="<?= $isEdit ? base_url('admin/events/' . $event['id']) : base_url('admin/events') ?>"
       class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition-colors hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?= esc($heading) ?></h1>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?= esc($subheading) ?></p>
    </div>
  </div>

  <form action="<?= esc($formAction) ?>" method="POST" class="space-y-5">
    <?= csrf_field() ?>

    <section class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Guest & Event</h2>
      </div>
      <div class="grid gap-5 p-6 lg:grid-cols-2">
        <div>
          <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
          <input id="name" name="name" type="text" value="<?= esc(old('name', $event['name'] ?? '')) ?>" required
                 class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
          <label for="phone" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
          <input id="phone" name="phone" type="text" value="<?= esc(old('phone', $event['phone'] ?? '')) ?>" required
                 class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
          <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
          <input id="email" name="email" type="email" value="<?= esc(old('email', $event['email'] ?? '')) ?>"
                 class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
          <label for="event_type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Event Type</label>
          <input id="event_type" name="event_type" type="text" value="<?= esc(old('event_type', $event['event_type'] ?? '')) ?>" required list="eventTypeOptions" placeholder="Wedding, birthday, meeting..."
                 class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
          <?php if (! empty($services)): ?>
            <datalist id="eventTypeOptions">
              <?php foreach ($services as $service): ?>
                <option value="<?= esc($service['title'] ?? '') ?>"></option>
              <?php endforeach; ?>
            </datalist>
          <?php endif; ?>
        </div>

        <div>
          <label for="event_date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Event Date</label>
          <input id="event_date" name="event_date" type="date" value="<?= esc(old('event_date', $event['event_date'] ?? date('Y-m-d'))) ?>" required
                 class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>

        <div>
          <label for="guests" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Expected Guests</label>
          <input id="guests" name="guests" type="text" value="<?= esc(old('guests', $event['guests'] ?? '')) ?>" placeholder="Example: 80 - 120"
                 class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        </div>
      </div>
    </section>

    <section class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status & Notes</h2>
      </div>
      <div class="grid gap-5 p-6 lg:grid-cols-[320px_minmax(0,1fr)]">
        <div>
          <label for="status" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
          <select id="status" name="status"
                  class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            <?php foreach (['confirmed' => 'Confirmed', 'read' => 'Follow-up', 'replied' => 'Quoted', 'cancelled' => 'Cancelled'] as $value => $label): ?>
              <option value="<?= esc($value) ?>" <?= old('status', $event['status'] ?? 'confirmed') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label for="message" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Internal Note</label>
          <textarea id="message" name="message" rows="5" placeholder="Advance, package, hall, catering notes..."
                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none focus:ring-2 focus:ring-[#F59E0B] dark:border-gray-700 dark:bg-gray-800 dark:text-white"><?= esc(old('message', $event['message'] ?? '')) ?></textarea>
        </div>
      </div>
    </section>

    <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
      <a href="<?= $isEdit ? base_url('admin/events/' . $event['id']) : base_url('admin/events') ?>"
         class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
        Cancel
      </a>
      <button type="submit"
              class="rounded-xl px-5 py-3 text-sm font-semibold text-white transition-shadow hover:shadow-lg"
              style="background:linear-gradient(to right,#F59E0B,#FB923C)">
        <?= esc($isEdit ? 'Save Event' : 'Create Event') ?>
      </button>
    </div>
  </form>
</div>
