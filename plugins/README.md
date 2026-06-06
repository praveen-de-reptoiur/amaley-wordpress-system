# Amaley Plugins

This folder contains clean source code for Amaley custom WordPress plugins and future Amaley component modules.

Plugin ZIP backups stay in Google Drive. Clean source code and documentation belong in GitHub.

---

## Current Source Folder Structure

```text
plugins/
  README.md
  amaley-core/
  amaley-discovery-engine/
  amaley-site-shell/
  amaley-ui-sections-kit/
  amaley-compact-widgets/
  amaley-templates/
  amaley-project-guard/
  amaley-debug-toolkit/
```

Some future folders may remain planning-only until a real source module is approved.

---

## Current Locked Source Versions

| Plugin / Module | GitHub source status | Drive ZIP backup status |
| --- | --- | --- |
| Amaley Core | v1.0.99.4 | ZIP backup belongs in Drive only |
| Amaley Discovery Engine | v1.4.4 stable OG card controls | `amaley-discovery-engine-v1.4.4-full-og-card-controls-tested.zip` in Drive/local backup only |
| Amaley Site Shell | v1.0.1 | `amaley-site-shell-v1.0.1.zip` |
| Amaley UI Sections Kit | v0.6.1 | `amaley-ui-sections-kit-v0.6.1.zip` |
| Amaley Compact Widgets | v0.4.3 source | v0.4.2 active ZIP until v0.4.3 ZIP/staging test |
| Amaley Templates | v1.2.7 | `amaley-templates-v1.2.7.zip` |

ZIPs are backups and must not be uploaded into this GitHub folder.

---

## Current Amaley Discovery Engine v1.4.4 Lock

`plugins/amaley-discovery-engine/` is now synced to v1.4.4.

Accepted behaviour:

- Product Discovery widget renders products using source-level Amaley Core OG Product Card 1 support.
- Card renderer selector is preserved instead of hardcoding one card forever.
- Pagination, filters, reset and sort continue using the same selected OG product card.
- Full selected OG product-card controls are approved in the Elementor widget.
- Control structure is section-wise and must remain clean:

```text
Content tab:
- Product Card Renderer
- Selected OG Product Card — Content

Style tab:
- Section / Heading
- Filters / Toolbar
- Grid / Spacing
- Selected OG Product Card — Layout
- Selected OG Product Card — Text
- Selected OG Product Card — Meta & Tags
- Selected OG Product Card — Button
- Pagination
```

Safety scope:

```text
No product data change.
No product image/gallery change.
No origin mapping change.
No WooCommerce cart/checkout/template override.
No header/footer change.
No frontend replacement/stabilizer patch layer.
```

Rejected / archived attempts:

```text
v1.3.7, v1.3.8, v1.3.9, v1.4.0, v1.4.1, v1.4.2, v1.4.3 rollback packages
```

Next Discovery work:

```text
Add Cluster / SHG-Collective / Producer-Member filters source-level, one by one, after v1.4.4 remains stable.
```

---

## Current Amaley Core v1.0.99.4 Lock

`plugins/amaley-core/` is now synced to v1.0.99.4.

Important included work:

- Universal OG card direction across Cluster, SHG / Collective, Member / Producer and Product contexts.
- Cluster Single accepted card/control/pagination work.
- Member Single linked SHG, linked Cluster and Products card-control work.
- Single SHG card controls and pagination work from the current plugin chain.
- Cluster Archive OG Cluster Card 1 selector and existing controls bridge.
- SHG Archive OG SHG Card 1 selector and control selector fix.
- Product Card PRICE label/value readability fix.
- Member Archive OG Member Card 1 hide/show and style-control bridge.

Editor stability lock:

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during universal-card work.

Cleanup status:

```text
Cleanup is pending before the next new widget/module.
```

---

## Architecture Rule

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, random utility plugins, or page-builder widgets as core architecture.

Target direction:

- Amaley Core manages data structures, origin mapping, explicit Cluster → SHG/Producer Group links, rich story content, gallery/media fields, locked CPT card families and CPT-driven section widgets.
- Amaley Discovery Engine manages discovery, filters, listings, pagination, sorting and search.
- Amaley Site Shell manages header/footer/mobile drawer only when approved.
- Amaley UI Sections Kit manages locked generic page/home visual sections and foundation UI components.
- Amaley Compact Widgets manages manual/static compact card and section widgets.
- Amaley Templates supports WooCommerce/page template modules.
- Project Guard / Debug Toolkit will manage diagnostics and safety checks.

---

## Current CPT / Spacing / Card Locks

Read before creating or changing Cluster, SHG or Member / Producer pages:

```text
docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md
docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md
docs/AMALEY_CARD_DESIGN_LOCK.md
docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.md
```

Locked principles:

- Archive and single pages use separate section widgets.
- All-in-one widgets are legacy/fallback/test helpers only.
- Final editing workflow is one page template plus multiple Amaley Core section widgets.
- Future sections should follow `Amaley Section Spacing Rhythm 1`.
- Existing loose sections should be updated later to the approved compact rhythm.
- Cluster cards, SHG cards, Member / Producer cards and Product cards are locked.
- Same card type must keep the same design wherever it appears.
- Section-level CTA buttons are expected where a section shows limited cards and must have controls.
- Avoid heavy OG full controls unless they are essential and tested.

---

## Plugin / Module Roles

### amaley-core

Core data and system backbone.

Owns:

- Clusters
- SHG Groups
- SHG Members / Producers
- Product Origin Mapping
- Explicit Cluster → SHG/Producer Group links
- Rich story editor support
- Gallery/media fields where implemented
- Cluster Single spacing rhythm polish
- SHG archive and SHG single section widgets
- Member archive and Member single section widgets where CPT data is involved
- CPT-driven cards, archive sections and single sections
- Locked Cluster, SHG, Member and Product card families used in CPT contexts
- Universal OG card selectors/bridges for CPT contexts
- Section-level CTA controls where sections show limited cards
- Producer / maker profiles
- Traceability fields
- System health checks

Current relation source of truth:

```text
_amaley_cluster_linked_group_ids
```

Admin box:

```text
Amaley Linked Producer Groups / SHGs
```

This field is edited on the Cluster edit screen and read first by single cluster frontend sections.

Current approved spacing reference:

```text
Amaley Section Spacing Rhythm 1
```

Current approved card reference:

```text
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Does not own broad generic frontend design sections.

---

### amaley-discovery-engine

Discovery and listing system.

Owns:

- Product filtering
- Product grids where discovery logic is required
- Search
- Sorting
- Pagination
- Mobile filter drawer
- Cluster / SHG / Member discovery
- Safe empty states
- Source-level use of the locked Amaley Core product-card family for product discovery grids

Does not own static compact card libraries or generic page heroes.

When Discovery displays Amaley products, it must reuse the locked Amaley Core product-card style where practical rather than inventing a new product card family.

---

### amaley-site-shell

Header/footer shell system.

Owns:

- Header
- Footer
- Mobile header
