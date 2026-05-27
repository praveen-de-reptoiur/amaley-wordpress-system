# Amaley Core

Version: 1.0.0  
Author: Praveen  
Scope: Fresh WordPress / staging build only

Amaley Core is the data backbone plugin for the Amaley WordPress system.

It manages:

- Clusters
- SHG Groups
- Members / Producers
- Product Origin Mapping for WooCommerce products
- CSV import/export templates and data transfer

## Relationship Structure

```text
Cluster
  └── Multiple SHG Groups
        └── Multiple Members / Producers

WooCommerce Product
  └── One Primary Cluster
  └── One or Multiple SHG Groups
  └── Optional One or Multiple Members / Producers
```

## Custom Post Types

```text
amaley_cluster
amaley_shg_group
amaley_member
```

WooCommerce products remain WooCommerce products. Amaley Core only adds a product origin mapping panel.

## Import / Export

Admin path:

```text
Amaley Core → Import / Export
```

Supports:

- Download CSV templates
- Export existing Cluster / SHG / Member / Origin data
- Import CSV with dry-run preview
- Create only / Update only / Create + Update modes
- Stable code-based mapping using `cluster_code`, `shg_code`, `member_code`, and product SKU

## Safety Rules

- WooCommerce is supported, not replaced.
- Elementor is not touched.
- No fake Cluster / SHG / Producer data is created.
- Admin assets are scoped and lightweight.
- Import validates before writing.
- Normal data management should not require code editing.

## First Test Order

1. Install on fresh/staging WordPress.
2. Activate WooCommerce first if product origin mapping will be tested.
3. Activate Amaley Core.
4. Add one Cluster manually.
5. Add one SHG linked to that Cluster.
6. Add one Member linked to that SHG.
7. Create or open one WooCommerce product.
8. Map Product → Cluster → SHG → Member.
9. Export all CSVs.
10. Test import dry-run using sample templates.

## Important

Do not install directly on the old live site. Test only on the fresh/staging setup first.
