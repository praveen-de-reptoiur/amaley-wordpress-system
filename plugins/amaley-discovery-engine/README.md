# Amaley Discovery Engine

This folder will contain the clean source code for the Amaley Discovery Engine plugin.

Amaley Discovery Engine is responsible for discovery, filtering, listing, search, sorting, pagination, and mobile filter behaviour for the Amaley WordPress system.

## Plugin Role

Amaley Discovery Engine handles:

- Product discovery
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
- Cluster / SHG / Member discovery layouts

## What This Plugin Must Not Do

Amaley Discovery Engine must not replace WooCommerce.

WooCommerce remains responsible for:

- Products
- Prices
- Stock
- Variations
- Cart
- Checkout
- Orders
- Reviews

This plugin should query, filter, and display WooCommerce and Amaley data safely.

## Dependency Direction

The future Amaley system should not depend permanently on:

- JetEngine
- Smart Filters
- ACF
- CPT UI
- Random utility plugins

Amaley Discovery Engine should eventually replace JetEngine / Smart Filters dependency for filtering and discovery.

## Relationship With Amaley Templates

Amaley Discovery Engine manages discovery logic.

Amaley Templates manages visual/template sections manages visual.

They must remain separate.

Discovery Engine should not become a template plugin.  
Templates should not become a filtering engine.

## Elementor Role

This plugin may provide Elementor-native widgets for:

- Product discovery grid
- Filter panel
- Search bar
- Sort dropdown
- Active filter chips
- Pagination
- Mobile filter drawer
- Cluster discovery
- SHG discovery
- Member discovery

Controls must be organized section-wise:

- Wrapper
- Filter Panel
- Search
- Sort
- Product Grid
- Cards
- Pagination
- Mobile Drawer
- Empty State
- Spacing
- Responsive Layout

## Design Rule

All frontend output must follow:

- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`

No random fonts.  
No random colours.  
No inconsistent filter styles.  
No unmanaged spacing.  
No broken mobile filter behaviour.

## CSS Rule

Use scoped CSS only.

Allowed prefix:

    .amaley-discovery-

Avoid unsafe global selectors:

    body {}
    button {}
    .card {}
    h1 {}
    .elementor-widget {}

## PHP Rule

Use prefixed classes and functions.

Allowed prefixes:

    Amaley_Discovery_
    amaley_discovery_

## Query Safety

Queries must be safe and predictable.

Rules:

- Sanitize user input
- Validate filter values
- Avoid heavy frontend queries
- Avoid exposing private data
- Avoid breaking WooCommerce product loops
- Avoid duplicate query conflicts with Elementor or theme loops

## Mobile Rule

Mobile filtering must be clean and usable.

Required behaviour:

- No horizontal scroll
- No hidden filter buttons
- No filter drawer covering checkout/cart actions
- Clear close button
- Clear reset option
- Active filters visible
- Empty state visible
- Product grid remains readable

## Empty State Rule

When no results are found, the plugin must show a clean empty state.

The empty state should explain:

- No matching products or entries were found
- User can reset filters
- User can try another search
- User can browse all products

Do not show broken blank sections.

## Debug Requirement

The plugin should support future Project Guard / Debug Toolkit checks.

It should expose or document:

- Plugin version
- Required dependencies
- Registered widgets
- Registered filters
- Query status
- Pagination status
- Empty-state status
- WooCommerce dependency status

## Production Rule

This plugin must be:

- Versioned
- Documented
- WooCommerce-safe
- Elementor-safe
- Query-safe
- Mobile-first
- Conflict-safe
- Rollback-safe
- Debuggable

## Hard Rule

If this plugin cannot be tested, debugged, and rolled back, it is not production-ready.
