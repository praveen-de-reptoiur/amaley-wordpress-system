# Amaley UI Sections Kit

Version: 0.1.2  
Status: Phase 1 MVP skeleton — foundation components only.

## Purpose

Amaley UI Sections Kit is a lightweight WordPress-native UI foundation for Amaley. It provides reusable, scoped shortcodes for headings, buttons, trust items, brand promise strips, CTA bands and safe empty states.

This plugin is intentionally small. It must not become a product discovery engine, Elementor widget kit, WooCommerce replacement, header/footer system, origin database, SHG data manager, or cart/checkout replacement.

## Phase 1 MVP Includes

- Design tokens
- Section container renderer
- Section heading shortcode
- Button shortcode
- Button group shortcode
- Trust mini item shortcode
- Brand promise strip shortcode
- CTA band shortcode
- Safe empty state shortcode

## Phase 1 MVP Does Not Include

- Product cards
- Product grids
- Collection cards
- Origin blocks
- SHG / women collective cards
- Producer / maker cards
- Filters
- Search
- Sorting
- Pagination
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
```

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
