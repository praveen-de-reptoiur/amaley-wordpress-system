# Rollback Notes — Amaley UI Sections Kit v0.2.5

## Rollback Target

If v0.2.5 causes any issue, roll back to:

```text
amaley-ui-sections-kit-v0.1.3.zip
```

## What v0.2.5 Adds

- Product card shortcode
- Product grid shortcode
- Product display CSS
- Product shortcode examples and testing documentation

## What v0.2.5 Does Not Change

- No database schema changes
- No CPT creation
- No WooCommerce template override
- No cart or checkout replacement
- No Elementor widget registration
- No JavaScript added
- No origin/SHG/producer data added

## Rollback Steps

1. Deactivate Amaley UI Sections Kit v0.2.5.
2. Delete v0.2.5 plugin from staging/local WordPress.
3. Upload `amaley-ui-sections-kit-v0.1.3.zip`.
4. Activate v0.1.3.
5. Remove or ignore product shortcodes because v0.1.3 does not include product card/grid.
6. Clear cache if the site uses cache.
7. Re-test foundation shortcodes.

## Expected Rollback Impact

Foundation shortcodes continue working in v0.1.3.
Product shortcodes will stop rendering because they do not exist in v0.1.3.


## v0.2.5 rollback note

If the product card polish causes visual issues, roll back to v0.2.5. v0.2.5 changes are CSS/metadata polish only and do not change WooCommerce query logic, database, cart, checkout or shortcode names.


## v0.2.5 rollback note
If the product grid alignment fix causes image cropping issues, roll back to v0.2.4. v0.2.5 changes CSS layout only.
