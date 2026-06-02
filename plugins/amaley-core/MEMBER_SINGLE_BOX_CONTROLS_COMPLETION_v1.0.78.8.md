# Member Single Box Controls Completion v1.0.78.8

Controls-only completion patch after v1.0.78.7. The marked inner stat/meta boxes inside cards now have direct controls for margin, padding, radius, min-height and responsive behavior.

## Added controls
- SHG/Cluster card stat boxes: padding, margin, radius, min-height, columns, label/value margin.
- Product price/origin boxes: padding, margin, radius, min-height, columns.
- Snapshot stat boxes: margin, min-height, label/value margin.
- Card-level margin controls for related, product, story, gallery and CTA cards.
- Tag/chip padding, margin and radius controls for hero, story and product tags.
- Image/media radius/margin controls where missing.
- Label, heading and description margin controls.

## Safety
No base CSS redesign, no layout change, no WooCommerce/header/footer/admin/archive/SHG Single/Cluster Single changes. Elementor selectors remain scoped with {{WRAPPER}} and existing .amms-* Member Single classes.
