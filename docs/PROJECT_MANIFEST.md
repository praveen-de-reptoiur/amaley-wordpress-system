# PROJECT MANIFEST — Amaley WordPress System

This manifest is the project index for the Amaley WordPress system.

---

## Repository

```text
praveen-de-reptoiur/amaley-wordpress-system
```

---

## GitHub Role

GitHub is used for source code, documentation, version history, migration planning, QA notes, and developer handoff notes.

GitHub is not used for heavy backup files, media, screenshots, videos, plugin ZIPs, `.wpress` backups, or secrets.

---

## Google Drive Role

Google Drive is used for plugin ZIP backups, full website backups, Elementor exports, WooCommerce exports, product images, screenshots, videos, and handoff packages.

---

## Current Locked Source Versions

| Plugin / Module | Current Source | Role |
| --- | --- | --- |
| Amaley Core | v1.0.99.4 | Data backbone, product-origin mapping, explicit Cluster → SHG/Producer Group links, rich story editors, gallery/media fields, CPT archive/single widgets, approved universal OG cards, card selectors/control bridges and origin-led section widgets |
| Amaley Discovery Engine | v1.3.5 | Discovery, filters, listings, search, sort, pagination |
| Amaley Site Shell | v1.0.1 | Header/footer shell and mobile drawer; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other, UI foundation |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact visual widgets; v0.4.2 active ZIP may remain until v0.4.3 staging test |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

---

## Elementor Stability Lock

```text
Elementor Atomic Editor must remain inactive.
```

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during the universal-card work. After deactivation, controls started working again.

---

## Latest Amaley Core Locks

Current Amaley Core v1.0.99.4 includes:

```text
v1.0.41   — Explicit Cluster → SHG/Producer Group linking
v1.0.45   — Cluster Full Story rich editor direction
v1.0.46   — Cluster Single spacing rhythm polish
v1.0.74   — SHG archive/single polish, gallery/media fields, section-level buttons, controls and card-design locks
v1.0.82.2 — Accepted Cluster Single card visual polish
v1.0.89   — Accepted Cluster Single OG card visibility/control work
v1.0.91   — Accepted Cluster Single no-reload pagination
v1.0.92.4 — Accepted Member Single OG card controls
v1.0.95   — SHG Single pagination clean safe
v1.0.96   — Member Single Products pagination
v1.0.97.5 — Cluster Archive existing controls mapped to OG Cluster Card 1
v1.0.97.6 — Universal Product Card PRICE label/value readability fix
v1.0.98.1 — SHG Archive OG controls selector fix
v1.0.99.4 — Member Archive OG Member Card 1 hide/show and style-control bridge
```

Relation source of truth meta key:

```text
_amaley_cluster_linked_group_ids
```

Admin edit box:

```text
Amaley Linked Producer Groups / SHGs
```

Expected frontend behaviour:

- Quick Details → SHGs count follows selected groups.
- SHG cards follow selected groups.
- People / Producer sections follow linked SHGs/producers.
- Story sections read rich story content from CPT records where implemented.
- Gallery sections use media/gallery fields where implemented.
- Mapped Products sections use WooCommerce product origin mapping.
- CPT sections follow the approved compact spacing rhythm.
- Card designs remain consistent across pages and contexts.
- Archive/single widgets use universal OG card families where connected.

---

## Current Architecture / Visual Locks

### `docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md`

Locks archive/single pages as section-wise systems using multiple Amaley Core section widgets.

### `docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md`

Locks `Amaley Section Spacing Rhythm 1` as the approved spacing density for future Amaley sections and later updates to existing loose sections.

### `docs/AMALEY_CARD_DESIGN_LOCK.md`

Locks the approved Cluster, SHG / Producer Group, Member / Producer and Product card families so the same card type stays visually consistent across the site.

Universal OG card flow:

```text
image / initials placeholder → label → title → description → meta/stat boxes → tags/chips → full-width rounded button
```

### `docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.md`

Version-wise record of what was done, what worked, what failed, what gaps remain and which version should be used.

---

## Current Documentation Index

### `README.md`

Main repository overview, current architecture, GitHub/Drive rules, plugin boundaries, and workflow rules.

