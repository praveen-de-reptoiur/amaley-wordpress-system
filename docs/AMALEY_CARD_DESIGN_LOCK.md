# AMALEY CARD DESIGN LOCK

Status: Active visual component lock  
Owner: Praveen  
Date locked: 2026-06-01  
Applies to: Amaley Core CPT cards, product cards inside Amaley Core sections, archive widgets, single-page related-card sections, and future Discovery/Template reuse where these cards appear.

---

## Why this lock exists

Cluster cards, SHG cards, Member / Producer cards and Product cards were visually reviewed and approved during the Amaley Core v1.0.74 work.

These card designs must now be treated as reusable locked components. They should not be redesigned page by page.

The same card type must look the same wherever it appears.

---

## Master rule

Do not randomly change card design again.

If a card type appears on Cluster Archive, Cluster Single, SHG Archive, SHG Single, Member pages, product-origin sections, or later Discovery pages, it must use the same locked card family.

Bug fixes are allowed. Visual redesign is not allowed unless Praveen explicitly unlocks the card design.

---

## Locked card families

### 1. Cluster card

Use the approved Cluster card design wherever Cluster cards appear.

Required visual pattern:

- Premium ivory / cream card body.
- Top image or visual area.
- Image must be visible and controlled with `object-fit: cover; object-position: center center;`.
- Region / source label.
- Cluster title.
- Short cluster description.
- Controlled chips / tags.
- Compact stat boxes such as SHGs and Producers.
- Full-width dark chocolate CTA button.
- Same border, radius, shadow and spacing family across the site.

Do not create a separate Cluster card design for another page.

### 2. SHG / Producer Group card

Use the approved SHG card design for SHG Groups / Producer Groups.

Required visual pattern:

- Top image / visual area with image visible as cover center center.
- Verified badge shown on the visual area when status is verified.
- Card body label such as `SHG`.
- SHG / Producer Group title.
- Short controlled description.
- Detail boxes for Village, District, Members, Verification and Contact where available.
- Chips/tags controlled so they do not make the card unnecessarily tall.
- CTA button such as `View Collective Details`.
- Same card family on SHG Archive and Cluster Single SHG section.

If verified is already shown as a badge, do not duplicate status in a visually confusing way unless the widget has a clear show/hide control.

### 3. Member / Producer card

Use the approved Member / Producer card family wherever producer/member cards appear.

Required visual pattern:

- Top image / visual area with image visible as cover center center.
- Type label such as `Producer` or `Member`.
- Name / title.
- Short role or profile text.
- Detail boxes such as Role and Village.
- Skill/product chips with max count control.
- CTA button such as `View Producer Profile`.

Do not invent a new producer card style for each page.

### 4. Product card

Use the approved compact product card for Amaley product references.

Required visual pattern:

- Product image fully visible as cover center center.
- Product label.
- Product title.
- Controlled description excerpt.
- Price box and Origin box aligned properly without text clipping.
- Traceability badges such as `Traceable` and `Origin linked`.
- Full-width rust CTA button.
- Same design should later be reused in Discovery where practical.

Product card design must not be changed casually while integrating it into Discovery or Template modules.

---

## Mandatory controls for card widgets

Every card/grid widget that renders these cards should include practical controls for:

- Data source / preview source.
- Limit.
- Include / exclude where relevant.
- Order and order by.
- Columns desktop / tablet / mobile.
- Card width / grid gap.
- Image show/hide.
- Image height / aspect ratio.
- Image object fit and position, defaulting to cover center center.
- Title show/hide and typography.
- Description show/hide.
- Description word count / excerpt length.
- Details boxes show/hide.
- Individual detail visibility where practical.
- Chips/tags show/hide.
- Max chips/tags.
- Chips row control where practical.
- CTA button show/hide.
- Button text and URL.
- Button alignment desktop / tablet / mobile.
- Section-level button show/hide, text, URL and alignment when the section previews only limited cards.
- Empty-state message.
- Hover / transform controls.
- Animation enable/disable, intensity, duration and delay.
- Responsive desktop / tablet / mobile spacing.

---

## Section-level CTA button rule

Whenever a section shows a limited set of cards, for example 4 SHGs, 4 producers, 4 products or 4 clusters, the section should have an optional section-level CTA button.

Examples:

```text
View all SHGs
View all producers
View all products
View all clusters
```

This button must have show/hide, text, URL, alignment and responsive controls.

The button must remain visible against the background and must not blend into the page color.

---

## Animation and transform rule

Cards may use smooth, light transformations so the page feels alive.

Allowed:

- subtle hover lift
- subtle shadow change
- light image scale
- soft fade/slide entrance where useful

Avoid:

- heavy motion
- large jumps
- repeated aggressive animation
- animation libraries
- motion that hurts mobile performance

Animations must be controllable and should respect reduced-motion behaviour where practical.

---

## Non-negotiable image rule

For Cluster, SHG, Member and Product cards, images must be displayed as:

```css
object-fit: cover;
object-position: center center;
```

There must be controls to adjust image height / ratio where practical.

Image handling should not crop the main subject badly, and card image areas should remain consistent across the grid.

---

## Plugin safety rule

The card lock does not allow global CSS dumps.

All card CSS must remain scoped to Amaley plugin/card classes.

Do not override theme, header, footer, cart, checkout, unrelated WooCommerce templates, or Elementor global styles.

Keep the plugin lightweight. No heavy animation libraries or unnecessary JavaScript.

---

## Current implementation checkpoint

Current source checkpoint:

```text
Amaley Core v1.0.74
```

This version is the current GitHub source checkpoint after SHG archive/single polish, card lock discussion, gallery/media field direction, button alignment controls and product-card correction work.

---

## Final lock statement

Cluster card, SHG card, Member / Producer card and Product card designs are now locked.

Future work may improve data accuracy, responsive controls, accessibility, bug fixes and performance, but must not visually redesign these card families without explicit approval from Praveen.
