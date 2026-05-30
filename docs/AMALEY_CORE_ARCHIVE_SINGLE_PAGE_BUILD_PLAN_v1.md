# AMALEY CORE — ARCHIVE & SINGLE PAGE BUILD PLAN
Version: v1.0
Date: 2026-05-30
Project: Amaley WordPress System
Prepared for: Amaley Collective / Firgun Foundation

---

## 1. Purpose

This plan defines the next phase of Amaley Core development after completion of:

- Cluster Cards Grid
- SHG Group Cards Grid
- Member / Producer Cards Grid
- Product Origin Panel
- Product Origin Import by Product Name
- GitHub source verification
- Master handoff update

The next phase will create user-friendly, detailed archive and single-page experiences for Amaley’s origin ecosystem:

1. Source Clusters
2. SHG Groups / Women Collectives
3. Members / Producers
4. Product Origin and Traceability

These pages must not look like raw database pages. They should feel like premium brand pages that help a customer understand where Amaley products come from, who makes them, how they are connected to community-rooted production, and which products they can explore.

---

## 2. Permanent Architecture Rule

The work must remain modular and conflict-safe.

### Amaley Core handles

- Cluster CPT
- SHG Group CPT
- Member / Producer CPT
- Product origin mapping
- Origin display widgets
- Archive/detail data widgets
- Traceability display widgets

### Amaley Templates handles

- WooCommerce product templates
- Shop page templates
- Single product template layouts
- Future page templates

### Amaley Discovery Engine handles

- Search
- Filters
- Sorting
- Pagination
- Discovery listing logic

### Amaley Compact Widgets handles

- Static visual sections
- Manual editorial cards
- Non-CPT display blocks

### Do not mix responsibilities

Amaley Core should not become a theme, header/footer plugin, WooCommerce replacement, or discovery/filter engine.

---

## 3. UX Goal

Each page should clearly answer:

- What is this origin / cluster / group / producer?
- Where is it located?
- What products are connected to it?
- Which women collective / producer family is involved?
- What makes it trustworthy?
- What should the user do next?

The experience should guide the user from story to trust to product action.

---

## 4. Language and Brand Tone

Use premium, dignified, non-charity language.

Preferred language:

- women collectives
- producer families
- community-rooted
- Himalayan
- natural
- pure
- small-batch
- traditional knowledge
- quality checked
- carefully prepared
- source cluster
- origin story

Avoid unless specifically required:

- charity language
- beneficiary-heavy language
- pity-based language
- overclaiming
- “women-led” as default phrase

---

## 5. Page System Overview

The complete page system will include:

1. Cluster Archive Page
2. Cluster Single Page
3. SHG Group Archive Page
4. SHG Group Single Page
5. Producer / Member Archive Page
6. Producer / Member Single Page
7. Product Origin Chain / Traceability Flow

---

## 6. Cluster Archive Page

### Purpose

To show all Amaley source clusters in a premium, browse-friendly format.

### Suggested URL

/am‌aley-clusters/
/clusters/

Final slug to be decided before implementation.

### Sections

#### 1. Archive Hero

Content:

- Small label: Amaley Origins
- Heading: Discover Amaley’s Himalayan Source Clusters
- Short description about source clusters, women collectives, producer families and products.

#### 2. Quick Stats

Possible stats:

- Total clusters
- Total SHG groups
- Total producers / members
- Product categories represented

#### 3. Browse / Filter Strip

Display controls:

- Region
- District
- Product category
- Featured only
- Show on website only

Note: Deep filtering can later move to Discovery Engine. Basic archive controls can be included for now.

#### 4. Cluster Cards Grid

Each card should include:

- Image / fallback visual
- Cluster name
- Region / district
- Villages
- Main product categories
- SHG count
- Producer count
- CTA: View Cluster

#### 5. Bottom CTA

Possible CTA:

- Explore products from these clusters
- Know the people behind Amaley

---

## 7. Cluster Single Page

### Purpose

To present one source cluster as a complete story page.

### Suggested URL

/amaley-cluster/{cluster-slug}/

### Sections

#### 1. Cluster Hero

Display:

- Cluster title
- Region
- District / block
- Short intro
- Main product badges
- Hero image / gallery image fallback

#### 2. Trust Snapshot

Display:

- Villages connected
- SHG groups connected
- Producer families connected
- Products linked

#### 3. Cluster Story

Display:

- Full story
- Why the region matters
- Product relevance
- Community-rooted value

#### 4. Village and Product Map Block

