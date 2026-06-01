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
| Amaley Core | v1.0.74 | v1.0.74 ZIP backup belongs in Drive |
| Amaley Discovery Engine | v1.3.5 | `amaley-discovery-engine-v1.3.5-no-cpt.zip` |
| Amaley Site Shell | v1.0.1 | `amaley-site-shell-v1.0.1.zip` |
| Amaley UI Sections Kit | v0.6.1 | `amaley-ui-sections-kit-v0.6.1.zip` |
| Amaley Compact Widgets | v0.4.3 source | v0.4.2 active ZIP until v0.4.3 ZIP/staging test |
| Amaley Templates | v1.2.7 | `amaley-templates-v1.2.7.zip` |

ZIPs stay in Google Drive. GitHub stores clean source code and documentation only.

---

## Latest Amaley Core Status

Amaley Core source is now synced to **v1.0.74**.

Locked changes preserved:

```text
v1.0.41 — Explicit Cluster → SHG/Producer Group relation
v1.0.45 — Cluster Full Story rich editor direction
v1.0.46 — Cluster Single spacing rhythm polish
v1.0.74 — SHG archive/single polish, gallery/media fields, section buttons, card locks and product-card correction checkpoint
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

Reference files:

```text
docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md
docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md
docs/AMALEY_CARD_DESIGN_LOCK.md
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
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Locked principles:

- Archive and single pages use separate section widgets.
- All-in-one widgets are legacy/fallback/test helpers only.
- Cluster Single, SHG Single and Member / Producer Single must follow reusable section-wise structures.
- New sections must follow Amaley Section Spacing Rhythm 1.
- Existing loose sections should be updated later to the approved compact rhythm.
- Spacing problems must be solved through plugin defaults and widget controls, not by abandoning section-wise architecture.
- Section-level CTA buttons are expected where a section shows only limited cards.
- Section-level CTA buttons need show/hide, text, URL, alignment and responsive controls.

---

## Card Design Lock

Cluster card, SHG / Producer Group card, Member / Producer card and Product card families are now locked.

Reference:

```text
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Rules:

- Same card type must keep the same design across the site.
- Do not create random alternate card designs for different pages.
- Product cards used inside Amaley Core should follow the approved compact product-card family and later be reused in Discovery where practical.
- Images should use cover center center handling and must have practical height/ratio controls where relevant.
- Description word count, max chips/tags, card buttons, section buttons, button alignment, transform/hover, animation intensity and responsive layout should be controllable where relevant.
- Only bug fixes, data fixes, responsiveness fixes and accessibility/performance improvements are allowed without explicit redesign approval.

---

## Active Custom Plugin / Module Direction

### Amaley Core

Core data and system backbone.

Owns:

- Cluster records
- SHG Group records
- SHG Members / Producers records
- Product Origin Mapping
- Explicit Cluster → SHG/Producer Group links
- Rich story editor support for CPT story fields
- Gallery/media fields for Cluster, SHG and Member records where implemented
- Cluster Single spacing rhythm polish
- SHG archive and SHG single section widgets
- Producer / maker profiles
- Source village and region data
- Traceability fields
- Product usage and storage fields
- CPT-driven card families and related-item sections
- System health checks

Current relation source of truth:

```text
_amaley_cluster_linked_group_ids
```

Rule: Amaley Core must not become a broad frontend design plugin. It may own CPT-driven cards, sections, archive widgets and single widgets because they depend on Amaley Core data.

---
