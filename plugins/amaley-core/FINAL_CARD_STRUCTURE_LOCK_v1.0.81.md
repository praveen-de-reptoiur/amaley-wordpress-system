# Final Card Structure Lock v1.0.81

## Purpose
This version locks the shared card design structure based on the final screenshots provided for:
- Product Card
- SHG / Collective Card
- Member / Producer Card
- Cluster Card

Cluster cards follow the same design flow as the SHG card.

## Final card flow
All centralized Amaley Core cards now follow this structure:

1. Media / image area
2. Label / eyebrow
3. Title
4. Short description / excerpt
5. Meta/stat boxes
6. Tags / chips
7. Full-width rounded CTA button

## Important
This version updates the central Amaley Core Card Renderer and card CSS only.
It does not force all old frontend cards to change automatically.

Existing widgets/pages will be connected one by one in later versions.

## Add-on friendly structure
The renderer now uses shared helper methods:
- `card_markup()`
- `meta_markup()`
- `tags_markup()`
- `split_tags()`
- `image_for_post()`
- `initials()`

This makes future card add-ons easier without rewriting each card again.

## What changed
- Product renderer aligned with final Product card structure
- SHG renderer aligned with final SHG card structure
- Member renderer aligned with final Producer card structure
- Cluster renderer aligned with the same SHG-style card flow
- New fallback initials bubble for missing images
- Meta boxes and tags are generated from shared helper functions
- CSS is scoped only to `.amaley-card*`

## What did not change
- No Discovery Engine migration yet
- No WooCommerce logic change
- No product page/cart/checkout change
- No SHG/Cluster/Member archive replacement
- No header/footer change
- No global CSS

## Next recommended step
After this card structure is accepted, connect one frontend area at a time:
1. Member Single Products already has optional Core card pilot
2. Cluster Single SHGs can be connected next
3. Cluster Single Members can be connected next
4. Discovery Engine product grid should be connected later after card is stable
