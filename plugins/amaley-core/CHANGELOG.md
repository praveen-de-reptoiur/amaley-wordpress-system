## 1.0.99.4
- Fixed OG Member Card 1 hide/show and style control compatibility in Member Archive Grid.
- Added existing Member Archive control classes to OG Member Card 1 markup instead of adding heavy new controls.
- Existing style controls now naturally apply to OG Member Card 1.
- Meta markup now supports existing dt/dd controls while preserving OG card visual rhythm.
- No new control sections, no OG full controls, no transform controls, no archive JS/AJAX and no pagination changes.

## 1.0.99.3
- Added lightweight OG Member Card 1 selector to Amaley Member Archive Grid.
- Built from v1.0.99.2 rollback/editor-safe build.
- Added only Card Template selector and render-level show/hide mapping.
- Existing style controls are intentionally not force-mapped to OG Member Card 1 to keep Elementor stable.
- No heavy OG full controls, no transform controls, no archive JS/AJAX and no pagination changes.

## 1.0.99.2
- Emergency rollback/editor-safe build for Member Archive after v1.0.99 / v1.0.99.1 caused or failed to resolve Elementor left-panel loading.
- Built from stable v1.0.98.1 with only the version number increased.
- Member Archive OG Member Card selector and renderer are intentionally not included in this build.
- Use this to restore editor stability before rebuilding Member Archive in a smaller safer phase.

## 1.0.98.1
- Fixed SHG Archive OG SHG Card 1 existing style controls by remapping them to stronger scoped OG selectors.
- No new controls added; existing controls now target OG card classes more reliably.
- Added important overrides only where needed to beat fixed universal card CSS.
- No heavy OG full controls, no transform controls, no archive JS/AJAX, no pagination changes.

## 1.0.98
- Added lightweight universal OG SHG Card 1 selector to Amaley SHG Archive Grid.
- Added Card Template option: Current / Existing Card or OG SHG Card 1.
- OG SHG Card 1 follows the universal Amaley card flow.
- Existing SHG Archive show/hide controls now map to OG card output.
- Existing SHG Archive style controls now target OG card classes as well as current card classes.
- No OG full controls, no new transform controls, no archive JS/AJAX and no pagination changes.
- Single Cluster, Single SHG, Single Member, Cluster Archive, Discovery Engine, WooCommerce and header/footer untouched.

## 1.0.97.6
- Improved universal Product Card price/meta label-value readability.
- PRICE label remains small uppercase while the price value is now bolder and clearer.
- WooCommerce price markup inside card meta boxes now inherits the correct value styling.
- No card structure, query logic, pagination, Discovery Engine, WooCommerce logic or header/footer changes.

## 1.0.97.5
- Mapped existing Cluster Archive style controls to lightweight OG Cluster Card 1 classes.
- Existing controls 8–13 now affect OG Cluster Card 1 as well as Current / Existing Card.
- No new heavy OG full controls added.
- No transform controls, no archive JS/AJAX, no pagination changes.
- Single Cluster, Single SHG, Single Member, Discovery Engine, WooCommerce and header/footer untouched.

## 1.0.97.4
- Fixed show/hide control behaviour for OG Cluster Card 1 in Cluster Archive Grid.
- Added stronger Elementor switcher value handling for OG card elements.
- Allowed lightweight Card Template / Elements controls to refresh Elementor preview.
- Kept the patch lightweight: no OG full controls, no transform controls, no Cluster Archive JS/AJAX.
- Single Cluster, Single SHG, Single Member, pagination, Discovery Engine, WooCommerce and header/footer untouched.

## 1.0.97.3
- Audited and locked the lightweight Cluster Archive OG card approach.
- Confirmed heavy OG full controls are not included.
- Confirmed transform/motion controls are not included.
- Confirmed no Cluster Archive frontend JavaScript/AJAX registration was added.
- Kept only Card Template selector, simple show/hide controls and OG description word limit.
- No design logic changes beyond v1.0.97.2.
- Single Cluster, Single SHG, Single Member, pagination, Discovery Engine, WooCommerce and header/footer untouched.

## 1.0.97.2
- Rebuilt Cluster Archive OG card support from stable v1.0.96 as a lightweight rescue patch.
- Added only a simple Card Template selector: Current / Existing Card or OG Cluster Card 1.
- Removed/avoided heavy OG full controls to prevent Elementor left-panel loader issues.
- OG Cluster Card 1 uses fixed universal card design through scoped CSS.
- Kept simple show/hide controls and OG description word limit.
- Single Cluster, Single SHG, Single Member, pagination, Discovery Engine, WooCommerce and header/footer untouched.

