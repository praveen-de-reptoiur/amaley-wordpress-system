
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
