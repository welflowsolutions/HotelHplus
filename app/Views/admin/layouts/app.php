<!DOCTYPE html>
<html lang="en" class="bg-[#F5F6F8]">
<head>
  <?php
    $adminFavicon = app_setting('brand_favicon', '/favicon.ico');
    $adminFaviconUrl = trim((string) $adminFavicon) !== ''
      ? (preg_match('#^https?://#i', (string) $adminFavicon) ? $adminFavicon : base_url(ltrim((string) $adminFavicon, '/')))
      : base_url('favicon.ico');
  ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Admin') ?> | <?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= esc($adminFaviconUrl) ?>" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: { sans: ['Outfit', 'sans-serif'] },
          colors: {
            hotel: {
              gold: '#C99A30',
              dark: '#0D1117',
              canvas: '#F5F6F8'
            }
          }
        }
      }
    }
  </script>
  <!-- Apply admin theme before paint to avoid flash -->
  <script>
    (function () {
      const root = document.documentElement;
      const storedTheme = localStorage.getItem('adminTheme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const useDark = storedTheme === 'dark' || (!storedTheme && prefersDark);

      root.classList.toggle('dark', useDark);
      root.classList.toggle('bg-[#F5F6F8]', !useDark);
      root.classList.toggle('bg-[#090D14]', useDark);
      root.style.colorScheme = useDark ? 'dark' : 'light';
    })();
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    html {
      background: #F5F6F8;
    }
    html.dark {
      background: #090D14;
    }
    * { scrollbar-color: #CBD5E1 transparent; scrollbar-width: thin; }
    .sidebar { transition: width .3s ease, transform .3s ease }
    .nav-label { transition: opacity .15s ease; }
    .no-scrollbar::-webkit-scrollbar { display: none }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none }
    input[type="number"] { -moz-appearance: textfield; appearance: textfield; }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .admin-toast {
      opacity: 0;
      transform: translateY(-12px) translateX(12px);
      transition: opacity .25s ease, transform .25s ease;
    }
    .admin-toast.show { opacity: 1; transform: translateY(0) translateX(0); }
    .admin-surface {
      background-image:
        radial-gradient(circle at 5% 0%, rgba(201,154,48,.08), transparent 22rem),
        radial-gradient(circle at 100% 100%, rgba(15,23,42,.04), transparent 28rem);
    }
    .dark .admin-surface {
      background-image:
        radial-gradient(circle at 5% 0%, rgba(201,154,48,.08), transparent 22rem),
        radial-gradient(circle at 100% 100%, rgba(255,255,255,.025), transparent 28rem);
    }
    details.admin-actions > summary { list-style: none; }
    details.admin-actions > summary::-webkit-details-marker { display: none; }
    <?= $styles ?? '' ?>
  </style>
</head>
<body data-page="<?= esc($page ?? '') ?>" class="font-sans bg-[#F5F6F8] text-slate-900 dark:bg-[#090D14] dark:text-slate-100 h-screen overflow-hidden flex antialiased">

  <?php
    // Build toast messages from session
    $toastMessages = [];
    $session = session();
    $normalizeToastMessage = static function ($message): string {
      if (is_array($message)) {
        $message = implode(' ', array_values($message));
      }

      $message = html_entity_decode((string) $message, ENT_QUOTES | ENT_HTML5, 'UTF-8');
      $message = preg_replace('/<!--\s*DEBUG-VIEW\s+(?:START|ENDED).*?-->/s', '', $message) ?? $message;
      $message = strip_tags($message);
      $message = preg_replace('/\s+/', ' ', $message) ?? $message;

      return trim($message);
    };

    foreach (['success', 'warning', 'error'] as $toastType) {
      $flashMessage = $session->getFlashdata($toastType);

      if ($flashMessage) {
        $toastMessages[] = ['type' => $toastType, 'message' => $normalizeToastMessage($flashMessage)];
      }
    }
  ?>

  <?= view('admin/layouts/components/_sidebar', ['page' => $page ?? '']) ?>

  <div id="mainContent" class="flex min-w-0 flex-1 flex-col overflow-hidden transition-all duration-300 lg:ml-[284px]">

    <?= view('admin/layouts/components/_topbar', ['title' => $title ?? 'Admin']) ?>

    <main class="admin-surface flex-1 overflow-y-auto bg-[#F5F6F8] p-4 dark:bg-[#090D14] sm:p-6 lg:p-8">
      <div class="mx-auto w-full max-w-[1500px]">
        <?= $content ?? '' ?>
      </div>
    </main>

  </div>

  <?php if (!empty($toastMessages)) : ?>
    <div id="toastContainer" class="fixed left-4 right-4 top-4 z-[1000] flex flex-col gap-3 pointer-events-none sm:left-auto sm:w-full sm:max-w-sm">
      <?php foreach ($toastMessages as $toast) :
        $cls = match ($toast['type']) {
          'success' => 'border-green-200 bg-green-50 text-green-800',
          'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
          default   => 'border-red-200 bg-red-50 text-red-800',
        };
      ?>
        <div class="admin-toast pointer-events-auto rounded-2xl border <?= $cls ?> shadow-xl">
          <div class="flex items-start gap-3 px-4 py-3">
            <div class="mt-0.5">
              <?php if ($toast['type'] === 'success') : ?>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <?php elseif ($toast['type'] === 'warning') : ?>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.66 18h16.68a1 1 0 00.87-1.5l-7.5-13a1 1 0 00-1.74 0z"/></svg>
              <?php else : ?>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              <?php endif; ?>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-semibold capitalize"><?= $toast['type'] ?></p>
              <p class="mt-1 text-sm leading-5"><?= esc($toast['message']) ?></p>
            </div>
            <button type="button" onclick="dismissToast(this.closest('.admin-toast'))" class="text-current/70 hover:text-current">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?= view('admin/layouts/components/_logout_modal') ?>
  <?= view('admin/layouts/components/_confirm_action_modal') ?>
  <?= view('admin/layouts/components/_confirm_delete_modal') ?>

  <script src="<?= base_url('assets/admin/js/shared.js') ?>"></script>
  <?= $scripts ?? '' ?>

</body>
</html>
