# AMALEY FRESH WORDPRESS MIGRATION PLAN

This document defines the safe migration direction for Amaley.

The goal is not to randomly rebuild the website.  
The goal is to move Amaley toward a cleaner, faster, scalable, lightweight, low-network-ready, and more controlled WordPress system.

---

## Migration Objective

Move Amaley from the current theme/plugin-heavy setup toward a cleaner WordPress architecture.

The future setup should be:

- Lightweight
- Low-network-ready
- WooCommerce-first
- WordPress-native where possible
- Elementor-compatible only for old/current migration context
- Not dependent on Elementor default widgets for future clean UI sections
- Mobile-first
- Design-system consistent
- Global design-token controlled
- Conflict-safe
- Debuggable
- Easier to maintain
- Easier for future developers to understand
- Easy to rollback

---

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
- Existing Elementor templates
- Existing shortcodes/widgets
- Existing header/footer source

These must not be removed blindly.

Blind removal can break:

- Product pages
- Shop page
- Filters
- Header/footer
- Mobile menu
- Product origin sections
- Cluster / SHG / Member layouts
- Elementor templates
- WooCommerce cart or checkout
- Mobile responsiveness
- Admin editing workflows
- Existing content relationships
- Existing SEO structure
- Existing product data

---

## Target Long-Term Stack

Preferred future setup:

- Lightweight base theme
- WooCommerce
- Fluent Forms if needed
- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit
- LiteSpeed Cache only after layout is stable

Elementor Pro may remain temporarily for old/current migration context, but future clean custom UI sections should not depend on Elementor default widgets.

---

## Dependency Direction

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins
- Page-builder default widgets for important custom UI sections

These plugins may exist in the current or old WordPress setup, but they are not part of the final target architecture.

Target direction:

- Amaley Core will manage custom post types, data structures, and origin fields.
- Amaley Discovery Engine will manage discovery, filters, listings, pagination, search, sorting, and mobile filter behaviour.
- Amaley Site Shell will manage header, footer, mobile header, mobile drawer, navigation, announcement strip, and footer controls.
- Amaley UI Sections Kit will manage future lightweight WordPress-native UI sections and components.
- Amaley Templates will support existing/transitional WooCommerce template-level sections.
- Amaley Project Guard will manage safety checks, version visibility, dependency warnings, and risky plugin detection.
- Amaley Debug Toolkit will manage admin-only debug visibility, health reports, and developer diagnostics.

Do not remove ACF, CPT UI, JetEngine, Smart Filters, Elementor, Elementor Pro, Freshen, Apus, or existing dependencies blindly from the current live site.

Removal must happen only after replacement functionality is tested, QA is complete, and rollback plan is available.

---

## Future UI Direction

Future clean Amaley UI must not be built through Elementor default widgets.

Do not build important future UI sections with:

- Elementor Heading widget
- Elementor Button widget
- Elementor Icon Box widget
- Elementor Image Box widget
- Elementor HTML widget
- Elementor generic section layouts as the main system

Future clean UI sections must come from Amaley-controlled components.

They should be:

- WordPress-native
- Theme-like
- Lightweight
- Low-network-ready
- Mobile-first
- Globally design-token controlled
- Easy to disable
- Easy to rollback
- Safe for WooCommerce

---

## Performance Rule

The Amaley website must remain extremely lightweight.

Every frontend module must follow:

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

## Plugin / Module Roles

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

Custom Amaley plugins/modules must support WooCommerce, not replace it.

---

### Amaley Core

Purpose:

- Register Amaley CPTs safely
- Manage Cluster data
- Manage SHG Group data
- Manage SHG Member / Producer data
- Manage product origin fields
- Manage product origin mapping
- Manage producer / maker profiles
- Manage source village / region data
- Manage traceability fields
- Manage product usage fields
- Manage storage instruction fields
- Add system-level health checks
- Reduce dependency on third-party field/CPT plugins
- Keep data migration-safe

Rule:

Amaley Core must become the controlled data layer for Amaley.  
It must not become a frontend design plugin.

---

### Amaley Discovery Engine

Purpose:

- Product discovery
- Filters
- Search
- Sorting
- Listings
- Pagination
- Product grids
- Cluster / SHG / Member discovery layouts
- Mobile filter behaviour
- Active filter chips
- Safe empty-state handling

Rule:

Discovery Engine must remain separate from Amaley Core, Amaley Templates, and Amaley UI Sections Kit.