Display:

- Villages covered
- Main ingredients / products
- Region orientation

This may later connect with Origin Map / Trail style visual block.

#### 5. Linked SHG Groups

Display SHG cards linked to the cluster.

#### 6. Linked Producers / Members

Display producer/member cards linked through SHG and direct cluster relations.

#### 7. Products from this Cluster

Display WooCommerce products mapped to this cluster through product origin data.

#### 8. Origin Journey

Visual flow:

Village → Cluster → SHG Group → Producer → Amaley Quality Check → Product

#### 9. Gallery

Show cluster gallery images if available.

#### 10. CTA

Possible CTA:

- Shop products from this cluster
- Explore linked women collectives

---

## 8. SHG Group Archive Page

### Purpose

To show all SHG Groups / women collectives connected with Amaley.

### Suggested URL

/amaley-shg-groups/
/women-collectives/

### Sections

#### 1. Archive Hero

Heading idea:

Women Collectives Behind Amaley Products

#### 2. Intro

Explain community-rooted production, collective work, and small-batch preparation.

#### 3. Browse / Filter Strip

Filters:

- Cluster
- District
- Village
- Product category
- Featured
- Verification status

#### 4. SHG Cards Grid

Each card should include:

- SHG name
- Village
- Cluster
- Member count
- Product categories
- Verification status
- Short story
- CTA: View Group

#### 5. CTA

Explore products made through Amaley’s producer network.

---

## 9. SHG Group Single Page

### Purpose

To present one SHG / women collective respectfully and clearly.

### Suggested URL

/amaley-shg-group/{shg-slug}/

### Sections

#### 1. SHG Hero

Display:

- SHG name
- Village
- District
- Linked cluster
- Short story
- Image / gallery image fallback

#### 2. Group Snapshot

Display:

- Member count
- Product categories
- Verification status
- Cluster connection
- Village / district

#### 3. Group Story

Display:

- Full story
- Role in Amaley production
- Traditional knowledge / skills
- Product categories handled

#### 4. Members / Producers

Display linked members/producers from this SHG.

#### 5. Products Linked

Display products connected to this SHG through origin mapping.

#### 6. Cluster Connection

Block showing:

Part of: {Cluster Name}

CTA to view cluster page.

#### 7. Gallery

Show production / group / ingredient images where available.

#### 8. CTA

Explore products from this group.

---

## 10. Producer / Member Archive Page

### Purpose

To show producers / makers in a respectful and privacy-safe way.

### Suggested URL

/amaley-producers/
/makers/

### Sections

#### 1. Archive Hero

Heading idea:

Meet the Producer Families and Makers

#### 2. Intro

Explain skills, careful preparation, traditional knowledge, and Amaley quality support.

#### 3. Browse / Filter Strip

Filters:

- Cluster
- SHG Group
- Village
- Skill
- Product handled
- Featured

#### 4. Producer Cards Grid

Each card should include:

- Photo / fallback
- Name
- Village
- SHG Group
- Role
- Skills
- Products handled
- CTA: View Profile

### Privacy Rule

Phone number should not be shown publicly by default.

---

## 11. Producer / Member Single Page

### Purpose

To present one producer/member profile as a dignified story page.

### Suggested URL

/amaley-producer/{producer-slug}/

### Sections

#### 1. Producer Hero

Display:

- Photo
- Name
- Village
- Role
- SHG Group
- Cluster

#### 2. Short Bio

A clean profile summary.

#### 3. Producer Story

Display full story if available.

#### 4. Skills

Examples:

- Sorting
- Processing
- Packing
- Traditional recipe knowledge
- Quality support
- Ingredient handling

#### 5. Products Handled

Display WooCommerce products linked to the producer through origin mapping.

#### 6. SHG / Cluster Connection

Show:

- Belongs to SHG
- Part of Cluster

#### 7. CTA

Explore products connected to this producer.

---

## 12. Origin Chain / Traceability Flow

### Purpose

To visually explain product origin.

### Use cases

- Product pages
- Cluster single pages
- SHG single pages
- Producer single pages

### Flow

Village → Cluster → SHG Group → Producer → Amaley Quality Check → Product

### Example shortcode

[amaley_origin_chain product_name="Amaley Ladakh Apricot Jam"]

### Data source

Use Amaley Core product origin mapping.

### Safe behavior

If data is incomplete, show only verified available steps. Do not fake missing parts.

---

## 13. Data Quality Requirements

Before final frontend deployment, data should be improved for:

