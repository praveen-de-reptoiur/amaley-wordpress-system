# Amaley Project Guard — Master Plan Locked v1.0.1

Date locked: 2026-06-02

Status: Planning locked. Coding starts in next chat only after reading the complete repository.

---

## 1. Purpose

Amaley Project Guard will be the read-only control-room, debug, audit and mapping plugin for the complete Amaley WordPress ecosystem.

It must answer:

- Which Amaley plugins are installed and active?
- Which versions are running?
- Which widgets/sections exist?
- Which widget is used on which page/template?
- Which plugin depends on which plugin/file/CSS/class/shortcode?
- Which external plugin may create conflict risk?
- Where exactly is a breakage, missing file, version mismatch, dependency issue, fatal error or Elementor/WooCommerce risk?

The plugin must show exact area, file, widget, dependency, severity and suggested action.

---

## 2. Hard Role Lock

Project Guard is not a design plugin.

Project Guard is not a frontend plugin.

Project Guard is not an auto-fix plugin.

Project Guard is a read-only project intelligence and diagnostic layer.

Default mode:

```text
Scan → Map → Report → Explain exact issue → Suggest action
```

It must not change the website automatically.

---

## 3. Performance and Zero-Load Safety Lock

Project Guard must never make the live website heavy.

Non-negotiable rules:

- No frontend output.
- No frontend CSS.
- No frontend JS.
- No frontend render hook unless explicitly needed later and proven safe.
- No heavy scan on normal page load.
- No full database scan on every admin page load.
- No file-system deep scan on every admin page load.
- No debug log parsing on every admin page load.
- Full scan must be manual-triggered from admin.
- Dashboard must load cached last report first.
- Deep scans must run in batches where needed.
- Scan result must show scan time, memory usage and scanned item count.
- Any future scheduled scan must be optional and off by default.

If the plugin creates frontend load, render delay, cache issues, Elementor editor delay, WooCommerce checkout delay, or heavy database load, that version is considered failed.

---

## 4. Admin Location

Admin-only page:

```text
Amaley → Project Guard
```

Capability:

```text
manage_options
```

No public-facing output.

---

## 5. Dashboard Tabs

Project Guard dashboard should eventually include:

1. Overview
2. Project Map
3. Plugins
4. Widgets & Sections
5. Usage Map
6. Amaley Core
7. Elementor
8. WooCommerce
9. External Plugin Risks
10. Assets
11. Data Integrity
12. Errors / Logs
13. Reports

---

## 6. Issue Severity System

Every issue must have:

```text
Severity
Area
Problem
Exact location
Impact
Suggested action
```

Severity levels:

```text
CRITICAL — site break / fatal risk
HIGH     — editor/frontend/commerce damage risk
MEDIUM   — data/display/conflict risk
LOW      — cleanup/documentation warning
INFO     — normal status or useful note
```

Example:

```text
HIGH
Area: Elementor
Problem: Atomic Editor active
Exact location: Elementor → Settings → Features
Impact: Amaley editor widgets may keep loading
Suggested action: Deactivate Atomic Editor
```

---

## 7. Auto Plugin Registry

Project Guard must automatically detect:

- Active plugins
- Inactive plugins
- Amaley plugins
- External plugins
- Plugin version
- Plugin folder
- Plugin main file
- Plugin author
- Basic plugin role if known
- Risk category if known

Amaley plugin examples:

- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Compact Widgets
- Amaley Templates
- Amaley Project Guard

External plugin examples:

- Elementor
- WooCommerce
- LiteSpeed Cache
- Code Snippets
- JetSmartFilters
- SEO/security/cache/image optimization plugins

---

## 8. Project Map

The Project Map must show the structure of the ecosystem:

```text
Amaley Core
  CPTs
    Cluster
    SHG / Collective
    Member / Producer
  Widgets
    Archive widgets
    Single-page widgets
    Related sections
  Card Renderers
    OG Cluster Card 1
    OG SHG Card 1
    OG Member Card 1
    OG Product Card 1
  Assets
    amaley-core-cards.css
    archive/single CSS files
  Data Relations
    _amaley_cluster_linked_group_ids
    _amaley_shg_cluster_id
    _amaley_member_shg_id
```

