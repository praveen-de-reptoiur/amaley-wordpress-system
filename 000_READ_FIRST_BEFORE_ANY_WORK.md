# 000 — READ FIRST BEFORE ANY WORK

This file must be read before starting **any** website, WordPress, Elementor, plugin, widget, page template, archive/single page, design system, layout plan, or UI build in this repository.

## Mandatory first rule

Before planning, designing, coding, generating Elementor widgets, making plugin files, or giving UI/build guidance, first read:

1. `docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md`
2. `docs/READ_FIRST_AMALEY.md`
3. `docs/PROJECT_MANIFEST.md`

## Locked standard

**Universal Full-Control Website Standard**

Core rule:

> Har section → har element → Content + Show/Hide + Layout + Style + Responsive control.

This means every future website/widget/template/plugin should be built so that a non-coder can manage content, visibility, layout, spacing, styling, and responsive behavior without touching code.

## Current compact widget lock

Latest accepted Compact Widgets source baseline:

```text
Amaley Compact Widgets v0.4.18 — Dual Heading + Non-Dual Alignment System Reset
```

Locked rules for compact widgets:

- `Amaley Dual Section Heading` is the approved reusable heading widget.
- Dual Heading must remain heading-only and must not receive card/grid/repeater controls.
- Existing non-dual compact widgets use separate Header Alignment, Card Text Alignment and Button Alignment controls.
- Do not bring back the old broad Overall Alignment control into non-dual compact widgets.
- Do not use `v0.4.14`, `v0.4.15`, `v0.4.16` or `v0.4.17` as final sources.
- No WooCommerce, product data, product image/gallery, product-origin mapping, header/footer or global CSS changes are allowed through Compact Widgets unless Praveen explicitly asks.

Reference docs:

```text
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
```

## Applies to

This rule is **not only for Amaley** and **not only for Himalayan/formal projects**. It applies to any future project handled in this repository or similar workflows, including e-commerce, institutional, NGO, travel, directory, dashboard, landing page, archive/single page, Elementor widget, and WordPress plugin work.

## Non-negotiable build rules

- Non-coder friendly controls are mandatory.
- No half-control widgets.
- No hardcoded styling without controls.
- No global CSS.
- No theme/WooCommerce/header/footer conflict unless explicitly requested.
- Prefer section-wise widgets over heavy all-in-one widgets.
- Use scoped, lightweight, conflict-safe CSS/JS only.
- Do not update GitHub unless explicitly requested by the user.

## Final standard line

Every future build must follow:

> Har section, har element ka non-coder-friendly Content + Show/Hide + Layout + Style + Responsive control, with scoped lightweight CSS and no conflict.
