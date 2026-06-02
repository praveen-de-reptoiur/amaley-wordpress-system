# Amaley Core Version History — v1.0.74 to v1.0.99.4

Prepared: 2026-06-02

## Purpose

This document records version-wise progress for Amaley Core so future work is not confusing. It explains what was done, what happened during testing, what issue/kami remained, and which version should or should not be used.

## Current GitHub and Working Status

- Current GitHub source before this sync: **v1.0.74**.
- Current latest working source after this sync: **v1.0.99.4**.
- Elementor **Atomic Editor must remain inactive** because it caused repeated editor left-panel loading/spinner issues.
- GitHub should store source and docs only. ZIPs/media/backups should remain outside GitHub.

## Version-wise table

| Version | Status | What was done | What happened / result | Kami / issue | Decision |
| --- | --- | --- | --- | --- | --- |
| v1.0.74 | Current old GitHub baseline | SHG Archive / Single polish, card design lock, gallery/media field direction, rich story direction, section-level CTA/control expectations. | Stable source previously present on GitHub. | Far behind current working plugin. Missing latest universal card renderer, Member Single/Archive work, SHG/Cluster archive fixes, pagination fixes and price label/value fix. | Historical baseline only. Replaced by v1.0.99.4 source. |
| v1.0.75 | Intermediate | Member Archive clean rebuild from v1.0.74 baseline. | Started Member Archive clean structure. | Not final; later versions changed controls/cards. | Document only. |
| v1.0.76 | Intermediate | Member Archive controls-only update. | Added control direction for Member Archive. | Not final. | Document only. |
| v1.0.76.1 | Intermediate | Member Archive gallery compact polish. | Improved compact visual/gallery handling. | Not current; later card system moved toward universal card flow. | Document only. |
| v1.0.76.2 | Intermediate | Member Archive grid card micro controls. | More visual control for Member Archive cards. | Contributed to growing control complexity later. | Review during cleanup. |
| v1.0.76.3 | Intermediate | Manual gallery controls. | Allowed more manual gallery handling. | Potential cleanup candidate if unused. | Audit before deleting. |
| v1.0.76.4 | Intermediate | Chip overflow controls. | Improved chip/tag handling. | May be duplicated by universal card tag/chip controls. | Audit during cleanup. |
| v1.0.76.5 | Intermediate | Generic Manual Gallery Section. | Added/expanded reusable manual gallery section. | Confirm whether still used. | Keep only if actively used. |
| v1.0.77 | Intermediate | Member Single normal build. | Member Single page structure started. | Later versions polished controls/cards. | Historical step. |
| v1.0.78 | Intermediate | Member Single visual rhythm polish. | Improved Member Single spacing/visual flow. | Later universal card and control updates superseded parts. | Historical step. |
| v1.0.78.10 | Safety baseline | Product card consistency fix before centralized Card Library / Assignment direction. | Used as stable reference before card renderer expansion. | Not final; assignments and multiple widgets came later. | Historical safety baseline. |
| v1.0.82.2 | Accepted | Cluster Core Card Visual Polish for Cluster Single SHG and Producer/Member cards using centralized renderer. | Accepted after phone and frontend testing. | Product/Discovery/WooCommerce/Header/Footer untouched. | Keep accepted card design logic. |
| v1.0.89 | Accepted | Cluster Single OG Card Visibility + Transform Controls. | Cluster Single Related SHGs and Producers got working card style, show/hide, transform controls. | Transform controls add editor weight; review in cleanup. | Keep accepted functionality, audit heaviness. |
| v1.0.91 | Accepted | Cluster AJAX Pagination No-Reload. | Cluster Single Related SHGs, Producers, and Products got no-reload pagination. | Archive pagination still not finalized everywhere. | Keep; use as pagination reference. |
| v1.0.92.4 | Accepted | Member Single OG Full Card Controls. | Member Single Linked SHG, Linked Cluster, and Products got OG Card 1 selector and controls aligned with Cluster Single. | Full controls may increase editor weight. | Keep but audit in performance cleanup. |
| v1.0.95 | Working | SHG Single Pagination Clean Safe. | Members and Products pagination added/fixed for SHG Single. | Needs periodic check if cleanup changes query helpers. | Keep. |
| v1.0.96 | Working | Member Single Products Pagination. | Pagination added to Member Single Products. | Linked SHG/Cluster remain unpaginated by design. | Keep. |
| v1.0.97 | Rejected / too heavy | Cluster Archive OG Cluster Card 1 selector + full controls. | Selector and controls were added. | Over-engineered. Heavy Elementor controls caused confusion/loading risk. | Do not use as final approach. |
| v1.0.97.1 | Rejected / incomplete fix | Cluster Archive Universal Card Fix. | Tried to correct archive OG card visual structure. | Still not acceptable; further lightweight rescue required. | Do not use as final approach. |
| v1.0.97.2 | Rescue / lightweight | Cluster Archive Lightweight OG Card Rescue. | Removed heavy controls; kept simple Card Template selector and fixed CSS design. | Show/hide and style control mapping still needed later. | Good rescue direction. |
| v1.0.97.3 | Audited lightweight lock | Cluster Archive audited lightweight lock. | Confirmed no heavy OG full controls, no transform controls, no archive JS/AJAX. | Show/hide/style controls still needed refinement. | Safe intermediate. |
| v1.0.97.4 | Fix | Cluster Archive OG Show/Hide Fix. | Show/hide controls mapped more strongly for OG Cluster Card 1. | Existing style controls still needed mapping to OG classes. | Keep as part of later final chain. |
| v1.0.97.5 | Working | Cluster Archive Existing Controls Work on OG. | Existing controls 8–13 mapped to lightweight OG Cluster card classes. | Needs practical retest after source sync. | Keep. |
| v1.0.97.6 | Working | Universal Product Card PRICE label/value readability fix. | PRICE label and price value hierarchy improved; WooCommerce `.amount`/`bdi` inherit correct styling. | Product Archive/Discovery integration still pending. | Keep. |
| v1.0.98 | Initial SHG Archive selector | SHG Archive OG SHG Card 1 selector and mapping. | Selector added. | Controls did not apply reliably due to weak selectors. | Superseded by v1.0.98.1. |
| v1.0.98.1 | Working | SHG Archive OG Controls Selector Fix. | Stronger scoped selectors fixed existing style controls for OG SHG Card 1. | Needs final frontend/editor retest after GitHub sync. | Keep. |
| v1.0.99 | Rejected / editor issue | Member Archive Universal Card Selector + Controls. | OG Member Card 1 selector + existing controls mapping added. | Elementor loading/spinner issue appeared again. Too heavy. | Do not use. Superseded. |
| v1.0.99.1 | Rejected / not enough | Member Archive Lightweight Rescue. | Tried removing heavy mapping and keeping lightweight selector. | Did not fully resolve while Atomic Editor/editor remained unstable. | Do not use as final. |
| v1.0.99.2 | Rollback / editor-safe | Member Archive rollback to stable v1.0.98.1 with higher version number. | Used to restore editor safety. | Member Archive OG selector removed in rollback. | Keep as emergency fallback note. |
| v1.0.99.3 | Working lightweight attempt | Member Archive Lightweight OG Selector. | Added Card Template selector + OG Member Card 1 render path without heavy style mapping. | Style controls did not affect OG card because old control classes were not bridged. | Superseded by v1.0.99.4. |
| v1.0.99.4 | Current latest source | Member Archive OG Hide/Show + Style Controls Fix using class-bridge method. | OG Member Card 1 markup carries existing control classes so hide/show + style controls work without adding new heavy control sections. | Needs full-site test after GitHub source sync. Cleanup is pending before new widgets. | Use as current source. |

