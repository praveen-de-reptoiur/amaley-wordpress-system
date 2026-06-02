# Amaley Project Guard — A-to-Z Master Tracker

Current Locked Version: Amaley Project Guard v1.0.1.3
Current Status: Usage Map Stable Test Pass
Author: Praveen
Correct GitHub Path: plugins/amaley-project-guard/
Safety Rule: Do not place Project Guard inside plugins/amaley-core/

Legend: [x] DONE = completed/tested. [ ] PENDING = not built. [~] PARTIAL = partly done. HOLD = do not touch.

---

## Quick Status

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Foundation | v1.0.0 clean separate foundation | Completed and tested. | Locked. |
| [x] DONE | Usage Map | v1.0.1.3 compact usage map | Completed, layout corrected and accepted. | Locked. |
| [ ] PENDING | Next Build | v1.0.2 Deep Amaley Core Integrity | Not started. | Start only after confirmation. |
| [ ] PENDING | Later Builds | v1.0.3 / v1.0.4 / v1.0.5 | Pending future modules. | Do not start now. |

---

## 0. Current Lock and Live Status

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Current accepted version | Amaley Project Guard v1.0.1.3 | Usage Map compact accordion version tested on live admin and accepted. | Use as latest active version. |
| [x] DONE | Author | Author must be Praveen | Plugin header shows Author: Praveen. | No action. |
| [x] DONE | Repository path | plugins/amaley-project-guard/ | GitHub source is in separate Project Guard folder. | Continue using same folder. |
| [x] DONE | Admin menu | Separate top-level menu: Amaley Project Guard | Not inside Amaley Core menu. | Keep top-level menu. |
| [x] DONE | Frontend safety | No frontend hooks/assets/output | Frontend quick check normal after v1.0.1.3. | Keep locked. |
| [x] DONE | Backup | Backup after v1.0.1.3 stable pass | User confirmed backup done. | Take backup before next build too. |

---

## 1. Purpose and Definition

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Purpose | Read-only project intelligence/debug/mapping/risk-detection plugin | Foundation Guard and Usage Map act as read-only control room. | Keep scope unchanged. |
| [x] DONE | Definition | Not a design plugin, widget builder, or auto-fix tool | No design/frontend output or auto-fix added. | Keep locked. |
| [~] PARTIAL | Detection | Detect code mistakes, missing files, wrong versions, dependencies, conflicts and fatal/error conditions | Basic plugin/Core/Elementor/Woo checks done. Deep conflict/fatal detection pending. | Continue in v1.0.2 to v1.0.4. |
| [~] PARTIAL | Mapping | Map Amaley plugins, widgets, shortcodes, sections, assets, CPTs and relations | Plugins, CPTs, shortcodes and widgets mapped. Assets, sections, dependencies and relations pending. | Deepen in v1.0.2/v1.0.5. |
| [x] DONE | Usage tracking | Detect which widget/section is used on which page/template | v1.0.1.3 detects Elementor widget and shortcode usage. | Do not use for deletion yet. |
| [x] DONE | Controlled development | Keep future development documented and safe | README, master plan, running note and tracker are maintained. | Update tracker after every change. |

---

## 2. Hard Safety Rules

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Frontend output | No frontend output in v1.x unless approved later | No frontend output added. | Keep locked. |
| [x] DONE | Auto-fix | No auto-fix | No auto-fix exists. | Keep review-only. |
| [x] DONE | DB changes | Only store scan/cache/options. No content/data mutation. | Scan/report-only behavior maintained. | No content mutations. |
| [x] DONE | File changes | No plugin/theme file editing from Guard | No file editor/patch tool in plugin. | Keep out. |
| [x] DONE | Plugin actions | No automatic plugin activation/deactivation/deletion | No plugin action controls exist. | Keep out. |
| [x] DONE | Scan load | No heavy scan on every page load. Manual admin scan first. | Manual scan flow used. | Keep manual. |
| [~] PARTIAL | Security | Admin-only, nonce-protected, capability manage_options | Admin-only behavior confirmed. Full code security audit still pending. | Audit before public/stable release. |
| [~] PARTIAL | Atomic Editor warning | Elementor Atomic Editor warning must stay | Elementor tab exists. Warning behavior needs verification when Atomic Editor is enabled. | Check later. |

---