## 1.0.96
- Added safe AJAX/no-reload pagination to Member Single Products widget.
- Added Enable Pagination, Pagination Previous Text and Pagination Next Text controls.
- Product Limit now works as items per page when pagination is enabled.
- Added lightweight pagination style controls.
- Pagination JS loads only on public frontend, not Elementor editor/preview.
- Expanded product mapping lookup for producer/member origin keys.
- Linked SHG and Linked Cluster remain unpaginated because they are single linked-card sections.
- Single Cluster, Single SHG, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.95
- Rebuilt SHG Single pagination cleanly from stable v1.0.93.3.
- Added pagination to SHG Single Members and Products widgets only.
- Added Enable Pagination, Previous Text and Next Text controls.
- Added lightweight pagination style controls.
- Kept default pagination off for safety.
- Added AJAX/no-reload frontend pagination while keeping pagination JS out of Elementor editor/preview.
- Product lookup now checks multiple SHG origin/meta keys.
- Linked Cluster remains unpaginated because it is a single linked card.
- Single Cluster, Single Member, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.93.3
- Fixed duplicate controls in SHG Single widgets.
- Legacy/current card controls now show only when Card Template is Current / Existing Card.
- OG Card: Full Controls now shows only when Card Template is OG Card 1.
- Kept general section controls visible in both modes.
- No frontend design, card logic, pagination, Single Cluster, Single Member, Discovery Engine, WooCommerce or header/footer changes.

## 1.0.93.2
- Fixed SHG Single OG Card full controls registration.
- `OG Card: Full Controls` now properly loads for SHG Single Linked Cluster, Members and Products when Card Template is OG Card 1.
- Added a small SHG Single OG card compatibility CSS rule without changing the accepted card design.
- No pagination, frontend design, card logic, Single Cluster, Single Member, Discovery Engine, WooCommerce or header/footer changes.

## 1.0.93
- Added safe Card Template selector to SHG Single Linked Cluster, Members and Products sections.
- Default remains Current / Existing Card.
- Selecting OG Card 1 switches Linked Cluster to OG Cluster Card 1, Members to OG Member Card 1 and Products to OG Product Card 1.
- Added full OG Card controls for SHG Single sections aligned with Cluster Single and Member Single controls.
- Enqueued central Amaley Core card CSS for SHG Single sections.
- No pagination, Discovery Engine, WooCommerce, header/footer, Cluster Single or Member Single changes.

## 1.0.92.4
- Added complete Member Single OG Card 1 controls aligned with the accepted Cluster Single control standard.
- Replaced the lighter OG fine-controls section with `OG Card: Full Controls`.
- Added image/placeholder controls, full card box controls, label/title/description controls, meta/stat box controls, tags/chips controls, button controls and transform controls.
- Controls remain conditional and appear only when Card Template is OG Card 1.
- Current / Existing Card controls remain separate for editor performance.
- Cluster Single v1.0.91, pagination, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.92.3
- Improved Elementor editor performance for Member Single card controls.
- OG Card fine controls now display only when Card Template is set to OG Card 1.
- Legacy card controls now display only when Card Template is set to Current / Existing Card.
- Simplified Card Template help text to reduce panel clutter.
- Frontend design, Cluster Single v1.0.91, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.92.2
- Mapped Member Single Linked SHG, Linked Cluster and Products widget style controls to OG Card 1 classes.
- Existing controls now apply to `.amaley-card`, media, label, title, excerpt, body, meta, tags and button elements.
- Added `OG Card: Tags / Inner Gap / Transform` style section with tag/chip controls and transform/motion controls.
- Added safe transform CSS variables for Member Single legacy cards while keeping defaults visually unchanged.
- Cluster Single v1.0.91, pagination, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.92.1
- Corrected Member Single workflow by adding safe Card Template selectors before further pagination work.
- Added Card Template selector to Member Single Linked SHG, Linked Cluster and Products widgets.
- Default remains Current / Existing Card; selecting OG Card 1 switches to the approved central OG SHG, Cluster or Product card renderer.
- Added central OG card stylesheet dependency on Member Single sections.
- Cluster Single v1.0.91, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.91
- Upgraded Cluster Single related-card pagination to AJAX/no-reload for SHG, Producer and Product sections.
- Added frontend script `amaley-core-cluster-pagination.js`.
- Pagination links still keep normal URL fallback if JavaScript fails.
- Only the related card grid and pagination block are replaced during pagination.
- Existing card design, controls, Member Single, SHG Single, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.90
- Added frontend pagination for Cluster Single Related SHGs, Related Producers and Related Products widgets.
- Added Elementor controls for enabling pagination and editing Previous/Next text.
- Added Pagination style controls for alignment, gap, margin, padding, colors, border, radius and typography.
- Number of Items now works as items per page when pagination is enabled.
- Show All Connected Items remains a full-list override.
- Existing accepted card design, SHG/Producer OG card controls, Member Single, SHG Single, Discovery Engine, WooCommerce and header/footer remain untouched.

