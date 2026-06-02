# SHG Single Duplicate Controls Fix v1.0.93.3

## Purpose
v1.0.93.2 made OG Card full controls work, but the old/current card controls were still visible at the same time. This created duplicate controls in Elementor.

## Fix
For SHG Single card sections only:
- When Card Template = Current / Existing Card:
  - old/current card controls are visible
  - OG Card full controls are hidden
- When Card Template = OG Card 1:
  - OG Card: Full Controls is visible
  - old/current card/image/meta/button/motion sections are hidden

## Widgets affected
- Amaley SHG Single Linked Cluster
- Amaley SHG Single Members
- Amaley SHG Single Products

## What stays visible in both modes
- Data / Preview Source
- Content / Display
- Layout / Alignment
- Section Background
- Section Spacing
- Heading / Text Style

## Safety
- No frontend design change.
- No card logic change.
- No pagination added.
- Single Cluster and Single Member untouched.
- Discovery Engine, WooCommerce, header/footer untouched.
