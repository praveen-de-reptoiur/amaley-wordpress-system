# Amaley Card Design System Lock

Status: Active design lock  
Owner: Praveen  
Locked after: Amaley Core v1.0.67 Cluster Archive Card + Gallery Polish testing  
Applies to: Amaley Core, Amaley Discovery, Amaley Templates, Amaley Compact Widgets, and every future Amaley section/widget that renders Cluster, SHG Group, Member/Producer, or Product cards.

---

## 1. Purpose

This document locks the approved Amaley card design families so future work does not keep changing card style from page to page.

The accepted visual reference is the live-tested v1.0.67 rhythm on:

- Cluster Archive cards.
- Cluster Single related SHG cards.
- Cluster Single related Producer cards.
- Cluster Single mapped Product cards.

These card families are now permanent design references. Any future plugin/widget/template must reuse this system instead of inventing a new card style.

---

## 2. Non-negotiable rule

Do not redesign these cards casually.

Cards may only be adjusted for:

- Bug fixes.
- Responsive fixes.
- Missing control exposure.
- Small spacing polish within the same design family.
- Data-specific variations that preserve the same visual rhythm.

Cards must not be visually changed just because a new page, archive, discovery layout, or template is being built.

---

## 3. Locked card families

### 3.1 Cluster Card

The approved Cluster Card design is the Cluster Archive card style after v1.0.67.

Use this same card design wherever Cluster cards appear:

- Cluster Archive.
- Cluster Single related cluster sections.
- SHG Single linked cluster section.
- Product origin traceability panel.
- Discovery Engine cluster results.
- Compact Widgets cluster sections.
- Future homepage/landing sections showing clusters.

Locked behaviour:

- Same card shell.
- Same image/placeholder area.
- Same typography hierarchy.
- Same chips/tags rhythm.
- Same stat boxes for SHGs/producers where relevant.
- Same CTA/button family.
- Same hover/motion direction.
- Same responsive behaviour.

Data/details may change by context, but the design family must remain the same.

---

### 3.2 SHG Group Card

The approved SHG Group Card design is the related SHG card style shown on Cluster Single after v1.0.67.

Use this same design wherever SHG Group cards appear:

- SHG Archive.
- Cluster Single SHGs connected with this cluster.
- Product origin traceability panel.
- Discovery Engine SHG results.
- Future SHG recommendation/related sections.

Locked behaviour:

- Same top visual/placeholder treatment.
- Same verification badge treatment.
- Same title, description, details, chips and CTA rhythm.
- Same compact premium card spacing.
- Same image rule: cover + center center when a real image exists.

---

### 3.3 Member / Producer Card

The approved Member/Producer Card design is the related Producer card style shown on Cluster Single after v1.0.67.

Use this same design wherever Member/Producer cards appear:

- Member/Producer archive.
- Cluster Single producer section.
- SHG Single member/producer section.
- Product origin traceability panel.
- Discovery Engine producer/member results.

Locked behaviour:

- Same top visual/initial placeholder treatment.
- Same role/village/details structure.
- Same chips/tags rhythm.
- Same CTA/button family.
- Same compact card height direction.

---

### 3.4 Product Card

The approved Product Card design is the compact Amaley product card shown in the latest accepted screenshots and must be reused across:

- Cluster Single mapped products.
- SHG Single mapped products.
- Product discovery/results.
- Product origin sections.
- Future product grids using Amaley custom widgets.

Locked behaviour:

- Product image visible, stable and premium.
- Image rule: cover + center center.
- Title, description, price, origin, chips and CTA retain the same hierarchy.
- Product description must have word-limit / line-clamp control.
- CTA button must remain clean and full-width unless the section design explicitly needs a compact variant.

WooCommerce remains the source for product data, but the card shell belongs to the approved Amaley card design system.

---

## 4. Image rule for all cards

Every card that uses an image must support:

- Image fit: cover by default.
- Image position: center center by default.
- Image height control.
- Desktop, tablet and mobile image height controls wherever practical.
- Placeholder treatment when no image exists.

Do not stretch images awkwardly. Do not make cards taller only because too many chips/descriptions are shown.

---

## 5. Description and text controls

Every card family must provide practical content controls:

- Description show/hide.
- Description word limit.
- Description line clamp.
- Chips/tags show/hide.
- Chips/tags maximum count.
- Details/meta show/hide.
- CTA show/hide.
- CTA label and URL controls where the widget is manual/static or section-driven.

The card must not become oversized because all text/chips are forced to show.

---

## 6. Section-level buttons are mandatory

Any archive/single section that shows a limited preview of cards must include a section-level button.

Examples:

- Cluster Single → SHGs connected with this cluster → show 4 cards + button to SHG archive/details.
- Cluster Single → People behind the cluster → show 4 cards + button to all producers/members.
- Cluster Single → Products mapped to this cluster → show limited products + button to product/shop/discovery page.
- SHG Single → Members and producers → show limited cards + button.
- SHG Single → Mapped products → show limited products + button.

Section-level button controls must include:

- Show/hide.
- Button text.
- Button URL.
- Alignment.
- Style controls.
- Responsive behaviour.

This applies across all future templates, not only Cluster Single.

---

## 7. Controls rule

Every card-rendering widget must follow the full-control standard already locked for Amaley:

- Data/source controls.
- Query/limit/order controls where relevant.
- Content show/hide controls.
- Layout controls.
- Alignment controls.
- Typography controls.
- Color controls.
- Spacing controls.
- Card radius/border/shadow controls.
- Image controls.
- Button controls.
- Motion/transform controls.
- Responsive controls.
- Empty-state controls.

Do not create half-controlled widgets.

---

## 8. Motion / transform rule

Motion should add life, not heaviness.

Default animation must be:

- Smooth.
- Light.
- Controllable.
- Disabled or reduced when needed.
- Safe for mobile.

Motion controls should include, where practical:

- Enable/disable motion.
- Hover lift amount.
- Hover scale amount.
- Image zoom amount.
- Transition duration.

Avoid heavy transforms, jumpy hover effects, and repeated stacked animation patches.

---

## 9. CSS safety rule

Card CSS must remain clean and scoped.

Rules:

- No global CSS overrides.
- No header/footer interference.
- No WooCommerce cart/checkout interference.
- No discovery/filter interference unless intentionally working inside Discovery Engine.
- No repeated patch stacking.
- Avoid `!important`; use only when absolutely required and document the reason.
- Prefer one clean card system over multiple per-page variations.

---

## 10. Template/preset direction

Future improvement should create reusable card templates/presets so Praveen can select a known card family instead of rebuilding styles every time.

Suggested internal preset names:

- Amaley Cluster Card — Locked v1.
- Amaley SHG Group Card — Locked v1.
- Amaley Member/Producer Card — Locked v1.
- Amaley Product Card — Locked v1.

These presets should be reusable in Elementor-native widgets and future Discovery/Templates modules.

---

## 11. Future work rule

Before building or changing any page that displays cards, check this document first.

If a new page needs Cluster, SHG, Member/Producer or Product cards, reuse the locked card design family.

Do not invent another card design.

Do not change the accepted card visual language unless Praveen explicitly approves a new locked version.
