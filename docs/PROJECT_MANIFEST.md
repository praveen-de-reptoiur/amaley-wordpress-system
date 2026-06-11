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
| Amaley Brand Site Kit | v1.0.4 future-safe lock | Global brand tokens and Elementor/WordPress design support |
| Amaley Core | v1.0.99.5 | Data backbone, CPTs, origin mapping and OG card systems |
| Amaley Discovery Engine | **v1.6.2 clean stable** | Shop, product-filter, CTA and contact-page Elementor widgets |
| Amaley Blog System | **v1.4.7 audit safe** | Blog archive and single blog Elementor system |
| Amaley Page Assignment Bridge | v1.4.1 final single product bridge | Single product page assignment bridge |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Header/footer templates and assignment rules |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell |
| Amaley UI Sections Kit | v0.6.1 | Home and page section widgets |
| Amaley Compact Widgets | v0.4.18 final tested | Manual/static compact widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

---

## Amaley Blog System Current Lock

```text
Source path: plugins/amaley-blog-system/
Version: v1.4.7 — Audit Safe Baseline
```

Active Elementor widgets:

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

Accepted page flow:

```text
Blogs page → Archive Hero → Archive Layout
Single post URL → Blog router → Blog Detail Template → Single Hero → Single Article Layout
```

Setup notes:

```text
WordPress Admin → Amaley Blog
Blog Listing Page → Blogs
Single Blog Template Page → Blog Detail Template
Settings → Reading → Posts page stays blank / Select
```

Reference docs:

```text
docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md
plugins/amaley-blog-system/README.md
plugins/amaley-blog-system/README-v1.4.7-AUDIT-SAFE.txt
```

Future Blog System work starts from v1.4.7 Audit Safe source in `plugins/amaley-blog-system/`.

---

## Amaley Discovery Engine Current Lock

```text
Source path: plugins/amaley-discovery-engine/
Version: v1.6.2 — Clean Stable Baseline
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

Future Discovery Engine work must start from v1.6.2 only.

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

```text
Source path: plugins/amaley-compact-widgets/
Version: v0.4.18 — Dual Heading + Non-Dual Alignment System Reset
```

Current accepted behaviour:

- `Amaley Dual Section Heading` is the approved reusable section-heading widget.
- Dual Heading is a dedicated heading-only widget with no card/grid/repeater controls.
- Existing compact widgets remain manual/static visual widgets.
- Non-dual compact widgets separate Header Alignment, Card Text Alignment and Button Alignment.
- Old broad Overall Alignment was removed from non-dual widgets because it caused cross-control alignment conflicts.
