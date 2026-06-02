# Amaley Core v1.0.76 — Member Archive Controls Only

Base: v1.0.75 clean member archive visual rebuild from v1.0.74.

Scope of this version:
- Controls-only update for Member / Producer Archive widgets.
- No visual redesign, no CSS cascade rewrite, no Cluster/SHG/Product card lock changes.
- Existing accepted Member Archive frontend rhythm should remain the same unless Elementor controls are changed by the user.

Widgets covered:
1. Amaley Member Archive Hero
2. Amaley Member Archive Trust Strip
3. Amaley Member Archive Intro
4. Amaley Member Archive Grid
5. Amaley Member Archive Gallery
6. Amaley Member Archive CTA

Control coverage:
- Content + show/hide controls for visible elements.
- Layout and responsive controls per section.
- Style controls for labels, headings, descriptions, cards, icons/dots, image/placeholder, meta boxes, tags, buttons, stats, CTA and gallery/fallback cards.
- Animation/transform controls where the section actually uses motion/card hover.

Non-touch rules:
- Cluster Archive, Cluster Single, SHG Archive, SHG Single and product card lock are untouched.
- CSS remains scoped under `ampa-*` member archive selectors.
- No global CSS overrides added.
