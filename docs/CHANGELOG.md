# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

Every entry should clearly explain what changed, why it changed, which file/plugin/module was affected, and whether it is safe, experimental, or archived.

---

## 2026-06-06

### Amaley Discovery Engine v1.4.4 — Stable OG Product Card Source Renderer and Full Card Controls

- Synced `plugins/amaley-discovery-engine/` source to Amaley Discovery Engine v1.4.4.
- Confirmed plugin header and `AMALEY_DE_VERSION` are set to `1.4.4`.
- Preserved the source-level renderer path introduced after the v1.3.6 core-card source fix.
- Product Discovery now supports the selected Amaley Core product-card renderer without frontend card-replacement patches.
- Current accepted renderer flow:

```text
Product Discovery widget
→ Card Renderer: Amaley Core Product Card — Select Template
→ Template: OG Product Card 1
```

- Confirmed user-accepted behaviour after testing:
  - OG product cards render in the Product Discovery grid.
  - Pagination continues to return OG product cards.
  - Filter, reset and sort continue to return OG product cards.
  - Product Card Renderer selector remains available for future approved product-card templates.
  - Full selected OG product-card controls are accepted in the Elementor widget.

Approved control structure:

```text
Content tab:
- Product Card Renderer
- Selected OG Product Card — Content

Style tab:
- Section / Heading
- Filters / Toolbar
- Grid / Spacing
- Selected OG Product Card — Layout
- Selected OG Product Card — Text
- Selected OG Product Card — Meta & Tags
- Selected OG Product Card — Button
- Pagination
```

Safety decision:

```text
No product data changes.
No product images/gallery changes.
No product-origin mapping changes.
No WooCommerce cart/checkout/template override.
No header/footer change.
No broad global CSS.
No frontend replacement/stabilizer patch layer.
```

Rejected / archived attempts:

```text
v1.3.7 — broken Style tab restoration path
v1.3.8 — section-close recovery but incomplete control behaviour
v1.3.9 — broad CSS/control attempt that damaged cards
v1.4.0 — safe-control attempt but incomplete micro-control planning
v1.4.1 — hover-control attempt with confusing structure
v1.4.2 — fatal activation risk / rejected
v1.4.3 — rollback package only, not the final accepted version
```

Affected source / docs:

```text
plugins/amaley-discovery-engine/
plugins/amaley-discovery-engine/amaley-discovery-engine.php
plugins/amaley-discovery-engine/includes/class-amaley-de-renderer.php
plugins/amaley-discovery-engine/includes/class-amaley-de-plugin.php
plugins/amaley-discovery-engine/includes/elementor/class-amaley-de-elementor-base.php
plugins/amaley-discovery-engine/assets/css/amaley-de-frontend.css
docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.4.4.md
README.md
plugins/README.md
docs/CHANGELOG.md
docs/PROJECT_MANIFEST.md
docs/NEXT_CHAT_PROMPT.md
```

Next safe work:

```text
1. Keep v1.4.4 as the current Discovery Engine baseline.
2. Do not revisit old card-render patch plugins.
3. Add Cluster filter source-level only after this baseline remains stable.
4. Then add SHG / Collective filter.
5. Then add Producer / Member filter.
6. Test pagination/filter/sort after each filter addition.
```

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
v1.0.99.4 — Member Archive OG Member Card 1 hide/show + style-control bridge
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
- Discovery Engine is now connected to the central Amaley Core Product Card renderer in v1.4.4.
- Product archive/shop-loop consistency still needs a separate phase.

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
```
