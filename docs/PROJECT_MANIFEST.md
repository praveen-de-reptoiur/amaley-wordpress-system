# PROJECT MANIFEST — Amaley WordPress System

This manifest is the project index for the Amaley WordPress system.

It explains what each repository file is for, what belongs in GitHub, what belongs in Google Drive, and what the target architecture is.

---

## Repository

```text
praveen-de-reptoiur/amaley-wordpress-system
```

---

## Repository Role

GitHub is used for:

- Source code
- Documentation
- Version history
- Migration planning
- QA notes
- Developer handoff notes

GitHub is not used for heavy backup files.

---

## Google Drive Role

Google Drive is used for:

- `.wpress` backups
- Plugin ZIP backups
- Elementor template exports
- WooCommerce exports
- Product images
- Screenshots
- Videos
- Handoff ZIP packages

---

## Current Repository Files

### README.md

Main front-page description of the repository.

Purpose:

- Explain the repository
- Link the major documentation files
- Define the high-level development standard
- Lock current architecture direction

---

### docs/READ_FIRST_AMALEY.md

Primary onboarding file.

Purpose:

- Explain project rules
- Explain GitHub vs Google Drive roles
- Explain plugin boundaries
- Explain WooCommerce rule
- Explain naming discipline

This file must be read before touching the project.

---

### docs/AMALEY_DESIGN_SYSTEM_LOCKED.md

Locked design-system file.

Purpose:

- Define brand positioning
- Lock colors
- Lock typography
- Lock button style
- Lock card style
- Lock mobile rules
- Prevent visual inconsistency

No page or plugin module should drift away from this file.

---

### docs/AMALEY_PRIMARY_BUILD_RULES.md

Primary build rule file.

Purpose:

- Lock staging/fresh-build direction
- Lock conflict-free development rules
- Lock CSS/PHP safety rules
- Lock WooCommerce boundary
- Lock non-coder control direction
- Lock testing gate

---

### docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md

Permanent performance and future UI direction lock.

Purpose:

- Lock extremely lightweight site direction
- Lock low-network-first rule
- Lock no-Elementor-default-widget rule for future clean UI sections
- Lock global design-token direction
- Lock component boundary rules
- Lock performance testing gate

---

### docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md

Earlier full-control and performance rule file.

Purpose:

- Preserve earlier widget/template control philosophy
- Preserve performance thinking
- Preserve responsive control expectations
- Preserve safety requirements

Current note:

This file may mention Elementor in the context of earlier/template migration work.  
For the future clean UI section system, `AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md` is stricter and applies.

---

### docs/CHANGELOG.md

Version and decision history.

Purpose:

- Record major project decisions
- Record plugin versions
- Record documentation updates
- Record migration milestones
- Record architecture decisions

Every serious change must be documented here.

---

### docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md

Fresh WordPress migration plan.

Purpose:

- Define safe migration direction
- Prevent blind dependency removal
- Define plugin roles
- Define target architecture
- Define migration phases
- Define rollback rules
- Define guard and debug direction

---

### docs/DRIVE_FOLDER_MAP.md

Google Drive folder map.

Purpose:

- Explain Drive folder structure
- Define what belongs in each folder
- Prevent backup/media/source-code confusion

---

### docs/QA_CHECKLIST.md

Testing checklist.

Purpose:

- Test plugin updates
- Test templates/modules
- Test WooCommerce flows
- Test responsive layout
- Test design-system consistency
- Test migration safety
- Test performance and low-network readiness

If it is not tested, it is not done.

---

### docs/NEXT_CHAT_PROMPT.md

Continuation prompt for future ChatGPT chats.

Purpose:

- Help future chats continue without guessing
- Point to the correct GitHub and Drive references
- Lock project rules for the next assistant/developer

---

### docs/PROJECT_MANIFEST.md

This file.

Purpose:

- Act as the project index
- Explain current and planned repository structure
- Explain plugin/module architecture
- Explain source vs backup rules

---

### plugins/README.md

Plugin and module architecture guide.

Purpose:

- Define plugin/module source structure
- Define plugin/module roles
- Lock dependency direction
- Lock no-Elementor future UI direction
- Define debug and guard philosophy
- Define CSS, PHP, security, and performance rules

---

## Target Repository Structure

Planned repository structure:

```text
amaley-wordpress-system/
  README.md
  docs/
    READ_FIRST_AMALEY.md
    AMALEY_DESIGN_SYSTEM_LOCKED.md
    AMALEY_PRIMARY_BUILD_RULES.md
    AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md
    AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md
    CHANGELOG.md
    AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md
    DRIVE_FOLDER_MAP.md
    QA_CHECKLIST.md
    PROJECT_MANIFEST.md
    NEXT_CHAT_PROMPT.md
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

## Current Active Plugin ZIPs in Google Drive

Current active plugin ZIP backups:

```text
amaley-core-v1.0.2.zip
amaley-site-shell-v1.0.1.zip
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

