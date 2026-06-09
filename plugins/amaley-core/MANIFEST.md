# Amaley Core v1.0.144 Manifest

## Repository path

`plugins/amaley-core/`

## Locked version

- Plugin header version: `1.0.144`
- `AMALEY_CORE_VERSION`: `1.0.144`
- Status: Working live source lock
- Source type: Clean GitHub source, synced from verified live File Manager export

## Production source structure

```text
amaley-core.php
assets/
includes/
templates/
docs/
README.md
CHANGELOG.md
MANIFEST.md
.gitignore
```

## Important working areas included

- Cluster archive and single cluster widgets/renderers
- SHG archive and single SHG widgets/renderers
- Member / Producer archive widgets/renderers
- Member / Producer single widgets/renderers
- Amaley universal card registry and renderer
- WooCommerce product-origin mapping layer
- Product, SHG, cluster and member card styling assets
- Product responsive pagination scripts
- Import/export and admin support files

## Current working locks

- Single Member / Producer Products: OG/Core product card retained with responsive grid final
- Single Member / Producer Gallery: clean controls retained
- Single Member / Producer Contact CTA: clean controls retained
- Plugin version display synced to `1.0.144`

## Clean-source exclusions

The following temporary/legacy backup ZIP files were removed from GitHub source to avoid confusion:

```text
includes/widgets/class-amaley-core-cluster-single-widget-controls-BACKUP-BEFORE-HEADING-FIX.php.zip
includes/widgets/class-amaley-core-cluster-single-widget-controls-WORKING-v1.0.101.php.zip
```

These were backup archives only and were not required for runtime.

## Safety note

This source lock does not intentionally change:

- WooCommerce product data
- Origin mappings
- Uploaded media/photos
- Header/footer templates
- Live Elementor page content
- Orders, carts, payments or checkout

## Recommended Git tag

```text
v1.0.144-working-lock
```
