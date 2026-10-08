# Hotel H Plus System: Feature Audit and Future Roadmap

## Purpose

This document explains what the hotel system already includes, why it is useful for hotel owners, and what can be added in future to make daily hotel operations easier, safer, and more professional.

The system is no longer only a hotel website. It is now a hotel operations platform with website CMS, room booking, events, payment gateway, staff access, GST receipts, SEO tools, and owner-only controls.

## Why Choose This System

- Built for hotel operations, not just a brochure website.
- Website, rooms, bookings, events, payments, receipts, staff, and SEO are managed from one admin panel.
- Supports both online and offline hotel workflows.
- Owner has control over sensitive actions like refunds, delete permissions, payment settings, GST, developer tools, and user access.
- Payment gateway flow supports Razorpay and Cashfree, with webhook tracking and transaction rechecks.
- The system is future-safe because roles, permissions, developer tools, templates, receipt styles, GST settings, and event payments are already modular.

## Current Feature Set

### Public Website

- Home page.
- About page.
- Rooms and room detail pages.
- Events page.
- Gallery page.
- Contact page.
- FAQ page.
- Privacy Policy page.
- Terms and Conditions page.
- Thank You page.
- Guest booking lookup page.
- Public sitemap and robots.txt support.
- Mobile responsive frontend structure.

### Room Booking

- Public room booking form.
- Server-side price verification so users cannot manipulate JavaScript totals.
- Server-side room count validation so users cannot submit more rooms than available.
- Room availability by date period.
- Multiple room booking support for families or groups.
- Guest count and room count logic.
- Max guests per room type support.
- Admin manual booking.
- Admin booking calendar.
- Booking status management.
- Booking receipt download.
- Guest booking lookup from public website.
- Booking email notification to admin.
- Guest booking auto reply email.

### Room Management

- Admin room listing.
- Create room.
- Edit room.
- Delete room with permission control.
- Room images and gallery images.
- Room pricing.
- Room availability status.
- Room booking open/closed control.
- Total available room units per room type.
- Max guest capacity per room type.
- Starter room import.

### Events Management

- Public event enquiry flow.
- Admin event enquiries inbox.
- Admin event calendar.
- Create offline/manual event from admin.
- Edit event.
- Confirm or cancel event.
- Event status management.
- Event services management.
- Event packages management.
- Event page CMS.
- Event gallery/glimpse management.
- Event payment links.
- Event manual advance recording for cash, GPay, PhonePe, bank transfer, etc.
- UTR/reference optional for manual payments.
- Event payment records.
- Cancel pending event payment links.
- Share payment link by WhatsApp, email, or copy link.
- Event payment receipt download.

### Trident/Event Legacy Module

- Trident enquiry management.
- Trident event list.
- Trident event create/edit/delete.
- Trident page content settings.
- Trident page is currently kept for future reuse and can remain disabled publicly.

### Payments and Transactions

- Payment manager.
- Razorpay support.
- Cashfree support.
- Sandbox and production environment support.
- Gateway-controlled booking toggle.
- Payment transaction list.
- Transaction detail page.
- Gateway order ID and payment ID tracking.
- Payment recheck with gateway.
- Webhook logs.
- Technical gateway data kept owner-only.
- Payment records for both room bookings and event payments.

### Refunds

- Refund available only for cancelled bookings.
- Confirmed bookings do not expose refund action.
- Refund OTP protection.
- OTP sent to owner/admin hotel-domain email.
- OTP sent email is recorded for audit safety.
- Refund status recheck.
- Guest refund notification email.
- Booking remains cancelled after refund and is not silently changed.
- Refund permissions are owner controlled.

### Billing, Receipts, and GST

- Receipt/invoice prefix setting.
- GST invoice enable/disable setting.
- GST rate setting.
- GST label and GSTIN setting.
- GST-inclusive receipt calculation.
- GST rows shown only when GST is enabled.
- Receipt PDF for bookings.
- Receipt PDF for event payments.
- Receipt style manager in Developer Tools.
- Multiple receipt visual presets:
  - Classic
  - Signature
  - Minimal
