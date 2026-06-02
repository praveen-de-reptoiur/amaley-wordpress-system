# Member Single Controls Performance Fix v1.0.92.3

## Purpose
v1.0.92.2 mapped many controls to OG card selectors. The controls worked, but Elementor editor could repeatedly reload the left panel because old card controls and OG card controls were both active at once.

## Fix
This version makes the Member Single card controls performance-safe:

- OG Card controls are shown only when Card Template = OG Card 1
- Legacy/current card controls are shown only when Card Template = Current / Existing Card
- Card Template description was simplified
- Frontend card design is unchanged

## Widgets affected
- Amaley Member Single Linked SHG
- Amaley Member Single Linked Cluster
- Amaley Member Single Products

## Safety
- Cluster Single v1.0.91 remains untouched
- Discovery Engine untouched
- WooCommerce untouched
- Header/footer untouched
- No pagination changes