## 2A. Performance and Zero-Load Safety Lock

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Zero frontend load | No frontend output/design/CSS/JS/rendering dependency | Frontend quick check normal; source has frontend safety return. | Keep locked. |
| [x] DONE | No automatic full scan | No full scan on normal frontend/admin dashboard load | Scans are manual. | Keep manual. |
| [x] DONE | No recursive file scan on load | File/integrity checks only on admin scan | Foundation scan is manual. | No silent scans. |
| [x] DONE | No remote API calls | No GitHub/external network checks in normal WP requests | No remote calls in plugin. | Keep out. |
| [x] DONE | Cached dashboard | Dashboard loads cached last report first | Cached report behavior present. | Keep. |
| [~] PARTIAL | Batching | Widget/page usage scanner should process in batches | Usage Map works for current scale. Deeper batching can be improved later. | Improve before larger scale. |
| [ ] PENDING | Debug log safe reader | Read only recent portion of debug.log | Planned for v1.0.4. | Do later. |
| [x] DONE | Self-performance metrics | Track scan time, memory usage, scanned item count | Scan metrics visible. | Keep. |
| [~] PARTIAL | Expensive scan warning | Warn admin if scan becomes expensive | Basic safety notes present. Advanced warning pending. | Add later. |

---

## 3. Main Admin Dashboard Structure

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Overview | Issue counts, scan status, versions, next safe action | Overview tab working. | Polish only if needed. |
| [x] DONE | Project Map | Tree/map of plugins, widgets, sections, cards, assets, dependencies | Basic map working. Deep assets/dependencies pending. | Deepen later. |
| [x] DONE | Plugins | Active/inactive plugins, Amaley plugins, external plugins and risk areas | Plugin grouping working. Risk intelligence pending. | Add in v1.0.3. |
| [~] PARTIAL | Widgets and Sections | Registered widgets, shortcodes, renderers, files, CSS handles and status | Widgets/shortcodes shown. Renderer/file/CSS detail pending. | Add in v1.0.2/assets scanner. |
| [x] DONE | Usage Map | Where every widget/shortcode is used | v1.0.1.3 stable. | Locked. |
| [~] PARTIAL | Amaley Core | Deep source, version, file, card and dependency checks | Basic target checks done. Deep integrity pending. | Build v1.0.2 after confirmation. |
| [x] DONE | Elementor | Atomic Editor, widget registration, editor issues and template scanning | Elementor active/widgets/usage detected. Advanced diagnostics pending. | Deepen later. |
| [x] DONE | WooCommerce | Commerce safety, product mapping, template override warnings | Shop/cart/checkout/account detected. Template override checks pending. | Deepen later. |
| [ ] PENDING | External Plugin Risks | Cache, snippets, filters, SEO/security/image overlap risks | Planned v1.0.3. | Do later. |
| [ ] PENDING | Assets | CSS/JS handles, missing files, scoped selector risks, enqueue checks | Future asset scanner. | Do later. |
| [ ] PENDING | Data Integrity | CPT counts, orphan relations, product origin, duplicate slugs | Planned v1.0.5. | Do later. |
| [ ] PENDING | Errors / Logs | Fatal errors, warnings, deprecated notices, Amaley-specific logs | Planned v1.0.4. | Do later. |
| [x] DONE | Reports | Markdown/JSON/debug summaries | Markdown and JSON export working. | Keep. |

---

## 4. Severity Model

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | CRITICAL | Site break/fatal/missing core file/class/500 risk | Severity count exists. | Deep logic later. |
| [x] DONE | HIGH | Editor/frontend damage or known breaking setting | Severity count exists. | Deep logic later. |
| [x] DONE | MEDIUM | Data/display inconsistency or conflict risk | Severity count exists. | Deep logic later. |
| [x] DONE | LOW | Cleanup/documentation/version mismatch | Severity count exists. | Deep logic later. |
| [x] DONE | INFO | Useful status, unused widget, normal condition | Info status used for clean scan/review items. | Keep unused as INFO/review-only. |
| [~] PARTIAL | Issue detail format | Severity, area, problem, exact location, impact, suggested action | Basic issue list exists. Rich issue cards need expansion. | Improve in future scanners. |

---

