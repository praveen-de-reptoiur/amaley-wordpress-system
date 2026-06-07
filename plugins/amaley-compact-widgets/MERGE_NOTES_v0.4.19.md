# Amaley Compact Widgets v0.4.19 Merge Notes

## Purpose

v0.4.19 merges the approved home-section widgets and control fixes from Amaley Compact Spacing Controls v1.0.23 into the main Amaley Compact Widgets plugin.

This removes the need to keep a separate add-on active for the final Amaley homepage visual sections.

## Source baseline

- Base plugin: Amaley Compact Widgets v0.4.18 from the live/fresh Hostinger working site.
- Merge source: Amaley Compact Spacing Controls v1.0.23 icon color fix.
- Merged plugin version: Amaley Compact Widgets v0.4.19.

## What was merged

### New Elementor widgets

The following widgets were merged into the main plugin and remain in the Amaley Compact Elementor category:

- Amaley Mission Visual Statement
- Amaley Vision Visual Statement
- Amaley Process Journey
- Amaley Origin Pillars
- Amaley Livelihood Chain Band
- Amaley Gifting Feature Split

### Existing widget control enhancements

The following controls were merged for existing Compact Widgets:

- Split Editorial spacing controls
- Split Editorial card controls
- Split Editorial mobile flow controls
- Origin Map Path visibility controls
- Origin Map Path layout controls
- Origin Map Path panel, map and step controls

### Stylesheets merged

The following scoped stylesheets are now registered and enqueued by the main plugin:

- assets/css/reference-visual-statement.css
- assets/css/process-journey.css
- assets/css/three-sections.css

## Main file changes

The main plugin file now identifies the build as version 0.4.19.

The plugin loader now registers and enqueues the merged stylesheets, registers merged home widgets, and loads the merged control injector.

## Conflict prevention

The merged plugin includes guards for the old add-on class name:

ACWSC109_Plugin

If the old Compact Spacing Controls add-on is still active, merged home widget registration and merged control injection are skipped. This reduces duplicate Elementor widget/control registration risk.

Clean production setup should still use only:

Amaley Compact Widgets v0.4.19 active
Amaley Compact Spacing Controls inactive

## What was intentionally not changed

This merge did not alter:

- WooCommerce product templates
- Product data
- Product media
- Cluster / SHG / Member data
- Product-origin mapping
- Import/export flows
- Header/footer
- Theme templates
- Amaley Core data structures
- Discovery Engine query/filter logic

## CSS scope

Merged CSS remains scoped to these wrappers:

- .amaley-cw4
- .amaley-mvr
- .acwsc-pj
- .acwsc-op
- .acwsc-lc
- .acwsc-gift

The merged CSS should not be used for global theme styling.

## Future update rules

1. Do not reactivate the separate Compact Spacing Controls add-on after this merge unless debugging an old page snapshot.
2. Do not copy the same merged widget classes into another plugin while v0.4.19 is active.
3. Keep widget IDs stable so existing Elementor pages do not lose their widget references.
4. Keep CSS scoped to widget wrappers.
5. Keep product, origin mapping and WooCommerce logic outside this visual widget plugin.
6. When adding a new visual section, add it as a properly named Elementor widget with scoped CSS and documented controls.
7. Update CHANGELOG.md and README.txt for every future plugin version.

## QA checklist used for this merge

- Plugin version updated to 0.4.19.
- New merged widgets present in plugin loader.
- Merged stylesheets registered and enqueued.
- Old add-on guard present.
- README updated.
- CHANGELOG updated.
- Installation notes added.
- No broad theme/header/footer/WooCommerce styling introduced.

## Rollback note

If v0.4.19 creates issues on final/live, rollback to the last stable backup and restore the previous Compact Widgets version. Then re-test on staging before trying a corrected merge.
