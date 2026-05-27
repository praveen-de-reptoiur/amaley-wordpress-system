# v1.3.5 — CPT Registration Disabled

- Disabled plugin-owned CPT/taxonomy registration to remove duplicate admin menus: Collections, Clusters, SHGs and Members created by the Discovery Engine.
- Existing Amaley internal content remains intended for CPT UI + ACF post types such as `clusters`, `shgs_groups`, and `shg_members`.
- Product Discovery widgets, Elementor widgets, filter rendering, styling controls, import/export, AJAX and frontend assets are preserved.
- Rollback: upload the v1.3.4 backup zip if the older plugin-owned CPT menus are ever needed again.

---

# Amaley Discovery Engine — Compatibility & Update Notes

Plugin Name: Amaley Discovery Engine  
Author / By: Praveen  
Current Framework Version: 1.3.0

## Core Purpose
A reusable Elementor-native discovery engine for Amaley Products, Collections, Clusters, SHGs, and Members.

## Non-Negotiable Rules
- No global CSS selectors.
- No global JavaScript pollution.
- No hard dependency on Freshen / Apus theme.
- No hard dependency on JetSmartFilters.
- No forced WooCommerce template override.
- No forced Elementor template override.
- All CSS must stay scoped under `.amaley-discovery-engine-v1`.
- PHP functions/classes/hooks must stay prefixed with `amaley_de_` or `Amaley_DE_`.
- JS must stay scoped around the current widget root only.
- Assets must load only when the widget/shortcode is used.
- AJAX must keep URL fallback.
- Pagination is mandatory for scalable lists.
- Desktop, tablet, mobile, small mobile, zoom, and boxed/full-width Elementor containers must be considered before updates.

## Design Lock
- Chocolate: #2E1203
- Gold: #C2880A
- Rust: #B5502A
- Ivory: #F7EFE2
- Cream: #FFF8EA
- Heading font: Playfair Display
- Body font: Lato

## Elementor Widgets
- Amaley Product Discovery
- Amaley Collection Discovery
- Amaley Cluster Discovery
- Amaley SHG Discovery
- Amaley Member Discovery

Shortcode fallback remains available through `[amaley_discovery type="products"]` and related types, but Elementor widgets are the preferred workflow.

## Update Checklist
Before any future release, check:
1. PHP syntax across all files.
2. WordPress activation.
3. Elementor editor load.
4. Frontend rendering.
5. WooCommerce product query.
6. Category/tag/price/stock/search/sort filters.
7. AJAX filter.
8. URL fallback filter.
9. Pagination.
10. Mobile drawer.
11. Full-width breakout.
12. Desktop/tablet/mobile/small-mobile responsiveness.
13. No console error.
14. No WooCommerce shop/archive breakage.
15. No Elementor layout conflict.
16. No Freshen/Apus theme override.
17. Import/export settings still valid.

## Future Direction
The plugin is designed to move later to a fresh WordPress install and a future custom Amaley theme. Keep the engine independent from any current theme or third-party filter plugin.

## Version 1.0.2 Update Notes

### Reason for update
The product query/filter system was working, but in some Freshen/Apus + Elementor boxed/editor conditions the layout background expanded while the internal results grid remained narrow. Product cards became thin vertical strips.

### Fix added
- True full-bleed breakout using `width: 100vw`, `left: 50%`, and `margin-left: -50vw`.
- Forced scoped desktop layout for left-filter mode.
- Added minimum product card width safety so cards do not become thin strips.
- Preserved responsive breakpoints: desktop/laptop side-by-side, tablet/mobile stacked, mobile one-column.
- Added price text wrapping safety so WooCommerce price is not split letter-by-letter.

### Safety rules maintained
- No global CSS.
- No WooCommerce global class override.
- No Elementor global class override.
- No theme class override.
- All changes scoped under `.amaley-discovery-engine-v1`.

## Version 1.0.3 — Import/Export System Lock

Purpose: Reduce repeated plugin replacement. Future settings, CPT mappings, design tokens, and widget/filter/style presets can be imported from the WordPress admin panel without editing plugin core files.

