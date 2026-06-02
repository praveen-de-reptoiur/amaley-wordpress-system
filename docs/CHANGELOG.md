# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

Every entry should clearly explain what changed, why it changed, which file/plugin/module was affected, and whether it is safe, experimental, or archived.

---

## 2026-06-02

### Amaley Core v1.0.99.4 — Universal Card Archive/Single Work, Member Archive Bridge and Source Sync

- Synced `plugins/amaley-core/` source to Amaley Core v1.0.99.4.
- Confirmed plugin header and `AMALEY_CORE_VERSION` are set to `1.0.99.4`.
- Preserved the GitHub source-only rule. ZIP/media/backups remain outside GitHub.
- Documented that Elementor Atomic Editor must remain inactive because it caused repeated Elementor left-panel loading/spinner issues during universal-card work.
- Preserved the locked universal OG card flow:

```text
image / initials placeholder → label → title → description → meta/stat boxes → tags/chips → full-width rounded button
```

Version chain captured:

```text
v1.0.74   — previous GitHub source baseline
v1.0.82.2 — accepted Cluster Single card visual polish
v1.0.89   — accepted Cluster Single OG card visibility + transform controls
v1.0.91   — accepted Cluster Single no-reload pagination
v1.0.92.4 — accepted Member Single OG full card controls
v1.0.95   — SHG Single pagination clean safe
v1.0.96   — Member Single Products pagination
v1.0.97.5 — Cluster Archive existing controls mapped to OG Cluster Card 1
v1.0.97.6 — Universal Product Card PRICE label/value readability fix
v1.0.98.1 — SHG Archive OG controls selector fix
v1.0.99.4 — Member Archive OG hide/show + style-control bridge
```

What changed in the current source sync:

- Updated Amaley Core source from v1.0.74 to v1.0.99.4.
- Added/kept universal card direction for Cluster, SHG / Collective, Member / Producer and Product card contexts.
- Kept Single Cluster related cards and accepted pagination/control work.
- Kept Single SHG card-control and pagination work from the current plugin chain.
- Kept Member Single linked SHG, linked Cluster and Products card-control work.
- Kept Cluster Archive OG Cluster Card 1 selector and existing-controls bridge.
- Kept SHG Archive OG SHG Card 1 selector and stronger selector-control fix.
- Kept Universal Product Card price label/value readability fix.
- Kept Member Archive OG Member Card 1 hide/show + style-control bridge using existing class bridge instead of new heavy controls.
- Added version-wise Amaley Core history documentation.
- Added cleanup and next-work planning documentation.

Affected source / docs:

```text
plugins/amaley-core/
plugins/amaley-core/amaley-core.php
plugins/amaley-core/assets/
plugins/amaley-core/includes/
docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.md
docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.csv
docs/AMALEY_CORE_DOCS_UPLOAD_GUIDE_v1.0.99.4.md
docs/AMALEY_CORE_CURRENT_STATUS_v1.0.99.4.md
docs/AMALEY_CORE_KNOWN_GAPS_AND_RISKS_v1.0.99.4.txt
docs/AMALEY_CORE_SAFE_CLEANUP_PLAN_v1.0.99.4.txt
docs/AMALEY_CORE_NEXT_WORK_PLAN_v1.0.99.4.txt
docs/AMALEY_CORE_INSTALL_AND_TEST_CHECKLIST_v1.0.99.4.txt
README.md
plugins/README.md
docs/CHANGELOG.md
docs/PROJECT_MANIFEST.md
docs/NEXT_CHAT_PROMPT.md
```

Safety decision:

```text
No WooCommerce cart/checkout override.
No header/footer override.
No permalink rewrite.
No ZIP/media committed to GitHub.
No new Member Archive JS/AJAX in v1.0.99.4.
No new OG full controls in the Member Archive v1.0.99.4 bridge.
Atomic Editor must remain inactive.
Cleanup is pending before new widget development.
```

Known gaps after v1.0.99.4:

- Full cleanup is still pending.
- Some older widgets may still contain too many Elementor controls.
- Archive pagination strategy still needs a final cross-archive review.
- Discovery Engine is not yet fully connected to the central Amaley Core Product Card renderer.
- Product archive/shop loop consistency still needs a separate phase.

Next safe work:

```text
1. Test v1.0.99.4 across Single Cluster, Single SHG, Single Member, Cluster Archive, SHG Archive, Member Archive and product cards.
2. Do not build a new widget before cleanup.
3. Create a cleanup baseline version, preferably v1.0.100 CLEANUP BASELINE or v1.1.0 CLEANUP BASELINE.
4. Remove unnecessary/duplicate code only after reference checks and rollback safety.
```

