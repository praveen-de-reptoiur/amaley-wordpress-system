
## v1.0.74 — Admin Rich Text, Media Gallery and Related Button Link Fix

- Loaded WordPress editor scripts on Amaley CPT edit screens and sync TinyMCE before save so SHG/Member/Cluster story rich text fields save reliably.
- Replaced manual gallery URL editing with Media Library select/upload controls for Cluster, SHG Group and Member/Producer gallery fields.
- Fixed Cluster Single related SHG/producer card buttons so they link to assigned detail template pages when configured.
- Scope deliberately limited: no card design, layout, WooCommerce, header/footer, route or CSS redesign changes.

# Changelog

## v1.0.72 — Section action button visibility and alignment control

- Fixed SHG Single section-level action buttons so they stay visible on pale backgrounds instead of blending into the page.
- Added dedicated Section Button Alignment control for SHG Single widgets so section footer buttons can be aligned left, center or right independently from card buttons.
- Added section button background/text/hover color controls for SHG Single widgets.
- Added the same visibility safety to Cluster Single related-section buttons without changing locked cluster, SHG, member or product card designs.
- Kept product card, SHG card, member card, cluster card and WooCommerce mapping logic untouched.

## v1.0.71 — SHG Single product price meta alignment fix

- Tightened the locked SHG Single product card price/origin meta row.
- Fixed WooCommerce price amount vertical alignment inside the compact price box.
- Kept the approved product card layout, image cover/center-center, description clamp, chips, button and responsive grid unchanged.
- Scope remains SHG Single only; no header/footer, archive, cluster page or WooCommerce template override changes.


## 1.0.70 — SHG Single Product Card + Button Alignment Recovery
- Restored mapped product cards to the locked compact Amaley product-card look.
- Set SHG Single product defaults to 4 desktop / 2 tablet / 1 mobile columns.
- Added product button wrapper so card/section button alignment controls work.
- Added card button width and section button width controls.
- Kept changes scoped to SHG Single selectors only.


## v1.0.69 — SHG Single CSS Recovery + Control Selector Audit

- Removed the v1.0.68 broad SHG Single CSS override that changed hero/contact/background behaviour.
- Restored approved SHG Single hero, contact/CTA, product card and related-card styling from the stable v1.0.66/v1.0.67 line.
- Kept section-level CTA buttons for Members, Products and Gallery without affecting global/card CSS.
- Expanded Elementor control selectors for section buttons, card images, meta boxes and locked card families.
- Scope remains SHG Single assets only; no Cluster Archive, Cluster Single, SHG Archive, WooCommerce template, header or footer CSS changed.


## v1.0.68 — SHG Single Locked Card + Section Button Pass

- Aligned SHG Single related Cluster, Member/Producer and Product sections with the approved locked Amaley card design system.
- Added section-level CTA buttons for limited-preview card sections.
- Added member/producer card CTA output.
- Preserved product card family and image cover/center-center rule.
- Kept CSS scoped to SHG Single section widgets.

## v1.0.66 — Cluster Archive + Single Consistency Controls

- Cleaned Cluster Archive CSS into one scoped consistency system.
- Matched Cluster Archive visual rhythm closer to Cluster Single / approved Amaley dark chocolate + ivory direction.
- Kept Cluster card data/details untouched.
- Added section-level CTA buttons for Cluster Single SHG, Producer and Product sections.
- Set related sections toward 4-card preview with link-out buttons.
- Added controls for section button show/hide, text, URL and alignment.
- Ensured image areas use cover + center center.
- No WooCommerce/header/footer/discovery route changes.


## v1.0.64 — SHG Single Copy + Gallery Polish

- Fixed SHG Single Members/Products default copy so products do not inherit generic `Connected Network / Linked items` text.
- Added render-time cleanup for old generic saved defaults.
- Improved SHG Single gallery URL parsing so labelled gallery lines can still extract valid image URLs.
- Preserved v1.0.63 Elementor template preview fallback.
- Preserved SHG Archive v1.0.61 CSS cleanup state.


## v1.0.63 - SHG Single Template Preview Fallback

- Fixes SHG Single Elementor/template preview URLs that do not include `shg_slug` or `shg_id`.
- Adds safe preview fallback: Elementor editor / WordPress preview uses the first available SHG group so all SHG Single sections can be edited with real data.
- Live frontend detail URLs still use `shg_slug` / `shg_id` from archive cards.
- No SHG Archive CSS change.
- No WooCommerce, header, footer, Discovery Engine, permalink or route changes.

