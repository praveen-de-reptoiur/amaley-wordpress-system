# Amaley Core v1.0.0 Architecture

## Purpose

Amaley Core is the central data-layer plugin for Cluster, SHG, Member / Producer and WooCommerce Product Origin Mapping.

## Main Entities

```text
Cluster → SHG Group → Member / Producer
```

WooCommerce product origin mapping connects products to the data layer.

## Data Safety

- Relations are saved by post IDs in admin.
- CSV import/export uses stable codes.
- Cluster relation key: `cluster_code` / `_amaley_cluster_code`
- SHG relation key: `shg_code` / `_amaley_shg_code`
- Member relation key: `member_code` / `_amaley_member_code`
- Product relation key: product SKU

## Admin Menu

```text
Amaley Core
  ├── Dashboard
  ├── Clusters
  ├── SHG Groups
  ├── Members / Producers
  ├── Product Origin Mapping
  ├── Import / Export
  └── Settings
```

## Performance

The plugin is admin-focused and lightweight.

- No heavy frontend assets.
- Admin CSS is scoped.
- Admin CSS is loaded only on Amaley Core related screens.
- No Elementor or WooCommerce template replacement.

## Future Notes

Future versions may add:

- JSON export format
- automatic backup snapshot before import
- deeper data validation
- Elementor widgets that read Amaley Core data
- Project Guard compatibility checks


## WooCommerce Compatibility

Amaley Core does not manage WooCommerce orders. Version 1.0.1 declares compatibility with WooCommerce High-Performance Order Storage (custom order tables).
