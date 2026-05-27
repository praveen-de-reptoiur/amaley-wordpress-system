# AMALEY UI SECTIONS KIT — INVENTORY AND PHASE PLAN

This document defines the section inventory and phase-wise build plan for the future **Amaley UI Sections Kit**.

This is a planning and approval document only.

No plugin ZIP should be created until this inventory, component boundaries, global design tokens, and phase plan are approved.

---

## 1. Module Purpose

Amaley UI Sections Kit will become the lightweight, WordPress-native, theme-like UI component system for the future clean Amaley website.

It will provide reusable Amaley-controlled sections such as:

- Buttons
- Section headings
- Product cards
- Product grids
- Story sections
- Trust strips
- CTA bands
- Origin blocks
- Cluster cards
- SHG / women collective cards
- Contact blocks
- Other content sections required for Amaley’s clean website experience

It must not become a data plugin, filter plugin, header/footer plugin, or WooCommerce replacement.

---

## 2. Permanent Rules

Amaley UI Sections Kit must follow these permanent rules:

- No Elementor default widget dependency
- No Elementor Heading widget dependency
- No Elementor Button widget dependency
- No Elementor Icon Box widget dependency
- No Elementor Image Box widget dependency
- No Elementor HTML widget dependency for important future UI sections
- No CPT creation
- No WooCommerce replacement
- No header/footer replacement
- No discovery/filter engine replacement
- No global CSS dumps
- No unnecessary frontend libraries
- No heavy animation libraries
- No duplicate CSS/JS
- Low-network-first
- Mobile-first
- Global design-token controlled
- Easy to disable
- Easy to rollback

---

## 3. Plugin Boundary

### Amaley Core Handles

- Clusters
- SHG Groups
- SHG Members / Producers
- Product origin mapping
- Product metadata
- Data structures
- Traceability data
- Usage/storage instruction data

### Amaley Discovery Engine Handles

- Product search
- Product filters
- Category filters
- Origin filters
- Cluster filters
- SHG filters
- Producer filters
- Sorting
- Pagination
- Mobile filter drawer
- Discovery listings

### Amaley Site Shell Handles

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation shell
- Announcement strip
- Footer controls

### Amaley Templates Handles

- Existing/transitional product template sections
- Existing/transitional shop template sections
- WooCommerce template-level display areas where needed during migration

### Amaley UI Sections Kit Handles

- Lightweight reusable visual sections
- Brand/story sections
- Product display components
- Trust/quality sections
- Origin display sections
- CTA sections
- Static and dynamic UI blocks
- Global design-token controlled frontend components

---

## 4. Global Design Token Requirement

The UI Sections Kit must inherit from the Amaley global design system.

Core tokens to support:

```text
Colors
Typography
Font sizes
Spacing
Radius
Borders
Shadows
Buttons
Cards
Product cards
Trust strips
Mobile spacing
Section spacing
```

Required current design tokens:

```text
--amaley-deep-chocolate: #2E1203;
--amaley-warm-chocolate: #4A2208;
--amaley-ivory-base: #FFF8ED;
--amaley-warm-cream: #F6EFE3;
--amaley-soft-sand: #EFE3D0;
--amaley-muted-gold: #C2880A;
--amaley-rust-accent: #B85C38;
--amaley-leaf-green: #6F7A3A;
--amaley-text-brown: #4A2208;
--amaley-muted-text: #7A6250;
--amaley-border-warm: #E5D7C2;
```

When the final Amaley brand PDF is provided, this token list may be upgraded, but all components should continue to use token-based styling.

---

## 5. Section Inventory Overview

The section inventory is grouped into build categories:

```text
A. Foundation Components
B. Product and Shop Components
C. Brand and Story Components
D. Origin and Traceability Components
E. Community / SHG Components
F. Trust and Conversion Components
G. Utility / Layout Components
```

---

# A. Foundation Components

## A1. Section Heading

Purpose:

Reusable heading block for all sections.

Content controls:

- Small label
- Main heading
- Accent word option
- Short description
- Alignment: left / center
- Optional eyebrow label

Design rules:

- Use Playfair-style premium heading direction
- Use gold small label
- Use deep chocolate heading
- Mobile heading must not be oversized
- No Elementor Heading widget dependency

Priority:

```text
Phase 1
```

---

## A2. Button

Purpose:

Reusable Amaley button system.

