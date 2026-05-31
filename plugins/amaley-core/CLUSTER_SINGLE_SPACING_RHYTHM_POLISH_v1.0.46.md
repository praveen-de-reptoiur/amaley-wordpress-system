# Amaley Core v1.0.46 — Cluster Single Spacing Rhythm Polish

## Purpose

The Cluster Single page is built from separate Elementor section widgets. This is the correct locked architecture, but the default vertical spacing made the page feel like disconnected pieces.

This version tightens the visual rhythm while keeping all section widgets separate.

## What changed

- Reduced default top/bottom padding for Cluster Single sections.
- Tightened Hero → Quick Details → Story → Women Collectives → Producers → Products → Gallery → Contact/CTA rhythm.
- Reduced heading and card grid gaps.
- Added scoped Elementor widget-wrapper rhythm rules for stacked Cluster Single widgets.
- Added responsive desktop/tablet/mobile spacing defaults.

## What did not change

- No WooCommerce change.
- No header/footer change.
- No permalink or route change.
- No relation/meta change.
- No product mapping change.
- No all-in-one widget conversion.

## Preserved locks

- v1.0.41 explicit relation key remains preserved: `_amaley_cluster_linked_group_ids`.
- v1.0.45 rich editor Full Story direction remains preserved.
- Separate section widgets remain the final editing workflow.

## Test checklist

1. Open the Cluster Detail page on desktop.
2. Check that Quick Details, Story, Women Collectives, Producers and Products feel connected.
3. Open tablet/mobile widths and confirm there is no excessive gap.
4. Confirm the Cluster Full Story rich text still renders.
5. Confirm Women Collectives and Producers still show from linked SHG/Producer Groups.
6. Confirm WooCommerce product links still open normally.
