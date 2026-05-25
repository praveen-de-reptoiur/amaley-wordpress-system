# Amaley Project Guard

This folder will contain the clean source code for the future Amaley Project Guard plugin.

Amaley Project Guard will be the safety, dependency, and health-check layer for the Amaley WordPress system.

## Plugin Role

Amaley Project Guard exists to prevent silent breakage.

It should help admins and developers quickly understand:

- Which Amaley plugins are active
- Which versions are active
- Which dependencies are missing
- Which old or broken plugins are still present
- Which required CPTs are missing
- Which required fields are missing
- Whether WooCommerce is active
- Whether Elementor is active
- Whether required templates or widgets may be broken

## What This Plugin Should Check

Project Guard should check:

- WordPress version
- PHP version
- WooCommerce status
- Elementor status
- Elementor Pro status where required
- Amaley Templates status
- Amaley Discovery Engine status
- Amaley Core status
- Amaley Debug Toolkit status
- Required CPT availability
- Required field availability
- Old Amaley plugin versions
- Duplicate Amaley plugin folders
- Broken or archived plugin folders

## Active Plugin Version Visibility

Project Guard should show active versions for:

- Amaley Templates
- Amaley Discovery Engine
- Amaley Core
- Amaley Project Guard
- Amaley Debug Toolkit

The admin should immediately know which version is running.

## Dependency Warning Rule

If a required dependency is missing, the plugin should show a clear admin notice.

Examples:

- WooCommerce is missing
- Elementor is missing
- Elementor Pro is missing where required
- Required CPT is missing
- Required field is missing
- Old plugin version is active
- Duplicate plugin folder found

Warnings must be clear, not scary, and not public-facing.

## Admin Dashboard

Project Guard should eventually provide an admin-only dashboard.

Dashboard sections may include:

- System status
- Plugin status
- Dependency status
- WooCommerce status
- Elementor status
- CPT status
- Field status
- Template status
- Risk warnings
- Suggested next action

## What This Plugin Must Not Do

Project Guard must not:

- Replace WooCommerce
- Replace Elementor
- Replace Amaley Templates
- Replace Amaley Discovery Engine
- Replace Amaley Core
- Make frontend layout changes
- Slow down the public frontend
- Expose debug information publicly
- Delete files automatically
- Deactivate plugins without explicit approval

## Safety Philosophy

A serious production website needs visibility.

If something breaks, we should be able to answer:

- What changed?
- Which plugin changed?
- Which version is active?
- Which dependency is missing?
- Which template may be affected?
- Which widget may be affected?
- Is the issue related to theme, plugin, cache, data, or template?

If the system cannot answer these questions, the architecture is weak.

## Relationship With Other Plugins

### Amaley Templates

Project Guard checks if Amaley Templates is active and whether expected widgets may be available.

### Amaley Discovery Engine

Project Guard checks if Discovery Engine is active and whether discovery/filter functionality may be available.

### Amaley Core

Project Guard checks if Amaley Core is active and whether required CPTs and fields are registered.

### Amaley Debug Toolkit

Project Guard gives high-level safety status.

Debug Toolkit gives deeper diagnostic reports.

They must remain separate.

## CSS Rule

Project Guard should avoid frontend CSS unless absolutely required.

Admin CSS must be scoped.

Allowed prefix:

    .amaley-guard-

Avoid unsafe global selectors:

    body {}
    button {}
    .card {}
    h1 {}
    .notice {}

## PHP Rule

Use prefixed classes and functions.

Allowed prefixes:

    Amaley_Guard_
    amaley_guard_

## Security Rule

Project Guard must be admin-only.

Required practices:

- Check user capabilities
- Verify nonces for actions
- Escape output
- Sanitize input
- Do not expose server secrets
- Do not expose `wp-config.php`
- Do not expose full error logs publicly
- Do not expose private paths to public users

## Performance Rule

Project Guard must not slow down the frontend.

Heavy checks should run only:

- In admin dashboard
- On manual refresh
- On project health screen
- During explicit diagnostic action

## Migration Rule

Project Guard should help during migration by warning about:

- Missing dependencies
- Old plugin versions
- Duplicate plugin folders
- Missing CPTs
- Missing fields
- Risky dependency removal
- Incomplete replacement state

It should not automatically remove dependencies.

## Production Rule

This plugin must be:

- Versioned
- Documented
- Admin-safe
- Permission-safe
- Frontend-light
- Conflict-safe
- Rollback-safe
- Debuggable

## Hard Rule

If this plugin cannot be tested, debugged, and rolled back, it is not production-ready.
