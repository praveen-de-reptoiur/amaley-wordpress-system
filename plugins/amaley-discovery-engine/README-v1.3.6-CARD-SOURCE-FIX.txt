Amaley Discovery Engine v1.3.6
Author: Praveen

Purpose:
- Source-level fix for product card rendering.
- Product discovery results, AJAX filters, sort and pagination use the same renderer path.
- Adds Amaley Core product card renderer support inside Discovery Engine renderer.
- Default product card renderer: Amaley Core Product Card -> OG Product Card 1.

Safety:
- Does not register CPTs.
- Does not change product data.
- Does not change product images/gallery.
- Does not change origin mappings.
- Does not change WooCommerce templates, cart, checkout, header or footer.
- Product filters, query and pagination stay inside Discovery Engine.

Before install:
- Backup current /wp-content/plugins/amaley-discovery-engine/ folder.
- Deactivate/delete old temporary patch plugins named amaley-discovery-card-renderer-selector-fix v1.0.0 to v1.3.3.
- Deactivate/delete amaley-discovery-widget-disable if active.

After install:
- Select Product Card Renderer: Amaley Core Product Card — Select Template.
- Template: OG Product Card 1.
- Regenerate Elementor CSS & Data.
- Purge LiteSpeed/Hostinger cache.
- Test page 1, page 2, page 3, filter, reset and sort.
