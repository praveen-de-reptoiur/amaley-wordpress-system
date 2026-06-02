# Amaley Project Guard — Running Note / Tracker

Current locked plugin: Amaley Project Guard v1.0.1.3
Author: Praveen
Status: Usage Map Stable Test Pass
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

## 3. v1.0.1 Usage Map Work

- [x] Usage Map tab added
- [x] Elementor widget usage scan added
- [x] Shortcode usage scan added
- [x] Used widgets list added
- [x] Used shortcodes list added
- [x] Unused widgets review-only list added
- [x] Unused shortcodes review-only list added
- [x] Responsive fix added in v1.0.1.1
- [x] Layout fix added in v1.0.1.2
- [x] Compact accordion fix added in v1.0.1.3
- [x] No frontend change
- [x] No cleanup action
- [x] No auto-fix
- [x] No delete/deactivate action

## 4. Testing Done on Site

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
- [x] Usage Map working
- [x] Usage Map responsive/compact enough after v1.0.1.3
- [x] Frontend quick check normal

## 5. Current Usage Map Snapshot

- Known Amaley widgets: 94
- Used Amaley widgets: 49
- Unused Amaley widgets: 45
- Known Amaley shortcodes: 86
- Used Amaley shortcodes: 2
- Unused Amaley shortcodes: 84
- Elementor documents scanned: 8
- Shortcode documents scanned: 1

Important: Unused means review-only. Do not delete anything from this list without manual confirmation.

## 6. Watchlist — Do Not Touch Yet

- [ ] Amaley Inspector Temporary Read-Only
- [ ] Amaley Relation Debug Tool
- [ ] Inactive plugins
- [ ] Extra/unused Elementor widgets
- [ ] Old debug pages under Tools
- [ ] Theme plugin-install notice

Rule: No cleanup before manual review.

## 7. GitHub Rule

Correct repository:

praveen-de-reptoiur/amaley-wordpress-system

Correct path:

plugins/amaley-project-guard/

Do NOT upload Project Guard inside:

plugins/amaley-core/

## 8. Final Locked Version

Installable plugin ZIP:

amaley-project-guard-v1.0.1.3-usage-map-compact-fix.zip

GitHub/source ZIP:

AMALEY_PROJECT_GUARD_COMPLETE_SOURCE_FOR_GITHUB_v1.0.1.3_USAGE_MAP_COMPACT_FIX.zip

## 9. Next Step

- [ ] Take fresh backup after v1.0.1.3 stable pass
- [ ] Later build v1.0.2 Deep Amaley Core Integrity only after confirmation

## 10. Future Roadmap

- [x] v1.0.1 — Usage Map
- [ ] v1.0.2 — Deep Amaley Core Integrity
- [ ] v1.0.3 — External Plugin Conflict Scanner
- [ ] v1.0.4 — Error/Fatal Log Scanner
- [ ] v1.0.5 — Data Integrity Scanner
