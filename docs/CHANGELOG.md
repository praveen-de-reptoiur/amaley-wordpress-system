# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

Do not use vague entries like “fixed things” or “updated plugin.”

Every entry must clearly explain:

- What changed
- Why it changed
- Which file/plugin/module was affected
- Whether it is safe, experimental, or archived

---

## 2026-05-25

### Added

- Created GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Updated root `README.md` with professional repository purpose and rules
- Added `docs/READ_FIRST_AMALEY.md`
- Added `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- Added `docs/CHANGELOG.md`
- Added `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- Added `docs/DRIVE_FOLDER_MAP.md`
- Added `docs/QA_CHECKLIST.md`
- Added `docs/PROJECT_MANIFEST.md`
- Added `docs/NEXT_CHAT_PROMPT.md`
- Added `plugins/README.md`

### Google Drive Structure Created

Google Drive project folder structure created:

```text
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
```

### Current Active Plugin Backups in Google Drive

Current plugin ZIP backups stored in Google Drive:

```text
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

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

### Amaley Core Direction

Future Amaley Core will manage:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region information
- Traceability fields
- Product usage fields
- Storage instruction fields
- System health checks

ACF and CPT UI must not remain permanent core dependencies.

### Amaley Discovery Engine Direction

Amaley Discovery Engine will eventually replace JetEngine / Smart Filters dependency.

Discovery Engine should support:

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

### Amaley Templates Direction

Amaley Templates remains responsible for Elementor-native visual/template sections.

It should support:

- Product hero
- Product info tabs
- Trust strip
- Origin / traceability display
- Shop hero
- Shop discovery layout
- Future quick view / popup modules

Amaley Templates must not replace WooCommerce.

### Project Guard / Debug Toolkit Direction

Future debug and guard system added to architecture.

Purpose:

- Detect broken dependencies
- Show active plugin versions
- Warn about old/broken plugins
- Detect missing CPTs or fields
- Show Elementor widget registration status
- Show WooCommerce template dependency status
- Provide admin-only debug reports

Debug tools must be admin-only, permission-protected, and must not slow down the frontend.

### Migration Plan Updated

`docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md` was replaced with a full target architecture plan.

The plan now includes:

- Current risk
- Target long-term stack
- Dependency direction
- Plugin roles
- Amaley Core build phase
- Discovery Engine replacement phase
- Project Guard and Debug Toolkit phase
- QA phase
- Rollback rule
- Hard production rule

### Plugins README Updated

`plugins/README.md` was replaced with a full plugin architecture guide.

It now documents:

- Target plugin structure
- Active plugin ZIP backups
- Dependency direction
- Custom data system plan
- Filtering system plan
- Plugin roles
- Debug philosophy
- Minimum health checks
- CSS rules
- PHP rules
- Security rules
- Production rules

### Fixed

- Removed wrongly nested `docs/docs/docs/READ_FIRST_AMALEY.md`
- Recreated correct file at `docs/READ_FIRST_AMALEY.md`
- Fixed incomplete `docs/DRIVE_FOLDER_MAP.md`
- Replaced weak plugin README with full architecture guide
- Replaced patch-style migration notes with full replacement migration plan

### Current Rule Lock

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
