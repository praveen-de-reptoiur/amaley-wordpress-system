# PROJECT MANIFEST — Amaley WordPress System

This manifest is the project index for the Amaley WordPress system.

It explains what each repository file is for, what belongs in GitHub, what belongs in Google Drive, and what the target architecture is.

## Repository

    praveen-de-reptoiur/amaley-wordpress-system

## Repository Role

GitHub is used for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

GitHub is not used for heavy backup files.

## Google Drive Role

Google Drive is used for:

- `.wpress` backups
- Plugin ZIP backups
- Elementor template exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

## Current Repository Files

### README.md

Main front-page description of the repository.

Purpose:

- Explain the repository
- Link the major documentation files
- Define the high-level development standard

### docs/READ_FIRST_AMALEY.md

Primary onboarding file.

Purpose:

- Explain project rules
- Explain GitHub vs Google Drive roles
- Explain plugin boundaries
- Explain WooCommerce rule
- Explain naming discipline

This file must be read before touching the project.

### docs/AMALEY_DESIGN_SYSTEM_LOCKED.md

Locked design-system file.

Purpose:

- Define brand positioning
- Lock colors
- Lock typography
- Lock button style
- Lock card style
- Lock mobile rules
- Prevent visual inconsistency

No page or plugin widget should drift away from this file.

### docs/CHANGELOG.md

Version and decision history.

Purpose:

- Record major project decisions
- Record plugin versions
- Record documentation updates
- Record migration milestones
- Record architecture decisions

Every serious change must be documented here.

### docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md

Fresh WordPress migration plan.

Purpose:

- Define safe migration direction
- Prevent blind dependency removal
- Define plugin roles
- Define target architecture
- Define migration phases
- Define rollback rules
- Define guard and debug direction

### docs/DRIVE_FOLDER_MAP.md

Google Drive folder map.

Purpose:

- Explain Drive folder structure
- Define what belongs in each folder
- Prevent backup/media/source-code confusion

### docs/QA_CHECKLIST.md

Testing checklist.

Purpose:

- Test plugin updates
- Test Elementor templates
- Test WooCommerce flows
- Test responsive layout
- Test design-system consistency
- Test migration safety

If it is not tested, it is not done.

### docs/NEXT_CHAT_PROMPT.md

Continuation prompt for future ChatGPT chats.

Purpose:

- Help future chats continue without guessing
- Point to the correct GitHub and Drive references
- Lock project rules for the next assistant/developer

### docs/PROJECT_MANIFEST.md

This file.

Purpose:

- Act as the project index
- Explain current and planned repository structure
- Explain plugin architecture
- Explain source vs backup rules

### plugins/README.md

Plugin architecture guide.

Purpose:

- Define plugin source structure
- Define plugin roles
- Lock dependency direction
- Define debug and guard philosophy
- Define CSS, PHP, and security rules

## Target Repository Structure

Planned repository structure:

    amaley-wordpress-system/
      README.md
      docs/
        READ_FIRST_AMALEY.md
        AMALEY_DESIGN_SYSTEM_LOCKED.md
        CHANGELOG.md
        AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md
        DRIVE_FOLDER_MAP.md
        QA_CHECKLIST.md
        PROJECT_MANIFEST.md
        NEXT_CHAT_PROMPT.md
      plugins/
        README.md
        amaley-templates/
        amaley-discovery-engine/
        amaley-core/
        amaley-project-guard/
        amaley-debug-toolkit/

## Current Active Plugin ZIPs in Google Drive

Current active plugin ZIP backups:

    amaley-templates-v1.2.7.zip
    amaley-discovery-engine-v1.3.5-no-cpt.zip

These ZIPs stay in Google Drive.

Extracted source code can later be added to GitHub.

## Architecture Decision

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

## Plugin Source Plan

### plugins/amaley-templates

Future source folder for the Amaley Templates plugin.

Purpose:

- Elementor-native template widgets
- Product page sections
- Shop page sections
- Product hero
- Product info tabs
- Trust strips
- Origin and traceability sections
- Future quick view / popup modules

Rule:

Amaley Templates must not replace WooCommerce.

### plugins/amaley-discovery-engine

Future source folder for the Amaley Discovery Engine plugin.

Purpose:

- Product discovery
- Filtering
- Listings
- Pagination
- Mobile filter behaviour
- Cluster discovery
- SHG group discovery
- SHG member discovery
- Safe empty-state handling

Rule:

Discovery Engine must remain separate from Amaley Templates.

### plugins/amaley-core

Future source folder for Amaley Core.

Purpose:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage product origin fields
- Manage Cluster data
- Manage SHG Group data
- Manage SHG Member data
- Manage producer / maker profiles
- Manage source village and region data
- Manage traceability fields
- Add system health checks

Rule:

Amaley Core must become the controlled data layer for Amaley.

### plugins/amaley-project-guard

Future source folder for Amaley Project Guard.

Purpose:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect missing Elementor
- Detect old or broken Amaley plugin versions
- Detect duplicate plugin risks
- Detect missing CPTs
- Detect missing fields
- Provide admin-only project health dashboard
- Warn before unsafe activation

Rule:

Project Guard exists to prevent silent breakage.

### plugins/amaley-debug-toolkit

Future source folder for Amaley Debug Toolkit.

Purpose:

- Show Elementor widget registration status
- Show WooCommerce template dependency status
- Show product and origin data issues
- Show cache-related warnings
- Provide exportable debug reports for developers
- Support safer troubleshooting

Debug tools must be:

- Admin-only
- Permission-protected
- Safe for production
- Easy to disable
- Not visible to public users

Rule:

Debug visibility is part of production readiness.

## Data System Direction

Amaley should eventually manage its own data structures for:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region information
- Traceability fields
- Product usage fields
- Storage instruction fields

These should not remain permanently dependent on ACF or CPT UI.

## Filtering System Direction

Filtering should be handled by Amaley Discovery Engine.

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

Amaley should not depend permanently on JetEngine or Smart Filters.

## Google Drive Structure

Google Drive structure:

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

## What Belongs in GitHub

GitHub should contain:

- Clean source code
- README files
- Documentation
- Design-system rules
- Migration plans
- QA notes
- Changelogs
- Developer handoff notes

## What Does Not Belong in GitHub

Do not upload:

- `.wpress` files
- Full backup ZIPs
- Product image dumps
- Videos
- Passwords
- API keys
- License keys
- `wp-config.php`
- Large media folders
- Random plugin ZIPs

Heavy files belong in Google Drive.

## Development Standard

Every file must answer:

- What is this?
- Why does it exist?
- Is it latest?
- Is it source, backup, archive, or documentation?
- Can another developer understand it?
- Can it be rolled back safely?

## Migration Standard

No dependency should be removed before its replacement is ready.

Do not remove blindly:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Freshen theme dependencies
- Existing live utility plugins

Replacement must be tested on staging or safe environment first.

## Debug Standard

A plugin is not production-ready unless it can be:

- Tested
- Debugged
- Rolled back
- Versioned
- Documented

## Final Rule

If a file creates confusion, rename it or document it.

Confusion is technical debt.
