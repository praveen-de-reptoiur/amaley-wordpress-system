# Amaley WordPress System

Controlled source-code and documentation repository for the Amaley WordPress ecosystem.

## Read First

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, read these first:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`

Locked standard:

```text
Har section, har element ka non-coder-friendly Content + Show/Hide + Layout + Style + Responsive control, with scoped lightweight CSS and no conflict.
```

## Repository Role

GitHub stores source code, documentation, changelogs, QA notes, architecture rules and developer handoff notes.

Drive/backups are used separately for install ZIPs, full site backups, media, screenshots, videos and export packs.

## Current Plugin Source Status

| Plugin / Module | Current GitHub source status | Role |
| --- | --- | --- |
| Amaley Core | v1.0.99.4 | Data backbone, CPTs, product-origin mapping, Cluster to SHG/Producer Group links, archive/single widgets and OG card systems |
| Amaley Discovery Engine | v1.3.5 | Discovery, filtering, search, sort and pagination |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Current active header/footer builder: Elementor H/F templates, assignment rules, live-style widgets, mobile drawer and section-wise full controls |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell. Do not activate together with Amaley H/F Studio V2 |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other and UI foundation |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact visual widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support modules |

## Amaley H/F Studio V2 Lock Note

Current header/footer system:

```text
Amaley H/F Studio V2 — v2.0.15 pre-lock safety
```

Source path:

```text
plugins/amaley-hf-studio-v2/
```

Rules:

- Keep old Amaley H/F and old Amaley Site Shell inactive.
- Do not run two header/footer systems together.
- Theme hiding remains OFF by default.
- No output buffering.
- Header/footer rendering must remain hook-based and lightweight.
- Header/footer Elementor widgets must keep section-wise Content, Hide/Show, Layout, Style, Typography and Responsive controls.

Next planned phase:

```text
v2.1.0 — Amaley Global Colors Sync / Elementor Kit color sync
```

## Elementor Stability Lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor panel loading issues during earlier widget work. Do not reactivate it without a controlled rollback plan.

## Active Documentation

Start here:

- `docs/PROJECT_MANIFEST.md`
- `docs/AMALEY_HF_STUDIO_V2_CURRENT_STATUS_v2.0.15.md`
- `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- `docs/QA_CHECKLIST.md`
- `docs/CHANGELOG.md`
- `plugins/README.md`

## Target Architecture

The active Amaley system is moving toward custom, scoped, maintainable plugins:

- Amaley Core
- Amaley Discovery Engine
- Amaley H/F Studio V2
- Amaley UI Sections Kit
- Amaley Compact Widgets
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit
