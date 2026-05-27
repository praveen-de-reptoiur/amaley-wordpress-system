# READ FIRST — Amaley WordPress System

This repository is the controlled source-code and documentation space for the Amaley WordPress system.

It is maintained for long-term development, plugin/module work, design consistency, migration planning, QA, debugging, and developer handoff.

This file must be read before touching the project.

---

## Project Owner

Praveen  
GitHub Username: `praveen-de-reptoiur`

---

## Purpose of This Repository

This repository is for:

- Amaley WordPress plugin/module source code
- Amaley Core source
- Amaley Discovery Engine source
- Amaley Site Shell source
- Amaley UI Sections Kit planning/source
- Amaley Templates source
- Amaley Project Guard source
- Amaley Debug Toolkit source
- Design system documentation
- Performance and no-Elementor future UI rules
- Migration notes
- Changelog records
- QA and debug notes
- Developer handoff documentation

---

## What Not to Upload Here

Do not upload:

- `.wpress` backups
- All-in-One WP Migration backups
- Full website backup ZIP files
- Large media folders
- Videos
- Screenshot dumps
- Passwords
- API keys
- License keys
- `wp-config.php`
- Random plugin ZIPs

Heavy files belong in Google Drive, not GitHub.

---

## Google Drive Role

Google Drive is the archive and backup space.

Drive is used for:

- Website backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Media references
- Handoff ZIPs

---

## GitHub Role

GitHub is the clean development space.

GitHub is used for:

- Source code
- Documentation
- Version history
- Changelogs
- Migration planning
- QA notes
- Developer-readable project rules

---

## Current Active Plugin ZIPs

Current active plugin ZIP backups are stored in Google Drive:

