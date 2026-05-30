# Amaley Plugin Widget Registry and Conflict Rules

Status: Active architecture lock  
Owner: Praveen  
Last updated: 2026-05-30

This document is the source of truth for where Amaley widgets, sections, shortcodes, CSS and PHP classes should live. Do not add new widgets randomly without checking this registry first.

## Core rule

Each plugin must own one clear responsibility. Do not duplicate widgets, shortcodes, CSS prefixes, Elementor widget names or PHP classes across plugins.

GitHub must stay clean source only. Do not commit ZIP files, backups, media dumps, videos, screenshots, passwords, wp-config files or All-in-One Migration archives.

## Preview requirement lock

Every new Amaley widget, section, Elementor element, shortcode layout, plugin module or visual component must be delivered with a visual preview/mockup before the user is asked to install or test it.

Required for every new visual build:

1. A preview image/mockup showing the expected desktop layout.
2. A preview image/mockup or clear responsive preview showing phone behaviour.
3. A short note explaining what the preview represents.
4. The plugin ZIP/source deliverable only after the preview direction is clear.

Do not provide plugin ZIP/code alone for visual widgets. Preview is mandatory.

## Plugin ownership map

| Plugin | Owns | Must not own |
|---|---|---|
| Amaley Core | CPTs, cluster data, SHG data, member/producer data, product-origin mapping, and all CPT-related cards/sections/widgets | Product discovery filters, header/footer, checkout/cart, generic homepage UI sections |
| Amaley Discovery Engine | Product/content discovery, filters, search, sort, pagination, result grids, topbar filters | Generic homepage widgets, CPT card design ownership, header/footer, cart/checkout |
| Amaley Templates | Single product, shop page, product template modules, product-page trust strip, shop discovery wrapper | General page hero trust strip, CPT data management, Discovery Engine filter logic |
| Amaley Site Shell | Header, footer, mobile drawer, site shell shortcodes/widgets | Content sections, product cards, discovery filters, CPT cards |
| Amaley UI Sections Kit | General reusable page/homepage visual sections only: Home Hero V6, Page Trust Strip, Pages Hero Other and foundation UI components | CPT-specific cards, Discovery filters, header/footer, WooCommerce templates, origin data management, compact card libraries |
| Amaley Compact Widgets | Generic compact visual card/section widgets for manual/static page building: info cards, split editorial, values, process, purpose, image/flip cards, CTA/metric tiles | CPT/data logic, Discovery filters, header/footer, WooCommerce templates, Home Hero V6, Page Trust Strip, Pages Hero Other |

## Locked decisions

### CPT-related widgets belong in Amaley Core

All cards, sections, listings and display elements connected to these data types must be built inside Amaley Core:

- Clusters
- SHG Groups
- SHG Members
- Producers / Makers
- Product Origin Mapping
- Cluster story cards
- SHG cards
- Member/maker cards
- Origin traceability sections
- Cluster-linked product context blocks

Reason: these elements depend on the same CPT and ACF/data backbone. Keeping them in Amaley Core prevents confusion and avoids duplicate logic across plugins.

### Discovery Engine must not be touched casually

Amaley Discovery Engine already owns important filter/listing sections. Do not edit or replace it during normal UI section work.

Only touch Discovery Engine when the task is specifically about filters, search, sort, pagination, result rendering, discovery layout or a Discovery Engine bug fix.

Before touching it, check for conflict with UI Sections Kit, Templates and Core.

### UI Sections Kit stays generic and hero-focused

UI Sections Kit should only contain generic, reusable visual page sections that do not depend on CPT data, especially locked heroes and foundation components.

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

- ACF/CPT data fetching
- Product discovery/filter logic
- WooCommerce template overrides
- Header/footer/site shell logic
- Home Hero V6, Page Trust Strip or Pages Hero Other

### Templates plugin stays product/shop-template focused

Amaley Templates owns product and shop page template modules only. Do not use Templates plugin for generic homepage/page sections.

### Site Shell owns header/footer only

No other plugin should create Amaley header/footer/mobile drawer widgets or shortcodes.

## Current known widgets and shortcodes

### Amaley UI Sections Kit

Current accepted plugin build: v0.6.1 performance and conditional asset loading cleanup. Home Hero V6 remains locked at v0.5.4 visual state. Page Trust Strip remains locked at v0.3.7 visual state. Pages Hero Other remains accepted at v0.6.0 visual/control state and uses v0.6.1 conditional loading.

Accepted/locked shortcodes:

- [amaley_page_trust_strip]
- [amaley_home_hero_v6]
- [amaley_pages_hero_other]

Existing foundation shortcodes:

- [amaley_section_heading]
- [amaley_button]
- [amaley_button_group]
- [amaley_trust_item]
- [amaley_trust_strip] legacy alias only
- [amaley_brand_promise]
- [amaley_cta_band]
- [amaley_empty_state]
- [amaley_product_card]
- [amaley_product_grid]

