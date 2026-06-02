# Amaley Project Guard — Locked Master Plan v1.0.1

Planning Lock: v1.0.1
Performance Safety Lock: Added
Repository Path: plugins/amaley-project-guard/
Default Mode: Read-only. No auto-fix, no deletion, no frontend output, no plugin deactivation.

## Primary Goal

Create a read-only control room that detects plugin problems, maps widgets/sections/pages, and reports exact conflict, fatal and code risks.

## First Build Version

Amaley Project Guard v1.0.0

## Hard Safety Rules

- No frontend output in v1.x unless explicitly approved later.
- No auto-fix in v1.0.0. Reports only.
- Only store scan reports/cache/options. No content/data mutation.
- No plugin/theme file editing from Project Guard.
- No automatic plugin activation/deactivation/deletion.
- No heavy scan on every page load. Manual admin scan first.
- Admin-only, nonce-protected, capability manage_options.
- Elementor Atomic Editor warning must stay.

## Performance and Zero-Load Safety Lock

Project Guard must never make the live website heavy.

- No frontend output, no frontend design change, no frontend CSS/JS.
- No full scan on normal page load.
- No heavy DB/file/log scan without pagination, batching, limits and manual trigger.
- Dashboard must first load the last cached report quickly.
- Fresh scans must run only after user action.
- Guard must track scan time, memory usage and scanned item count.

## Main Admin Dashboard Structure

Amaley Project Guard:

- Overview
- Project Map
- Plugins
- Widgets and Sections
- Usage Map
- Amaley Core
- Elementor
- WooCommerce
- External Plugin Risks
- Assets
- Data Integrity
- Errors / Logs
- Reports

## Severity Model

- CRITICAL: Site break, fatal risk, missing core file/class, 500 response risk.
- HIGH: Editor/frontend damage risk or known breaking setting.
- MEDIUM: Data/display inconsistency or conflict risk.
- LOW: Cleanup/documentation/version mismatch.
- INFO: Useful status, unused widget, normal condition.

## Project Map

The map tab must show the structure of the Amaley ecosystem:

- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Site Shell
- Future Amaley plugins/theme/site kit

## Plugin Registry and Auto-Discovery

Guard should auto-detect:

- Plugins from get_plugins()
- Theme from wp_get_themes()
- CPTs
- Taxonomies
- Shortcodes
- Elementor widgets
- Styles/scripts where available
- Elementor data for later usage map
- Optional self-registry hook

## Widget / Section Mapping

Every widget/section should eventually map:

- Widget name
- Plugin
- Class
- File
- Renderer
- Shortcode
- Data source
- CSS
- Used on pages/templates

## Usage Map

Usage Map should scan:

- Elementor JSON from _elementor_data
- Page/post content for Amaley shortcodes
- Page/template title, ID, post type, status, modified date
- Used count, unused widgets, and duplicate usage

## Dependency Map

Project Guard should identify dependency chains such as:

- Requires Elementor
- Requires Amaley Core active
- Data source
- Relation meta
- Renderer
- CSS assets

## External Plugin Conflict Scanner

Future versions should scan risk areas:

- Page builders
- WooCommerce
- Cache/performance plugins
- Code snippets/custom code
- Filter plugins
- Security/firewall plugins
- Image optimization plugins

## Fatal / Error / Log Scanner

Future versions should read only safe recent portions of debug.log and show exact file, line, impact and suggested action.

## Amaley Core Deep Integrity Checks

Future checks should cover:

- Header version matching constant
- Required files/classes
- Card bridge classes
- Shortcodes
- Elementor widgets
- Assets
- Version comments

## Data / CPT Integrity

Future checks should cover:

- Cluster count
- SHG / Collective count
- Member / Producer count
- Products
- Orphan SHGs
- Members without SHG relation
- Products without origin mapping
- Duplicate slugs
- Empty required fields

Important relation keys:

- _amaley_cluster_linked_group_ids
- _amaley_shg_cluster_id
- _amaley_member_shg_id

## File and Class Structure

Expected plugin folder:

plugins/amaley-project-guard/

Expected prefixes:

- PHP class prefix: APG_
- Function prefix: amaley_project_guard_
- CSS prefix: apg-

## Version Roadmap

- v1.0.0 — Foundation Guard
- v1.0.1 — Usage Map
- v1.0.2 — Deep Amaley Core Integrity
- v1.0.3 — External Plugin Conflict Scanner
- v1.0.4 — Fatal/Error Log Scanner
- v1.0.5 — Data Integrity Scanner

## v1.0.0 Locked Build Scope

Build only foundation:

- Admin menu
- Manual Run Quick Scan button
- Plugin registry
- Basic project map
- Amaley Core version/header/constant/file checks
- Elementor active check and Atomic Editor warning
- WooCommerce active check
- Basic shortcode list
- Basic Elementor widget list
- Issue list
- Export Markdown and JSON report
- Performance-safe dashboard
- Self-performance metrics

## What Must Not Be Built in v1.0.0

- No automatic fixes
- No plugin deactivation
- No deletion or cleanup tool
- No frontend scanner
- No background cron scanning
- No heavy unused-function scanner
- No GitHub API integration in the first version
- No admin UI over-design
- No frontend hooks that slow the site
- No scan that runs automatically on every admin dashboard load

## Locked Amendment after v1.0.0 Live Test

Final tested admin menu is separate top-level menu: Amaley Project Guard.

Project Guard must not sit under Amaley Core menu.

Amaley Core remains only a read-only scan target.

This amendment was applied after live-site testing of v1.0.0 clean separate build.
