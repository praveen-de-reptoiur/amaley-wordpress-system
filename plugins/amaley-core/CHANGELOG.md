# Amaley Core Changelog

## 1.0.2 - 2026-05-27

### Fixed

- Added safe cluster import fallback to match existing blank-code clusters by exact title during first code backfill imports.
- Prevents duplicate Cluster creation when old cluster records existed before Amaley Core stable codes were saved.


## 1.0.1 — 2026-05-27

### Fixed

- Declared WooCommerce High-Performance Order Storage compatibility using WooCommerce `FeaturesUtil`.
- Removed WooCommerce incompatible-feature warning for stores with custom order tables enabled.

### Notes

- No data structure change.
- No CPT change.
- No field schema change.
- No import/export change.
- Safe patch over v1.0.0.

## 1.0.0 — 2026-05-27

### Added

- Added Cluster CPT.
- Added SHG Group CPT.
- Added Member / Producer CPT.
- Added central field registry.
- Added non-coder friendly metaboxes.
- Added WooCommerce Product Origin Mapping panel.
- Added Amaley Core admin dashboard.
- Added Product Origin Mapping status screen.
- Added CSV template downloads.
- Added CSV export for Clusters, SHGs, Members and Product Origin Mapping.
- Added CSV import with dry-run preview, validation, and create/update modes.
- Added lightweight scoped admin CSS.

### Rule Lock

- One Cluster can have multiple SHGs.
- One SHG can have multiple Members.
- One product can map to one Cluster, multiple SHGs, and optional Members.
- Data relations use stable codes/IDs, not typed names only.
- WooCommerce remains the commerce engine.
- Old live site is not the development target.
