## v1.0.46 — Cluster Single Spacing Rhythm Polish

- Reduced default vertical spacing between separate Cluster Single section widgets so the page reads as one continuous flow instead of disconnected blocks.
- Added scoped rhythm overrides for Hero, Quick Details/Snapshot, Story, Women Collectives/SHGs, Producers, Products, Gallery, Contact and CTA sections.
- Added Elementor widget-wrapper rhythm rules for stacked Cluster Single widgets.
- Preserved section-wise architecture: widgets remain separate and non-coder controllable.
- No data logic, relation mapping, WooCommerce, header/footer, route or permalink change.


## v1.0.44 — Single Story Label + Rich Text Fix

- Removed unwanted decorative prefix line before `.amcss-label` in cluster single section widgets.
- Added rich text/WYSIWYG custom story fallback control to `Amaley Cluster Story` widget.
- Added optional custom story override toggle so Elementor can use formatted story content when needed.
- Kept cluster Full Story as default source unless override is enabled.
- No WooCommerce/theme/header/footer/permalink changes.

## v1.0.36 - Cluster Single Relation Query Fix
- Fixed Related SHGs showing only one record in cluster single template.
- Added support for Meta Box plugin relationship table (`mb_relationships`) in single template related sections.
- Related SHGs, Producers and Products now include all connected items by default with a new Show All Connected Items toggle.
- Added fallback lookup by cluster code as well as cluster ID.
- Kept changes scoped to Amaley Core single template widgets; no theme/WooCommerce/header/footer changes.


## 1.0.31 - Cluster Archive Grid heading consistency fix
- Fixed Cluster Archive Grid heading block so the small label stacks above the heading, matching the approved intro section rhythm.
- Prevented the small label from becoming a large left-side vertical/side block.
- Added Elementor controls for small label margin and description margin.
- Kept theme/WooCommerce/header/footer untouched.

## v1.0.28 — Cluster Archive Section Widgets System

- Added section-wise Elementor widgets for Cluster Archive page.
- Added Archive Hero, Trust Strip, Intro, Grid and CTA Band widgets.
- Kept all-in-one archive/single widgets as legacy only.
- Added scoped CSS under `amaley-core-cluster-archive-sections.css`.
- Added fallback shortcodes for each archive section.
- No WooCommerce/theme/header/footer override.


## 1.0.26 - Page-Based Final Setup Lock
- Locked safest implementation approach for live site: normal WordPress pages + Elementor + Amaley Core shortcodes/widgets.
- Added Safe Page Setup guidance inside Amaley Core Settings.
- Added admin control for archive card detail URL pattern.
- Updated default detail URL pattern to `/cluster-detail/?cluster_id={id}`.
- Updated single breadcrumb return URL default to `/clusters/`.
- No WooCommerce template override, theme override, header/footer change, or clean permalink rewrite added.

## v1.0.23 - Breadcrumb Link Fix
- Made Cluster Archive and Single hero breadcrumbs functional links.
- Added Elementor controls for breadcrumb URL targets.
- Kept hero layout/body sections unchanged from v1.0.22.

## 1.0.22 — Archive hero differentiation
- Made Cluster Archive hero visually different from Cluster Single hero.
- Added archive-specific browse/directory hero layout.
- Kept single cluster page body structure unchanged.
- No WooCommerce/theme/header/footer override.


## v1.0.21 — Cluster Hero Cleanup + Archive Card Visibility Fix

- Reduced cluster archive/single hero height.
- Removed confusing right-side origin card and target/crosshair hero graphic.
- Added cleaner dark chocolate hero aligned with Amaley site rhythm.
- Fixed archive cluster query so clusters display even when display-order meta is missing.
- Preserved approved single page content flow below hero.

# Changelog

## 1.0.32 - Archive section widgets full control rebuild
- Rebuilt Cluster Archive Hero, Trust Strip, Intro, Grid and CTA Elementor controls.
- Added section-wise Content, Data/Links, Layout, Section Box, Typography, Card, Image, Tags, Stats and Button controls.
- Fixed grid heading alignment system so block alignment, text alignment and max width can be controlled separately.
- Added full card inner controls for grid: card padding, inner gap, media height/radius, title/text margins, tag wrapper gap/margin, tag padding/radius/border, stat wrapper/box padding/margin/radius/border, stat number/label typography, and button width/alignment/margin/padding/radius.
- Updated grid stat markup to separate number and label for reliable styling.
- Reworked scoped archive CSS to reduce hardcoded layout conflicts and support Elementor-generated selectors.
- No WooCommerce override, no theme template override, no header/footer change, no permalink rewrite.

