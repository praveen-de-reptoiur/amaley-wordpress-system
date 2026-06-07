# Amaley Compact Widgets — Version History

This document tracks important source milestones for `plugins/amaley-compact-widgets/`.

---

## v0.4.18 — Final tested Dual Heading + Non-Dual Alignment System Reset

Status:

```text
Current accepted source baseline
```

Major decisions:

- Kept the approved `Amaley Dual Section Heading` widget.
- Kept Dual Heading as a dedicated heading-only widget.
- Preserved clean show/hide, content, layout, typography, spacing and responsive controls for Dual Heading.
- Reset old non-dual compact widget alignment behaviour.
- Removed the broad `Overall Alignment` control from old non-dual compact widgets.
- Separated alignment into:

```text
Header Alignment      → heading area only
Card Text Alignment   → cards/items only
Button Alignment      → action rows/buttons only
```

- Fixed Elementor live-preview header alignment behaviour using text alignment plus block margin behaviour.
- Preserved responsive columns fix by avoiding inline column variables that block Elementor selectors.

Safety:

```text
No WooCommerce cart/checkout/template override.
No product data change.
No product image/gallery change.
No product-origin mapping change.
No header/footer change.
No Amaley Core change.
No Amaley Discovery Engine change.
No broad global CSS.
No database/filesystem destructive routines.
```

Accepted source path:

```text
plugins/amaley-compact-widgets/
```

---

## v0.4.17 — Alignment System Reset Attempt

Status:

```text
Archived / not final
```

What it attempted:

- Removed broad Overall Alignment control from old widgets.
- Started separating Header Alignment, Card Text Alignment and Button Alignment.

Reason not final:

- Retest showed Header Alignment still needed better Elementor live-preview behaviour.

---

## v0.4.16 — Header Alignment Root Fix Attempt

Status:

```text
Archived / not final
```

What it attempted:

- Stopped Header Alignment from forcibly inheriting Overall Alignment.
- Tried to restore original heading alignment behaviour in old widgets.

Reason not final:

- Did not fully resolve the root alignment conflict in live Elementor behaviour.

---

## v0.4.15 — Safe Alignment Rollback Attempt

Status:

```text
Archived / not final
```

What it attempted:

- Rolled back broad v0.4.14 alignment changes.
- Tried a narrower alignment guard.

Reason not final:

- The old Overall Alignment control still remained a source of confusion and conflicts.

---

## v0.4.14 — Non-Dual Alignment Fix Attempt

Status:

```text
Rejected / do not use
```

What it attempted:

- Applied broad alignment CSS across non-dual widgets.

Reason rejected:

- Over-corrected alignment.
- Made several old widgets visually worse.
- Disturbed existing layouts such as Metric Tiles, Info Cards and Image Flip Cards.

---

## v0.4.13 — Final Clean Safe Package Before Alignment Reset

Status:

```text
Stable reference before v0.4.18 alignment reset
```

What it contained:

- Cleaned package after the Dual Heading work.
- Preserved v0.4.12 visual direction for Dual Heading.
- Removed old package clutter.

Reason superseded:

- Existing old compact widgets still needed proper non-dual alignment reset.

---

## v0.4.12 — Dual Heading Alignment Fix

Status:

```text
Visual reference for Dual Heading
```

What it fixed:

- Improved Dual Heading description width and alignment.
- Added better description alignment behaviour.

Reason superseded:

- Package cleanup was still needed before final source locking.

---

## v0.4.11 — Dual Section Heading Added

Status:

```text
Superseded by v0.4.18
```

What it added:

- Added `Amaley Dual Section Heading` as a new widget.
- Added shortcode fallback `[amaley_cw_dual_heading]`.
- Added heading-only controls rather than reusing a generic card widget base.

Reason superseded:

- Needed visual alignment correction and later package cleanup.

---

## v0.4.10 and earlier

Status:

```text
Historical / superseded
```

Notes:

- Earlier versions handled compact widget basics, responsive controls and safety checks.
- They should not be treated as current source baselines after v0.4.18.

---

## Current rule

Use only this source baseline unless a later version is explicitly approved and tested:

```text
Amaley Compact Widgets v0.4.18
```