Added:
- Full export package schema: `amaley_discovery_engine_package_v1`.
- Export includes plugin settings, CPT/taxonomy mappings, relation meta keys, design tokens, and preset library.
- Download Export JSON button added under Dashboard → Amaley Discovery.
- Import supports pasted JSON and uploaded `.json` files.
- Import supports merge mode and replace mode.
- Backward compatibility: old v1.0.2 direct settings JSON can still be imported.
- Preset library added for Products, Collections, Clusters, SHGs, and Members.
- Elementor widgets now include: Query & Filters → Use Imported Preset → Imported Preset.
- Imported presets can control layout/filter/style values without changing plugin files.

Future update rule:
- Do not remove the package schema without migration.
- Keep imported preset keys stable.
- Keep shortcode and Elementor controls backward-compatible as much as practical.
- Any new filter/card/layout option should first be designed to be preset-importable.
- Plugin core should remain stable; routine design and mapping changes should happen through Admin settings, Elementor controls, or JSON preset import/export.

Responsive rule remains mandatory:
- Desktop, laptop, tablet, mobile, small mobile, Elementor editor preview, frontend preview, full-width container, boxed container, and zoom in/out must remain tested.

## Version 1.0.4 — Addon-ready settings + desktop grid fix

- Fixed desktop layout issue where product results could appear below the filter sidebar. Root cause: the mobile drawer backdrop element existed as a normal grid child on desktop and could occupy the second grid column. The backdrop is now hidden globally and only activated inside mobile drawer media rules.
- Added addon-ready widget controls so future label/layout adjustments can be made from Elementor or imported JSON presets instead of replacing the plugin.
- Added Messages & Labels controls: mobile filter button text, drawer title, apply/reset button text, result count labels, and empty state text.
- Added Advanced Layout controls: sidebar width, product/card minimum width, grid gap, and custom wrapper class.
- Added CSS variables for sidebar width, card min width and grid gap, so imported presets can control these values safely.
- Continued no-conflict rules: scoped CSS only, no global WooCommerce/Elementor/Freshen/Apus overrides, no JetSmart dependency, no forced template override.
- Fully responsive rule maintained: desktop, laptop, tablet, mobile, small mobile and zoom-safe layout checks remain mandatory for future updates.

## Version 1.0.5 — Elementor Loop Item / Template Card Renderer

Purpose: Allow Amaley Discovery Engine to use the existing Elementor Loop Item card design while keeping the plugin's query, filter, AJAX, pagination, mobile drawer, and URL fallback system.

Added:
- New Elementor widget section: Content → Card Template / Renderer.
- New control: Card Renderer.
  - Plugin Default Card: uses the plugin's built-in scoped card.
  - Elementor Loop Item / Template: renders an Elementor template as the card.
- New control: Elementor Template ID.
  - Example: the user's current product loop template ID is `7184`.
- The renderer temporarily sets the current post/product context so Elementor dynamic widgets can read the current WooCommerce product/post.
- Elementor template CSS is enqueued through Elementor's CSS post file system instead of printing duplicate CSS inside every card.
- Safe fallback: if Elementor is unavailable or the template ID is invalid, the plugin falls back to the built-in Amaley card.
- Added scoped template wrapper class: `.amaley-discovery-engine-v1__template-card`.

Safety rules maintained:
- No Elementor global override.
- No WooCommerce template override.
- No Freshen/Apus dependency.
- No JetSmart dependency.
- No global selectors.
- Template rendering is opt-in per widget.
- Query/filter/pagination engine stays inside Amaley Discovery Engine.

Future update rule:
- Any future card renderer must remain opt-in and fallback-safe.
- Never hard-replace WooCommerce archive templates globally.
- Do not force one card template across all pages; keep per-widget renderer controls and importable presets.
- When moving to a fresh WordPress/custom Amaley theme, export/import presets can carry the chosen renderer and template ID.

## Version 1.0.6 — Elementor Loop Template CSS Rendering Fix

Issue observed: Elementor Loop Item / Template cards could render correctly inside Elementor editor but appear unstyled on the frontend because the template-specific CSS was enqueued too late for normal page-head output.