## 1.0.20
- Refined Cluster Archive and Cluster Single hero to a richer Amaley premium dark-chocolate visual system.
- Added origin story card stack inside hero for a more complete Amaley section feel.
- Added data fallback profiles for clusters with incomplete fields.
- Added sample-ready SHG, producer and product cards when linked data is missing.
- Kept all CSS scoped and avoided WooCommerce/theme/header/footer overrides.


## 1.0.20 — Cluster Pages Visual Polish

- Polished OG-aligned Cluster Archive and Cluster Single visual system.
- Added cluster image/fallback visual panels to featured cluster, archive cards and single detail layouts.
- Improved dark hero, trust strip, traceability cards, map panel, CTA band and mobile responsiveness.
- Changed archive default to show clusters without requiring the Show on Website flag, while preserving Elementor filtering control.
- Maintains no WooCommerce template override, no theme template override, and no header/footer changes.


## v1.0.14 - Product Origin import by product name / ID
- Adds safer Product Origin Mapping import using product_sku, product_id, or exact product_name.
- Keeps existing SKU import working.
- Useful when WooCommerce SKUs are incomplete or not visible during mapping.


## v1.0.13
- Added Product Origin Panel shortcode and Elementor widget.
- Added shortcode `[amaley_product_origin_panel]`.
- Supports current product auto-detection, manual product ID, and manual WooCommerce SKU.
- Displays origin cluster, linked SHG groups, linked producers, source village, origin note and traceability note.
- Includes field visibility controls, layout styles, typography/color/background/padding controls, and safe empty state.


## v1.0.12
- Stabilized editorial shortcode query behavior for Cluster and SHG widgets.
- When `show_only_website="0"` is used, Cluster and SHG widgets now directly query all manageable statuses instead of relying on a secondary fallback.
- Added stronger final fallback query so editorial layout uses the same available CPT data as grid layout.
- No layout changes to existing grid cards.

## v1.0.11
- Fixed editorial shortcodes returning empty for Cluster and SHG cards in test conditions by adding a safe fallback query when `show_only_website="0"` is used.
- Preserved existing grid layouts.
- Improved member editorial fallback media text while keeping proper rectangular image area.
- No GitHub write required for this test package.


## v1.0.10
- Added optional Editorial Wide card variation for Cluster, SHG Group, and Member / Producer widgets.
- Preserved existing grid card layout as default.
- Added Elementor “Card Layout” control with Grid Cards and Editorial Wide options.
- Added shortcode layout_style="editorial" support.
- Kept warm Amaley design language without copying the external reference.


## v1.0.9
- Refined Member / Producer Cards again to keep a proper top image area instead of circular avatar style.
- Added compact rectangular media section for real producer photos when available.
- Added soft branded fallback media block when no image is available.
- Preserved compact hierarchy and reduced chip clutter from v1.0.8.


## v1.0.8
- Refined Member / Producer Cards layout into a compact professional profile card.
- Removed the large empty hero-style image block from fallback cards.
- Added compact circular avatar treatment with initials fallback.
- Improved information hierarchy for name, role, village, SHG, and cluster.
- Reduced chip clutter by limiting skills and product tags on cards.
- Updated default member CTA text to “View Profile”.

## v1.0.7 — Member / Producer Cards Grid
- Added Member / Producer Cards Grid shortcode and Elementor widget.
- Added scoped member card CSS.
- Kept producer privacy safe: phone/exact contact data not rendered.

## 1.0.6 - Import form restored
- Restored full Import CSV form in Amaley Core → Import / Export.
- Restored dry-run preview import handler for Clusters, SHGs, Members and Product Origin Mapping.
- Kept v1.0.5 SHG cards and v1.0.4 compact cluster cards.

## 1.0.5 - SHG Group Cards Grid test build
- Added SHG Group Cards Grid shortcode `[amaley_shg_cards]`.
- Added Elementor widget: Amaley SHG Group Cards Grid.
- Added scoped mobile-first CSS and full visibility/layout/style controls.

# Changelog