```text
amaley-core-v1.0.2.zip
amaley-site-shell-v1.0.1.zip
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

ZIPs stay in Google Drive, not GitHub.

GitHub stores clean source code and documentation.

---

## Target Architecture

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins
- Page-builder default widgets for important custom UI sections

These may exist in old/current WordPress setups, but they are not part of the final target architecture.

Target custom system:

- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

---

## Future UI Direction

For the future clean Amaley website, important UI sections must be Amaley-controlled and lightweight.

Future UI sections must not depend on Elementor default widgets such as:

- Elementor Heading widget
- Elementor Button widget
- Elementor Icon Box widget
- Elementor Image Box widget
- Elementor HTML widget
- Elementor generic section layouts as the main system

Elementor may still exist temporarily in old/current migration contexts, but future clean UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks, and story sections must come from Amaley-controlled components.

The future clean UI system should be:

- WordPress-native
- Theme-like
- Lightweight
- Low-network-ready
- Mobile-first
- Global design-token controlled
- Easy to disable
- Easy to rollback
- Safe for WooCommerce

---

## Performance and Low-Network Rule

The Amaley website must remain extremely lightweight.

It must open fast even in low-network areas and must not become heavy after products, sections, origin data, or future modules are added.

Every plugin/module must follow:

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

## Active Custom Plugin / Module Direction

### Amaley Core

Core data and system backbone.

Planned / current role:

- Register Amaley CPTs safely
- Manage Clusters
- Manage SHG Groups
- Manage SHG Members / Producers
- Manage product origin mapping
- Manage producer / maker profiles
- Manage source village and region data
- Manage traceability fields
- Manage product usage fields
- Manage storage instruction fields
- Add system health checks
- Reduce dependency on third-party field/CPT plugins
- Keep data migration-safe

Rule:

Amaley Core must become the controlled data layer for Amaley.  
It must not become a frontend design plugin.

---

### Amaley Discovery Engine

Discovery and listing system.

Purpose:

- Product discovery
- Filters
- Listings
- Search
- Sorting
- Pagination
- Product grids
- Cluster discovery
- SHG group discovery
- SHG member discovery
- Mobile filter behaviour
- Safe empty-state handling

Rule:

Discovery Engine must remain separate from Amaley Core, Amaley Templates, and Amaley UI Sections Kit.

It must stay lightweight and avoid expensive unlimited frontend queries.

---

### Amaley Site Shell

Header/footer shell system.

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

Future lightweight WordPress-native UI section/component system.

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

Template-level support module.

Role:

- Existing or transitional template-level WooCommerce/page sections
- Existing or transitional product sections
- Existing or transitional shop sections
- Product hero / info tabs / trust strip / origin display where already implemented or required during migration

Rule:

Amaley Templates must support WooCommerce, not replace it.

Future clean reusable UI components should move toward Amaley UI Sections Kit instead of relying on Elementor default widgets.

---

### Amaley Project Guard

Future safety and health-check plugin.

Planned role:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect risky duplicate plugins
- Detect old or broken Amaley plugins
- Detect duplicate plugin risks
- Detect missing CPTs
- Detect missing fields
- Warn before unsafe activation
- Provide admin-only project health dashboard

Rule:

Project Guard exists to prevent silent breakage.

It must remain admin-only/lightweight and must not slow down the public frontend.

---

### Amaley Debug Toolkit

Future admin-only diagnostic plugin.

Planned role:

- Record plugin health status
- Show module/component registration status
- Show WooCommerce template dependency status
- Show product and origin data issues
- Show cache-related warnings
- Provide exportable debug reports for developers
- Support safer troubleshooting

Debug tools must be:

- Admin-only
- Permission-protected
- Safe for production
- Easy to disable
- Not visible to public users
- Not exposing secrets
- Not slowing the public frontend

---

## WooCommerce Rule

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

## Data System Direction

Amaley should eventually manage its own data structures for:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region information
- Traceability fields
- Product usage fields
- Storage instruction fields

These should not remain permanently dependent on ACF or CPT UI.

Do not create fake Cluster, SHG, Producer, or origin data.

---

## Filtering System Direction

Filtering should be handled by Amaley Discovery Engine.

Amaley should not depend permanently on JetEngine or Smart Filters.

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

## Design Rule

Amaley must remain:

- Premium
- Clean
- Mobile-first
- Consistent
- Lightweight
- Low-network-ready
- Scalable
- Easy for non-coders to manage
- Safe for long-term development
- Global design-token controlled where relevant

No random styling.  
No inconsistent fonts.  
No global CSS shortcuts.  
No plugin conflict hacks.

---

## Fresh WordPress Direction

The long-term direction is a cleaner WordPress setup using:

- Lightweight base theme
- WooCommerce
- Amaley Core
- Amaley Discovery Engine
- Amaley Site Shell
- Amaley UI Sections Kit
- Amaley Templates
- Amaley Project Guard
- Amaley Debug Toolkit

Elementor Pro may still exist temporarily for old/current migration context, but future clean custom UI sections should not depend on Elementor default widgets.

Existing dependencies such as Freshen theme, ACF, CPT UI, JetEngine, Smart Filters, Elementor, Elementor Pro, or helper plugins must not be removed blindly.

Removal must happen only after:

- Replacement is ready
- Backup is taken
- Testing is complete
- Rollback plan is available

---

## Development Rule

Before every serious change:

1. Take a backup where relevant.
2. Check current active plugin versions.
3. Check the root `README.md`.
4. Check `docs/PROJECT_MANIFEST.md`.
5. Check `docs/CHANGELOG.md`.
6. Check `plugins/README.md`.
7. Update changelog when the change is serious.
8. Make the change in a versioned way.
9. Test desktop, tablet, and mobile.
10. Test WooCommerce product, cart, and checkout flows where relevant.
11. Record what changed and why.

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

## Naming Rule

Good names:

- `amaley-core-v1.0.2`
- `amaley-site-shell-v1.0.1`
- `amaley-templates-v1.2.7`
- `amaley-discovery-engine-v1.3.5-no-cpt`
- `AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`
- `AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`

Bad names:

- `final-new-latest-2`
- `plugin-fixed-real-final`
- `copy of backup`
- `new zip`
- `test working maybe`

Bad naming creates future confusion and project risk.

---

## Project Standard

This project must be maintained like a serious production system, not like a temporary experiment.

Every file must answer:

- What is this?
- Why does it exist?
- Is it latest or archived?
- Can another developer understand it?
- Can it be rolled back safely?

---

## Hard Rule

If a plugin/module cannot be tested, debugged, documented, rolled back, and managed safely, it is not production-ready.

If a file creates confusion, rename it or document it.

Confusion is technical debt.
