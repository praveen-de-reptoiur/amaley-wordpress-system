# SHG Single Template Preview Fallback - v1.0.63

Purpose: allow the SHG Detail Elementor template page to show real SHG data while editing/previewing even when the WordPress preview URL does not contain `shg_slug` or `shg_id`.

## Behaviour

- Live SHG detail URLs still read `shg_slug` / `shg_id` from the URL.
- Elementor editor and WordPress preview URLs without SHG parameters automatically fall back to the first available SHG group.
- Widget-level Preview SHG ID / Fixed SHG Slug controls remain available when a specific SHG group is needed for editing.

## Safety

- No archive CSS change.
- No WooCommerce change.
- No header/footer change.
- No Discovery Engine change.
- No permalink/rewrite change.