## 5. Project Map — Central Feature

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Amaley Core map | CPTs, widgets, cards, assets, data relations | Core detected with CPTs/widgets. Cards/assets/relations pending. | Deepen later. |
| [x] DONE | Amaley Discovery Engine map | Filters, search, sort, pagination, product grid | Plugin detected. Deep module map pending. | Deepen later. |
| [x] DONE | Amaley Templates map | WooCommerce/page template support | Plugin detected. | Deepen later. |
| [x] DONE | Amaley Site Shell map | Header, footer, mobile drawer | Shortcodes/header-footer detected. | Deepen later. |
| [x] DONE | Future plugin auto-detection | Future Amaley plugins/theme/site kit added to map | Amaley grouping auto-detects by plugin scan. | Keep. |
| [~] PARTIAL | Visual tree depth | Full structured visual tree of ecosystem | Basic map useful but still developer/raw in some areas. | Improve later. |

---

## 6. Plugin Registry and Auto-Discovery

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | get_plugins() | Plugin name, folder, main file, version, status, author | Plugin registry tab working. | Keep. |
| [~] PARTIAL | wp_get_themes() | Active theme, parent theme, version | Not yet visible as completed check. | Add later. |
| [x] DONE | registered_post_types | CPT list, labels, visibility | 3 Amaley CPTs detected. | Keep. |
| [~] PARTIAL | registered_taxonomies | Taxonomies and connected post types | Section exists but no detected Amaley taxonomies in current scan. | Review later. |
| [x] DONE | shortcode_tags | Registered shortcode names and callbacks | 86 Amaley shortcodes detected. | Keep. |
| [x] DONE | Elementor widgets_manager | Registered widget names/classes/categories | 94 Amaley widgets detected. | Keep. |
| [ ] PENDING | wp_styles/wp_scripts | CSS/JS handles and enqueued status | Future asset scanner. | Do later. |
| [x] DONE | Elementor _elementor_data | Page/template widget usage map | v1.0.1.3 scans Elementor JSON. | Keep. |
| [ ] PENDING | Optional registry hook | Richer plugin self-reporting | Future enhancement. | Do later. |

---

## 7. Widget / Section Mapping

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Widget name | Show widget machine name | Usage Map lists widget names. | Keep. |
| [x] DONE | Plugin/class | Show widget class | Usage Map shows class names. | Keep. |
| [~] PARTIAL | Source file | Map widget source file | Not complete for every widget. | Deepen later. |
| [~] PARTIAL | Renderer | Map render method or section renderer | Planned for v1.0.2. | Do later. |
| [x] DONE | Shortcode | Map shortcode tag/callback | Shortcode list and usage scan present. | Keep. |
| [~] PARTIAL | Data source | Map CPT/meta relation dependency | Future data integrity/dependency work. | Do later. |
| [ ] PENDING | CSS dependency | Map CSS handles/files per widget | Future asset/dependency scanner. | Do later. |
| [x] DONE | Used on | Page/template list with count and widget IDs | v1.0.1.3 shows page/template usage with IDs. | Keep. |

---

## 8. Usage Map — Where Widgets Are Used

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Elementor JSON scan | Scan _elementor_data for widget names and widget IDs | v1.0.1 implemented. | Keep. |
| [x] DONE | Content shortcode scan | Scan content for Amaley shortcodes | v1.0.1 implemented. | Keep. |
| [x] DONE | Page/template detail | Show title, ID, post type/status and source | Usage rows show page/template title, ID, status/source/widget ID. | Keep. |
| [x] DONE | Used count | Show used count per widget/shortcode | Counts visible on accordion rows. | Keep. |
| [x] DONE | Unused widgets | Show unused widgets review-only | 45 unused widgets shown as review-only. | Do not delete without manual review. |
| [x] DONE | Unused shortcodes | Show unused shortcodes review-only | 84 unused shortcodes shown as review-only. | Do not delete without manual review. |
| [x] DONE | No guessing | Show widget ID/hierarchy when exact title unavailable | Widget IDs shown. | Keep. |
| [x] DONE | Responsive layout | Usage Map should be practical in admin | v1.0.1.3 compact accordion accepted. | Lock. |
| [~] PARTIAL | Batched deep scan | For very large sites, use deeper batching | Current site OK; future batching can improve. | Add if site grows. |

---

