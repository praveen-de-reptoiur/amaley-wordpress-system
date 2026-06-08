# Rollback Notes — Amaley UI Sections Kit v0.6.4.1

## Current checkpoint

```text
Amaley UI Sections Kit v0.6.4.1
Pages Hero Other — All Variations Controls
Staging Working + ZIP Audit Passed
```

## Rollback target

If v0.6.4.1 causes a visual/editor issue, roll back to the previous confirmed backup created before the all-variation update:

```text
amaley-ui-sections-kit-v0.6.3-style10-controls-working-staging-backup.zip
```

If that exact file name is not available, use the latest safe ZIP created immediately after Style 10 was confirmed working.

## What v0.6.4.1 changes

- `amaley-ui-sections-kit.php` version bump to 0.6.4.1.
- `includes/elementor/widgets/class-amaley-elementor-pages-hero-other-widget.php` all-variation Elementor controls.
- `assets/css/amaley-ui-pages-hero-other.css` scoped support CSS for all Pages Hero Other variations.
- Documentation updated for final handoff.

## What v0.6.4.1 does not change

- No database schema changes.
- No CPT creation or deletion.
- No WooCommerce template override.
- No cart or checkout replacement.
- No product data update.
- No origin mapping update.
- No uploaded photo/gallery overwrite.
- No Discovery Engine filter/query change.
- No Amaley Core card/CPT change.
- No Amaley Templates change.
- No header/footer change.
- No global CSS reset.

## Rollback steps — manual file manager method

1. Take a fresh backup of the current plugin folder before rollback.
2. In WordPress, deactivate `Amaley UI Sections Kit` only if file replacement through File Manager is not safe while active.
3. Replace the plugin folder contents with the previous safe backup.
4. Reactivate `Amaley UI Sections Kit` if it was deactivated.
5. Clear Elementor cache:

```text
Elementor → Tools → Regenerate CSS & Data
Elementor → Tools → Sync Library
```

6. Clear site cache if a cache plugin/server cache is used.
7. Reopen Elementor and test Style 10.
8. Test one non-Style-10 page hero.

## Rollback steps — WordPress plugin upload method

Use this only if the ZIP structure is prepared for WordPress plugin upload.

1. Download the previous safe backup ZIP.
2. Deactivate and delete the current plugin.
3. Upload the previous safe ZIP.
4. Activate the plugin.
5. Clear Elementor and site cache.
6. Re-test affected pages.

## Expected rollback impact

- Style 10 accepted controls should remain available if rolling back to v0.6.3 Style 10 backup.
- All-variation controls added in v0.6.4.1 will no longer be available after rollback.
- Pages already using v0.6.4.1-specific settings may lose those newly added control values until v0.6.4.1 is restored.
- WooCommerce, Discovery Engine, Core, Templates and header/footer should remain unaffected because v0.6.4.1 does not modify them.
