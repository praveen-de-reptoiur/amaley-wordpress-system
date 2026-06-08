# Pages Hero Other Notes — v0.6.4.1

Status: All active Pages Hero Other variations now have selected-style Elementor controls and staging-tested CSS support.

## Widget

```text
Amaley UI > Amaley Pages Hero Other
```

## Shortcode

```text
[amaley_pages_hero_other style="style-1"]
```

## Active styles

```text
Style 1  — Story Split
Style 2  — Cluster / Traceability
Style 3  — Collections / Intent Card
Style 5  — Contact / Minimal
Style 6  — Gifting / Image Split
Style 7  — Premium Editorial Ribbon
Style 8  — Centered Statement
Style 9  — Framed Origin Editorial
Style 10 — Product Story Editorial
Style 11 — Warm Story Editorial
Style 12 — Centered Trust Board
Style 13 — Quiet Minimal Statement
```

Style 4 remains intentionally removed.

## Control rules

- Controls must appear only for the selected style.
- Style 10 is the accepted base and must not be visually redesigned without approval.
- Device-wise visibility is handled through Elementor responsive switcher controls.
- Image/media controls appear only for image-based styles: Style 6, 7, 9, 10, 11.
- Editorial note controls appear only for editorial image styles: Style 7, 9, 10, 11.
- Statement pill controls appear only for statement styles: Style 8, 12, 13.
- Intent card controls appear only for Style 3.
- Right text panel controls appear only for Style 1.
- Style 2 uses stats only and has no removed bottom feature strip.

## Stats controls

Stats-based styles include:

```text
Style 2
Style 3
Style 7
Style 9
Style 11
Style 10
```

The v0.6.4.1 fix adds:

```text
Value and Label Gap
Label Top Spacing Fallback
```

These prevent stat values and labels from appearing too tight or visually merged.

## Renderer targeting classes

The renderer includes control-friendly classes for Elementor targeting:

```text
.amaley-pages-hero-other__stat-value
.amaley-pages-hero-other__stat-label
.amaley-pages-hero-other__note-kicker
.amaley-pages-hero-other__note-title
.amaley-pages-hero-other__note-text
.amaley-pages-hero-other__side-title
.amaley-pages-hero-other__side-description
.amaley-pages-hero-other__intent-kicker
.amaley-pages-hero-other__intent-title
.amaley-pages-hero-other__intent-description
.amaley-pages-hero-other__statement-pill-title
.amaley-pages-hero-other__statement-pill-text
```

## CSS safety

CSS must remain scoped to:

```text
.amaley-pages-hero-other
```

Style-specific CSS must use scoped style modifiers such as:

```text
.amaley-pages-hero-other--style-7
.amaley-pages-hero-other--style-10
```

Do not add global body/theme/WooCommerce/header/footer rules from this plugin.

## Safety lock

No Discovery Engine, Amaley Core, Amaley Templates, Header/Footer, WooCommerce cart/checkout, product data, origin mapping, uploaded photos or database changes are part of this widget.