Variants:

- Primary
- Secondary
- Text link
- Outline
- Small pill

Controls:

- Button text
- URL
- Open in same/new tab
- Alignment
- Icon optional but not required

Design rules:

- Rust primary CTA
- Chocolate hover
- Rounded pill style
- Minimum 44px touch target
- No Elementor Button widget dependency

Priority:

```text
Phase 1
```

---

## A3. Button Group

Purpose:

Two-button or multi-button CTA row.

Controls:

- Primary button
- Secondary button
- Alignment
- Stack on mobile
- Gap control through tokens

Priority:

```text
Phase 1
```

---

## A4. Icon / Trust Mini Item

Purpose:

Small icon + title + text item for trust, quality, natural, small-batch, origin, women collective cues.

Controls:

- Icon choice from built-in lightweight SVG set
- Title
- Description
- Optional link

Rules:

- Use inline SVG only
- No heavy icon library
- No Elementor Icon Box dependency

Priority:

```text
Phase 1
```

---

# B. Product and Shop Components

## B1. Amaley Product Card

Purpose:

Reusable product card for product grids and curated sections.

Data source:

```text
WooCommerce product data
```

Should display:

- Product image
- Product title
- Price
- Sale price if available
- Add to cart / View product action
- Optional origin cue
- Optional product tag/badge
- Optional short description

Controls:

- Image ratio
- Show/hide price
- Show/hide add to cart
- Show/hide origin cue
- Show/hide badge
- Card density: compact / editorial

Rules:

- Must use WooCommerce product data
- Must not replace WooCommerce
- Must not create product data
- Must be fast and low-network-ready
- Images must be optimized/lazy-loaded
- Layout must be stable across cards

Priority:

```text
Phase 1
```

---

## B2. Curated Product Grid

Purpose:

Display selected products or product category in a clean Amaley grid.

Data source:

```text
WooCommerce products
```

Controls:

- Manual product IDs/SKUs
- Category slug
- Number of products
- Columns desktop/tablet/mobile
- Show/hide section heading
- Show/hide CTA
- Show/hide filters: no, filters are Discovery Engine responsibility

Rules:

- Product grid display only
- No filter engine
- No search engine
- No unlimited query
- Query limit required
- Use Product Card component

Priority:

```text
Phase 1
```

---

## B3. Featured Product Strip

Purpose:

Highlight 1 to 3 featured products.

Data source:

```text
WooCommerce products
```

Controls:

- Product IDs/SKUs
- Layout: single / two / three
- CTA text
- Show origin cue
- Show short description

Priority:

```text
Phase 2
```

---

## B4. Collection Cards

Purpose:

Show product categories/collections such as apricot, seabuckthorn, honey, bakery, grains, wellness.

Data source:

```text
WooCommerce product categories or manual cards
```

Controls:

- Image
- Label
- Title
- Description
- Link
- Card count
- Grid columns

Priority:

```text
Phase 1
```

---

# C. Brand and Story Components

## C1. Editorial Text + Image Section

Purpose:

Premium two-column storytelling block.

Use for:

- Brand story
- Ingredient story
- Women collective story
- Himalayan sourcing explanation
- Product category intro

Controls:

- Small label
- Heading
- Paragraph
- Image
- Image side: left/right
- Feature cards optional
- CTA optional

Priority:

```text
Phase 1
```

---

## C2. Brand Promise Strip

Purpose:

Short trust strip under hero or product sections.

Items:

- Natural Himalayan ingredients
- Small-batch production
- Quality checked by Amaley
- Community-rooted sourcing
- Women collectives / producer families

Controls:

- 3 to 5 items
- Icon optional
- Compact/mobile style

Priority:

```text
Phase 1
```

---

## C3. Story Cards Grid

Purpose:

Show multiple short stories.

Use for:

- Ingredients
- Regions
- Producer families
- Women collectives
- Seasonal sourcing
- Responsible production

Controls:

- Card title
- Text
- Image/icon
- Link optional
- Grid count

Priority:

```text
Phase 2
```

---

# D. Origin and Traceability Components

## D1. Product Origin Summary Block

Purpose:

Show origin/traceability details on product or product-related sections.

Data source:

```text
Amaley Core origin/product mapping where available
Manual fallback where approved
```

Can display:

- Source village
- Region
- Cluster
- SHG Group
- Producer / maker
- Ingredient origin
- Quality check note

