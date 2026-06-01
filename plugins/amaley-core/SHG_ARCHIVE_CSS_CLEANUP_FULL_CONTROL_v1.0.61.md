# Amaley Core v1.0.61 — SHG Archive CSS Cleanup + Full Section Control Pass

## Purpose

v1.0.61 cleans the SHG Archive styling after multiple rapid test patches. The goal is to stop patch stacking, keep the approved dark chocolate hero, keep mobile 2 + 2 stats, make motion smooth, and let Elementor controls work reliably.

## What changed

- Replaced the stacked SHG Archive CSS file with one clean scoped stylesheet.
- Reduced `!important` usage to avoid blocking Elementor controls.
- Kept motion subtle and controllable.
- Kept image, card, detail, tag, button and responsive behaviour stable.
- Preserved SHG Archive Gallery base.

## What did not change

- No SHG Single change.
- No WooCommerce change.
- No header/footer change.
- No Discovery Engine change.
- No routing/permalink change.

## Test checklist

1. Open SHG Groups Archive in Elementor.
2. Check Hero stats on phone show 2 + 2.
3. Check Grid card columns and image height controls.
4. Check alignment controls in Hero, Trust Strip, Intro, Grid, Gallery and CTA.
5. Check motion controls can make movement none/soft/visible.
6. Check frontend mobile width does not overflow.
