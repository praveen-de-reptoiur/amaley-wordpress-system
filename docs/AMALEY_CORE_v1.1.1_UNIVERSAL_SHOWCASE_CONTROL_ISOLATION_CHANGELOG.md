# Amaley Core v1.1.1 — Universal Showcase Control Isolation

Date: 2026-06-06
Status: Safe additive patch after Universal Showcase base

---

## Summary

This patch tightens the Amaley Universal Showcase Widget so the Elementor panel follows the locked rule more strictly:

```text
Selected content/card type ke controls hi editor me visible honge.
```

---

## What Changed

### 1. Removed always-visible common card element controls

The earlier base had a common card element control section. That could still create confusion because card element controls were visible regardless of selected content type.

v1.1.1 moves these controls inside each selected card family section.

Now:

- Cluster selected -> Cluster card controls show image/label/title/excerpt/meta/tags/button controls
- SHG selected -> SHG card controls show image/label/title/excerpt/meta/tags/button controls
- Member selected -> Member card controls show image/label/title/excerpt/meta/tags/button controls
- Product selected -> Product card controls show image/label/title/excerpt/meta/tags/button controls

### 2. Render side now reads selected family controls

Frontend card output now reads controls from the selected family prefix:

```text
cluster_show_image, cluster_show_label, cluster_show_title, etc.
shg_show_image, shg_show_label, shg_show_title, etc.
member_show_image, member_show_label, member_show_title, etc.
product_show_image, product_show_label, product_show_title, etc.
```

Hidden controls from another family do not affect the selected render.

### 3. Replaced responsive columns with explicit device controls

To avoid Elementor responsive-control naming confusion, the widget now uses clear separate controls:

```text
columns_desktop
columns_tablet
columns_phone
```

### 4. Gap control synced with slider width calculation

The Card Gap control now updates both CSS `gap` and the internal `--amaley-usw-gap` variable used by slider item width calculations.

---

## Files Updated

```text
plugins/amaley-core/amaley-core.php
plugins/amaley-core/includes/class-amaley-core-universal-showcase.php
plugins/amaley-core/includes/widgets/class-amaley-core-universal-showcase-widget.php
plugins/amaley-core/assets/amaley-core-universal-showcase.css
```

---

## Version Change

```text
Amaley Core 1.1.0 -> 1.1.1
```

---

## Safety Boundaries Preserved

This patch does not change:

- Discovery Engine filters
- Discovery Engine query logic
- Filtered pagination
- Product data
- Product photos / galleries
- Product origin mappings
- Header
- Footer
- Theme templates
- WooCommerce cart / checkout

---

## Immediate QA

Test in Elementor:

1. Add Amaley Universal Showcase.
2. Select Cluster and confirm only Cluster Card Controls show.
3. Select SHG and confirm only SHG Card Controls show.
4. Select Member and confirm only Member / Producer Card Controls show.
5. Select Product and confirm only Product Card Controls show.
6. Change image/title/meta/button toggles inside each selected family and confirm frontend output follows the selected card family only.
7. Test phone slider arrows/dots and card gap.
