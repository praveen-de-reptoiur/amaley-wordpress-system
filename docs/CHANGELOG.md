# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

Every entry should clearly explain what changed, why it changed, which file/plugin/module was affected, and whether it is safe, experimental, or archived.

---

## 2026-05-31

### Amaley Core v1.0.41 — Explicit Cluster Group Linking Source Sync

- Synced `plugins/amaley-core/` source to Amaley Core v1.0.41.
- Confirmed the plugin header and `AMALEY_CORE_VERSION` are now set to `1.0.41`.
- Added/confirmed explicit Cluster → SHG/Producer Group relation source:

```text
_amaley_cluster_linked_group_ids
```

- Added/confirmed Cluster edit screen side metabox:

```text
Amaley Linked Producer Groups / SHGs
```

- Confirmed this relation is saved directly on the Cluster record and is read first by the single cluster frontend.
- Live/staging observation confirmed:
  - Quick Details SHG count updates from selected groups.
  - Women Collectives section renders selected SHG/Producer Group cards.
  - People behind the cluster updates through linked SHGs.

Affected source:

```text
plugins/amaley-core/
plugins/amaley-core/amaley-core.php
plugins/amaley-core/includes/class-amaley-core-metaboxes.php
plugins/amaley-core/includes/class-amaley-core-cluster-single-sections.php
plugins/amaley-core/RELATION_EXPLICIT_LINKS_FIX_v1.0.41.md
```

Safety decision:

```text
No WooCommerce cart/checkout override.
No header/footer override.
No permalink rewrite.
No ZIP/media committed to GitHub.
Source and documentation only.
```

### Documentation Alignment — v1.0.41

- Updated root `README.md` to show Amaley Core v1.0.41 as the current GitHub source.
- Updated `docs/READ_FIRST_AMALEY.md` to include v1.0.41 and the explicit relation meta key.
- Updated `docs/CHANGELOG.md` with this v1.0.41 source sync entry.
- Updated `docs/PROJECT_MANIFEST.md` to align current source versions.
- Updated `docs/NEXT_CHAT_PROMPT.md` so future chats continue from v1.0.41, not v1.0.2.
- Updated `plugins/README.md` to align the plugin source status table.

---

## 2026-05-30

### Plugin Source Lock Update

- Confirmed Amaley UI Sections Kit source is locked at v0.6.1.
- Confirmed Amaley Compact Widgets source is updated and locked at v0.4.2.
- Cleaned the Compact Widgets changelog duplicate heading.
- Confirmed Compact Widgets v0.4.2 includes alignment controls for header, card/item text, and button row alignment.
- Confirmed Compact Widgets remains frontend-JS-free and scoped to the `.amaley-cw4-*` CSS family.
- Confirmed GitHub must remain source-only and documentation-only.

Current source locks after the 2026-05-31 update:

```text
Amaley Core: v1.0.41
Amaley Discovery Engine: v1.3.5
Amaley Site Shell: v1.0.1
Amaley UI Sections Kit: v0.6.1
Amaley Compact Widgets: v0.4.3 source / v0.4.2 active ZIP until staging test
Amaley Templates: v1.2.7
```

### Documentation Sync

- Updated root `README.md` with the current plugin architecture and added Amaley Compact Widgets to the target architecture.
- Updated `plugins/README.md` with current source folder structure and active source/Drive ZIP status.
- Updated `docs/READ_FIRST_AMALEY.md` with current plugin locks, GitHub/Drive rules, and source-only workflow.
- Updated `docs/NEXT_CHAT_PROMPT.md` so future chats do not treat UI Sections Kit as unbuilt and do not forget Compact Widgets.
- `docs/PROJECT_MANIFEST.md` should remain aligned with current plugin registry and source locks.

Safety decision:

```text
No plugin ZIP committed to GitHub.
No media committed to GitHub.
No live-site change done.
Documentation/source lock cleanup only.
```

---

## 2026-05-27

### Architecture / Documentation Update — UI Sections Kit and Performance Lock

- Added `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md` as the permanent performance and future UI direction lock.
- Locked the future Amaley website direction as lightweight, low-network-first, mobile-first, and globally design-token controlled.
- Locked the rule that future clean Amaley UI sections must not depend on Elementor default widgets.
- Clarified that Elementor may still exist temporarily in old/current migration contexts.
- Created `plugins/amaley-ui-sections-kit/README.md` as the planning folder for the future lightweight UI section/component system.
- Removed the old `plugins/amaley-widgets-kit/` planning folder to avoid the outdated Elementor-only direction.
- Updated `plugins/README.md`, root `README.md`, and `docs/PROJECT_MANIFEST.md` to reflect the revised architecture.

Affected files:

```text
README.md
plugins/README.md
plugins/amaley-ui-sections-kit/README.md
docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md
docs/PROJECT_MANIFEST.md
```

### Added

- Added `docs/AMALEY_PRIMARY_BUILD_RULES.md`.
- Added `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md`.
- Updated `docs/DRIVE_FOLDER_MAP.md`.
- Added Amaley Core v1.0.2 plugin source under `plugins/amaley-core/`.

### Fixed

- Updated Amaley Core from v1.0.0 / v1.0.1 to v1.0.2 after staging testing.
- Added WooCommerce HPOS compatibility declaration.
- Added safe cluster import fallback.
- Prevented duplicate Cluster creation during initial Cluster code backfill.

### Amaley Site Shell v1.0.1

- Added `plugins/amaley-site-shell/` as the lightweight header/footer shell plugin.
- Plugin source was uploaded to GitHub under `plugins/amaley-site-shell/`.
- Auto Header Render and Auto Footer Render were intentionally kept OFF.
- Current safe mode for Amaley Site Shell is shortcode/manual render only.

### Rule Lock

- Every future Amaley component must be conflict-safe, mobile-first, scoped, lightweight, non-coder manageable, documented, testable, and rollback-ready.
- The fresh/staging build remains the development base.
- GitHub and Google Drive will be maintained together with clear separation.
- Amaley Core v1.0.2 was the tested data-backbone baseline before later v1.0.41 source sync.

---

## 2026-05-25

### Added

- Created GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`.
- Updated root README.md with professional repository purpose and target architecture.
- Added core documentation files under `docs/`.
- Added `plugins/README.md`.
