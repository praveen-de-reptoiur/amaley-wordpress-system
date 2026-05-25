# Amaley Debug Toolkit

This folder will contain the clean source code for the future Amaley Debug Toolkit plugin.

Amaley Debug Toolkit will be the admin-only diagnostic and troubleshooting layer for the Amaley WordPress system.

## Plugin Role

Amaley Debug Toolkit exists to help developers and admins understand what is broken, where it is broken, and why it may be broken.

It should help diagnose:

- Plugin health issues
- Elementor widget registration issues
- WooCommerce dependency issues
- Product and origin data issues
- Missing fields
- Missing relationships
- Cache-related problems
- Template dependency problems
- Migration-related issues

## What This Plugin Should Do

Debug Toolkit should provide admin-only diagnostic visibility for:

- WordPress version
- PHP version
- Active Amaley plugin versions
- WooCommerce status
- Elementor status
- Elementor Pro status where required
- Registered Elementor widgets
- Registered CPTs
- Registered fields
- Product origin mapping status
- Missing Cluster links
- Missing SHG Group links
- Missing SHG Member links
- Query/filter status
- Cache warning notes

## What This Plugin Must Not Do

Debug Toolkit must not:

- Replace WooCommerce
- Replace Elementor
- Replace Amaley Templates
- Replace Amaley Discovery Engine
- Replace Amaley Core
- Replace Amaley Project Guard
- Display debug data publicly
- Slow down the frontend
- Expose private server data
- Expose passwords or API keys
- Show full raw error logs to public users
- Make automatic destructive changes

## Relationship With Amaley Project Guard

Project Guard gives high-level safety status.

Debug Toolkit gives deeper diagnostic detail.

They must remain separate.

Example:

Project Guard says:

- Amaley Core field missing

Debug Toolkit helps show:

- Which field is missing
- Which product is affected
- Which relationship is broken
- Which template or widget may be impacted

## Admin Dashboard

Debug Toolkit should eventually provide an admin-only dashboard.

Possible dashboard sections:

- System Overview
- Plugin Status
- Elementor Widget Status
- WooCommerce Status
- Product Data Status
- Origin Mapping Status
- CPT and Field Status
- Cache Notes
- Recent Warnings
- Export Debug Report

## Exportable Debug Report

Debug Toolkit should eventually allow admins to export a safe diagnostic report.

The report may include:

- WordPress version
- PHP version
- Active plugin versions
- Theme name
- WooCommerce status
- Elementor status
- Registered Amaley widgets
- Missing CPT warnings
- Missing field warnings
- Product origin data warnings

The report must not include:

- Passwords
- API keys
- License keys
- Database credentials
- Full server paths
- wp-config.php
- Private user data
- Full raw error logs

## Product and Origin Diagnostics

Debug Toolkit should help identify:

- Products without origin data
- Products with missing Cluster link
- Products with missing SHG Group link
- Products with missing SHG Member link
- Broken producer / maker references
- Empty traceability fields
- Missing usage fields
- Missing storage fields
- Incomplete origin display data

Do not create fake data to fix warnings.

Warnings should help humans fix the real data.

## Elementor Diagnostics

Debug Toolkit should help identify:

- Missing Amaley widgets
- Failed widget registration
- Widgets registered in wrong category
- Missing template dependencies
- Broken widget render state
- Elementor not active
- Elementor Pro missing where required

## WooCommerce Diagnostics

Debug Toolkit should help identify:

- WooCommerce inactive
- Product page unavailable
- Product variation issues
- Add-to-cart flow issues
- Cart page missing
- Checkout page missing
- Product data missing
- Product image/gallery issues

WooCommerce remains the commerce engine.

## Cache Diagnostics

Debug Toolkit should help identify possible cache problems.

It may show notes such as:

- Cache plugin active
- Elementor CSS may need regeneration
- Frontend may be showing old CSS
- Plugin update may require cache purge
- Mobile layout issue may be cache-related

Debug Toolkit should not automatically clear cache unless explicitly designed and approved.

## Security Rule

Debug Toolkit must be admin-only.

Required practices:

- Check user capabilities
- Verify nonces for actions
- Escape output
- Sanitize input
- Hide private data
- Avoid exposing server secrets
- Avoid exposing full file paths publicly
- Avoid exposing full raw logs publicly

## Performance Rule

Debug Toolkit must not slow down the frontend.

Heavy checks should run only:

- In admin dashboard
- On manual refresh
- On debug report export
- During explicit diagnostic action

No heavy frontend scans.

## Relationship With Other Plugins

### Amaley Templates

Debug Toolkit checks whether template widgets are registered and rendering safely.

### Amaley Discovery Engine

Debug Toolkit checks whether filter, query, pagination, and empty-state logic may be working.

### Amaley Core

Debug Toolkit checks whether CPTs, fields, and relationships are available.

### Amaley Project Guard

Debug Toolkit provides deeper details after Project Guard identifies a risk.

## CSS Rule

Debug Toolkit should avoid frontend CSS.

Admin CSS must be scoped.

Allowed prefix:

    .amaley-debug-

Avoid unsafe global selectors:

    body {}
    button {}
    .card {}
    h1 {}
    .notice {}

## PHP Rule

Use prefixed classes and functions.

Allowed prefixes:

    Amaley_Debug_
    amaley_debug_

## Production Rule

This plugin must be:

- Versioned
- Documented
- Admin-safe
- Permission-safe
- Frontend-light
- Non-destructive
- Conflict-safe
- Rollback-safe
- Debuggable

## Hard Rule

If this plugin cannot be tested, debugged, and rolled back, it is not production-ready.