Fix applied:
- Elementor template cards now render with `get_builder_content_for_display($template_id, true)` so the required Elementor template CSS can be included with the rendered card content.
- Query, filter, pagination and AJAX remain controlled by Amaley Discovery Engine.
- Card visual design can still come from the selected Elementor Loop Item / Template.
- No global Elementor, WooCommerce, Freshen/Apus, JetSmart or theme CSS is overridden.

Future rule:
When rendering any external Elementor template inside Amaley Discovery Engine, template-specific CSS must be included safely with the rendered output or the card must gracefully fall back to the plugin default card.

## Version 1.0.7 — Runtime Import/Patch Layer

Added a scoped Runtime Styling & Patch Layer so future visual/layout fixes can be imported through JSON instead of replacing plugin ZIP files every time.

### What can now be changed through Import/Export
- Global design tokens and fonts.
- CPT/taxonomy/relation mapping.
- Widget presets and filter presets.
- Card/layout/filter spacing presets.
- Scoped runtime CSS patches for minor frontend visual fixes.

### What still requires a plugin update
- New PHP query logic.
- New Elementor control types.
- New database structures.
- Security fixes.
- New AJAX endpoints.
- Deep integration with new third-party plugins.

### Safety Rules for Runtime CSS
- Keep selectors scoped to `.amaley-discovery-engine-v1` or a custom wrapper class.
- Do not target global WooCommerce, Elementor, theme, or body/html selectors.
- Do not use external imports.
- Runtime CSS is exported and imported with the full settings package.

This reduces repeated plugin replacement and helps future fresh WordPress/custom Amaley theme builds reuse the same engine and presets safely.


## v1.0.8 — Import/Patch Safety Review

- Added automatic rollback backups before imports and manual settings saves.
- Added rollback restore UI in Amaley Discovery → Import / Export Settings & Presets.
- Runtime CSS patches are now validated before save/import/output.
- Runtime CSS must stay scoped to `.amaley-discovery-engine-v1` or `.amaley-de-` selectors.
- The latest 8 rollback backups are retained to avoid patch/import mistakes becoming permanent.
- Future patch workflow: export backup → import scoped JSON patch using Merge → purge cache → test desktop/tablet/mobile → keep or rollback.
- Do not stack multiple unknown CSS patches. Prefer named/versioned presets and clean replacement when a patch supersedes an older patch.


## Version 1.0.9 — Tablet/Mobile Filter Behaviour Control

Added Elementor-level control: Content → Layout → Tablet/Mobile Filter Behaviour.
Options:
- Drawer Button: tablet/mobile filters open via a FILTER button and scoped drawer.
- Always Visible Inline Filter: tablet/mobile filters remain visible above results.

Safety decision:
- The setting is rendered as a scoped class on the widget instance.
- A small instance-scoped style block is printed per widget, using the widget ID.
- This allows the Elementor control to override older runtime CSS patches safely.
- No global CSS, WooCommerce, Elementor, Freshen/Apus, JetSmart, header, footer, or theme selectors are targeted.

Maintenance note:
- Future presets can store `mobile_filter_mode` as `drawer` or `inline`.
- Use this setting instead of importing permanent CSS patches for drawer/inline behaviour whenever possible.


## Version 1.1.2 — Mobile Hybrid Filter Experience

Added a professional mobile/tablet drawer experience without removing user control.

New Elementor controls under Content → Layout:
- Show Mobile Result Count
- Show Mobile Quick Category Pills
- Show Mobile Sort Dropdown
- Show Mobile Active Filter Chips
- Mobile Toolbar Layout: Filter + Sort / Filter Only / Sort Only
- Mobile Quick Pills Limit

Design decision:
- Drawer mode no longer needs to look like a lonely FILTER button.
- Mobile can show result count, horizontal quick category pills, a compact Filter + Sort toolbar, and active chips.
- Advanced filters remain inside the drawer.
- Inline mode remains available for pages where the full filter should always remain visible.

Conflict-safety:
- All CSS is scoped to `.amaley-discovery-engine-v1`.
- No WooCommerce, Elementor, Freshen/Apus, or global selector override.
- JavaScript controls only elements inside `[data-ade-root]`.

