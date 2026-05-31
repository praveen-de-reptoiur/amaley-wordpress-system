# PROJECT MANIFEST — Amaley WordPress System

This manifest is the project index for the Amaley WordPress system.

---

## Repository

```text
praveen-de-reptoiur/amaley-wordpress-system
```

---

## GitHub Role

GitHub is used for source code, documentation, version history, migration planning, QA notes, and developer handoff notes.

GitHub is not used for heavy backup files, media, screenshots, videos, plugin ZIPs, `.wpress` backups, or secrets.

---

## Google Drive Role

Google Drive is used for plugin ZIP backups, full website backups, Elementor exports, WooCommerce exports, product images, screenshots, videos, and handoff packages.

---

## Current Locked Source Versions

| Plugin / Module | Current Source | Role |
| --- | --- | --- |
| Amaley Core | v1.0.41 | Data backbone, product-origin mapping and explicit Cluster → SHG/Producer Group links |
| Amaley Discovery Engine | v1.3.5 | Discovery, filters, listings, search, sort, pagination |
| Amaley Site Shell | v1.0.1 | Header/footer shell and mobile drawer; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact visual widgets; v0.4.2 active ZIP may remain until v0.4.3 staging test |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

---

## Latest Amaley Core Relation Lock

Current Amaley Core v1.0.41 includes the explicit Cluster → SHG/Producer Group linking workflow.

Source of truth meta key:

```text
_amaley_cluster_linked_group_ids
```

Admin edit box:

```text
Amaley Linked Producer Groups / SHGs
```

This relation powers the single cluster frontend output first, before fallback relationship detection.

Expected frontend behaviour:

- Quick Details → SHGs count follows selected groups.
- Women Collectives cards follow selected groups.
- People behind the cluster follows linked SHGs/producers.

---

## Current Documentation Index

### `README.md`

Main repository overview, current architecture, GitHub/Drive rules, plugin boundaries, and workflow rules.

### `docs/READ_FIRST_AMALEY.md`

Primary onboarding file. Read before touching the project.

### `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`

Main plugin/widget ownership registry. Use before building, moving, or changing widgets.

### `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`

Locked design-system reference.

### `docs/AMALEY_PRIMARY_BUILD_RULES.md`

Primary safe-build and conflict-prevention rules.

### `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`

Permanent performance and future UI direction lock.

### `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md`

Widget/template control and performance expectations.

### `docs/CHANGELOG.md`

Project change history. Every serious change must be documented here.

### `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`

Fresh WordPress migration plan and safety approach.

### `docs/DRIVE_FOLDER_MAP.md`

Google Drive usage map.

### `docs/QA_CHECKLIST.md`

Testing and verification checklist.

### `docs/NEXT_CHAT_PROMPT.md`

Continuation prompt for future chats.

### `plugins/README.md`

Plugin/module source folder and ownership index.

---

## Current Source Folder Map

```text
plugins/
  README.md
  amaley-core/
  amaley-discovery-engine/
  amaley-site-shell/
  amaley-ui-sections-kit/
  amaley-compact-widgets/
  amaley-templates/
  amaley-project-guard/
  amaley-debug-toolkit/
```

---

## Hard Rules

- GitHub is source-only and documentation-only.
- ZIPs, screenshots, videos, backups and media dumps belong in Google Drive.
- Source files should be used for GitHub updates.
- WooCommerce remains the commerce engine.
- Discovery Engine owns discovery/filter/list/search/sort/pagination logic.
- Core owns data backbone, origin mapping and explicit cluster group links.
- UI Sections Kit owns locked generic page/home visual sections.
- Compact Widgets owns manual/static compact visual widgets.
- Templates supports WooCommerce/page template modules.
- Site Shell owns header/footer shell only; auto-render remains on hold until safely tested.
- Do not say done until verification is complete.
