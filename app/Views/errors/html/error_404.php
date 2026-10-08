<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | <?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --gold: #c6a03a;
            --gold-dark: #8c7022;
            --ink: #111010;
            --ivory: #faf8f4;
            --white: #ffffff;
            --text-soft: rgba(255, 255, 255, 0.76);
            --text-muted: rgba(17, 16, 16, 0.62);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "DM Sans", Arial, sans-serif;
            background:
                linear-gradient(rgba(17, 16, 16, 0.62), rgba(17, 16, 16, 0.76)),
                url("<?= esc(base_url('assets/web/images/about-welcome-image.webp')) ?>") center/cover no-repeat;
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        .shell {
            width: min(1120px, 100%);
        }

        .brand {
            margin-bottom: 18px;
            text-align: center;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.72);
        }

        .panel {
            background: rgba(250, 248, 244, 0.92);
            color: var(--ink);
            border: 1px solid rgba(198, 160, 58, 0.2);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(10px);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            overflow: hidden;
        }

        .copy {
            padding: 56px 52px;
        }

        .eyebrow {
            margin: 0 0 20px;
            color: var(--gold-dark);
            text-transform: uppercase;
            letter-spacing: 0.22em;
            font-size: 11px;
            font-weight: 600;
        }

        .code {
            margin: 0;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: clamp(5rem, 11vw, 8rem);
            line-height: 0.88;
            font-weight: 400;
            color: var(--ink);
        }

        h1 {
            margin: 18px 0 18px;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: clamp(2.2rem, 5vw, 4.25rem);
            line-height: 0.98;
            font-weight: 400;
            letter-spacing: 0;
        }

        h1 em {
            color: var(--gold);
            font-style: italic;
            font-weight: 400;
        }

        .lead {
            margin: 0 0 16px;
            font-size: 16px;
            line-height: 1.9;
            color: var(--text-muted);
            max-width: 34rem;
        }

        .note {
            margin: 0;
            font-size: 14px;
            line-height: 1.8;
            color: rgba(17, 16, 16, 0.54);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 34px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 168px;
            padding: 15px 24px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--gold);
            border: 1px solid var(--gold);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--gold-dark);
            border-color: var(--gold-dark);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(198, 160, 58, 0.42);
            color: var(--ink);
        }

        .btn-secondary:hover {
            border-color: var(--gold);
            color: var(--gold-dark);
        }

        .aside {
            position: relative;
            min-height: 560px;
            background:
                linear-gradient(180deg, rgba(17, 16, 16, 0.06), rgba(17, 16, 16, 0.2)),
                url("<?= esc(base_url('assets/web/images/homepage-hero-bg.webp')) ?>") center/cover no-repeat;
            display: flex;
            align-items: flex-end;
            padding: 36px;
        }

        .aside-card {
            width: min(100%, 320px);
            margin-left: auto;
            background: rgba(17, 16, 16, 0.84);
            border: 1px solid rgba(212, 174, 80, 0.22);
            padding: 24px;
            color: var(--white);
        }

        .aside-card p {
            margin: 0;
        }

        .aside-top {
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-size: 10px;
            color: rgba(212, 174, 80, 0.84);
            margin-bottom: 10px !important;
        }

        .aside-title {
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: 2rem;
            line-height: 1;
            margin-bottom: 12px !important;
        }

        .aside-copy {
            font-size: 14px;
            line-height: 1.8;
            color: var(--text-soft);
        }

        .dev-message {
            margin-top: 20px;
            padding: 16px 18px;
            background: rgba(198, 160, 58, 0.08);
            border-left: 2px solid rgba(198, 160, 58, 0.42);
            color: rgba(17, 16, 16, 0.66);
            font-size: 13px;
            line-height: 1.7;
            white-space: pre-wrap;
            word-break: break-word;
        }

        @media (max-width: 900px) {
            .panel {
                grid-template-columns: 1fr;
            }

            .copy {
                padding: 42px 28px;
            }

            .aside {
                min-height: 300px;
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="brand"><?= esc(app_setting('hotel_name', 'Hotel H Plus')) ?></div>

        <section class="panel" aria-label="Page not found">
            <div class="copy">
                <p class="eyebrow">Page Not Found</p>
                <p class="code">404</p>
                <h1>Looks like this page took a <em>wrong turn</em>.</h1>
                <p class="lead">
                    The page you are looking for is not available right now. You can head back to the homepage,
                    explore our rooms, or contact the hotel team for help.
                </p>
                <p class="note">
                    <?= esc(app_setting('hotel_phone', '+91 92530 72122')) ?> •
                    <?= esc(app_setting('hotel_email', 'info@hotelhplus.in')) ?>
                </p>

                <?php if (ENVIRONMENT !== 'production' && ! empty($message ?? '')) : ?>
                    <div class="dev-message"><?= esc($message) ?></div>
                <?php endif; ?>

                <div class="actions">
                    <a class="btn btn-primary" href="<?= esc(base_url('/')) ?>">Back Home</a>
                    <a class="btn btn-secondary" href="<?= esc(base_url('rooms')) ?>">View Rooms</a>
                    <a class="btn btn-secondary" href="<?= esc(base_url('contact')) ?>">Contact Us</a>
                </div>
            </div>

            <div class="aside" aria-hidden="true">
                <div class="aside-card">
                    <p class="aside-top">Hotel H Plus</p>
                    <p class="aside-title">Stay on course.</p>
                    <p class="aside-copy">
                        Premium comfort, warm hospitality, and a quicker path back to the pages your guests actually need.
                    </p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
