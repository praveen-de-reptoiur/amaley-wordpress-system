# Simple Card Template Settings v1.0.85

## Purpose
This version removes the confusing multi-location Card Templates & Assignments UI and replaces it with a simple family-level model.

## New simplified settings
Amaley Core Settings now shows only:

- Cluster → Cluster Card Temp
- SHGs → SHG Card Temp
- Member → Member Card Temp
- Product → Product Card Temp

## Why
The earlier UI had many section-level options such as Discovery Product Grid, Member Single Products, Cluster Single SHG List, SHG Archive, Member Archive, etc.
That was too confusing and unnecessary for the current workflow.

## Safety
- Existing frontend pages do not change automatically.
- Old internal location keys are retained for backward compatibility.
- Existing accepted Cluster Single cards keep working.
- Product cards remain untouched.
- Discovery Engine remains untouched.
- WooCommerce remains untouched.
- Header/footer remain untouched.

## Future workflow
Elementor section widgets should later get one simple control:

Card Template:
- Current / Existing Card
- Amaley Standard Card

When Amaley Standard Card is selected, the section will use the relevant family template:
- SHG section → SHG Card Temp
- Cluster section → Cluster Card Temp
- Member section → Member Card Temp
- Product section → Product Card Temp
