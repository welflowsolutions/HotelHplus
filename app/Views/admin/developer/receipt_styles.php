<?php
$settings = $settings ?? [];
$hotelName = $settings['hotel_name'] ?? 'Hotel H Plus';
$receiptPdfStyle = old('receipt_pdf_style', $settings['receipt_pdf_style'] ?? 'classic');
$receiptStyleOptions = [
    ['key' => 'classic', 'name' => 'Classic', 'description' => 'Current gold-and-ivory hotel receipt.', 'classes' => 'bg-[#f8f6f1] border-[#e5dbc7] text-slate-900', 'bar' => 'bg-slate-950 text-[#c49d3a]'],
    ['key' => 'signature', 'name' => 'Signature', 'description' => 'Warmer premium look with a deeper amount band.', 'classes' => 'bg-[#f4f1ea] border-[#ceb888] text-slate-900', 'bar' => 'bg-[#2d2216] text-[#e0b044]'],
    ['key' => 'minimal', 'name' => 'Minimal', 'description' => 'Clean invoice-style layout with restrained contrast.', 'classes' => 'bg-white border-slate-300 text-slate-900', 'bar' => 'bg-slate-100 text-slate-950'],
];
?>

<div class="space-y-6">
  <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-amber-700/80 dark:text-amber-300/80">Developer Tools</p>
      <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">Receipt Styles</h1>
      <p class="mt-1 max-w-3xl text-sm text-slate-500 dark:text-slate-400">Choose the PDF receipt look used for booking and event payment receipts.</p>
    </div>
    <a href="<?= base_url('admin/settings?tab=billing') ?>" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
      Billing Settings
    </a>
  </div>

  <form action="<?= base_url('admin/settings/update') ?>" method="POST" class="rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <?= csrf_field() ?>
    <input type="hidden" name="settings_tab" value="receiptstyles" />

    <div class="border-b border-slate-100 px-6 py-5 dark:border-slate-800">
      <h2 class="text-lg font-bold text-slate-900 dark:text-white">Style Presets</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400">Receipt data, GST rows, and totals stay unchanged. Only the PDF visual style changes.</p>
    </div>

    <div class="grid gap-5 p-6 lg:grid-cols-3">
      <?php foreach ($receiptStyleOptions as $option): ?>
        <label data-receipt-style-card class="group cursor-pointer rounded-3xl border p-4 transition hover:-translate-y-0.5 hover:shadow-lg <?= $receiptPdfStyle === $option['key'] ? 'border-[#C99A30] ring-4 ring-[#C99A30]/15 dark:border-[#C99A30]' : 'border-slate-200 dark:border-slate-700' ?>">
          <input data-receipt-style-input type="radio" name="receipt_pdf_style" value="<?= esc($option['key']) ?>" <?= $receiptPdfStyle === $option['key'] ? 'checked' : '' ?> class="sr-only" />
          <div class="rounded-2xl border px-4 py-5 <?= esc($option['classes']) ?>">
            <div class="text-center">
              <p class="text-lg font-bold"><?= esc($hotelName) ?></p>
              <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.18em] opacity-70">Payment Receipt</p>
            </div>
            <div class="my-5 h-px border-t border-dashed opacity-40"></div>
            <div class="flex justify-between text-xs">
              <span class="opacity-60">Receipt No.</span>
              <strong>HHP-BKG001</strong>
            </div>
            <div class="mt-4 rounded-xl px-3 py-5 text-center <?= esc($option['bar']) ?>">
              <p class="text-[10px] font-bold uppercase opacity-70">Amount Paid</p>
              <p class="mt-1 text-2xl font-black">INR 2,200.00</p>
            </div>
            <div class="mt-5 space-y-2 text-xs">
              <div class="flex justify-between"><span class="opacity-60">Guest</span><strong>Guest Name</strong></div>
              <div class="flex justify-between"><span class="opacity-60">Room</span><strong>Deluxe Room</strong></div>
              <div class="flex justify-between"><span class="opacity-60">Status</span><strong>Paid</strong></div>
            </div>
          </div>
          <div class="mt-4 flex items-start gap-3">
            <span data-receipt-style-dot class="mt-1 h-4 w-4 rounded-full border <?= $receiptPdfStyle === $option['key'] ? 'border-[#C99A30] bg-[#C99A30]' : 'border-slate-300 dark:border-slate-600' ?>"></span>
            <span>
              <span class="block text-sm font-bold text-slate-900 dark:text-white"><?= esc($option['name']) ?></span>
              <span class="mt-1 block text-xs leading-5 text-slate-500 dark:text-slate-400"><?= esc($option['description']) ?></span>
            </span>
          </div>
        </label>
      <?php endforeach; ?>
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 px-6 py-5 dark:border-slate-800">
      <button type="submit" class="rounded-2xl bg-[#0D1117] px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg dark:bg-[#C99A30] dark:text-slate-950 dark:hover:bg-[#d5ab4a]">
        Save Receipt Style
      </button>
    </div>
  </form>
</div>

