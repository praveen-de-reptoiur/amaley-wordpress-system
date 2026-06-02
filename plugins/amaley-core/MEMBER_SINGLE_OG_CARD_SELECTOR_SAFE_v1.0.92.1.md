# Member Single OG Card Selector Safe v1.0.92.1

## Purpose
This corrects the Member Single sequence. Pagination alone was not enough; the Member Single cards first need a Card Template selector so they can use the approved universal OG Card 1 designs.

## Widgets updated
- Amaley Member Single Linked SHG
- Amaley Member Single Linked Cluster
- Amaley Member Single Products

## New control
Content / Show-Hide → Card Template

Options:
- Current / Existing Card
- OG Card 1

## Behaviour
- Default remains Current / Existing Card for safety.
- Selecting OG Card 1 switches that section to the approved central card renderer:
  - Linked SHG → OG SHG Card 1
  - Linked Cluster → OG Cluster Card 1
  - Products → OG Product Card 1

## Scope safety
- Cluster Single v1.0.91 remains untouched.
- Discovery Engine is untouched.
- WooCommerce logic is untouched.
- Header/footer are untouched.
- This patch does not add Member Single pagination yet. Pagination should be added after OG card switching is confirmed stable.
