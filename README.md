# Amaley WordPress System

Controlled source-code and documentation repository for the Amaley WordPress ecosystem.

## Read First

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, read these first:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`
4. `docs/PROJECT_MANIFEST.md`
5. `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md`
6. `docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md`
7. `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`

Locked standard:

```text
Har section, har element ka non-coder-friendly Content + Show/Hide + Layout + Style + Responsive control, with scoped lightweight CSS and no conflict.
```

## Current Plugin Source Status

| Plugin / Module | Current GitHub source status | Role |
| --- | --- | --- |
| Amaley Core | v1.1.0 | Data backbone, CPTs, product-origin mapping, Cluster to SHG/Producer Group links, OG card systems and Universal Showcase |
| Amaley Discovery Engine | **v1.6.2 clean stable** | Current shop, filter, CTA and contact-page Elementor widgets with full Elementor-native controls |
| Amaley Blog System | **v1.4.7 audit safe** | Current blog archive and single blog Elementor system |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Current header/footer builder |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell. Do not activate together with Amaley H/F Studio V2 |
| Amaley UI Sections Kit | v0.6.1 | Home and page sections |
| Amaley Compact Widgets | v0.4.18 final tested | Manual/static compact visual widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support modules |

## Amaley Blog System Current Lock

Current stable source:

```text
Amaley Blog System — v1.4.7 audit safe
```

Source path:

```text
plugins/amaley-blog-system/
```

Active Elementor widgets:

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

Future Blog System work must start from `plugins/amaley-blog-system/` and the v1.4.7 current status doc.

## Amaley Discovery Engine Current Lock

Current stable source:

```text
Amaley Discovery Engine — v1.6.2 clean stable
```

Source path:

```text
plugins/amaley-discovery-engine/
```

Active Elementor widgets:

```text
1. Amaley Collection Product Filter
2. Amaley Shop Hero
3. Amaley Shop Strip
4. Amaley Universal CTA
5. Amaley Contact Hero
6. Amaley Contact Info Cards
7. Amaley Contact Map Section
8. Amaley Contact Form CTA
```

Retired legacy widgets are not part of the active baseline:

```text
Amaley Heading
Amaley Text
Amaley Icon List
Amaley Product Discovery
Amaley Collection Discovery
Amaley Cluster Discovery
Amaley SHG Discovery
Amaley Member Discovery
Product Topbar Discovery
Collection Topbar Discovery
Cluster Topbar Discovery
SHG Topbar Discovery
Member Topbar Discovery
```

Future Discovery work must start from:

```text
v1.6.2 clean stable
```

## Active Documentation

Start here:

- `docs/PROJECT_MANIFEST.md`
- `docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md`
- `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md`
- `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
- `docs/QA_CHECKLIST.md`
- `docs/CHANGELOG.md`
- `plugins/README.md`

Historical docs may remain for audit, but active work must follow the current locked source docs listed above.
