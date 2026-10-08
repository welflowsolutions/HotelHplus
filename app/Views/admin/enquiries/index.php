<div class="space-y-5">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Enquiries</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Contact form submissions from the website</p>
    </div>
  </div>

  <!-- Status tabs -->
  <div class="flex flex-wrap gap-2 border-b border-gray-200 dark:border-gray-800 pb-0">
    <?php
    $tabs = [
      'all'     => 'All',
      'new'     => 'New',
      'read'    => 'Read',
      'replied' => 'Replied',
    ];
    foreach ($tabs as $key => $label):
      $isActive = $status === $key;
    ?>
      <a href="?status=<?= $key ?>"
         class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition-colors
           <?= $isActive
               ? 'border-[#F59E0B] text-[#F59E0B]'
               : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' ?>">
        <?= $label ?>
        <span class="ml-1 px-1.5 py-0.5 text-[10px] rounded-full
          <?= $isActive ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' ?>">
          <?= $counts[$key] ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Table -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">

    <!-- Search -->
    <div class="p-4 border-b border-gray-100 dark:border-gray-800">
      <input type="text" id="searchInput" placeholder="Search by name, email or subject…"
             class="w-full sm:w-72 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#F59E0B]" />
    </div>

    <?php if (!empty($enquiries)): ?>
    <div class="overflow-x-auto">
      <table class="w-full text-sm" role="table">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
            <th class="text-left px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Name</th>
            <th class="text-left px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hidden md:table-cell">Subject</th>
            <th class="text-left px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hidden lg:table-cell">Room</th>
            <th class="text-left px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
            <th class="text-left px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hidden sm:table-cell">Date</th>
            <th class="px-5 py-3"></th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <?php foreach ($enquiries as $enq): ?>
          <tr class="border-b border-gray-50 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors <?= $enq['status'] === 'new' ? 'font-semibold' : '' ?>">
            <td class="px-5 py-3.5">
              <div class="font-medium text-gray-900 dark:text-white"><?= esc(($enq['first_name'] ?? '') . ' ' . ($enq['last_name'] ?? '')) ?></div>
              <div class="text-xs text-gray-400 mt-0.5"><?= esc($enq['email'] ?? '') ?></div>
            </td>
            <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300 hidden md:table-cell max-w-[200px] truncate"><?= esc($enq['subject'] ?? '') ?></td>
            <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden lg:table-cell"><?= esc($enq['room_type'] ?? '—') ?></td>
            <td class="px-5 py-3.5">
              <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                <?php echo match($enq['status'] ?? 'new') {
                  'new'     => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400',
                  'replied' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400',
                  default   => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                }; ?>">
                <?= esc($enq['status'] ?? 'new') ?>
              </span>
            </td>
            <td class="px-5 py-3.5 text-gray-400 text-xs hidden sm:table-cell"><?= date('d M Y', strtotime($enq['created_at'])) ?></td>
            <td class="px-5 py-3.5 text-right">
              <a href="<?= base_url('admin/enquiries/' . $enq['id']) ?>"
                 class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-amber-50 hover:text-amber-700 dark:hover:bg-amber-900/20 dark:hover:text-amber-400 transition-colors">
                View
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <div class="text-center py-16">
      <div class="w-14 h-14 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
      </div>
      <p class="text-sm font-medium text-gray-900 dark:text-white">No enquiries found</p>
      <p class="text-sm text-gray-400 mt-1">Enquiries submitted via the contact form will appear here.</p>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => initSearch('searchInput', 'tableBody'));
</script>
