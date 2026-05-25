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
- Debuggable
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
- JetEngine
- Smart Filters
- Other utility plugins
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
- Admin editing workflows
- Existing content relationships

## Target Long-Term Stack

Preferred future setup:

- Lightweight base theme
- WooCommerce
- Elementor Pro
- Fluent Forms
- Amaley Core
- Amaley Discovery Engine
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit
- LiteSpeed Cache only after layout is stable

## Dependency Direction

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, or random utility plugins.

These plugins may exist in the current or old WordPress setup, but they are not part of the target architecture.

Target direction:

- Amaley Core will manage custom post types and fields.
- Amaley Discovery Engine will manage discovery, filters, listings, pagination, and mobile filter behaviour.
- Amaley Templates will manage Elementor-native visual sections and templates.
- Amaley Project Guard will manage safety checks, version visibility, dependency warnings, and risky plugin detection.
- Amaley Debug Toolkit will manage admin-only debug visibility, health reports, and developer diagnostics.

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

Custom Amaley plugins must support WooCommerce, not replace it.

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

Rule:

Amaley Templates must not replace WooCommerce.

### Amaley Discovery Engine

Purpose:

- Product discovery
- Filters
- Listings
- Pagination
- Cluster / SHG / Member discovery layouts
- Mobile filter behaviour
- Safe empty-state handling

Rule:

Discovery Engine must remain separate from Amaley Templates.

### Amaley Core

Future purpose:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage product origin fields
- Manage Cluster, SHG Group, and SHG Member data
- Manage producer / maker profiles
- Manage traceability fields
- Add system-level health checks
- Reduce dependency on third-party plugins

### Amaley Project Guard

Future purpose:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect missing Elementor
- Detect risky duplicate plugins
- Detect old or broken Amaley plugin versions
- Detect required CPT/field availability
- Warn before unsafe activation
- Provide admin-only project health dashboard

This plugin exists to prevent silent breakage.

### Amaley Debug Toolkit

Future purpose:

- Record plugin health status
- Show Elementor widget registration status
- Show WooCommerce template dependency status
- Show product/origin data issues
- Show cache-related warnings
- Provide exportable debug reports for developers

Debug tools must be:

- Admin-only
- Permission-protected
- Safe for production
- Easy to disable
- Not visible to public users

## Migration Rule

Do not migrate everything in one step.

Migration must happen in controlled phases.

## Phase 1 — Documentation and Backup

Status: In progress

Tasks:

- Create Google Drive project structure
- Store latest `.wpress` backup
- Store active plugin ZIPs
- Create GitHub repository
- Add README
- Add READ_FIRST file
- Add design system file
- Add changelog
- Add migration plan
- Add Drive folder map
- Add QA checklist
- Add project manifest
- Add plugins architecture guide

## Phase 2 — Source Code Organization

Tasks:

- Extract latest Amaley Templates plugin source
- Extract latest Amaley Discovery Engine plugin source
- Add source folders to GitHub
- Add plugin-level README files
- Add version notes
- Keep plugin ZIPs in Google Drive only
- Keep GitHub clean from backup ZIPs

Planned GitHub source structure:

```text
plugins/
  README.md
  amaley-templates/
  amaley-discovery-engine/
  amaley-core/
  amaley-project-guard/
  amaley-debug-toolkit/
```

## Phase 3 — WordPress Audit

Tasks:

- List all active plugins
- Identify which plugins are essential
- Identify which plugins are temporary
- Identify which plugins are risky
- Document theme dependency
- Document Elementor templates
- Export WooCommerce products
- Export ACF fields if currently used
- Export CPT structures if currently used
- Export Elementor templates
- Export product origin mappings
- Identify filters currently dependent on JetEngine or Smart Filters

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
- Test filters
- Test cart
- Test checkout

## Phase 5 — Dependency Replacement

Do not remove ACF, CPT UI, JetEngine, Smart Filters, or theme dependency until replacements are tested.

Replacement order:

1. Product page structure
2. Shop page structure
3. Product filters
4. Origin fields
5. Cluster data
6. SHG Group data
7. SHG Member data
8. Producer / maker profiles
9. Product origin mapping
10. Forms
11. Header and footer
12. Cart and checkout styling
13. Theme-dependent layouts

## Phase 6 — Amaley Core Build

Amaley Core should eventually handle:

- Cluster CPT
- SHG Group CPT
- SHG Member CPT
- Product origin fields
- Producer / maker data
- Source village data
- Region / source belt data
- Traceability fields
- Product usage fields
- Storage instruction fields
- Admin health checks

This must be built carefully and tested on staging before replacing ACF or CPT UI.

## Phase 7 — Discovery Engine Replacement

Amaley Discovery Engine should eventually replace JetEngine / Smart Filters dependency.

Discovery Engine should support:

- Product search
- Product category filtering
- Product origin filtering
- Cluster filtering
- SHG filtering
- Producer filtering
- Sorting
- Pagination
- Active filter chips
- Mobile filter drawer
- Empty-state handling
- Elementor widget controls

## Phase 8 — Project Guard and Debug Toolkit

Amaley Project Guard should provide:

- Active plugin version status
- Required dependency checks
- Old plugin warning
- Duplicate plugin warning
- Missing CPT warning
- Missing field warning
- Admin-only status screen

Amaley Debug Toolkit should provide:

- Elementor widget status
- WooCommerce flow status
- Origin data issue report
- Cache warning notes
- Exportable debug report

These tools should not slow down the frontend.

## Phase 9 — QA

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
- Mobile-first behaviour
- Origin and traceability storytelling
- Future scalability
- Debug visibility

## Hard Rule

If a dependency is removed before its replacement is tested, that is reckless.

If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.
