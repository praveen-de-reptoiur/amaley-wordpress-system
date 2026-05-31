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
| Amaley Core | v1.0.46 | v1.0.46 ZIP backup belongs in Drive |
| Amaley Discovery Engine | v1.3.5 | `amaley-discovery-engine-v1.3.5-no-cpt.zip` |
| Amaley Site Shell | v1.0.1 | `amaley-site-shell-v1.0.1.zip` |
| Amaley UI Sections Kit | v0.6.1 | `amaley-ui-sections-kit-v0.6.1.zip` |
| Amaley Compact Widgets | v0.4.3 source | v0.4.2 active ZIP until v0.4.3 ZIP/staging test |
| Amaley Templates | v1.2.7 | `amaley-templates-v1.2.7.zip` |

ZIPs are backups and must not be uploaded into this GitHub folder.

---

## Architecture Rule

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, random utility plugins, or page-builder widgets as core architecture.

Target direction:

- Amaley Core manages data structures, origin mapping, explicit Cluster → SHG/Producer Group links, rich Cluster Story content and CPT-driven section widgets.
- Amaley Discovery Engine manages discovery, filters, listings, pagination, sorting and search.
- Amaley Site Shell manages header/footer/mobile drawer only when approved.
- Amaley UI Sections Kit manages locked generic page/home visual sections and foundation UI components.
- Amaley Compact Widgets manages manual/static compact card and section widgets.
- Amaley Templates supports WooCommerce/page template modules.
- Project Guard / Debug Toolkit will manage diagnostics and safety checks.

---

## Current CPT / Spacing Locks

Read before creating or changing Cluster, SHG or Member / Producer pages:

```text
docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md
docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md
```

Locked principles:

- Archive and single pages use separate section widgets.
- All-in-one widgets are legacy/fallback/test helpers only.
- Final editing workflow is one page template plus multiple Amaley Core section widgets.
- Future sections should follow `Amaley Section Spacing Rhythm 1`.
- Existing loose sections should be updated later to the approved v1.0.46 compact rhythm.

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
- Rich Cluster Full Story editor support
- Cluster Single spacing rhythm polish
- CPT-driven cards, archive sections and single sections
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
Amaley Core v1.0.46 — Cluster Single Spacing Rhythm Polish
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

Does not own static compact card libraries or generic page heroes.

---

### amaley-site-shell

Header/footer shell system.

Owns:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- Shell-level CTA controls

Current safety rule: auto-render stays on hold until header/footer source is fully confirmed on staging.

---

### amaley-ui-sections-kit

Generic page/home visual section system.

Currently locked source: v0.6.1.

Owns:

- Home Hero V6
- Page Trust Strip
- Pages Hero Other
- Foundation UI helpers
- Generic static page visual sections where they are not compact widget libraries

Does not own:

- CPT/data logic
- Discovery filters
- WooCommerce template overrides
- Header/footer
- Compact card libraries

---

### amaley-compact-widgets

Manual/static compact visual widgets.

Current GitHub source: v0.4.3.  
Current active ZIP backup may remain v0.4.2 until v0.4.3 is zipped and tested on staging.

Owns:

- Info Cards Grid
- Split Editorial Section
- Traceability Journey as static visual section
- Origin Map Path as static homepage visual section
- Gifting / Bulk Band
- Feature / Value Strip
- Process Steps
- Origin Story Cards where manual/static
- Purpose Cards
- Collection Cards where manual/static
- Two Panel Info
- Dark Chain Cards
- Image Flip Cards
- Image Cards
- Image Info Cards
- Image Overlay Cards
- Quote Cards
- CTA Tiles
- Metric Tiles

Does not own:

- ACF/CPT data fetching
- Discovery filters
- WooCommerce template overrides
- Header/footer
- Home Hero V6
- Page Trust Strip
- Pages Hero Other

---

### amaley-templates

Template-level support module.

Owns:

- Existing or transitional template-level WooCommerce/page sections
- Single product support modules
- Shop page support modules
- Product hero / info tabs / trust strip / origin display where template-specific

Rule: Amaley Templates supports WooCommerce. It does not replace WooCommerce.

---

### amaley-project-guard

Future safety and project protection plugin.

Purpose:

- Show active Amaley plugin versions
- Show required dependency status
- Detect missing WooCommerce
- Detect risky duplicate plugins
- Detect old or broken Amaley plugin versions
- Warn before unsafe activation
- Provide admin-only status dashboard

---

### amaley-debug-toolkit

Future admin-only debug toolkit.

Purpose:

- Record plugin health status
- Show widget/module registration status
- Show WooCommerce dependency status
- Show product and origin data issues
- Show cache-related warnings
- Provide exportable debug report for developers

---

## Hard GitHub Rule

Do not commit:

- Plugin ZIPs
- `.wpress` backups
- Full website backups
- Screenshots
- Videos
- Product image dumps
- Passwords or secrets
- `wp-config.php`

GitHub remains source-only and documentation-only.