## 9. Dependency Map

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [ ] PENDING | Elementor dependency | Show widgets requiring Elementor | Planned for v1.0.2 dependency mapping. | Do later. |
| [ ] PENDING | Amaley Core dependency | Show modules requiring Amaley Core active | Planned for v1.0.2. | Do later. |
| [ ] PENDING | CPT dependency | Map widget to CPT/data source | Planned for v1.0.2/v1.0.5. | Do later. |
| [ ] PENDING | Relation dependency | Map relation meta like _amaley_member_shg_id | Planned for v1.0.5. | Do later. |
| [ ] PENDING | Renderer dependency | Map render_grid/render_section dependencies | Planned v1.0.2. | Do later. |
| [ ] PENDING | CSS dependency | Map card CSS and section CSS | Planned v1.0.2/assets. | Do later. |
| [ ] PENDING | Severity logic | Report missing file as CRITICAL, CSS as HIGH, unused as INFO | Deep dependency severity rules later. | Do later. |

---

## 10. External Plugin Conflict Scanner

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [ ] PENDING | Page builder risks | Elementor/Pro mistakes, Atomic Editor, duplicate widget names | Planned v1.0.3. | Do later. |
| [ ] PENDING | WooCommerce risks | Cart/checkout, HPOS, template override risk | Basic Woo pages done; deep risk scanner pending. | Do later. |
| [ ] PENDING | Cache/performance risks | Minify/combine/defer/stale cache warnings | Planned v1.0.3. | Do later. |
| [ ] PENDING | Code snippets/custom code | Warn active snippets can override hooks | Planned v1.0.3. | Do later. |
| [ ] PENDING | Filter plugin overlap | JetSmartFilters or other filters overlap with Discovery Engine | Planned v1.0.3. | Do later. |
| [ ] PENDING | Security/firewall | Warn about REST/AJAX/admin-ajax blocking | Planned v1.0.3. | Do later. |
| [ ] PENDING | Image optimization | Warn if CDN/lazy load breaks card/product images | Planned v1.0.3. | Do later. |

---

## 11. Fatal / Error / Log Scanner

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [ ] PENDING | debug.log reader | Read latest safe portion of wp-content/debug.log | Planned v1.0.4. | Do later. |
| [ ] PENDING | Error grouping | Group fatal, parse, warning, deprecated notices | Planned v1.0.4. | Do later. |
| [ ] PENDING | Shutdown fatal capture | Capture last shutdown fatal and show next admin visit | Planned v1.0.4. | Do later. |
| [ ] PENDING | Exact error report | Show error, file, line, plugin area, next safe action | Planned v1.0.4. | Do later. |
| [x] DONE | Admin-only logs | Never expose logs publicly | No public log exposure added. | Keep locked. |

---

## 12. Amaley Core Deep Integrity Checks

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Plugin header version | Check plugin header version | Header version detected. | Deeper compare in v1.0.2. |
| [x] DONE | Constant version | Detect AMALEY_CORE_VERSION constant | Constant detected. | Deeper compare in v1.0.2. |
| [x] DONE | Required files | Check required includes/assets exist | Visible required Core files pass. | Expand in v1.0.2. |
| [~] PARTIAL | Required classes | Check Core/CPT/metabox/card registry/card renderer/sections classes exist | File checks done; class existence deep checks pending. | Do in v1.0.2. |
| [ ] PENDING | Card bridge classes | Check controls like ampa-card-button/meta/chip row | Planned v1.0.2. | Do later. |
| [~] PARTIAL | Shortcodes | Required shortcodes registered | Global shortcode list done. Required-by-module validation pending. | Do later. |
| [~] PARTIAL | Elementor widgets | Expected Core widgets registered once | Widgets detected. Duplicate/expected-once validation pending. | Do later. |
| [~] PARTIAL | Assets | CSS file exists and registered/enqueued where required | Core cards CSS file found. Enqueue/context check pending. | Do later. |
| [ ] PENDING | Version comments | Warn if file header/comments mention old version | Planned v1.0.2 or cleanup audit. | Do later. |

---