### Cluster data

- Featured image
- Gallery images
- Short intro
- Full story
- Region / district
- Villages
- Product categories

### SHG Group data

- Featured image
- Gallery images
- Short story
- Full story
- Product categories
- Verification status
- Member count

### Producer data

- Photo
- Short bio
- Full story
- Skills
- Products handled
- Village
- SHG link

### Product origin data

- Cluster
- SHG Group
- Producer / member
- Source village
- Origin note
- Traceability note
- Show origin setting

---

## 14. Widget Build Roadmap

### Amaley Core v1.0.16

Focus:

Cluster Archive + Cluster Single widgets

Planned widgets / shortcodes:

- Amaley Cluster Archive Header
- Amaley Cluster Archive Grid
- Amaley Cluster Single Hero
- Amaley Cluster Story Block
- Amaley Cluster Linked SHGs
- Amaley Cluster Linked Producers
- Amaley Cluster Linked Products
- Amaley Cluster Origin Journey

Possible shortcodes:

[amaley_cluster_archive]
[amaley_cluster_detail]
[amaley_cluster_related_shgs]
[amaley_cluster_related_members]
[amaley_cluster_related_products]

### Amaley Core v1.0.17

Focus:

SHG Archive + SHG Single widgets

Planned widgets / shortcodes:

- Amaley SHG Archive Header
- Amaley SHG Archive Grid
- Amaley SHG Single Hero
- Amaley SHG Story Block
- Amaley SHG Members Grid
- Amaley SHG Linked Products
- Amaley SHG Cluster Connection

### Amaley Core v1.0.18

Focus:

Producer / Member Archive + Single widgets

Planned widgets / shortcodes:

- Amaley Producer Archive Header
- Amaley Producer Archive Grid
- Amaley Producer Single Hero
- Amaley Producer Story Block
- Amaley Producer Skills Block
- Amaley Producer Linked Products
- Amaley Producer SHG / Cluster Connection

### Amaley Core v1.0.19

Focus:

Origin Chain / Traceability Flow widget

Planned widgets / shortcodes:

- Amaley Origin Chain
- Amaley Product Journey
- Amaley Quality Check Flow

---

## 15. Elementor-First Build Principle

Every visual output should be Elementor-friendly.

Each widget should expose controls for:

### Content Controls

- Source selection
- Include/exclude IDs
- Limit
- Order/orderby
- Featured only
- Show on website only
- Manual post selection where needed
- Empty state toggle

### Layout Controls

- Columns desktop/tablet/mobile
- Card layout style
- Image ratio
- Equal height
- Section max width
- Alignment

### Style Controls

- Typography
- Colors
- Background
- Border
- Radius
- Shadow
- Padding
- Margin
- Gap
- Button styling
- Badge styling
- Card styling
- Responsive values

---

## 16. Safe Empty State Rules

If data is missing, widgets must not show fake content.

Recommended empty-state message:

This information will appear once verified Amaley data is available.

Where possible, hide incomplete sections instead of showing weak content.

---

## 17. Technical Safety Rules

- No theme override unless explicitly approved
- No WooCommerce template replacement in Amaley Core
- No header/footer changes
- No global CSS pollution
- No duplicate class/function names
- No hard dependency on Elementor for shortcode rendering
- Widgets should work via shortcode and Elementor
- Query limits required
- Mobile-first layout
- Privacy-safe producer display
- No phone numbers publicly unless explicitly enabled
- No ZIP/media/backups in GitHub
- GitHub source only

---

## 18. Testing Checklist

Each release should be tested on:

- Mobile 360px
- Mobile 390px
- Mobile 430px
- Tablet 768px
- Desktop 1024px
- Desktop 1366px

Functional testing:

- Empty data
- Partial data
- Full data
- Missing images
- Missing linked SHG
- Missing linked producer
- Product origin available
- Product origin missing
- Elementor editor
- Elementor preview
- Published frontend
- Shortcode rendering

---

## 19. Workflow Rule

Follow the safe Amaley workflow:

1. Build installable test plugin ZIP
2. User tests in WordPress
3. If approved, source update pack is provided
4. User manually updates GitHub source
5. Assistant verifies GitHub read-only
6. Master handoff ZIP is updated
7. Next version begins

Assistant must not push to GitHub unless explicitly asked.

---

## 20. Immediate Next Step

Build:

Amaley Core v1.0.16 — Cluster Archive + Cluster Single Widgets

This will become the base pattern for SHG and Producer pages.
