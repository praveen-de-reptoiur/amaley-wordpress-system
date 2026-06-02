# SHG Single Pagination Clean Safe v1.0.95

## Built from
Stable base: v1.0.93.3 SHG Single Duplicate Controls Fix.

## Fix
Adds clean pagination to:
- Amaley SHG Single Members
- Amaley SHG Single Products

## Controls
Content / Display:
- Enable Pagination
- Pagination Previous Text
- Pagination Next Text

Style:
- Pagination alignment
- Gap
- Button background
- Button text color
- Current page background
- Current page text color
- Border
- Radius
- Typography

## Behaviour
- Default Enable Pagination is OFF for safety.
- Turn Enable Pagination ON where needed.
- Number of Cards / Limit becomes items per page.
- Pagination appears only when total linked records are more than the limit.
- Frontend pagination is AJAX/no-reload.
- Elementor editor/preview does not load pagination JS to avoid the sidebar loader issue.
- Normal URL fallback remains if JS fails.

## Notes
- Linked Cluster does not have pagination because it is one linked cluster card.
- Product lookup now checks multiple common SHG origin/meta keys.

## Untouched
- Single Cluster untouched.
- Single Member untouched.
- Discovery Engine untouched.
- WooCommerce untouched.
- Header/footer untouched.