## 13. Data / CPT Integrity

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [~] PARTIAL | CPT counts | Count Clusters, SHGs, Members and Products | CPT types detected; content counts not built yet. | Do in v1.0.5. |
| [ ] PENDING | Orphan SHGs | Detect SHGs without Cluster relation | Planned v1.0.5. | Do later. |
| [ ] PENDING | Members without SHG | Detect Members without SHG relation | Planned v1.0.5. | Do later. |
| [ ] PENDING | Products without origin | Detect products missing origin mapping | Planned v1.0.5. | Do later. |
| [ ] PENDING | Duplicate slugs | Detect duplicate slugs | Planned v1.0.5. | Do later. |
| [ ] PENDING | Empty required fields | Detect empty required fields | Planned v1.0.5. | Do later. |
| [ ] PENDING | Edit links | Show affected record titles and edit links | Planned v1.0.5. | Do later. |
| [ ] PENDING | Relation keys | Check cluster/SHG/member relation meta keys | Planned v1.0.5. | Do later. |

---

## 14. Reports and Exports

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [~] PARTIAL | Copy Debug Summary | Short summary for chat/help | Debug summary visible; copy UX can improve. | Improve later. |
| [x] DONE | Markdown Report | Download human-readable report | Markdown export working. | Keep. |
| [x] DONE | JSON Report | Download structured scan output | JSON export working. | Keep. |
| [ ] PENDING | Export Project Map | Export plugin/widget/usage/dependency map | Future export enhancement. | Do later. |
| [ ] PENDING | Export Cleanup Candidate List | Unused widgets/files/old comments review-only list | Review-only list exists; dedicated export pending. | Do later. |

---

## 15. Optional Self-Registry Hook for Future Plugins

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [ ] PENDING | Registry filter | Add amaley_project_guard_registry filter | Future plugin self-reporting hook. | Do later. |
| [ ] PENDING | Widget registry metadata | Plugins report widgets/classes/files/assets | Future enhancement. | Do later. |
| [ ] PENDING | Dependency registry metadata | Plugins report dependencies and known risks | Future enhancement. | Do later. |

---

## 16. File and Class Structure

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Main file | amaley-project-guard.php | Main file exists and version is 1.0.1.3. | Keep. |
| [x] DONE | APG prefix | PHP class prefix APG_ | Source uses APG class naming. | Keep. |
| [x] DONE | Function prefix | amaley_project_guard_ | Prefix reserved/used where needed. | Keep. |
| [x] DONE | CSS prefix | apg- | Admin styles scoped to APG. | Keep. |
| [x] DONE | No generic names | Avoid generic class/function names | Names are scoped. | Keep. |
| [x] DONE | assets/admin.css | Admin CSS present | Present. | Keep. |
| [x] DONE | assets/admin.js | Admin JS present | Present. | Keep. |
| [x] DONE | includes/class-apg-plugin.php | Plugin bootstrap class | Present. | Keep. |
| [x] DONE | includes/class-apg-admin.php | Admin page class | Present. | Keep. |
| [x] DONE | includes/class-apg-scanner.php | Scanner class | Present. | Keep. |
| [x] DONE | includes/class-apg-plugin-registry.php | Plugin registry class | Present. | Keep. |
| [x] DONE | includes/class-apg-project-map.php | Project map class | Present. | Keep. |
| [x] DONE | includes/class-apg-elementor-scanner.php | Elementor scanner class | Present. | Keep. |
| [x] DONE | includes/class-apg-woocommerce-scanner.php | WooCommerce scanner class | Present. | Keep. |
| [x] DONE | includes/class-apg-report-exporter.php | Report exporter class | Present. | Keep. |
| [x] DONE | class-apg-widget-usage-scanner.php | Widget usage scanner class | Usage Map working in v1.0.1.3. | Keep. |
| [ ] PENDING | class-apg-conflict-scanner.php | Conflict scanner class | Future v1.0.3. | Do later. |
| [ ] PENDING | class-apg-error-log-scanner.php | Error log scanner class | Future v1.0.4. | Do later. |

---

## 17. Version Roadmap Tracker

| Mark | Version | Scope | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | v1.0.0 | Foundation Guard | Clean Separate Foundation Pass. | Locked. |
| [x] DONE | v1.0.1 | Usage Map | Stable as v1.0.1.3 after layout fixes. | Locked. |
| [ ] PENDING | v1.0.2 | Deep Amaley Core Integrity | Next major build only after confirmation. | Ask user before starting. |
| [ ] PENDING | v1.0.3 | External Plugin Conflict Scanner | Pending. | Not now. |
| [ ] PENDING | v1.0.4 | Fatal/Error Log Scanner | Pending. | Not now. |
| [ ] PENDING | v1.0.5 | Data Integrity Scanner | Pending. | Not now. |

