# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

Do not use vague entries like “fixed things” or “updated plugin.”

Every entry must clearly explain:

- What changed
- Why it changed
- Which file/plugin/module was affected
- Whether it is safe, experimental, or archived

---

## 2026-05-27

### Architecture / Documentation Update — UI Sections Kit and Performance Lock

- Added `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md` as the permanent performance and future UI direction lock.
- Locked the future Amaley website direction as extremely lightweight, low-network-first, mobile-first, and globally design-token controlled.
- Locked the rule that future clean Amaley UI sections must not depend on Elementor default widgets.
- Clarified that Elementor may still exist temporarily in old/current migration contexts, but new future UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks, and story sections must come from Amaley-controlled components.
- Created `plugins/amaley-ui-sections-kit/README.md` as the planning folder for the future lightweight, WordPress-native, theme-like UI section/component system.
- Removed the old `plugins/amaley-widgets-kit/` planning folder to avoid the outdated Elementor-only direction.
- Updated `plugins/README.md` to reflect the new plugin/module structure, no-Elementor future UI rule, performance rule, global design-token direction, plugin boundaries, and step-by-step workflow rule.
- Updated root `README.md` to reflect Amaley Site Shell, Amaley UI Sections Kit, no-Elementor future UI direction, low-network performance lock, global design-token direction, and step-by-step workflow rule.
- Updated `docs/PROJECT_MANIFEST.md` to make it the current project index for the revised architecture.

Affected files:

```text
README.md
plugins/README.md
plugins/amaley-ui-sections-kit/README.md
docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md
docs/PROJECT_MANIFEST.md
```

Current architecture direction:

```text
Amaley Core
Amaley Discovery Engine
Amaley Site Shell
Amaley UI Sections Kit
Amaley Templates
Amaley Project Guard
Amaley Debug Toolkit
```

Safety decision:

```text
No plugin build started.
No ZIP created.
No Drive upload done.
No live-site change done.
Documentation and architecture cleanup only.
```

Workflow rule locked:

```text
One task at a time.
No parallel build/update/confusion.
Ask before plugin build.
Ask before ZIP creation.
Ask before Drive upload.
Ask before GitHub structural change.
Complete current step, check it, then move to the next step.
```

### Added

- Added `docs/AMALEY_PRIMARY_BUILD_RULES.md` to lock fresh/staging-only development, no-conflict development, mobile-first responsiveness, scoped CSS, WooCommerce/Elementor boundaries, non-coder controls, data integrity, and testing gates.
- Added `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md` to lock mandatory Hero-widget-style full controls for all future widgets, Template Studio modules, sections, popups, forms, single templates, archive/listing templates, card/grid/timeline components, with section-wise/tab-wise controls and lightweight low-network performance rules.
- Updated `docs/DRIVE_FOLDER_MAP.md` with the permanent Amaley Google Drive folder link and expanded Drive folder usage notes.
- Added Amaley Core v1.0.2 plugin source under `plugins/amaley-core/` as the tested Cluster, SHG Group, Member / Producer, Product Origin Mapping, and Import / Export backbone.

### Fixed

- Updated Amaley Core from v1.0.0 / v1.0.1 to v1.0.2 after staging testing.
- Added WooCommerce HPOS / custom order tables compatibility declaration to remove WooCommerce incompatible-feature warning.
- Added safe cluster import fallback so old blank-code Cluster records can be matched by exact title during first cluster code backfill imports.
- Prevented duplicate Cluster creation during initial Cluster code backfill.

### Tested on Staging Clone

Tested on temporary staging domain:

```text
https://lightsalmon-lemur-689499.hostingersite.com/
```

Passed checks:

- Amaley Core plugin activation completed successfully.
- Amaley Core dashboard loaded successfully.
- Schema Version displayed as `1`.
- Existing 5 Cluster records were detected.
- Cluster code backfill was completed and verified.
- Final Cluster codes verified:

```text
LAD-NET-001  Himalayan Nettle Cluster
LAD-APR-001  Ladakh Apricot Cluster
LAD-SBT-001  Seabuckthorn Cluster
LAD-BAR-001  Tsampa & Barley Cluster
UTK-GHE-001  Uttarakhand Ghee Cluster
```

