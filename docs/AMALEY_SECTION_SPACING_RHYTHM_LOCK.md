# AMALEY SECTION SPACING RHYTHM LOCK

Status: Active visual rhythm lock  
Owner: Praveen  
Date locked: 2026-05-31  
Reference implementation: Amaley Core v1.0.46 Cluster Single Spacing Rhythm Polish  
Applies to: Entire Amaley website, new section widgets, existing sections during future polish

---

## Lock name

```text
Amaley Section Spacing Rhythm 1
```

This is the approved spacing density for Amaley pages after reviewing the Cluster Single page built with Amaley Core v1.0.46.

The approved direction is tighter, cleaner and more continuous than the earlier loose spacing where every section looked like a separate broken block.

---

## Master rule

All future Amaley website sections should follow this spacing rhythm.

Existing sections that were already built with larger gaps should be updated later to match this rhythm.

Do not return to the earlier oversized spacing unless the user explicitly asks for a more editorial/landing-page-specific section.

---

## Visual intent

The website should feel:

- Premium
- Clean
- Connected
- Easy to scan
- Mobile-first
- Section-wise but not fragmented
- Warm and earthy, not empty or over-spaced

The correct feel is:

```text
Enough breathing room, but no dead space.
```

---

## Section-wise architecture remains locked

This spacing lock does not change the architecture.

The final editing structure remains:

```text
One page template + multiple Amaley section widgets.
```

Sections stay separate so non-coders can control each part in Elementor.

Spacing issues must be solved through shared rhythm defaults and spacing controls, not by merging sections into one hardcoded block.

---

## Approved page rhythm from v1.0.46

The approved Cluster Single rhythm is:

1. Hero
2. Quick Details
3. Story
4. Women Collectives / SHGs
5. People / Producers
6. Mapped Products
7. CTA / footer flow

The visible spacing between these sections should stay compact and continuous, similar to the approved v1.0.46 screenshot review.

---

## Default spacing target

Use these as the default design target for new Amaley section widgets.

### Desktop

```text
Section vertical gap: compact-medium
Large section top/bottom padding: around 48px to 64px
Normal section top/bottom padding: around 36px to 52px
Heading-to-content gap: around 14px to 24px
Card grid gap: around 18px to 28px
```

### Tablet

```text
Section vertical gap: compact
Large section top/bottom padding: around 40px to 52px
Normal section top/bottom padding: around 32px to 44px
Heading-to-content gap: around 12px to 20px
Card grid gap: around 16px to 24px
```

### Mobile

```text
Section vertical gap: tight but readable
Large section top/bottom padding: around 32px to 44px
Normal section top/bottom padding: around 28px to 38px
Heading-to-content gap: around 10px to 16px
Card grid gap: around 14px to 20px
```

These are rhythm guidelines, not rigid pixels for every use case. The page should visually match the approved v1.0.46 density.

---

## What must be avoided

Avoid:

- 80px to 120px gaps between normal sections
- Repeating large top padding on every stacked Elementor widget
- Empty dead space between Story and SHGs
- Empty dead space between SHGs and Producers
- Empty dead space between Producers and Products
- Large isolated blocks that break the flow
- Manual page-by-page spacing hacks as the main solution
- Different spacing systems for Cluster, SHG and Member pages

---

## What should be updated later

Existing built sections/pages should be reviewed later and brought to this rhythm:

- Home sections
- Cluster Archive
- Cluster Single sections
- SHG Archive
- SHG Single sections
- Member / Producer Archive
- Member / Producer Single sections
- Product origin / traceability sections
- Static compact widgets where spacing feels too loose
- CTA bands and footer-prelude sections if they feel oversized

This should be done safely, section by section, without breaking existing layouts.

---

## Future development rule

Every new Amaley section, widget, archive page, single page or template should start with this spacing rhythm by default.

Before shipping a new visual section, check:

- Does the section connect naturally with the previous section?
- Is there unnecessary vertical dead space?
- Does mobile feel compact and readable?
- Are headings close enough to their content?
- Are card grids visually tight but not cramped?
- Does the page feel like one website, not multiple disconnected parts?

---

## Plugin implementation rule

Spacing should be implemented using:

- shared CSS variables where practical
- scoped plugin classes
- Elementor spacing controls where needed
- responsive default values
- section-level controls for non-coders

Do not use global CSS dumps.

Do not rely only on manual Elementor margins.

Do not create spacing fixes that affect header, footer, WooCommerce checkout, cart or unrelated theme areas.

---

## Naming convention

When future plugin updates are created for this rhythm, use clear names such as:

```text
Spacing Rhythm Polish
Section Rhythm Controls
Amaley Section Spacing Rhythm 1
```

Avoid vague names like:

```text
minor design fix
padding update
style change
```

---

## Current approved reference

Approved by user after testing:

```text
Amaley Core v1.0.46 — Cluster Single Spacing Rhythm Polish
```

User direction:

```text
Entire site should keep this level of spacing between sections.
Existing built sections will be updated later.
All new sections should remember and follow this rhythm.
```

---

## Non-negotiable rule

Do not make Amaley pages overly spacious again.

The approved rhythm is compact, premium and continuous.

Future pages must follow this spacing unless a specific section intentionally needs a different editorial treatment and the user approves it.
