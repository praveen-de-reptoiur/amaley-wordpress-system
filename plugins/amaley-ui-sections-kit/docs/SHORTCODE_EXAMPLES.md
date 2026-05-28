# Shortcode Examples — Amaley UI Sections Kit v0.2.5

## Foundation Test

```text
[amaley_section_heading label="Amaley Promise" title="Food with identity and care" accent="care" description="Premium Himalayan products rooted in natural ingredients, small-batch production and community-rooted sourcing."]

[amaley_button_group primary_text="Explore products" primary_url="/shop/" secondary_text="Partner with Amaley" secondary_url="/contact/"]

[amaley_trust_item icon="leaf" title="Natural Himalayan ingredients" text="Made around seasonal produce, careful sourcing and clean product thinking."]

[amaley_brand_promise label="Amaley Promise" title="Rooted in Himalayan ingredients and careful production." items="Small-batch|Community-rooted|Quality checked|Natural ingredients"]

[amaley_cta_band label="For partners" title="Bring Amaley to your customers." text="For retail, hospitality, gifting and institutional partnerships." primary_text="Enquire now" primary_url="/contact/" secondary_text="View products" secondary_url="/shop/"]

[amaley_empty_state title="Products coming soon" text="This section is ready, but verified Amaley content has not been added yet."]
```

## Product Card Test

Replace `123` with a real WooCommerce product ID.

```text
[amaley_product_card id="123"]
```

With optional excerpt and cart button:

```text
[amaley_product_card id="123" show_excerpt="yes" show_cart="yes" badge="Small-batch"]
```

Using SKU:

```text
[amaley_product_card sku="AMALEY-001"]
```

## Product Grid Test

Replace IDs with real WooCommerce product IDs.

```text
[amaley_product_grid ids="123,124,125,126" columns="4" limit="4"]
```

Using SKUs:

```text
[amaley_product_grid skus="AMALEY-001,AMALEY-002,AMALEY-003" columns="3" limit="3"]
```

Using category slug:

```text
[amaley_product_grid category="cookies" columns="4" limit="4"]
```

## Product Display Notes

- `limit` is capped at 8.
- No filters, search, sorting or pagination are included.
- Product data comes only from WooCommerce.
- Do not add fake origin, SHG, cluster or producer details.