### `docs/READ_FIRST_AMALEY.md`

Primary onboarding file. Read before touching the project.

### `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`

Main plugin/widget ownership registry. Use before building, moving, or changing widgets.

### `docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md`

CPT archive/single section structure lock for Cluster, SHG and Member / Producer pages.

### `docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md`

Whole-site section spacing rhythm lock based on approved v1.0.46 Cluster Single spacing.

### `docs/AMALEY_CARD_DESIGN_LOCK.md`

Approved card design lock for Cluster, SHG / Producer Group, Member / Producer and Product card families.

### `docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.md`

Version-wise Amaley Core development record from v1.0.74 to v1.0.99.4.

### `docs/AMALEY_CORE_CURRENT_STATUS_v1.0.99.4.md`

Current v1.0.99.4 status, latest working notes and accepted/pending areas.

### `docs/AMALEY_CORE_KNOWN_GAPS_AND_RISKS_v1.0.99.4.txt`

Known remaining gaps, risk items and cleanup concerns.

### `docs/AMALEY_CORE_SAFE_CLEANUP_PLAN_v1.0.99.4.txt`

Safe cleanup strategy before building the next new widget/module.

### `docs/AMALEY_CORE_NEXT_WORK_PLAN_v1.0.99.4.txt`

Next work sequence after GitHub source sync.

### `docs/AMALEY_CORE_INSTALL_AND_TEST_CHECKLIST_v1.0.99.4.txt`

Testing checklist for the synced v1.0.99.4 source.

### `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`

Locked design-system reference.

### `docs/AMALEY_PRIMARY_BUILD_RULES.md`

Primary safe-build and conflict-prevention rules.

### `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md`

Permanent performance and future UI direction lock.

### `docs/AMALEY_WIDGET_TEMPLATE_PERFORMANCE_FULL_CONTROL_RULE.md`

Widget/template control and performance expectations.

### `docs/CHANGELOG.md`

Project change history. Every serious change must be documented here.

### `docs/AMALEY_FRESH_WORDPRESS_MIGRATION_PLAN.md`

Fresh WordPress migration plan and safety approach.

### `docs/DRIVE_FOLDER_MAP.md`

Google Drive usage map.

### `docs/QA_CHECKLIST.md`

Testing and verification checklist.

### `docs/NEXT_CHAT_PROMPT.md`

Continuation prompt for future chats.

### `plugins/README.md`

Plugin/module source folder and ownership index.

---

## Current Source Folder Map

```text
plugins/
  README.md
  amaley-core/
  amaley-discovery-engine/
  amaley-site-shell/
  amaley-ui-sections-kit/
  amaley-compact-widgets/
  amaley-templates/
  amaley-project-guard/
  amaley-debug-toolkit/
```

---

## Hard Rules

- GitHub is source-only and documentation-only.
- ZIPs, screenshots, videos, backups and media dumps belong in Google Drive.
- Source files should be used for GitHub updates.
- Elementor Atomic Editor must remain inactive unless a separate rollback-safe test is planned.
- WooCommerce remains the commerce engine.
- Discovery Engine owns discovery/filter/list/search/sort/pagination logic.
- Core owns data backbone, origin mapping, explicit cluster group links, rich story support, gallery/media fields and CPT-driven sections.
- Core owns the locked CPT card families because those cards depend on Amaley Core data.
- UI Sections Kit owns locked generic page/home visual sections.
- Compact Widgets owns manual/static compact visual widgets.
- Templates supports WooCommerce/page template modules.
- Site Shell owns header/footer shell only; auto-render remains on hold until safely tested.
- Do not build the next new widget before cleanup.
- Do not say done until verification is complete.

---

## Next Safe Work

1. Test v1.0.99.4 across Single Cluster, Single SHG, Single Member, Cluster Archive, SHG Archive, Member Archive and product cards.
2. Create a cleanup baseline version before new widget development.
3. Suggested cleanup version name: `v1.0.100 CLEANUP BASELINE` or `v1.1.0 CLEANUP BASELINE`.
4. Remove unnecessary/duplicate code only after reference checks and rollback safety.
