# Amaley Templates

This folder will contain the clean source code for the Amaley Templates plugin.

Amaley Templates is responsible for Elementor-native visual and template widgets for the Amaley WordPress system.

## Plugin Role

Amaley Templates handles visual/template sections such as:

- Product hero
- Product info tabs
- Product trust strip
- Origin and traceability display
- Shop hero
- Shop discovery layout
- Future quick view modules
- Future popup modules

## What This Plugin Must Not Do

Amaley Templates must not replace WooCommerce.

WooCommerce remains responsible for:

- Products
- Prices
- Stock
- Variations
- Cart
- Checkout
- Orders
- Reviews

This plugin should only support and display WooCommerce data safely.

## Elementor Role

This plugin should provide Elementor-native widgets with clean controls.

Controls must be section-wise:

- Heading
- Product Image
- Product Summary
- Button
- Tabs
- Origin Section
- Trust Strip
- Spacing
- Mobile Layout

Do not mix controls randomly.

## Design Rule

All widgets must follow:

- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`

No random fonts.  
No random colors.  
No inconsistent buttons.  
No unmanaged spacing.

## CSS Rule

Use scoped CSS only.

Allowed prefix:

```css
.amaley-tpl-
