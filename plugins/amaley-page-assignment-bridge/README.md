# Amaley Page Assignment Bridge

Separate, safe bridge plugin for assigning a normal Elementor page as the WooCommerce single product layout without editing Amaley Core, Amaley Templates, Amaley Discovery Engine, product data, cart, checkout, header, or footer.

## Current locked source

```text
v1.4.1 — Single Product Final / Member Value Controls Fix
```

## Status

```text
Final tested on All Products
```

## Main purpose

```text
WooCommerce single product URL
→ assigned Elementor page
→ current product context passed into Bridge Elementor widgets
→ custom Amaley single product layout rendered safely
```

## Final Elementor page widget order

Use these widgets on the assigned Elementor page:

```text
1. Amaley Bridge Product Hero
2. Amaley Bridge Trust Strip
3. Amaley Bridge Info Tabs
4. Amaley Bridge Member Value Strip
```

The separate Origin Panel widget may remain available, but the accepted final single product layout uses the Origin tab inside Info Tabs instead.

## Current accepted behaviour

- Product Hero renders product image/gallery, title, price, short description, badges, add-to-cart, buy-now, wishlist placeholder, and compact product meta.
- Trust Strip renders trust/value items below the hero.
- Info Tabs renders Details, Origin, How To Use, and Reviews.
- Origin data is displayed inside the Info Tabs Origin tab using product-origin mapping.
- Member Value Strip uses editable Elementor repeater tiles for add/remove/reorder.
- Editor preview context works for the assigned Elementor page.
- All Products rollout has been tested by Praveen.

## Admin assignment

```text
Amaley Bridge → Single Product Assignment
Enable Single Product Bridge: All Products
Assigned Elementor Page: Amaley Single Product
Preview Product Context on Assigned Page: Yes
```

## Safety scope

```text
No product data changes.
No product image/gallery changes.
No origin mapping changes.
No WooCommerce cart/checkout/order logic changes.
No Amaley Core source changes.
No Amaley Templates source changes.
No Amaley Discovery Engine source changes.
No header/footer source changes.
```

## Rollback

Set:

```text
Enable Single Product Bridge: Off
```

or deactivate this plugin. Default WooCommerce single product pages return immediately.

## Notes

- Keep Elementor Atomic Editor inactive.
- Do not upload plugin ZIP files into GitHub.
- Use GitHub for clean source only; ZIP backups belong in Drive/local backup.
- Do not update this plugin source without explicit approval from Praveen.