Rules:

- Do not fake data
- If origin data is missing, hide block or show safe empty state
- Must not create or edit origin data
- Must only display existing verified data

Priority:

```text
Phase 2
```

---

## D2. Origin Story Band

Purpose:

Editorial band explaining product/ingredient origin.

Controls:

- Small label
- Heading
- Short paragraph
- Origin cards
- CTA to origin/story page if available

Priority:

```text
Phase 2
```

---

## D3. Traceability Mini Cards

Purpose:

Small cards for:

- Village
- Ingredient
- Producer group
- Quality check
- Small-batch process

Priority:

```text
Phase 2
```

---

# E. Community / SHG Components

## E1. Women Collective Highlight Card

Purpose:

Highlight SHG group or women collective respectfully.

Data source:

```text
Amaley Core SHG / producer data where available
Manual content only if approved and verified
```

Controls:

- Group name
- Village/region
- Short description
- Image
- Related product link
- CTA optional

Rules:

- Avoid charity language
- Avoid overclaiming
- Avoid “women-led” unless specifically requested
- Use “women collectives”, “producer families”, “community-rooted”

Priority:

```text
Phase 2
```

---

## E2. Producer Family / Maker Card

Purpose:

Show maker/producer profile in a premium, dignified way.

Controls:

- Name/group
- Region
- Short story
- Product link
- Image
- Badge optional

Priority:

```text
Phase 3
```

---

## E3. Cluster Card

Purpose:

Show source cluster/region card.

Data source:

```text
Amaley Core cluster data where available
```

Controls:

- Cluster name
- Region
- Product category
- Description
- CTA

Priority:

```text
Phase 3
```

---

# F. Trust and Conversion Components

## F1. Quality Trust Strip

Purpose:

Build confidence before purchase.

Items can include:

- Quality checked by Amaley
- Small-batch production
- Natural ingredients
- Conscious sourcing
- Community-rooted sourcing

Priority:

```text
Phase 1
```

---

## F2. CTA Band

Purpose:

Premium call-to-action section.

Use for:

- Shop now
- Explore collections
- Know our origin
- Contact Amaley
- Bulk enquiry
- Become a retail/partner outlet

Controls:

- Label
- Heading
- Short text
- Primary CTA
- Secondary CTA
- Background style

Priority:

```text
Phase 1
```

---

## F3. Contact / Enquiry Block

Purpose:

Simple contact section for Amaley.

Can include:

- Brand name
- Gram Connect / Amaley details
- Phone
- Email
- WhatsApp CTA
- Partnership/bulk enquiry CTA

Priority:

```text
Phase 2
```

---

# G. Utility / Layout Components

## G1. Section Container

Purpose:

Global wrapper for consistent spacing and max-width.

Controls:

- Max width
- Background token
- Padding token
- Mobile padding
- Alignment

Priority:

```text
Phase 1
```

---

## G2. Responsive Grid Helper

Purpose:

Reusable responsive grid for cards.

Rules:

- CSS Grid
- No JS dependency
- Token-based gap
- Mobile-first

Priority:

```text
Phase 1
```

---

## G3. Safe Empty State

Purpose:

Reusable empty-state block.

Use for:

- No products selected
- No origin data
- No SHG data
- No collection available

Tone:

```text
This information will appear once verified Amaley data is available.
```

Rules:

- Do not show fake data
- Do not break layout

Priority:

```text
Phase 1
```

---

## 6. Phase-Wise Build Plan

## Phase 0 — Approval and Token Setup

Status:

```text
Required before build
```

Tasks:

- Approve this inventory document
- Confirm global design tokens
- Confirm brand PDF/design system updates
- Confirm component names
- Confirm folder/file structure
- Confirm no Elementor default widget dependency
- Confirm no CPT/data responsibility
- Confirm no WooCommerce replacement
- Confirm no header/footer responsibility
- Confirm no discovery/filter responsibility

No plugin ZIP in this phase.

---

## Phase 1 — Foundation + Product Display

Goal:

Build the minimum reusable UI kit foundation.

Components:

- Section Container
- Responsive Grid Helper
- Safe Empty State
- Section Heading
- Button
- Button Group
- Icon / Trust Mini Item
- Amaley Product Card
- Curated Product Grid
- Collection Cards
- Editorial Text + Image Section
- Brand Promise Strip
- Quality Trust Strip
- CTA Band