Testing required after update:
- Desktop: left sidebar + product grid.
- Tablet: quick pills + toolbar + two-column cards.
- Mobile: quick pills + Filter/Sort toolbar + one-column cards.
- Drawer open/close.
- Quick pill category filtering.
- Mobile sort filtering.
- Pagination after filtering.


## Version 1.1.2 — Responsive Filter Mode Polish
- Fixed Full Visible behaviour on tablet/phone so it does not render as a huge empty desktop-style sidebar card.
- Desktop Full Visible still respects Filter Position: Left Sidebar or Top Bar.
- Tablet Full Visible now renders as a compact 2-column filter form.
- Phone Full Visible now renders as a compact 1-column filter form.
- Drawer Toolbar and Compact Inline modes continue to hide the normal result head to avoid duplicate result counts.
- Kept all changes instance-scoped and under `.amaley-discovery-engine-v1`.
- Recommended product/shop setting: Desktop = Full Visible, Tablet = Compact Inline Filter Bar, Phone = Compact Inline Filter Bar or Drawer Toolbar.


## Version 1.1.3 — Laptop/Desktop Sidebar Lock
- Fixed the issue where Desktop + Left Sidebar + Full Visible could still render as a top horizontal filter bar inside Elementor desktop preview/laptop iframe widths.
- Added a scoped per-instance 881px+ rule that re-applies the chosen desktop filter position after tablet media rules.
- This update intentionally does not change approved phone/tablet behaviour below 880px.
- Locked direction remains: product/shop pages use Desktop = Full Visible Filter Form, Tablet = Compact Inline Filter Bar, Phone = Compact Inline Filter Bar unless a page specifically needs a different behaviour.
- Conflict safety maintained: no global CSS, no WooCommerce/Elementor/Freshen/Apus override, all rules scoped to the specific Amaley Discovery Engine widget instance.

## Version 1.1.4 — Topbar Preset Widgets
- Added dedicated Elementor topbar discovery widgets:
  - Amaley Product Topbar Discovery
  - Amaley Collection Topbar Discovery
  - Amaley Cluster Topbar Discovery
  - Amaley SHG Topbar Discovery
  - Amaley Member Topbar Discovery
- These widgets use the same stable query/filter/pagination engine but open with Filter Position = Top Bar.
- Default device behaviour: Desktop = Full Visible Filter Form, Tablet = Compact Inline Filter Bar, Phone = Compact Inline Filter Bar.
- Purpose: reuse the approved premium horizontal filter layout for cluster, SHG, member, collection, and product pages without manually changing multiple settings each time.
- Conflict safety maintained: no global CSS, no WooCommerce/Elementor/Freshen/Apus override, no JetSmart dependency, and all rendering remains scoped to the Amaley Discovery Engine widget instance.


## Version 1.1.5 — Device-Level Filter Position Lock

- Added independent Desktop / Tablet / Phone filter position controls: Left Sidebar or Top Bar.
- Kept device-level behaviour controls separate from position controls: Full Visible, Drawer Toolbar, Compact Inline Filter Bar.
- Topbar dedicated widgets remain included in the same plugin and default all devices to Top Bar position.
- Full Visible on tablet/phone is now safe: no large empty desktop-style box; tablet can be topbar or optional left sidebar; phone stacks safely even if Left is selected.
- Maintains the approved Amaley shop direction: desktop sidebar, tablet/phone compact bar, quick pills, sort, active chips.
- No global selectors added; all device-specific CSS is printed instance-scoped using the widget ID.
- Existing old widgets remain backward compatible through the legacy `filter_position` fallback.


## Version 1.1.7 — Elementor Layout Control Grouping Polish

Decision locked:
- Layout controls in Elementor must be grouped device-wise to reduce confusion.
- Desktop Filter Layout now shows Filter Position and Behaviour together.
- Tablet Filter Layout now shows Filter Position and Behaviour together.
- Phone Filter Layout now shows Filter Position and Behaviour together.
- Existing setting keys remain unchanged for backward compatibility, so old widgets and imported presets should not break.
- This is UI/control organization only; no query, CSS, WooCommerce, Elementor template, or filter runtime logic was changed.
- Applies across Product, Collection, Cluster, SHG, Member, and dedicated Topbar widgets because all inherit the same base widget controls.

