# Amaley Plugins

This folder contains clean source code for Amaley custom WordPress plugins and future Amaley component modules.

Plugin ZIP backups stay in Google Drive/local backup. Clean source code and documentation belong in GitHub.

---

## Current Source Folder Structure

```text
plugins/
  README.md
  amaley-core/
  amaley-discovery-engine/
  amaley-page-assignment-bridge/
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
| Amaley Core | v1.0.99.5 | ZIP backup belongs in Drive/local backup only |
| Amaley Discovery Engine | v1.4.4 stable OG card controls | `amaley-discovery-engine-v1.4.4-full-og-card-controls-tested.zip` in Drive/local backup only |
| Amaley Page Assignment Bridge | v1.4.1 final single product bridge | `AMALLEY_PAGE_ASSIGNMENT_BRIDGE_v1.4.1_SINGLE_PRODUCT_FINAL.zip` backup should be kept in Drive/local backup only |
| Amaley Site Shell | v1.0.1 retired/on hold | `amaley-site-shell-v1.0.1.zip` |
| Amaley UI Sections Kit | v0.6.1 | `amaley-ui-sections-kit-v0.6.1.zip` |
| Amaley Compact Widgets | v0.4.18 final tested | `amaley-compact-widgets-v0.4.18-header-alignment-live-preview-tested.zip` backup should be kept in Drive/local backup only |
| Amaley Templates | v1.2.7 | `amaley-templates-v1.2.7.zip` |

ZIPs are backups and must not be uploaded into this GitHub folder.

---

## Current Amaley Compact Widgets v0.4.18 Lock

`plugins/amaley-compact-widgets/` is synced to v0.4.18.

Accepted behaviour:

- Adds and keeps the approved `Amaley Dual Section Heading` widget.
- Dual Heading is a dedicated heading-only widget, not a card/grid widget.
- Dual Heading supports kicker, dual heading text, accent text, description, HTML tag, alignment, spacing, typography and show/hide controls.
- Existing non-dual compact widgets keep their compact visual role.
- Non-dual widgets use separate controls for Header Alignment, Card Text Alignment and Button Alignment.
- Old broad Overall Alignment was removed from non-dual widgets to avoid alignment conflicts.
- Header Alignment now affects the heading block in Elementor live preview with both text alignment and block margin behaviour.
- Columns no longer depend on inline `--acw4-cols` output that blocks responsive Elementor controls.

Safety scope:

```text
No WooCommerce cart/checkout/template override.
No product data change.
No product image/gallery change.
No product-origin mapping change.
No header/footer change.
No broad global CSS.
No filesystem/database write/delete routine.
No Dual Heading regression after v0.4.18 lock.
```

Do not use as final:

```text
v0.4.14, v0.4.15, v0.4.16, v0.4.17
```

Reference docs:

```text
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
```

---

## Current Amaley Page Assignment Bridge v1.4.1 Lock

`plugins/amaley-page-assignment-bridge/` is synced to the final tested v1.4.1 source.

Accepted behaviour:

- Assigns a normal Elementor page as the WooCommerce single product layout.
- Final assigned Elementor page order:

```text
1. Amaley Bridge Product Hero
2. Amaley Bridge Trust Strip
3. Amaley Bridge Info Tabs
4. Amaley Bridge Member Value Strip
```

- Bridge mode has been tested on All Products.
- Editor preview product context works.
- Origin details are shown inside Info Tabs → Origin.
- Member Value Strip uses editable Elementor repeater tiles.
- WooCommerce remains the source for product data, price, stock, cart, checkout and reviews.

Safety scope:

```text
No product data change.
No product image/gallery change.
No origin mapping change.
No WooCommerce cart/checkout/order logic change.
No Amaley Core source change.
No Amaley Templates source change.
No Amaley Discovery Engine source change.
No header/footer source change.
```

Rollback:

```text
Amaley Bridge → Single Product Assignment → Enable Single Product Bridge: Off
```

or deactivate the plugin.

---

## Current Amaley Discovery Engine v1.4.4 Lock

`plugins/amaley-discovery-engine/` is synced to v1.4.4.

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
v1.3.7, v1.3.8, v1.3.9, v1.4.0, v1.4.1, v1.4.2, v1.4.3 rollback packages, v1.4.5 price-layout fix
```

Next Discovery work:

```text
Add Cluster / SHG-Collective / Producer-Member filters source-level, one by one, after v1.4.4 remains stable.
```

---

## Current Amaley Core v1.0.99.5 Lock

`plugins/amaley-core/` is synced to v1.0.99.5.

Important included work:

- Universal OG card direction across Cluster, SHG / Collective, Member / Producer and Product contexts.
- Cluster Single accepted card/control/pagination work.
- Member Single linked SHG, linked Cluster and Products card-control work.
- Single SHG card controls and pagination work from the current plugin chain.
- Cluster Archive OG Cluster Card 1 selector and existing controls bridge.
- SHG Archive OG SHG Card 1 selector and control selector fix.
- Product Card price stack fix belongs to Amaley Core, not Discovery Engine.
- Member Archive OG Member Card 1 hide/show and style-control bridge.

Editor stability lock:

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during universal-card work.

Cleanup status:

```text
Cleanup is pending before the next broad widget/module.
```

---

## Architecture Rule

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, random utility plugins, or page-builder widgets as core architecture.

Target direction:

- Amaley Core manages data structures, origin mapping, explicit Cluster → SHG/Producer Group links, rich story content, gallery/media fields, locked CPT card families and CPT-driven section widgets.
- Amaley Discovery Engine manages discovery, filters, listings, pagination, sorting and search.
- Amaley Page Assignment Bridge manages page assignment for WooCommerce single product layouts and related bridge widgets.
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
