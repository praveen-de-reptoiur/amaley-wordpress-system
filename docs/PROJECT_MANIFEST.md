# PROJECT MANIFEST — Amaley WordPress System

This manifest is the project index for the Amaley WordPress system.

---

## Repository

```text
praveen-de-reptoiur/amaley-wordpress-system
```

---

## GitHub Role

GitHub is used for source code, documentation, version history, migration planning, QA notes, and developer handoff notes.

GitHub is not used for heavy backup files, media, screenshots, videos, plugin ZIPs, `.wpress` backups, or secrets.

---

## Google Drive Role

Google Drive is used for plugin ZIP backups, full website backups, Elementor exports, WooCommerce exports, product images, screenshots, videos, and handoff packages.

---

## Current Locked Source Versions

| Plugin / Module | Current Source | Role |
| --- | --- | --- |
| Amaley Brand Site Kit | v1.0.4 future-safe lock | Global brand tokens, Elementor color/font sync, WordPress editor palette sync, CSS variables and optional scoped visual bridges |
| Amaley Core | v1.0.99.5 | Data backbone, product-origin mapping, explicit Cluster → SHG/Producer Group links, rich story editors, gallery/media fields, CPT archive/single widgets, approved universal OG cards, card selectors/control bridges, origin-led section widgets and accepted OG Product Card price stack fix |
| Amaley Discovery Engine | v1.4.4 stable OG card controls | Discovery, filters, listings, search, sort, pagination, source-level OG Product Card 1 renderer, selected OG product-card controls and collection-grid workflow |
| Amaley Page Assignment Bridge | v1.4.1 final single product bridge | Safe Elementor page-assignment bridge for WooCommerce single product pages; active/tested on All Products; owns single product page assignment and Bridge widgets only |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Elementor-style header/footer templates, assignment rules, live-style header/footer widgets, mobile drawer and section-wise full-control workflow |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell; do not activate alongside Amaley H/F Studio V2 |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact visual widgets; v0.4.2 active ZIP may remain until v0.4.3 staging test |
| Amaley Templates | v1.2.7 | WooCommerce/page template support; not edited for the Page Assignment Bridge |

---

## Elementor Stability Lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during the universal-card work. After deactivation, controls started working again.

---

## Amaley Page Assignment Bridge Current Lock

Current source path:

```text
plugins/amaley-page-assignment-bridge/
```

Current version:

```text
v1.4.1 — Single Product Final / Member Value Controls Fix
```

Current accepted behaviour:

- Assigns a normal Elementor page as the WooCommerce single product layout.
- Accepted assigned page: `Amaley Single Product`.
- Final page order: Product Hero, Trust Strip, Info Tabs, Member Value Strip.
- Editor preview product context works for the assigned Elementor page.
- Bridge mode has been tested on All Products.
- Origin details are shown inside Info Tabs → Origin.
- Member Value Strip uses Elementor repeater tiles for add/remove/reorder.
- WooCommerce remains the source for product data, price, stock, cart, checkout and reviews.

Safety scope:

```text
No product data changes.
No product image/gallery changes.
No origin mapping changes.
No WooCommerce cart/checkout/order logic changes.
No Amaley Core source changes.
No Amaley Templates source changes.
No Amaley Discovery Engine source changes.
No header/footer source changes.
```

Rollback:

```text
Amaley Bridge → Single Product Assignment → Enable Single Product Bridge: Off
```

or deactivate `Amaley Page Assignment Bridge`.

---

## Amaley Core Current Lock

Current source path:

```text
plugins/amaley-core/
```

Current version:

```text
v1.0.99.5 — OG Product Card Price Stack Fix Merged
```

Current accepted behaviour:

- OG Product Card price layout belongs to Amaley Core, not Discovery Engine.
- Old price is displayed smaller with strikethrough.
- Sale price is displayed on the next line, bold and readable.
- Temporary helper plugin `Amaley Core OG Product Price Stack Fix` can remain deactivated after confirming Core v1.0.99.5 is active.
- Product data, product images/gallery, product-origin mappings, Discovery Engine filters/pagination/sort, WooCommerce templates, header and footer were not changed.

Important rejection / do-not-use note:

```text
Discovery Engine v1.4.5 price-layout fix should not be used as the final solution.
Price/card visual fixes must remain in Amaley Core.
```

---

## Amaley Discovery Engine Current Lock

Current source path:

```text
plugins/amaley-discovery-engine/
```

Current version:

```text
v1.4.4 — Full OG Product Card Controls Tested
```

Current accepted behaviour:

- Product Discovery uses source-level `Amaley Core Product Card — Select Template` support.
- Accepted card template is `OG Product Card 1` from Amaley Core.
- Product grid, filters, sorting, reset and pagination return the selected OG product card consistently.
- Elementor controls are section-wise and non-coder-friendly.
- Content tab owns the selected OG product-card content controls.
- Style tab owns section/heading, filters/toolbar, grid/spacing, selected OG product-card layout/text/meta/tags/button and pagination controls.
- Product data, product photos/gallery, product-origin mappings, WooCommerce templates, header and footer were not changed.

Rejected / not-to-use versions:

```text
v1.3.7, v1.3.8, v1.3.9, v1.4.0, v1.4.1, v1.4.2, v1.4.3 rollback packages, v1.4.5 price-layout fix
```

Previous working base:

```text
v1.3.6 — Core card source fix
```

Next pending source-level Discovery work:

```text
Cluster / SHG-Collective / Producer-Member filters, added one by one after v1.4.4 remains stable.
```

---

## Amaley Brand Site Kit Current Lock

Current source path:

```text
plugins/amaley-brand-site-kit/
```

Current version:

```text
v1.0.4 — Future-Safe Lock
```

Current accepted behaviour:

- Elementor color/font sync remains manual and reversible.
- Elementor Kit backup is created before sync.
- WordPress editor palette sync is available.
- Global frontend bridge is OFF by default.
- WooCommerce visual bridge is OFF by default.
- Elementor visual bridge is OFF by default.
- Existing installs are migrated once to switch broad visual bridges OFF.
