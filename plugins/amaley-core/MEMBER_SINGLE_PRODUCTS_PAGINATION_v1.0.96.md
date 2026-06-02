# Member Single Products Pagination v1.0.96

## Built from
v1.0.95, where Single Cluster and Single SHG pagination are already in place.

## Scope
Adds pagination only to:
- Amaley Member Single Products

Linked SHG and Linked Cluster remain unpaginated because they are single linked-card sections.

## Controls
Content:
- Enable Pagination
- Pagination Previous Text
- Pagination Next Text
- Product Limit / Items Per Page

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
- Enable Pagination default is OFF for safety.
- Turn Enable Pagination ON in the Member Single Products widget.
- Product Limit / Items Per Page controls how many product cards show per page.
- Pagination appears only when mapped products are more than the limit.
- Frontend pagination is AJAX/no-reload.
- Pagination JS is not loaded inside Elementor editor/preview to avoid sidebar loader issues.
- Normal URL fallback remains if JavaScript fails.

## Product mapping lookup
Product lookup checks multiple possible producer/member origin keys:
- `_amaley_origin_member_ids`
- `_amaley_origin_member_id`
- `linked_producer_maker`
- `_linked_producer_maker`
- `linked_member`
- `_linked_member`

## Untouched
- Single Cluster untouched.
- Single SHG untouched.
- Discovery Engine untouched.
- WooCommerce untouched.
- Header/footer untouched.