Future rule:
- Any new device-specific layout setting must be placed under the relevant device heading, not mixed in one long list.
- Keep advanced shared toolbar controls under Responsive Filter Bar Controls after the device blocks.


## Version 1.1.7 — Professional Elementor Style Control Review

Purpose: Fix the Elementor Style tab so controls are not mixed and the user has professional, section-wise styling control.

Added / improved:
- Section / Wrapper Style: background, top/bottom padding, left/right padding.
- Heading Style: heading color, accent word color, font family, responsive size, full Elementor Typography controls, alignment, heading area spacing.
- Kicker / Small Label Style: color, size, Typography controls, bottom spacing.
- Filter Style: panel background, primary/accent colors, padding, radius, border, shadow, field gap, filter label typography/color, input/select typography, background, border, height, and radius.
- Responsive Toolbar Style: toolbar background/padding/radius, result count typography/color, quick-pill typography, colors, active state, and radius.
- Card Style: card background/radius, border, shadow, template-wrapper padding, and a clear note that Elementor Loop Item inner card styling should be edited inside the Loop Item itself.
- Image Style: image height, object-fit, and image radius.
- Card Title Style: title/body text controls, title typography, body typography, spacing.
- Meta / Badge Style: meta typography/color and badge colors/radius.
- Price Style: price typography, sale/regular price colors.
- Button Style: button typography, padding, radius, primary/hover colors, reset button colors.
- Pagination Style: typography, size, gap, colors.
- Mobile Drawer Style: drawer background, shadow and close icon color.

Important architectural note:
- This required a plugin update because Elementor control panels are registered in PHP. JSON/runtime patches can change CSS/settings, but they cannot add new native Elementor controls.
- No global CSS/JS was introduced. All selector controls are scoped to the widget through Elementor’s `{{WRAPPER}}` selectors and/or `.amaley-discovery-engine-v1`.
- Existing setting keys were preserved as much as possible, so old pages and presets should remain compatible.


## Version 1.1.8 — Device-wise Main Result Count Controls
- Added direct Elementor controls for hiding/showing the normal result count above cards separately on Desktop, Tablet and Phone.
- This removes the need for custom wrapper classes or runtime patches just to hide `15 results found` on selected devices.
- Toolbar result count remains separate from main result count, so mobile compact/drawer UX can be controlled independently.
- CSS remains instance-scoped to `.amaley-discovery-engine-v1` and the widget instance ID to avoid cross-widget/theme conflicts.


## Version 1.1.9 — Amaley Section Heading Widget

Added a dedicated Elementor widget: **Amaley Section Heading**.

Purpose:
- Reusable heading/kicker system across the Amaley website.
- Keeps section headings consistent without recreating text/typography manually.
- Supports `{word}` syntax for rust italic accent words, e.g. `Our {Collections}`.
- Provides separate Style tab sections: Wrapper / Spacing, Kicker, Main Heading, Description.
- Includes responsive controls for alignment, max width, padding, heading size, line height, and spacing.

Conflict-safety:
- Uses fully scoped classes under `.amaley-section-heading-v1`.
- Does not modify global headings, Elementor widgets, WooCommerce classes, or theme typography.
- Intended to be used as a standalone heading widget across pages and future custom Amaley theme.


## Version 1.2.0 — Amaley Section Heading Default Style Lock

- Updated the **Amaley Section Heading** widget with ready-to-use default styling so headings do not need manual setup every time.
- Default heading font: Playfair Display, weight 500, chocolate #2E1203.
- Default accent word font: Playfair Display, italic, rust #B5502A.
- Default kicker font: Lato, uppercase, gold #C2880A with premium letter spacing.
- Default responsive heading sizes: Desktop 52px, Tablet 45px, Phone 34px.
- Default line-height tuned for desktop/tablet/mobile.
- Default wrapper padding added for safe left/right breathing on all devices.
- Description typography defaults added using Lato.
- No global CSS/JS added; heading widget remains scoped under `.amaley-section-heading-v1`.