## 1.0.89
- Added card element show/hide controls for Cluster Single Related SHGs and Related Producers OG cards.
- Added Card Transform / Motion controls for OG cards: translate Y, scale, rotate, hover translate Y, hover scale, hover rotate and transition duration.
- Updated Cluster Single central renderer calls so OG card elements respect Elementor show/hide settings.
- Default values preserve the accepted OG card design.
- No Member Single, product migration, Discovery Engine, WooCommerce, header/footer or unrelated template changes.

## 1.0.88
- Mapped existing Elementor controls in Cluster Single widgets to the locked OG universal card classes.
- Controls now target `.amaley-card`, `.amaley-card__media`, `.amaley-card__label`, `.amaley-card__title`, `.amaley-card__excerpt`, `.amaley-card__meta`, `.amaley-card__tags` and `.amaley-card__button`.
- Added an OG Card Inner Gap control.
- No card redesign, Member Single, product migration, Discovery Engine, WooCommerce, header/footer or unrelated template changes.

## 1.0.87
- Added a simple section-level Card Template selector to Cluster Single Related SHGs and Related Producers widgets.
- Options are limited to OG Card 1 and Current / Existing Card.
- Default is OG Card 1 to preserve the already accepted universal card design.
- Member Single, product cards, Discovery Engine, WooCommerce, header/footer and unrelated templates remain untouched.

## 1.0.86
- Locked the existing approved card designs as named OG Card 1 templates for Cluster, SHG, Member and Product families.
- Added internal OG template definitions with stable design flow and future add-on slots.
- Added scoped CSS aliases for OG Card 1 template classes without changing the accepted visual design.
- Existing frontend pages do not change automatically.
- No Member Single renderer connection, preview widget, product migration, Discovery Engine, WooCommerce, header/footer or unrelated template changes.

## 1.0.85.1
- Reduced card template dropdowns to one approved OG option per family.
- New template names: OG Cluster Card 1, OG SHG Card 1, OG Member Card 1, OG Product Card 1.
- Removed confusing multiple preset options from the settings UI.
- Added internal normalization so old saved preset values resolve to the new OG family template.
- Existing frontend pages do not change automatically.
- Product cards, Discovery Engine, WooCommerce, header/footer and accepted Cluster Single card work remain untouched.

## 1.0.85
- Simplified Card Templates settings UI to only four family-level fields: Cluster, SHGs, Member and Product.
- Hid the previous multi-location card assignment UI to reduce clutter and keep the plugin lighter to manage.
- Added family-level template keys: `card_template_cluster`, `card_template_shg`, `card_template_member`, `card_template_product`.
- Old location keys remain internally for backward compatibility, but are no longer shown in the settings UI.
- Existing frontend pages do not change automatically.
- Product cards, Discovery Engine, WooCommerce, header/footer and existing accepted Cluster Single card work remain untouched.

## 1.0.84.1
- Emergency rollback to accepted v1.0.82.2 / v1.0.83.1 safe state.
- Removes the v1.0.84 preview widget changes by restoring the accepted rollback codebase.
- Keeps accepted Cluster Single SHG/Producer card work.
- No product, Discovery Engine, WooCommerce, header/footer or SHG Single changes.

## 1.0.83.1
- Safe rollback package restoring the accepted v1.0.82.2 codebase.
- Reverts v1.0.83 Member Single Linked SHG/Cluster central card connection due to Member Single layout/CSS breakage.
- Keeps accepted Cluster Single SHG and Producer card work from v1.0.82.2.
- No product, Discovery Engine, WooCommerce, header/footer or SHG Single changes.

## 1.0.82.2
- Visual-only polish for Cluster Single SHG and Producer central cards.
- Improved missing-image placeholder, spacing, title/excerpt rhythm, stat boxes, tags and button alignment.
- No product card, Discovery Engine, WooCommerce logic, query/data, header/footer or unrelated template changes.

