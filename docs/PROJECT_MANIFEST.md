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
| Amaley Core | v1.0.99.4 | Data backbone, product-origin mapping, explicit Cluster → SHG/Producer Group links, rich story editors, gallery/media fields, CPT archive/single widgets, approved universal OG cards, card selectors/control bridges and origin-led section widgets |
| Amaley Discovery Engine | v1.4.4 stable OG card controls | Discovery, filters, listings, search, sort, pagination, source-level OG Product Card 1 renderer, selected OG product-card controls and collection-grid workflow |
| Amaley H/F Studio V2 | v2.0.15 pre-lock safety | Elementor-style header/footer templates, assignment rules, live-style header/footer widgets, mobile drawer and section-wise full-control workflow |
| Amaley Site Shell | v1.0.1 retired/on hold | Old header/footer shell; do not activate alongside Amaley H/F Studio V2 |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact visual widgets; v0.4.2 active ZIP may remain until v0.4.3 staging test |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

---

## Elementor Stability Lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during the universal-card work. After deactivation, controls started working again.

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
v1.3.7, v1.3.8, v1.3.9, v1.4.0, v1.4.1, v1.4.2, v1.4.3 rollback packages
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
- Admin CSS/fonts load only on the Amaley Brand Kit admin page.
- No CPT, WooCommerce data, product price, product stock, order, cart, checkout, header/footer, template or page-content logic is changed.

Rejected / unused:

```text
v1.0.3 — Elementor Force Sync Fix
```

Reason: v1.0.2 sync worked correctly after proper button use; v1.0.4 is the safer continuation.

---

## Amaley H/F Studio V2 Current Lock

Current source path:

```text
plugins/amaley-hf-studio-v2/
```

Current pre-lock version:

```text
v2.0.15 — Pre-Lock Safety
```

Current accepted behaviour:

- Header and footer render on staging without old H/F plugins active.
- Old `Amaley H/F` and `Amaley Site Shell` must remain inactive/deleted to avoid double-render conflicts.
- Header/footer templates are created through the plugin and edited with Elementor.
- Header and footer can be assigned as default templates.
- Header widget includes WordPress menu selection, top strip repeater, hide/show controls, layout/style controls, typography controls, phone controls, live-style mobile drawer, and header layout/spacing controls.
- Footer widget includes section-wise brand/shop/ecosystem/contact/bottom-bar content controls, repeaters, hide/show controls, layout/style controls, typography controls, and mobile two-column controls.
- Theme hiding remains OFF by default and should only be tested after baseline is stable.
- No output buffering should be used.
- Rendering should stay hook-based and conflict-safe.

Important scope lock:

```text
H/F Studio is only for header and footer.
```

Global colors, fonts, design tokens, Elementor Kit sync and WordPress editor palette sync belong to Amaley Brand Site Kit, not H/F Studio.

---

## Latest Amaley Core Locks

Current Amaley Core v1.0.99.4 includes:

```text
v1.0.41   — Explicit Cluster → SHG/Producer Group linking
v1.0.45   — Cluster Full Story rich editor direction
v1.0.46   — Cluster Single spacing rhythm polish
v1.0.74   — SHG archive/single polish, gallery/media fields, section-level buttons, controls and card-design locks
v1.0.82.2 — Accepted Cluster Single card visual polish
v1.0.89   — Accepted Cluster Single OG card visibility/control work
v1.0.91   — Accepted Cluster Single no-reload pagination
v1.0.92.4 — Accepted Member Single OG card controls
v1.0.95   — SHG Single pagination clean safe
v1.0.96   — Member Single Products pagination
v1.0.97.5 — Cluster Archive existing controls mapped to OG Cluster Card 1
v1.0.97.6 — Universal Product Card PRICE label/value readability fix
v1.0.98.1 — SHG Archive OG controls selector fix
v1.0.99.4 — Member Archive OG Member Card 1 hide/show and style-control bridge
```

Relation source of truth meta key:

```text
_amaley_cluster_linked_group_ids
```

Admin edit box:

```text
Amaley Linked Producer Groups / SHGs
```

Expected frontend behaviour:

- Quick Details → SHGs count follows selected groups.
- SHG cards follow selected groups.
- People / Producer sections follow linked SHGs/producers.
- Story sections read rich story content from CPT records where implemented.
- Gallery sections use media/gallery fields where implemented.
- Mapped Products sections use WooCommerce product origin mapping.
- CPT sections follow the approved compact spacing rhythm.
- Card designs remain consistent across pages and contexts.
- Archive/single widgets use universal OG card families where connected.

---

## Current Architecture / Visual Locks

### `docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md`

Locks archive/single pages as section-wise systems using multiple Amaley Core section widgets.

### `docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md`

Locks `Amaley Section Spacing Rhythm 1` as the approved spacing density for future Amaley sections and later updates to existing loose sections.

### `docs/AMALEY_CARD_DESIGN_LOCK.md`

Locks the approved Cluster, SHG / Producer Group, Member / Producer and Product card families so the same card type stays visually consistent across the site.

Universal OG card flow:

```text
image / initials placeholder → label → title → description → meta/stat boxes → tags/chips → full-width rounded button
```
