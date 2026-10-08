# Frontend Content Mapping Plan

This plan defines what should stay hardcoded, what should come from Media Library, and what should be managed from admin for the full Hotel H Plus website.

The goal is:

- keep the frontend stable
- avoid building a heavy page builder
- let admin change images quickly
- map only content that is operationally useful to change

## Core Decision

Do **not** build a generic `Pages` editor right now.

Use this structure instead:

1. `Media Library`
2. `Global Settings`
3. `Rooms`
4. `Trident`
5. `SEO Manager`

This is the cleanest model for this website.

## Content Rules

### 1. Keep Hardcoded

Use hardcoded content for:

- brand storytelling
- decorative headings
- legal structure
- static FAQ wording
- static policy copy
- team/about narrative
- testimonials unless there is a real workflow to update them

Reason:
This content does not change often and is safer in views/templates.

### 2. Map From Media Library

Use Media Library for any important website image that may need replacement later.

Store only the selected image path or media reference in DB/settings.

### 3. Map As Admin Data

Use admin-managed DB/settings only for:

- rooms
- prices
- feature lists
- galleries
- Trident events
- Trident packages
- contact info
- booking info
- selected stats or promos
- SEO

## Recommended Admin Structure

### Global Areas

- `Media Library`
- `Settings`
  - Hotel Details
  - Branding
  - SMTP
  - Booking
  - Room Page
  - Trident Page
  - System
- `SEO Manager`

### Dynamic Modules

- `Rooms`
- `Trident`
  - Page Settings
  - Event List
  - Facilities
  - Packages
  - Enquiries

## Page-by-Page Mapping

---

## 1. Shared Header / Footer

### Map from admin

- logo
- favicon
- phone
- WhatsApp
- email
- address
- footer brand text
- social links

### Keep hardcoded

- nav labels
- static menu order
- reserve button text

### Use media

- header logo
- footer logo if separate
- favicon

---

## 2. Home Page

File:
- `app/Views/front/home.php`

### Keep hardcoded

- most section structure
- service card wording
- testimonial wording
- CTA decorative copy if not expected to change

### Map from admin

- hero eyebrow/title/description if already used
- hero guest count
- review text
- hotel stats
- rooms section heading/description if already used
- promo/offer text if marketing wants to update it

### Use media

- hero main image
- hero secondary image
- about main image
- about secondary image
- offer image
- gallery preview images

### Use dynamic modules

- featured rooms should come from `Rooms`

### Recommended implementation

- create a `Home Media` subsection in settings
- use media picker fields for each homepage image slot
- keep testimonials hardcoded for now

---

## 3. About Page

File:
- `app/Views/front/about.php`

### Keep hardcoded

- story text
- why choose us text
- team section text
- team names/roles unless there is an actual HR/update workflow

### Use media

- story main image
- story secondary image
- team photos
- about CTA background image

### Map from admin

- none required now except global hotel info already used

### Recommended implementation

- add an `About Media` subsection
- do not build an editable about-page text manager

---

## 4. Rooms Listing

File:
- `app/Views/front/rooms.php`

### Already should be dynamic

- room names
- room images
- room price
- max guests
- room description
- amenities
- slug

### Keep hardcoded

- comparison layout
- reserve/view button text

### Use media

- all room featured images

### Recommended implementation

- continue using `Rooms` as primary admin owner

---

## 5. Room Detail Page

File:
- `app/Views/front/room_detail.php`

### Already should be dynamic

- room gallery
- featured image
- room name
- price
- guest count
- amenities
- related rooms

### Keep hardcoded

- review cards
- static decorative copy

### Map from admin

- shared room policy labels and booking timings via settings

### Use media

- featured image
- gallery images

### Recommended implementation

- no generic page system needed
- room module is the owner

---

## 6. Trident Page

File:
- `app/Views/front/trident.php`

### Map from admin

