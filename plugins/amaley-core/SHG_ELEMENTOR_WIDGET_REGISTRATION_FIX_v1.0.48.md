# Amaley Core v1.0.48 — SHG Elementor Widget Registration Fix

## Purpose

Fixes the case where SHG Archive / SHG Single widgets were available in code but did not appear in the Elementor widget search panel on some Elementor builds.

## What changed

- Keeps all v1.0.47 SHG Archive and SHG Single section widgets.
- Adds Elementor legacy registration hook fallback: `elementor/widgets/widgets_registered`.
- Keeps the modern registration hook: `elementor/widgets/register`.
- Adds duplicate-registration guard so widgets are not registered twice.
- Rebuilds installable ZIP with a single clean plugin root: `amaley-core/`.

## What did not change

- No WooCommerce cart/checkout change.
- No header/footer change.
- No permalink/route change.
- No Discovery Engine change.
- No relation/meta mapping change.

## Test

After activation, open Elementor and search for:

```text
SHG
```

Expected widgets include:

```text
Amaley SHG Archive Hero
Amaley SHG Archive Trust Strip
Amaley SHG Archive Intro
Amaley SHG Archive Grid
Amaley SHG Archive CTA
```
