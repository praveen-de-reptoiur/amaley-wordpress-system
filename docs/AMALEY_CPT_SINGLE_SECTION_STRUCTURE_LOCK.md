# AMALEY CPT SINGLE SECTION STRUCTURE LOCK

Status: Active architecture lock  
Owner: Praveen  
Date locked: 2026-05-31  
Applies to: Amaley Core and all CPT-driven archive/single pages

---

## Why this lock exists

Amaley Core is the controlled data layer for Clusters, SHG Groups, Members / Producers and Product Origin Mapping.

The public pages for these CPTs must be built as section-wise systems, not as one hardcoded all-in-one block. This keeps the website non-coder manageable in Elementor while keeping data logic inside Amaley Core.

This document locks the structure before further spacing, SHG single, Member single, archive, or visual polish work begins.

---

## Master rule

Archive pages and single pages must use separate section widgets.

Do not use one all-in-one widget as the final workflow.

All-in-one widgets may exist only as legacy, fallback, migration or quick-test helpers. They must not become the final production editing method.

---

## Required control standard for every section widget

Every CPT section widget must provide non-coder friendly controls for:

- Content
- Show / Hide
- Data source where relevant
- Layout
- Alignment
- Style
- Typography
- Colors
- Spacing
- Border / radius / shadow where relevant
- Buttons / links where relevant
- Button alignment desktop / tablet / mobile where relevant
- Section-level CTA button controls where the section shows limited cards
- Image / gallery visibility, height, fit and position where relevant
- Description word count / excerpt length where relevant
- Chips / tags max count where relevant
- Smooth animation / transform controls where relevant
- Responsive desktop / tablet / mobile behaviour
- Empty-state text where relevant

Controls must be section-wise and easy to understand. Do not mix unrelated controls into one confusing panel.

---

## Shared spacing rhythm lock

Because sections are separate widgets, visual rhythm must be controlled through a shared spacing system.

The goal is:

```text
Separate widgets, one continuous page flow.
```

Default spacing should avoid the page looking like broken pieces.

The shared rhythm must support:

- Section top padding
- Section bottom padding
- Section margin top
- Section margin bottom
- Heading gap
- Card grid gap
- Card internal spacing
- Desktop spacing
- Tablet spacing
- Mobile spacing

Manual one-off Elementor spacing fixes should not be the main solution. Plugin defaults and widget controls must carry the rhythm.

---

## Section-level CTA button rule

Whenever a section shows a limited number of related cards, the section should provide an optional section-level CTA button.

Examples:

```text
View all SHGs
View all producers
View all products
View all clusters
```

This button must have:

- Show / hide control
- Button text control
- URL control
- Alignment control for desktop / tablet / mobile
- Style controls so it does not disappear into the background
- Responsive spacing controls

This applies across Cluster Archive, Cluster Single, SHG Archive, SHG Single, Member / Producer pages, and Product-origin sections wherever limited-card previews are used.

---

## Gallery / media rule

Cluster, SHG and Member / Producer records should support gallery/media fields where visual story sections are required.

Gallery fields should be manageable from the relevant CPT edit screen, not only by manually pasting placeholder image URLs.

Where URL fallback fields exist for migration/testing, they should not replace the long-term media-management direction.

Gallery sections should have controls for:

- Show / hide
- Label, title and description
- Image source / fallback
- Number of images
- Image ratio / height
- Object fit and object position
- Columns desktop / tablet / mobile
- Gap
- Overlay text visibility where relevant
- Responsive behaviour

---

## Cluster Archive structure lock

Cluster Archive must be built section-wise.

Recommended final order:

1. Cluster Archive Hero
2. Cluster Archive Trust Strip
3. Cluster Archive Intro / Why Section
4. Cluster Archive Grid
5. Cluster Archive Gallery / Story Visual Section where approved
6. Cluster Archive CTA Band

The archive grid should route to the assigned Cluster Single Template Page where applicable.

---

## Cluster Single structure lock

Cluster Single must be built section-wise.

Recommended final order:

1. Cluster Hero
2. Quick Details / Cluster Snapshot
3. Cluster Story
4. Women Collectives / SHGs connected with this cluster
5. People / Producers behind the cluster
6. Mapped Products
7. Gallery
8. Contact / CTA

Important:

- The Cluster Story section should read the Cluster Full Story from Amaley Core data.
- SHGs should read explicit cluster-side linked groups first.
- Current source of truth for explicit group links:

```text
_amaley_cluster_linked_group_ids
```

- The admin edit box is:

```text
Amaley Linked Producer Groups / SHGs
```

- Products should come from WooCommerce product origin mapping.
- The Cluster Single flow must remain data-driven and reusable for all clusters.
- SHG, Producer and Product sections should include optional section-level CTA buttons when only limited cards are shown.

---

## SHG Group Archive structure lock

SHG Group Archive must be built section-wise.

Recommended final order:

1. SHG Archive Hero
2. SHG Archive Trust / Context Strip
3. SHG Archive Intro
4. SHG Group Grid
5. SHG Archive Gallery / Story Visual Section where approved
6. SHG Archive CTA Band

The archive should be able to filter or group by cluster, region, product category or status in future phases, but that discovery/filter logic must stay aligned with Amaley Core and Amaley Discovery Engine boundaries.

---

## SHG Group Single structure lock

SHG Group Single must be built section-wise.

Recommended final order:

1. SHG Hero
2. Quick Details / SHG Snapshot
3. SHG Story
4. Linked Cluster
5. Members / Producers connected with this SHG
6. Products handled / mapped products
7. Gallery
8. Contact / CTA

Important:

- SHG data must come from Amaley Core SHG Group records.
- Linked Cluster must use the saved SHG → Cluster relation.
- Members / Producers must use the saved Member → SHG relation.
- Products should use product origin mapping where available.
- The SHG Single flow must not become a custom one-page-per-SHG design.
- Member / Producer and Product sections should include optional section-level CTA buttons when only limited cards are shown.

---

## Member / Producer Archive structure lock

Member / Producer Archive must be built section-wise.

Recommended final order:

1. Member Archive Hero
2. Member Archive Context / Trust Strip
3. Member Archive Intro
4. Member / Producer Grid
5. Member Archive Gallery / Story Visual Section where approved
6. Member Archive CTA Band

The archive should support future filtering by SHG, cluster, region, role, product handled and visibility status, while keeping discovery/filter responsibility properly separated.

---

## Member / Producer Single structure lock

Member / Producer Single must be built section-wise.

Recommended final order:

1. Member / Producer Hero
2. Quick Details / Producer Snapshot
3. Producer Story
4. Linked SHG Group
5. Linked Cluster
6. Products handled / mapped products
7. Skills / Role / Contribution
8. Gallery / Photo section
9. Contact / CTA

Important:

- Member / Producer data must come from Amaley Core Member records.
- Linked SHG must use the saved Member → SHG relation.
- Linked Cluster should resolve through the linked SHG wherever possible.
- Products handled may come from member profile fields and product origin mapping.
- The Member Single flow must not be manually rebuilt per person.
- Related SHG, Cluster and Product sections should include optional section-level CTA buttons when only limited cards are shown.

---

## Product origin / traceability section lock

Product-origin display sections must remain tied to WooCommerce products and Amaley Core origin mapping.

Expected product-origin flow:

1. Product Origin Panel
2. Linked Cluster
3. Linked SHG Groups
4. Linked Members / Producers
5. Source village / region
6. Traceability note
7. Origin story CTA

WooCommerce remains responsible for product, price, stock, variation, cart, checkout, order and review functions.

Amaley Core supports origin and traceability. It does not replace WooCommerce.

---

## Design and visual rhythm rule

All CPT pages must feel like one premium Amaley website, not unrelated blocks.

Keep:

- Same typography rhythm
- Same earthy premium palette
- Same card style family
- Same section heading style
- Same button style family
- Same responsive behaviour
- Same mobile-first spacing logic
- Same image handling logic for cards and galleries

Do not create random new visual systems for SHG and Member pages.

SHG and Member pages should inherit the Cluster Single structure and rhythm, adjusted only for their data type.

---

## Card family rule

Use the locked card designs from:

```text
docs/AMALEY_CARD_DESIGN_LOCK.md
```

Locked card families:

- Cluster card
- SHG / Producer Group card
- Member / Producer card
- Product card

Same card type must keep the same design everywhere it appears.

Do not redesign cards while moving from archive to single pages or from Core to Discovery contexts.

---

## Elementor rule

Elementor may be used to place and configure section widgets during the current migration/staging context.

The editing workflow should remain:

```text
One page template + multiple Amaley Core section widgets.
```

Do not create one separate Elementor page per Cluster, SHG or Member as the final scalable system.

---

## Plugin boundary rule

CPT-driven cards, sections, listings and single-page widgets belong in Amaley Core.

Discovery filters, search, sorting and pagination belong to Amaley Discovery Engine when discovery logic is required.

Generic manual/static card sections belong to Amaley Compact Widgets.

Header/footer belongs to Amaley Site Shell.

WooCommerce template support belongs to Amaley Templates.

---

## Future build sequence

After this lock, future work should move in this order:

1. Cluster Single spacing rhythm polish
2. Cluster Single section controls cleanup where needed
3. Product mapping completion
4. SHG Group Single section widgets
5. Member / Producer Single section widgets
6. SHG Archive section widgets
7. Member Archive section widgets
8. Product-origin traceability panel refinement
9. Discovery/filter integration where needed

Do not start SHG/Member single builds before the Cluster Single rhythm is stable.

---

## Non-negotiable rule

Separate sections are the final editing structure.

Spacing problems must be solved through shared rhythm controls and sane defaults, not by abandoning the section-wise architecture.

If a future build turns CPT pages into one hardcoded all-in-one block, it violates this lock.
