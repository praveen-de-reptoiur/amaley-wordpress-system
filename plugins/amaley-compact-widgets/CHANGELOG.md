# Changelog

## 0.4.19 - Merged Home Sections Safe Build

### Summary
- Merged the approved Compact Spacing Controls v1.0.23 home-section widgets into the main Amaley Compact Widgets plugin.
- Updated the main plugin version from 0.4.18 to 0.4.19.
- The separate Compact Spacing Controls add-on is no longer required for the merged home-page widgets and controls.

### Added widgets
- Amaley Mission Visual Statement.
- Amaley Vision Visual Statement.
- Amaley Process Journey.
- Amaley Origin Pillars.
- Amaley Livelihood Chain Band.
- Amaley Gifting Feature Split.

### Added controls and styles
- Split Editorial spacing, feature-card and mobile flow controls.
- Origin Map Path visibility, layout, panel, map and step controls.
- Reference visual statement stylesheet.
- Process journey stylesheet.
- Three-section stylesheet for Origin Pillars, Livelihood Chain Band and Gifting Feature Split.
- Improved SVG/icon color coverage for merged visual widgets.

### Compatibility and safety
- Existing Compact Widgets renderers, shortcodes and Elementor category remain intact.
- Guard checks skip merged widget registration when the old Compact Spacing Controls add-on is also active.
- The merge is presentation-only and does not manage products, mappings, media, imports, WooCommerce templates, header or footer.
- CSS remains scoped to Amaley widget wrappers.

### Install note
- On staging/live sites, keep Amaley Compact Spacing Controls v1.0.23 inactive after installing Compact Widgets v0.4.19.
- Regenerate Elementor CSS and purge cache after update.

## 0.4.18
- Final alignment system reset.
- Dual Heading remained unchanged from approved v0.4.13/v0.4.12 visual direction.
- Removed legacy Overall Alignment control from old compact widgets.
- Header Alignment controls only section heading.
- Card Text Alignment controls only cards/items.
- Section Button Alignment controls only section buttons.
- No WooCommerce/header/footer/theme override.

## 0.4.5-test
- Replaced dull/static fake map texture with real OpenStreetMap tile rendering.
- Fixed zoom controls with direct delegated click handling.
- Added working drag/pan, mouse wheel zoom, touch drag and reset button.
- Added route/marker/label projection on top of the real map.
- Kept the widget scoped, manual/static and free from external JS libraries.

## 0.4.4-test
- Added drag/pan and zoom behaviour to the Origin Map Path map board.
- Added scoped vanilla JS for map movement.
- Kept no external libraries and no frontend dependency outside the plugin.

## 0.4.3
- Added Amaley Origin Map Path widget for the homepage.
- Added [amaley_cw_origin_map] shortcode.
- Added static CSS map board with route markers, label cards, route caption, right-side journey list and CTA.
- Kept the widget manual/static inside Compact Widgets; no CPT, ACF, Discovery Engine, WooCommerce template, header/footer or frontend JavaScript changes.

## 0.4.2
- Final professional polish after v0.4.1 visual approval.
- Added Elementor alignment controls for header, card/item text and button row.
- Added shortcode-level alignment classes for header/card/button alignment.
- Kept accepted five-section visual repair intact.
- No new widgets, no frontend JS, no external libraries.

## 0.4.1
- Focus repair for the five weak sections identified by Praveen: Our Story, Traceability, Gifting, Our Values and For Whom.
- Rebuilt those five layouts only; no new widgets added.
- Improved default content, hierarchy, spacing, card structure, mobile stacking and professional visual polish.
- Kept frontend JavaScript at 0 KB and CSS scoped to .amaley-cw4-*.
- No Discovery Engine, Amaley Core, Templates, Site Shell, WooCommerce, header or footer changes.

## 0.4.0
- Rebuilt the Compact Widgets output after rejecting v0.3.x visual quality.
- Added dry-test HTML and visual preview flow.
