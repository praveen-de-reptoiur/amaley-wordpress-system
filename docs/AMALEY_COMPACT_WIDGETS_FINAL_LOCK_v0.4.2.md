# Amaley Compact Widgets — Final Lock v0.4.2

Status: Final accepted lock  
Owner: Praveen  
Date: 2026-05-30  
Plugin: Amaley Compact Widgets  
Locked version: v0.4.2

## Final acceptance

Praveen confirmed that Amaley Compact Widgets v0.4.2 is accepted and locked after the focused polish of the weak sections.

Final user confirmation: "ok locked it ye theek h"

## Accepted build

- Plugin Name: Amaley Compact Widgets
- Version: 0.4.2
- Author: Praveen
- CSS scope: `.amaley-cw4-*`
- PHP prefix: `Amaley_CW_`
- Elementor category: `Amaley Compact`
- Frontend JavaScript: none
- External libraries: none

## Locked shortcodes

```text
[amaley_cw_info_cards]
[amaley_cw_split_editorial]
[amaley_cw_traceability]
[amaley_cw_gifting_band]
[amaley_cw_value_strip]
[amaley_cw_process_steps]
[amaley_cw_origin_cards]
[amaley_cw_purpose_cards]
[amaley_cw_collection_cards]
[amaley_cw_two_panel_info]
[amaley_cw_dark_chain]
[amaley_cw_image_flip_cards]
[amaley_cw_image_cards]
[amaley_cw_image_info_cards]
[amaley_cw_image_overlay_cards]
[amaley_cw_quote_cards]
[amaley_cw_cta_tiles]
[amaley_cw_metric_tiles]
```

## Widgets included

1. Amaley Info Cards Grid
2. Amaley Split Editorial Section
3. Amaley Traceability Journey
4. Amaley Gifting / Bulk Band
5. Amaley Feature / Value Strip
6. Amaley Process Steps
7. Amaley Origin Story Cards
8. Amaley Purpose Cards
9. Amaley Collection Cards
10. Amaley Two Panel Info
11. Amaley Dark Chain Cards
12. Amaley Image Flip Cards
13. Amaley Image Cards
14. Amaley Image Info Cards
15. Amaley Image Overlay Cards
16. Amaley Quote Cards
17. Amaley CTA Tiles
18. Amaley Metric Tiles

## Final focused polish

The following sections were specifically reviewed and polished after user feedback:

- OUR STORY
- TRACEABILITY
- GIFTING
- OUR VALUES
- FOR WHOM

The v0.4.1 accepted visual layout was preserved. v0.4.2 added final professional polish and alignment controls without redesigning the accepted layout.

## Alignment controls added

The v0.4.2 final build includes alignment controls:

- Overall Content Alignment
- Header Alignment
- Card / Item Text Alignment
- Button Row Alignment

Additional existing controls retained:

- Columns
- Item Gap
- Section Background
- Section Padding
- Inner Max Width
- Heading Typography
- Body Typography
- Card Background
- Card Border
- Card Radius
- Card Padding
- Card Shadow
- Image Height
- Image Radius
- Image Shadow
- Button Typography
- Button Color
- Button Radius

## Conflict rules

This plugin must remain a generic compact visual widgets plugin.

It must not own or modify:

- WooCommerce cart/checkout
- Amaley Discovery Engine filters/search/sort/pagination
- Amaley Core CPT logic
- Amaley Templates product/shop templates
- Amaley Site Shell header/footer/mobile drawer
- Product-origin data mapping
- Cluster/SHG/member CPT data logic

## GitHub cleanliness rule

Do not commit ZIP files, screenshots, videos, media dumps, backups, `.wpress` files, passwords, or `wp-config` files to GitHub.

GitHub should contain source code and documentation only. Plugin ZIPs and visual preview images belong in Drive/project archive, not in this repository.

## Future change rule

Do not casually patch this plugin after v0.4.2. Any future change must follow this sequence:

1. Identify exact widget/section to change.
2. Confirm it does not belong to Core, Discovery, Templates, or Site Shell.
3. Update only the affected widget/renderer/CSS.
4. Produce desktop and mobile preview before asking for install/testing.
5. Run PHP lint and ZIP structure checks.
6. Keep GitHub source-only.