- Admin receipt style preview.
- Selected receipt style is used in customer-downloaded PDFs.

### Email and Reply System

- SMTP settings.
- Booking admin notification email.
- Booking guest auto reply.
- Event guest auto reply.
- Event payment link email.
- Subscriber welcome email.
- Refund OTP email.
- Refund processed email.
- Developer email template manager.
- Preview-first email template UI.
- Template placeholders such as:
  - `{hotel_name}`
  - `{guest_name}`
  - `{hotel_contact}`
  - `{room_name}`
  - `{checkin}`
  - `{checkout}`
  - `{rooms_required}`
  - `{guests}`
  - `{event_type}`
  - `{event_date}`
  - `{amount}`
  - `{payment_code}`
  - `{payment_link}`

### Admin Users and Permissions

- Owner, admin, and staff roles.
- User creation.
- User editing.
- Password update.
- Role permissions page.
- Future-safe permission override model.
- Last login tracking support.
- Owner-only delete controls.
- Owner-only sensitive settings.
- Staff/admin restricted from technical owner-only data.
- Owner can control role capabilities without changing core code.

### Activity and Audit Logs

- Admin activity logs.
- Settings changes logged.
- Room edits/deletes logged.
- Payment configuration changes logged.
- Refund actions logged.
- User and permission-sensitive actions can be tracked.
- Activity logs hidden from admin/staff unless permission allows.

### CMS and Content Management

- Hotel details settings.
- Branding settings.
- Logo and favicon settings.
- Media library.
- Image upload.
- Media metadata edit fields.
- Gallery management.
- Homepage image/content settings.
- About page image/content settings.
- Room page content settings.
- Legal page hero image settings.
- Event page CMS.
- Trident page content settings.

### SEO and Developer Tools

- Developer Mode toggle.
- SEO Manager visible only in Developer Mode.
- SEO tracked pages.
- Global SEO settings.
- Route scanner.
- Sitemap support.
- Image sitemap support.
- Robots.txt support.
- Email Templates visible only in Developer Mode.
- Receipt Styles visible only in Developer Mode.

### Security and Reliability

- Admin authentication.
- Role-based access control.
- Owner-only destructive actions.
- Payment secret fields encrypted/protected.
- Secret fields not exposed as readable values in normal admin use.
- Login rate limit settings.
- Refund OTP rate limit settings.
- CSRF protected forms.
- Server-side validation for critical booking/payment values.

## Recommended Future Features

These are the most useful next features for real hotel operations.

## Priority 1: Must-Have Hotel Operations

### 1. GST and Tax Invoice Upgrade

Current system already supports GST enable/disable and GST receipt rows. Future improvements:

- Add guest GSTIN field during booking for business travelers.
- Add company name and billing address fields.
- Add place of supply.
- Add invoice number sequence table instead of generating receipt number only from booking/payment code.
- Add credit note for refunds.
- Add tax report by date range.
- Add GST summary export for accountant:
  - Taxable value
  - CGST
  - SGST
  - IGST if needed
  - Total invoice value
- Add HSN/SAC code setting.
- Add invoice PDF separate from payment receipt when required.

Why this matters:
Hotels often need official invoices for corporate guests, accountant filing, and GST compliance.

### 2. Staff Task and Duty Management

Add a staff operations module:

- Housekeeping tasks.
- Room cleaning status:
  - Dirty
  - Cleaning
  - Ready
  - Maintenance
- Assign task to staff.
- Task due time.
- Task notes.
- Staff completion status.
- Owner/admin task dashboard.
- Daily checklist:
  - Room cleaning
  - Linen change
  - Bathroom restock
  - AC/TV check
  - Checkout inspection

Why this matters:
Hotels run on repeated daily tasks. A simple staff task board can reduce phone calls, missed cleaning, and confusion.

### 3. Room Inventory and Housekeeping Calendar

Improve room availability from room type level to actual unit level:

