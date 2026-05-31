# Amaley Core v1.0.33 — Cluster Single Section Widgets

## Read first
This build follows the Universal Full-Control Website Standard:

Every section and every element needs non-coder-friendly Content + Show/Hide + Layout + Style + Responsive control, with scoped lightweight CSS and no conflict.

## Purpose
This update adds section-wise Elementor widgets for the assigned Cluster Single Template Page.

It does not create one page per cluster. One normal WordPress page is selected as the single template page in Amaley Core settings. Archive cards open it using `cluster_slug` or `cluster_id`.

## Widgets added
Add these widgets to the Cluster Single Template Page in this order:

1. Amaley Cluster Single Hero
2. Amaley Cluster Snapshot
3. Amaley Cluster Story
4. Amaley Cluster Related SHGs
5. Amaley Cluster Related Producers
6. Amaley Cluster Related Products
7. Amaley Cluster CTA Band

## Editor preview
Each widget has a **Preview Cluster ID** field. Use this while designing in Elementor so the widget can show sample real cluster data even when the editor URL does not contain `cluster_slug`.

On the live page, the widgets auto-detect the cluster from URL parameters:

- `?cluster_slug=cluster-name`
- `?cluster_id=123`

## Safety
- No theme override
- No WooCommerce override
- No header/footer change
- No permalink/rewrite change
- Scoped CSS only
- Legacy all-in-one widgets remain untouched but are not the final workflow

## Data sources
- Cluster data: Amaley Core → Clusters
- SHGs: Amaley Core → SHG Groups linked by cluster
- Producers: Amaley Core → Members / Producers linked through SHGs
- Products: WooCommerce Products mapped through Product Origin Mapping

## Final workflow
1. Create or use the normal WordPress page selected as Cluster Single Template Page.
2. Edit with Elementor.
3. Add the seven section widgets in order.
4. Set Preview Cluster ID while designing.
5. Publish.
6. Open from the archive card link to test live dynamic data.
