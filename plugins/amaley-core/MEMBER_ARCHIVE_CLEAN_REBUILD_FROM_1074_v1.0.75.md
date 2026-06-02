# Amaley Core v1.0.75 — Member / Producer Archive Clean Rebuild

Status: test package only.
Baseline: v1.0.74.

## Scope
- Added clean Member / Producer Archive Elementor section widgets.
- Did not use failed post-v1.0.74 experiments.
- Did not change existing Cluster, SHG, Product card locks.
- Did not touch admin metaboxes, rich text/gallery fields, product origin mapping, SHG Single, SHG Archive, Cluster Archive or Cluster Single rendering.

## Widgets added
1. Amaley Member Archive Hero
2. Amaley Member Archive Trust Strip
3. Amaley Member Archive Intro
4. Amaley Member Archive Grid
5. Amaley Member Archive Gallery
6. Amaley Member Archive CTA

## Control rule followed
Each widget only exposes controls for elements that exist inside that widget.
Every visible element has practical content, layout, style, spacing/responsive or animation controls.

## Design rule followed
Member / Producer Archive follows SHG Archive visual rhythm and spacing, with scoped CSS only.
