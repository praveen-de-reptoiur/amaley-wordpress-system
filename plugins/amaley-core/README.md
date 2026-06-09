# Amaley Core

Amaley Core is the backend and Elementor widget layer for the Amaley fresh WordPress build. It manages Cluster, SHG Group, Member / Producer, WooCommerce product-origin mapping, archive sections, single profile sections, and universal Amaley card rendering.

## Current locked version

- Plugin version: `1.0.144`
- Constant version: `1.0.144`
- Status: Working live checkpoint
- Source base: File Manager export checked after live fixes

## Current working scope

- Cluster archive and single cluster sections
- SHG archive and single SHG sections
- Member / Producer archive sections
- Member / Producer single page sections
- Product-origin mapping cards and related product rendering
- Single Member Products section locked with OG product card and responsive grid final
- Single Member Gallery controls cleaned
- Single Member Contact CTA controls cleaned

## Production safety notes

- No header/footer overrides
- No WooCommerce template overrides
- No order/payment logic
- No product data mutation during frontend rendering
- No global unscoped frontend CSS beyond Amaley Core plugin selectors
- Elementor widgets use scoped selectors and renderer fallbacks

## Installation

For WordPress installation, use the separate clean installable ZIP:

`amaley-core-v1.0.144-clean-installable.zip`

For GitHub, upload this extracted source folder to the repository root.

## Recommended Git workflow

```bash
git add .
git commit -m "chore: lock Amaley Core working source v1.0.144"
git tag v1.0.144-working-lock
```

## Important

Do not upload old scattered patch files or temporary replacement files to GitHub. This source pack is the clean locked source.
