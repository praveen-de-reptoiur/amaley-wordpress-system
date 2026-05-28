# Testing Checklist — Amaley UI Sections Kit v0.2.5

## Activation

- [ ] Upload ZIP on staging/local first
- [ ] Activate plugin without fatal error
- [ ] Confirm no PHP warnings/notices in debug mode
- [ ] Confirm plugin can deactivate cleanly

## Foundation Shortcode Rendering

- [ ] `[amaley_section_heading]` renders heading, label, accent and description
- [ ] `[amaley_button]` renders primary, secondary, outline, text and pill variants
- [ ] `[amaley_button_group]` stacks correctly on mobile
- [ ] `[amaley_trust_item]` renders icons without external library
- [ ] `[amaley_brand_promise]` renders items without overflow
- [ ] `[amaley_cta_band]` renders dark and warm tones
- [ ] `[amaley_empty_state]` renders safely with missing fields

## Product Shortcode Rendering

- [ ] `[amaley_product_card id="REAL_ID"]` renders image, title, price and view button
- [ ] `[amaley_product_card sku="REAL_SKU"]` renders the correct product
- [ ] `[amaley_product_grid ids="REAL_ID_1,REAL_ID_2"]` renders selected products only
- [ ] `[amaley_product_grid skus="REAL_SKU_1,REAL_SKU_2"]` renders selected products only
- [ ] `[amaley_product_grid category="REAL_CATEGORY_SLUG" limit="4"]` renders category products only
- [ ] Missing product ID shows safe message
- [ ] Wrong category slug shows safe message
- [ ] WooCommerce inactive shows safe message and no fatal error

## Product Safety

- [ ] Grid does not query unlimited products
- [ ] Grid limit is capped at 8
- [ ] Product card does not display fake origin/SHG/producer data
- [ ] Product card does not override WooCommerce templates
- [ ] Cart and checkout remain unaffected
- [ ] Existing WooCommerce product cards remain unaffected

## Responsiveness

Test widths:

- [ ] 360px
- [ ] 390px
- [ ] 430px
- [ ] 768px
- [ ] 1024px
- [ ] 1366px

## Conflict Safety

- [ ] No global body styling changed
- [ ] No Elementor widget styling changed
- [ ] No WooCommerce product/card styling changed
- [ ] No Freshen theme header/footer styling changed
- [ ] No horizontal overflow on mobile
- [ ] No frontend JavaScript loaded by this plugin

## Visual Checks

- [ ] Buttons have minimum 44px touch target
- [ ] Headings are not oversized on mobile
- [ ] CTA band remains readable
- [ ] Brand promise strip remains clean on mobile
- [ ] Empty state looks intentional, not broken
- [ ] Product card image ratio remains stable
- [ ] Product grid has even card spacing
- [ ] Product title, price and buttons remain readable on mobile

## Product Card Polish Checks

- [ ] Single product card is compact and does not stretch into a hero banner
- [ ] Four-product grid keeps even card rhythm
- [ ] Product title does not create uncontrolled tall cards
- [ ] Product image ratio remains stable across all cards
- [ ] Product button stays visually aligned across cards
- [ ] Grid has breathing space before the next section/footer