These ZIPs stay in Google Drive.

Extracted source code and approved planning docs belong in GitHub.

Do not upload plugin ZIPs into GitHub.

---

## Architecture Decision

The future Amaley system should not depend permanently on:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Random utility plugins
- Page-builder default widgets for important custom UI sections

These may exist in old/current WordPress setups, but they are not part of the final target architecture.

Target architecture:

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

## Performance and Low-Network Rule

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

## Plugin Source Plan

### plugins/amaley-core

Core data and system backbone.

Current / planned role:

- Register Amaley CPTs safely
- Manage product origin fields
- Manage Cluster data
- Manage SHG Group data
- Manage SHG Member data
- Manage producer / maker profiles
- Manage source village and region data
- Manage traceability fields
- Manage product origin mapping
- Add system health checks
- Reduce dependency on third-party field/CPT plugins
- Keep data migration-safe

Rule:

Amaley Core must become the controlled data layer for Amaley.  
It must not become a frontend design plugin.

---

### plugins/amaley-discovery-engine

Discovery and listing system.

Purpose:

- Product discovery
- Filtering
- Search
- Sorting
- Listings
- Pagination
- Mobile filter behaviour
- Cluster discovery
- SHG group discovery
- SHG member discovery
- Safe empty-state handling

Rule:

Discovery Engine must remain separate from Amaley Core, Amaley Templates, and Amaley UI Sections Kit.

It must stay lightweight and avoid expensive unlimited frontend queries.

---

### plugins/amaley-site-shell

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

- v1.0.1 source exists
- Shortcode/manual mode tested
- Auto-render exists but remains on HOLD
- Full replacement must be tested only on fresh/staging after source of existing header/footer is confirmed

Rule:

Amaley Site Shell must not blindly override live/current header and footer.

---

### plugins/amaley-ui-sections-kit

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

### plugins/amaley-templates

Template-level support module.

Purpose:

- Existing or transitional template-level WooCommerce/page sections
- Single product section support where already planned
- Shop page section support where already planned
- Product hero / info tabs / trust strip / origin display where already implemented or required during migration

Rule:

Amaley Templates must support WooCommerce, not replace it.

Future clean reusable UI components should move toward Amaley UI Sections Kit instead of relying on Elementor default widgets.

---

### plugins/amaley-project-guard

Future source folder for Amaley Project Guard.

Purpose:

- Show active Amaley plugin versions
- Detect missing WooCommerce
- Detect risky duplicate plugins
- Detect old or broken Amaley plugin versions
- Detect missing CPTs
- Detect missing fields
- Provide admin-only project health dashboard
- Warn before unsafe activation

Rule:

Project Guard exists to prevent silent breakage.

It must remain admin-only/lightweight and must not slow down the public frontend.

---

### plugins/amaley-debug-toolkit

Future source folder for Amaley Debug Toolkit.

Purpose:

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

Rule:

Debug visibility is part of production readiness.

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

Amaley should not depend permanently on JetEngine or Smart Filters.

---

## Google Drive Structure

Google Drive structure:

```text
Amaley Project/
  00_Project_Control/
  01_Backups/
  02_Active_Plugins/
  03_Code_Source/
  04_Elementor_Templates/
  05_Data_Exports/
  06_Design_System/
  07_Media_Reference/
  08_Migration/
  09_QA_Debug/
  10_Archive_Do_Not_Use/
  11_Handoff_Packages/
```

---

## What Belongs in GitHub

GitHub should contain:

- Clean source code
- README files
- Documentation
- Design-system rules
- Migration plans
- QA notes
- Changelogs
- Developer handoff notes

---

## What Does Not Belong in GitHub

Do not upload:

- `.wpress` files
- Full backup ZIPs
- Product image dumps
- Videos
- Passwords
- API keys
- License keys
- `wp-config.php`
- Large media folders
- Random plugin ZIPs

Heavy files belong in Google Drive.

---

## Development Standard

Every file must answer:

- What is this?
- Why does it exist?
- Is it latest?
- Is it source, backup, archive, or documentation?
- Can another developer understand it?
- Can it be rolled back safely?

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

## Migration Standard

No dependency should be removed before its replacement is ready.

Do not remove blindly:

- ACF
- CPT UI
- JetEngine
- Smart Filters
- Elementor
- Elementor Pro
- Freshen theme dependencies
- Existing live utility plugins

Replacement must be tested on staging or safe environment first.

---

## Debug Standard

A plugin/module is not production-ready unless it can be:

- Tested
- Debugged
- Rolled back
- Versioned
- Documented

---

## Final Rule

If a file creates confusion, rename it or document it.

Confusion is technical debt.
