# Amaley Project Guard — Running Note / Tracker

Current locked plugin: Amaley Project Guard v1.0.0
Author: Praveen
Status: Clean Separate Foundation Pass
Main rule: Project Guard will stay separate from Amaley Core.

## 1. Placement Rule

- [x] Plugin folder must be separate: plugins/amaley-project-guard/
- [x] Plugin must NOT go inside: plugins/amaley-core/
- [x] Admin menu must be separate: Amaley Project Guard
- [x] Amaley Core must be scanned only as a target
- [x] No Amaley Core file include
- [x] No Amaley Core class/function dependency

## 2. v1.0.0 Foundation Work

- [x] Fresh plugin created from v1.0.0
- [x] Old submenu-under-Core approach removed
- [x] Separate top-level admin menu created
- [x] Author changed to Praveen
- [x] Read-only mode kept
- [x] Manual Quick Scan added
- [x] Cached report loading added
- [x] Plugin registry added
- [x] Amaley vs external plugins detection added
- [x] Project Map added
- [x] Amaley Core target checks added
- [x] Elementor status check added
- [x] WooCommerce status check added
- [x] Markdown report export added
- [x] JSON report export added
- [x] No frontend CSS/JS added
- [x] No auto-fix added
- [x] No delete/deactivate action added

## 3. Testing Done on Site

- [x] Separate admin menu visible
- [x] Quick Scan completed
- [x] Critical issues: 0
- [x] High issues: 0
- [x] Medium issues: 0
- [x] Low issues: 0
- [x] Plugins tab working
- [x] Project Map tab working
- [x] Core Target Checks pass
- [x] Elementor tab working
- [x] WooCommerce tab working
- [x] Reports tab working

## 4. Current Scan Snapshot

- Total plugins detected: 27
- Active plugins: 16
- Inactive plugins: 11
- Amaley plugins: 9
- External plugins: 18
- Total Elementor widgets: 303
- Amaley Elementor widgets: 94
- WooCommerce pages detected: Shop, Cart, Checkout, My Account

## 5. Watchlist — Do Not Touch Yet

- [ ] Amaley Inspector Temporary Read-Only
- [ ] Amaley Relation Debug Tool
- [ ] Inactive plugins
- [ ] Extra/unused Elementor widgets
- [ ] Old debug pages under Tools
- [ ] Theme plugin-install notice

Rule: No cleanup before Usage Map.

## 6. GitHub Rule

Correct repository:

praveen-de-reptoiur/amaley-wordpress-system

Correct path:

plugins/amaley-project-guard/

Do NOT upload Project Guard inside:

plugins/amaley-core/

## 7. Final Files Created

Installable plugin ZIP:

amaley-project-guard-v1.0.0-clean-separate-author-praveen.zip

GitHub/source ZIP:

AMALEY_PROJECT_GUARD_COMPLETE_SOURCE_FOR_GITHUB_v1.0.0_CLEAN_SEPARATE_AUTHOR_PRAVEEN.zip

## 8. Next Step

- [ ] Take fresh backup after v1.0.0 clean pass
- [ ] Upload final source to GitHub path: plugins/amaley-project-guard/
- [ ] Build v1.0.1 Usage Map

## 9. v1.0.1 Usage Map Plan

- [ ] Scan Elementor pages/templates
- [ ] Show which widget is used where
- [ ] Show widget usage count
- [ ] Scan shortcodes in page content
- [ ] Show shortcode usage page-wise
- [ ] Mark unused widgets
- [ ] Create cleanup candidate list
- [ ] Keep everything read-only
- [ ] No auto-fix
- [ ] No delete
- [ ] No frontend output

## 10. Future Roadmap

- [ ] v1.0.1 — Usage Map
- [ ] v1.0.2 — Deep Amaley Core Integrity
- [ ] v1.0.3 — External Plugin Conflict Scanner
- [ ] v1.0.4 — Error/Fatal Log Scanner
- [ ] v1.0.5 — Data Integrity Scanner
