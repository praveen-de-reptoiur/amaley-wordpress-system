# Amaley Compact Widgets — Current Status v0.4.18

This document records the current accepted source baseline for `plugins/amaley-compact-widgets/`.

---

## Current version

```text
Amaley Compact Widgets v0.4.18
```

Source path:

```text
plugins/amaley-compact-widgets/
```

Plugin header and constant are expected to read:

```text
Version: 0.4.18
AMALEY_CW_VERSION = 0.4.18
```

---

## Accepted purpose

Amaley Compact Widgets provides manual/static compact visual sections for Elementor pages.

It is not responsible for:

- WooCommerce data
- product prices
- product stock
- product images/gallery
- product-origin mapping
- cart/checkout/order logic
- header/footer rendering
- CPT archive/single data systems
- Discovery filters/search/sort/pagination

Those responsibilities belong to Amaley Core, WooCommerce, Discovery Engine, H/F Studio or other dedicated modules.

---

## Approved new widget

### Amaley Dual Section Heading

The v0.4.18 source includes the approved reusable heading widget:

```text
Amaley Dual Section Heading
```

Shortcode:

```text
[amaley_cw_dual_heading]
```

Accepted use:

- reusable section headings across the Amaley site
- visual heading pattern with kicker, main heading, accent heading and optional description
- clean heading-only Elementor controls

Locked rule:

```text
Dual Heading must remain heading-only.
```

Do not add card/grid/repeater/product/data controls into the Dual Heading widget.

---

## Alignment system lock

v0.4.18 fixes the old compact widget alignment behaviour.

The old broad control was removed from non-dual widgets:

```text
Overall Alignment
```

The accepted alignment structure is now:

```text
Header Alignment      → heading / kicker / title / description only
Card Text Alignment   → cards / items only
Button Alignment      → action rows / buttons only, where applicable
```

This separation must be preserved in future changes.

Do not restore the old broad Overall Alignment control because it caused alignment conflicts between headings, cards and buttons.

---

## Responsive columns lock

v0.4.18 keeps the responsive columns fix from the earlier tested compact-widget work.

Rules:

- Do not output inline `--acw4-cols` values that override Elementor responsive selectors.
- Desktop, tablet and mobile columns must remain controllable from Elementor where the widget supports columns.
- Widgets that are not grid-based should not show confusing columns controls.

---

## Safety scope

v0.4.18 was treated as a compact-widget-only update.

Safety scope:

```text
No WooCommerce cart/checkout/template override.
No product data change.
No product image/gallery change.
No product-origin mapping change.
No header/footer change.
No Amaley Core change.
No Amaley Discovery Engine change.
No broad global CSS.
No database write/delete routine.
No filesystem write/delete routine.
No ZIP/media committed to GitHub.
```

---

## Rejected / archived versions

Do not use these as final source baselines:

```text
v0.4.14
v0.4.15
v0.4.16
v0.4.17
```

Reason:

- v0.4.14 over-corrected alignment and disturbed existing widgets.
- v0.4.15 did not fully resolve the root alignment issue.
- v0.4.16 still allowed alignment confusion in live Elementor preview.
- v0.4.17 improved the reset but needed final live-preview alignment correction.

Accepted source:

```text
v0.4.18
```

---

## Test notes

The final v0.4.18 direction was accepted after checking:

- Dual Heading visual alignment
- non-dual heading alignment behaviour
- Info Cards
- Purpose Cards
- Quote Cards
- Metric Tiles
- desktop preview
- mobile preview
- Elementor-style alignment controls

Direct live browser testing still needs to be done on the WordPress site after installing the final plugin ZIP and clearing cache.

---

## Future change rules

Before changing Compact Widgets again:

1. Read this document.
2. Read `000_READ_FIRST_BEFORE_ANY_WORK.md`.
3. Read `docs/PROJECT_MANIFEST.md`.
4. Do not change Dual Heading unless the task explicitly targets Dual Heading.
5. Do not change non-dual widget alignment with broad CSS.
6. Do not add controls that the widget output does not actually use.
7. Test each changed widget individually.
8. Keep GitHub source clean; keep ZIPs/media/screenshots/videos outside GitHub.
