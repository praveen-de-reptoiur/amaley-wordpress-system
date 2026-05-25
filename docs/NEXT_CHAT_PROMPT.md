# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

---

I am working on the Amaley WordPress system.

Please continue from the existing project structure and do not guess.

Important references:

- GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Google Drive folder: `Amaley Project`
- Main README: `README.md`
- Read first: `docs/READ_FIRST_AMALEY.md`
- Design system: `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- Changelog: `docs/CHANGELOG.md`
- Migration plan: `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- QA checklist: `docs/QA_CHECKLIST.md`
- Project manifest: `docs/PROJECT_MANIFEST.md`
- Drive folder map: `docs/DRIVE_FOLDER_MAP.md`
- Plugin architecture: `plugins/README.md`

Current project rules:

- GitHub is for source code, documentation, changelog, migration planning, QA notes, and developer handoff.
- Google Drive is for backups, plugin ZIPs, media, screenshots, videos, exports, and handoff packages.
- Heavy files must not be uploaded to GitHub.
- WooCommerce remains the commerce engine.
- Custom Amaley plugins must support WooCommerce, not replace it.
- Do not create fake Cluster / SHG / Producer data.
- Do not remove existing live dependencies blindly.
- Every serious change must be versioned, documented, tested, and reversible.

Target architecture:

- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

Dependency direction:

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins

These may exist in old/current WordPress setups, but they are not part of the target architecture.

Amaley Core should eventually manage:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region data
- Traceability fields
- Product usage fields
- Storage instruction fields
- System health checks

Amaley Discovery Engine should eventually manage:

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

Amaley Templates should manage:

- Elementor-native visual sections
- Product hero
- Product info tabs
- Trust strip
- Origin / traceability display
- Shop hero
- Shop discovery layout
- Future quick view / popup modules

Amaley Project Guard should manage:

- Active Amaley plugin version checks
- Required dependency checks
- Old or broken plugin warnings
- Duplicate plugin risk warnings
- Missing CPT warnings
- Missing field warnings
- Admin-only project health dashboard

Amaley Debug Toolkit should manage:

- Elementor widget registration status
- WooCommerce template dependency status
- Product and origin data issue reports
- Cache-related warnings
- Exportable debug reports for developers

Current active plugin ZIPs are stored in Google Drive:

- `amaley-templates-v1.2.7.zip`
- `amaley-discovery-engine-v1.3.5-no-cpt.zip`

Before making changes:

1. Check the root `README.md`.
2. Check `docs/READ_FIRST_AMALEY.md`.
3. Check `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`.
4. Check `docs/CHANGELOG.md`.
5. Check `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`.
6. Check `docs/QA_CHECKLIST.md`.
7. Check `docs/PROJECT_MANIFEST.md`.
8. Check `plugins/README.md`.
9. Ask what exact step we are continuing from.

Work style:

- Continue professionally.
- Work step by step.
- Do not guess.
- Do not give vague suggestions.
- Do not create fake data.
- Do not upload backup files to GitHub.
- Do not give patch-only updates when full replacement is safer.
- Keep naming clean and developer-grade.
- Keep the project future-proof, debuggable, and rollback-safe.

Hard rule:

If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.