## v1.0.61 — SHG Archive CSS Cleanup + Full Section Control Pass

- Replaced stacked SHG Archive patch CSS with one clean scoped CSS system.
- Reduced `!important` usage so Elementor controls can actually override colors, spacing, alignment, image height, typography and card settings.
- Kept SHG Archive Hero dark chocolate background consistency.
- Kept phone hero stats as 2 + 2.
- Kept card image/placeholder sizing responsive and controllable.
- Kept motion smooth, subtle and controllable through the existing Animation / Micro Motion controls.
- Preserved v1.0.49 grid query fix and v1.0.53 gallery base.
- No SHG Single change, no WooCommerce change, no header/footer change, no Discovery Engine change.

# Amaley Core Changelog

## v1.0.60 — SHG Archive Smooth Motion and Alignment Controls

- Softened SHG Archive transform/motion defaults after live review.
- Added alignment controls for SHG Archive Hero, Trust Strip, Intro, Grid, Gallery and CTA widgets.
- Added motion intensity controls for hover lift, hover scale and image zoom.
- Kept SHG Single, WooCommerce, header/footer, routes and Discovery Engine untouched.
- GitHub not touched; test package only.

## v1.0.59 — SHG Archive Motion + Card Transform Restore

- Restored visible transform/hover motion on SHG archive cards.
- Fixed v1.0.58 motion issue where animation depended on a wrapper class that may not exist until Elementor saves the control.
- Motion now runs by default and can still be disabled through the Motion Off control.
- Preserved dark-chocolate SHG Archive Hero, mobile 2+2 stat layout, grid query fix, gallery base and card details.
- No SHG Single, WooCommerce, header/footer, route, Discovery Engine or data changes.


## v1.0.58 — SHG Archive Alive Motion + Micro Polish

- Added scoped CSS-only entrance motion and hover lift for SHG Archive Hero, Trust Strip, Intro, Grid, Gallery and CTA sections.
- Added Animation / Micro Motion controls to SHG Archive section widgets.
- Preserved dark chocolate hero consistency, phone 2+2 stats layout, gallery base, grid query fix and SHG card rendering.
- No WooCommerce, header/footer, Discovery Engine or SHG Single changes.

## v1.0.57 — SHG Archive Hero Consistency + Control Correction

- Restores SHG Archive hero to dark chocolate Amaley visual rhythm.
- Fixes mobile stats panel to remain 2 + 2 on phone by default.
- Adds stats column controls for desktop/tablet/mobile.
- Adds additional Hero typography, stats panel and button style controls.
- Keeps v1.0.56 grid controls and responsive safeguards.
- Keeps v1.0.53 gallery fields/sections.
- No WooCommerce, header/footer, route or SHG Single changes.

## v1.0.56 — SHG Archive Full-Control Responsive Fix

- Adds safer, grouped Elementor controls for SHG Archive Grid after user feedback.
- Adds phone responsive safeguards for SHG archive cards, hero stats and detail boxes.
- Adds dedicated controls for image/placeholder height, image opacity, card spacing, description words, line clamp, max tags, meta boxes and button styling.
- Preserves v1.0.49 grid query fix and v1.0.53 gallery base.
- Does not touch SHG Single, WooCommerce, header/footer, routes or Discovery Engine.

## v1.0.53 — Gallery Sections and Gallery Fields

## v1.0.55 — SHG Archive Safe Restore

- Restores stable SHG archive/gallery baseline after v1.0.54 full-control alignment test caused Elementor editor critical error.
- Keeps v1.0.53 gallery fields and archive gallery widget baseline.
- No WooCommerce/header/footer/routing changes.

- Added SHG Archive Gallery widget and shortcode.
- Added Cluster Archive Gallery widget and shortcode.
- Added Member / Producer gallery image URL field.
- Improved gallery field labels/descriptions for Cluster and SHG records.
- Added member import/export support for `gallery_urls`.
- Preserved v1.0.49 grid query fix and v1.0.52 SHG Archive card/control polish.
- No WooCommerce/header/footer/route/discovery change.

## v1.0.52 — SHG Archive Font, Card and Control Polish

