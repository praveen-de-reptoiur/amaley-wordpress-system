# Amaley Plugin Widget Registry and Conflict Rules

Status: Active architecture lock  
Owner: Praveen  
Last updated: 2026-06-01

This document is the source of truth for where Amaley widgets, sections, shortcodes, CSS and PHP classes should live. Do not add new widgets randomly without checking this registry first.

---

## Core rule

Each plugin must own one clear responsibility. Do not duplicate widgets, shortcodes, CSS prefixes, Elementor widget names or PHP classes across plugins.

GitHub must stay clean source only. Do not commit ZIP files, backups, media dumps, videos, screenshots, passwords, `wp-config.php` files or All-in-One Migration archives.

---

## Required companion locks

Read these before creating or changing any CPT-driven archive, single page, section widget, spacing system or Elementor template:

```text
docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md
docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md
```

Current approved spacing reference:

```text
Amaley Section Spacing Rhythm 1
```

Approved implementation reference:

```text
Amaley Core v1.0.46 — Cluster Single Spacing Rhythm Polish
```

---

## Preview requirement lock

Every new Amaley widget, section, Elementor element, shortcode layout, plugin module or visual component must be delivered with a visual preview/mockup before the user is asked to install or test it.

Required for every new visual build:

1. A preview image/mockup showing the expected desktop layout.
2. A preview image/mockup or clear responsive preview showing phone behaviour.
3. A short note explaining what the preview represents.
4. The plugin ZIP/source deliverable only after the preview direction is clear.

Do not provide plugin ZIP/code alone for visual widgets. Preview is mandatory.

---

## Plugin ownership map

| Plugin | Owns | Must not own |
|---|---|---|
| Amaley Core | CPTs, cluster data, SHG data, member/producer data, product-origin mapping, CPT/meta/data-backed cards, CPT archive sections, CPT single sections, rich Cluster Story, and origin/traceability context blocks | Product discovery filters, header/footer, checkout/cart, generic homepage UI sections |
| Amaley Discovery Engine | Product/content discovery, filters, search, sort, pagination, result grids, topbar filters | Generic homepage widgets, CPT card design ownership, header/footer, cart/checkout |
| Amaley Templates | Single product, shop page, product template modules, product-page trust strip, shop discovery wrapper | General page hero trust strip, CPT data management, Discovery Engine filter logic |
| Amaley Site Shell | Header, footer, mobile drawer, site shell shortcodes/widgets | Content sections, product cards, discovery filters, CPT cards |
| Amaley UI Sections Kit | General reusable page/homepage visual sections only: Home Hero V6, Page Trust Strip, Pages Hero Other and foundation UI components | CPT-specific cards, Discovery filters, header/footer, WooCommerce templates, origin data management, compact card libraries |
| Amaley Compact Widgets | Generic compact visual card/section widgets for manual/static page building: info cards, split editorial, values, process, purpose, map-style origin section, image/flip cards, CTA/metric tiles | CPT/meta/data logic, Discovery filters, header/footer, WooCommerce templates, Home Hero V6, Page Trust Strip, Pages Hero Other |

---

## Locked decisions

### CPT-related widgets belong in Amaley Core

All cards, sections, listings and display elements connected to these data types must be built inside Amaley Core:

- Clusters
- SHG Groups
- SHG Members
- Producers / Makers
- Product Origin Mapping
- Cluster story cards and sections
- SHG cards and sections
- Member/maker cards and sections
- Origin traceability sections
- Cluster-linked product context blocks
- CPT-driven archive sections
- CPT-driven single sections

Reason: these elements depend on the same CPT/meta/data backbone. Keeping them in Amaley Core prevents confusion and avoids duplicate logic across plugins.

### Section-wise CPT pages are final workflow

CPT archive and single pages must use separate section widgets.

Final scalable workflow:

```text
One page template + multiple Amaley Core section widgets.
```

All-in-one widgets may remain only as legacy, fallback, migration or quick-test helpers. They must not become the final production editing method.

### Spacing rhythm is locked

All future Amaley website sections should follow:

```text
Amaley Section Spacing Rhythm 1
```

Existing loose sections should be updated later to match this rhythm.

