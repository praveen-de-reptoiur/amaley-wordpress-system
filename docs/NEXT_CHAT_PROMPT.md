# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

---

I am working on the Amaley WordPress system.

Please continue from the existing project structure and do not guess. First review the GitHub source/docs and the latest handoff/source files I provide.

---

## Important References

- GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Google Drive folder: `Amaley Project`
- Main README: `README.md`
- Read first: `docs/READ_FIRST_AMALEY.md`
- Plugin/widget registry: `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- Design system: `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- Primary build rules: `docs/AMALEY_PRIMARY_BUILD_RULES.md`
- Performance and no-Elementor lock: `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`
- Changelog: `docs/CHANGELOG.md`
- Migration plan: `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- QA checklist: `docs/QA_CHECKLIST.md`
- Project manifest: `docs/PROJECT_MANIFEST.md`
- Drive folder map: `docs/DRIVE_FOLDER_MAP.md`
- Plugin/module architecture: `plugins/README.md`

---

## Current Project Rules

- GitHub is for source code, documentation, changelog, migration planning, QA notes, and developer handoff.
- Google Drive is for backups, plugin ZIPs, media, screenshots, videos, exports, and handoff packages.
- Heavy files must not be uploaded to GitHub.
- Source files should be used for GitHub updates.
- WooCommerce remains the commerce engine.
- Custom Amaley plugins/modules must support WooCommerce, not replace it.
- Do not create fake Cluster / SHG / Producer / origin data.
- Do not remove existing live dependencies blindly.
- Every serious change must be versioned, documented, tested, and reversible.
- The live site is reference/export source only unless explicitly approved.
- Fresh/staging/safe environment remains the development base.
- Do not say done without verification.

---

## Current Locked Plugin Source Status

| Plugin / Module | Current GitHub source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.2 | Data backbone and product-origin mapping baseline |
| Amaley Discovery Engine | v1.3.5 | Discovery/filter/listing engine; no default CPT registration |
| Amaley Site Shell | v1.0.1 | Shortcode/manual mode tested; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.2 | Manual/static compact card and section widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

Plugin ZIP backups belong in Drive, not GitHub.

---

## Latest Locked Architecture

Target architecture:

- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Compact Widgets
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

---

## Plugin / Module Boundaries

### Amaley Core

Manages data backbone:

- Clusters
- SHG Groups
- SHG Members / Producers
- Product Origin Mapping
- Producer / maker profiles
- Source village / region data
- Traceability fields
- Product usage/storage fields
- System health checks

Rule: Amaley Core must not become a frontend design plugin.

---

### Amaley Discovery Engine

Manages discovery logic:

- Product filters
- Category filters
- Origin filters
- Cluster filters
- SHG filters
- Producer filters
- Search
- Sorting
- Pagination
- Mobile filter behaviour
- Safe empty-state handling

Rule: Discovery Engine must remain separate from Core, Templates, UI Sections Kit and Compact Widgets.

---

### Amaley Site Shell

Manages site shell only:

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

---

### Amaley UI Sections Kit

Current locked source: v0.6.1.

Owns:

- Home Hero V6
- Page Trust Strip
- Pages Hero Other
- Foundation UI helpers
- Generic static page visual sections where they do not belong to Compact Widgets

Does not own CPT/data logic, Discovery filters, WooCommerce templates, header/footer, or compact card libraries.

---

### Amaley Compact Widgets

Current locked source: v0.4.2.

Owns manual/static compact visual widgets:

- Info Cards Grid
- Split Editorial Section
- Traceability Journey as static visual section
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

Does not own CPT/data logic, Discovery filters, WooCommerce template overrides, header/footer, Home Hero V6, Page Trust Strip or Pages Hero Other.

---

### Amaley Templates

Supports WooCommerce/page template modules only:

- Single product support modules
- Shop page support modules
- Product hero / info tabs / trust strip / origin display where template-specific

WooCommerce remains the commerce engine.

---

## Performance and No-Elementor Rule

The future clean Amaley website must remain extremely lightweight and low-network-first.

For the future clean UI/component system:

- Do not depend on Elementor default widgets.
- Do not build important future UI sections using Elementor Heading, Button, Icon Box, Image Box or HTML widgets.
- Do not use Elementor generic section layouts as the main system.

Elementor may still exist temporarily in old/current migration contexts, but future clean UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks and story sections must come from Amaley-controlled components.

---

## Working Style for Next Chat

- First review repo/source status.
- Use source files for GitHub updates.
- Never upload ZIPs/media/screenshots/videos to GitHub.
- Give commit messages before GitHub updates.
- For visual widgets, preview/dry-test first.
- Keep steps small and sequential.
- Do not claim done until files are verified.
