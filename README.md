# Amaley WordPress System

Private source-code and documentation repository for the Amaley WordPress ecosystem.

This repository is maintained for clean plugin development, design-system control, migration planning, QA, debugging, and future developer handoff.

---

## Repository Purpose

This repository stores:

- Custom Amaley plugin source code
- WordPress development documentation
- Design-system rules
- Migration plans
- Changelog records
- QA and debug notes
- Developer handoff files

---

## Important Rule

This repository must not be used as a backup dump.

Do not upload:

- `.wpress` files
- Full website backup ZIPs
- Large media folders
- Product image dumps
- Videos
- Passwords
- API keys
- License keys
- `wp-config.php`

Heavy files belong in Google Drive.

---

## Current Documentation

Start here:

- `docs/READ_FIRST_AMALEY.md`
- `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- `docs/AMALEY_PRIMARY_BUILD_RULES.md`
- `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`
- `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md`
- `docs/CHANGELOG.md`
- `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`
- `docs/DRIVE_FOLDER_MAP.md`
- `docs/QA_CHECKLIST.md`
- `docs/PROJECT_MANIFEST.md`
- `docs/NEXT_CHAT_PROMPT.md`
- `plugins/README.md`

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

Future UI sections should not depend on Elementor default widgets such as:

- Elementor Heading widget
- Elementor Button widget
- Elementor Icon Box widget
- Elementor Image Box widget
- Elementor HTML widget
- Elementor generic section layouts as the main system

Elementor may still exist in old/current setups during migration, but new custom UI sections, buttons, cards, strips, CTAs, product blocks, origin blocks, and story sections must come from Amaley-controlled components.

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

## Performance Lock

The Amaley website must remain extremely lightweight.

It must load fast even in low-network areas and must not become heavy after products, sections, origin data, or future modules are added.

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

Current / planned role:

- Register Amaley CPTs safely
- Manage Clusters
- Manage SHG Groups
- Manage SHG Members
- Manage Product Origin Mapping
- Manage producer / maker profiles
- Manage traceability fields
- Reduce dependency on third-party field/CPT plugins
- Add system-level health checks
- Keep data migration-safe

Rule:

Amaley Core handles the data backbone only.  
It must not become a frontend design plugin.

---

### Amaley Discovery Engine

Discovery, filtering, listing, pagination, search, sorting, and Cluster / SHG / Member discovery system.

Rule:

Discovery Engine must remain separate from Amaley Core, Amaley Templates, and Amaley UI Sections Kit.

It must stay lightweight and avoid expensive unlimited frontend queries.

---

### Amaley Site Shell

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

### Amaley UI Sections Kit

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

### Amaley Templates

Template-level support module.

Role:

- Existing or transitional template-level WooCommerce/page sections
- Single product section support where already planned
- Shop page section support where already planned
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
- Detect missing CPTs or fields
- Warn before unsafe activation
- Provide admin-only project health dashboard

Rule:

Project Guard must remain admin-only/lightweight and must not slow down the public frontend.

---

### Amaley Debug Toolkit

Future admin-only diagnostic plugin.

Planned role:

- Record plugin health status
- Show module/component registration status
- Show WooCommerce dependency status
- Show product and origin data issues
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

Custom Amaley plugins must support WooCommerce, not replace it.

---

## Google Drive vs GitHub

Google Drive is for:

- `.wpress` backups
- Plugin ZIP backups
- Elementor exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

GitHub is for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

---

## Development Standard

Every change must be:

- Versioned
- Documented
- Tested
- Reversible
- Consistent with the Amaley design system
- Safe for WooCommerce
- Lightweight
- Low-network-ready
- Mobile-first
- Debuggable
- Global-design-token compatible where relevant
- Non-coder manageable where relevant

No random fixes.  
No undocumented plugin edits.  
No messy file names.  
No backup files in GitHub.

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

If a plugin cannot be tested, debugged, documented, rolled back, and managed safely, it is not production-ready.
