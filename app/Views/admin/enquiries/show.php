<div class="max-w-3xl space-y-5">

  <!-- Back + Header -->
  <div class="flex items-center gap-3">
    <a href="<?= base_url('admin/enquiries') ?>"
       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Enquiry #<?= $enq['id'] ?></h1>
      <p class="text-xs text-gray-400 mt-0.5"><?= date('d M Y, h:i A', strtotime($enq['created_at'])) ?></p>
    </div>
    <span class="ml-auto px-3 py-1 rounded-full text-xs font-medium
      <?php echo match($enq['status']) {
        'new'     => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400',
        'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
        default   => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
      }; ?>">
      <?= ucfirst($enq['status']) ?>
    </span>
  </div>

  <!-- Sender info -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Sender Details</h2>
    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <p class="text-xs text-gray-400 mb-0.5">Full Name</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white">
          <?= esc(($enq['first_name'] ?? '') . ' ' . ($enq['last_name'] ?? '')) ?>
        </p>
      </div>
      <div>
        <p class="text-xs text-gray-400 mb-0.5">Email</p>
        <a href="mailto:<?= esc($enq['email'] ?? '') ?>"
           class="text-sm font-medium text-[#F59E0B] hover:underline">
          <?= esc($enq['email'] ?? '—') ?>
        </a>
      </div>
      <?php if (!empty($enq['phone'])): ?>
      <div>
        <p class="text-xs text-gray-400 mb-0.5">Phone</p>
        <a href="tel:<?= esc($enq['phone']) ?>"
           class="text-sm font-medium text-gray-900 dark:text-white hover:text-[#F59E0B]">
          <?= esc($enq['phone']) ?>
        </a>
      </div>
      <?php endif; ?>
      <?php if (!empty($enq['room_type'])): ?>
      <div>
        <p class="text-xs text-gray-400 mb-0.5">Room Interest</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= esc($enq['room_type']) ?></p>
      </div>
      <?php endif; ?>
      <?php if (!empty($enq['checkin'])): ?>
      <div>
        <p class="text-xs text-gray-400 mb-0.5">Check-in</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= date('d M Y', strtotime($enq['checkin'])) ?></p>
      </div>
      <?php endif; ?>
      <?php if (!empty($enq['checkout'])): ?>
      <div>
        <p class="text-xs text-gray-400 mb-0.5">Check-out</p>
        <p class="text-sm font-medium text-gray-900 dark:text-white"><?= date('d M Y', strtotime($enq['checkout'])) ?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Message -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
      Subject: <?= esc($enq['subject'] ?? '') ?>
    </h2>
    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
      <?= esc($enq['message'] ?? '') ?>
    </p>
  </div>

  <!-- Actions -->
  <div class="flex flex-wrap gap-3">
    <a href="mailto:<?= esc($enq['email'] ?? '') ?>?subject=Re: <?= urlencode($enq['subject'] ?? '') ?>"
       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-medium transition-shadow hover:shadow-lg"
       style="background:linear-gradient(to right,#F59E0B,#FB923C)">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
      </svg>
      Reply via Email
    </a>
    <?php if (!empty($enq['phone'])): ?>
    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $enq['phone']) ?>?text=<?= urlencode('Hello ' . ($enq['first_name'] ?? '') . ', thank you for contacting ' . app_setting('hotel_name', 'Hotel H Plus') . '.') ?>"
       target="_blank" rel="noopener"
       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#25D366] text-white text-sm font-medium hover:bg-green-600 transition-colors">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
      </svg>
      WhatsApp
    </a>
    <?php endif; ?>
    <?php if (service('adminPermissions')->canDeleteData()): ?>
      <form action="<?= base_url('admin/enquiries/' . $enq['id'] . '/delete') ?>" method="POST"
            data-confirm-delete-form
            data-delete-title="Delete enquiry?"
            data-delete-message="This will permanently remove this enquiry and cannot be undone."
            data-confirm-button="Delete Enquiry">
        <?= csrf_field() ?>
        <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-sm font-medium hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          Delete
        </button>
      </form>
    <?php endif; ?>
  </div>

</div>