## 1.0.82.1
- Fixed central card CSS loading for Cluster Single SHG and Producer cards in Elementor preview/frontend.
- Cluster Single assets now explicitly register and enqueue `amaley-core-cards.css`.
- No query/data logic changes and no product, Discovery Engine, WooCommerce, header/footer or unrelated template changes.

## 1.0.82
- Connected Cluster Single SHG cards to the central Amaley Core SHG Card Renderer.
- Connected Cluster Single Member/Producer cards to the central Amaley Core Member Card Renderer.
- Uses global card assignments: `card_shg_cluster_single_list` and `card_member_cluster_producers`.
- Added URL override support so central cards still open assigned template pages with the correct query arguments.
- Product cards, Discovery Engine, WooCommerce logic, product pages, cart/checkout, header/footer, Member Single and SHG Single remain untouched.

## 1.0.81
- Locked final shared Amaley Core card structure for Product, SHG, Cluster and Member/Producer cards.
- Updated centralized `Amaley_Core_Card_Renderer` to use a consistent media → label → title → excerpt → meta boxes → tags → button flow.
- Added add-on friendly renderer helper methods for card markup, meta boxes, tags, image fallback and initials.
- Updated scoped `.amaley-card*` CSS to match the accepted compact card design rhythm from provided screenshots.
- Cluster card now follows the same design flow as SHG/Collective cards.
- No frontend-wide migration, Discovery Engine change, WooCommerce logic change, header/footer change or global CSS added.

## 1.0.80
- Added optional pilot bridge from Member Single Products widget to Amaley Core Product Card Renderer.
- Default card source remains Legacy, so existing frontend should not change automatically.
- Added Elementor controls for Product Card Source and Manual Product Card Preset.
- Global assignment resolves from `card_product_member_single_products`.
- No Discovery Engine, WooCommerce logic, product page, cart/checkout, header/footer or unrelated card changes.

## 1.0.79
- Added Card Library & Assignment base architecture.
- Added `Amaley_Core_Card_Registry` with Product, SHG, Cluster and Member card families, presets and global assignment locations.
- Added `Amaley_Core_Card_Renderer` skeleton/fallback renderer methods for Product, SHG, Cluster and Member cards.
- Added `Amaley Core → Settings → Card Templates & Assignments` panel, similar to page assignment.
- Added scoped `amaley-core-cards.css` base card stylesheet that only applies when new card renderers are used.
- No existing frontend card output is replaced in this version.
- No WooCommerce, Discovery Engine, header/footer, admin schema or archive/single template changes.

## 1.0.78.10
- Aligned Member Single product cards with the accepted compact Amaley product card style.
- Added product excerpt display and controls.
- Changed product card label default to `Product`.
- Kept price inline and clamped long origin text to avoid card height inconsistency.
- Member Single Products only; no WooCommerce logic or unrelated template changes.

## 1.0.78.9
- Fixed Member Single product card price display so the currency symbol and amount stay inline.
- Added scoped CSS only under `.amms-products .amms-product-meta`.
- No WooCommerce logic, cart/checkout, product page, header/footer, admin schema or archive changes.

## 1.0.78.8
- Added missing box-level Elementor controls for inner stat/meta boxes in Member Single card sections.
- Added padding, margin, radius, min-height, columns and responsive controls for SHG/Cluster card stat boxes and product price/origin boxes.
- Added card margin, tag padding/margin/radius, image radius/margin, and heading text margin controls where missing.
- Controls-only patch; no base CSS redesign or unrelated template changes.

## 1.0.78.7
- Added full section-wise Elementor controls for all Member Single widgets.
- Controls now cover content/show-hide, layout, typography, colors, background, card styling, image/media, tags/chips, stat boxes, buttons, gallery, CTA, and fallback messages.
- Added safe renderer hooks for existing element show/hide controls only.
- No WooCommerce, header/footer, archive, admin schema, SHG Single, or Cluster Single changes.

## 1.0.78.6
- Removed left-right split from Member Single Linked SHG and Linked Cluster sections.
- Converted both sections to Single SHG style rhythm: top heading and cards below.
- Added frontend-safe support for multiple linked SHGs and unique derived clusters if future multi-value metadata exists.
- No admin schema, WooCommerce, header/footer, archive, or unrelated template changes.