Deliverables:

- Plugin skeleton
- Scoped CSS
- Token file
- Component render functions/classes
- Shortcode or block/render approach decided before build
- Basic admin settings only if required
- No Elementor default widgets

Testing:

- Mobile 360/390/430
- Tablet 768
- Desktop 1024/1366
- Product grid query limit
- WooCommerce add-to-cart
- No frontend CSS/JS bloat
- No layout shift in product cards

---

## Phase 2 — Origin + Community Sections

Goal:

Add verified story, origin, and community display sections.

Components:

- Product Origin Summary Block
- Origin Story Band
- Traceability Mini Cards
- Women Collective Highlight Card
- Contact / Enquiry Block
- Featured Product Strip
- Story Cards Grid

Dependencies:

- Existing WooCommerce product data
- Amaley Core origin data where available
- Verified manual content only if approved

Testing:

- Missing origin data
- Missing SHG data
- Safe empty states
- No fake data
- No broken product page
- No slow frontend queries

---

## Phase 3 — Advanced Community and Cluster Display

Goal:

Add deeper community and traceability display.

Components:

- Producer Family / Maker Card
- Cluster Card
- Product-origin linked sections
- Related origin/product display where data exists

Dependencies:

- Amaley Core stable data structures
- Verified Cluster / SHG / Producer mapping

Testing:

- Data fallback
- Product relation display
- No duplicate data creation
- No CPT responsibility inside UI Kit

---

## Phase 4 — Polish and Template Integration

Goal:

Integrate UI Sections Kit into the cleaner site build.

Tasks:

- Use kit sections on homepage
- Use kit sections on shop landing areas
- Use kit sections on product storytelling areas
- Connect with Discovery Engine where display-only handoff is needed
- Keep data/query boundaries clear
- Remove unnecessary old Elementor layout sections only after replacement is approved

Testing:

- Homepage
- Shop page
- Product page
- Origin display
- Mobile layout
- Low-network performance
- WooCommerce flow

---

## 7. Not Included in UI Sections Kit

The following must not be built inside UI Sections Kit:

- CPT creation
- ACF replacement
- Product origin database management
- SHG/Cluster/Producer admin management
- Search engine
- Filter engine
- Sorting engine
- Pagination engine
- Header replacement
- Footer replacement
- Mobile drawer/navigation shell
- Cart replacement
- Checkout replacement
- Payment flow
- Debug dashboard
- Project health dashboard
- Backup/export system

---

## 8. Proposed Plugin Structure

Proposed source structure only after approval:

```text
plugins/
  amaley-ui-sections-kit/
    README.md
    AMALEY_UI_SECTIONS_KIT_INVENTORY_AND_PHASE_PLAN.md
    amaley-ui-sections-kit.php
    includes/
      class-amaley-ui-sections-kit.php
      class-amaley-ui-token-registry.php
      renderers/
        class-amaley-ui-section-heading.php
        class-amaley-ui-button.php
        class-amaley-ui-product-card.php
        class-amaley-ui-product-grid.php
        class-amaley-ui-story-section.php
        class-amaley-ui-trust-strip.php
        class-amaley-ui-origin-block.php
        class-amaley-ui-cta-band.php
    assets/
      css/
        amaley-ui-sections-kit.css
      js/
        amaley-ui-sections-kit.js
    docs/
      CHANGELOG.md
      TESTING_NOTES.md
```

This structure is not final until approved.

---

## 9. Build Approval Checklist

Before plugin build starts, confirm:

- Inventory approved
- Phase 1 scope approved
- Global tokens approved
- File structure approved
- Naming approved
- WooCommerce data boundaries approved
- Amaley Core boundaries approved
- Discovery Engine boundaries approved
- Site Shell boundaries approved
- No Elementor default widget dependency approved
- Low-network/performance requirement approved
- Rollback plan approved

If approval is incomplete, do not build.

---

## 10. Commit Message

Suggested commit message for adding this document:

```text
Add UI Sections Kit inventory and phase plan
```

---

## 11. Hard Rule

If the UI Sections Kit becomes heavy, confusing, dependent on Elementor default widgets, or starts replacing Core/Discovery/Site Shell/WooCommerce responsibilities, it is going in the wrong direction.

Build only after approval.

No ZIP before approval.
