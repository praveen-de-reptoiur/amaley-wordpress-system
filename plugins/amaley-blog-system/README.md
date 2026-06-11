# Amaley Blog System

Editable source folder for the Amaley Blog System WordPress plugin.

## Current baseline

```text
Version: v1.4.7 Audit Safe
Source path: plugins/amaley-blog-system/
Plugin folder: amaley-blog-system/
```

This folder contains the editable source files that were uploaded after the accepted hero/layout rebuild and final audit.

## What this plugin does

- Manages the Amaley blog archive/listing page.
- Manages the Amaley single blog template page.
- Keeps blog content inside normal WordPress Posts.
- Provides Elementor widgets for archive hero, archive layout, full-width single hero and single article layout.
- Provides an `Amaley Blog` admin page for assigning the archive and single template pages.

## Correct source structure

```text
plugins/amaley-blog-system/
  amaley-blog-system.php
  assets/
    css/
    js/
    images/
  includes/
    class-amaley-blog-plugin.php
    class-amaley-blog-query.php
    class-amaley-blog-reading-time.php
    class-amaley-blog-renderer.php
    class-amaley-blog-settings.php
    class-amaley-blog-template-router.php
    elementor/
  templates/
    single-post-router.php
  README.md
  README-v1.4.7-AUDIT-SAFE.txt
```

## Final Elementor widgets

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

## Important setup note

Use the plugin admin page:

```text
WordPress Admin → Amaley Blog
```

Assign:

```text
Blog Listing Page         → Blogs
Single Blog Template Page → Blog Detail Template
```

Keep native WordPress Reading Settings clean:

```text
Settings → Reading → Posts page = blank / Select
```

Do not use WordPress native Posts page assignment for the custom `Blogs` page.

## Development rules

- Keep source files here, not ZIP files.
- Do not commit Elementor generated CSS/cache.
- Do not commit media, videos, screenshots or backups.
- Do not nest as `plugins/amaley-blog-system/amaley-blog-system/`.
- Do not move this plugin to repo root.
- Keep hero and article layout as separate widgets.
- Keep CSS scoped to the plugin/widget prefix.
- Keep assets limited to assigned blog pages, routed single posts and Elementor editor/preview.
- Before future delivery, check editor, frontend, desktop, tablet and mobile.

## Documentation

Read these before future work:

```text
docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md
docs/PROJECT_MANIFEST.md
docs/UNIVERSAL_FULL_CONTROL_WEBSITE_STANDARD.md
```

## Baseline warning

Future work must start from this folder and from v1.4.7 Audit Safe source. Do not use older patch ZIPs as current source.
