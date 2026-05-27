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
```

---

## 6. Asset Loading Rule

Every new plugin or component must load assets carefully.

Rules:

- No unnecessary external libraries
- No heavy animation libraries
- No unnecessary sliders
- No background videos unless explicitly approved
- No global CSS dumps
- No duplicate CSS
- No duplicate JavaScript
- No frontend-heavy diagnostics
- No unnecessary AJAX calls
- No large DOM output where simple markup is enough
- Load CSS/JS only where needed where practical
- Keep JavaScript small and vanilla where possible
- Keep admin-only tools out of the public frontend

---

## 7. Image and Media Rule

Images must not make the site slow.

Rules:

- Use optimized image sizes
- Avoid oversized original images on frontend
- Use lazy loading where appropriate
- Avoid heavy galleries unless required
- Avoid auto-loading large carousels
- Prefer simple responsive images
- Use real product/origin media only when needed
- Do not dump product image folders into GitHub

---

## 8. Query and Data Rule

The site must remain fast even after data grows.

Rules:

- Avoid unlimited frontend queries
- Cap product/cluster/SHG/member output counts
- Paginate or lazy-load large lists where needed
- Cache safe repeated queries where practical
- Avoid expensive meta queries on public pages without review
- Do not load all origin/producer data on every page
- Product, origin, cluster, SHG, and member sections must request only what they need

---

## 9. Plugin Boundary Rule

Future plugin boundaries must remain clean.

Amaley Core:

- Data backbone
- Clusters
- SHGs
- Members/producers
- Product origin mapping

Amaley Discovery Engine:

- Search
- Filters
- Sorting
- Pagination
- Discovery listings

Amaley Site Shell:

- Header
- Footer
- Mobile menu
- Navigation shell

Amaley UI Sections / Widgets Kit:

- Lightweight custom UI sections
- Buttons
- Cards
- Strips
- CTA sections
- Product display components
- Brand/story sections

No plugin should become overloaded with unrelated work.

---

## 10. Rule Precedence and Conflict Clarification

This file is a stricter add-on rule.

Older/current-site documentation may mention Elementor because the existing live or clone site may still use Elementor during migration.

For the future clean Amaley build:

- Elementor may remain temporarily for old content or migration reference.
- New Amaley UI sections must not depend on Elementor default widgets.
- New buttons, headings, cards, strips, product sections, story sections, CTA sections, and origin blocks must come from Amaley-controlled components.
- If an older rule and this file appear different, this file applies to the future clean UI/component system.

---

## 11. Testing Gate

Before any future component is accepted, test:

- Desktop load
- Mobile load
- Low-network behavior
- No console errors
- No layout shift issues
- No WooCommerce product/cart/checkout breakage
- No duplicate CSS/JS
- No unnecessary frontend requests
- No Elementor dependency for new custom components
- No global styling leakage
- Rollback possible

---

## Final Rule

The future Amaley website must be clean, fast, light, globally controlled, and low-network ready.

No future section, widget, plugin, or template is approved if it makes the site heavy, page-builder dependent, difficult to globally control, or risky for WooCommerce.
