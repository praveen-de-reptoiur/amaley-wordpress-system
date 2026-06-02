# Cluster Related Cards Pagination v1.0.90

## Purpose
Adds frontend pagination to Cluster Single related-card widgets so users can access all linked records instead of seeing only the first few cards.

## Widgets updated
- Amaley Cluster Related SHGs
- Amaley Cluster Related Producers
- Amaley Cluster Related Products

## New Query / Layout controls
- Enable Pagination
- Previous Text
- Next Text

## New Style controls
Style → Pagination:
- Alignment
- Gap
- Margin
- Button padding
- Button background
- Button text color
- Current page background
- Current page text color
- Border
- Radius
- Typography

## Behaviour
- Number of Items is now used as items per page when pagination is enabled.
- Pagination appears only when total linked items are more than the Number of Items.
- Show All Connected Items still works as a full-list override and disables pagination for that section.
- Separate URL page parameters are used:
  - amcss_shg_page
  - amcss_producer_page
  - amcss_product_page

## Scope safety
- Existing card design remains unchanged.
- SHG/Producer OG card controls remain intact.
- Product section gets pagination but product card migration is not done.
- Member Single is untouched.
- SHG Single is untouched.
- Discovery Engine is untouched.
- WooCommerce logic is untouched.
- Header/footer are untouched.

## Next required work
Apply the same reusable pagination pattern to Member Single, SHG Single, archive/listing widgets and any remaining card grid widgets after Cluster Single pagination is confirmed stable.