## Version 1.2.1 — Section Heading Size Lock

- Updated **Amaley Section Heading** default main heading sizes as approved by the user.
- Main heading default size: Desktop 52px, Tablet 45px, Phone 34px.
- Updated both Elementor typography defaults and quick heading size defaults.
- Updated frontend fallback CSS for the standalone heading widget.
- Plugin name remains **Amaley Discovery Engine** and author remains **Praveen**.
- No global CSS/JS added; heading widget remains scoped under `.amaley-section-heading-v1`.


## v1.2.2 - Editorial Text and Icon List Widgets
- Added `Amaley Editorial Text` Elementor widget as a scoped, controlled replacement for unreliable theme Text Editor/Description widgets.
- Added `Amaley Icon List` Elementor widget for Amaley-style feature cards and compact icon lists.
- Both widgets follow scoped classes only: `.amaley-editorial-text-v1` and `.amaley-icon-list-v1`.
- No global CSS selectors, no theme overrides, no WooCommerce/Elementor template override.
- Defaults follow Amaley approved editorial style: Playfair Display, Lato, chocolate/gold/rust/ivory palette.
- These widgets should be used for important paragraph and feature-card content instead of generic Text Editor when the theme editor behaves unreliably.


## Version 1.2.3 — WooCommerce Attribute Filters for Collection Discovery

- Added Elementor controls for key Amaley product attributes: Collection Type, Core Ingredient, Cluster, Producer/Maker, Source Belt/Region Cluster, SHG/Producer Group, Use Case, and Village/Source Location.
- Added server-side product queries for WooCommerce attribute taxonomies (`pa_collection-type`, `pa_ingredient`, `pa_cluster`, `pa_producer-maker`, `pa_region-cluster`, `pa_shg`, `pa_use-case`, `pa_village-source-location`).
- Added frontend/AJAX/URL fallback support for attribute filters.
- Defaults are OFF to avoid changing existing widgets; enable per widget when building collection/filter pages.
- All controls remain scoped within Amaley Discovery Engine and do not override WooCommerce/Elementor/Freshen/Apus globally.

## v1.2.4 — Native Marketplace Product Card
- Added `Amaley Native Marketplace Card` renderer inside Card Template / Renderer.
- Purpose: avoid dependency on Elementor Loop Item CSS for filtered product grids when a fully coded, responsive product card is preferred.
- Card includes: image, badge, small meta label, product title, rating, price, add-to-cart/view button, progress bar, available quantity, already sold count.
- Styling remains scoped under `.amaley-discovery-engine-v1 .amaley-native-product-card-v1`.
- Existing Elementor Loop Item renderer remains available and unchanged.


## v1.2.5 - Include / Exclude controls
- Added Elementor controls for include/exclude product IDs.
- Added include/exclude controls for product categories and tags.
- Added include/exclude controls for all supported WooCommerce product attributes: collection type, core ingredient, cluster, producer/maker, region cluster, SHG, use case, and village/source location.
- Include/exclude now affects both query results and visible dropdown options where applicable.
- Kept controls scoped to widget settings. No global CSS/JS changes.


## v1.2.6 — Default Selected Filter Controls
- Added widget controls to control dropdown defaults instead of forcing All on first load.
- New Default Dropdown Selection modes: All / No Default, First Available Term, Custom Slugs Below.
- Added Default Tag and Default Attribute Term Slug controls for Collection Type, Core Ingredient, Cluster, Producer/Maker, Region Cluster, SHG, Use Case, Village/Source Location.
- Default selections only apply on first load; user selections from AJAX/forms/URL override them.
- Include/exclude controls still limit both query results and dropdown options.


## v1.2.7 — Editor Picker Controls for Include/Exclude and Defaults
- Replaced slug-entry controls with Elementor SELECT/SELECT2 option pickers for product categories, tags, attributes, and products.
- Include/exclude product IDs now use selectable product options instead of manual ID typing.
- Attribute include/exclude and default selections now use readable term dropdowns.
- Kept internal values slug/ID based for stable frontend URLs and query compatibility.
- Existing older slug/text settings remain compatible because query helpers still accept strings and arrays.


