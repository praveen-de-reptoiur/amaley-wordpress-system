# Amaley Core v1.0.49 — SHG Archive Grid Query Fix

## Purpose

The SHG Archive widgets were registering correctly after v1.0.48, but the SHG Archive Grid still showed `No SHG groups found yet` even when SHG Group records existed.

## Root cause

The grid default `Order By` value was `menu_order`, but the query converted that into a meta query order using `_amaley_display_order`. Existing SHG Group records did not have this meta key, so WordPress excluded them from the result set.

## What changed

- `menu_order` now uses native `menu_order title` ordering.
- The grid no longer requires `_amaley_display_order` meta for normal archive display.
- SHG Archive Grid default `Show Only Website` is now off for safer first setup/testing.

## What did not change

- No WooCommerce checkout/cart change.
- No header/footer change.
- No permalink or route change.
- No Discovery Engine change.
- No Cluster/SHG relation data change.

## Test checklist

1. Activate Amaley Core v1.0.49.
2. Open the SHG Groups archive page in Elementor.
3. Keep SHG Archive Grid `Show Only Website` set to No.
4. Keep `Order By` as `menu_order`.
5. Confirm SHG Group cards appear instead of the empty message.
