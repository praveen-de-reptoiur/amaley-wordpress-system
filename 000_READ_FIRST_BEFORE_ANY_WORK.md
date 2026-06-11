# 000 — READ FIRST BEFORE ANY WORK

This file must be read before starting any website, WordPress, Elementor, plugin, widget, page template, archive/single page, design system, layout plan, or UI build in this repository.

## Mandatory first rule

Before planning, designing, coding, generating Elementor widgets, making plugin files, or giving UI/build guidance, first read:

1. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
2. `docs/READ_FIRST_AMALEY.md`
3. `docs/PROJECT_MANIFEST.md`
4. `docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md`

## Locked standard

**Universal Full-Control Website Standard**

Core rule:

> Har section → har element → Content + Show/Hide + Layout + Style + Responsive control.

Every future website/widget/template/plugin should let a non-coder manage content, visibility, layout, spacing, styling, and responsive behavior without touching code.

## Current Blog System lock

Latest accepted Blog System source baseline:

```text
Amaley Blog System v1.4.7 — Audit Safe Baseline
```

Source path:

```text
plugins/amaley-blog-system/
```

Accepted widgets:

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

Blog System rule:

- Blog archive page uses Archive Hero + Archive Layout.
- Single blog template uses Single Hero Full Width + Single Article Layout Fixed.
- Hero and article layout stay separate.
- Future Blog work starts from `plugins/amaley-blog-system/` and the v1.4.7 current status doc.

Reference doc:

```text
docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md
```

## Current compact widget lock

Latest accepted Compact Widgets source baseline:

```text
Amaley Compact Widgets v0.4.18 — Dual Heading + Non-Dual Alignment System Reset
```

Locked rules for compact widgets:

- `Amaley Dual Section Heading` is the approved reusable heading widget.
- Dual Heading remains heading-only.
- Existing non-dual compact widgets use separate Header Alignment, Card Text Alignment and Button Alignment controls.
- Old broad Overall Alignment stays out of non-dual compact widgets.

Reference docs:

```text
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
```

## Applies to

This applies to any future project handled in this repository or similar workflows, including e-commerce, institutional, NGO, travel, directory, dashboard, landing page, archive/single page, Elementor widget, and WordPress plugin work.

## Build rules

- Non-coder friendly controls are mandatory.
- No half-control widgets.
- No hardcoded styling without controls.
- No global CSS.
- No theme, WooCommerce, header or footer conflict unless explicitly requested.
- Prefer section-wise widgets over heavy all-in-one widgets.
- Use scoped, lightweight, conflict-safe CSS/JS only.
- GitHub updates happen only after Praveen approval.

## Final standard line

Every future build must follow:

> Har section, har element ka non-coder-friendly Content + Show/Hide + Layout + Style + Responsive control, with scoped lightweight CSS and no conflict.
