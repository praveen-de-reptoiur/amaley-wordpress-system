# READ FIRST — Amaley WordPress System

This repository is the controlled source-code and documentation space for the Amaley WordPress system.

It is maintained for long-term development, plugin work, design consistency, migration planning, QA, and developer handoff.

## Project Owner

Praveen  
GitHub Username: `praveen-de-reptoiur`

## Purpose of This Repository

This repository is for:

- Amaley WordPress plugin source code
- Amaley Templates plugin source
- Amaley Discovery Engine source
- Future Amaley Core plugin source
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

## Active Custom Plugins

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

Amaley Templates must not replace WooCommerce.

### Amaley Discovery Engine

Purpose:

- Product discovery
- Filters
- Listings
- Pagination
- Cluster, SHG, and member discovery layouts

Rule:

Discovery Engine must remain separate from Amaley Templates.

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

Existing dependencies such as Freshen theme, ACF, CPT UI, JetEngine, or helper plugins must not be removed blindly.

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
