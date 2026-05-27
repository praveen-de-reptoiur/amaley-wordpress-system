# Amaley Plugins

This folder contains the planned source-code structure for Amaley custom WordPress plugins and future Amaley component modules.

Plugin ZIP backups stay in Google Drive.  
Clean extracted source code and planning documentation belong in GitHub.

---

## Target Plugin / Module Structure

```text
plugins/
  README.md
  amaley-core/
  amaley-discovery-engine/
  amaley-site-shell/
  amaley-ui-sections-kit/
  amaley-templates/
  amaley-project-guard/
  amaley-debug-toolkit/
```

---

## Current Active Plugin ZIPs

Stored in Google Drive:

```text
amaley-core-v1.0.2.zip
amaley-site-shell-v1.0.1.zip
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

These ZIPs are backups, not source folders.

Do not upload plugin ZIPs into this GitHub folder.

---

## Target Architecture Direction

The future Amaley system should not depend permanently on ACF, CPT UI, JetEngine, Smart Filters, random utility plugins, or page-builder widgets as core architecture.

These may exist in old/current WordPress setups, but they are not the final target architecture.

Target direction:

- Amaley Core will manage custom post types, core fields, origin data, and system data structures.
- Amaley Discovery Engine will manage discovery, filters, listings, pagination, sorting, search, and mobile filter behaviour.
- Amaley Site Shell will manage header, footer, mobile menu, navigation shell, and shell-level UI when approved.
- Amaley UI Sections Kit will manage lightweight, WordPress-native, no-Elementor-dependency UI sections and components.
- Amaley Templates may support existing template-level WooCommerce/page work during transition, but future clean UI sections should move toward Amaley UI Sections Kit.
- Amaley Project Guard / Debug Toolkit will manage health checks, dependency warnings, and debug visibility.

---

## No-Elementor Dependency Rule for Future UI Sections

For the future clean Amaley website, new Amaley UI sections must not depend on Elementor default widgets.

Do not build future Amaley sections using:

- Elementor Heading widget
- Elementor Button widget
- Elementor Icon Box widget
- Elementor Image Box widget
- Elementor HTML widget
- Elementor generic section layouts as the main system
- Elementor-based raw HTML blocks for important page sections

Elementor may still exist in old/current site setups during migration, but future custom UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks, and story sections must come from Amaley-controlled components.

If old/current documentation mentions Elementor, treat it as migration/current-site context.  
For the future clean UI/component system, the stricter no-Elementor dependency rule applies.

---

## Performance Rule

The Amaley website must remain extremely lightweight.

It must load fast even in low-network areas and must not become heavy after products, sections, origin data, or future modules are added.

Every plugin/module must follow:

- Low-network-first performance
- Mobile-first layout
- No unnecessary external libraries
- No heavy animation libraries
- No global CSS dumps
- No duplicate CSS/JS
- No unnecessary frontend requests
- No unlimited frontend queries
- Optimized image output
- Clean HTML output
- Small vanilla JavaScript only where required
- Admin-only diagnostics kept away from public frontend

If a component looks premium but makes the site heavy, it is not approved.

---

## Global Design Token Direction

The future Amaley UI/component system must be globally controlled through design tokens.

When the final Amaley brand PDF is provided, global tokens should control:

- Brand colors
- Background colors
- Text colors
- Heading font
- Body font
- Font sizes
- Button styling
- Border radius
- Card styling
- Shadows
- Section spacing
- Mobile spacing
- Product card styling
- Trust strip styling

If global font, color, radius, spacing, or button style changes, connected UI components should update without editing every section manually.

---

## Custom Data System Plan

Amaley Core will eventually manage its own data structures for:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region information
- Traceability fields
- Product usage and storage fields

These should not remain permanently dependent on ACF or CPT UI.

Do not create fake Cluster, SHG, Producer, or origin data.

---

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

---

## Plugin / Module Roles

### amaley-core

Core data and system backbone.

Current / planned role:

- Register Amaley CPTs safely
- Manage product origin fields
- Manage Cluster, SHG Group, and SHG Member data
- Manage product origin mapping
- Reduce dependency on third-party field/CPT plugins
- Add system-level health checks
- Keep data migration-safe

Rule:

Amaley Core handles data backbone only.  
It must not become a frontend design plugin.

---

### amaley-discovery-engine

Discovery and listing system.

Role:

- Product filtering
- Product grids
- Search
- Sorting
- Pagination
- Mobile filter drawer
- Cluster discovery
- SHG group discovery
- SHG member discovery
- Safe empty states

Rule:

Discovery Engine must remain separate from Amaley Core, Amaley Templates, and Amaley UI Sections Kit.

It must stay lightweight and avoid expensive unlimited frontend queries.

---

### amaley-site-shell

Header/footer shell system.

Role:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- CTA controls
- Footer contact and link controls

Current status:

- v1.0.1 source exists
- Shortcode/manual mode tested
- Auto-render exists but remains on HOLD
- Full replacement must be tested only on fresh/staging after source of existing header/footer is confirmed

Rule:

Amaley Site Shell must not blindly override live/current header and footer.

---

### amaley-ui-sections-kit

Future lightweight WordPress-native UI section/component system.

Role:

- Buttons
- Button groups
- Section headings
- Heading strips
- Promise strips
- Product cards
- Product grids
- Story sections
- Media + text sections
- Trust strips
- CTA bands
- Origin blocks
- Cluster cards
- SHG / women collective cards
- Contact blocks
- Footer CTA sections

Rules:

- No Elementor default widget dependency
- No Elementor HTML widget dependency
- No CPT creation
- No WooCommerce replacement
- No header/footer replacement
- No discovery/filter engine replacement
- Low-network-first
- Global design-token controlled
- No plugin ZIP should be built until structure, inventory, design tokens, and phase plan are approved

---

### amaley-templates

Template-level support module.

Role:

- Existing or transitional template-level WooCommerce/page sections
- Single product section support where already planned
- Shop page section support where already planned
- Product hero / info tabs / trust strip / origin display where already implemented or required during migration

Rule:

Amaley Templates must not replace WooCommerce.

Future clean reusable UI components should move toward Amaley UI Sections Kit instead of relying on Elementor default widgets.

---

### amaley-project-guard

Future safety and project protection plugin.

Purpose:

- Show active Amaley plugin versions
- Show required dependency status
- Detect missing WooCommerce
- Detect risky duplicate plugins
- Detect old or broken Amaley plugin versions
- Warn before unsafe activation
- Provide admin-only status dashboard

This plugin should help identify what is broken before the site becomes unusable.

Rule:

Project Guard must remain admin-only/lightweight and must not slow down the public frontend.

---

### amaley-debug-toolkit

Future admin-only debug toolkit.

Purpose:

- Record plugin health status
- Show widget/module registration status
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

Rule:

Debug Toolkit must not expose secrets or slow down the public frontend.

---

## Debug Philosophy

A serious website needs observability.

If something breaks, we should be able to answer:

- Which plugin changed?
- Which version is active?
- Which dependency is missing?
- Which template failed?
- Which component failed?
- Which WooCommerce flow is affected?
- Is this a frontend, backend, theme, plugin, cache, or data issue?

If the system cannot answer these questions, the architecture is weak.

---

## Minimum Health Checks

Every Amaley custom plugin should expose or support:

- Plugin version
- WordPress version check
- PHP version check
- WooCommerce active check where relevant
- Required CPT check where relevant
- Required field check where relevant
- Admin notice if dependency is missing
- Safe fallback if dependency is missing
- Rollback or disable guidance

Elementor checks are required only for old/current modules that still depend on Elementor during migration.

Future Amaley UI Sections Kit must not depend on Elementor default widgets.

---

## Migration Warning

Do not remove ACF, CPT UI, JetEngine, Smart Filters, Elementor, Elementor Pro, or any existing dependency from any live/current site blindly.

They may still support old content, fields, templates, layouts, or filters.

Removal must happen only after Amaley Core, Amaley Discovery Engine, Amaley UI Sections Kit, and other approved modules fully replace the required functionality and QA is complete.

---

## Development Rules

Every plugin/module must be:

- Scoped
- Versioned
- Conflict-safe
- WooCommerce-safe
- Lightweight
- Low-network-ready
- Mobile-first
- Documented
- Reversible
- Debuggable
- Global-design-token compatible where relevant
- Non-coder manageable where relevant

---

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
.amaley-shell-
.amaley-ui-
.amaley-guard-
.amaley-debug-
```

