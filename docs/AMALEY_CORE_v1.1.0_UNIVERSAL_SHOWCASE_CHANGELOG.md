# Amaley Core v1.1.0 — Universal Showcase Base Changelog

Date: 2026-06-06
Status: Additive source update in GitHub

---

## Summary

Amaley Core v1.1.0 adds the first base implementation of the Amaley Universal Showcase Widget.

This widget is meant for reusable non-filtered showcase sections where a page needs to display Amaley Clusters, SHG / Producer Groups, Members / Producers or Products as grid, slider, card row or list.

---

## New Source Files

```text
plugins/amaley-core/includes/class-amaley-core-universal-showcase.php
plugins/amaley-core/includes/widgets/class-amaley-core-universal-showcase-widget.php
plugins/amaley-core/assets/amaley-core-universal-showcase.css
plugins/amaley-core/assets/amaley-core-universal-showcase.js
```

---

## Updated Source Files

```text
plugins/amaley-core/amaley-core.php
plugins/amaley-core/includes/class-amaley-core.php
README.md
docs/AMALEY_UNIVERSAL_SHOWCASE_WIDGET_LOCK.md
```

---

## Version Change

```text
Amaley Core 1.0.99.4 -> 1.1.0
```

---

## Widget Added

Elementor widget:

```text
Amaley Universal Showcase
```

Elementor category:

```text
Amaley Core
```

Shortcode:

```text
[amaley_universal_showcase]
```

---

## Current Supported Content Types

```text
cluster
shg
member
product
```

---

## Current Supported Layout Modes

- Grid
- Slider
- Card row
- List
- Phone-first slider / horizontal card row

---

## Current Supported Source Modes

- Latest / normal query
- Manual IDs
- Featured only
- Product category slug for products

Future relation-based source modes can be added after testing this base.

---

## Locked Editor Rule

```text
Selected content/card type ke controls hi Elementor editor me visible honge.
```

Implemented by separate Elementor control sections:

- Cluster Card Controls visible only when Content Type = Cluster
- SHG Card Controls visible only when Content Type = SHG
- Member / Producer Card Controls visible only when Content Type = Member
- Product Card Controls visible only when Content Type = Product

---

## Renderer Rule

The widget reuses the existing central card renderer:

```text
Cluster -> Amaley_Core_Card_Renderer::render_cluster()
SHG     -> Amaley_Core_Card_Renderer::render_shg()
Member  -> Amaley_Core_Card_Renderer::render_member()
Product -> Amaley_Core_Card_Renderer::render_product()
```

No separate new card family has been invented in this update.

---

## Safety Boundaries Preserved

This update does not touch:

- Amaley Discovery Engine filters
- Discovery query logic
- Filtered pagination
- WooCommerce cart
- WooCommerce checkout
- WooCommerce orders
- Product photos / galleries
- Product origin mappings
- Header
- Footer
- Theme templates
- Permalinks

---

## Testing Required Before ZIP Release

Test in Elementor and frontend:

- Cluster + Grid
- Cluster + Phone Slider
- SHG + Grid
- SHG + Phone Slider
- Member + Grid
- Member + Phone Slider
- Product + Grid
- Product + Phone Slider
- Manual IDs mode
- Latest mode
- Product category mode
- Empty state
- Two Universal Showcase widgets on same page
- Mobile arrows, dots and current/total number

---

## Notes

This is a safe additive base. Existing archive/single widgets have not been refactored or deleted.

Cleanup is still pending before any broad refactor of older widgets.
