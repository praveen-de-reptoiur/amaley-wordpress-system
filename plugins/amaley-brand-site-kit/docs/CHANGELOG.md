# Changelog

## v1.0.4 — Future-Safe Lock

- Keeps v1.0.2 Elementor Global Colors and Fonts sync.
- Sets broad frontend visual bridges OFF by default for future safety.
- Adds one-time migration for existing installs so global, WooCommerce and Elementor visual bridges are switched OFF.
- Restricts admin CSS/font loading to the Amaley Brand Kit admin page only.
- Does not touch product data, orders, cart, checkout, CPTs, header/footer templates or page content.

## v1.0.3 — Force Sync Fix

- Built as an aggressive Elementor force-sync test.
- Not selected as the approved baseline because v1.0.2 sync worked correctly after proper button use.
- Treat as rejected/unused.

## v1.0.2 — Global Sync

- Added Elementor Global Colors sync from Amaley brand tokens.
- Added Elementor Global Fonts sync from Amaley typography tokens.
- Added WordPress block editor color palette support.
- Added manual WordPress editor palette sync action.
- Added Elementor Kit backup before sync.
- Added Restore Last Elementor Kit Backup action.
- Added sync status notices and timestamps in the Brand Kit admin screen.
- Preserved existing option key `amaley_brand_site_kit_settings` so existing tokens remain safe.
- No WooCommerce/cart/checkout/CPT/header/footer/template logic changed.

## v1.0.1 — Separate Admin Menu

- Moved admin page from Settings → Amaley Brand Site Kit to separate top-level admin menu **Amaley Brand Kit**.
- Updated form action and save redirect to `admin.php?page=amaley-brand-site-kit`.
- Preserved existing option key `amaley_brand_site_kit_settings` so existing tokens remain safe.
- No design-token values changed.
- No WooCommerce/cart/checkout/CPT/header/footer/template logic changed.

## v1.0.0 — 2026-06-04

- Initial audited build.
- Added global Amaley tokens from the uploaded design-system PDF.
- Added admin settings page.
- Added optional Google Fonts loading for Playfair Display and Lato.
- Added scoped `.amaley-site` component classes.
- Added optional body-class global bridge.
- Added optional Elementor visual bridge.
- Added optional WooCommerce product-card visual bridge.
- No CPT, WooCommerce data, cart, checkout, header, footer, Elementor widget or template override logic added.
