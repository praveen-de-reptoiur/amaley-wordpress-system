# AMALEY UNIVERSAL SHOWCASE WIDGET LOCK

This document locks the approved architecture for the Amaley Universal Showcase Widget.

Date: 2026-06-06
Status: Approved for Amaley Core implementation

---

## 1. Final Widget Name

```text
Amaley Universal Showcase
```

Elementor category:

```text
Amaley Core
```

Target source module:

```text
plugins/amaley-core/
```

---

## 2. Purpose

The Amaley Universal Showcase Widget is a reusable Elementor section for showing Amaley ecosystem content anywhere on the website.

It may be used on:

- Home page
- About page
- Collection pages
- Cluster pages
- SHG / Producer Group pages
- Member / Producer pages
- Product story pages
- Landing pages
- Any custom Elementor page where Amaley content needs to be displayed

The widget is not only a slider. It is a universal display system with layout choices.

Supported display modes:

- Grid
- Slider
- Card row
- List
- Phone-first horizontal showcase

---

## 3. Source Ownership Decision

The widget belongs in Amaley Core.

Reason:

Amaley Core owns the Amaley data backbone, including:

- Clusters
- SHG / Producer Groups
- Members / Producers
- Product Origin Mapping
- Core OG card renderer
- CPT-driven archive and single widgets
- Universal card families
- Origin-led section logic

The widget must not be built inside Amaley Discovery Engine.

Discovery Engine remains responsible for:

- Shop / collection filters
- Search
- Sort
- Filtered listings
- Filtered pagination
- Mobile filter drawer

---

## 4. Most Important Editor Rule

```text
Selected content/card type ke controls hi Elementor editor me visible honge.
```

Meaning:

| Selected Content Type | Visible Editor Controls |
| --- | --- |
| Cluster | Cluster card controls only |
| SHG / Producer Group | SHG card controls only |
| Member / Producer | Member card controls only |
| Product | Product card controls only |

The editor panel must not show mixed Cluster + SHG + Member + Product card controls together.

This is a locked rule.

---

## 5. Conditional Control Rule

Every card family must have its own isolated Elementor control group.

Required logic:

```text
content_type = cluster -> show Cluster Card Controls only
content_type = shg     -> show SHG Card Controls only
content_type = member  -> show Member Card Controls only
content_type = product -> show Product Card Controls only
```

Saved hidden controls must not affect the frontend render of a different selected content type.

---

## 6. Common Widget Controls

Always visible controls:

- Show / hide whole section
- Content type selector
- Source mode selector
- Manual IDs
- Limit
- Order by
- Order
- Section label
- Section heading
- Section description
- Section CTA button
- Desktop layout mode
- Tablet layout mode
- Phone layout mode
- Grid columns
- Gap
- Empty state message
- Section spacing
- Section background
- Heading typography
- Responsive layout controls

---

## 7. Content Type Options

Supported content types:

```text
cluster
shg
member
product
```

Labels:

- Cluster
- SHG / Producer Group
- Member / Producer
- Product

---

## 8. Source Modes

Initial safe source modes:

- Latest
- Manual IDs
- Featured only
- By linked cluster
- By linked SHG / Producer Group
- By linked member / producer
- By product category

The first implementation may start with latest + manual IDs + basic featured support, then extend relation filters safely.

---

## 9. Card Renderer Rule

The widget must reuse the existing Amaley Core card renderer.

Required mapping:

```text
Cluster -> Amaley_Core_Card_Renderer::render_cluster()
SHG     -> Amaley_Core_Card_Renderer::render_shg()
Member  -> Amaley_Core_Card_Renderer::render_member()
Product -> Amaley_Core_Card_Renderer::render_product()
```

No duplicate card HTML should be created unless a future version deliberately extends the central renderer.

---

## 10. Card Controls

Each card family must expose its matching controls only.

Common card control concepts:

- Show image
- Show label
- Show title
- Show description / excerpt
- Show meta/stat boxes
- Show tags/chips
- Show button
- Label text override
- Button text
- Description word limit
- Card background
- Card radius
- Image height
- Body padding
- Title typography
- Description typography
- Meta/chip/button styling
- Hover transform controls

---

## 11. Phone-First Slider / Pagination Rule

Phone display is a priority for this widget.

Phone controls should include:

- Phone layout mode
- Cards per view on phone
- Phone gap
- Swipe on/off
- Arrows on/off
- Dots on/off
- Numbers on/off
- Arrow + numbers mode
- Current / total slide counter
- Below-cards navigation
- Top-right navigation where required

Phone pagination must be frontend-safe and must not reload into old/default cards.

---

## 12. Safety Boundaries

The widget must not touch:

- Discovery Engine filters
- Discovery Engine query logic
- WooCommerce product data
- Product photos/gallery
- Product origin mappings
- Cart
- Checkout
- Orders
- Header
- Footer
- Theme templates
- Permalinks

---

## 13. CSS / JS Rules

- No global CSS
- No global JS
- Scoped wrapper only
- Lightweight assets
- No external slider library unless approved later
- Vanilla JS preferred
- Multiple widget instances on one page must work independently
- Elementor editor and frontend must both work

Primary wrapper:

```text
.amaley-universal-showcase
```

---

## 14. Version Direction

Recommended first implementation version:

```text
Amaley Core v1.1.0 — Universal Showcase Base
```

The first phase should be additive and safe.

It should not refactor existing archive/single widgets until a separate cleanup baseline is created.

---

## 15. QA Lock

Before treating the widget as production-ready, test:

- Cluster + Grid
- Cluster + Phone Slider
- SHG + Grid
- SHG + Phone Slider
- Member + Grid
- Member + Phone Slider
- Product + Grid
- Product + Phone Slider
- Manual IDs
- Latest mode
- Empty state
- Two showcase widgets on the same page
- Elementor editor preview
- Published frontend
- Desktop / tablet / phone

---

## 16. Final Locked Line

```text
Universal Showcase Widget Core me banega. Jo card selected hoga, sirf usi card ke controls editor me dikhenge. Discovery filters untouched rahenge.
```