---

## 18. v1.0.0 Locked Build Scope

| Mark | Area | Item | Comment | Next Action |
|---|---|---|---|---|
| [x] DONE | Admin menu | Separate top-level menu Amaley Project Guard | Amended from old submenu plan after live test. | Keep. |
| [x] DONE | Run Quick Scan | Manual Run Quick Scan button | Done. | Keep. |
| [ ] PENDING | Run Full Scan placeholder | Manual Full Scan placeholder if full scan not ready | Not added yet. | Add later if needed. |
| [x] DONE | Plugin registry | Active/inactive, Amaley vs external plugins | Done. | Keep. |
| [x] DONE | Basic project map | Detected plugins, CPTs, shortcodes, Elementor widgets | Done. | Keep. |
| [x] DONE | Amaley Core checks | Version/header/constant/file checks | Done basic. | Deepen later. |
| [x] DONE | Elementor check | Elementor active and widget detection | Done basic. | Deepen later. |
| [x] DONE | WooCommerce check | WooCommerce active and pages | Done basic. | Deepen later. |
| [x] DONE | Basic shortcode list | Registered shortcode list | Done. | Keep. |
| [x] DONE | Basic Elementor widget list | Registered Elementor widget list | Done. | Keep. |
| [x] DONE | Issue list | Severity, area, location, impact, suggested action | Done basic. | Deepen later. |
| [x] DONE | Markdown/JSON exports | Export reports | Done. | Keep. |
| [x] DONE | Performance-safe dashboard | Load cached report first | Done. | Keep. |
| [x] DONE | Self metrics | Scan time, memory estimate, scanned count | Done. | Keep. |

---

## 19. What Must Not Be Built Without Approval

| Mark | Rule | Comment |
|---|---|---|
| [x] DONE | No automatic fixes | Not built. |
| [x] DONE | No plugin deactivation | Not built. |
| [x] DONE | No deletion or cleanup tool | Not built. |
| [x] DONE | No frontend scanner | Not built. |
| [x] DONE | No background cron | Not built. |
| [x] DONE | No heavy unused-function scanner | Not built. |
| [x] DONE | No GitHub API integration inside WP plugin | Not built. |
| [x] DONE | No frontend hooks slowing site | Not built. |
| [x] DONE | No auto admin scan | Not built. |
| [x] DONE | No large silent scan | Not built. |
| [x] DONE | No remote calls inside normal WP requests | Not built. |

---

## 20. Hold / Do Not Touch Yet

| Mark | Item | Comment | Next Action |
|---|---|---|---|
| HOLD | Amaley Inspector Temporary Read-Only | Do not deactivate yet. | Review after deep checks. |
| HOLD | Amaley Relation Debug Tool | Do not deactivate yet. | Review after relation/data scanner. |
| HOLD | Inactive plugins | Do not delete yet. | Review after conflict/usage scan. |
| HOLD | Unused widgets | 45 unused does not mean safe to delete. | Manual review later. |
| HOLD | Unused shortcodes | 84 unused does not mean safe to delete. | Manual review later. |
| HOLD | Old debug pages under Tools | Do not remove blindly. | Review later. |
| HOLD | Theme plugin-install notice | Not Project Guard issue. | Separate audit later. |

---

## Update Commands for Future

### Tracker update command

Use the same tracker format. Mark only completed work as [x] DONE. Keep pending items as [ ] PENDING. Keep partial items as [~] PARTIAL. Keep HOLD items untouched. Do not create a random new format.

### Master ZIP update command

Update the Amaley master handoff ZIP only when explicitly asked. Read READ_FIRST and this tracker first. Preserve folder sequence. Add latest install ZIP, source ZIP, tracker DOCX/MD, notes, screenshots, changelog and next-step files. Do not remove older baseline references unless explicitly asked.

### GitHub verification command

Verify repo praveen-de-reptoiur/amaley-wordpress-system and path plugins/amaley-project-guard/. Confirm plugin is not inside plugins/amaley-core/. Check version, author, README, docs, includes, assets and tracker.

### Next build command

Before starting any next Project Guard version, read current tracker and locked plan. Build from current stable version only. Do not touch Amaley Core. Do not add frontend output. Do not add auto-fix/delete/deactivate. Work in small safe steps.
