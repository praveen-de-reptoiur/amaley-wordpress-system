# Safe Rollback v1.0.83.1

## Purpose
This package restores the accepted v1.0.82.2 state after the v1.0.83 Member Single linked-card connection caused layout/CSS breakage on the Member Single page.

## Restored accepted state
- Cluster Single SHG cards: accepted and working
- Cluster Single Producer/Member cards: accepted and working
- Phone/mobile: working
- Frontend: working

## Reverted
- Member Single Linked SHG central card connection from v1.0.83
- Member Single Linked Cluster central card connection from v1.0.83
- Member Single asset enqueue changes from v1.0.83

## Untouched
- Product cards
- Discovery Engine
- WooCommerce
- Header/footer
- Cluster Single accepted card work
- SHG Single
