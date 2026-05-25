# Amaley Plugins

This folder contains the planned source-code structure for Amaley custom WordPress plugins.

Plugin ZIP backups stay in Google Drive.  
Clean extracted source code belongs in GitHub.

## Target Plugin Structure

```text
plugins/
  README.md
  amaley-templates/
  amaley-discovery-engine/
  amaley-core/
  amaley-project-guard/
  amaley-debug-toolkit/
```

## Current Active Plugin ZIPs

Stored in Google Drive:

```text
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

These ZIPs are backups, not source folders.

## Dependency Direction

The future Amaley system should not depend on ACF, CPT UI, JetEngine, Smart Filters, or random utility plugins as permanent core dependencies.

These may exist in old/current WordPress setups, but they are not part of the target architecture.

Target direction:

- Amaley Core will manage custom post types and fields.
- Amaley Discovery Engine will manage discovery, filters, listings, pagination, and mobile filter behaviour.
- Amaley Templates will manage Elementor-native visual sections and templates.
- Amaley Project Guard / Debug Toolkit will manage health checks, dependency warnings, and debug visibility.

## Custom Data System Plan

Amaley will eventually manage its own data structures for:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region information
- Traceability fields
- Product usage and storage fields

These should not remain permanently dependent on ACF or CPT UI.

## Filtering System Plan

Amaley should not depend permanently on JetEngine or Smart Filters.

Filtering should be handled by Amaley Discovery Engine.

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

## Plugin Roles

### amaley-templates

Elementor-native template widgets for:

- Single product sections
- Shop page sections
- Product hero
- Product info tabs
- Trust strip
- Origin and traceability display
- Future quick view or popup modules

Rule:

Amaley Templates must not replace WooCommerce.

### amaley-discovery-engine

Discovery and listing system for:

- Product filtering
- Product grids
- Pagination
- Cluster discovery
- SHG group discovery
- SHG member discovery

Rule:

Discovery Engine must remain separate from Amaley Templates.

### amaley-core

Future core plugin.

Planned role:

- Replace ACF dependency
- Replace CPT UI dependency
- Register Amaley CPTs safely
- Manage product origin fields
- Manage Cluster, SHG Group, and SHG Member data
- Add system-level health checks
- Reduce dependency on third-party plugins

### amaley-project-guard

Future safety and project protection plugin.

Purpose:

- Show active Amaley plugin versions
- Show required dependency status
- Detect missing WooCommerce
- Detect missing Elementor
- Detect risky duplicate plugins
- Detect old or broken Amaley plugin versions
- Warn before unsafe activation
- Provide admin-only status dashboard

This plugin should help identify what is broken before the site becomes unusable.

### amaley-debug-toolkit

Future admin-only debug toolkit.

Purpose:

- Record plugin health status
- Show Elementor widget registration status
- Show WooCommerce template dependency status
- Show product and origin data issues
- Show cache-related warnings
- Provide exportable debug report for developers

Debug output must be:

- Admin-only
- Non-public
- Permission-protected
- Safe for production
- Easy to disable

## Debug Philosophy

A serious website needs observability.

If something breaks, we should be able to answer:

- Which plugin changed?
- Which version is active?
- Which dependency is missing?
- Which template failed?
- Which widget failed?
- Which WooCommerce flow is affected?
- Is this a frontend, backend, theme, plugin, cache, or data issue?

If the system cannot answer these questions, the architecture is weak.

## Minimum Health Checks

Every Amaley custom plugin should expose or support:

- Plugin version
- WordPress version check
- PHP version check
- WooCommerce active check
- Elementor active check
- Elementor Pro active check where required
- Required CPT check
- Required field check
- Admin notice if dependency is missing
- Safe fallback if dependency is missing

## Migration Warning

Do not remove ACF, CPT UI, JetEngine, Smart Filters, or any existing dependency from any live/current site blindly.

They may still support old content, fields, templates, or filters.

Removal must happen only after Amaley Core and Amaley Discovery Engine fully replace the required functionality and QA is complete.

## Development Rules

Every plugin must be:

- Scoped
- Versioned
- Conflict-safe
- WooCommerce-safe
- Elementor-safe
- Mobile-first
- Documented
- Reversible
- Debuggable

## CSS Rules

Do not use unsafe global selectors like:

```css
body {}
button {}
.card {}
h1 {}
.elementor-widget {}
```

Use scoped prefixes such as:

```css
.amaley-tpl-
.amaley-discovery-
.amaley-core-
.amaley-guard-
.amaley-debug-
```

## PHP Rules

Use prefixed functions and classes.

Examples:

```php
Amaley_Tpl_
amaley_tpl_
Amaley_Discovery_
amaley_discovery_
Amaley_Core_
amaley_core_
Amaley_Guard_
amaley_guard_
Amaley_Debug_
amaley_debug_
```

## Security Rules

Debug tools must not expose:

- Database credentials
- API keys
- License keys
- Server secrets
- `wp-config.php`
- Full error logs to public users

## Production Rule

Debug tools must not slow down the frontend.

Heavy checks should run only:

- In admin dashboard
- On manual refresh
- On plugin health screen
- During explicit diagnostic export

## Hard Rule

Do not put random plugin ZIPs here.

This folder is for clean source code only.

If a plugin cannot be tested, debugged, and rolled back, it is not production-ready.
