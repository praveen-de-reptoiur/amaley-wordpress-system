# Member Single Full Elementor Controls v1.0.78.7

## Purpose
This is a controls-only patch on top of the accepted v1.0.78.6 Member Single related-grid layout.

## What changed
- Rebuilt all 8 Member Single Elementor widgets with section-wise controls:
  - Hero
  - Snapshot
  - Story
  - Linked SHG
  - Linked Cluster
  - Products
  - Gallery
  - Contact CTA
- Each widget now has structured Elementor panels:
  - Data / Preview Source
  - Content / Show-Hide
  - Section: Background & Layout
  - Section Head: Label / Heading / Description
  - Buttons / CTA Buttons
  - Fallback / Empty Message
  - Section-specific panels such as Hero Image/Tags, Snapshot Stat Boxes, Story Card/Tags, Related Cards, Product Cards, Gallery, and CTA Card.
- Added safe show/hide hooks for existing elements only:
  - Hero tags/chips
  - Snapshot individual stat boxes
  - Related card media/badge/label/excerpt/meta/button
  - Product image/label/meta/chips/button/fallback tags
- Added Elementor selector-based controls for:
  - typography
  - colors
  - background
  - padding
  - width
  - border
  - radius
  - shadow
  - grid gaps/columns
  - image/media height
  - stat boxes
  - tags/chips
  - buttons
  - gallery captions
  - fallback messages

## Scope safety
- No layout redesign beyond enabling controls.
- No change to WooCommerce, cart, checkout, header/footer, admin schema, archive pages, SHG Single, or Cluster Single.
- CSS remains scoped through Elementor `{{WRAPPER}}` selectors and existing `.amms-*` Member Single classes.
- Base frontend CSS is not replaced; controls override only when values are changed in Elementor.