- Room numbers under each room type.
- Room status by date.
- Block room for maintenance.
- Assign room number to booking.
- Move guest from one room number to another.
- View occupancy calendar by room number.

Why this matters:
Current room type inventory protects overbooking, but actual hotel operation eventually needs room number assignment.

### 4. Check-in and Check-out Workflow

Add a proper front desk workflow:

- Mark booking as checked-in.
- Mark booking as checked-out.
- Upload guest ID proof.
- Add number of adults/children.
- Add vehicle number.
- Add expected arrival time.
- Add late checkout flag.
- Add internal notes visible to staff.
- Generate registration card.

Why this matters:
Confirmed booking is not enough. Front desk needs arrival, identity, room allocation, and checkout control.

### 5. Payments Ledger

Create a hotel ledger for all money movements:

- Room booking payment.
- Event advance.
- Manual cash/GPay/bank payment.
- Refund.
- Discount.
- Extra charges.
- Pending balance.
- Daily collection summary.
- Payment method breakdown.

Why this matters:
Owners need to know actual money received, gateway money, cash, refund, and pending balance in one place.

## Priority 2: Sales, Guest Experience, and Owner Convenience

### 6. Offers and Rate Plans

Add pricing rules:

- Weekend price.
- Seasonal price.
- Festival price.
- Corporate rate.
- Coupon code.
- Extra guest charge.
- Extra bed charge.
- Child policy.

Why this matters:
Hotels do not always sell rooms at one fixed rate. Rate plans help increase revenue without editing each room manually.

### 7. Guest CRM

Create a guest profile automatically from bookings:

- Guest name, phone, email.
- Booking history.
- Total spend.
- Last stay.
- Notes.
- Repeat guest badge.
- Birthday/anniversary if collected.
- Blacklist/watchlist option if owner wants.

Why this matters:
Repeat customers are valuable. Staff should know if a guest stayed before.

### 8. WhatsApp Communication Manager

Add structured WhatsApp templates:

- Booking confirmation.
- Payment link.
- Check-in reminder.
- Checkout reminder.
- Event enquiry follow-up.
- Balance due reminder.
- Feedback request.

Why this matters:
Indian hotels often work heavily through WhatsApp. A controlled WhatsApp workflow saves time and keeps messaging consistent.

### 9. Auto Reply Rules

Current templates exist. Future rules can make them smarter:

- Different reply templates by room type.
- Different reply templates by event type.
- Auto reply only during off-hours.
- Auto follow-up after 24 hours if enquiry is unread.
- Auto payment reminder before booking expiry.

Why this matters:
Owners can automate basic communication without hiring extra staff.

### 10. Booking Expiry and Hold System

Add temporary room hold:

- Hold room for 10/15/30 minutes during payment.
- Auto release room if payment fails or expires.
- Admin hold for phone bookings.
- Hold expiry alert.

Why this matters:
Prevents double booking while guest is completing payment.

## Priority 3: CMS and Website Growth

### 11. Full CMS Pages

Current CMS covers many hotel pages and images. Future CMS can add:

- Custom pages.
- Drag-and-sort sections.
- Testimonials manager.
- FAQ manager.
- Offers banner manager.
- Pop-up notice manager.
- Menu/restaurant page if hotel has dining.
- Nearby attractions page.

Why this matters:
The hotel can update marketing content without calling a developer for every small change.

### 12. Blog or Local Guide

Add simple blog/local guide:

- Kurukshetra travel guide.
- Nearby places.
- Wedding planning guide.
- Hotel updates.
- SEO-friendly articles.

Why this matters:
Useful for organic search and local hotel marketing.

### 13. Review and Feedback Manager

Add post-stay feedback:

- Send feedback link after checkout.
- Capture rating and comment.
- Flag unhappy guests before public review.
- Show approved testimonials on website.

Why this matters:
Helps improve service and protects online reputation.

## Priority 4: Reporting and Owner Dashboard

### 14. Owner Dashboard Upgrade

