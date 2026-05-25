# Amaley WordPress System

Private source-code and documentation repository for the Amaley WordPress ecosystem.

This repository is maintained for clean plugin development, design-system control, migration planning, QA, debugging, and future developer handoff.

## Repository Purpose

This repository stores:

- Custom Amaley plugin source code
- WordPress development documentation
- Design-system rules
- Migration plans
- Changelog records
- QA and debug notes
- Developer handoff files

## Important Rule

This repository must not be used as a backup dump.

Do not upload:

- `.wpress` files
- Full website backup ZIPs
- Large media folders
- Product image dumps
- Videos
- Passwords
- API keys
- License keys
- `wp-config.php`

Heavy files belong in Google Drive.

## Current Documentation

Start here:

- `docs/READ_FIRST_AMALEY.md`
- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `docs/CHANGELOG.md`
- `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- `docs/DRIVE_FOLDER_MAP.md`
- `docs/QA_CHECKLIST.md`
- `docs/PROJECT_MANIFEST.md`
- `docs/NEXT_CHAT_PROMPT.md`
- `plugins/README.md`

## Target Architecture

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins

These may exist in old/current WordPress setups, but they are not part of the target architecture.

Target custom system:

- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

## Active Custom Plugin Direction

### Amaley Templates

Elementor-native template widgets for Amaley product, shop, origin, trust, and future quick-view sections.

Rule:

Amaley Templates must support WooCommerce, not replace it.

### Amaley Discovery Engine

Discovery, filtering, listing, pagination, and Cluster / SHG / Member display system.

Rule:

Discovery Engine must remain separate from Amaley Templates.

### Amaley Core

Future controlled data-layer plugin.

Planned role:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage Clusters
- Manage SHG Groups
- Manage SHG Members
- Manage Product Origin Mapping
- Manage producer / maker profiles
- Manage traceability fields

### Amaley Project Guard

Future safety and health-check plugin.

Planned role:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect missing Elementor
- Detect old or broken Amaley plugins
- Detect missing CPTs or fields
- Warn before unsafe activation
- Provide admin-only project health dashboard

### Amaley Debug Toolkit

Future admin-only diagnostic plugin.

Planned role:

- Show Elementor widget registration status
- Show WooCommerce dependency status
- Show product and origin data issues
- Show cache-related warnings
- Provide exportable debug reports for developers

Debug tools must be admin-only, permission-protected, safe for production, and not visible to public users.

## WooCommerce Rule

WooCommerce remains the commerce engine.

WooCommerce handles:

- Products
- Prices
- Stock
- Variations
- Cart
- Checkout
- Orders
- Reviews

Custom Amaley plugins must support WooCommerce, not replace it.

## Google Drive vs GitHub

Google Drive is for:

- `.wpress` backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

GitHub is for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

## Development Standard

Every change must be:

- Versioned
- Documented
- Tested
- Reversible
- Consistent with the Amaley design system
- Safe for WooCommerce
- Safe for Elementor
- Debuggable

No random fixes.  
No undocumented plugin edits.  
No messy file names.  
No backup files in GitHub.

## Hard Rule

If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.# Amaley WordPress System

Private source-code and documentation repository for the Amaley WordPress ecosystem.

This repository is maintained for clean plugin development, design-system control, migration planning, QA, debugging, and future developer handoff.

## Repository Purpose

This repository stores:

- Custom Amaley plugin source code
- WordPress development documentation
- Design-system rules
- Migration plans
- Changelog records
- QA and debug notes
- Developer handoff files

## Important Rule

This repository must not be used as a backup dump.

Do not upload:

- `.wpress` files
- Full website backup ZIPs
- Large media folders
- Product image dumps
- Videos
- Passwords
- API keys
- License keys
- `wp-config.php`

Heavy files belong in Google Drive.

## Current Documentation

Start here:

- `docs/READ_FIRST_AMALEY.md`
- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `docs/CHANGELOG.md`
- `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- `docs/DRIVE_FOLDER_MAP.md`
- `docs/QA_CHECKLIST.md`
- `docs/PROJECT_MANIFEST.md`
- `docs/NEXT_CHAT_PROMPT.md`
- `plugins/README.md`

## Target Architecture

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins

These may exist in old/current WordPress setups, but they are not part of the target architecture.

Target custom system:

- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

## Active Custom Plugin Direction

### Amaley Templates

Elementor-native template widgets for Amaley product, shop, origin, trust, and future quick-view sections.

Rule:

Amaley Templates must support WooCommerce, not replace it.

### Amaley Discovery Engine

Discovery, filtering, listing, pagination, and Cluster / SHG / Member display system.

Rule:

Discovery Engine must remain separate from Amaley Templates.

### Amaley Core

Future controlled data-layer plugin.

Planned role:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage Clusters
- Manage SHG Groups
- Manage SHG Members
- Manage Product Origin Mapping
- Manage producer / maker profiles
- Manage traceability fields

### Amaley Project Guard

Future safety and health-check plugin.

Planned role:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect missing Elementor
- Detect old or broken Amaley plugins
- Detect missing CPTs or fields
- Warn before unsafe activation
- Provide admin-only project health dashboard

### Amaley Debug Toolkit

Future admin-only diagnostic plugin.

Planned role:

- Show Elementor widget registration status
- Show WooCommerce dependency status
- Show product and origin data issues
- Show cache-related warnings
- Provide exportable debug reports for developers

Debug tools must be admin-only, permission-protected, safe for production, and not visible to public users.

## WooCommerce Rule

WooCommerce remains the commerce engine.

WooCommerce handles:

- Products
- Prices
- Stock
- Variations
- Cart
- Checkout
- Orders
- Reviews

Custom Amaley plugins must support WooCommerce, not replace it.

## Google Drive vs GitHub

Google Drive is for:

- `.wpress` backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

GitHub is for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

## Development Standard

Every change must be:

- Versioned
- Documented
- Tested
- Reversible
- Consistent with the Amaley design system
- Safe for WooCommerce
- Safe for Elementor
- Debuggable

No random fixes.  
No undocumented plugin edits.  
No messy file names.  
No backup files in GitHub.

## Hard Rule

If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.
