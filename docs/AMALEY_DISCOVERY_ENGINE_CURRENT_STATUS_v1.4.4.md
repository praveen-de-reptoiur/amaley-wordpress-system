# Amaley Discovery Engine — Current Status v1.4.4

Date: 2026-06-06

Status: **Accepted stable source baseline**

Source path:

```text
plugins/amaley-discovery-engine/
```

Current version:

```text
v1.4.4 — Full OG Product Card Controls Tested
```

---

## Accepted Purpose

Amaley Discovery Engine owns discovery/listing behaviour:

- Product grids where discovery/filter logic is required
- Search
- Sorting
- Pagination
- Filter sidebar/topbar/mobile drawer
- Product Discovery / Collection-style product browsing
- Future Cluster / SHG / Member discovery filters

It does **not** own:

- Product data creation
- Product image/gallery uploads
- Product-origin mapping edits
- WooCommerce cart/checkout templates
- Header/footer rendering
- Static homepage hero/page sections

---

## Accepted Product Card Renderer Flow

The stable accepted renderer flow is:

```text
Product Discovery widget
→ Product Card Renderer
→ Amaley Core Product Card — Select Template
→ OG Product Card 1
```

This is source-level support inside Discovery Engine. Do not use frontend replacement/stabilizer patch plugins for this path.

---

## Accepted Behaviour After User Testing

The user confirmed:

- OG Product Card 1 appears in Product Discovery.
- Pagination returns OG product cards.
- Filter apply returns OG product cards.
- Reset returns OG product cards.
- Sort returns OG product cards.
- The card renderer remains selectable instead of hardcoded.
- Full selected OG product-card controls are accepted.

---

## Pending Origin Filters — Not Implemented Yet

The following filters are **pending only**. They are **not implemented in v1.4.4** and must not be treated as completed work:

```text
PENDING — Cluster filter
PENDING — SHG / Collective filter
PENDING — Producer / Member filter
```

Implementation rule for later:

```text
1. Add Cluster filter first.
2. Test page 1, page 2, sort, filter apply, reset.
3. Add SHG / Collective filter only after Cluster filter is stable.
4. Test page 1, page 2, sort, filter apply, reset.
5. Add Producer / Member filter only after SHG / Collective filter is stable.
6. Test page 1, page 2, sort, filter apply, reset.
```

Do not combine all three filters in one update.

---

## Approved Elementor Control Structure

### Content tab

```text
Product Card Renderer
Selected OG Product Card — Content
```

Content controls belong here:

- Card renderer selection
- OG Product Card template selection
- Show/hide selected card elements
- Button text
- Label text override
- Description/excerpt limit where available

### Style tab

```text
Section / Heading
Filters / Toolbar
Grid / Spacing
Selected OG Product Card — Layout
Selected OG Product Card — Text
Selected OG Product Card — Meta & Tags
Selected OG Product Card — Button
Pagination
```

This structure is the reference for future Discovery widgets. Do not return to mixed old/native card controls.

---

## Safety Scope of v1.4.4

v1.4.4 must be treated as a safe source-level card integration and controls version.

Confirmed safety scope:

```text
No product data change.
No product images/gallery change.
No product-origin mapping change.
No WooCommerce cart/checkout/template override.
No header/footer change.
No broad global CSS.
No frontend replacement/stabilizer patch layer.
```

---

## Previous Working Base

```text
v1.3.6 — Core card source fix
```

v1.3.6 established the correct source-level renderer direction after frontend bridge/patch attempts failed.

---

## Rejected / Archived Versions

Do not use or revive these builds as the future baseline:

```text
v1.3.7 — broken Style tab restoration path
v1.3.8 — section-close recovery but incomplete control behaviour
v1.3.9 — broad CSS/control attempt that damaged cards
v1.4.0 — safe-control attempt but incomplete micro-control planning
v1.4.1 — hover-control attempt with confusing structure
v1.4.2 — fatal activation risk / rejected
v1.4.3 — rollback package only, not final accepted version
```

---

## Next Safe Work

Next Discovery work must be source-level and one-by-one.

Current status:

```text
NOT IMPLEMENTED — Cluster filter
NOT IMPLEMENTED — SHG / Collective filter
NOT IMPLEMENTED — Producer / Member filter
```

Future sequence:

```text
1. Add Cluster filter.
2. Test page 1, page 2, sort, filter apply, reset.
3. Add SHG / Collective filter.
4. Test page 1, page 2, sort, filter apply, reset.
5. Add Producer / Member filter.
6. Test page 1, page 2, sort, filter apply, reset.
```

Do not combine all three filters in one untested jump.

---

## Current Build Lock

Use this version as the current baseline:

```text
Amaley Discovery Engine v1.4.4 — Full OG Product Card Controls Tested
```

Any future v1.4.5+ work must preserve:

- v1.4.4 Product Discovery card renderer behaviour
- approved card-control section structure
- existing filter/query/pagination stability
- product data and origin mapping safety