It must stay lightweight and avoid expensive unlimited frontend queries.

---

### Amaley Site Shell

Purpose:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- CTA controls
- Footer contact and link controls

Current status:

- v1.0.1 source exists.
- Shortcode/manual mode tested.
- Auto-render exists but remains on HOLD.
- Full replacement must be tested only on fresh/staging after source of existing header/footer is confirmed.

Rule:

Amaley Site Shell must not blindly override live/current header and footer.

---

### Amaley UI Sections Kit

Purpose:

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

- `plugins/amaley-ui-sections-kit/` is the correct future UI sections planning folder.
- Old `plugins/amaley-widgets-kit/` was removed to avoid the wrong Elementor-only direction.
- No Elementor default widget dependency.
- No Elementor HTML widget dependency.
- No CPT creation.
- No WooCommerce replacement.
- No header/footer replacement.
- No discovery/filter engine replacement.
- Low-network-first.
- Global design-token controlled.
- No plugin ZIP should be built until structure, inventory, design tokens, and phase plan are approved.

---

### Amaley Templates

Purpose:

- Existing or transitional template-level WooCommerce/page sections
- Existing product template sections
- Existing shop template sections
- Product hero / info tabs / trust strip / origin display where already implemented or required during migration

Rule:

Amaley Templates must support WooCommerce, not replace it.

Future clean reusable UI components should move toward Amaley UI Sections Kit instead of relying on Elementor default widgets.

---

### Amaley Project Guard

Purpose:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect risky duplicate plugins
- Detect old or broken Amaley plugin versions
- Detect required CPT/field availability
- Warn before unsafe activation
- Provide admin-only project health dashboard

Rule:

Project Guard exists to prevent silent breakage.

It must remain admin-only/lightweight and must not slow down the public frontend.

---

### Amaley Debug Toolkit

Purpose:

- Record plugin health status
- Show module/component registration status
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
- Not exposing secrets
- Not slowing the public frontend

---

## Migration Rule

Do not migrate everything in one step.

Migration must happen in controlled phases.

No build, ZIP creation, Drive upload, or GitHub structural change should start without approval.

---

## Phase 1 — Documentation and Backup

Status: In progress / mostly completed

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
- Add performance and no-Elementor lock
- Add UI Sections Kit planning folder
- Remove old Widgets Kit direction
- Keep documentation aligned

---

## Phase 2 — Source Code Organization

Status: In progress

Tasks:

- Keep plugin ZIPs in Google Drive only
- Keep GitHub clean from backup ZIPs
- Keep extracted plugin source in GitHub
- Maintain plugin-level README files
- Maintain version notes
- Keep old plugin versions clearly archived
- Ensure active source matches active ZIP versions where applicable

Planned GitHub source structure:

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

Current active plugin ZIP backups in Google Drive:

