# Testing Checklist — Amaley UI Sections Kit v0.3.7

## Activation

- Upload ZIP on staging/local first.
- Activate without PHP fatal error.
- Confirm plugin version shows 0.3.7.
- Confirm existing product grid shortcode still renders.

## Page Trust Strip

Shortcode:

[amaley_page_trust_strip tone="cream" style="cards" columns="4" mobile="stack" motion="glow" width="contained"]

Check:

- Desktop strip appears below hero/header area.
- Desktop left dark copy block is readable.
- Desktop 4 trust cards align cleanly.
- Desktop has no horizontal overflow.
- Phone 360/390/430 cards stack vertically.
- Phone has no horizontal slider or scrollbar.
- Phone icon, title and text remain readable.
- Tablet layout does not break.

## Elementor Widget

- Search Elementor widgets for Page Trust Strip.
- Confirm widget title: Amaley Page Trust Strip.
- Confirm category: Amaley UI.
- Confirm controls: Tone, Style, Width, Columns, Mobile Behaviour, Transformation.
- Confirm default mobile behaviour is Responsive Stacked Cards.

## Conflict Safety

- Discovery Engine filters still work.
- Amaley Templates product trust strip stays separate.
- Site Shell header and footer remain unchanged.
- WooCommerce product pages, cart and checkout remain unchanged.
- No global styling leak into theme buttons, cards or forms.

## Final Lock

- Desktop screenshot saved.
- Mobile screenshot saved.
- Drive archive uploaded.
- GitHub source synced without ZIP files.