- SHG Groups export checked and confirmed empty / clean.
- Members / Producers export checked and confirmed empty / clean.
- WooCommerce Product Origin Mapping panel appeared on product edit screen.
- One product origin mapping was saved successfully.
- Dashboard count changed correctly:

```text
Products with Origin: 1
Products Missing Origin: 19
```

- Product Origin Mapping CSV dry-run passed.
- Product Origin Mapping actual import passed.
- Final Product Origin export verified:

```text
AMY-SBT-PRE-200 → LAD-SBT-001
show_origin → 1
```

### Drive / GitHub Status

- Saved `amaley-core-v1.0.2.zip` in Google Drive under `02_Active_Plugins`.
- Updated GitHub source under `plugins/amaley-core/` to v1.0.2.
- Marked `amaley-core-v1.0.2.zip` as the current tested active Amaley Core plugin ZIP.
- `amaley-core-v1.0.0.zip` should be treated as old archive candidate and moved later to `10_Archive_Do_Not_Use / old-plugin-versions /`.

### Amaley Site Shell v1.0.1

- Added `plugins/amaley-site-shell/` as the lightweight, scoped, mobile-first header/footer shell plugin for the Amaley WordPress system.
- Amaley Site Shell is intended to manage header, footer, mobile header, mobile drawer, navigation, announcement strip, CTA controls, footer contact details, and footer links in the future fresh build.
- Plugin source was uploaded to GitHub under `plugins/amaley-site-shell/`.
- Saved `amaley-site-shell-v1.0.1.zip` in Google Drive under `02_Active_Plugins`.

### Amaley Site Shell Testing Status

Tested on temporary staging domain:

```text
https://lightsalmon-lemur-689499.hostingersite.com/
```

Passed checks:

- Plugin installed and activated successfully on staging.
- Amaley Site Shell dashboard loaded successfully.
- Dashboard showed Header enabled, Footer enabled, Auto Header OFF, Auto Footer OFF, navigation item count, footer column count, and shortcode information.
- Shortcode mode was tested using Elementor Shortcode widgets:

```text
[amaley_site_header]
[amaley_site_footer]
```

- Header and footer output rendered correctly inside a test page.
- HTML widget shortcode rendering issue was identified and corrected by using Elementor Shortcode widgets instead of Elementor HTML widget.

### Amaley Site Shell Safety Decision

- Auto Header Render and Auto Footer Render were intentionally kept OFF.
- Existing clone header/footer source is not yet fully confirmed. It may be coming from theme options, Apus/Freshen header builder, Elementor templates, Megamenu plugin, or theme hooks.
- Direct header/footer replacement is therefore deferred to the future fresh build or a controlled staging test after the current header/footer source is clearly identified.
- `amaley-site-shell-v1.0.1.zip` is saved as an experimental/staging plugin backup, not as a production replacement baseline.
- Current safe mode for Amaley Site Shell is shortcode/manual render only.

Status:

```text
Version saved: v1.0.1
Mode tested: Shortcode mode
Auto render: OFF / HOLD
Production use: Not yet
Fresh build test: Required later
```


### Rule Lock

- Every future Amaley component must be conflict-safe, mobile-first, scoped, lightweight, non-coder manageable, documented, testable, and rollback-ready.
- Every future widget/module/template must provide proper section-wise and tab-wise controls for content, style, layout, spacing, responsive behaviour, visibility, repeaters, and performance safety.
- The fresh/staging build remains the development base. The existing live site remains reference/export source only.
- GitHub and Google Drive will be maintained together: GitHub for clean source code and documentation, Drive for backups, plugin ZIPs, exports, media references, screenshots, videos, and handoff packages.
- Amaley Core v1.0.2 is the current tested data-backbone baseline for Cluster → SHG Group → Member / Producer → Product Origin Mapping.

## 2026-05-25

### Added

- Created GitHub repository: praveen-de-reptoiur/amaley-wordpress-system
- Updated root README.md with professional repository purpose and target architecture
- Added docs/READ_FIRST_AMALEY.md
- Added docs/AMALEY_DESIGN_SYSTEM_LOCKED.md
- Added docs/CHANGELOG.md
- Added docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md
- Added docs/DRIVE_FOLDER_MAP.md
- Added docs/QA_CHECKLIST.md
- Added docs/PROJECT_MANIFEST.md
- Added docs/NEXT_CHAT_PROMPT.md
- Added plugins/README.md

