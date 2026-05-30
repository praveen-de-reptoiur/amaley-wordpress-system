# Amaley WordPress System

## READ FIRST — Mandatory Universal Standard

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`

Locked rule:

> Har section, har element ka non-coder-friendly Content + Show/Hide + Layout + Style + Responsive control, with scoped lightweight CSS and no conflict.

This universal standard applies before project-specific Amaley rules. It is not limited to Amaley or Himalayan/formal design.

---

Controlled source-code and documentation repository for the Amaley WordPress ecosystem.

This repository is maintained for clean plugin development, source history, design-system control, migration planning, QA, debugging, and future developer handoff.

---

## Repository Purpose

This repository stores:

- Custom Amaley plugin source code
- Documentation and changelog records
- Architecture and plugin-boundary rules
- QA and dry-test notes
- Migration and handoff planning

GitHub is not a backup dump.

---

## GitHub vs Google Drive Rule

GitHub is for source code, documentation, version history, migration planning, QA notes, and developer handoff notes.

Google Drive is for `.wpress` backups, plugin ZIP backups, Elementor exports, WooCommerce exports, product images, screenshots, videos, and handoff ZIP packages.

Do not upload ZIPs, videos, screenshots, product image dumps, passwords, API keys, license keys, or `wp-config.php` to GitHub.

---

## Current Locked Plugin Source Status

| Plugin / Module | Current GitHub source status | Drive ZIP status | Role |
| --- | --- | --- | --- |
| Amaley Core | v1.0.2 | `amaley-core-v1.0.2.zip` | Data backbone and product-origin mapping |
| Amaley Discovery Engine | v1.3.5 | `amaley-discovery-engine-v1.3.5-no-cpt.zip` | Discovery, filtering, search, sort and pagination |
| Amaley Site Shell | v1.0.1 | `amaley-site-shell-v1.0.1.zip` | Header/footer shell; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | `amaley-ui-sections-kit-v0.6.1.zip` | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.3 source | v0.4.2 active ZIP until v0.4.3 ZIP/staging test | Manual/static compact visual widgets; includes Origin Map Path |
| Amaley Templates | v1.2.7 | `amaley-templates-v1.2.7.zip` | WooCommerce/page template support modules |

Current source code belongs in GitHub. Plugin ZIP backups stay in Google Drive.

---

## Active Documentation

Start here in this exact order:

- `000_READ_FIRST_BEFORE_ANY_WORK.md`
- `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
- `docs/READ_FIRST_AMALEY.md`
- `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `docs/AMALEY_PRIMARY_BUILD_RULES.md`
- `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`
- `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md`
- `docs/CHANGELOG.md`
- `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- `docs/DRIVE_FOLDER_MAP.md`
- `docs/QA_CHECKLIST.md`
- `docs/PROJECT_MANIFEST.md`
- `docs/NEXT_CHAT_PROMPT.md`
- `plugins/README.md`

---

## Target Architecture

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, random utility plugins, or page-builder default widgets for important custom UI sections.

Target custom system:

- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Compact Widgets
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

---

## Plugin Boundaries

### Amaley Core

Core manages data backbone only: Clusters, SHG Groups, SHG Members / Producers, Product Origin Mapping, producer profiles, traceability fields and system health checks.

Rule: Amaley Core must not become a frontend design plugin.

### Amaley Discovery Engine

Discovery Engine manages filtering, search, sorting, pagination, result grids, topbar filters and discovery layouts.

Rule: Discovery Engine must stay separate from Core, Templates, UI Sections Kit and Compact Widgets.

### Amaley Site Shell

Site Shell manages header, footer, mobile drawer, navigation shell and shell-level CTA controls.

Rule: auto-render remains on hold. Header/footer replacement must not be done blindly on the live site.

### Amaley UI Sections Kit

UI Sections Kit owns generic page/home visual sections and foundation UI components: Home Hero V6, Page Trust Strip and Pages Hero Other.

Rule: UI Sections Kit must not own CPT data cards, discovery filters, WooCommerce templates, header/footer or compact card libraries.

### Amaley Compact Widgets

Compact Widgets owns manual/static compact visual card and section widgets.

Current source addition: `v0.4.3` adds Amaley Origin Map Path and `[amaley_cw_origin_map]` for the homepage.

Rule: Compact Widgets must not own CPT/data logic, Discovery filters, WooCommerce template overrides, header/footer, Home Hero V6, Page Trust Strip or Pages Hero Other.

### Amaley Templates

Templates supports WooCommerce/page template modules. WooCommerce remains the commerce engine.

---

## Workflow Rule

1. Read `000_READ_FIRST_BEFORE_ANY_WORK.md` first.
2. Read `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md` before planning/design/build.
3. Review repo/source status before changing code.
4. Use source files for GitHub updates.
5. Do not commit ZIP/media/screenshots/videos to GitHub.
6. Preview or dry-test visual widgets before calling them final.
7. Update documentation/changelog after serious source changes.
8. Verify the final repo state before reporting done.
