# Hotel H Plus Management System

Hotel H Plus is a CodeIgniter 4 based hotel website and operations platform. It combines a public hotel website with an admin panel for rooms, bookings, events, payments, receipts, GST settings, staff access, CMS content, SEO, and owner-only controls.

This project is designed for a hotel that needs more than a brochure website: it supports real booking operations, payment tracking, event advances, admin workflows, and future PMS-style expansion.

## Current Features

### Public Website

- Home, About, Rooms, Events, Gallery, Contact, FAQ, Privacy Policy, Terms, and Thank You pages.
- Room detail pages with booking form.
- Public guest booking lookup.
- Public sitemap, image sitemap, and robots.txt support.
- Mobile responsive frontend assets.

### Room Booking

- Public room booking flow.
- Server-side price verification.
- Server-side room availability validation.
- Multiple rooms per booking for families/groups.
- Max guests per room type.
- Room type availability by date period.
- Admin manual booking.
- Admin booking calendar.
- Booking status management.
- Booking receipt download.
- Guest booking lookup.
- Admin booking notification email.
- Guest auto reply email.

### Room Management

- Room list, create, edit, and delete.
- Room pricing and booking status.
- Total available room units per room type.
- Max guest capacity per room type.
- Room images and gallery images.
- Starter room import.

### Events Management

- Public event enquiry form.
- Admin event enquiries inbox.
- Event calendar.
- Manual/offline event creation from admin.
- Event edit/status management.
- Event services and packages.
- Event page CMS.
- Event payment links.
- Manual event advances for cash, GPay, PhonePe, bank transfer, etc.
- Optional UTR/reference for manual payments.
- Cancel pending event payment links.
- Share payment links by WhatsApp, email, or copy link.
- Event payment receipt download.

### Payments

- Payment manager for gateway transactions.
- Razorpay support.
- Cashfree support.
- Sandbox and production settings.
- Gateway order/payment ID tracking.
- Payment recheck with gateway.
- Webhook logs.
- Booking and event payment records.
- Owner-only technical payment data.

### Refunds

- Refunds available only for cancelled bookings.
- Confirmed bookings do not show refund actions.
- OTP-protected refund flow.
- Refund OTP sent to hotel-domain owner/admin email.
- OTP recipient email recorded for audit safety.
- Refund recheck.
- Guest refund notification email.
- Booking remains cancelled after refund.

### Billing, GST, and Receipts

- Receipt/invoice prefix setting.
- GST invoice enable/disable.
- GST rate setting.
- GST label and GSTIN setting.
- GST-inclusive receipt calculation.
- GST rows shown only when enabled.
- PDF receipt for bookings and event payments.
- Developer receipt style manager.
- Receipt style presets:
  - Classic
  - Signature
  - Minimal
- Selected receipt style is used for customer-downloaded receipts.

### Email Templates

- SMTP configuration.
- Booking auto reply template.
- Event auto reply template.
- Event payment link email template.
- Preview-first template editor.
- Supported placeholders include `{hotel_name}`, `{guest_name}`, `{room_name}`, `{checkin}`, `{checkout}`, `{event_type}`, `{amount}`, and `{payment_link}`.

### Admin Users and Permissions

- Owner, admin, and staff roles.
- User creation and editing.
- Password update.
- Role permission overrides.
- Last login support.
- Owner-only delete/sensitive controls.
- Staff/admin restricted from owner-only technical information.

### Audit Logs

- Admin activity logs.
- Settings change logging.
- Room edit/delete logging.
- Payment configuration logging.
- Refund action logging.
- Permission-controlled access to activity logs.

### CMS and Media

- Hotel details settings.
- Branding, logo, favicon, and footer settings.
- Media library.
- Gallery management.
- Homepage content/images.
- About page images.
- Room page content settings.
- Legal page images.
- Event page content.
- Trident legacy event page settings.

### SEO and Developer Tools

- Developer Mode toggle.
- SEO Manager.
- Global SEO settings.
- Tracked pages and route scanner.
- Sitemap, image sitemap, and robots.txt.
- Developer-only Email Templates.
- Developer-only Receipt Styles.

## Future Roadmap

The full roadmap is documented in:

[HOTEL_SYSTEM_FEATURES_AND_ROADMAP.md](HOTEL_SYSTEM_FEATURES_AND_ROADMAP.md)

Recommended future modules:

- GST invoice upgrade with guest GSTIN, company name, billing address, SAC/HSN, invoice sequence, tax export, and credit notes.
- Staff task and housekeeping module.
- Actual room number inventory and room assignment.
- Check-in/check-out workflow with ID/KYC upload.
- Payments ledger and daily collection report.
- Occupancy, revenue, refund, and event reports.
- Booking hold/expiry system.
- WhatsApp communication manager.
- Guest CRM and repeat guest history.
- Review and feedback manager.
- Backup/export routines.
- OTA/channel manager integration.
- Accounting/Tally/Zoho export.
- Multi-property support.

## Server Requirements

- PHP 8.2 or higher.
- MySQL/MariaDB.
- Composer.
- Required PHP extensions:
  - intl
  - mbstring
  - json
  - mysqlnd
  - curl
  - openssl

## Setup

Install PHP dependencies:

```bash
composer install
```

Copy environment config:

```bash
cp env .env
```

Update `.env` with database, base URL, email, and production settings.

Run migrations:

```bash
php spark migrate
```

For frontend CSS build, install Node dependencies only on development/build machine:

```bash
npm install
npm run build:css
```

The live server does not need `node_modules` if `public/assets/web/css/tailwind.css` is already built.

## Deployment Notes

- Web server document root should point to the `public/` folder.
- Do not expose the project root directly.
- Do not commit or upload development `.env` values publicly.
- `writable/` must be writable by the server.
- `vendor/` is required at runtime. Either run Composer on server or upload `vendor` manually for shared hosting.
- `node_modules/` is not required on live server.

## Git Cleanup

The repository ignores:

- `.env`
- `node_modules/`
- `vendor/`
- runtime logs/cache/session/debugbar files
- backup archives
- OS/editor noise
- PHPUnit/build artifacts

Required writable folders are kept using `.gitkeep` placeholders.

## Testing

Run:

```bash
./vendor/bin/phpunit
```

Current suite covers key permission and application behaviors. A local warning about missing code coverage driver is expected if Xdebug/PCOV is not installed.

## Important Notes

- Payment gateway keys and webhook secrets must be configured in admin settings.
- Razorpay/Cashfree webhooks must use the live domain URL, not localhost.
- GST should be enabled only when the hotel needs GST invoice output.
- Developer Mode controls SEO Manager, Email Templates, and Receipt Styles visibility.
