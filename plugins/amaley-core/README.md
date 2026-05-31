# Amaley Core v1.0.7 Test Build

Installable WordPress test plugin ZIP.

Changes:
- Keeps Cluster Cards Grid and SHG Group Cards Grid.
- Restores full Import CSV form with dry-run preview mode.
- Import order: Clusters → SHG Groups → Members / Producers → Product Origin Mapping.

Shortcodes:
- [amaley_cluster_cards]
- [amaley_shg_cards]


## Frontend shortcodes
- [amaley_cluster_cards]
- [amaley_shg_cards]
- [amaley_member_cards]


### Product Origin Panel quick examples

Use on a normal Elementor page when you know the WooCommerce product name:

```text
[amaley_product_origin_panel product_name="Amaley Ladakh Apricot Jam"]
```

Use on a product template or single product page:

```text
[amaley_product_origin_panel]
```

Use direct ID/SKU/slug when needed:

```text
[amaley_product_origin_panel product_id="1234"]
[amaley_product_origin_panel product_sku="ACTUAL-SKU"]
[amaley_product_origin_panel product_slug="product-slug"]
```


## v1.0.24

Cluster Archive hero redesigned into a distinct directory/browse hero, separate from Cluster Single hero.
