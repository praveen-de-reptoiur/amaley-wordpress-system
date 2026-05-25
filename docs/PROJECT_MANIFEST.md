# PROJECT MANIFEST — Amaley WordPress System

This manifest is the project index for the Amaley WordPress system.

It explains what each repository file is for, what belongs in GitHub, and what belongs in Google Drive.

## Repository

```text
praveen-de-reptoiur/amaley-wordpress-system
```

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

Every serious change must be documented here.

### docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md

Fresh WordPress migration plan.

Purpose:

- Define safe migration direction
- Prevent blind removal of dependencies
- Define plugin roles
- Define migration phases
- Define rollback rules

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

If it is not tested, it is not done.

## Planned Repository Structure

Future structure:

```text
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
  plugins/
    amaley-templates/
    amaley-discovery-engine/
    amaley-core/
```

## Plugin Source Plan

### plugins/amaley-templates

Future source folder for the Amaley Templates plugin.

Purpose:

- Elementor-native template widgets
- Product page sections
- Shop page sections
- Origin and traceability sections
- Trust strips
- Future quick view modules

### plugins/amaley-discovery-engine

Future source folder for the Amaley Discovery Engine plugin.

Purpose:

- Product discovery
- Filtering
- Listings
- Pagination
- Cluster / SHG / Member discovery

### plugins/amaley-core

Future source folder for Amaley Core.

Purpose:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage origin fields
- Manage system health checks

## Current Active Plugin ZIPs in Google Drive

```text
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

These ZIPs stay in Google Drive.

Extracted source code can later be added to GitHub.

## Hard Rules

Do not upload heavy files to GitHub.

Do not upload:

- `.wpress` files
- Full backup ZIPs
- Product image dumps
- Videos
- Passwords
- API keys
- License keys
- `wp-config.php`

## Developer Standard

Every file must answer:

- What is this?
- Why does it exist?
- Is it latest?
- Is it source, backup, archive, or documentation?
- Can another developer understand it?
- Can it be rolled back safely?

## Final Rule

If a file creates confusion, rename it or document it.

Confusion is technical debt.
