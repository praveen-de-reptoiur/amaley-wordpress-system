# Amaley Core v1.0.41 — Explicit Cluster Linked Groups Fix

## Why this exists

The debug tool showed that the current database had only one SHG/group record truly linked to the selected cluster through readable meta. The admin screen appeared to show more linked producer groups, but those IDs were not available in `wp_mb_relationships` or cluster meta in a reliable way.

## Fix

v1.0.41 adds a stable explicit cluster-side relation field:

`_amaley_cluster_linked_group_ids`

This field is managed from the cluster edit screen in a side metabox:

**Amaley Linked Producer Groups / SHGs**

The cluster single template now reads this field first before trying old/reverse relationship detection.

## How to use

1. Install the test plugin.
2. Open the cluster edit screen.
3. In the right side box **Amaley Linked Producer Groups / SHGs**, tick all groups that should show on the single cluster page.
4. Save/Update the cluster.
5. Open the frontend single cluster page.

Expected result:
- Quick Details → SHGs count matches selected groups.
- Women Collectives section shows all selected group cards.

## Safety

- No theme override.
- No WooCommerce override.
- No permalink rewrite.
- No header/footer changes.
- Scoped plugin logic only.
