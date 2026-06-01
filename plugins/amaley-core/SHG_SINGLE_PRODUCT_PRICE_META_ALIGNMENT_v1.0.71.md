# SHG Single Product Price Meta Alignment — v1.0.71

Status: test package
Scope: Amaley Core / SHG Single mapped product cards only

## What changed

- Fixed the compact price meta box alignment inside SHG Single product cards.
- Price label and amount now sit together at the top/compact rhythm instead of leaving a large empty area.
- WooCommerce price HTML (`amount`, `bdi`, `del`, `ins`) is normalized inside this scoped card only.

## What was not changed

- Product card structure remains locked.
- Product image remains `cover` and `center center`.
- Product grid default remains Desktop 4 / Tablet 2 / Mobile 1.
- Section button and card button controls remain unchanged.
- No global CSS, no header/footer changes, no WooCommerce template overrides.
