# AMALEY FRESH WORDPRESS MIGRATION PLAN

This document defines the safe migration direction for Amaley.

The goal is not to randomly rebuild the website.  
The goal is to move Amaley toward a cleaner, faster, scalable, and more controlled WordPress system.

## Migration Objective

Move Amaley from the current theme/plugin-heavy setup toward a cleaner WordPress architecture.

The future setup should be:

- Lightweight
- WooCommerce-first
- Elementor-compatible
- Mobile-first
- Design-system consistent
- Conflict-safe
- Easier to maintain
- Easier for future developers to understand

## Current Risk

The current site may depend on:

- Freshen theme
- Apus theme components
- WooCommerce
- Elementor Pro
- ACF
- CPT UI
- JetEngine / Smart Filters
- Custom plugins
- Theme-specific templates
- Imported demo structures

These must not be removed blindly.

Blind removal can break:

- Product pages
- Shop page
- Filters
- Product origin sections
- Cluster / SHG / Member layouts
- Elementor templates
- WooCommerce cart or checkout
- Mobile responsiveness

## Target Long-Term Stack

Preferred future setup:

- Lightweight base theme
- WooCommerce
- Elementor Pro
- Fluent Forms
- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- LiteSpeed Cache only after layout is stable

## Dependency Direction

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, or random utility plugins.

These plugins may exist in the current or old WordPress setup, but they are not part of the target architecture.

Target direction:

- Amaley Core will manage custom post types and fields.
- Amaley Discovery Engine will manage discovery, filters, listings, pagination, and mobile filter behaviour.
- Amaley Templates will manage Elementor-native visual sections and templates.
- Amaley Project Guard and Amaley Debug Toolkit will manage health checks, warnings, and debug visibility.

Do not remove ACF, CPT UI, JetEngine, Smart Filters, or existing dependencies blindly from the current live site.

Removal must happen only after Amaley Core and Amaley Discovery Engine fully replace the required functionality and QA is complete.

## Plugin Roles

### WooCommerce

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

Custom plugins must not replace WooCommerce.

### Amaley Templates

Purpose:

- Elementor-native template widgets
- Single product sections
- Shop page sections
- Product hero
- Product info tabs
- Trust strips
- Origin / traceability display
- Future quick view or popup modules

### Amaley Discovery Engine

Purpose:

- Product discovery
- Filters
- Listings
- Pagination
- Cluster / SHG / Member discovery layouts

### Future Amaley Core

Future purpose:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage origin fields
- Manage Cluster, SHG Group, and SHG Member data
- Add health/debug checks
- Reduce dependency on third-party plugins

## Migration Rule

Do not migrate everything in one step.

Migration must happen in phases.

## Phase 1 — Documentation and Backup

Status: In progress

Tasks:

- Create Google Drive project structure
- Store latest `.wpress` backup
- Store active plugin ZIPs
- Create GitHub repository
- Add READ_FIRST file
- Add design system file
- Add changelog
- Add migration plan

## Phase 2 — Source Code Organization

Tasks:

- Extract latest Amaley Templates plugin source
- Extract latest Amaley Discovery Engine plugin source
- Add source folders to GitHub
- Add plugin-level README files
- Add version notes
- Keep plugin ZIPs in Google Drive only

## Phase 3 — WordPress Audit

Tasks:

- List all active plugins
- Identify which plugins are essential
- Identify which plugins are temporary
- Identify which plugins are risky
- Document theme dependency
- Document Elementor templates
- Export WooCommerce products
- Export ACF fields
- Export CPT structures
- Export Elementor templates

## Phase 4 — Staging Setup

Tasks:

- Create staging or fresh WordPress setup
- Install lightweight base theme
- Install WooCommerce
- Install Elementor Pro
- Install Fluent Forms
- Install Amaley Discovery Engine
- Install Amaley Templates
- Import limited test products
- Test product page
- Test shop page
- Test mobile layout

## Phase 5 — Dependency Replacement

Do not remove ACF, CPT UI, JetEngine, or Freshen until replacements are tested.

Replacement order:

1. Product page structure
2. Shop page structure
3. Product filters
4. Origin fields
5. Cluster / SHG / Member data
6. Forms
7. Header and footer
8. Cart and checkout styling
9. Theme-dependent layouts

## Phase 6 — QA

Test before approval:

- Homepage
- Shop page
- Single product page
- Product variations
- Cart
- Checkout
- Mobile menu
- Filters
- Product origin display
- Cluster pages
- SHG group pages
- SHG member pages
- Forms
- Speed
- Cache behavior
- Elementor CSS regeneration

## Rollback Rule

Before every migration step:

1. Take a backup.
2. Record current versions.
3. Make one controlled change.
4. Test.
5. Document result.
6. Keep rollback file ready.

No undocumented migration work is allowed.

## Non-Negotiable Rule

Migration is not redesign chaos.

Migration must preserve:

- Amaley brand identity
- Product structure
- WooCommerce reliability
- Design consistency
- Mobile-first behavior
- Origin and traceability storytelling
- Future scalability