The map should auto-build from registered plugins, CPTs, shortcodes, Elementor widgets, files and optional registry hooks.

---

## 9. Widget / Section Map

For each widget/section, Project Guard should identify:

- Widget name
- Plugin owner
- Class name
- File path
- Renderer method
- Shortcode if any
- CSS dependencies
- JS dependencies if any
- Required plugin dependencies
- Required data/CPT/meta
- Used/not used status

Example:

```text
Widget: Amaley Member Archive Grid
Plugin: Amaley Core
Class: Amaley_Core_Member_Archive_Grid_Widget
File: includes/widgets/class-amaley-core-member-archive-grid-widget.php
Renderer: Amaley_Core_Member_Archive_Sections::render_grid()
Shortcode: [amaley_member_archive_grid]
CSS: amaley-core-member-archive-sections
Used on: Producers page / Member Archive template
```

---

## 10. Usage Map

Project Guard should scan:

- Pages
- Posts where relevant
- Elementor templates
- Elementor page JSON/meta
- Shortcode usage
- WooCommerce templates if stored through Elementor

It should report:

- Which widget is used where
- How many times it is used
- Page/template title
- Page/template ID
- Elementor widget ID if detectable
- Whether widget is registered but unused

Exact human section name is best-effort because Elementor may not store a human-readable section name. If unavailable, report widget ID and hierarchy.

---

## 11. Dependency Map

Each widget should map:

```text
Widget → Renderer → CPT/Data → CSS → JS → External Plugin Dependency
```

Example:

```text
Amaley Member Archive Grid
  Requires: Elementor
  Requires: Amaley Core
  Data: amaley_member CPT
  Relation: _amaley_member_shg_id
  Renderer: render_grid()
  Optional Card: OG Member Card 1
  CSS: amaley-core-cards.css, amaley-core-member-archive-sections.css
```

If missing:

```text
CRITICAL
Widget: Amaley Member Archive Grid
Missing dependency: amaley-core-cards.css
Impact: OG cards may appear broken.
```

---

## 12. External Plugin Conflict Scanner

Project Guard should categorize external plugin risks:

- Page builder
- WooCommerce
- Cache/performance
- SEO
- Security
- Image optimization
- Code snippets
- Theme builder
- Filter/search plugins

Examples:

```text
HIGH
Plugin: LiteSpeed Cache
Risk: CSS/JS minify active
Possible impact: Elementor/Amaley widget CSS may not update immediately.
Suggested action: Purge all cache after plugin update.
```

```text
MEDIUM
Plugin: JetSmartFilters
Risk: Discovery Engine and Jet filters may affect same archive.
Suggested action: Avoid mixing two filter systems on same page unless intentional.
```

Conflict scanner must label predictions as risk warnings, not fake confirmed errors.

---

## 13. Fatal / Error Scanner

Project Guard should later read safely:

- `wp-content/debug.log`
- PHP fatal errors
- Parse errors
- Warnings
- Deprecated notices
- Elementor errors
- WooCommerce errors
- Amaley-specific errors

It may later use a shutdown capture system for last fatal error, but v1.0.0 should stay simple and read-only.

---

## 14. File / Code Integrity Scanner

For Amaley plugins, Project Guard should check:

- Required files exist
- Required classes exist
- Required CSS files exist
- Shortcodes registered
- Elementor widgets registered
- Plugin header version and constant match
- Duplicate class/function risk where detectable
- Old version comments creating confusion

Example issue:

```text
LOW
File header mismatch
File: includes/widgets/class-amaley-core-member-archive-grid-widget.php
Header mentions: v1.0.76.4
Current plugin: v1.0.99.4
Action: Update file header to avoid future confusion.
```

---

## 15. Future Plugin Self-Registry Hook

Future Amaley plugins should optionally expose a registry hook so Project Guard can map them without manual updates.

Recommended hook:

```php
apply_filters( 'amaley_project_guard_registry', $registry );
```

Each plugin may report:

- Plugin name
- Version
- Role
- Widgets
- Shortcodes
- CPTs
- Assets
- Dependencies
- Known risks

Project Guard should use both auto-detection and self-reported registry data.

---

