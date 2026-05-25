# Amaley WordPress System

Private source-code and documentation repository for the Amaley WordPress ecosystem.

This repository is maintained for clean plugin development, design-system control, migration planning, QA, and future developer handoff.

## Repository Purpose

This repository stores:

- Custom Amaley plugin source code
- WordPress development documentation
- Design-system rules
- Migration plans
- Changelog records
- QA and debug notes
- Developer handoff files

## Important

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

## Active Custom Plugin Direction

### Amaley Templates

Elementor-native template widgets for Amaley product, shop, origin, trust, and future quick-view sections.

### Amaley Discovery Engine

Discovery, filtering, listing, pagination, and cluster / SHG / member display system.

### Future Amaley Core

Planned core plugin for replacing ACF and CPT UI dependency in a controlled, safe, versioned way.

## Core Rule

WooCommerce remains the commerce engine.

Custom Amaley plugins must support WooCommerce, not replace it.

## Development Standard

Every change must be:

- Versioned
- Documented
- Tested
- Reversible
- Consistent with the Amaley design system

No random fixes.  
No undocumented plugin edits.  
No messy file names.  
No backup files in GitHub.
