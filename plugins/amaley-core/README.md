# Amaley Core

This folder will contain the clean source code for the future Amaley Core plugin.

Amaley Core will become the controlled data layer for the Amaley WordPress system.

## Plugin Role

Amaley Core is planned to manage Amaley’s core data structures.

It should eventually replace permanent dependency on:

- ACF
- CPT UI
- Random field/helper plugins

## What Amaley Core Should Manage

Amaley Core should manage:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village data
- Source region data
- Traceability fields
- Product usage fields
- Storage instruction fields
- System health checks

## Custom Post Types

Amaley Core should eventually register and manage custom post types such as:

- Cluster
- SHG Group
- SHG Member
- Producer / Maker if required

These must be registered safely and in a migration-friendly way.

## Product Origin Fields

Amaley Core should eventually manage product origin fields such as:

- Origin short line
- Linked cluster
- Linked SHG group
- Linked producer / maker
- Village / source location
- Region / source belt
- Harvest / collection season
- Processing method
- Traceability note
- Ingredients note
- How to use
- Storage instructions
- Shelf life
- Allergen note
- Producer quote / maker note

## WooCommerce Relationship

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

Amaley Core should only add Amaley-specific data and relationships around WooCommerce products.

It must not replace WooCommerce.

## ACF / CPT UI Replacement Rule

ACF and CPT UI may exist in the old/current WordPress setup.

But they should not remain permanent core dependencies.

Replacement must happen only after:

- Amaley Core fields are ready
- Data migration is tested
- Backups are available
- Rollback plan exists
- QA is complete

Do not remove ACF or CPT UI blindly from any live/current site.

## Data Integrity Rule

Do not create fake origin data.

Do not create dummy Clusters, SHG Groups, SHG Members, or Producers unless explicitly approved.

Origin data must be:

- Verified
- Traceable
- Linked correctly
- Safe to migrate
- Easy to audit

## Admin Experience

Amaley Core should provide clean admin management for:

- Cluster data
- SHG Group data
- SHG Member data
- Product origin data
- Traceability data
- Health checks

Admin screens should be simple, non-confusing, and safe for non-coders.

## Migration Safety

Amaley Core must be built carefully.

Migration should happen in phases:

1. Register data structure safely.
2. Add fields safely.
3. Import test data.
4. Map test products.
5. Validate frontend output.
6. Validate admin editing.
7. Test rollback.
8. Only then replace old dependency.

## Relationship With Other Plugins

### Amaley Templates

Amaley Templates displays visual sections and Elementor widgets.

Amaley Core provides the data.

### Amaley Discovery Engine

Amaley Discovery Engine filters, searches, lists, and paginates content.

Amaley Core provides the structured data.

### Amaley Project Guard

Project Guard checks whether required CPTs, fields, and dependencies are available.

### Amaley Debug Toolkit

Debug Toolkit helps identify product/origin data problems, field issues, and broken relationships.

## CSS Rule

Amaley Core should not add unnecessary frontend styling.

If frontend styling is required, use scoped prefixes only.

Allowed prefix:

    .amaley-core-

Avoid unsafe global selectors:

    body {}
    button {}
    .card {}
    h1 {}
    .elementor-widget {}

## PHP Rule

Use prefixed classes and functions.

Allowed prefixes:

    Amaley_Core_
    amaley_core_

## Security Rule

Amaley Core must protect data properly.

Required practices:

- Sanitize input
- Escape output
- Check capabilities
- Verify nonces
- Avoid public exposure of private admin data
- Avoid direct database manipulation unless necessary and documented

## Debug Requirement

Amaley Core should support future Project Guard / Debug Toolkit checks.

It should expose or document:

- Plugin version
- Registered CPT status
- Registered field status
- WooCommerce dependency status
- Data mapping status
- Missing relationship warnings
- Migration status

## Production Rule

This plugin must be:

- Versioned
- Documented
- WooCommerce-safe
- Admin-safe
- Migration-safe
- Rollback-safe
- Conflict-safe
- Debuggable

## Hard Rule

If this plugin cannot be tested, debugged, and rolled back, it is not production-ready.