## 16. Guard Cache / Scan Storage

Project Guard should store scan result in options/transients, not run deep scan on every load.

Example options:

```text
amaley_project_guard_last_scan
amaley_project_guard_plugin_map
amaley_project_guard_widget_usage_map
amaley_project_guard_last_errors
```

Admin buttons:

```text
Run Quick Scan
Run Full Scan
Clear Guard Cache
Export Report
```

v1.0.0 should use manual scan only.

---

## 17. Report Export

Project Guard should provide:

- Copy debug summary
- Export Markdown report
- Export JSON report

Report should include:

- Date/time
- WordPress version
- PHP version
- Theme
- Active Amaley plugins
- Critical/high/medium/low issues
- Widget usage summary
- Recommended next action

---

## 18. Suggested File Structure

```text
amaley-project-guard/
  amaley-project-guard.php
  includes/
    class-apg-plugin.php
    class-apg-admin.php
    class-apg-scanner.php
    class-apg-plugin-registry.php
    class-apg-project-map.php
    class-apg-widget-usage-scanner.php
    class-apg-elementor-scanner.php
    class-apg-woocommerce-scanner.php
    class-apg-conflict-scanner.php
    class-apg-error-log-scanner.php
    class-apg-report-exporter.php
  assets/
    admin.css
    admin.js
  docs/
    PROJECT_GUARD_PLAN.md
    CHANGELOG.md
```

Prefix rules:

```text
APG
amaley_project_guard_
apg-
```

No generic names.

---

## 19. Version Roadmap

### v1.0.0 — Foundation Guard

Scope:

- Admin dashboard
- Manual scan button
- Plugin registry scan
- Amaley plugin detection
- External plugin detection
- Amaley Core version/header/constant check
- Required Amaley Core files check
- Elementor active check
- Atomic Editor warning
- WooCommerce active check
- Basic shortcode list
- Basic Elementor widget list
- Basic Project Map
- Basic report export
- No frontend load

### v1.0.1 — Usage Map

- Elementor page/template JSON scan
- Shortcode usage scan
- Used/unused widget map
- Page/template usage report

### v1.0.2 — Deep Amaley Core Integrity

- Renderer → widget → asset dependency map
- Card bridge class checks
- Missing CSS handle checks
- Required class checks

### v1.0.3 — External Plugin Conflict Scanner

- Cache plugin risk detection
- Code Snippets risk
- Elementor/WooCommerce/filter conflict warnings

### v1.0.4 — Error/Fatal Log Scanner

- debug.log parser
- fatal/warning/deprecated grouping
- Amaley-specific error detection

### v1.0.5 — Data Integrity Scanner

- Cluster/SHG/Member/Product counts
- Orphan relation checks
- Product origin mapping scan
- Duplicate slug checks

---

## 20. v1.0.0 Locked Build Scope

Build only this first:

1. Admin menu: `Amaley → Project Guard`
2. Manual Quick Scan button
3. Cached dashboard report
4. Active/inactive plugin registry scan
5. Amaley plugin detection
6. External plugin detection
7. Amaley Core version/header/constant check
8. Required Amaley Core file checks
9. Elementor active check
10. Atomic Editor warning
11. WooCommerce active check
12. Basic shortcode list
13. Basic Elementor widget list
14. Basic Project Map
15. Export Markdown/JSON report
16. Performance metrics: scan time, memory usage, scanned item count

Do not build usage scanning, deep code scanning, log reading, or frontend URL scanning in v1.0.0.

---

## 21. What Must Not Be Built in v1.0.0

- No frontend scan
- No log parser
- No DB-heavy full usage scan
- No automatic fixes
- No plugin deactivation
- No theme/plugin file editing
- No scheduled scans
- No frontend CSS/JS
- No data mutation beyond storing scan result

---

## 22. Final Next-Chat Instruction

In the next chat:

1. First read the complete GitHub repository status.
2. Read this locked Project Guard plan.
3. Do not start coding blindly.
4. Confirm current Amaley Core v1.0.99.4 status.
5. Confirm Project Guard v1.0.0 scope.
6. Build only the foundation guard first.
7. Keep the plugin read-only and zero frontend load.

The next chat must start exactly from this locked plan.
