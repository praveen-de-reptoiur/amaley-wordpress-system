# Amaley UI Sections Kit

Version: 0.6.1  
Status: Performance + conditional asset loading cleanup. No visual redesign.

## Purpose

Amaley UI Sections Kit is a lightweight WordPress-native UI foundation for Amaley. It provides reusable, scoped shortcodes and Elementor widgets for generic homepage/page visual sections.



## New in v0.6.1

### Performance + Asset Loading Cleanup

This release does not add a new visual widget and does not redesign any accepted section. It changes how assets load.

- Base UI CSS loads only when Amaley UI shortcodes/widgets are detected.
- Home Hero V6 CSS and counter JS load only when Home Hero V6 is used.
- Pages Hero Other CSS loads only when Pages Hero Other is used.
- Elementor editor/preview loads all assets for safe editing.
- Elementor widgets declare their own asset dependencies.
- A force-load filter is available for rare late-rendered dynamic builder content.

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

## New in v0.6.0

### Amaley Pages Hero Other

Elementor widget:

```text
Amaley UI > Amaley Pages Hero Other
```

Shortcode:

```text
[amaley_pages_hero_other style="style-1"]
```

Fixes:

- Style numbers are visible in the Elementor dropdown.
- Image/media side can be switched left or right for image-based styles.
- Image gaps at browser zoom are fixed by no-gap media wrappers.
- Image fit/focus controls remain in Style tab.
- No Discovery Engine, Core, Templates, Site Shell or WooCommerce changes.


## New in v0.5.4

- No-gap absolute right-image mosaic lock for Home Hero V6.
- Main, top-right and bottom-right images now fill their slots without bottom/middle beige gaps.
- Image fit/focus controls remain available in Elementor Style tab.

## Previous v0.5.3

- Home Hero V6 right image collage hard-lock: images default to center center + cover.
- Added all-images fit/focus controls and per-image fit/focus controls in Elementor Style tab.
- Connected crop preset controls to rendered image classes.
- No Discovery Engine, Core, Templates, Site Shell or WooCommerce changes.

## New in v0.5.1

### Amaley Home Hero V6

This is the clean plugin conversion of the accepted live HTML widget hero.

Shortcode:

```text
[amaley_home_hero_v6]
```

Elementor widget:

```text
Amaley UI > Amaley Home Hero V6
```

The hero uses:

- Locked desktop grid: left content panel + right 3-image mosaic
- Scoped class prefix: `.amaley-home-hero-v6`
- Live counter script scoped only to `[data-amaley-home-hero-v6]`
- No external library
- No jQuery
- No WooCommerce, Elementor, Freshen, Apus or Discovery Engine overrides

## Page Trust Strip

Locked shortcode:

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
[amaley_brand_promise]
[amaley_cta_band]
[amaley_empty_state]
[amaley_product_card]
[amaley_product_grid]
```

## Safety

- GitHub source only; do not commit plugin ZIPs.
- CSS remains scoped to `.amaley-ui-*` and `.amaley-home-hero-v6`.
- Discovery Engine remains untouched.
- Amaley Core remains untouched.
- Amaley Templates remains untouched.
- Site Shell remains untouched.
- WooCommerce cart/checkout remains untouched.


## v0.5.4 Home Hero V6 style controls

The Elementor widget `Amaley UI > Amaley Home Hero V6` now includes section-wise Style tab controls:

- Section / Background
- Left Content Panel
- Label / Heading / Text
- Buttons
- Counter / Proof Row
- Image Collage / Fit Controls
- Center Medallion / Badge

Image fit controls include per-image fit mode and horizontal/vertical focal sliders, so product and producer images can be adjusted inside the fixed live-style mosaic without changing the code.


## Pages Hero Other v0.5.7

Adds 8 selectable inner-page hero styles under `Amaley UI > Amaley Pages Hero Other`, including Style 7 Premium Editorial Ribbon and Style 8 Centered Statement / Minimal.

Shortcode examples:

```text
[amaley_pages_hero_other style="style-7"]
[amaley_pages_hero_other style="style-8"]
```


## v0.5.9 note

Pages Hero Other controls audit: typography controls, image fit/focus/radius/border/shadow controls, and style-specific control visibility improved. Home Hero V6 and Page Trust Strip remain untouched.


## v0.5.9 Pages Hero Other

- Removed Style 4 Journal / Image Split.
- Removed the bottom feature strip from Style 2.
- Added Style 9, Style 10 and Style 11 as distinct premium editorial image variations inspired by Style 7.
- Added Style 12 and Style 13 as centered statement variations inspired by Style 8.
- Kept controls style-specific so unrelated style controls stay hidden.
- No Discovery Engine, Amaley Core, Templates, Site Shell or WooCommerce cart/checkout changes.
