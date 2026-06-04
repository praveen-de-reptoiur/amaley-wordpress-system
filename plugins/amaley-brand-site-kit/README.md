# Amaley Brand Site Kit v1.0.2

A safe global design-token and sync layer for the fresh Amaley WordPress build.

## What it does

- Stores Amaley brand tokens in one WordPress admin screen.
- Outputs CSS variables for colors, fonts, spacing, radius, shadows, cards, buttons and badges.
- Adds a scoped `.amaley-site` component layer.
- Adds optional body-class, Elementor and WooCommerce visual bridges.
- Syncs Amaley colors and fonts into the active Elementor Site Kit.
- Syncs Amaley colors into the WordPress block editor palette.
- Creates an Elementor Kit backup before syncing and provides restore.

## What it does not do

- Does not create CPTs.
- Does not change product data, prices, stock, orders, cart or checkout logic.
- Does not create or replace header/footer.
- Does not register Elementor widgets.
- Does not modify Amaley Core, Discovery Engine, H/F Studio, Templates, UI Sections Kit, Compact Widgets or Project Guard.

## Source design system

Built from `AMALEY_WEBSITE_DESIGN_SYSTEM_DEV_HANDOFF.pdf` uploaded on 2026-06-04.

## Installation

1. Install on staging or fresh WordPress first.
2. Upload `amaley-brand-site-kit-v1.0.2.zip` from Plugins > Add New > Upload Plugin.
3. Activate.
4. Go to **Amaley Brand Kit**.
5. Confirm colors and fonts.
6. Use **Global Sync**:
   - Sync Amaley Colors + Fonts to Elementor
   - Sync Amaley Colors to WordPress Editor
7. Refresh Elementor editor and check Global Colors / Global Fonts.
8. Take a backup/checkpoint after approval.

## Safety notes

- Elementor Kit sync creates a backup before writing.
- Restore Last Elementor Kit Backup is available after first sync.
- WordPress editor sync does not overwrite theme files.
- WooCommerce and Elementor visual bridges are optional.
- If a theme/plugin conflict appears, disable the relevant bridge from Amaley Brand Kit.

## v1.0.2 — Global Sync

- Added Elementor Global Colors sync.
- Added Elementor Global Fonts sync.
- Added WordPress block editor palette sync.
- Added Elementor Kit backup before sync.
- Added Elementor Kit backup restore button.
- Preserved existing brand token settings and option keys.
- No header/footer, CPT, WooCommerce data, cart, checkout or template logic changed.


## v1.0.4 Future-Safe Lock

- Elementor color/font sync remains manual and reversible.
- Broad frontend bridges are OFF by default.
- Existing installs are migrated once to switch global, WooCommerce and Elementor visual bridges OFF.
- Admin CSS/fonts only load on the Amaley Brand Kit admin page.
- No CPT, WooCommerce data, cart, checkout, header/footer or template logic is changed.
