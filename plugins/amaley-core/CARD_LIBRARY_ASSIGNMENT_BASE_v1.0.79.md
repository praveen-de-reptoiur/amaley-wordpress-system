# Amaley Core Card Library & Assignment Base v1.0.79

## Purpose
This version starts the centralized Amaley Card Library & Assignment architecture.

The goal is to stop repeated card-level patching by making Amaley Core the shared source for reusable, Elementor-controlled cards.

## Current baseline
Built on:
`AMALEY_CORE_v1.0.78.10_MEMBER_SINGLE_PRODUCT_CARD_CONSISTENCY_FIX_TEST_PLUGIN`

## What this version adds
- New Card Registry:
  - Product Card presets
  - SHG / Collective Card presets
  - Cluster Card presets
  - Member / Producer Card presets
  - Assignment locations
  - Default assignments

- New Card Renderer base:
  - `Amaley_Core_Card_Renderer::render_product()`
  - `Amaley_Core_Card_Renderer::render_shg()`
  - `Amaley_Core_Card_Renderer::render_cluster()`
  - `Amaley_Core_Card_Renderer::render_member()`

- New settings section:
  - Amaley Core → Settings → Card Templates & Assignments

- New scoped base card CSS:
  - `assets/amaley-core-cards.css`
  - Uses `.amaley-card*` class family only
  - Does not alter existing `.amms-*`, `.amss-*`, archive, single or product page cards

## Important safety note
v1.0.79 does not replace any existing frontend card output.

The card registry and assignment system are saved now, but existing widgets continue to render as before until a later version connects them one by one.

## Card assignment behavior
Global card assignment works similar to page assignment.

Examples:
- Discovery Product Grid → Compact Marketplace
- Member Single Products → Compact Marketplace
- Member Single Linked SHG → Compact Collective
- Member Single Linked Cluster → Compact Cluster
- Member Archive → Producer Story

## What did not change
- No WooCommerce cart/checkout/product logic change
- No Discovery Engine change
- No Member Single frontend replacement
- No SHG Single frontend replacement
- No Cluster Single frontend replacement
- No archive replacement
- No header/footer change
- No admin schema change
- No global CSS

## Next planned version
v1.0.80:
Connect Member Single Products as the first pilot to the Core Product Card Renderer, with:
- Use Global Assignment
- Choose Manually
- Legacy fallback

Only after v1.0.80 is stable should Discovery Engine or SHG/Cluster/Member card migration begin.
