# NEXT CHAT PROMPT — Amaley WordPress System

Use this prompt when starting a new ChatGPT chat for Amaley.

## Mandatory first read

Before any planning, design, Elementor widget, plugin, template, archive/single page, layout, or UI build, first read:

1. `000_READ_FIRST_BEFORE_ANY_WORK.md`
2. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
3. `docs/READ_FIRST_AMALEY.md`

Universal rule:

Every section and every element must have non-coder friendly controls for content, show/hide, layout, style, and responsive behavior, with scoped lightweight CSS and no conflict.

## Project references

- GitHub repository: `praveen-de-reptoiur/amaley-wordpress-system`
- Main README: `README.md`
- Root read-first: `000_READ_FIRST_BEFORE_ANY_WORK.md`
- Universal standard: `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
- Amaley read-first: `docs/READ_FIRST_AMALEY.md`
- Plugin/widget registry: `docs/AMALEY_PLUGIN_WIDGET_REGISTRY_AND_CONFLICT_RULES.md`
- CPT structure lock: `docs/AMALEY_CPT_SINGLE_SECTION_STRUCTURE_LOCK.md`
- Section spacing rhythm lock: `docs/AMALEY_SECTION_SPACING_RHYTHM_LOCK.md`
- Card design lock: `docs/AMALEY_CARD_DESIGN_LOCK.md`
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

## Current plugin source status

| Plugin / Module | GitHub source | Notes |
| --- | --- | --- |
| Amaley Core | v1.0.74 | Data backbone, product-origin mapping, explicit Cluster → SHG/Producer Group links, SHG archive/single sections, gallery/media fields, rich story direction, card locks and section controls |
| Amaley Discovery Engine | v1.3.5 | Discovery/filter/listing engine |
| Amaley Site Shell | v1.0.1 | Header/footer shell; auto-render on hold |
| Amaley UI Sections Kit | v0.6.1 | Home Hero V6, Page Trust Strip, Pages Hero Other |
| Amaley Compact Widgets | v0.4.3 source | Manual/static compact widgets; v0.4.2 ZIP may remain active until v0.4.3 staging test |
| Amaley Templates | v1.2.7 | WooCommerce/page template support |

## Current Amaley Core continuation point

Amaley Core v1.0.74 is now the current GitHub source.

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
v1.0.41 — explicit Cluster → SHG/Producer Group linking
v1.0.45 — Cluster Full Story rich editor direction
v1.0.46 — Cluster Single spacing rhythm polish
v1.0.74 — SHG archive/single polish, gallery/media fields, section buttons, controls and card design locks
```

Approved spacing reference:

```text
Amaley Section Spacing Rhythm 1
```

Future work should use the same compact section spacing across the site. Existing loose sections can be updated later.

## Current card design lock

Cluster cards, SHG / Producer Group cards, Member / Producer cards and Product cards are locked.

Reference:

```text
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Rules:

- Same card type must keep the same design wherever it appears.
- Do not redesign card families casually.
- Product card design should be reused later in Discovery where practical.
- Images should use cover center center and practical image-height / ratio controls.
- Description words, max tags, section buttons, button alignment, animations and responsive behaviour need controls where relevant.

## Current architecture lock

CPT archive/single pages must use separate Amaley Core section widgets.

Final scalable workflow:

```text
One page template + multiple Amaley Core section widgets.
```

Do not turn Cluster, SHG or Member pages into one hardcoded all-in-one widget as the final workflow.

## Next safe work sequence

1. Verify Amaley Core v1.0.74 source after GitHub upload.
2. Keep card designs locked while continuing SHG Single and Cluster Archive refinements.
3. Do not alter locked Cluster/SHG/Member/Product card designs unless Praveen explicitly unlocks them.
4. Add missing section-level CTA buttons where sections show limited cards.
5. Continue Member / Producer Single only after SHG Single pattern remains stable.
6. Later update older loose sections to Amaley Section Spacing Rhythm 1.
7. Later integrate locked Product card style into Discovery where practical.

## Working style

- First read the root read-first file and universal standard.
- Review repo/source status before changes.
- Use source files for GitHub updates.
- Never upload ZIPs/media/screenshots/videos to GitHub.
- Give commit messages before GitHub updates.
- Preview or dry-test visual widgets before final.
- Keep steps small and sequential.