## v1.2.8 — Safe Editor Term Picker Fallback
- Fixed blank Elementor include/exclude/default term controls by adding a direct WooCommerce/WordPress term-table fallback.
- Product category, product tag and WooCommerce attribute controls now try normal taxonomy loading first, then safe DB lookup when Elementor editor loads controls before taxonomies are fully available.
- If a taxonomy truly has no terms, the control now shows a clear 'No terms found' placeholder instead of appearing blank.
- No frontend layout/card/filter CSS changed.
- Existing query/filter logic remains backward-compatible.


## v1.2.9 — Final Collection Filter Hardening

Purpose:
- Reviewed the plugin after the collection-page filter workflow.
- Kept existing settings/data safe while fixing layout defaults and future-proofing.

Changes:
- New widgets default to Tablet/Phone Compact Inline Filter Bar instead of Drawer Toolbar.
- Default desktop sidebar width increased from 260px to 290px for better readability.
- Default card minimum width increased from 220px to 240px.
- Default grid gap increased from 26px to 30px.
- Frontend CSS now uses a safer desktop sidebar visual width with a 280px comfortable floor on wide screens.
- Filter field height and padding lightly improved for more premium/consistent feel.
- No global CSS selectors added. All frontend changes remain scoped to `.amaley-discovery-engine-v1`.

Safety:
- Existing saved Elementor values are preserved.
- No WooCommerce archive override.
- No Elementor template override.
- No JetSmart/Freshen/Apus dependency.
- Settings remain import/export compatible.
- Old broken-folder recovery workflow should be avoided; always export settings before plugin replacement.

## v1.3.0 — Sidebar / Filter Panel Control Panel

Purpose: Give the user direct Elementor controls for the collection/shop sidebar and compact filter layout, instead of requiring code edits or CSS patches.

Added controls under Content → Layout:
- Sidebar / Filter Panel Control heading
- Sidebar Width
- Sidebar Minimum Width
- Sidebar Sticky Top Offset
- Top Bar Field Min Width
- Apply / Clear Button Gap
- Card Minimum Width
- Filter + Card Grid Gap

Added controls under Style → Filter Style:
- Input Inner Padding
- Apply / Clear Gap styling control

Hardening rules:
- All changes stay scoped to `.amaley-discovery-engine-v1`.
- No WooCommerce, Elementor, Freshen/Apus, or global selector override.
- New controls are variables-based and backward compatible with existing widget settings.
- Default values keep the approved compact Amaley layout.

Recommended collection page starting values:
- Sidebar Width: 290–310
- Sidebar Minimum Width: 260
- Sidebar Sticky Top Offset: 96
- Top Bar Field Min Width: 150
- Apply / Clear Button Gap: 10
- Card Minimum Width: 240
- Filter + Card Grid Gap: 30


## v1.3.1
- Added OG-style result top bar support: products found count can stay above cards while sort appears on the same top row, not inside the left sidebar.
- Added hidden sort field when the sidebar sort dropdown is disabled, so top-bar sort still works with AJAX.
- Kept CSS scoped to `.amaley-discovery-engine-v1`.


## v1.3.3 — Filter label controls and filter panel heading

- Added Elementor controls to rename every visible filter label: Search, Category, Tag, Collection Type, Core Ingredient, Cluster, Producer/Maker, Source Belt/Region Cluster, SHG/Producer Group, Use Case, Village/Source Location, Price, Stock and Sort.
- Added a controlled optional filter panel heading with small label + title above filter fields.
- Added editable default dropdown option text and search placeholder.
- Kept all changes scoped to `.amaley-discovery-engine-v1`; no global Elementor, WooCommerce or theme overrides.
- Defaults preserve previous frontend output unless the new controls are changed.


## v1.3.4 — Sidebar CTA Style + Device Controls
- Added desktop/tablet/phone visibility controls for the sidebar CTA / Collection Builder box.
- Added dedicated Style tab controls for CTA margin, padding, radius, border, shadow, typography, spacing, and button styling.
- Kept all CSS scoped to `.amaley-discovery-engine-v1` and CTA-specific classes.
- Default CTA visibility when enabled: desktop visible, tablet hidden, phone hidden.