<div id="receiptStylePreviewModal" class="fixed inset-0 z-[80] hidden items-center justify-center bg-slate-950/75 p-4 backdrop-blur-sm">
  <div class="w-full max-w-3xl overflow-hidden rounded-3xl border border-slate-700 bg-slate-950 shadow-2xl">
    <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4">
      <div>
        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-amber-300/80">Receipt Preview</p>
        <h2 id="receiptStylePreviewTitle" class="mt-1 text-lg font-bold text-white">Receipt Style</h2>
      </div>
      <button type="button" data-close-receipt-preview class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-700 text-slate-300 transition hover:bg-slate-800 hover:text-white" aria-label="Close preview">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"/>
        </svg>
      </button>
    </div>

    <div class="max-h-[72vh] overflow-y-auto p-5">
      <?php foreach ($receiptStyleOptions as $option): ?>
        <div data-receipt-preview-style="<?= esc($option['key']) ?>" data-receipt-preview-name="<?= esc($option['name']) ?>" class="hidden">
          <div class="mx-auto max-w-md rounded-[2rem] border p-6 shadow-2xl <?= esc($option['classes']) ?>">
            <div class="text-center">
              <p class="text-2xl font-black"><?= esc($hotelName) ?></p>
              <p class="mt-2 text-[11px] font-semibold uppercase tracking-[0.22em] opacity-70">Payment Receipt</p>
              <p class="mt-4 text-sm opacity-70">Opposite Sector-7, Pipli Road, Kurukshetra</p>
            </div>
            <div class="my-7 h-px border-t border-dashed opacity-40"></div>
            <div class="space-y-3 text-sm">
              <div class="flex justify-between gap-5"><span class="opacity-60">Receipt No.</span><strong>HHP-BKG001</strong></div>
              <div class="flex justify-between gap-5"><span class="opacity-60">Paid On</span><strong>24 Jul 2026, 12:15 PM</strong></div>
              <div class="flex justify-between gap-5"><span class="opacity-60">Status</span><strong>Paid</strong></div>
            </div>
            <div class="my-7 rounded-2xl px-4 py-7 text-center <?= esc($option['bar']) ?>">
              <p class="text-[11px] font-bold uppercase tracking-[0.16em] opacity-70">Amount Paid</p>
              <p class="mt-2 text-4xl font-black">INR 2,200.00</p>
            </div>
            <h3 class="text-sm font-bold uppercase tracking-[0.18em] opacity-70">Stay Details</h3>
            <div class="mt-4 space-y-3 text-sm">
              <div class="flex justify-between gap-5"><span class="opacity-60">Guest</span><strong>Guest Name</strong></div>
              <div class="flex justify-between gap-5"><span class="opacity-60">Room</span><strong>Deluxe Room</strong></div>
              <div class="flex justify-between gap-5"><span class="opacity-60">Check-in</span><strong>24 Jul 2026</strong></div>
              <div class="flex justify-between gap-5"><span class="opacity-60">Rooms / Guests</span><strong>1 / 2</strong></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-800 px-5 py-4">
      <button type="button" data-close-receipt-preview class="rounded-2xl border border-slate-700 px-5 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white">
        Close
      </button>
      <button type="button" data-close-receipt-preview class="rounded-2xl bg-[#C99A30] px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-[#d5ab4a]">
        Use This Style
      </button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const cards = Array.from(document.querySelectorAll('[data-receipt-style-card]'));
    const previewModal = document.getElementById('receiptStylePreviewModal');
    const previewTitle = document.getElementById('receiptStylePreviewTitle');

    function syncReceiptStyleCards() {
      cards.forEach(function (card) {
        const input = card.querySelector('[data-receipt-style-input]');
        const dot = card.querySelector('[data-receipt-style-dot]');
        const selected = input && input.checked;

        card.classList.toggle('border-[#C99A30]', selected);
        card.classList.toggle('ring-4', selected);
        card.classList.toggle('ring-[#C99A30]/15', selected);
        card.classList.toggle('dark:border-[#C99A30]', selected);
        card.classList.toggle('border-slate-200', !selected);
        card.classList.toggle('dark:border-slate-700', !selected);

        if (dot) {
          dot.classList.toggle('border-[#C99A30]', selected);
          dot.classList.toggle('bg-[#C99A30]', selected);
          dot.classList.toggle('border-slate-300', !selected);
          dot.classList.toggle('dark:border-slate-600', !selected);
        }
      });
    }

    function openReceiptPreview(style) {
      if (!previewModal) return;

      let activeName = 'Receipt Style';
      previewModal.querySelectorAll('[data-receipt-preview-style]').forEach(function (preview) {
        const isActive = preview.getAttribute('data-receipt-preview-style') === style;
        preview.classList.toggle('hidden', !isActive);
        if (isActive) {
          activeName = preview.getAttribute('data-receipt-preview-name') || activeName;
        }
      });

      if (previewTitle) {
        previewTitle.textContent = activeName + ' Preview';
      }

      previewModal.classList.remove('hidden');
      previewModal.classList.add('flex');
    }

    function closeReceiptPreview() {
      if (!previewModal) return;
      previewModal.classList.add('hidden');
      previewModal.classList.remove('flex');
    }

    cards.forEach(function (card) {
      const input = card.querySelector('[data-receipt-style-input]');
      if (!input) return;

      card.addEventListener('click', function () {
        input.checked = true;
        syncReceiptStyleCards();
        openReceiptPreview(input.value);
      });

      input.addEventListener('change', syncReceiptStyleCards);
    });

    syncReceiptStyleCards();

    document.querySelectorAll('[data-close-receipt-preview]').forEach(function (button) {
      button.addEventListener('click', closeReceiptPreview);
    });

    if (previewModal) {
      previewModal.addEventListener('click', function (event) {
        if (event.target === previewModal) {
          closeReceiptPreview();
        }
      });
    }

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeReceiptPreview();
      }
    });
  });
</script>
