# OG Card Controls Mapping — Cluster v1.0.88

## Purpose
This patch maps the existing Elementor style controls to the locked OG universal card classes.

## Scope
Only the Cluster Single widgets already using the approved OG card design:
- Amaley Cluster Related SHGs
- Amaley Cluster Related Producers

## What now works on OG cards
Existing Elementor controls now target both old Cluster Single card classes and the new OG card classes:

- Card background
- Card border
- Card radius
- Card shadow
- Card body padding
- OG card inner gap
- Image / placeholder height
- Image / placeholder radius
- Placeholder background and text color
- Card label typography and color
- Card title typography and color
- Card description typography and color
- Meta/stat box gap, background, border, padding, radius
- Meta label/value typography and color
- Tags/chips gap, background, color, border, padding, radius, typography
- Button padding, radius, colors and typography
- Section layout, section padding and grid gap

## What did not change
- No visual redesign.
- Default accepted card design remains unchanged.
- No Member Single change.
- No product card migration.
- No Discovery Engine change.
- No WooCommerce change.
- No header/footer change.

## Testing
Open Cluster Single template in Elementor and test controls on:
- Cluster Related SHGs
- Cluster Related Producers

The frontend should look the same unless a style control is manually changed.