Accepted Elementor widgets:

- Amaley UI > Amaley Page Trust Strip
- Amaley UI > Amaley Home Hero V6
- Amaley UI > Amaley Pages Hero Other

Locked Page Trust Strip shortcode:

[amaley_page_trust_strip tone="cream" style="cards" columns="4" mobile="stack" motion="glow" width="contained"]

Locked Home Hero V6 shortcode:

[amaley_home_hero_v6]

Locked Pages Hero Other shortcode:

[amaley_pages_hero_other]

Home Hero V6 notes:

- Based on the live HTML hero structure supplied by Praveen.
- Final accepted visual version is v0.5.4.
- Right image mosaic is no-gap absolute layout.
- Default image behaviour is cover + center center.
- Image fit/focus controls must stay available in Style tab.
- Counter, medallion, buttons and image hover animation are scoped to the hero only.
- Do not patch this hero casually. Any future edit requires preview first.

UI Sections Kit v0.6.1 performance notes:

- Base UI CSS loads only when Amaley UI shortcodes/widgets are detected.
- Home Hero CSS/JS loads only when Home Hero V6 is detected.
- Pages Hero Other CSS loads only when Pages Hero Other is detected.
- Elementor editor/preview intentionally loads required assets for safe editing.

### Amaley Compact Widgets

Current accepted plugin build: v0.4.2 final accepted lock.

Elementor category:

- Amaley Compact

Locked shortcodes:

- [amaley_cw_info_cards]
- [amaley_cw_split_editorial]
- [amaley_cw_traceability]
- [amaley_cw_gifting_band]
- [amaley_cw_value_strip]
- [amaley_cw_process_steps]
- [amaley_cw_origin_cards]
- [amaley_cw_purpose_cards]
- [amaley_cw_collection_cards]
- [amaley_cw_two_panel_info]
- [amaley_cw_dark_chain]
- [amaley_cw_image_flip_cards]
- [amaley_cw_image_cards]
- [amaley_cw_image_info_cards]
- [amaley_cw_image_overlay_cards]
- [amaley_cw_quote_cards]
- [amaley_cw_cta_tiles]
- [amaley_cw_metric_tiles]

Locked widgets:

1. Amaley Info Cards Grid
2. Amaley Split Editorial Section
3. Amaley Traceability Journey
4. Amaley Gifting / Bulk Band
5. Amaley Feature / Value Strip
6. Amaley Process Steps
7. Amaley Origin Story Cards
8. Amaley Purpose Cards
9. Amaley Collection Cards
10. Amaley Two Panel Info
11. Amaley Dark Chain Cards
12. Amaley Image Flip Cards
13. Amaley Image Cards
14. Amaley Image Info Cards
15. Amaley Image Overlay Cards
16. Amaley Quote Cards
17. Amaley CTA Tiles
18. Amaley Metric Tiles

Compact Widgets v0.4.2 notes:

- Final accepted after focused repairs to OUR STORY, TRACEABILITY, GIFTING, OUR VALUES and FOR WHOM.
- Alignment controls added: Overall Content Alignment, Header Alignment, Card / Item Text Alignment and Button Row Alignment.
- No frontend JavaScript.
- No external libraries.
- CSS scope must remain `.amaley-cw4-*`.
- Do not patch casually after v0.4.2. Future changes need focused scope, preview, dry test and source-only GitHub update.

### Amaley Discovery Engine

Known responsibility:

- [amaley_discovery]
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

- [amaley_site_header]
- [amaley_site_footer]

Elementor widgets:

- Header widget
- Footer widget

### Amaley Core

Current role:

- CPT backbone
- Cluster, SHG, member/producer and product-origin mapping

Future widgets to build in Amaley Core:

1. Cluster Card widget/shortcode
2. Cluster Grid widget/shortcode
3. SHG Group Card widget/shortcode
4. SHG Group Grid widget/shortcode
5. Member / Producer Card widget/shortcode
6. Member / Producer Grid widget/shortcode
7. Origin Chain widget/shortcode
8. Product Traceability panel

## Future build list by plugin

### Build in Amaley Core

1. Cluster Card widget/shortcode
2. Cluster Grid widget/shortcode
3. SHG Group Card widget/shortcode
4. SHG Group Grid widget/shortcode
5. Member / Producer Card widget/shortcode
6. Member / Producer Grid widget/shortcode
7. Origin Chain widget/shortcode
8. Product Traceability panel

### Build in Amaley Compact Widgets only after v0.4.2

Only focused refinements or new manual compact visual widgets. Any addition requires preview and dry test before plugin ZIP/source delivery.

### Build in Amaley UI Sections Kit only after v0.6.1

Only focused refinements to locked UI foundation, Home Hero V6, Page Trust Strip or Pages Hero Other. Do not add compact card libraries here.
