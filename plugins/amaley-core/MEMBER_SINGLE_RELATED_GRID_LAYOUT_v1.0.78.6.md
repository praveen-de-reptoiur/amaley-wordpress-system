# Member Single Related Grid Layout v1.0.78.6

## Purpose
Linked SHG and Linked Cluster sections were not matching the accepted Single SHG page rhythm because they used a left-right split. This patch removes that split.

## What changed
- Linked SHG and Linked Cluster now render as:
  - section label
  - heading
  - short description
  - cards below in a responsive grid
- One card remains compact and left-aligned.
- Two or more cards wrap in a clean card grid.
- Frontend display now reads a future-safe `_amaley_member_shg_ids` multi-value if available, while preserving the current `_amaley_member_shg_id` single field.
- Cluster cards are derived uniquely from linked SHGs, with optional future direct `_amaley_member_cluster_ids` support.

## What did not change
- No admin field schema change.
- No WooCommerce change.
- No header/footer change.
- No SHG/Cluster single page change.
- No archive page change.
