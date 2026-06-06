# Amaley Core v1.0.99.5 — OG Product Price Stack Fix

## Status
Accepted on live site after testing.

## Scope
This update merges the tested OG product card price layout fix into Amaley Core.

## What changed
- Plugin version updated from `1.0.99.4` to `1.0.99.5`.
- Product card price styling added to `assets/amaley-core-cards.css`.
- Old price is stacked above the sale price.
- Old price remains smaller and struck through.
- Sale price remains bold and readable.

## What was not changed
- Product data was not changed.
- Product images/gallery were not changed.
- Product-origin mappings were not changed.
- Discovery Engine was not changed.
- Filters, pagination, sort and reset were not changed.
- Header/footer were not changed.
- WooCommerce templates were not changed.

## Accepted working setup
- Amaley Core: `v1.0.99.5`
- Amaley Discovery Engine: `v1.4.4`
- Discovery Engine `v1.4.5` should not be used for this price fix.
- The temporary helper plugin `Amaley Core OG Product Price Stack Fix` can remain deactivated after confirming Core v1.0.99.5 is active.
