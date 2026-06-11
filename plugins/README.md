# Amaley Plugins

Current clean source folders for Amaley custom WordPress plugins.

## Current baseline

- `amaley-core`: v1.1.0
- `amaley-discovery-engine`: v1.6.2 clean stable
- `amaley-blog-system`: v1.4.7 audit safe
- `amaley-hf-studio-v2`: v2.0.15 pre-lock safety
- `amaley-ui-sections-kit`: v0.6.1
- `amaley-compact-widgets`: v0.4.18 final tested
- `amaley-templates`: v1.2.7

## Amaley Blog System

Source folder:

```text
plugins/amaley-blog-system/
```

Current widgets:

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

Read before future Blog System work:

```text
docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md
plugins/amaley-blog-system/README.md
plugins/amaley-blog-system/README-v1.4.7-AUDIT-SAFE.txt
```

## Repo rules

- Keep editable plugin source inside `plugins/<plugin-folder>/`.
- Keep release ZIPs, backups, screenshots, videos and media outside GitHub.
- Keep Elementor generated CSS/cache outside GitHub.
- Avoid double folders such as `plugins/amaley-blog-system/amaley-blog-system/`.
- Future work starts from the current baseline documented in `docs/PROJECT_MANIFEST.md`.
