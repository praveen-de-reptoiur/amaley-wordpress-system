# Build Notes — Amaley UI Sections Kit v0.2.5

## Build Scope

v0.2.5 adds lightweight WooCommerce product display shortcodes:

- `[amaley_product_card]`
- `[amaley_product_grid]`

## Boundaries

This build does not add filters, search, sorting, pagination, Elementor widgets, JavaScript, origin data, SHG data, database tables, cart changes or checkout changes.

## Performance Notes

- Product grids are capped at 8 products.
- Category grid uses `posts_per_page` with `no_found_rows`.
- ID/SKU grids render only explicitly selected products.
- No unlimited product query is allowed.

## Commit Message

```text
Build Amaley UI Sections Kit v0.2.5 product display components
```


## v0.2.5 visual rebuild note

This release rebuilds only the product card visual layer: compact premium e-commerce card proportions, media badge overlay, cleaner title typography, stable image area, full-width CTA, and better grid rhythm. It does not change WooCommerce query logic, product data, cart, checkout, filters, search, sorting, JavaScript, database, CPTs, SHG/origin data, or Elementor widgets.

Commit message:

```text
Rebuild product card visual design in v0.2.5
```


## v0.2.5 layout fix
Fixed uneven product card top alignment by forcing equal grid media height. Commit message: `Fix product grid card alignment in v0.2.5`.


## v0.3.1 — Trust Strip Elementor Widget

- Added renderer: `includes/renderers/class-amaley-ui-trust-strip.php`.
- Added Elementor loader: `includes/elementor/class-amaley-ui-elementor-loader.php`.
- Added Elementor widget: `includes/elementor/widgets/class-amaley-elementor-trust-strip-widget.php`.
- Added shortcode: `[amaley_trust_strip]`.
- Kept Discovery Engine untouched.
- Kept all CSS scoped under `.amaley-ui-trust-strip-*`.


## v0.3.2 — Trust Strip Static Premium Polish

- Made `Transformation: Gold glow` visibly premium in static state, not only on hover.
- Added deeper background, gold accent rim, raised item cards, stronger icon circles, and intro depth.
- No JavaScript added.
- No Discovery Engine, WooCommerce cart/checkout, product query, or global CSS changes.

## v0.3.3 — Page Trust Strip Naming Cleanup

- Renamed Elementor widget user-facing label to `Amaley Page Trust Strip`.
- Changed Elementor widget machine name to `amaley_ui_page_trust_strip`.
- Added primary shortcode `[amaley_page_trust_strip]`.
- Kept old `[amaley_trust_strip]` alias for backwards compatibility only.
- Reason: avoid confusion with Amaley Templates Product Trust Strip (`amaley_tpl_trust_strip`).
- No Discovery Engine, Amaley Templates, WooCommerce cart/checkout, product grid or data-layer changes.


## v0.3.5 — Page Trust Strip Shortcode Alias Fix
- Fixed shortcode issue where `transformation="gold-glow"` was ignored because the renderer expected `motion="glow"`.
- Kept `motion` as the internal developer attribute and added `transformation` as a human-friendly shortcode alias.
- Set Page Trust Strip default motion to `glow` for a stronger static hero-below appearance.

## v0.3.7 — Page Trust Strip Copy + Alignment Polish
- Changed default intro copy to `Rooted in taste, trust & traceability.`
- Added desktop grid override to give the dark intro block more breathing room.
- Kept `[amaley_page_trust_strip]` primary and `[amaley_trust_strip]` alias unchanged.
- No cross-plugin changes.