```text
amaley-core-v1.0.2.zip
amaley-site-shell-v1.0.1.zip
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

---

## Phase 3 — WordPress Audit

Tasks:

- List all active plugins
- Identify which plugins are essential
- Identify which plugins are temporary
- Identify which plugins are risky
- Document theme dependency
- Document current header/footer source
- Document current menu source
- Document current Elementor templates
- Export WooCommerce products
- Export ACF fields if currently used
- Export CPT structures if currently used
- Export Elementor templates
- Export product origin mappings
- Identify filters currently dependent on JetEngine or Smart Filters
- Identify existing product card/shop loop source
- Identify current image sizes and media dependencies

---

## Phase 4 — Staging / Fresh Setup

Tasks:

- Create staging or fresh WordPress setup
- Install lightweight base theme
- Install WooCommerce
- Install Fluent Forms if needed
- Install Amaley Core
- Install Amaley Discovery Engine
- Install Amaley Site Shell only in safe/manual mode first
- Install Amaley Templates if needed for transitional sections
- Do not build/install Amaley UI Sections Kit until structure, inventory, global design tokens, and phase plan are approved
- Import limited test products
- Test product page
- Test shop page
- Test mobile layout
- Test filters
- Test cart
- Test checkout
- Test performance / low-network behavior

Elementor Pro may be installed only if required for old/current template migration, not as the future clean UI dependency.

---

## Phase 5 — Dependency Replacement

Do not remove ACF, CPT UI, JetEngine, Smart Filters, Elementor, Elementor Pro, Freshen, Apus, or theme dependency until replacements are tested.

Replacement order:

1. Backup and export data
2. Confirm current plugin/template/theme dependency
3. Confirm product data structure
4. Product origin mapping
5. Cluster data
6. SHG Group data
7. SHG Member / Producer data
8. Product filters
9. Shop page structure
10. Product page structure
11. Product card and product grid UI
12. Header and footer
13. Mobile menu
14. Forms
15. Cart and checkout styling
16. Theme-dependent layouts
17. Cache/performance optimization

---

## Phase 6 — Amaley Core Stabilization

Amaley Core should handle:

- Cluster CPT
- SHG Group CPT
- SHG Member / Producer CPT
- Product origin fields
- Product origin mapping
- Producer / maker data
- Source village data
- Region / source belt data
- Traceability fields
- Product usage fields
- Storage instruction fields
- Admin health checks

This must be built and tested on staging before replacing ACF or CPT UI.

No fake Cluster, SHG, Producer, or origin data should be created.

---

## Phase 7 — Discovery Engine Stabilization

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

This must stay separate from:

- Amaley Core
- Amaley Templates
- Amaley UI Sections Kit

---

## Phase 8 — Site Shell Stabilization

Amaley Site Shell should manage header/footer only after safe testing.

Steps:

1. Identify existing header/footer source.
2. Test shortcode/manual mode.
3. Confirm no conflict with theme header/footer.
4. Test mobile drawer.
5. Test navigation links.
6. Test footer links and contact details.
7. Keep auto-render OFF until approved.
8. Test full replacement only on fresh/staging.
9. Do not apply blind replacement on live/current site.

---

## Phase 9 — UI Sections Kit Planning

Before building Amaley UI Sections Kit:

1. Finalize section inventory.
2. Finalize global design tokens.
3. Confirm brand PDF / design rules.
4. Confirm component boundaries.
5. Confirm which sections are WordPress-native.
6. Confirm which sections need WooCommerce data.
7. Confirm no CPT/data responsibility.
8. Confirm no header/footer responsibility.
9. Confirm no discovery/filter responsibility.
10. Confirm no Elementor default widget dependency.
11. Confirm performance/low-network requirements.
12. Approve phase plan.

No UI Sections Kit ZIP should be built before this phase is approved.

---

## Phase 10 — Project Guard and Debug Toolkit

Amaley Project Guard should provide:

- Active plugin version status
- Required dependency checks
- Old plugin warning
- Duplicate plugin warning
- Missing CPT warning
- Missing field warning
- Admin-only status screen

Amaley Debug Toolkit should provide:

- Plugin health status
- Module/component registration status
- WooCommerce flow status
- Origin data issue report
- Cache warning notes
- Exportable debug report

These tools should not slow down the frontend.

---

## Phase 11 — QA

Test before approval:

- Homepage
- Shop page
- Single product page
- Product variations
- Cart
- Checkout
- Mobile menu
- Header
- Footer
- Filters
- Product cards
- Product grids
- Product origin display
- Cluster pages
- SHG group pages
- SHG member pages
- Forms
- Speed
- Low-network behavior
- Cache behavior
- Elementor CSS regeneration only if Elementor migration context is touched
- Global design token behavior
- No Elementor default widget dependency for future UI sections

Use:

```text
docs/QA_CHECKLIST.md
```

If it is not tested, it is not done.

---

## Rollback Rule

Before every migration step:

1. Take a backup.
2. Record current versions.
3. Make one controlled change.
4. Test.
5. Document result.
6. Keep rollback file ready.

No undocumented migration work is allowed.

---

## Step-by-Step Workflow Rule

Future Amaley work must move in small steps.

Rule:

- One task at a time.
- No parallel build/update/confusion.
- Ask before starting plugin build.
- Ask before ZIP creation.
- Ask before Drive upload.
- Ask before GitHub structural change.
- Complete current step first.
- Check current step.
- Then move to next step.

No build should start without approval.

---

## Non-Negotiable Rule

Migration is not redesign chaos.

Migration must preserve:

- Amaley brand identity
- Product structure
- WooCommerce reliability
- Design consistency
- Mobile-first behaviour
- Lightweight performance
- Low-network usability
- Origin and traceability storytelling
- Future scalability
- Debug visibility
- Rollback safety

---

## Hard Rule

If a dependency is removed before its replacement is tested, that is reckless.

If a plugin/module cannot be tested, debugged, documented, rolled back, and managed safely, it is not production-ready.

If a component looks premium but makes the site heavy, it is not approved.
