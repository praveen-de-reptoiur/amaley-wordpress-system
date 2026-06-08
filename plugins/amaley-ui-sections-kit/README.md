# Amaley UI Sections Kit

Version: 0.6.9.3  
Status: Pages Hero Other all-variation Elementor controls completed and staging-tested. No live update yet.

## New in v0.6.9.3

- Gifting Enquiry real form embed mode now keeps Contact Form 7 / WPForms / Elementor form markup usable.
- Safe allow-list added for form, input, select, textarea, label, button, fieldset and option tags.
- Dummy form remains fillable and non-submitting for preview/testing.

## Purpose

Amaley UI Sections Kit is a lightweight WordPress-native UI foundation for Amaley. It provides reusable, scoped shortcodes and Elementor widgets for generic homepage and inner-page visual sections.

This plugin owns generic UI sections only. It must not own or replace WooCommerce templates, Amaley Core CPT/card logic, Discovery Engine filters, Amaley Templates, header/footer, product data, origin mapping, uploaded photos, cart or checkout.

## Current release — v0.6.4.1

### Pages Hero Other — all variation controls

Elementor widget:

```text
Amaley UI > Amaley Pages Hero Other
```

Shortcode:

```text
[amaley_pages_hero_other style="style-1"]
```

v0.6.4.1 completes the Elementor control system for `Amaley Pages Hero Other` across all active variations.

Covered styles:

```text
Style 1  — Story Split
Style 2  — Cluster / Traceability
Style 3  — Collections / Intent Card
Style 5  — Contact / Minimal
Style 6  — Gifting / Image Split
Style 7  — Premium Editorial Ribbon
Style 8  — Centered Statement
Style 9  — Framed Origin Editorial
Style 10 — Product Story Editorial
Style 11 — Warm Story Editorial
Style 12 — Centered Trust Board
Style 13 — Quiet Minimal Statement
```

Style 4 remains intentionally removed.

### Control system

Each selected style now shows its own relevant Elementor panels instead of confusing shared panels.

Common control families include:

- Device-wise visibility controls
- Layout and spacing controls
- Typography controls
- Button controls
- Stats / proof controls where applicable
- Image / media controls where applicable
- Editorial note card controls where applicable
- Intent card controls for Style 3
- Right text panel controls for Style 1
- Statement pill controls for Styles 8, 12 and 13

### Stats gap fix

v0.6.4.1 adds specific controls for spacing between stat value and stat label:

```text
Value and Label Gap
Label Top Spacing Fallback
```

These controls apply to stats-based styles such as Style 2, Style 3, Style 7, Style 9 and Style 11.

### Style 10 lock

Style 10 was already accepted during staging testing. v0.6.4.1 keeps Style 10 as the approved base and does not redesign it.

Style 10 includes:

- `Style 10 — Visibility (Device Wise)`
- Layout controls
- Typography controls
- Image / media controls
- Editorial note card controls
- Stats / proof controls
- Button controls

### CSS scope

Pages Hero Other CSS remains scoped under:

```text
.amaley-pages-hero-other
```

Style-specific safety CSS uses classes such as:

```text
.amaley-pages-hero-other--style-1
.amaley-pages-hero-other--style-10
```

No global CSS reset, theme override, WooCommerce override, header/footer override or Discovery filter CSS is added.

## Other active widgets / shortcodes

### Amaley Home Hero V6

Shortcode:

```text
[amaley_home_hero_v6]
```

Elementor widget:

```text
Amaley UI > Amaley Home Hero V6
```

### Amaley Page Trust Strip

Shortcode:

```text
[amaley_page_trust_strip tone="cream" style="cards" columns="4" mobile="stack" motion="glow" width="contained"]
```

Elementor widget:

```text
Amaley UI > Amaley Page Trust Strip
```

## Existing shortcodes

```text
[amaley_section_heading]
[amaley_button]
[amaley_button_group]
[amaley_trust_item]
[amaley_page_trust_strip]
[amaley_home_hero_v6]
[amaley_pages_hero_other]
[amaley_brand_promise]
[amaley_cta_band]
[amaley_empty_state]
[amaley_product_card]
[amaley_product_grid]
```

## Asset loading

The plugin keeps the v0.6.1 conditional asset-loading approach:

- Base UI CSS loads only when Amaley UI shortcodes/widgets are detected.
- Home Hero V6 CSS and counter JS load only when Home Hero V6 is used.
- Pages Hero Other CSS loads only when Pages Hero Other is used.
- Elementor editor/preview loads assets for safe editing.
- Elementor widgets declare their own asset dependencies.

Developer force-load example:

```php
add_filter( 'amaley_ui_sections_kit_force_asset_handles', function( $handles ) {
    $handles[] = 'amaley-ui-pages-hero-other';
    return $handles;
} );
```

Allowed handles:

```text
amaley-ui-sections-kit
amaley-ui-home-hero-v6
amaley-ui-home-hero-v6-js
amaley-ui-pages-hero-other
```

## Safety

- No database schema changes.
- No WooCommerce template override.
- No cart or checkout replacement.
- No product data, origin mapping or photo update.
- No Discovery Engine filter or query logic change.
- No Amaley Core CPT/card-library change.
- No Amaley Templates change.
- No header/footer change.
- No global CSS selectors added.
- GitHub source must not be updated unless explicitly approved.

## Staging checkpoint

```text
Amaley UI Sections Kit v0.6.4.1
Pages Hero Other — All Variations Controls
Staging Working + ZIP Audit Passed
```
