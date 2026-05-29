# Performance and Asset Loading — v0.6.1

Status: Active from Amaley UI Sections Kit v0.6.1.

## Purpose

v0.6.1 is a performance cleanup release. It adds no new visual widget and does not redesign Home Hero V6, Page Trust Strip or Pages Hero Other.

## What changed

Before v0.6.1, the plugin registered and loaded base CSS, Home Hero CSS, Pages Hero CSS and Home Hero counter JS on the frontend together. This was still light, but would become risky as more widgets are added.

From v0.6.1:

- Assets are registered first.
- Assets are enqueued only when current page content or Elementor data shows that the relevant shortcode/widget is present.
- Elementor editor/preview loads all assets so editing does not break.
- Elementor widgets declare style/script dependencies through `get_style_depends()` and `get_script_depends()`.

## Asset groups

| Handle | File | Loads when |
|---|---|---|
| `amaley-ui-sections-kit` | `assets/css/amaley-ui-sections-kit.css` | Any Amaley UI shortcode/widget is detected |
| `amaley-ui-home-hero-v6` | `assets/css/amaley-ui-home-hero-v6.css` | Home Hero V6 is detected |
| `amaley-ui-home-hero-v6-js` | `assets/js/amaley-ui-home-hero-v6.js` | Home Hero V6 is detected |
| `amaley-ui-pages-hero-other` | `assets/css/amaley-ui-pages-hero-other.css` | Pages Hero Other is detected |

## Detection sources

The plugin checks:

- Current post content.
- `_elementor_data` post meta for Elementor widget machine names and shortcode strings.
- Elementor editor/preview state.

## Developer override

For rare dynamic builder cases where markup is generated after normal detection, force asset handles like this:

```php
add_filter( 'amaley_ui_sections_kit_force_asset_handles', function( $handles ) {
    $handles[] = 'amaley-ui-pages-hero-other';
    return $handles;
} );
```

Allowed handles:

- `amaley-ui-sections-kit`
- `amaley-ui-home-hero-v6`
- `amaley-ui-home-hero-v6-js`
- `amaley-ui-pages-hero-other`

## Safety

- No Discovery Engine change.
- No Amaley Core change.
- No Amaley Templates change.
- No Site Shell change.
- No WooCommerce cart/checkout change.
- No accepted visual output redesign.

## Testing checklist

1. A normal page without Amaley UI widgets should not load Home Hero or Pages Hero CSS.
2. Home page with Home Hero V6 should load base CSS, Home Hero CSS and Home Hero JS.
3. Inner page with Pages Hero Other should load base CSS and Pages Hero CSS only.
4. Elementor editor/preview should show widgets correctly.
5. Existing final Home Hero V6 and Pages Hero Other visuals should remain unchanged.
