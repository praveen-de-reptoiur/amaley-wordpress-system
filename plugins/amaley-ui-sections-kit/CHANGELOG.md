# Changelog

## 0.2.5
- Fixed product grid vertical misalignment by forcing equal media height and top alignment across all grid cards.
- Kept v0.2.4 card size/direction unchanged; no WooCommerce query, cart, checkout, JavaScript, Elementor widget or database changes.
- Synced main plugin version, product renderer files, shortcode registration and documentation.

## 0.2.4
- Rebuilt product card visual direction into a cleaner compact e-commerce card.
- Removed default black badge treatment and kept optional badge/sale behaviour.
- Improved product title, price, CTA, spacing and grid rhythm without changing WooCommerce data logic.

## 0.2.0
- Added `[amaley_product_card]` shortcode for safe single WooCommerce product display.
- Added `[amaley_product_grid]` shortcode for curated WooCommerce product grids using IDs, SKUs, or one product category slug.
- Added scoped product card/grid CSS using `.amaley-ui-product-*` classes only.
- Added safe WooCommerce inactive, missing product, and empty grid messages.
- Product grid limit is capped at 8 to avoid unlimited frontend queries.
- No product filters, search, sorting, pagination, origin data, SHG data, Elementor widgets, JavaScript, database, cart or checkout replacement added.

## 0.1.3
- Corrected plugin author field to Praveen for repository and project-owner consistency.
- Added safe standalone/stacked shortcode spacing polish for trust item, promise strip, CTA band and empty state combinations.
- No product card, WooCommerce query, Elementor widget, JavaScript, database, CPT, origin-data or checkout changes.

## 0.1.2
- Aligned plugin header, version constant, README, testing checklist and rollback notes to v0.1.2.
- No visual, shortcode, CSS, WooCommerce, Elementor or frontend behaviour changes from v0.1.1.

## 0.1.1
- Fixed outline button contrast inside deep CTA bands.
- Added safer spacing between stacked shortcodes.
- Improved mobile heading scale and edge spacing for standalone shortcode tests.
- Improved mobile card/CTA padding and readability.

## 0.1.0
- Initial Phase 1 MVP skeleton.
- Added design tokens, section container, section heading, buttons, button group, trust item, brand promise strip, CTA band and empty state.
