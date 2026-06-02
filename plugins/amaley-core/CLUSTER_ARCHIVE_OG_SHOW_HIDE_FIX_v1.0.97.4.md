# Cluster Archive OG Show/Hide Fix v1.0.97.4

## Issue
In the lightweight Cluster Archive OG card patch, the show/hide controls were present but could appear not to work, especially in Elementor preview.

## Fix
- Added stronger show/hide value handling for OG Cluster Card 1.
- Supports Elementor switcher values like `1`, `yes`, `true`, `on`, and boolean values.
- Removed non-live render blocking from the lightweight Card Template / Elements controls so the preview can refresh when show/hide is changed.

## Controls fixed
- Show Image / Fallback Initial
- Show Label / Region
- Show Description / Village Text
- Show Product Tags / Chips
- Show Meta / Stat Boxes
- Show Button
- OG Description Word Limit

## Still lightweight
- No OG full controls
- No transform/motion controls
- No archive JS/AJAX
- No pagination changes
- No changes to Single Cluster, Single SHG, Single Member, Discovery Engine, WooCommerce, header/footer
