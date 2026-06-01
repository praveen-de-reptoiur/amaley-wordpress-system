# SHG Single CSS Recovery + Control Selector Audit — v1.0.69

## Purpose
Recover SHG Single after v1.0.68 introduced broad CSS rules that unintentionally changed hero/contact backgrounds and approved card styling.

## Fixed
- Removed broad late `.amss-section { background: #fffaf2; }` override.
- Restored approved dark chocolate hero and contact/CTA sections.
- Restored approved final product card family.
- Restored approved related SHG/member card rhythm.
- Kept new section-level buttons without touching global card CSS.
- Added control selectors for section buttons, card images, meta/details boxes and all locked card families.

## Not touched
- Cluster Archive design.
- Cluster Single design.
- SHG Archive design.
- WooCommerce product templates.
- Header/footer/site shell.
- Existing mapping/data logic.
