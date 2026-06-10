# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

## Mandatory first read

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`
4. `docs/PROJECT_MANIFEST.md`
5. `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md`
6. `docs/AMALEY_CORE_CURRENT_STATUS_v1.0.99.5.md`
7. `docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md`
8. `plugins/amaley-core/OG_PRODUCT_PRICE_STACK_FIX_v1.0.99.5.md`
9. `plugins/amaley-page-assignment-bridge/README.md`

## Current locked source status

| Plugin / Module | Current source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.99.5 | Data backbone, product-origin mapping, CPT archive/single sections, universal OG cards, and accepted OG Product Card price stack fix |
| Amaley Discovery Engine | **v1.6.2 clean stable** | Current shop/filter/CTA/contact Elementor widgets with full controls, responsive layout controls, mobile drawer, AJAX filtering, sort and pagination |
| Amaley Page Assignment Bridge | v1.4.1 | Final tested single product page assignment bridge; active on All Products; Elementor bridge widgets and editor preview context working |
| Amaley Brand Site Kit | v1.0.4 | Global brand tokens and safe Elementor color/font support |
| Amaley H/F Studio V2 | v2.0.15 | Header/footer template workflow |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other |
| Amaley Compact Widgets | v0.4.18 final tested | Manual/static compact widgets; approved Dual Section Heading and fixed non-dual alignment system |
| Amaley Templates | v1.2.7 | WooCommerce/page template support; not edited for the bridge |

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

Retired legacy widgets must not be restored:

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

Accepted Discovery Engine behaviour:

- Collection Product Filter uses current full-control widget architecture.
- Product card visuals remain OG Product Card flow rendered through Amaley Core.
- Mobile/tablet filter drawer must work in frontend and Elementor preview.
- Mobile toolbar must support Filter + Sort in a responsive row.
- Quick pills/category chips can be hidden device-wise.
- Shop Hero, Shop Strip, Universal CTA and Contact widgets must remain reusable Elementor-native widgets.
- Contact widgets support multiple contact lines, map by address/embed/shortcode/image and Contact Form CTA by built-in demo form/shortcode/custom embed.

Discovery Engine safety:

```text
No WooCommerce cart/checkout/order logic changes.
No product data changes.
No product image/gallery changes.
No product-origin mapping changes.
No header/footer source changes.
No broad global CSS.
No legacy widget files or registrations.
```

Future Discovery Engine work must start from v1.6.2 only. Do not use old v1.4.x or v1.5.x patch packages as current source.

## Compact Widgets lock

Amaley Compact Widgets v0.4.18 is the accepted source baseline.

Accepted behaviour:

- `Amaley Dual Section Heading` is approved for reusable site-wide section headings.
- Dual Heading must remain a dedicated heading-only widget.
- Do not add card/grid/repeater controls to Dual Heading.
- Old non-dual compact widgets use separate Header Alignment, Card Text Alignment and Button Alignment controls.
- Do not bring back the old broad Overall Alignment control.
- Do not use `v0.4.14`, `v0.4.15`, `v0.4.16` or `v0.4.17` as final.
- Compact Widgets must not change WooCommerce, product data/photos/mapping, header/footer, cart/checkout or templates.

Reference docs:

```text
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
```

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

## Single Product lock

Amaley Page Assignment Bridge v1.4.1 is the accepted source for Single Product layout assignment.

Accepted flow:

```text
WooCommerce product URL
→ Amaley Page Assignment Bridge
→ Assigned Elementor page: Amaley Single Product
→ Bridge widgets render with current product context
```

Final assigned Elementor page widget order:

```text
1. Amaley Bridge Product Hero
2. Amaley Bridge Trust Strip
3. Amaley Bridge Info Tabs
4. Amaley Bridge Member Value Strip
```

Accepted behaviour:

- Bridge mode has been tested on All Products.
- Editor preview product context works on the assigned Elementor page.
- Product Hero, Trust Strip, Info Tabs and Member Value Strip are Elementor-native Bridge widgets.
- Origin details are shown inside Info Tabs → Origin.
- Separate Origin Panel widget is optional and not part of the final single product page order.
- Member Value Strip uses repeater tiles for add/remove/reorder.
- WooCommerce remains the source for product data, price, stock, cart, checkout and reviews.

Safety:

```text
No product data changes.
No product image/gallery changes.
No origin mapping changes.
No WooCommerce cart/checkout/order logic changes.
No Amaley Core source changes.
No Amaley Templates source changes.
No header/footer source changes.
```

Rollback:

```text
Amaley Bridge → Single Product Assignment → Enable Single Product Bridge: Off
```

or deactivate Amaley Page Assignment Bridge.

## Elementor stability lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during universal-card work.

## Working style

- Review repo/source status before changes.
- Use source files for GitHub updates.
- Never upload ZIPs/media/screenshots/videos to GitHub.
- Keep steps small and sequential.
- Do not say done without verification.
- Do not update GitHub/repo without Praveen's approval.
