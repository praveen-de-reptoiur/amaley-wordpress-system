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
| Amaley Discovery Engine | **v1.6.2 clean stable** | Current Elementor-native shop, product-filter, CTA and contact-page widgets with clean full controls, responsive layout controls, mobile drawer, AJAX filtering, sort and pagination |
| Amaley Page Assignment Bridge | v1.4.1 final single product bridge | Safe Elementor page-assignment bridge for WooCommerce single product pages; active/tested on All Products; owns single product page assignment and Bridge widgets only |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Elementor-style header/footer templates, assignment rules, live-style header/footer widgets, mobile drawer and section-wise full-control workflow |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell; do not activate alongside Amaley H/F Studio V2 |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.18 final tested | Manual/static compact visual widgets; includes approved Dual Section Heading and fixed non-dual widget alignment controls |
| Amaley Templates | v1.2.7 | WooCommerce/page template support; not edited for the Page Assignment Bridge |

---

## Amaley Discovery Engine Current Lock

Current source path:

```text
plugins/amaley-discovery-engine/
```

Current version:

```text
v1.6.2 — Clean Stable Baseline
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

Retired legacy widgets are not part of the current baseline:

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

Current accepted scope:

```text
- Elementor-native full-control widget architecture
- Shop hero and shop strip widgets
- Universal CTA widget
- Contact hero, contact info cards, contact map and contact form CTA widgets
- Collection Product Filter with mobile drawer, AJAX filtering, sort and pagination
- OG Product Card rendering remains handled through Amaley Core
```

Safety lock:

```text
No WooCommerce cart/checkout/order logic changes.
No product data changes.
No product image/gallery changes.
No product-origin mapping changes.
No header/footer source changes.
No broad global CSS.
No legacy Discovery widgets.
No ZIP/media/screenshots/videos committed to GitHub.
```

Future Discovery Engine work must start from v1.6.2 only. Do not use old v1.4.x, v1.5.x patch files or retired legacy widget files as a baseline.

Reference doc:

```text
docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md
```

---

## Elementor Stability Lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during the universal-card work. After deactivation, controls started working again.

---

## Amaley Compact Widgets Current Lock

Current source path:

```text
plugins/amaley-compact-widgets/
```

Current version:

```text
v0.4.18 — Dual Heading + Non-Dual Alignment System Reset
```

Current accepted behaviour:

- `Amaley Dual Section Heading` is the approved reusable section-heading widget.
- Dual Heading is a dedicated heading-only widget with no card/grid/repeater controls.
- Dual Heading supports kicker, dual heading text, accent text, description, HTML tag, alignment, spacing, typography and show/hide controls.
- Existing compact widgets remain manual/static visual widgets.
- Non-dual compact widgets now separate alignment behaviour clearly:
  - Header Alignment controls only heading/kicker/title/description.
  - Card Text Alignment controls cards/items.
  - Button Alignment controls section/card action rows where applicable.
- Old broad Overall Alignment was removed from non-dual widgets because it caused cross-control alignment conflicts.
- Elementor live-preview alignment was retested after the v0.4.18 fix.
- Columns responsive control no longer depends on inline column variables that override Elementor responsive selectors.

Safety scope:

```text
No WooCommerce cart/checkout/template override.
No product data changes.
No product image/gallery changes.
No product-origin mapping changes.
No header/footer changes.
```
