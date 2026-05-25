# READ FIRST — Amaley WordPress System

This repository is the controlled source-code and documentation space for the Amaley WordPress system.

It is maintained for long-term development, plugin work, design consistency, migration planning, QA, debugging, and developer handoff.

## Project Owner

Praveen  
GitHub Username: `praveen-de-reptoiur`

## Purpose of This Repository

This repository is for:

- Amaley WordPress plugin source code
- Amaley Templates plugin source
- Amaley Discovery Engine source
- Future Amaley Core source
- Future Amaley Project Guard source
- Future Amaley Debug Toolkit source
- Design system documentation
- Migration notes
- Changelog records
- QA and debug notes
- Developer handoff documentation

## What Not to Upload Here

Do not upload:

- `.wpress` backups
- All-in-One WP Migration backups
- Full website backup ZIP files
- Large media folders
- Videos
- Screenshot dumps
- Passwords
- API keys
- License keys
- `wp-config.php`

Heavy files belong in Google Drive, not GitHub.

## Google Drive Role

Google Drive is the archive and backup space.

Drive is used for:

- Website backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Media references
- Handoff ZIPs

## GitHub Role

GitHub is the clean development space.

GitHub is used for:

- Source code
- Documentation
- Version history
- Changelogs
- Migration planning
- QA notes
- Developer-readable project rules

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

Purpose:

- Elementor-native Amaley widgets
- Single product template sections
- Shop page sections
- Product hero
- Product info tabs
- Trust strip
- Origin and traceability display
- Future quick view and popup modules

Rule:

Amaley Templates must support WooCommerce, not replace it.

### Amaley Discovery Engine

Purpose:

- Product discovery
- Filters
- Listings
- Pagination
- Product grids
- Cluster discovery
- SHG group discovery
- SHG member discovery
- Mobile filter behaviour
- Safe empty-state handling

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
- Manage product origin mapping
- Manage producer / maker profiles
- Manage source village and region data
- Manage traceability fields
- Add system health checks

Rule:

Amaley Core must become the controlled data layer for Amaley.

### Amaley Project Guard

Future safety and health-check plugin.

Planned role:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect missing Elementor
- Detect old or broken Amaley plugins
- Detect duplicate plugin risks
- Detect missing CPTs
- Detect missing fields
- Warn before unsafe activation
- Provide admin-only project health dashboard

Rule:

Project Guard exists to prevent silent breakage.

### Amaley Debug Toolkit

Future admin-only diagnostic plugin.

Planned role:

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

Amaley should not depend permanently on JetEngine or Smart Filters.

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

## Design Rule

Amaley must remain:

- Premium
- Clean
- Mobile-first
- Consistent
- Lightweight
- Scalable
- Easy for non-coders to manage
- Safe for long-term development

No random styling.  
No inconsistent fonts.  
No global CSS shortcuts.  
No plugin conflict hacks.

## Fresh WordPress Direction

The long-term direction is a cleaner WordPress setup using:

- Lightweight base theme
- WooCommerce
- Elementor Pro
- Fluent Forms
- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

Existing dependencies such as Freshen theme, ACF, CPT UI, JetEngine, Smart Filters, or helper plugins must not be removed blindly.

Removal must happen only after:

- Replacement is ready
- Backup is taken
- Testing is complete
- Rollback plan is available

## Development Rule

Before every serious change:

1. Take a backup.
2. Check current active plugin versions.
3. Update changelog.
4. Make the change in a versioned way.
5. Test desktop, tablet, and mobile.
6. Test WooCommerce product, cart, and checkout flows.
7. Record what changed and why.

## Naming Rule

Good names:

- `amaley-templates-v1.2.7`
- `amaley-discovery-engine-v1.3.5-no-cpt`
- `AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`

Bad names:

- `final-new-latest-2`
- `plugin-fixed-real-final`
- `copy of backup`
- `new zip`
- `test working maybe`

Bad naming creates future confusion and project risk.

## Project Standard

This project must be maintained like a serious production system, not like a temporary experiment.

Every file must answer:

- What is this?
- Why does it exist?
- Is it latest or archived?
- Can another developer understand it?
- Can it be rolled back safely?

## Hard Rule

If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.
