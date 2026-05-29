# Amaley Plugin Widget Registry and Conflict Rules

Status: Active architecture lock  
Owner: Praveen  
Last updated: 2026-05-29

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
| Amaley UI Sections Kit | General reusable page/homepage visual sections only | CPT-specific cards, Discovery filters, header/footer, WooCommerce templates, origin data management |

## Locked decisions

### 1. CPT-related widgets belong in Amaley Core

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

### 2. Discovery Engine must not be touched casually

Amaley Discovery Engine already owns important filter/listing sections. Do not edit or replace it during normal UI section work.

Only touch Discovery Engine when the task is specifically about:

- Filters
- Search
- Sort
- Pagination
- Result rendering
- Discovery layout
- Discovery Engine bug fix

Before touching it, check for conflict with UI Sections Kit, Templates and Core.

### 3. UI Sections Kit stays generic

UI Sections Kit should only contain generic, reusable visual page sections that do not depend on CPT data.

Allowed examples:

- Page Trust Strip
- Split Editorial Section
- Editorial Hero Section
- Gifting CTA
- Newsletter CTA
- General testimonial strip
- General journal cards if they are static/manual or simple post display
- General brand promise sections

Not allowed in UI Sections Kit:

- Cluster cards
- SHG cards
- Member/maker cards connected to CPTs
- Origin traceability data sections
- Discovery filters
- Header/footer
- Product template overrides
- Cart/checkout changes

### 4. Templates plugin stays product/shop-template focused

Amaley Templates owns product and shop page template modules only. It already has product-page modules such as product hero, origin panel, info tabs, product trust strip, shop hero and shop discovery wrappers.

Do not use Templates plugin for generic homepage/page sections.

### 5. Site Shell owns header/footer only

No other plugin should create Amaley header/footer/mobile drawer widgets or shortcodes.

## Current known widgets and shortcodes

### Amaley UI Sections Kit

Current locked source version: 0.3.7 for Page Trust Strip. Editorial Hero is under review and not locked.

Shortcodes:

- [amaley_section_heading]
- [amaley_button]
- [amaley_button_group]
- [amaley_trust_item]
- [amaley_page_trust_strip]
- [amaley_trust_strip] legacy alias only
- [amaley_brand_promise]
- [amaley_cta_band]
- [amaley_empty_state]
- [amaley_product_card]
- [amaley_product_grid]

Elementor widgets:

- Amaley UI > Amaley Page Trust Strip

Locked final shortcode:

[amaley_page_trust_strip tone="cream" style="cards" columns="4" mobile="stack" motion="glow" width="contained"]

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

Important: because Section Heading and Icon List already exist in Discovery Engine, do not create duplicate Elementor widgets with the same names in UI Sections Kit.

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

- Cluster Card
- Cluster Grid / Cluster Section
- SHG Group Card
- SHG Group Grid / SHG Section
- Member / Producer / Maker Card
- Member / Producer / Maker Grid
- Product Origin Chain Block
- Product Traceability Panel
- Cluster Story Section
- SHG Story Section
- Producer Story Section
- Origin-linked product context strip

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
9. Cluster Story section
10. SHG Story section
11. Producer/Maker Story section

### Build in Amaley UI Sections Kit

1. Split Editorial Section
2. Editorial Hero Section, currently under review
3. Gifting CTA Section
4. Newsletter CTA Section
5. General Journal Cards Section if not CPT-driven
6. General Testimonials Section
7. General Brand Promise layout variants

### Keep in Amaley Discovery Engine

1. Product filters
2. Search
3. Sort
4. Pagination
5. Result cards controlled by discovery flow
6. Topbar filters
7. Any discovery/listing logic

### Keep in Amaley Templates

1. Single product page modules
2. Shop page modules
3. Product trust strip
4. Product information tabs
5. Product origin panel as product-template display

### Keep in Amaley Site Shell

1. Header
2. Footer
3. Mobile drawer
4. Site shell controls

## Naming rules

### PHP prefixes

- Amaley Core: `Amaley_Core_` and `amaley_core_`
- Amaley Discovery Engine: `Amaley_DE_` and `amaley_de_`
- Amaley Templates: `Amaley_Tpl_` and `amaley_tpl_`
- Amaley Site Shell: `Amaley_Shell_` and `amaley_shell_`
- Amaley UI Sections Kit: `Amaley_UI_` and `amaley_ui_`

### CSS prefixes

- Core CPT display: `.amaley-core-*`
- Discovery Engine: `.amaley-discovery-engine-v1*` or `.amaley-de-*`
- Templates: `.amaley-tpl-*`
- Site Shell: `.amaley-shell-*`
- UI Sections Kit: `.amaley-ui-*`

Do not use generic selectors like `.card`, `.button`, `.product`, `.grid`, `.section`, `body`, `h1`, `p`, `.woocommerce`, `.elementor-widget`, or theme classes unless explicitly scoped inside the plugin wrapper.

### Elementor widget names

Widget machine names must include the plugin namespace:

- UI Sections Kit example: `amaley_ui_page_trust_strip`
- Templates example: `amaley_tpl_trust_strip`
- Discovery Engine example: `amaley_de_product_discovery`
- Core future example: `amaley_core_cluster_card`

Never reuse an existing widget machine name.

### Shortcode names

Use clear ownership:

- UI Sections Kit: `[amaley_page_trust_strip]`, `[amaley_product_grid]`
- Core future: `[amaley_core_cluster_card]`, `[amaley_core_shg_card]`, `[amaley_core_member_card]`
- Discovery Engine: `[amaley_discovery]`
- Site Shell: `[amaley_site_header]`, `[amaley_site_footer]`

Avoid vague new shortcodes like `[amaley_card]`, `[amaley_grid]`, `[amaley_trust]`.

## Conflict-check workflow before every new widget

Before building any new widget or section:

1. Check existing plugin ownership in this document.
2. Search GitHub for the proposed PHP class name.
3. Search GitHub for the proposed shortcode name.
4. Search GitHub for the proposed Elementor widget machine name.
5. Search CSS for the proposed wrapper class.
6. Confirm no generic/global CSS selector is being introduced.
7. Confirm no WooCommerce cart/checkout/template override is being added.
8. Confirm Discovery Engine is untouched unless the task explicitly requires it.
9. Confirm no ZIP/media/backups are committed to GitHub.
10. Create or provide visual preview/mockup before plugin ZIP/code delivery.
11. Update this registry if a new widget is added.

## Do not touch unless explicitly requested

- Discovery Engine filter logic
- WooCommerce cart and checkout
- WooCommerce product template overrides
- Header/footer/mobile drawer
- Live production data
- ACF field mapping
- Existing CPT slugs
- Existing product images/gallery
- Old accepted product grid/card logic unless the task is specifically about that

## Current next safe build direction

The next UI work should be either:

1. Split Editorial Section in UI Sections Kit, if it is generic content and not CPT-linked.
2. Cluster/SHG/Member cards in Amaley Core, if the section depends on real CPT data.

Do not mix these two directions in one plugin.