## Versions not recommended for use

Do not use these as final current source:

- `v1.0.97` — Cluster Archive full-control approach was too heavy.
- `v1.0.97.1` — visual fix attempt was not sufficient.
- `v1.0.99` — Member Archive control mapping caused Elementor loading issue.
- `v1.0.99.1` — lightweight rescue did not fully settle the issue before Atomic Editor was handled.

## Current version to use

```text
v1.0.99.4
```

Why:

- Built after Atomic Editor issue was identified.
- Member Archive OG Member Card 1 uses class-bridge method instead of adding new heavy control sections.
- Avoids new JS/AJAX and avoids new OG full controls in the latest Member Archive fix.
- Keeps the universal card direction.

## Immediate pending after GitHub sync

1. Test Single Cluster, Single SHG, Single Member, Cluster Archive, SHG Archive, Member Archive and product cards.
2. Start cleanup phase before building any new widget.
3. Do not delete code blindly.
4. Prepare `v1.0.100 CLEANUP BASELINE` or `v1.1.0 CLEANUP BASELINE`.

## Cleanup warning

Do not delete code blindly. The plugin has many patch versions and some legacy helpers may still be referenced. Cleanup should be versioned separately and should remove only confirmed unused code, duplicate controls, old docs inside runtime plugin folder, and dead CSS after testing.

## Locked future rule

- Keep Atomic Editor inactive.
- Avoid heavy OG full controls.
- Avoid adding transform controls everywhere.
- Use existing class-bridge/control reuse where possible.
- Make one small plugin version per widget/module.
- Document every version immediately.
