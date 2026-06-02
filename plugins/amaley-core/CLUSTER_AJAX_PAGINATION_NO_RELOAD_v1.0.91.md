# Cluster AJAX Pagination No-Reload v1.0.91

## Purpose
v1.0.90 pagination worked, but clicking page numbers reloaded the whole page because it used normal URL query pagination. v1.0.91 upgrades Cluster related-card pagination to AJAX/no-reload.

## Scope
AJAX pagination is added only for:
- Cluster Single Related SHGs
- Cluster Single Related Producers
- Cluster Single Related Products

## Behaviour
- Clicking pagination numbers updates only the card grid.
- The full page does not reload when JavaScript is working.
- If JavaScript fails or is disabled, the old URL-based pagination still works as a fallback.
- The section smoothly scrolls to the top after the cards update.
- Existing card design and controls remain unchanged.

## Safety
- Member Single is untouched.
- SHG Single is untouched.
- Discovery Engine is untouched.
- WooCommerce logic is untouched.
- Header/footer are untouched.
