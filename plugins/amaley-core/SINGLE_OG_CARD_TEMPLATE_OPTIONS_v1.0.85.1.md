# Single OG Card Template Options v1.0.85.1

## Purpose
This version removes multiple card template options from the settings dropdowns.

## New names
Amaley Core Settings now keeps only one approved OG card template per family:

- Cluster → OG Cluster Card 1
- SHGs → OG SHG Card 1
- Member → OG Member Card 1
- Product → OG Product Card 1

## Removed from UI
Old options such as Compact Cluster, Source Cluster, Territory Cluster, Minimal Cluster, Compact Collective, Detailed Collective, Producer Story, etc. are no longer offered.

## Future-safe approach
More templates can be added later only when a new card design is approved, for example:
- OG Cluster Card 2
- OG SHG Card 2
- OG Member Card 2
- OG Product Card 2

## Safety
- Existing frontend pages do not change automatically.
- Old saved preset values are normalized internally to the new OG card family template.
- Product cards remain untouched.
- Discovery Engine remains untouched.
- WooCommerce remains untouched.
- Header/footer remain untouched.
- Existing accepted Cluster Single work remains intact.
