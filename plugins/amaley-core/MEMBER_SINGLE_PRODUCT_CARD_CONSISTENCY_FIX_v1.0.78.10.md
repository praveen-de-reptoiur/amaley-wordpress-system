# Member Single Product Card Consistency Fix v1.0.78.10

## Purpose
The Member Single product cards were not matching the accepted compact Amaley product card style shown in the reference.

## What changed
- Product label now defaults to `Product` instead of `Amaley Product`.
- Product excerpt/description is shown between title and price/origin boxes, matching the accepted card rhythm.
- Product title, image height, body spacing, price/origin boxes, chips and button rhythm were aligned with the compact product-card family.
- Price remains inline from v1.0.78.9.
- Origin text is clamped to two lines to avoid card height breaking.

## Controls added
- Product Label Text
- Show Product Description / Excerpt
- Product Description Word Limit
- Product Description typography, color and margin controls

## Scope safety
- Member Single Products only.
- No WooCommerce price logic changes.
- No product page, cart, checkout, header/footer, admin schema, SHG/Cluster sections or archive page changes.
