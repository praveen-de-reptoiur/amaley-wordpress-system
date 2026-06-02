# Current Status — Amaley Core v1.0.99.4

## Locked design direction

The universal Amaley card structure is now the accepted visual direction:

1. Media image or initials placeholder
2. Small label
3. Title
4. Description / excerpt
5. Meta/stat boxes
6. Tags/chips
7. Full-width rounded rust button

This flow should remain consistent for:

- Cluster cards
- SHG / Collective cards
- Member / Producer cards
- Product cards

## Current latest version

```text
v1.0.99.4
```

Latest focus:

- Member Archive OG Member Card 1 hide/show + style controls fix
- No new heavy control sections
- No transform controls
- No archive JS/AJAX
- No pagination change in this version

## Editor stability note

Elementor Atomic Editor must stay inactive.

Issue observed:

- Elementor left panel / Atomic Elements loader kept appearing.
- Cache purge did not resolve it.
- After deactivating Atomic Editor, controls started working again.

## Recently accepted / working areas

### Single Cluster

- Related SHGs universal cards
- Related Producers universal cards
- Related Products universal cards
- Show/hide controls
- Style controls
- Transform controls earlier accepted for these sections
- AJAX/no-reload pagination accepted earlier

### Single Member

- Linked SHG
- Linked Cluster
- Products
- Product pagination
- OG card controls aligned with previous single-page pattern

### Single SHG

- Card controls aligned with Single Cluster/Single Member pattern
- Pagination work completed in workflow

### Cluster Archive

- OG Cluster Card 1 selector
- Existing controls bridged carefully after heavy-control issue
- Avoid heavy OG full controls

### SHG Archive

- OG SHG Card 1 selector
- Existing control selector fix v1.0.98.1

### Member Archive

- v1.0.99.4 is the latest attempt
- Uses class-bridge method rather than new heavy control sections
- Needs final practical testing in Elementor and frontend

### Product cards

- Universal product card price label/value readability fixed
- PRICE label and value hierarchy improved

## Immediate status

GitHub source is now updated to v1.0.99.4.

Next work should not be a new widget immediately. First test the current source, then create a cleanup baseline.