- Removed duplicated Status detail row from SHG Archive cards when the verification badge is already shown.
- Added Story Words Per Card control so card description length is non-coder adjustable.
- Tightened 4-column SHG Archive card proportions and reduced placeholder/image dominance.
- Strengthened hero button visibility against theme CSS.
- Improved hero stat fallback from old text labels to meaningful dynamic counts.
- Cleaned the second explanation section copy.
- Added safer typography rhythm for SHG Archive sections.
- Preserved v1.0.49 grid query fix and existing SHG widgets.
- No WooCommerce/header/footer/permalink change.

## v1.0.51 — SHG Archive Card Consistency Polish

- Refined SHG Archive hero stats to show meaningful origin-network numbers.
- Fixed primary hero button visibility.
- Aligned SHG Archive card design closer to the SHG cards used in Cluster Single related sections.
- Added compact card detail grid for cluster, location, members, verification and contact.
- Reduced card size, set default desktop grid to 4 columns and kept product tags compact.
- Kept v1.0.48 widget registration fix and v1.0.49 grid query fix preserved.
- No SHG Single, WooCommerce, header/footer, route or Discovery Engine change.

## v1.0.50 — SHG Archive Polish + Full Controls

- Polished SHG Archive default copy and rhythm after live archive review.
- Added proper Elementor Content, Show/Hide, Data Source, Layout, Spacing and Color controls for SHG Archive widgets.
- Added card-level show/hide controls for image area, placeholder, verification badge, cluster, location, member count, story, product tags and button.
- Improved SHG Archive card output so missing images do not force oversized blank image blocks unless placeholder display is enabled.
- Fixed CTA title contrast on dark CTA sections.
- Preserved v1.0.49 SHG Archive grid query fix and v1.0.48 Elementor registration fix.
- No WooCommerce checkout/cart, header/footer, permalink or Discovery Engine changes.


## v1.0.49 — SHG Archive Grid Query Fix

- Fixed SHG Archive Grid returning empty results when Order By was set to `menu_order`.
- Removed the `_amaley_display_order` meta-key requirement from the default menu-order query because many SHG Group records do not yet have that meta field.
- Changed SHG Archive Grid default `Show Only Website` to off so newly created/staging SHG groups can appear during archive setup.
- Kept SHG section widgets, Elementor registration fix, WooCommerce, header/footer, routes and relations untouched.

## v1.0.48 — SHG Elementor Widget Registration Fix

- Fixed SHG Archive / SHG Single widgets not appearing in Elementor search on some Elementor builds.
- Added legacy Elementor widget registration hook fallback.
- Added duplicate-registration guard.
- Rebuilt installable ZIP with a single clean plugin root: `amaley-core/`.
- Preserved v1.0.47 SHG Archive + SHG Single widgets.
- No WooCommerce, header/footer, permalink, Discovery Engine or relation/meta change.

## v1.0.47 — SHG Archive and Single Section Widgets Foundation

- Added section-wise SHG Archive widgets: Hero, Trust Strip, Intro, Grid and CTA.
- Added section-wise SHG Single widgets: Hero, Snapshot, Story, Linked Cluster, Members, Products, Gallery, Contact and CTA.
- Kept the locked workflow: one page template + multiple Amaley Core section widgets.
- Followed Amaley Section Spacing Rhythm 1 for compact premium spacing.
- Preserved Amaley Core v1.0.46 Cluster Single spacing rhythm, v1.0.45 rich story editor and v1.0.41 explicit cluster group link logic.
- No WooCommerce cart/checkout override.
- No header/footer override.
- No permalink rewrite.
- No Discovery Engine change.

## v1.0.46 — Cluster Single Spacing Rhythm Polish

- Reduced default vertical spacing between separate Cluster Single section widgets so the page reads as one continuous flow instead of disconnected blocks.
- Added scoped rhythm overrides for Hero, Quick Details/Snapshot, Story, Women Collectives/SHGs, Producers, Products, Gallery, Contact and CTA sections.
- Added Elementor widget-wrapper rhythm rules for stacked Cluster Single widgets.
- Preserved section-wise architecture: widgets remain separate and non-coder controllable.
- No data logic, relation mapping, WooCommerce, header/footer, route or permalink change.


## v1.0.65 — SHG Single Card Consistency Fix

- Aligns SHG Single linked cluster and member cards with the accepted Cluster Single related-card rhythm.
- Rebuilds SHG Single product cards into the approved compact Amaley product-card family.
- Uses product image as `cover` with `center center` object position.
- Uses active WooCommerce price only to avoid broken sale/regular price stacking inside card meta boxes.
- Keeps SHG Archive untouched.
- Keeps WooCommerce/cart/checkout/header/footer/discovery untouched.
