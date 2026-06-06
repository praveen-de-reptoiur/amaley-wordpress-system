# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

## Mandatory first read

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`
4. `docs/PROJECT_MANIFEST.md`
5. `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.4.4.md`
6. `docs/AMALEY_CORE_CURRENT_STATUS_v1.0.99.5.md`
7. `plugins/amaley-core/OG_PRODUCT_PRICE_STACK_FIX_v1.0.99.5.md`

## Current locked source status

| Plugin / Module | Current source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.99.5 | Data backbone, product-origin mapping, CPT archive/single sections, universal OG cards, and accepted OG Product Card price stack fix |
| Amaley Discovery Engine | v1.4.4 | Discovery/filter/listing engine with source-level Amaley Core OG Product Card 1 renderer; pagination/filter/sort tested |
| Amaley Brand Site Kit | v1.0.4 | Global brand tokens and safe Elementor color/font support |
| Amaley H/F Studio V2 | v2.0.15 | Header/footer template workflow |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

## Final card architecture lock

```text
Card design / price layout / title / image / meta boxes / tags / button = Amaley Core
Grid / filter / search / sort / pagination = Amaley Discovery Engine
```

Amaley Core v1.0.99.5 contains the accepted OG Product Card price stack fix:

```text
Old price = smaller + strikethrough
Sale price = next line + bold/readable
```

## Current Discovery Engine lock

Amaley Discovery Engine v1.4.4 is the accepted baseline.

Accepted render flow:

```text
Product Discovery widget
→ Card Renderer: Amaley Core Product Card — Select Template
→ Template: OG Product Card 1
```

Accepted behaviour:

- OG Product Card 1 appears in product discovery grid.
- Pagination keeps OG Product Card 1.
- Filter, reset and sort keep OG Product Card 1.
- Product data, photos/gallery, origin mapping, WooCommerce templates, header and footer are untouched.

Archive note:

```text
Discovery Engine v1.4.5 price-layout fix is not the final source path.
Price/card visual fixes are now handled by Amaley Core v1.0.99.5.
```

## Pending Discovery work

Add source-level filters one by one only:

```text
1. Cluster filter
2. SHG / Collective filter
3. Producer / Member filter
```

After each filter addition, test:

```text
Page 1, page 2, sort, filter apply, reset
```

## Elementor stability lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during universal-card work.

## Current card design lock

Universal OG card flow:

```text
image / initials placeholder → label → title → description → meta/stat boxes → tags/chips → full-width rounded button
```

Rules:

- Same card type must keep the same design wherever it appears.
- Product card design is reused in Discovery Engine v1.4.4 through Amaley Core OG Product Card 1.
- Card visual/content changes must be made in Amaley Core, not Discovery Engine.
- Avoid casual card redesigns.

## Current known gaps

- Discovery Engine Cluster / SHG / Producer filters are pending.
- Archive pagination strategy still needs cross-archive review.
- Product archive/shop-loop consistency still needs a separate phase.
- Cleanup is still needed before broad new module development.

## Working style

- Review repo/source status before changes.
- Use source files for GitHub updates.
- Never upload ZIPs/media/screenshots/videos to GitHub.
- Keep steps small and sequential.
- Do not say done without verification.
