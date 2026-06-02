# SHG Archive OG Controls Selector Fix v1.0.98.1

## Issue
In v1.0.98, the SHG Archive OG card selector was added, but several existing Elementor style controls were mapped through weak or duplicated selectors. The controls could appear in the Elementor panel but not visibly affect OG SHG Card 1.

## Fix
Existing controls were remapped to stronger, scoped OG selectors:

`{{WRAPPER}} .amaley-core-shg-grid-section-og .amaley-card--shg-archive ...`

Most visual declarations now use `!important` where needed to override the fixed universal card CSS.

## Controls covered
- Card Background
- Card Border Color
- Card Radius
- Card Body Padding
- Card Inner Gap
- Image / Placeholder Height
- Image Opacity
- Placeholder Circle Size
- Placeholder Background
- Verified Badge Background/Text Color
- Card Label Typography/Color
- Card Title Typography/Color
- Description Typography/Color/Line Clamp
- Details Gap/Box Padding/Box Background/Border/Label Color/Value Color/Line Clamp
- Tag Gap/Padding/Background/Text Color/Border Color
- Button Padding/Radius/Background/Text Color/Hover Background/Hover Text Color

## Still lightweight
- No new controls
- No heavy OG full controls
- No transform controls
- No new archive JS/AJAX
- No pagination changes
