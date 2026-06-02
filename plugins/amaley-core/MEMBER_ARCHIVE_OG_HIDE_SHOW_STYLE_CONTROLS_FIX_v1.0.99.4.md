# Member Archive OG Hide/Show + Style Controls Fix v1.0.99.4

## Scope
Fixes OG Member Card 1 in Amaley Member Archive Grid so existing hide/show and style controls work without adding heavy control sections.

## Method
Instead of adding more Elementor controls or heavy selector mapping, OG Member Card 1 markup now also carries the existing Member Archive control classes:

- ampa-member-card
- ampa-member-media
- ampa-member-body
- ampa-card-label
- ampa-card-desc
- ampa-card-meta
- ampa-chip-row
- ampa-card-button

This lets existing Elementor controls naturally target the OG card.

## Hide/show controls supported
- Show Image / Placeholder
- Show Placeholder When No Image
- Show Card Label
- Show Role Detail
- Show Village Detail
- Show SHG Detail
- Show Cluster Detail
- Show Skill Tags
- Show Product Tags
- Show Bio / Description
- Show Card Button
- Show Section Button

## Style controls supported
Existing Member Archive controls now apply to OG Member Card 1:
- Card background, border, radius, body padding, inner gap, min height
- Image height, fit, placeholder background/text/size/typography
- Card label/title/bio typography, color and margins
- Meta columns, gap, margin, box styling, label/value styling
- Chip row and chip styling
- Card button alignment, padding, margin, radius, colors, typography

## Safety
- No new control sections
- No OG full controls
- No transform controls added
- No archive JS/AJAX
- No pagination changes
- Built from v1.0.99.3
