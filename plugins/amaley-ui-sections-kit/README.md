# Amaley UI Sections Kit

**Module Name:** Amaley UI Sections Kit  
**Slug:** `amaley-ui-sections-kit`  
**Author:** Praveen  
**Status:** Planning / architecture folder  
**Build Status:** Not built yet. No ZIP should be created until structure is approved.

Amaley UI Sections Kit is the future lightweight, WordPress-native, theme-like component system for the Amaley website.

It will provide Amaley-controlled sections, buttons, cards, strips, product blocks, story blocks, CTA blocks, origin blocks, trust sections, and reusable UI components without depending on Elementor default widgets.

---

## Purpose

This module will support the future clean Amaley website with reusable custom UI sections.

It will include:

- Custom buttons
- Button groups
- Section headings
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

---

## Locked Direction

This module must follow the permanent performance and no-Elementor lock.

Rules:

- No Elementor default widget dependency.
- No Elementor Heading widget.
- No Elementor Button widget.
- No Elementor Icon Box widget.
- No Elementor Image Box widget.
- No Elementor HTML widget for important sections.
- No heavy page-builder dependency.
- No CPT creation.
- No WooCommerce replacement.
- No header/footer replacement.
- No discovery/filter engine replacement.
- No heavy frontend scripts.
- No unnecessary external libraries.
- No global CSS dumps.
- No duplicate CSS/JS.
- Low-network-first performance.
- Mobile-first layout.
- Global design-token controlled.

---

## Global Design Token Requirement

When the final Amaley brand PDF is provided, this kit must inherit from a global design token system.

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

If global font, color, radius, spacing, or button style changes, connected UI components should update without editing every section manually.

---

## Performance Requirement

The Amaley website must remain extremely lightweight.

This module must be built for:

- Low-network areas
- Mobile-first browsing
- Fast product browsing
- Clean HTML output
- Limited frontend requests
- Optimized images
- Controlled queries
- Reusable CSS
- Small vanilla JavaScript only where required

If a component looks premium but makes the site heavy, it is not approved.

---

## Plugin Boundary

This module must stay separate from other Amaley plugins.

Amaley Core handles:

- Clusters
- SHGs
- Members/producers
- Product origin mapping
- Data backbone

Amaley Discovery Engine handles:

- Product search
- Filters
- Sorting
- Pagination
- Discovery listings

Amaley Site Shell handles:

- Header
- Footer
- Mobile menu
- Navigation shell

Amaley UI Sections Kit handles:

- Lightweight UI sections
- Buttons
- Cards
- Strips
- CTA sections
- Product display components
- Brand/story sections

---

## Build Rule

Do not create plugin ZIP yet.

First required steps:

1. Approve this module direction.
2. Approve section/component inventory.
3. Approve global design-token structure after brand PDF is shared.
4. Approve phase-wise build plan.
5. Then build the plugin.

No build should start without approval.