Spacing problems must be solved through shared rhythm defaults and spacing controls, not by merging sections into one hardcoded block.

### Discovery Engine must not be touched casually

Amaley Discovery Engine already owns important filter/listing sections. Do not edit or replace it during normal UI section work.

Only touch Discovery Engine when the task is specifically about filters, search, sort, pagination, result rendering, discovery layout or a Discovery Engine bug fix.

### UI Sections Kit stays generic and hero-focused

UI Sections Kit should only contain generic reusable visual page sections that do not depend on CPT data, especially locked heroes and foundation components.

Allowed examples:

- Page Trust Strip
- Home Hero V6
- Pages Hero Other
- Section heading/button/foundation UI helpers
- Gifting CTA
- Newsletter CTA
- General testimonial strip
- General brand promise sections

Not allowed in UI Sections Kit:

- Cluster cards
- SHG cards
- Member/maker cards connected to CPTs
- Origin traceability data sections
- Discovery filters
- Header/footer
- Product template overrides
- Compact card libraries now owned by Amaley Compact Widgets

### Compact Widgets owns manual compact sections

Amaley Compact Widgets is the locked home for manual/static compact page sections and card-based widgets that are not CPT-driven.

Allowed examples:

- Info Cards Grid
- Split Editorial Section
- Traceability Journey used as a static visual section only
- Origin Map Path used as a static homepage origin/map-style section only
- Gifting / Bulk Band
- Feature / Value Strip
- Process Steps
- Origin Story Cards when manual/static
- Purpose Cards
- Collection Cards when manual/static
- Two Panel Info
- Dark Chain Cards
- Image Flip Cards
- Image Cards
- Image Info Cards
- Image Overlay Cards
- Quote Cards
- CTA Tiles
- Metric Tiles

Not allowed in Compact Widgets:

- CPT/meta/data fetching
- Product discovery/filter logic
- WooCommerce template overrides
- Header/footer/site shell logic
- Home Hero V6, Page Trust Strip or Pages Hero Other

### Templates plugin stays product/shop-template focused

Amaley Templates owns product and shop page template modules only. Do not use Templates plugin for generic homepage/page sections.

### Site Shell owns header/footer only

No other plugin should create Amaley header/footer/mobile drawer widgets or shortcodes.

---

## Current known widgets and shortcodes

### Amaley UI Sections Kit

Current accepted plugin build: v0.6.1 performance and conditional asset loading cleanup. Home Hero V6 remains locked at v0.5.4 visual state. Page Trust Strip remains locked at v0.3.7 visual state. Pages Hero Other remains accepted at v0.6.0 visual/control state and uses v0.6.1 conditional loading.

Accepted/locked shortcodes:

- `[amaley_page_trust_strip]`
- `[amaley_home_hero_v6]`
- `[amaley_pages_hero_other]`

Accepted Elementor widgets:

- Amaley UI > Amaley Page Trust Strip
- Amaley UI > Amaley Home Hero V6
- Amaley UI > Amaley Pages Hero Other

### Amaley Compact Widgets

Current active accepted ZIP: v0.4.2.  
Current GitHub source: v0.4.3 with Origin Map Path added.  
Status: v0.4.3 source is ready for ZIP build and staging/dry-test before replacing the Drive active ZIP.

Elementor category:

- Amaley Compact

Locked / current shortcodes:

- `[amaley_cw_info_cards]`
- `[amaley_cw_split_editorial]`
- `[amaley_cw_traceability]`
- `[amaley_cw_origin_map]`
- `[amaley_cw_gifting_band]`
- `[amaley_cw_value_strip]`
- `[amaley_cw_process_steps]`
- `[amaley_cw_origin_cards]`
- `[amaley_cw_purpose_cards]`
- `[amaley_cw_collection_cards]`
- `[amaley_cw_two_panel_info]`
- `[amaley_cw_dark_chain]`
- `[amaley_cw_image_flip_cards]`
- `[amaley_cw_image_cards]`
- `[amaley_cw_image_info_cards]`
- `[amaley_cw_image_overlay_cards]`
- `[amaley_cw_quote_cards]`
- `[amaley_cw_cta_tiles]`
- `[amaley_cw_metric_tiles]`

Current widgets:

