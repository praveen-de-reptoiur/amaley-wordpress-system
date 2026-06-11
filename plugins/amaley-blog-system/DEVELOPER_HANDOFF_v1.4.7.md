# Amaley Blog System Developer Handoff v1.4.7

Source path: `plugins/amaley-blog-system/`

Version: `1.4.7`

## What this plugin does

- Blog archive hero.
- Blog archive layout with filter, search, sort, grid/list and pagination.
- Single blog full-width hero.
- Single blog article layout.
- Sidebar with table of contents, share area, promo card and related posts.
- Blog archive and single template assignment through Amaley Blog settings.

## Active widgets

Use only these current widgets:

1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero Full Width
4. Amaley Single Article Layout Fixed

Correct Blog Detail Template order:

1. Amaley Single Hero Full Width
2. Amaley Single Article Layout Fixed

## Old widgets not to restore

The earlier single-blog widgets were removed from the accepted workflow. Do not restore them unless a rollback is approved:

- Amaley Blog Single Hero
- Amaley Blog Single Content
- Amaley Blog Single Sidebar
- Amaley Related Blogs
- Old Single Layout
- Amaley Single Blog Template Clean
- Amaley Single Hero Clean
- Amaley Single Blog Layout Clean
- One-piece single template variants

## Accepted final decision

The final accepted single blog architecture is not one combined widget. It is two separate widgets:

- Hero widget first.
- Article layout widget below it.

The hero was accepted in v1.4.2. The article layout was accepted in v1.4.3. Later versions completed controls, packaging and audit notes.

## File map

```text
plugins/amaley-blog-system/
  amaley-blog-system.php
  assets/css/amaley-blog-frontend.css
  assets/js/amaley-blog-frontend.js
  includes/
  includes/elementor/
  templates/single-post-router.php
  README.md
  README-v1.4.7-AUDIT-SAFE.txt
```

Do not create nested plugin source like:

```text
plugins/amaley-blog-system/amaley-blog-system/
```

## Future work rule

Before any update, identify the exact widget, file list, control plan, selector map and QA plan. Do not randomly patch the whole plugin.
