# Cluster Single SHG + Member Core Cards v1.0.82

## Purpose
This version connects only the Cluster Single page's SHG and Member/Producer card sections to the centralized Amaley Core Card Renderer.

## Sections connected
- Cluster Single → SHGs connected with this cluster
- Cluster Single → People behind the cluster

## Design followed
The cards now use the locked v1.0.81 final card flow:

1. Media / image or initials area
2. Label / eyebrow
3. Title
4. Short description / excerpt
5. Meta/stat boxes
6. Tags / chips
7. Full-width rounded CTA button

## Global assignments used
- SHG cards use: `card_shg_cluster_single_list`
- Member/Producer cards use: `card_member_cluster_producers`

These are managed from:
Amaley Core Settings → Card Templates & Assignments

## Important
Product cards are not migrated in this version.
Discovery Engine is not touched.
WooCommerce logic is not touched.

## Safety
- Cluster Single Products remain on the existing card flow.
- Header/footer untouched.
- WooCommerce untouched.
- Discovery Engine untouched.
- Product page/cart/checkout untouched.
- Member Single untouched.
- SHG Single untouched.
- CSS is scoped to Cluster Single grid + `.amaley-card*`.
