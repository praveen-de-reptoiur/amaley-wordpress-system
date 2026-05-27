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

### Added

- Added `docs/AMALEY_PRIMARY_BUILD_RULES.md` to lock fresh/staging-only development, no-conflict development, mobile-first responsiveness, scoped CSS, WooCommerce/Elementor boundaries, non-coder controls, data integrity, and testing gates.
- Added `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md` to lock mandatory Hero-widget-style full controls for all future widgets, Template Studio modules, sections, popups, forms, single templates, archive/listing templates, card/grid/timeline components, with section-wise/tab-wise controls and lightweight low-network performance rules.
- Updated `docs/DRIVE_FOLDER_MAP.md` with the permanent Amaley Google Drive folder link and expanded Drive folder usage notes.

### Rule Lock

- Every future Amaley component must be conflict-safe, mobile-first, scoped, lightweight, non-coder manageable, documented, testable, and rollback-ready.
- Every future widget/module/template must provide proper section-wise and tab-wise controls for content, style, layout, spacing, responsive behaviour, visibility, repeaters, and performance safety.
- The fresh/staging build remains the development base. The existing live site remains reference/export source only.
- GitHub and Google Drive will be maintained together: GitHub for clean source code and documentation, Drive for backups, plugin ZIPs, exports, media references, screenshots, videos, and handoff packages.

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
- If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.

---

## Development Rule

Before any serious update:

1. Take a backup.
2. Record current active version.
3. Make a versioned change.
4. Test desktop, tablet, and mobile.
5. Test WooCommerce product, cart, and checkout.
6. Update this changelog.
