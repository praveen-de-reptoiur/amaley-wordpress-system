# Testing Checklist — Amaley UI Sections Kit v0.5.1

## Activation

- Upload ZIP on staging/local first.
- Activate without PHP fatal error.
- Confirm plugin version shows 0.5.1.

## Home Hero V6

- Confirm shortcode `[amaley_home_hero_v6]` renders.
- Confirm Elementor widget `Amaley Home Hero V6` appears under `Amaley UI`.
- Confirm desktop layout is 2-column with left content and right 3-image mosaic.
- Confirm live counter animates from zero.
- Confirm right images use cover fit with no empty gaps.
- Confirm mobile stacks left content then image mosaic.
- Confirm no styling leak outside `.amaley-home-hero-v6`.

## Conflict Safety

- Discovery Engine filters still work.
- Amaley Core CPTs remain unchanged.
- Amaley Templates widgets remain unchanged.
- Site Shell header/footer remains unchanged.
- WooCommerce product pages, cart and checkout remain unchanged.
