# SHG Single Copy + Gallery Polish — v1.0.64

Status: Test plugin update.

## Scope

- Fix SHG Single template preview copy confusion.
- Preserve v1.0.63 Elementor preview fallback.
- Keep archive v1.0.61 stable state untouched.

## Changes

- Product widget now uses product-specific default heading/copy.
- Member widget now uses member-specific default heading/copy.
- Generic saved/default labels like `Connected Network` / `Linked items` are normalised at render time for members/products.
- Gallery URL parser now extracts real URLs even when the field contains label + URL text on one line.
- Product card pattern remains preserved for later Discovery Engine alignment.

## Not touched

- WooCommerce cart/checkout.
- Header/footer.
- Discovery Engine.
- SHG Archive CSS cleanup from v1.0.61.
- Plugin routes/permalinks.
