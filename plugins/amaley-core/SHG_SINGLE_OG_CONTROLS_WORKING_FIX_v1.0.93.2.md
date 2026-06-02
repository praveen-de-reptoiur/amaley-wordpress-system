# SHG Single OG Controls Working Fix v1.0.93.2

## Purpose
v1.0.93 created the OG Card full controls method for SHG Single but the method was not being called from the widget style-control registration. As a result, controls either did not appear properly or existing controls did not affect OG Card 1 as expected.

## Fix
- Registers `OG Card: Full Controls` properly inside SHG Single widgets.
- Controls now load when Card Template = OG Card 1.
- Controls target the OG card classes:
  - `.amaley-card`
  - `.amaley-card__media`
  - `.amaley-card__initials`
  - `.amaley-card__label`
  - `.amaley-card__title`
  - `.amaley-card__excerpt`
  - `.amaley-card__meta`
  - `.amaley-card__meta-item`
  - `.amaley-card__tags`
  - `.amaley-card__button`

## Widgets affected
- Amaley SHG Single Linked Cluster
- Amaley SHG Single Members
- Amaley SHG Single Products

## Safety
- No frontend design change.
- No card renderer logic change.
- No pagination added.
- Single Cluster v1.0.91 remains untouched.
- Single Member v1.0.92.4 remains untouched.
- Discovery Engine, WooCommerce, header/footer untouched.
