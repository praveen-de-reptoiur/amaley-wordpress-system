# Amaley WordPress System

Controlled source-code and documentation repository for the Amaley WordPress ecosystem.

## Read First

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, read these first:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`
4. `docs/AMALEY_UNIVERSAL_SHOWCASE_WIDGET_LOCK.md`

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
| Amaley Core | v1.1.0 | Data backbone, CPTs, product-origin mapping, Cluster to SHG/Producer Group links, archive/single widgets, OG card systems and the new Universal Showcase Widget |
| Amaley Discovery Engine | v1.4.4 stable OG card controls | Discovery, filtering, search, sort, pagination, source-level Amaley Core OG Product Card 1 renderer and approved selected OG product-card controls |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Current active header/footer builder: Elementor H/F templates, assignment rules, live-style widgets, mobile drawer and section-wise full controls |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell. Do not activate together with Amaley H/F Studio V2 |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other and UI foundation |
| Amaley Compact Widgets | v0.4.18 final tested | Manual/static compact visual widgets; includes approved Dual Section Heading and fixed non-dual widget alignment system |
| Amaley Templates | v1.2.7 | WooCommerce/page template support modules |

## Amaley Discovery Engine Lock Note

Current discovery/filter system:

```text
Amaley Discovery Engine — v1.4.4 stable OG card controls
```

Source path:

```text
plugins/amaley-discovery-engine/
```

Current accepted behaviour:

- Product Discovery uses the source-level `Amaley Core Product Card — Select Template` renderer.
- Accepted template is `OG Product Card 1`.
- Pagination, filtering, sorting and reset continue to return the selected OG product card.
- Approved card-control structure is section-wise: Content tab for selected OG product-card content controls; Style tab for section/heading, filters/toolbar, grid/spacing, selected OG card layout/text/meta/tags/button, and pagination.
- Product data, product images/gallery, product-origin mappings, WooCommerce templates, header and footer were not changed by the v1.4.4 update.

Previous working base:

```text
v1.3.6 — Core card source fix
```

Do not use rejected experimental versions for future work:

```text
v1.3.7, v1.3.8, v1.3.9, v1.4.0, v1.4.1, v1.4.2, v1.4.3 rollback packages
```

Next pending Discovery work:

```text
Cluster / SHG-Collective / Producer-Member filters, added source-level and tested one by one.
```

## Amaley Universal Showcase Lock Note

Current universal showcase direction:

```text
Amaley Universal Showcase — Amaley Core v1.1.0
```

Source paths:

```text
plugins/amaley-core/includes/class-amaley-core-universal-showcase.php
plugins/amaley-core/includes/widgets/class-amaley-core-universal-showcase-widget.php
plugins/amaley-core/assets/amaley-core-universal-showcase.css
plugins/amaley-core/assets/amaley-core-universal-showcase.js
docs/AMALEY_UNIVERSAL_SHOWCASE_WIDGET_LOCK.md
```

Locked editor rule:

```text
Selected content/card type ke controls hi Elementor editor me visible honge.
```

Meaning: Cluster selected means Cluster controls only, SHG selected means SHG controls only, Member selected means Member controls only, Product selected means Product controls only.

Discovery Engine filters, search, sort and filtered pagination remain untouched.

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

## Amaley Compact Widgets Lock Note

Current compact widget system:

```text
Amaley Compact Widgets — v0.4.18 final tested
```

Source path:

```text
plugins/amaley-compact-widgets/
```

Current accepted behaviour:

- Dedicated `Amaley Dual Section Heading` widget is approved for reusable section headings.
- Dual Heading has clean heading-only controls and must not inherit card/grid/widget controls.
- Old non-dual compact widgets use a separated alignment system: Header Alignment, Card Text Alignment and Button Alignment.
- The old broad Overall Alignment control was removed from non-dual compact widgets to avoid alignment conflicts.
- Elementor live-preview alignment was tested for key non-dual widgets after the v0.4.18 reset.
- No WooCommerce, header/footer, product data, product images, product-origin mappings, cart/checkout, template overrides or global CSS were intentionally changed.

Do not use rejected/archived compact widget builds as final:

```text
v0.4.14, v0.4.15, v0.4.16, v0.4.17
```

## Elementor Stability Lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor panel loading issues during earlier widget work. Do not reactivate it without a controlled rollback plan.

## Active Documentation

Start here:

- `docs/PROJECT_MANIFEST.md`
- `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.4.4.md`
- `docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md`
- `docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md`
- `docs/AMALEY_UNIVERSAL_SHOWCASE_WIDGET_LOCK.md`
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
