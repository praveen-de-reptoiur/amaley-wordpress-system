# Amaley Blog System Current Status — v1.4.7 Audit Safe

Current source lock for the Amaley Blog System plugin.

```text
Plugin: Amaley Blog System
Current version: v1.4.7 — Audit Safe Baseline
Repo source path: plugins/amaley-blog-system/
WordPress plugin folder: amaley-blog-system/
```

GitHub is for editable source and documentation. Release ZIPs, backups, videos, screenshots, media and Elementor generated cache/CSS should stay outside the repo.

## Purpose

This plugin manages the Amaley blog archive and single blog presentation through Elementor widgets. Blog content stays in normal WordPress Posts.

It provides:

- Blog archive/listing page widgets.
- Single blog template widgets.
- Blog Card 1 archive card design.
- Full-width single blog hero.
- Single article layout with sidebar, share, promo, tags, navigation and related posts.
- Admin page assignment under `Amaley Blog`.

## WordPress setup

Create two normal pages:

```text
1. Blogs
2. Blog Detail Template
```

Then assign them from:

```text
WordPress Admin → Amaley Blog
```

Use:

```text
Blog Listing Page         → Blogs
Single Blog Template Page → Blog Detail Template
```

Important setup note:

```text
Settings → Reading → Posts page should stay blank / Select.
```

The custom `Blogs` page is managed by this plugin, not by the native WordPress Posts page setting.

## Final Elementor widget order

### Blog archive page

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
```

### Single blog template page

```text
1. Amaley Single Hero — Full Width
2. Amaley Single Article Layout — Fixed
```

## Active Elementor widgets

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

## Retired single-blog attempts

These older single-blog widgets/approaches are not part of the current baseline:

```text
Amaley Blog Single Hero
Amaley Blog Single Content
Amaley Blog Single Sidebar
Amaley Related Blogs
Old Single Layout
Amaley Single Hero — Clean
Amaley Single Blog Layout Clean
Amaley Single Blog Template — Clean
```

The final accepted model is:

```text
Separate full-width hero widget + separate article layout widget.
```

## Accepted decisions

### Single hero

Accepted in the v1.4.2 line and retained in v1.4.7:

- Separate widget.
- Full-width frontend hero.
- Elementor editor-safe full-width behaviour.
- Featured image media/background layer.
- Amaley theme-consistent visual style.
- Clean controls mapped to scoped selectors.

### Single article layout

Accepted in the v1.4.3 line and retained in v1.4.7:

- Separate layout widget.
- Sidebar + article content + promo + tags + navigation + related posts.
- No internal sidebar scrollbar.
- Sticky behaviour only where safe.
- Promo image/text overflow guarded.
- Editor stability guarded.

### Controls

v1.4.5 and v1.4.6 completed the missing relevant controls without changing the accepted design.

Control rule:

```text
Only add controls that belong to the section/element and are useful for the admin.
```

Follow:

- One major element = one clean section.
- Sub-elements = tabs inside that section.
- Margin, padding and spacing/gap where relevant.
- Image controls where images exist.
- Normal/Hover/Active/Focus where applicable.
- Device visibility in Advanced.
- Scoped, lightweight CSS.

## Asset loading and conflict safety

v1.4.7 restricts assets so CSS/JS are not forced across the full website.

Assets load only on:

```text
- Assigned Blog archive page
- Assigned Blog detail template page
- Routed single posts
- Elementor editor/preview mode
```

This reduces conflict risk with the theme, header/footer plugin, WooCommerce, Discovery Engine and other Amaley plugins.

## Source structure

Expected source structure:

```text
plugins/amaley-blog-system/
  amaley-blog-system.php
  assets/
  includes/
  templates/
  README.md
  README-v1.4.7-AUDIT-SAFE.txt
```

Do not place the plugin at repo root. Do not create a double folder such as:

```text
plugins/amaley-blog-system/amaley-blog-system/
```

## Safe boundaries

Future Blog System work should stay limited to blog archive/single blog presentation unless a wider change is clearly approved.

Keep separate from:

```text
WooCommerce cart/checkout/order logic
Product data
Product images/gallery
Product-origin mapping
Header/footer source
Elementor generated CSS/cache
Release ZIPs/media/videos/screenshots
```

## Future update rule

Future work must start from:

```text
plugins/amaley-blog-system/ — v1.4.7 Audit Safe Baseline
```

Do not use old patch ZIPs from v1.0.x, v1.1.x, v1.2.x, v1.3.x or pre-audit v1.4.x as the source baseline.

## Required QA before delivery

Before any future Blog System delivery:

```text
1. Check plugin header version and AMALEY_BLOG_VERSION.
2. Run PHP lint on PHP files.
3. Run JS syntax check.
4. Check CSS brace balance.
5. Confirm scoped CSS only.
6. Confirm assets are not loaded site-wide unnecessarily.
7. Check Elementor editor for archive and single pages.
8. Check frontend archive and single posts.
9. Check desktop/tablet/mobile.
10. Confirm single hero remains full width.
11. Confirm article layout remains stable.
12. Confirm controls affect the right elements.
13. Confirm no render-time style layer is introduced into single widgets.
14. Confirm any ZIP has one plugin folder only.
```

## Rollback note

If a future update breaks the blog system, restore the source to:

```text
v1.4.7 Audit Safe Baseline
```