1. Amaley Info Cards Grid
2. Amaley Split Editorial Section
3. Amaley Traceability Journey
4. Amaley Origin Map Path
5. Amaley Gifting / Bulk Band
6. Amaley Feature / Value Strip
7. Amaley Process Steps
8. Amaley Origin Story Cards
9. Amaley Purpose Cards
10. Amaley Collection Cards
11. Amaley Two Panel Info
12. Amaley Dark Chain Cards
13. Amaley Image Flip Cards
14. Amaley Image Cards
15. Amaley Image Info Cards
16. Amaley Image Overlay Cards
17. Amaley Quote Cards
18. Amaley CTA Tiles
19. Amaley Metric Tiles

Compact Widgets v0.4.3 source notes:

- Adds Amaley Origin Map Path for the homepage.
- Adds `[amaley_cw_origin_map]` shortcode.
- Adds static CSS map board with route markers, label cards, route caption, right-side journey list and CTA.
- No frontend JavaScript.
- No external libraries.
- CSS scope must remain `.amaley-cw4-*` and `.amaley-cw4-origin-map-path*`.
- No CPT/meta/data fetching, Discovery Engine, WooCommerce template, header/footer or Site Shell change.

### Amaley Discovery Engine

Known responsibility:

- `[amaley_discovery]`
- Product discovery widget
- Collection discovery widget
- Cluster discovery widget
- SHG discovery widget
- Member discovery widget
- Product/Collection/Cluster/SHG/Member topbar widgets
- Existing Elementor Section Heading and Icon List widgets

Important: because Section Heading and Icon List already exist in Discovery Engine, do not create duplicate Elementor widgets with the same names in UI Sections Kit or Compact Widgets.

### Amaley Templates

Known widgets:

- Product Hero
- Origin Panel
- Info Tabs
- Product Trust Strip
- Shop Hero
- Shop Discovery
- Member Value Strip

Important: Product Trust Strip in Templates is separate from Page Trust Strip in UI Sections Kit.

### Amaley Site Shell

Shortcodes:

- `[amaley_site_header]`
- `[amaley_site_footer]`

Elementor widgets:

- Header widget
- Footer widget

### Amaley Core

Current source: v1.0.46.

Current role:

- CPT backbone
- Cluster, SHG, member/producer and product-origin mapping
- Explicit Cluster → SHG/Producer Group linking
- Rich Cluster Full Story editor support
- CPT-driven cards, archive sections and single sections
- Approved Cluster Single spacing rhythm reference

Active / current Cluster widgets and sections include:

1. Cluster Archive Hero
2. Cluster Archive Trust Strip
3. Cluster Archive Intro
4. Cluster Archive Grid
5. Cluster Archive CTA
6. Cluster Single Hero
7. Cluster Single Snapshot / Quick Details
8. Cluster Single Story
9. Cluster Single SHGs / Women Collectives
10. Cluster Single Producers / People
11. Cluster Single Products
12. Cluster Single Gallery
13. Cluster Single Contact
14. Cluster Single CTA
15. Cluster Card widgets / shortcodes where present
16. SHG Card widgets / shortcodes where present
17. Member / Producer Card widgets / shortcodes where present
18. Product Origin Panel where present

Next CPT build phase inside Amaley Core:

1. SHG Group Single section widgets using the locked structure and spacing rhythm
2. Member / Producer Single section widgets using the locked structure and spacing rhythm
3. SHG Group Archive section widgets
4. Member / Producer Archive section widgets
5. Product-origin traceability panel refinement

---

## Future build list by plugin

### Build in Amaley Core next

1. Complete product mapping review after v1.0.46.
2. SHG Group Single section widgets.
3. Member / Producer Single section widgets.
4. SHG Group Archive section widgets.
5. Member / Producer Archive section widgets.
6. Product-origin traceability panel refinement.

### Build in Amaley Compact Widgets after v0.4.3

Only focused refinements or new manual compact visual widgets. Any addition requires preview and dry test before plugin ZIP/source delivery.

### Build in Amaley UI Sections Kit after v0.6.1

Only focused refinements to locked UI foundation, Home Hero V6, Page Trust Strip or Pages Hero Other. Do not add compact card libraries here.