---

## 2026-06-01

### Amaley Core v1.0.74 — SHG Archive / Single Polish, Card Locks and Source Sync

- Synced `plugins/amaley-core/` source to Amaley Core v1.0.74.
- Confirmed plugin header and `AMALEY_CORE_VERSION` are set to `1.0.74`.
- Preserved the source-only GitHub rule. ZIP/media/backups remain outside GitHub.
- Continued the section-wise Elementor workflow instead of creating one hardcoded all-in-one page widget.
- Preserved the approved Cluster Single spacing rhythm direction.
- Added/updated SHG Archive and SHG Single section work after live/staging visual review.
- Added/continued gallery/media field direction for Cluster, SHG and Member records where implemented.
- Continued rich story editor direction for CPT story fields.
- Added/confirmed section-level CTA button requirement where a section shows limited cards.
- Added/confirmed button show/hide, text, URL, alignment and responsive-control expectations.
- Added `docs/AMALEY_CARD_DESIGN_LOCK.md` to lock approved Cluster, SHG, Member and Product card families.
- Locked that Cluster cards, SHG cards, Member / Producer cards and Product cards must not be randomly redesigned across pages.
- Locked product-card image handling and compact product-card direction for later Discovery integration.

Affected source / docs:

```text
plugins/amaley-core/
plugins/amaley-core/amaley-core.php
plugins/amaley-core/includes/class-amaley-core-shg-archive-sections.php
plugins/amaley-core/includes/class-amaley-core-shg-single-sections.php
plugins/amaley-core/includes/class-amaley-core-shg-cards.php
plugins/amaley-core/includes/class-amaley-core-cluster-cards.php
plugins/amaley-core/includes/class-amaley-core-member-cards.php
plugins/amaley-core/includes/class-amaley-core-metaboxes.php
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Safety decision:

```text
No WooCommerce cart/checkout override.
No header/footer override.
No permalink rewrite intentionally documented.
No ZIP/media committed to GitHub.
No global CSS dump approved.
No random card redesign allowed after this lock.
```

### Amaley Core v1.0.46 — Cluster Single Spacing Rhythm Polish Source Sync

- Synced `plugins/amaley-core/` source to Amaley Core v1.0.46.
- Confirmed plugin header and `AMALEY_CORE_VERSION` are set to `1.0.46`.
- Added/confirmed Cluster Single spacing rhythm polish after user-approved frontend review.
- Preserved separate section widgets as the final editing workflow.
- Tightened Hero → Quick Details → Story → Women Collectives → Producers → Products → CTA rhythm.
- Preserved v1.0.41 explicit relation key:

```text
_amaley_cluster_linked_group_ids
```

- Preserved v1.0.45 Cluster Full Story rich editor direction.
- Confirmed source sync did not include ZIP/media files.

Affected source:

```text
plugins/amaley-core/
plugins/amaley-core/amaley-core.php
plugins/amaley-core/CHANGELOG.md
plugins/amaley-core/CLUSTER_SINGLE_SPACING_RHYTHM_POLISH_v1.0.46.md
plugins/amaley-core/RICH_TEXT_CLUSTER_STORY_FIELD_v1.0.45.md
plugins/amaley-core/RELATION_EXPLICIT_LINKS_FIX_v1.0.41.md
```

Safety decision:

```text
No WooCommerce cart/checkout override.
No header/footer override.
No permalink rewrite.
No relation/meta change.
No all-in-one widget conversion.
No ZIP/media committed to GitHub.
```

### Amaley Section Spacing Rhythm 1 Lock

- Added `docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md`.
- Locked the approved v1.0.46 spacing density as the future whole-site section spacing reference.
- Future Amaley sections should follow this compact, premium, connected spacing rhythm.
- Existing loose sections should be updated later to match this rhythm.

### CPT Single Section Structure Lock

- Added `docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md` before spacing polish continuation.
- Locked that Archive and Single pages use separate section widgets.
- Locked that all-in-one widgets may remain only as legacy/fallback/test helpers, not final workflow.
- Locked Cluster Single, SHG Single and Member / Producer Single section order.

### Documentation Alignment — v1.0.74

- Updated root `README.md` to show Amaley Core v1.0.74 as the current GitHub source.
- Updated `docs/READ_FIRST_AMALEY.md` to include v1.0.74 and the card design lock.
- Updated `docs/CHANGELOG.md` with the v1.0.74 source sync entry.
- Updated `docs/PROJECT_MANIFEST.md` to align current source versions and lock docs.
- Updated `docs/NEXT_CHAT_PROMPT.md` so future chats continue from v1.0.74.
- Updated `plugins/README.md` to align Amaley Core source status and responsibilities.

---

## 2026-05-31

### Amaley Core v1.0.41 — Explicit Cluster Group Linking Source Sync

- Synced `plugins/amaley-core/` source to Amaley Core v1.0.41.
- Confirmed the plugin header and `AMALEY_CORE_VERSION` are now set to `1.0.41`.
- Added/confirmed explicit Cluster → SHG/Producer Group relation source:

```text
_amaley_cluster_linked_group_ids
```

- Added/confirmed Cluster edit screen side metabox:

```text
Amaley Linked Producer Groups / SHGs
```

- Confirmed this relation is saved directly on the Cluster record and is read first by the single cluster frontend.
- Live/staging observation confirmed:
  - Quick Details SHG count updates from selected groups.
  - Women Collectives section renders selected SHG/Producer Group cards.
  - People behind the cluster updates through linked SHGs.

Affected source:

```text
plugins/amaley-core/
plugins/amaley-core/amaley-core.php
plugins/amaley-core/includes/class-amaley-core-metaboxes.php
plugins/amaley-core/includes/class-amaley-core-cluster-single-sections.php
plugins/amaley-core/RELATION_EXPLICIT_LINKS_FIX_v1.0.41.md
```

Safety decision:

```text
No WooCommerce cart/checkout override.
No header/footer override.
No permalink rewrite.
No ZIP/media committed to GitHub.
Source and documentation only.
```

### Documentation Alignment — v1.0.41

- Updated root `README.md` to show Amaley Core v1.0.41 as the current GitHub source.
- Updated `docs/READ_FIRST_AMALEY.md` to include v1.0.41 and the explicit relation meta key.
- Updated `docs/CHANGELOG.md` with this v1.0.41 source sync entry.
- Updated `docs/PROJECT_MANIFEST.md` to align current source versions.
- Updated `docs/NEXT_CHAT_PROMPT.md` so future chats continue from v1.0.41, not v1.0.2.
- Updated `plugins/README.md` to align the plugin source status table.

---

## 2026-05-30

### Plugin Source Lock Update

- Confirmed Amaley UI Sections Kit source is locked at v0.6.1.
- Confirmed Amaley Compact Widgets source is updated and locked at v0.4.2.
- Cleaned the Compact Widgets changelog duplicate heading.
- Confirmed Compact Widgets v0.4.2 includes alignment controls for header, card/item text, and button row alignment.
- Confirmed Compact Widgets remains frontend-JS-free and scoped to the `.amaley-cw4-*` CSS family.
- Confirmed GitHub must remain source-only and documentation-only.

Current source locks after the 2026-06-02 update:

```text
Amaley Core: v1.0.99.4
Amaley Discovery Engine: v1.3.5
Amaley Site Shell: v1.0.1
Amaley UI Sections Kit: v0.6.1
Amaley Compact Widgets: v0.4.3 source / v0.4.2 active ZIP until staging test
Amaley Templates: v1.2.7
```

### Documentation Sync

- Updated root `README.md` with the current plugin architecture and added Amaley Compact Widgets to the target architecture.
- Updated `plugins/README.md` with current source folder structure and active source/Drive ZIP status.
- Updated `docs/READ_FIRST_AMALEY.md` with current plugin locks, GitHub/Drive rules, and source-only workflow.
- Updated `docs/NEXT_CHAT_PROMPT.md` so future chats do not treat UI Sections Kit as unbuilt and do not forget Compact Widgets.
- `docs/PROJECT_MANIFEST.md` should remain aligned with current plugin registry and source locks.

Safety decision:

```text
No plugin ZIP committed to GitHub.
No media committed to GitHub.
No live-site change done.
Documentation/source lock cleanup only.
```

---

## 2026-05-27

### Architecture / Documentation Update — UI Sections Kit and Performance Lock

- Added `docs/AMALEY_PERFORMANCE_AND_NO_ELEMENTOR_LOCK.md` as the permanent performance and future UI direction lock.
- Locked the future Amaley website direction as lightweight, low-network-first, mobile-first, and globally design-token controlled.
- Locked the rule that future clean Amaley UI sections must not depend on Elementor default widgets.
- Clarified that Elementor may still exist temporarily in old/current migration contexts.
- Created `plugins/amaley-ui-sections-kit/README.md` as the planning folder for the future lightweight UI section/component system.
- Removed the old `plugins/amaley-widgets-kit/` planning folder to avoid the outdated Elementor-only direction.
