# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

---

I am working on the Amaley WordPress system.

Please continue from the existing project structure and do not guess.

---

## Important References

- GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Google Drive folder: `Amaley Project`
- Main README: `README.md`
- Read first: `docs/READ_FIRST_AMALEY.md`
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
- WooCommerce remains the commerce engine.
- Custom Amaley plugins/modules must support WooCommerce, not replace it.
- Do not create fake Cluster / SHG / Producer / origin data.
- Do not remove existing live dependencies blindly.
- Every serious change must be versioned, documented, tested, and reversible.
- The live site is reference/export source only unless explicitly approved.
- Fresh/staging/safe environment remains the development base.

---

## Latest Locked Architecture

Target architecture:

- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

Important current direction:

- `plugins/amaley-ui-sections-kit/` is the correct future UI sections planning folder.
- Old `plugins/amaley-widgets-kit/` was removed to avoid the wrong Elementor-only direction.
- Amaley UI Sections Kit is not built yet.
- No plugin ZIP should be created until structure, inventory, global design tokens, and phase plan are approved.

---

## Performance and No-Elementor Rule

The future clean Amaley website must remain extremely lightweight.

It must open fast even in low-network areas and must not become heavy after products, sections, origin data, or future modules are added.

For the future clean Amaley UI/component system:

- Do not depend on Elementor default widgets.
- Do not build important future UI sections using Elementor Heading widget.
- Do not build important future UI sections using Elementor Button widget.
- Do not build important future UI sections using Elementor Icon Box widget.
- Do not build important future UI sections using Elementor Image Box widget.
- Do not build important future UI sections using Elementor HTML widget.
- Do not use Elementor generic section layouts as the main system.

Elementor may still exist temporarily in old/current migration contexts, but future clean UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks, and story sections must come from Amaley-controlled components.

---

## Global Design Token Direction

The future Amaley UI/component system must be globally controlled through design tokens.

When the final Amaley brand PDF is provided, global tokens should control:

- Brand colors
- Background colors
- Text colors
- Heading font
- Body font
- Font sizes
- Button styling
- Border radius
- Card styling
- Shadows
- Section spacing
- Mobile spacing
- Product card styling
- Trust strip styling

If global font, color, radius, spacing, or button style changes, connected UI components should update without editing every section manually.

---

## Plugin / Module Boundaries

### Amaley Core

Amaley Core manages the data backbone:

- Clusters
- SHG Groups
- SHG Members / Producers
- Product origin mapping
- Producer / maker profiles
- Source village / region data
- Traceability fields
- Product usage fields
- Storage instruction fields
- System health checks

Rule:

Amaley Core must not become a frontend design plugin.

---

### Amaley Discovery Engine

Amaley Discovery Engine manages:

- Product filters
- Category filters
- Origin filters
- Cluster filters
- SHG filters
- Producer filters
- Search
- Sorting
- Pagination
- Mobile filter drawer
- Safe empty-state handling

Rule:

Discovery Engine must remain separate from Amaley Core, Amaley Templates, and Amaley UI Sections Kit. It must stay lightweight and avoid expensive unlimited frontend queries.

---

### Amaley Site Shell

Amaley Site Shell manages:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- CTA controls
- Footer contact and link controls

Current status:

- v1.0.1 source exists.
- Shortcode/manual mode tested.
- Auto-render exists but remains on HOLD.
- Full replacement must be tested only on fresh/staging after source of existing header/footer is confirmed.

Rule:

Amaley Site Shell must not blindly override live/current header and footer.

---

### Amaley UI Sections Kit

Amaley UI Sections Kit will manage future lightweight WordPress-native UI sections and components:

- Buttons
- Button groups
- Section headings
- Heading strips
- Promise strips
- Product cards
- Product grids
- Story sections
- Media + text sections
- Trust strips
- CTA bands
- Origin blocks
- Cluster cards
- SHG / women collective cards
- Contact blocks
- Footer CTA sections

Rules:

- No Elementor default widget dependency.
- No Elementor HTML widget dependency.
- No CPT creation.
- No WooCommerce replacement.
- No header/footer replacement.
- No discovery/filter engine replacement.
- Low-network-first.
- Global design-token controlled.
- No plugin ZIP should be built until structure, inventory, design tokens, and phase plan are approved.

---

### Amaley Templates

Amaley Templates may support existing or transitional template-level WooCommerce/page work.

Role:

- Existing or transitional product sections
- Existing or transitional shop sections
- Product hero / info tabs / trust strip / origin display where already implemented or required during migration

Rule:

Amaley Templates must support WooCommerce, not replace it.

Future clean reusable UI components should move toward Amaley UI Sections Kit instead of relying on Elementor default widgets.

---

### Amaley Project Guard

Amaley Project Guard should manage:

- Active Amaley plugin version checks
- Required dependency checks
- Old or broken plugin warnings
- Duplicate plugin risk warnings
- Missing CPT warnings
- Missing field warnings
- Admin-only project health dashboard

Rule:

Project Guard must remain admin-only/lightweight and must not slow down the public frontend.

---

### Amaley Debug Toolkit

Amaley Debug Toolkit should manage:

- Plugin health status
- Module/component registration status
- WooCommerce template dependency status
- Product and origin data issue reports
- Cache-related warnings
- Exportable debug reports for developers

Rule:

Debug Toolkit must be admin-only, permission-protected, safe for production, easy to disable, not public, not exposing secrets, and not slowing the public frontend.

---

## Current Active Plugin ZIPs in Google Drive

Current active plugin ZIP backups are stored in Google Drive:

- `amaley-core-v1.0.2.zip`
- `amaley-site-shell-v1.0.1.zip`
- `amaley-templates-v1.2.7.zip`
- `amaley-discovery-engine-v1.3.5-no-cpt.zip`

ZIPs stay in Google Drive, not GitHub.

GitHub stores clean source code and documentation.

---

## Before Making Changes

Before touching anything, check:

1. Root `README.md`
2. `docs/READ_FIRST_AMALEY.md`
3. `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
4. `docs/AMALEY_PRIMARY_BUILD_RULES.md`
5. `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`
6. `docs/CHANGELOG.md`
7. `docs/PROJECT_MANIFEST.md`
8. `plugins/README.md`
9. The relevant plugin/module README

Then ask what exact step is being continued.

---

## Step-by-Step Workflow Rule

Future Amaley work must move in small steps.

Rule:

- One task at a time.
- No parallel build/update/confusion.
- Ask before starting plugin build.
- Ask before ZIP creation.
- Ask before Drive upload.
- Ask before GitHub structural change.
- Complete current step first.
- Check current step.
- Then move to next step.

No build should start without approval.

---

## Work Style

- Continue professionally.
- Work step by step.
- Do not guess.
- Do not give vague suggestions.
- Do not create fake data.
- Do not upload backup files to GitHub.
- Do not give patch-only updates when full replacement is safer.
- Keep naming clean and developer-grade.
- Keep the project future-proof, debuggable, lightweight, low-network-ready, and rollback-safe.
- Respect the user’s instruction to move in small steps.

---

## Hard Rule

If a plugin/module cannot be tested, debugged, documented, rolled back, and managed safely, it is not production-ready.

If a file creates confusion, rename it or document it.

Confusion is technical debt.