Add business metrics:

- Today's arrivals.
- Today's departures.
- Today's occupancy.
- Available rooms by type.
- Pending payments.
- Cancelled bookings.
- Refund requests.
- Event enquiries due for follow-up.
- Cash vs gateway collection.
- This month revenue.

Why this matters:
Owner should understand hotel status in 30 seconds.

### 15. Export and Backup Routines

Add export tools:

- Bookings CSV.
- Payments CSV.
- GST report CSV.
- Event enquiries CSV.
- Guests CSV.
- Full database backup download for owner.
- Scheduled backup to server/cloud.

Why this matters:
Hotels need safety against data loss and accountant-friendly exports.

### 16. Audit Log Export

Add export/filter for activity logs:

- Filter by user.
- Filter by action.
- Filter by date.
- Export CSV.
- Highlight sensitive actions.

Why this matters:
Useful when staff roles grow and owners need accountability.

## Priority 5: Integrations

### 17. OTA and Channel Manager Integration

Future integration options:

- Booking.com.
- Agoda.
- MakeMyTrip/Goibibo.
- Airbnb.
- Channel manager API if hotel already uses one.

Why this matters:
Prevents overbooking between website and OTA platforms.

### 18. Google Calendar Sync

Sync:

- Room bookings.
- Event bookings.
- Staff tasks.

Why this matters:
Useful for smaller hotels where owners manage schedules from phone calendars.

### 19. Accounting Integration

Possible future integrations:

- Tally export.
- Zoho Books export.
- GST report format for accountant.

Why this matters:
Reduces manual accounting work.

## Priority 6: Advanced Controls

### 20. Multi-Property Support

If owner has more than one property:

- Property switcher.
- Property-specific rooms.
- Property-specific staff.
- Property-specific payment settings.
- Consolidated owner dashboard.

Why this matters:
Makes the system scalable for hotel groups.

### 21. Advanced Permission Builder

Current permission system is future-safe. A more advanced version can add:

- Custom roles.
- Per-module access.
- Per-action access.
- Per-staff data visibility.
- Shift-based access.

Why this matters:
Large hotels need more than owner/admin/staff.

### 22. Notification Center

Add in-admin notifications:

- New booking.
- Payment received.
- Refund requested.
- New event enquiry.
- Room full alert.
- Booking cancelled.
- Failed payment.

Why this matters:
Admins should not rely only on email or WhatsApp.

## Suggested Implementation Order

1. GST invoice upgrade with guest GSTIN and tax exports.
2. Staff task and housekeeping module.
3. Room number inventory and room assignment.
4. Check-in/check-out workflow.
5. Payments ledger and daily collection report.
6. Owner dashboard upgrade.
7. Booking hold/expiry system.
8. WhatsApp communication manager.
9. Guest CRM.
10. Export and backup routines.
11. Review/feedback manager.
12. Full CMS custom pages.
13. OTA/channel manager integration.

## Current System Strength

The current system is already solid for:

- Running a hotel website.
- Receiving room booking requests.
- Taking online payments.
- Handling event enquiries and event advances.
- Managing rooms, events, payments, users, and settings.
- Generating receipts with optional GST.
- Managing SEO and developer tools.
- Protecting owner-only sensitive actions.

## Main Gaps Before Calling It a Complete Hotel PMS

To become a full hotel property management system, the biggest missing pieces are:

- Room number assignment.
- Housekeeping/staff task workflow.
- Check-in/check-out register.
- Guest ID/KYC storage.
- Advanced GST/tax invoice export.
- Ledger and daily cash collection reports.
- OTA/channel manager sync.

## Final Recommendation

This system is already strong as a hotel website plus admin operations platform. The best next direction is not adding random features, but turning it step by step into a lightweight PMS:

1. Improve billing and GST.
2. Add staff/housekeeping workflows.
3. Add room number level inventory.
4. Add check-in/check-out workflow.
5. Add owner reports and exports.

That path will make the system useful not only for online bookings, but for daily hotel management.
