# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

## Mandatory first read

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`
4. `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.4.4.md`

Universal rule:

Every section and every element must have non-coder friendly controls for content, show/hide, layout, style, and responsive behavior, with scoped lightweight CSS and no conflict.

## Project references

- GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Main README: `README.md`
- Root read-first: `000_READ_FIRST_BEFORE_ANY_WORK.md`
- Universal standard: `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
- Amaley read-first: `docs/READ_FIRST_AMALEY.md`
- Discovery Engine current status: `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.4.4.md`
- Plugin/widget registry: `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- CPT structure lock: `docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md`
- Section spacing rhythm lock: `docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md`
- Card design lock: `docs/AMALEY_CARD_DESIGN_LOCK.md`
- Version history: `docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.md`
- Design system: `docs/AMALEY_DESIGN_SYSTEM_LOCKED.md`
- Changelog: `docs/CHANGELOG.md`
- QA checklist: `docs/QA_CHECKLIST.md`
- Project manifest: `docs/PROJECT_MANIFEST.md`
- Plugin/module architecture: `plugins/README.md`

## Current project rules

- Read the universal standard before designing or building.
- GitHub is for source code, docs, changelog, planning, QA notes, and developer handoff.
- Google Drive is for backups, plugin ZIPs, media, screenshots, videos, exports, and handoff packages.
- Do not upload ZIPs or media to GitHub.
- WooCommerce remains the commerce engine.
- Custom Amaley plugins must support WooCommerce, not replace it.
- Do not create fake Cluster, SHG, Producer, or origin data.
- Every serious change must be versioned, documented, tested, and reversible.
- Do not say done without verification.
- Elementor Atomic Editor must remain inactive.

## Current plugin source status

| Plugin / Module | GitHub source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.99.4 | Data backbone, product-origin mapping, explicit Cluster → SHG/Producer Group links, CPT archive/single sections, gallery/media fields, rich story direction, universal OG card families, archive/single card selectors and control bridges |
| Amaley Discovery Engine | v1.4.4 stable OG card controls | Discovery/filter/listing engine with source-level Amaley Core OG Product Card 1 renderer, accepted full selected OG product-card controls, pagination/filter/sort working |
| Amaley Site Shell | v1.0.1 | Header/footer shell; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact widgets; v0.4.2 ZIP may remain active until v0.4.3 staging test |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

## Current Discovery Engine continuation point

Amaley Discovery Engine v1.4.4 is the current accepted GitHub source.

Accepted render flow:

```text
Product Discovery widget
→ Card Renderer: Amaley Core Product Card — Select Template
→ Template: OG Product Card 1
```

Accepted behaviour:

- OG Product Card 1 appears in product discovery grid.
- Pagination keeps OG Product Card 1.
- Filter, reset and sort keep OG Product Card 1.
- Card renderer remains selectable for future approved Core product-card templates.
- Product data, photos/gallery, origin mapping, WooCommerce templates, header and footer are untouched.

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

Do not use / revive these rejected attempts:

```text
v1.3.7, v1.3.8, v1.3.9, v1.4.0, v1.4.1, v1.4.2, v1.4.3 rollback packages
```

Next Discovery work must be source-level and one-by-one:

```text
1. Cluster filter
2. SHG / Collective filter
3. Producer / Member filter
```

After each filter addition, test:

```text
Page 1, page 2, sort, filter apply, reset
```

## Current Amaley Core continuation point

Amaley Core v1.0.99.4 is the current GitHub source.

Important relation key:

```text
_amaley_cluster_linked_group_ids
```

Admin field:

```text
Amaley Linked Producer Groups / SHGs
```

Preserved locks:

```text
v1.0.41   — explicit Cluster → SHG/Producer Group linking
v1.0.45   — Cluster Full Story rich editor direction
v1.0.46   — Cluster Single spacing rhythm polish
v1.0.74   — SHG archive/single polish, gallery/media fields, section buttons, controls and card design locks
v1.0.82.2 — accepted Cluster Single card visual polish
v1.0.89   — accepted Cluster Single OG card visibility/control work
v1.0.91   — accepted Cluster Single no-reload pagination
v1.0.92.4 — accepted Member Single OG card controls
v1.0.95   — SHG Single pagination clean safe
v1.0.96   — Member Single Products pagination
v1.0.97.5 — Cluster Archive existing controls mapped to OG Cluster Card 1
v1.0.97.6 — Universal Product Card PRICE label/value readability fix
v1.0.98.1 — SHG Archive OG controls selector fix
v1.0.99.4 — Member Archive OG Member Card 1 hide/show and style-control bridge
```

Approved spacing reference:

```text
Amaley Section Spacing Rhythm 1
```

Future work should use the same compact section spacing across the site. Existing loose sections can be updated later.

## Elementor stability lock

Elementor Atomic Editor must remain inactive.

Reason: Atomic Editor caused repeated Elementor left-panel loading/spinner issues during universal-card work. After deactivation, controls started working.

Do not reactivate Atomic Editor unless a separate rollback-safe test plan exists.

## Current card design lock

Cluster cards, SHG / Producer Group cards, Member / Producer cards and Product cards are locked.

Reference:

```text
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Universal OG card flow:

```text
image / initials placeholder → label → title → description → meta/stat boxes → tags/chips → full-width rounded button
```

Rules:

- Same card type must keep the same design wherever it appears.
- Do not redesign card families casually.
- Product card design is now reused in Discovery Engine v1.4.4.
- Images should use cover center center and practical image-height / ratio controls.
- Description words, max tags, section buttons, button alignment and responsive behaviour need controls where relevant.
- Avoid transform/motion controls unless specifically required and tested.

## Current architecture lock

CPT archive/single pages must use separate Amaley Core section widgets.

Final scalable workflow:

```text
One page template + multiple Amaley Core section widgets.
```

Do not turn Cluster, SHG or Member pages into one hardcoded all-in-one widget as the final workflow.

## Current known gaps

- Discovery Engine Cluster / SHG / Producer filters are pending.
- Archive pagination strategy still needs cross-archive review.
- Product archive/shop-loop consistency still needs a separate phase.
- Cleanup is still needed before broad new module development.

## Next safe work sequence

1. Keep Amaley Discovery Engine v1.4.4 as the stable baseline.
2. Do not revisit old card-render patch plugins.
3. Add Cluster filter source-level first.
4. Test page 1, page 2, sort, filter apply, reset.
5. Only then add SHG / Collective filter.
6. Only then add Producer / Member filter.
7. Keep card controls structure unchanged unless Praveen explicitly asks.

## Working style

- First read the root read-first file and universal standard.
- Review repo/source status before changes.
- Use source files for GitHub updates.
- Never upload ZIPs/media/screenshots/videos to GitHub.
- Give commit messages before GitHub updates.
- Preview or dry-test visual widgets before final.
- Keep steps small and sequential.
- Do not say done without verification.
