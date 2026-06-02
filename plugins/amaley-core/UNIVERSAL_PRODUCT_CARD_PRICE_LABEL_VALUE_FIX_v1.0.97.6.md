# Universal Product Card Price Label/Value Fix v1.0.97.6

## Issue
In universal product cards, the PRICE meta box did not clearly separate the label and value. The price value was too small/flat visually.

## Fix
Shared universal card CSS now improves product meta boxes:
- PRICE label is small uppercase label
- Price value is bold/readable
- WooCommerce price markup (`.amount`, `bdi`) inherits the correct value styling
- Meta boxes keep the same universal card layout

## Affected product card contexts
- Product cards rendered through Amaley Core
- SHG Single Products
- Cluster Single Products
- Member Single Products
- Future product archive cards using the same universal class

## Untouched
- Card structure
- Product data/query logic
- Cluster Archive
- Single Cluster
- Single SHG
- Single Member
- Discovery Engine
- WooCommerce logic
- Header/footer
- Pagination