## 1.0.32 - Archive section widgets full control rebuild
- Rebuilt Cluster Archive Hero, Trust Strip, Intro, Grid and CTA Elementor controls.
- Added section-wise Content, Data/Links, Layout, Section Box, Typography, Card, Image, Tags, Stats and Button controls.
- Fixed grid heading alignment system so block alignment, text alignment and max width can be controlled separately.
- Added full card inner controls for grid: card padding, inner gap, media height/radius, title/text margins, tag wrapper gap/margin, tag padding/radius/border, stat wrapper/box padding/margin/radius/border, stat number/label typography, and button width/alignment/margin/padding/radius.
- Updated grid stat markup to separate number and label for reliable styling.
- Reworked scoped archive CSS to reduce hardcoded layout conflicts and support Elementor-generated selectors.
- No WooCommerce override, no theme template override, no header/footer change, no permalink rewrite.

## 1.0.4 - Cluster Cards Grid — Compact 4 Column Test Build

- Added Cluster Cards Grid — Compact 4 Column shortcode: `[amaley_cluster_cards]`.
- Added Elementor widget: Amaley Core > Amaley Cluster Cards Grid — Compact 4 Column.
- Added scoped frontend CSS for mobile-first cluster cards.
- Added data source, field visibility, layout, typography, color, spacing, border, background and button controls.

## 1.0.2

- Cluster, SHG Group, Member/Producer and Product Origin Mapping backbone.


## v1.0.15 — Product Origin Panel Product Name Source

- Added `product_name` attribute to `[amaley_product_origin_panel]` so mapped products can be rendered without manually finding product IDs/SKUs.
- Added optional `product_slug` attribute for stable page/template usage.
- Added Elementor data-source controls for Product Name and Product Slug.
- Kept existing Product ID, Product SKU, and auto-detect behavior unchanged.
- No WooCommerce template override, no Discovery Engine changes, no header/footer changes.

## 1.0.18 — OG-Aligned Cluster Archive + Single Page
- Adds OG-inspired Cluster Archive and Cluster Single page widgets.
- Uses dark chocolate `shop-hero` style in scoped plugin CSS.
- Adds trust strip, traceability flow, featured cluster, cluster grid, single cluster story, related SHGs, members and products.
- Preserves conflict-safe architecture: no WooCommerce/theme/header/footer override.
## v1.0.24 — Cluster Archive Hero Directory Redesign

- Redesigned Cluster Archive hero so it is visually different from the Cluster Single hero.
- Converted archive hero into a compact directory/browse style section.
- Removed confusing right-side archive card from the archive hero.
- Kept single cluster body sections unchanged.
- Kept CSS scoped and avoided WooCommerce/theme/header/footer overrides.
## v1.0.25 — Admin Template Edit Panel

- Added editable non-coder template settings panel under Amaley Core → Settings.
- Added Cluster Archive defaults for hero, intro, traceability, archive copy, CTA, breadcrumb URLs and section visibility.
- Added Cluster Single defaults for breadcrumb, CTA and section visibility.
- Cluster Archive and Single widgets now use saved admin defaults while still allowing Elementor/shortcode overrides.
- No WooCommerce template override, no theme override, no header/footer change, and no global CSS.


## 1.0.29 - Page Template Assignment / Safe Routing
- Added Page Template Assignment controls in Amaley Core Settings.
- Added Cluster Archive Page and Cluster Single Template Page dropdowns.
- Added cluster detail parameter mode: cluster_slug or cluster_id.
- Added future SHG/Producer page assignment placeholders.
- Updated Archive Grid widget with a dedicated Routing / Single Template panel.
- Archive Grid can now use the assigned Single Template Page automatically.
- Kept manual detail URL override as fallback.
- No theme, WooCommerce, header/footer or rewrite override added.


## 1.0.30 - Archive section controls and polish
- Expanded Elementor controls for cluster archive section widgets.
- Added section-wise controls for typography, color, padding, margin, spacing, border, radius, background, shadow and alignment.
- Improved default archive card and section polish without touching theme, WooCommerce, header, footer or routes.
- Kept all-in-one widgets legacy only; section-wise archive widgets remain the recommended workflow.


## v1.0.35 — Single Detail Visual/Data Completion Polish
- Improved single cluster story fallback behavior.
- Extended Cluster/SHG/Member CSV templates/import/export with story, gallery, verification and profile fields.
- Added richer SHG/Producer card data output.
- Tightened single page heading scale, cards, images, spacing and responsive CSS.
- No WooCommerce/theme/header/footer override.

## v1.0.41 — Cluster Single Group-Like Render Fix

- Fixes cluster single template relation display where admin showed multiple linked producer groups but frontend showed only one.
- `get_shgs_for_cluster()` now fetches all detected group-like post types, not only `amaley_shg_group`.
- Keeps section-wise widgets, scoped CSS, and no theme/WooCommerce overrides.
