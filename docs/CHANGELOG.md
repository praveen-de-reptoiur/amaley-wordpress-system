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
- Updated root `README.md` with professional repository purpose and target architecture
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

Amaley Templates must support WooCommerce, not replace it.

### Project Guard Direction

Future Amaley Project Guard will manage safety and dependency visibility.

It should support:

- Active Amaley plugin version checks
- Required dependency checks
- Old or broken plugin warnings
- Duplicate plugin risk warnings
- Missing CPT warnings
- Missing field warnings
- Admin-only project health dashboard

Project Guard exists to prevent silent breakage.

### Debug Toolkit Direction

Future Amaley Debug Toolkit will support admin-only diagnostics.

It should support:

- Elementor widget registration status
- WooCommerce template dependency status
- Product and origin data issue reports
- Cache-related warnings
- Exportable debug reports for developers

Debug tools must be:

- Admin-only
- Permission-protected
- Safe for production
- Easy to disable
- Not visible to public users

### Migration Plan Updated and Restored

`docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md` was replaced with a full target architecture plan.

During the update process, the wrong NEXT_CHAT_PROMPT content was accidentally pasted into the migration plan file.

The migration plan was restored from GitHub history using the correct previous commit:

- Correct restored version: `Replace migration plan with full target architecture`
- Restore commit purpose: bring back the full migration architecture plan

The migration plan now includes:

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

### Root README Updated

`README.md` was updated to reflect the latest target architecture.

It now includes:

- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit
- No permanent ACF / CPT UI / JetEngine / Smart Filters dependency
- WooCommerce rule
- Google Drive vs GitHub rule
- Hard production rule

### READ_FIRST Updated

`docs/READ_FIRST_AMALEY.md` was updated to reflect the latest architecture.

It now includes:

- Target architecture
- Data system direction
- Filtering system direction
- Project Guard direction
- Debug Toolkit direction
- Fresh WordPress direction
- Hard production rule

### Project Manifest Updated

`docs/PROJECT_MANIFEST.md` was updated to reflect the latest architecture.

It now includes:

- Target repository structure
- Plugin source plan
- Data system direction
- Filtering system direction
- Migration standard
- Debug standard
- Final rule: confusion is technical debt

### NEXT_CHAT_PROMPT Updated

`docs/NEXT_CHAT_PROMPT.md` was updated to help future chats continue correctly.

It now includes:

- GitHub and Google Drive references
- Current project rules
- Target architecture
- Dependency direction
- Amaley Core direction
- Discovery Engine direction
- Templates direction
- Project Guard direction
- Debug Toolkit direction
- Work style rules
- Hard production rule

### Fixed

- Removed wrongly nested `docs/docs/docs/READ_FIRST_AMALEY.md`
- Recreated correct file at `docs/READ_FIRST_AMALEY.md`
- Fixed incomplete `docs/DRIVE_FOLDER_MAP.md`
- Replaced weak plugin README with full architecture guide
- Replaced patch-style migration notes with full replacement migration plan
- Restored migration plan after wrong content was pasted into it
- Updated README, READ_FIRST, PROJECT_MANIFEST, and NEXT_CHAT_PROMPT to match the final architecture direction

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
