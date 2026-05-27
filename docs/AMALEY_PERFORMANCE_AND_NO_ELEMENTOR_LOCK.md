# AMALEY PERFORMANCE AND NO-ELEMENTOR LOCK

Date locked: 2026-05-27  
Project: Amaley WordPress System  
Status: Permanent build rule for the fresh Amaley website

This file locks the performance and build direction for the future Amaley website.

It does not delete or overwrite earlier documentation. It adds a stricter rule for all future Amaley website sections, UI components, plugins, templates, buttons, cards, strips, product blocks, story blocks, and page systems.

---

## 1. Permanent Performance Rule

The Amaley website must remain extremely lightweight.

It must open fast even in low-network areas.

The site should not become slow now, after products are added, after sections are added, after origin data is added, or after future modules are added.

If a section looks premium but makes the site heavy, it is not approved.

If a feature depends on heavy scripts, unnecessary libraries, repeated CSS, uncontrolled DOM output, or slow queries, it must be redesigned before build.

---

## 2. Low-Network First Rule

The Amaley website must be designed for low-network and mobile-first access.

Every public-facing component must assume:

- Slow mobile internet
- Intermittent network
- Mobile-first browsing
- Product browsing on ordinary phones
- Limited bandwidth users
- Rural and semi-urban access conditions

The site must feel clean and fast, not overloaded.

---

## 3. No Elementor Dependency for New Amaley UI Sections

For the future clean Amaley build, new Amaley UI sections must not depend on Elementor default widgets.

Do not build future Amaley sections using:

- Elementor Heading widget
- Elementor Button widget
- Elementor Icon Box widget
- Elementor Image Box widget
- Elementor HTML widget
- Elementor generic section layouts as the main system
- Elementor-based raw HTML blocks for important page sections

Amaley must have its own controlled components.

This includes:

- Buttons
- Button groups
- Headings
- Heading strips
- Promise strips
- Product cards
- Product grids
- Story sections
- Media + text sections
- Trust strips
- CTA bands
- Origin blocks
- Cluster cards
- SHG / women collective cards
- Contact blocks
- Footer CTA sections

Elementor may exist in the old/current site and may remain temporarily during migration, but the future clean component system must not depend on Elementor widgets for normal page construction.

---

## 4. Theme-Like Component Direction

Future Amaley components should behave like a controlled theme/component system.

The user should be able to place and manage sections without rebuilding visual styling each time.

All important UI parts must come from custom Amaley components, not random page-builder widgets.

The component system must be:

- Consistent
- Reusable
- Fast
- Global-token controlled
- Non-coder manageable
- Easy to disable
- Easy to rollback
- Safe for WooCommerce
- Safe for future migration

---

## 5. Global Design Token Rule

When the final Amaley brand PDF is provided, all future components must inherit from a global design token system.

Global tokens should control:

- Brand colors
- Background colors
- Text colors
- Heading font
- Body font
- Font sizes
- Button styling
- Border radius
- Card styling
- Shadows
- Section spacing
- Mobile spacing
- Product card styling
- Trust strip styling

If the global font or color changes, all connected Amaley components should update without editing every section manually.

Example token direction:

```css
--amaley-color-cream
--amaley-color-chocolate
--amaley-color-gold
--amaley-color-rust
--amaley-font-heading
--amaley-font-body
--amaley-radius-card
--amaley-shadow-card
--amaley-section-padding-desktop
--amaley-section-padding-mobile