CSS must be scoped, necessary, mobile-safe, and must not leak into WooCommerce, theme, or unrelated plugin areas.

---

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

Amaley_Shell_
amaley_shell_

Amaley_UI_
amaley_ui_

Amaley_Guard_
amaley_guard_

Amaley_Debug_
amaley_debug_
```

Every plugin must include direct-access protection, sanitization, escaping, nonce checks where needed, capability checks where needed, and safe fallbacks.

---

## Security Rules

Debug tools and admin tools must not expose:

- Database credentials
- API keys
- License keys
- Server secrets
- `wp-config.php`
- Full error logs to public users

---

## Production Rule

Debug tools must not slow down the frontend.

Heavy checks should run only:

- In admin dashboard
- On manual refresh
- On plugin health screen
- During explicit diagnostic export

---

## Step-by-Step Workflow Rule

Future Amaley work must move in small steps.

Rule:

- One task at a time
- No parallel build/update/confusion
- Ask before starting plugin build
- Ask before ZIP creation
- Ask before Drive upload
- Ask before GitHub structural change
- Complete current step first
- Check current step
- Then move to next step

No build should start without approval.

---

## Hard Rule

Do not put random plugin ZIPs here.

This folder is for clean source code and approved planning documentation only.

If a plugin cannot be tested, debugged, documented, rolled back, and managed safely, it is not production-ready.