- page settings:
  - hero eyebrow/title/highlight
  - overview text
  - capacity
  - venue area
  - contact block text
  - CTA text
  - guest ranges
- event list:
  - event title
  - event description
  - event icon
- later:
  - facilities
  - packages

### Use media

- hero image
- overview secondary image
- facilities section image
- Trident gallery images

### Keep hardcoded

- section structure
- decorative headings where no operational value exists
- testimonials until needed

### Recommended implementation

Current standard should become:

- `Trident Page Settings`
- `Trident Event List`
- `Trident Facilities`
- `Trident Packages`
- `Trident Enquiries`

### Important rule

Event enquiry dropdown event types should come from `Trident Event List`, not a duplicate settings field.

---

## 7. Gallery Page

File:
- `app/Views/front/gallery.php`

### Use media / DB

- all gallery images
- category
- caption

### Keep hardcoded

- intro copy
- filter labels if categories stay fixed

### Recommended implementation

- the gallery page should be fully media-driven
- if the current `gallery` table is weaker than `media_files`, unify later so gallery selection comes from Media Library

---

## 8. Contact Page

File:
- `app/Views/front/contact.php`

### Map from admin

- phone
- email
- address
- WhatsApp

### Use dynamic data

- room options in enquiry form

### Keep hardcoded

- form labels
- layout copy

### Use media

- only if there is a banner, map image from media

---

## 9. FAQ Page

File:
- `app/Views/front/faq.php`

### Keep hardcoded

- FAQ questions and answers

### Map from admin

- none required now

### Reason

Unless the team expects frequent FAQ updates, admin editing here adds complexity with little value.

---

## 10. Thank You Page

File:
- `app/Views/front/thank_you.php`

### Map from admin

- hotel phone
- hotel email

### Keep hardcoded

- message copy
- buttons

### Use media

- none required

---

## 11. Privacy Policy / Terms

Files:
- `app/Views/front/privacy_policy.php`
- `app/Views/front/terms_conditions.php`

### Keep hardcoded

- legal sections
- legal wording structure

### Map from admin

- hotel name
- hotel email
- hotel phone
- hotel address

### Use media

- optional hero background image only if branding wants control

---

## Image Mapping Master List

These should be controllable from Media Library:

### Branding

- site logo
- favicon

### Home

- hero main image
- hero secondary image
- about main image
- about secondary image
- offer image
- gallery preview image 1
- gallery preview image 2
- gallery preview image 3
- gallery preview image 4
- gallery preview image 5
- gallery preview image 6

### About

- story main image
- story secondary image
- team member image 1
- team member image 2
- team member image 3
- CTA background

### Rooms

- room featured image
- room gallery images

### Trident

- hero image
- secondary venue image
- facilities image
- gallery image set

### Legal / Misc

- legal hero background if desired

## What Should Be Built Next

### Phase 1: Image Mapping Everywhere

Implement media-driven image fields for:

- home
- about
- Trident
- legal hero backgrounds if needed

This gives the admin immediate practical control.

### Phase 2: Finish Trident Dynamic Modules

Build:

- `Trident Facilities`
- `Trident Packages`

Keep testimonials hardcoded for now.

### Phase 3: Gallery / Media Cleanup

Unify gallery selection with Media Library so image ownership is consistent.

### Phase 4: Optional Homepage Refinement

Only if needed:

- homepage services
- homepage testimonials
- homepage gallery preview source

## What Should Not Be Built Right Now

Avoid:

- generic page builder
- inline click-to-edit system
- full editable CMS for every paragraph
- file-based page text editor

Reason:

- too much complexity
- hard to maintain
- unnecessary for this site
- increases risk of breaking layout consistency

## Final Recommendation

For Hotel H Plus, the right model is:

- hardcoded content for stable brand/story sections
- media-driven image control everywhere
- module-driven dynamic sections for rooms and Trident
- settings-driven contact, branding, booking, and SEO

That gives admin useful control without turning the project into a heavy CMS.
