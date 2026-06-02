# Member Archive Rollback / Editor Safe v1.0.99.2

## Purpose
This build intentionally rolls Member Archive changes back to the stable v1.0.98.1 baseline while keeping the higher version number so it can safely replace v1.0.99 / v1.0.99.1.

## Why
v1.0.99 and v1.0.99.1 caused or failed to resolve Elementor editor left-panel loading on the Member / Producer Archive template.

## What remains
All stable work up to v1.0.98.1 remains:
- Single Cluster accepted state
- Single SHG accepted state
- Single Member accepted state
- Cluster Archive lightweight work
- SHG Archive selector/control fix
- Product card price label/value fix if included before v1.0.98.1 chain

## What is intentionally removed
- Member Archive OG Member Card selector
- Member Archive OG renderer
- Any Member Archive OG CSS from v1.0.99 / 99.1

## Next direction
Member Archive should be rebuilt only after confirming the editor is stable with this rollback. The next attempt should use a completely separate small widget or a non-editor-heavy server-side renderer, not heavy selector mapping.
