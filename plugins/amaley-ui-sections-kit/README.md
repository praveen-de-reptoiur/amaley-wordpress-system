# Amaley UI Sections Kit

Version: 0.3.7  
Status: Page Trust Strip final lock + existing UI/product display foundation.

## Purpose

Amaley UI Sections Kit is a lightweight WordPress-native UI foundation for Amaley. It provides reusable, scoped shortcodes for headings, buttons, trust items, brand promise strips, CTA bands, safe empty states, product cards, curated product grids, and the page-level hero-below trust strip.

This plugin is intentionally small. It must not become a product discovery engine, WooCommerce replacement, header/footer system, origin database, SHG data manager, or cart/checkout replacement.

## Includes

- Design tokens
- Section container renderer
- Section heading shortcode
- Button shortcode
- Button group shortcode
- Trust mini item shortcode
- Page Trust Strip shortcode and Elementor widget
- Brand promise strip shortcode
- CTA band shortcode
- Safe empty state shortcode
- WooCommerce product card shortcode
- WooCommerce curated product grid shortcode

## Does Not Include

- Product filters/search/sort/pagination
- Header/footer/mobile drawer
- Cart/checkout replacement
- WooCommerce template overrides
- CPT creation
- ACF replacement
- Database tables
- Origin/SHG/member data management

## Primary Page Trust Strip Usage

```text
[amaley_page_trust_strip tone="cream" style="cards" columns="4" mobile="stack" motion="glow" width="contained"]
```

Backward-compatible alias:

```text
[amaley_trust_strip]
```

Elementor widget:

```text
Amaley UI > Amaley Page Trust Strip
```

## Product Display Shortcodes

```text
[amaley_product_card id="8361"]
[amaley_product_grid ids="8361,8362,8359,8363" columns="4" limit="4"]
```

## Existing Shortcodes

```text
[amaley_section_heading]
[amaley_button]
[amaley_button_group]
[amaley_trust_item]
[amaley_page_trust_strip]
[amaley_brand_promise]
[amaley_cta_band]
[amaley_empty_state]
[amaley_product_card]
[amaley_product_grid]
```

## Product Display Safety

- WooCommerce remains the commerce engine.
- Product grid has a maximum limit guard.
- Product grid does not add filters, sorting, search or pagination.
- Product card uses published WooCommerce product data only.
- No fake origin, SHG, cluster or producer data is displayed.
- If WooCommerce is inactive, product shortcodes show a safe message instead of a fatal error.

## Safety

- Scoped CSS only: `.amaley-ui-*`
- No global body/h/p/a/button styling
- No WooCommerce/Freshen/Apus overrides
- No frontend JavaScript for Page Trust Strip
- No database writes
- No WooCommerce writes
- No ZIP files committed to GitHub

## Testing

Test Page Trust Strip on:

- Desktop: 1366+
- Tablet: 768 / 1024
- Phone: 360 / 390 / 430

Phone must stack cards. Do not use horizontal slider for the hero-below trust strip.
