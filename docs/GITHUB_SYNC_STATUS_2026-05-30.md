# GitHub Sync Status — 2026-05-30

Owner: Praveen

## Current objective

Before continuing new Amaley work, GitHub must be brought up to date with the accepted plugin state, while keeping the repository clean.

## Clean GitHub rule

Do not commit ZIP files, screenshots, videos, backups, `.wpress` files, media dumps, passwords, or `wp-config` files.

GitHub must contain source code and documentation only.

## Accepted plugin versions to sync

| Plugin | Accepted version | Status |
|---|---:|---|
| Amaley UI Sections Kit | v0.6.1 | Main plugin header/version updated in GitHub. Full source verification still required. |
| Amaley Compact Widgets | v0.4.2 | Final lock note committed. Full source folder sync still required. |

## Existing GitHub observations

- `plugins/amaley-ui-sections-kit/amaley-ui-sections-kit.php` previously showed v0.3.7.
- It was updated to v0.6.1 during this sync pass.
- `plugins/amaley-compact-widgets/` was not found before source sync.
- Compact Widgets v0.4.2 final lock note exists in `docs/AMALEY_COMPACT_WIDGETS_FINAL_LOCK_v0.4.2.md`.

## Required final target structure

```text
plugins/
  amaley-ui-sections-kit/
    amaley-ui-sections-kit.php
    README.md
    CHANGELOG.md
    assets/
    includes/
    docs/

  amaley-compact-widgets/
    amaley-compact-widgets.php
    README.md
    CHANGELOG.md
    assets/
    includes/
    docs/
```

## Final verification checklist

Before declaring GitHub fully synced:

1. UI Sections Kit main file shows v0.6.1.
2. Compact Widgets main file shows v0.4.2.
3. Compact Widgets source folder exists under `plugins/amaley-compact-widgets/`.
4. No ZIP/media/backup files are committed.
5. Documentation lock notes exist.
6. GitHub file list confirms both plugin source folders.

## Current caution

Do not start new plugin/page work until both plugin source folders are confirmed in GitHub.
