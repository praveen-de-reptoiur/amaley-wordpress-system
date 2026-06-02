# Cluster Single Core Card CSS Enqueue Fix v1.0.82.1

## Purpose
After v1.0.82, Cluster Single SHG and Producer sections were rendering central card HTML but the card stylesheet was not reliably loading in Elementor preview/frontend, causing cards to appear like plain text columns.

## What changed
- Cluster Single sections now register `amaley-core-cards.css` directly.
- Cluster Single section stylesheet now depends on `amaley-core-cards`.
- `enqueue_assets()` now explicitly enqueues both:
  - `amaley-core-cards`
  - `amaley-core-cluster-single-sections`
- Added small defensive scoped CSS for Cluster Single SHG/Producer central cards.

## Scope safety
- CSS enqueue/loading fix only.
- No card data/query changes.
- No product cards touched.
- No Discovery Engine touched.
- No WooCommerce logic touched.
- No header/footer touched.