### Plugin Source Folder Structure Added

Created placeholder source folders with README files:

    plugins/
      README.md
      amaley-templates/
        README.md
      amaley-discovery-engine/
        README.md
      amaley-core/
        README.md
      amaley-project-guard/
        README.md
      amaley-debug-toolkit/
        README.md

These are documentation placeholders only.

Actual plugin source code has not yet been uploaded to GitHub.

### Amaley Templates Source README Added

Added:

    plugins/amaley-templates/README.md

Purpose:

- Define Amaley Templates plugin role
- Lock WooCommerce support rule
- Define Elementor-native widget direction
- Define CSS/PHP naming rules
- Define debug and production readiness rules

### Amaley Discovery Engine Source README Added

Added:

    plugins/amaley-discovery-engine/README.md

Purpose:

- Define discovery, filtering, sorting, search, pagination, and mobile drawer role
- Lock separation from Amaley Templates
- Define replacement direction for JetEngine / Smart Filters
- Define query safety and empty-state rules
- Define debug and production readiness rules

### Amaley Core Source README Added

Added:

    plugins/amaley-core/README.md

Purpose:

- Define future controlled data-layer plugin
- Define ACF / CPT UI replacement direction
- Define Cluster, SHG Group, SHG Member, producer, and origin mapping responsibilities
- Define migration safety rules
- Define data integrity and no-fake-data rule

### Amaley Project Guard Source README Added

Added:

    plugins/amaley-project-guard/README.md

Purpose:

- Define future safety and project health-check plugin
- Define dependency visibility
- Define active plugin version checks
- Define missing CPT/field warnings
- Define duplicate/old plugin warnings
- Define admin-only health dashboard direction

### Amaley Debug Toolkit Source README Added

Added:

    plugins/amaley-debug-toolkit/README.md

Purpose:

- Define future admin-only diagnostic plugin
- Define Elementor widget diagnostics
- Define WooCommerce diagnostics
- Define product/origin data diagnostics
- Define cache warning notes
- Define safe exportable debug report direction

### Google Drive Structure Created

Google Drive project folder structure created:

    Amaley Project/
      00_Project_Control/
      01_Backups/
      02_Active_Plugins/
      03_Code_Source/
      04_Elementor_Templates/
      05_Data_Exports/
      06_Design_System/
      07_Media_Reference/
      08_Migration/
      09_QA_Debug/
      10_Archive_Do_Not_Use/
      11_Handoff_Packages/

### Current Active Plugin Backups in Google Drive

Current plugin ZIP backups stored in Google Drive:

    amaley-templates-v1.2.7.zip
    amaley-discovery-engine-v1.3.5-no-cpt.zip

These ZIPs must remain in Google Drive.

GitHub should contain clean extracted source code only.

### Architecture Decision

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins

These may exist in old/current WordPress setups, but they are not part of the target architecture.

Target architecture:

- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

### Fixed

- Removed wrongly nested docs/docs/docs/READ_FIRST_AMALEY.md
- Recreated correct file at docs/READ_FIRST_AMALEY.md
- Fixed incomplete docs/DRIVE_FOLDER_MAP.md
- Replaced weak plugin README with full architecture guide
- Replaced patch-style migration notes with full replacement migration plan
- Restored migration plan after wrong content was pasted into it
- Updated README, READ_FIRST, PROJECT_MANIFEST, and NEXT_CHAT_PROMPT to match final architecture direction

### Current Rule Lock

GitHub is for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

Google Drive is for:

- .wpress backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

### Hard Rules

- WooCommerce remains the commerce engine.
- Heavy files must not be uploaded to GitHub.
- Do not create fake Cluster / SHG / Producer data.
- Do not remove ACF, CPT UI, JetEngine, Smart Filters, or existing live dependencies blindly.
- Every serious change must be versioned, documented, tested, and reversible.

---

## Development Rule

Before any serious update:

1. Take a backup.
2. Record current active version.
3. Make a versioned change.
4. Test desktop, tablet, and mobile.
5. Test WooCommerce product, cart, and checkout.
6. Update this changelog.
