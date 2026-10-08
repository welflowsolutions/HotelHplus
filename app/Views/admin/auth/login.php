<!DOCTYPE html>
<html lang="en" class="bg-[#F5F1E8]">
<head>
  <?php
    $adminFavicon = app_setting('brand_favicon', '/favicon.ico');
    $adminFaviconUrl = trim((string) $adminFavicon) !== ''
      ? (preg_match('#^https?://#i', (string) $adminFavicon) ? $adminFavicon : base_url(ltrim((string) $adminFavicon, '/')))
      : base_url('favicon.ico');
  ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login – <?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?></title>
  <link rel="shortcut icon" type="image/png" href="<?= esc($adminFaviconUrl) ?>" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: { extend: { fontFamily: { sans: ['Outfit','sans-serif'] } } }
    }
  </script>
  <script>
    (function () {
      const root = document.documentElement;
      const storedTheme = localStorage.getItem('adminTheme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const useDark = storedTheme === 'dark' || (!storedTheme && prefersDark);

      root.classList.toggle('dark', useDark);
      root.classList.toggle('bg-[#F5F1E8]', !useDark);
      root.classList.toggle('bg-[#090D14]', useDark);
      root.style.colorScheme = useDark ? 'dark' : 'light';
    })();
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    html {
      background: #F5F1E8;
    }
    html.dark {
      background: #090D14;
    }
  </style>
</head>
<body class="min-h-screen bg-[#F5F1E8] font-sans text-slate-900 dark:bg-[#090D14] dark:text-slate-100">
  <main class="grid min-h-screen lg:grid-cols-[1.05fr_.95fr]">
    <section class="relative hidden overflow-hidden bg-[#0D1117] p-12 text-white lg:flex lg:flex-col lg:justify-between xl:p-16">
      <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full border border-[#D4AE50]/20"></div>
      <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full border border-[#D4AE50]/15"></div>
      <div class="absolute bottom-0 left-0 h-72 w-72 bg-[radial-gradient(circle,rgba(212,174,80,.16),transparent_65%)]"></div>

      <div class="relative">
        <?= view('admin/layouts/components/_brand', ['light' => true]) ?>
      </div>

      <div class="relative max-w-xl">
        <p class="mb-5 text-xs font-semibold uppercase tracking-[0.32em] text-[#D4AE50]">Admin Portal</p>
        <h1 class="text-5xl font-semibold leading-[1.08] xl:text-6xl">Hospitality managed with clarity.</h1>
        <p class="mt-6 max-w-lg text-lg leading-8 text-white/55">
          Manage room inventory, guest enquiries, bookings and events from one focused workspace.
        </p>
      </div>

      <div class="relative grid grid-cols-3 gap-3">
        <?php foreach (['Room Management', 'Guest Enquiries', 'Event Bookings'] as $feature): ?>
          <div class="rounded-2xl border border-white/10 bg-white/[0.04] px-4 py-4 text-sm text-white/65"><?= $feature ?></div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="flex items-center justify-center p-5 sm:p-10">
      <div class="w-full max-w-md">
        <div class="mb-9 lg:hidden">
          <?= view('admin/layouts/components/_brand', ['light' => false, 'compact' => false]) ?>
        </div>

        <div class="mb-8">
          <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#A97919]">Secure Access</p>
          <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Welcome back</h2>
          <p class="mt-2 text-sm leading-6 text-slate-500">Sign in to continue to the <?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?> admin panel.</p>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="mb-5 flex gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.5m0 3.5h.01M10.3 3.9 2.8 17a1 1 0 0 0 .87 1.5h16.66a1 1 0 0 0 .87-1.5L13.7 3.9a1 1 0 0 0-1.74 0Z"/></svg>
            <span><?= esc(session()->getFlashdata('error')) ?></span>
          </div>
        <?php endif; ?>

        <div class="rounded-[2rem] border border-white/80 bg-white/80 p-7 shadow-[0_30px_90px_rgba(71,55,24,.13)] backdrop-blur sm:p-9">
          <form action="<?= base_url('admin/login') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>

        <div>
          <label for="login" class="mb-2 block text-sm font-medium text-slate-700">Username or Email</label>
          <input
            type="text" id="login" name="login"
            value="<?= old('login') ?>"
            placeholder="admin"
            required autocomplete="username"
            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10"
          />
        </div>

        <div>
          <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
          <div class="relative">
            <input
              type="password" id="password" name="password"
              placeholder="Enter your password"
              required autocomplete="current-password"
              class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 pr-12 text-sm text-slate-900 outline-none transition focus:border-[#C99A30] focus:ring-4 focus:ring-[#C99A30]/10"
            />
            <button type="button" onclick="togglePassword()"
                    aria-label="Show or hide password"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
              <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="w-full rounded-2xl bg-[#0D1117] px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800 hover:shadow-lg">
          Sign in to dashboard
        </button>

      </form>
        </div>

        <p class="mt-7 text-center text-xs text-slate-400">
          <a href="<?= base_url() ?>" class="transition-colors hover:text-slate-700">
            Back to <?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?> website
          </a>
        </p>
      </div>
    </section>
  </main>

  <script>
    function togglePassword() {
      const pw = document.getElementById('password');
      pw.type = pw.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
