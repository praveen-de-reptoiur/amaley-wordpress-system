# QA CHECKLIST — Amaley WordPress System

This checklist must be used before approving any major Amaley website, plugin, template, or migration update.

No change is complete until it is tested and documented.

## 1. Backup Check

Before making changes:

- Latest `.wpress` backup is available
- Backup is stored in Google Drive
- Current active plugin versions are recorded
- Rollback file is available
- Changelog is ready to update

## 2. Plugin Check

Check these after plugin install/update:

- WordPress admin opens without error
- Elementor editor opens
- WooCommerce product page opens
- Shop page opens
- No critical error
- No PHP warning visible
- No broken shortcode
- No broken Elementor widget
- No duplicate widget names
- No old plugin version accidentally activated

## 3. Amaley Templates Plugin Check

Check:

- Product Hero widget works
- Product Info Tabs widget works
- Product Trust Strip works
- Shop Hero widget works
- Shop Discovery widget works
- Style controls are visible section-wise
- Responsive controls work
- WooCommerce add-to-cart still works
- Variable product selector works if product has variations
- No WooCommerce cart/checkout override is broken

## 4. Amaley Discovery Engine Check

Check:

- Filters load properly
- Product grid loads
- Pagination works
- Sort works
- Active filter chips work
- Mobile filter behaviour works
- No layout break on tablet
- No conflict with Amaley Templates
- No CPT duplication

## 5. WooCommerce Check

Test:

- Product page
- Product image gallery
- Product price
- Product variations
- Add to cart
- Cart page
- Checkout page
- Coupon field
- Order flow
- Stock status
- Reviews if enabled

WooCommerce must remain the commerce engine.

## 6. Elementor Check

Check:

- Elementor editor loads
- Template preview loads
- CSS regenerates properly
- Widgets appear in correct categories
- No missing controls
- No duplicate widget labels
- No broken section layout
- No global CSS leak

After major update:

- Regenerate Elementor CSS
- Clear cache
- Test frontend again

## 7. Design System Check

Compare every section with:

- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`

Check:

- Font family
- Heading size
- Body text size
- Text color
- Background color
- Button style
- Card radius
- Card shadow
- Spacing
- Image crop
- Mobile layout

If it does not match the design system, it is not ready.

## 8. Responsive Check

Test these widths:

```text
360px
390px
430px
768px
1024px
1366px
