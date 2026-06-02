# Member Single Product Core Card Pilot v1.0.80

## Purpose
This version connects only the Member Single Products widget to the new Amaley Core Product Card Renderer as an optional pilot.

## Important safety
Default remains `Legacy Member Single Card`, so installing this version should not change the frontend automatically.

## Elementor control added
Inside `Amaley Member Single Products` widget:

Product Card Source:
- Legacy Member Single Card — safe current design
- Use Global Assignment from Amaley Core Settings
- Choose Manually in this Widget

Manual Product Card Preset:
- Compact Marketplace
- Origin Story
- Minimal Product
- Horizontal Product

## What changed
- Added optional bridge from Member Single Products to `Amaley_Core_Card_Renderer::render_product()`
- Global assignment uses:
  `card_product_member_single_products`
- Existing v1.0.78.10 product card remains as legacy fallback
- Product label/excerpt/show-hide controls are passed into the Core renderer

## What did not change
- No Discovery Engine connection yet
- No WooCommerce logic change
- No product page/cart/checkout change
- No SHG/Cluster/Member cards connected yet
- No header/footer change
- No global CSS
