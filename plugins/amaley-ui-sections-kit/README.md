# Amaley UI Sections Kit

Version: 0.2.5  
Status: Phase 1 foundation + Phase 2 product display MVP.

## Purpose

Amaley UI Sections Kit is a lightweight WordPress-native UI foundation for Amaley. It provides reusable, scoped shortcodes for headings, buttons, trust items, brand promise strips, CTA bands, safe empty states, product cards and curated product grids.

This plugin is intentionally small. It must not become a product discovery engine, Elementor widget kit, WooCommerce replacement, header/footer system, origin database, SHG data manager, or cart/checkout replacement.

## Includes

- Design tokens
- Section container renderer
- Section heading shortcode
- Button shortcode
- Button group shortcode
- Trust mini item shortcode
- Brand promise strip shortcode
- CTA band shortcode
- Safe empty state shortcode
- WooCommerce product card shortcode
- WooCommerce curated product grid shortcode

## Does Not Include

- Product filters
- Product search
- Sorting UI
- Pagination
- Origin blocks
- SHG / women collective cards
- Producer / maker cards
- Elementor widgets
- Header
- Footer
- Mobile drawer
- Cart / checkout replacement
- CPT creation
- ACF replacement
- Database tables

## Shortcodes

```text
[amaley_section_heading label="Small-batch Himalayan foods" title="Food with identity and care" accent="care" description="Premium sections for Amaley pages."]

[amaley_button text="Explore products" url="/shop/" variant="primary" align="left"]

[amaley_button_group primary_text="Explore products" primary_url="/shop/" secondary_text="Partner with Amaley" secondary_url="/contact/"]

[amaley_trust_item icon="leaf" title="Natural ingredients" text="Built around seasonal Himalayan produce and careful sourcing."]

[amaley_brand_promise label="Amaley Promise" title="Rooted in Himalayan ingredients and careful production." items="Small-batch|Community-rooted|Quality checked"]

[amaley_cta_band label="For partners" title="Bring Amaley to your customers." text="For retail, hospitality and institutional partnerships." primary_text="Enquire now" primary_url="/contact/" secondary_text="View products" secondary_url="/shop/"]

[amaley_empty_state title="Products coming soon" text="This section is ready, but content has not been added yet."]

[amaley_product_card id="123"]

[amaley_product_card sku="AMALEY-001" show_excerpt="yes" show_cart="no"]

[amaley_product_grid ids="123,124,125,126" columns="4" limit="4"]

[amaley_product_grid skus="AMALEY-001,AMALEY-002,AMALEY-003" columns="3" limit="3"]

[amaley_product_grid category="cookies" columns="4" limit="4"]
```

## Product Display Safety

- WooCommerce must remain the commerce engine.
- Product grid has a maximum limit of 8 products.
- Product grid does not run unlimited product queries.
- Product grid does not add filters, sorting, search or pagination.
- Product card uses published WooCommerce product data only.
- No fake origin, SHG, cluster or producer data is displayed.
- If WooCommerce is inactive, product shortcodes show a safe message instead of a fatal error.

## Safety

- Scoped CSS only: `.amaley-ui-*`
- No global body/h/p/a/button styling
- No Elementor dependency
- No frontend JavaScript
- No database writes
- No WooCommerce writes
- Deactivation removes all frontend rendering except shortcode text left in content

## Installation for Testing

1. Upload the plugin ZIP through WordPress Plugins > Add New > Upload Plugin.
2. Activate on staging or local test site first.
3. Create a private test page.
4. Paste shortcodes from `docs/SHORTCODE_EXAMPLES.md`.
5. Check mobile widths: 360, 390, 430, 768, 1024, 1366.

Do not install directly on the live Amaley site without backup.

## Product Display Shortcodes

```text
[amaley_product_card id="8361"]
[amaley_product_grid ids="8361,8362,8359,8363" columns="4" limit="4"]
```

Product cards are WooCommerce display components only. They do not replace cart, checkout, search, filters, sorting, origin mapping or product data.
