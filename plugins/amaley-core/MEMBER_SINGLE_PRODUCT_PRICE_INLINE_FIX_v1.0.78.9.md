# Member Single Product Price Inline Fix v1.0.78.9

## Purpose
Product card price was showing the currency symbol and amount on separate lines in the Member Single Products widget.

## What changed
- Added a scoped `amms-product-price` class to the product card price value.
- Added scoped CSS to force WooCommerce price amount, currency symbol and `bdi` markup to remain inline.
- Kept the fix limited to `.amms-products .amms-product-meta` only.

## Scope safety
- Member Single Products visual fix only.
- No WooCommerce price logic change.
- No cart/checkout/product page change.
- No header/footer, admin schema, archive, SHG Single or Cluster Single changes.
