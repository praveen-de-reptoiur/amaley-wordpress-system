# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

## Mandatory first read

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`
4. `docs/PROJECT_MANIFEST.md`
5. `docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md`
6. `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md`
7. `docs/AMALEY_CORE_CURRENT_STATUS_v1.0.99.5.md`
8. `docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md`
9. `plugins/amaley-core/OG_PRODUCT_PRICE_STACK_FIX_v1.0.99.5.md`
10. `plugins/amaley-page-assignment-bridge/README.md`

## Current locked source status

| Plugin / Module | Current source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.99.5 | Data backbone and OG card systems |
| Amaley Discovery Engine | **v1.6.2 clean stable** | Shop/filter/CTA/contact Elementor widgets |
| Amaley Blog System | **v1.4.7 audit safe** | Blog archive and single blog Elementor system |
| Amaley Page Assignment Bridge | v1.4.1 | Single product page assignment bridge |
| Amaley Brand Site Kit | v1.0.4 | Global brand tokens and Elementor support |
| Amaley H/F Studio V2 | v2.0.15 | Header/footer template workflow |
| Amaley UI Sections Kit | v0.6.1 | Home and page section widgets |
| Amaley Compact Widgets | v0.4.18 final tested | Manual/static compact widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

## Blog System v1.4.7 lock

Current source path:

```text
plugins/amaley-blog-system/
```

Current accepted widgets:

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

Accepted Blog template order:

```text
Blogs page:
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout

Blog Detail Template page:
1. Amaley Single Hero — Full Width
2. Amaley Single Article Layout — Fixed
```

Setup reminder:

```text
WordPress Admin → Amaley Blog
Blog Listing Page → Blogs
Single Blog Template Page → Blog Detail Template
Settings → Reading → Posts page should stay blank / Select
```

Future Blog System work starts from `plugins/amaley-blog-system/` and `docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md`.

## Discovery Engine v1.6.2 lock

Current source path:

```text
plugins/amaley-discovery-engine/
```

Current active widgets:

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

## Compact Widgets lock

Amaley Compact Widgets v0.4.18 is the accepted source baseline.

Reference docs:

```text
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
```

## Final architecture lock

```text
Card design / price layout / title / image / meta boxes / tags / button = Amaley Core
Grid / filter / search / sort / pagination = Amaley Discovery Engine
Blog archive card and single blog layout = Amaley Blog System
```

## Single Product lock

Amaley Page Assignment Bridge v1.4.1 is the accepted source for Single Product layout assignment.

## Elementor stability lock

```text
Elementor Atomic Editor must remain inactive.
```

## Working style

- Review repo/source status before changes.
- Use source files for GitHub updates.
- Keep ZIPs/media/screenshots/videos outside GitHub.
- Keep steps small and sequential.
- Verify before saying complete.
- Update GitHub only after Praveen approval.
