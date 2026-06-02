# Cluster Archive Audited Lightweight Lock v1.0.97.3

## Purpose
This is an audited rebuild of the lightweight Cluster Archive OG card patch.

## Base
Built from:
- v1.0.97.2 Cluster Archive Lightweight OG Card Rescue
- which was built from stable v1.0.96

## What is locked
Cluster Archive Grid keeps only a lightweight selector:

Card Template:
- Current / Existing Card
- OG Cluster Card 1

## What is intentionally NOT included
- No OG full control section
- No heavy transform/motion controls
- No large extra Elementor style-control block for OG cards
- No archive AJAX or frontend JavaScript registration
- No pagination changes
- No changes to Single Cluster, Single SHG, Single Member, Discovery Engine, WooCommerce, header or footer

## Audit checks passed
- Simple Card Template selector exists
- Heavy OG full controls are absent
- Transform controls are absent
- Lightweight renderer is present
- No Cluster Archive script registration was added
- PHP lint passed
- ZIP integrity test passed

## Practical note
This version is meant to keep Elementor stable. OG card styling is fixed through scoped CSS. If more controls are needed later, they should be added one small group at a time, not as a heavy full-control block.
