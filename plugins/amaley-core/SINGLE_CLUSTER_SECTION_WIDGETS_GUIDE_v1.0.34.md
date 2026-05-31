# Amaley Core v1.0.34 — Cluster Single Template Completion

## Purpose
This build improves the Cluster Single Template section widgets after live testing showed that the page looked structurally correct but details were incomplete.

## Use on the selected Cluster Single Template Page
Add widgets in this order:

1. Amaley Cluster Single Hero
2. Amaley Cluster Snapshot
3. Amaley Cluster Story
4. Amaley Cluster Gallery
5. Amaley Cluster Related SHGs
6. Amaley Cluster Related Producers
7. Amaley Cluster Related Products
8. Amaley Cluster Contact / Source Support
9. Amaley Cluster CTA Band

## What changed
- Hero now uses featured image or first gallery image as fallback.
- Snapshot includes more complete fields: cluster code, region, district, block/area, villages, products, SHG count, producer count, mapped products, gallery count and optional contact summary.
- Story no longer shows a weak placeholder when the full story field is empty. It creates a useful narrative from available intro, location, villages and products.
- Related SHG cards now show village, district, member count, product chips and story.
- Related Producer cards now show role, village, skills/products handled and bio.
- Related Product cards show image, price/origin meta, product summary and View Product button.
- New Gallery section widget added.
- New Contact / Source Support section widget added.
- Responsive behavior improved for cards, gallery, contact grid and meta rows.
- Additional Elementor controls added for meta/detail rows and gallery images.

## Data source
Cluster data is managed in:
- Amaley Core → Clusters

Related data is managed in:
- Amaley Core → SHG Groups
- Amaley Core → Members / Producers
- Amaley Core → Product Origin Mapping
- WooCommerce Products

## Safety
- No WooCommerce template override.
- No theme template override.
- No header/footer change.
- No permalink/rewrite change.
- No global CSS.
- Section widgets only.