## 1.0.78.5
- Safe rollback package from v1.0.78.3 to override the rejected v1.0.78.4 linked-section styling.
- Keeps Producer Story restored as a single editorial card.
- Does not redesign Linked SHG / Linked Cluster; keeps the plugin stable before relation-architecture decisions.

## 1.0.78.1 - Member Single Section Architecture Polish

- Safe Member Single only polish pass on top of v1.0.78.
- Tightened section spacing, hero rhythm, story card, related SHG/Cluster sections, product cards, gallery weight, and closing CTA.
- Added Gallery Max Images control with default curated output of 6 images.
- Added no-media related card class so placeholder bands are not oversized when SHG/Cluster images are missing.
- No WooCommerce, header/footer, Member Archive, Cluster or SHG logic changes.


## 1.0.78 — Member Single Visual Rhythm Polish
- Polished Member / Producer Single section rhythm after first frontend review.
- Balanced hero media size, story card width, linked SHG/Cluster desktop layout, product fallback and CTA spacing.
- Scope limited to Member Single CSS under `.amms-*`; Member Archive, Manual Gallery, SHG, Cluster and product card families remain untouched.

# Changelog

## v1.0.76.5 - Generic Manual Gallery Section
- Added a reusable Elementor widget: **Amaley Manual Gallery Section**.
- Purpose: archive/landing/page galleries where images are selected manually in Elementor.
- Keeps archive gallery separate from CPT single galleries: archive/page = manual images; single CPT page = record/gallery fields.
- Reuses the approved member archive gallery visual rhythm and scoped CSS without changing the locked member/archive card designs.
- Existing Member Archive Gallery widget remains available and unchanged for backwards compatibility.

## v1.0.76.3 - Member Archive Manual Gallery Source Controls

- Updated only the Member Archive Gallery widget.
- Archive gallery now supports manual Elementor image selection/upload through a Gallery control.
- Default gallery source is Manual Elementor Images because archive pages do not reliably fetch member-specific photos.
- Optional source modes remain available: Manual Images then Member Records, or Member Records Only.
- Added image fit, image position, caption source, caption typography, overlay, border, radius, shadow and responsive height controls.
- Preserved v1.0.76 accepted Member Archive design and v1.0.76.2 grid card micro controls.

## v1.0.76.2 - Member Archive Grid Card Micro Controls
- Added missing member archive grid card controls for meta boxes, chip tags, card label/title/bio spacing, placeholder circle, card button and section button.
- Scope is limited to `Amaley Member Archive Grid`; accepted visual design remains unchanged.
- No cluster, SHG, product, header, footer or global CSS changes.


## v1.0.75 - Member / Producer Archive clean rebuild from v1.0.74 baseline
- Added clean Member / Producer Archive Elementor widgets: Hero, Trust Strip, Intro, Grid, Gallery and CTA.
- Built from v1.0.74 baseline only; failed post-v1.0.74 experiments intentionally ignored.
- Controls are section-specific: no dead image/button/stats controls in sections where those elements do not exist.
- Scoped CSS added only for Member / Producer Archive (`ampa-*` classes).
- Existing Cluster, SHG and Product locked card families were not changed.


## v1.0.74 — Admin Rich Text, Media Gallery and Related Button Link Fix

- Loaded WordPress editor scripts on Amaley CPT edit screens and sync TinyMCE before save so SHG/Member/Cluster story rich text fields save reliably.
- Replaced manual gallery URL editing with Media Library select/upload controls for Cluster, SHG Group and Member/Producer gallery fields.
- Fixed Cluster Single related SHG/producer card buttons so they link to assigned detail template pages when configured.
- Scope deliberately limited: no card design, layout, WooCommerce, header/footer, route or CSS redesign changes.

# Changelog

## v1.0.76.3 - Member Archive Manual Gallery Source Controls

- Updated only the Member Archive Gallery widget.
- Archive gallery now supports manual Elementor image selection/upload through a Gallery control.
- Default gallery source is Manual Elementor Images because archive pages do not reliably fetch member-specific photos.
- Optional source modes remain available: Manual Images then Member Records, or Member Records Only.
- Added image fit, image position, caption source, caption typography, overlay, border, radius, shadow and responsive height controls.
- Preserved v1.0.76 accepted Member Archive design and v1.0.76.2 grid card micro controls.

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

## 1.0.78.3 - Member Single Story Card Restore
- Restored Producer Story as a single editorial card after v1.0.78.2 made it look like another linked-card section.
- Scoped changes to Story section only.
- Linked SHG / Linked Cluster structure not changed.
