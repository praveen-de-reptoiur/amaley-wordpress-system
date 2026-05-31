# READ FIRST — Amaley WordPress System

This repository is the controlled source-code and documentation space for the Amaley WordPress system.

Read this before touching the project.

---

## Project Owner

Praveen  
GitHub Username: `praveen-de-reptoiur`

---

## Purpose of This Repository

This repository is for:

- Amaley WordPress plugin/module source code
- Design system documentation
- Architecture and plugin-boundary rules
- Performance and low-network rules
- Migration notes
- Changelog records
- QA and dry-test notes
- Developer handoff documentation

---

## What Not to Upload Here

Do not upload:

- `.wpress` backups
- All-in-One WP Migration backups
- Full website backup ZIP files
- Plugin ZIP backups
- Large media folders
- Videos
- Screenshot dumps
- Product image dumps
- Passwords
- API keys
- License keys
- `wp-config.php`

Heavy files belong in Google Drive, not GitHub.

---

## Google Drive Role

Google Drive is the archive and backup space.

Drive is used for:

- Website backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Media references
- Handoff ZIPs

---

## GitHub Role

GitHub is the clean development space.

GitHub is used for:

- Source code
- Documentation
- Version history
- Changelogs
- Migration planning
- QA notes
- Developer-readable project rules

---

## Current Locked Plugin Source Status

| Plugin / Module | Current GitHub source | ZIP backup belongs in Drive |
| --- | --- | --- |
| Amaley Core | v1.0.46 | v1.0.46 ZIP backup belongs in Drive |
| Amaley Discovery Engine | v1.3.5 | `amaley-discovery-engine-v1.3.5-no-cpt.zip` |
| Amaley Site Shell | v1.0.1 | `amaley-site-shell-v1.0.1.zip` |
| Amaley UI Sections Kit | v0.6.1 | `amaley-ui-sections-kit-v0.6.1.zip` |
| Amaley Compact Widgets | v0.4.3 source | v0.4.2 active ZIP until v0.4.3 ZIP/staging test |
| Amaley Templates | v1.2.7 | `amaley-templates-v1.2.7.zip` |

ZIPs stay in Google Drive. GitHub stores clean source code and documentation only.

---

## Latest Amaley Core Status

Amaley Core source is now synced to **v1.0.46**.

Locked changes preserved:

```text
v1.0.41 — Explicit Cluster → SHG/Producer Group relation
v1.0.45 — Cluster Full Story rich editor
v1.0.46 — Cluster Single spacing rhythm polish
```

Important relation key:

```text
_amaley_cluster_linked_group_ids
```

This is the explicit Cluster → SHG/Producer Group relation meta key. It is edited from the Cluster edit screen side box:

```text
Amaley Linked Producer Groups / SHGs
```

Approved spacing reference:

```text
Amaley Section Spacing Rhythm 1
```

Reference file:

```text
docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md
```

Safety:

- No WooCommerce cart/checkout override.
- No header/footer override.
- No permalink rewrite.
- No ZIP/media should be committed to GitHub.

---

## Target Architecture

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins
- Page-builder default widgets for important custom UI sections

These may exist in old/current WordPress setups, but they are not part of the final target architecture.

Target custom system:

- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Compact Widgets
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

---

## Future UI Direction

For the future clean Amaley website, important UI sections must be Amaley-controlled and lightweight.

Future clean UI sections should not depend on Elementor default widgets such as:

- Elementor Heading widget
- Elementor Button widget
- Elementor Icon Box widget
- Elementor Image Box widget
- Elementor HTML widget
- Elementor generic section layouts as the main system

Elementor may still exist temporarily in old/current migration contexts, but future clean UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks, and story sections must come from Amaley-controlled components.

---

## Performance and Low-Network Rule

The Amaley website must remain extremely lightweight.

Every plugin/module must follow:

- No unnecessary external libraries
- No heavy animation libraries
- No global CSS dumps
- No duplicate CSS/JS
- No unnecessary frontend requests
- No unlimited frontend queries
- Optimized image output
- Clean HTML output
- Small vanilla JavaScript only where required
- Admin-only diagnostics kept away from public frontend

If a component looks premium but makes the site heavy, it is not approved.

---

## CPT Section Structure and Spacing Locks

Read these before any CPT archive/single work:

```text
docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md
docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md
```

Locked principles:

- Archive and single pages use separate section widgets.
- All-in-one widgets are legacy/fallback/test helpers only.
- Cluster Single, SHG Single and Member / Producer Single must follow reusable section-wise structures.
- New sections must follow Amaley Section Spacing Rhythm 1.
- Existing loose sections should be updated later to the approved compact rhythm.
- Spacing problems must be solved through plugin defaults and widget controls, not by abandoning section-wise architecture.

---

## Active Custom Plugin / Module Direction

### Amaley Core

Core data and system backbone.

Owns:

- Cluster records
- SHG Group records
- SHG Member / Producer records
- Product Origin Mapping
- Explicit Cluster → SHG/Producer Group links
- Rich Cluster Full Story editor support
- Cluster Single spacing rhythm polish
- Producer / maker profiles
- Source village and region data
- Traceability fields
- Product usage and storage fields
- System health checks

Current relation source of truth:

```text
_amaley_cluster_linked_group_ids
```

Rule: Amaley Core must not become a broad frontend design plugin. It may own CPT-driven cards, sections, archive widgets and single widgets because they depend on Amaley Core data.

---

### Amaley Discovery Engine

Discovery and listing system.

Owns:

- Product discovery
- Filters
- Listings
- Search
- Sorting
- Pagination
- Product grids where discovery logic is required
- Cluster discovery
- SHG group discovery
- SHG member discovery
- Mobile filter behaviour
- Safe empty-state handling

Rule: Discovery Engine must remain separate from Amaley Core, Amaley Templates, Amaley UI Sections Kit and Amaley Compact Widgets.

---

### Amaley Site Shell

Header/footer shell system.

Owns:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- Shell-level CTA controls
- Footer contact and link controls

Current status:

- v1.0.1 source exists.
- Shortcode/manual mode tested.
- Auto-render exists but remains on hold.
- Full replacement must be tested only on fresh/staging after source of existing header/footer is confirmed.

Rule: Amaley Site Shell must not blindly override live/current header and footer.

---

### Amaley UI Sections Kit

Generic page/home visual section system.

Current locked source: v0.6.1.

Owns:

- Home Hero V6
- Page Trust Strip
- Pages Hero Other
- Foundation UI helpers
- Generic static page visual sections where they do not belong to Compact Widgets

Does not own:

- CPT/data logic
- Discovery filters
- WooCommerce template overrides
- Header/footer
- Compact card libraries

---

### Amaley Compact Widgets

Manual/static compact visual widget system.

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

### Amaley Templates

Template-level support module.

Owns:

- Existing or transitional WooCommerce/page template sections
- Single product support modules
- Shop page support modules
- Product hero / info tabs / trust strip / origin display where template-specific

Rule: Amaley Templates must support WooCommerce, not replace it.

---

## WooCommerce Rule

WooCommerce remains responsible for products, prices, stock, variations, cart, checkout, orders and reviews.

Custom Amaley plugins must support WooCommerce, not replace it.

---

## Work Rules

- Review repo/source status before changing anything.
- Use source files for GitHub updates.
- Keep ZIPs/media/screenshots/videos out of GitHub.
- Give commit messages before updates.
- Preview or dry-test visual widgets before final lock.
- Do not say done without verification.
- Update docs/changelog after serious source changes.
- Work in small, safe, sequential steps.
