# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

## Mandatory first read

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`

Universal rule:

Every section and every element must have non-coder friendly controls for content, show/hide, layout, style, and responsive behavior, with scoped lightweight CSS and no conflict.

## Project references

- GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Main README: `README.md`
- Root read-first: `000_READ_FIRST_BEFORE_ANY_WORK.md`
- Universal standard: `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
- Amaley read-first: `docs/READ_FIRST_AMALEY.md`
- Plugin/widget registry: `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- Design system: `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- Changelog: `docs/CHANGELOG.md`
- QA checklist: `docs/QA_CHECKLIST.md`
- Project manifest: `docs/PROJECT_MANIFEST.md`
- Plugin/module architecture: `plugins/README.md`

## Current project rules

- Read the universal standard before designing or building.
- GitHub is for source code, docs, changelog, planning, QA notes, and developer handoff.
- Google Drive is for backups, plugin ZIPs, media, screenshots, videos, exports, and handoff packages.
- Do not upload ZIPs or media to GitHub.
- WooCommerce remains the commerce engine.
- Custom Amaley plugins must support WooCommerce, not replace it.
- Do not create fake Cluster, SHG, Producer, or origin data.
- Every serious change must be versioned, documented, tested, and reversible.
- Do not say done without verification.

## Current plugin source status

| Plugin / Module | GitHub source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.2 | Data backbone and product-origin mapping baseline |
| Amaley Discovery Engine | v1.3.5 | Discovery/filter/listing engine |
| Amaley Site Shell | v1.0.1 | Header/footer shell; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other |
| Amaley Compact Widgets | v0.4.2 | Manual/static compact widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

## Working style

- First read the root read-first file and universal standard.
- Review repo/source status before changes.
- Use source files for GitHub updates.
- Never upload ZIPs/media/screenshots/videos to GitHub.
- Give commit messages before GitHub updates.
- Preview or dry-test visual widgets before final.
- Keep steps small and sequential.
