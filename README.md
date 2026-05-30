# Amaley WordPress System

Controlled source-code and documentation repository for the Amaley WordPress ecosystem.

This repository is maintained for clean plugin development, source history, design-system control, migration planning, QA, debugging, and future developer handoff.

---

## Repository Purpose

This repository stores:

- Custom Amaley plugin source code
- Documentation and changelog records
- Architecture and plugin-boundary rules
- QA and dry-test notes
- Migration and handoff planning

GitHub is not a backup dump.

---

## GitHub vs Google Drive Rule

GitHub is for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

Google Drive is for:

- `.wpress` backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

Do not upload ZIPs, videos, screenshots, product image dumps, passwords, API keys, license keys, or `wp-config.php` to GitHub.

---

## Current Locked Plugin Source Status

| Plugin / Module | Current source status | Role |
| --- | --- | --- |
| Amaley Core | v1.0.2 | Data backbone: Cluster, SHG Group, Member / Producer, Product Origin Mapping |
| Amaley Discovery Engine | v1.3.5 | Discovery, filtering, search, sort, pagination, listing logic |
| Amaley Site Shell | v1.0.1 | Header/footer shell, mobile drawer, shortcode/manual mode; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Generic page/home visual sections: Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.2 | Manual/static compact visual card and section widgets |
| Amaley Templates | v1.2.7 | WooCommerce/page template support modules |

Current source code belongs in GitHub. Plugin ZIP backups stay in Google Drive.

---

## Active Documentation

Start here:

- `docs/READ_FIRST_AMALEY.md`
- `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `docs/AMALEY_PRIMARY_BUILD_RULES.md`
- `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`
- `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md`
- `docs/CHANGELOG.md`
- `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- `docs/DRIVE_FOLDER_MAP.md`
- `docs/QA_CHECKLIST.md`
- `docs/PROJECT_MANIFEST.md`
- `docs/NEXT_CHAT_PROMPT.md`
- `plugins/README.md`

---

## Target Architecture

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, random utility plugins, or page-builder default widgets for important custom UI sections.

These may exist in old/current WordPress setups, but they are not the final target architecture.

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

## Plugin Boundaries

### Amaley Core

Amaley Core manages the data backbone only:

- Clusters
- SHG Groups
- SHG Members / Producers
- Product Origin Mapping
- Producer / maker profiles
- Traceability fields
- System health checks

Rule: Amaley Core must not become a frontend design plugin.

---

### Amaley Discovery Engine

Discovery Engine manages listing and discovery logic:

- Product filters
- Search
- Sorting
- Pagination
- Result grids
- Topbar filters
- Cluster / SHG / Member discovery where discovery logic is required

Rule: Discovery Engine must stay separate from Core, Templates, UI Sections Kit and Compact Widgets.

---

### Amaley Site Shell

Site Shell manages:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- Shell-level CTA controls

Current rule: auto-render remains on hold. Header/footer replacement must not be done blindly on the live site.

---

### Amaley UI Sections Kit

UI Sections Kit owns generic page/home visual sections and foundation UI components:

- Home Hero V6
- Page Trust Strip
- Pages Hero Other
- Foundation section headings/buttons/strips
- Generic static page visual sections where they do not belong to Compact Widgets

Rule: UI Sections Kit must not own CPT data cards, discovery filters, WooCommerce templates, header/footer, or compact card libraries.

---

### Amaley Compact Widgets

Compact Widgets owns manual/static compact visual card and section widgets:

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

Rule: Compact Widgets must not own CPT/data logic, Discovery filters, WooCommerce template overrides, header/footer, Home Hero V6, Page Trust Strip, or Pages Hero Other.

---

### Amaley Templates

Templates supports WooCommerce/page template modules:

- Single product support modules
- Shop page support modules
- Product template sections
- Product hero / tabs / trust strip / origin display where template-specific

Rule: WooCommerce remains the commerce engine. Amaley Templates supports WooCommerce; it does not replace WooCommerce.

---

## WooCommerce Rule

WooCommerce remains responsible for:

- Products
- Prices
- Stock
- Variations
- Cart
- Checkout
- Orders
- Reviews

Custom Amaley plugins must support WooCommerce, not replace it.

---

## Performance Lock

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

## Development Standard

Every change must be:

- Versioned
- Documented
- Tested or clearly marked as not yet live-tested
- Reversible
- Consistent with Amaley design rules
- Safe for WooCommerce
- Lightweight
- Low-network-ready
- Mobile-first
- Debuggable
- Non-coder manageable where relevant

No random fixes. No undocumented edits. No backup files in GitHub.

---

## Step-by-Step Workflow Rule

Future Amaley work must move in small steps:

1. Review current source/repo status first.
2. Use source files for GitHub updates.
3. Do not commit ZIP/media/screenshots/videos to GitHub.
4. Preview or dry-test visual widgets before calling them final.
5. Update documentation/changelog after serious source changes.
6. Verify the final repo state before reporting done.
