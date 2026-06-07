Amaley Compact Widgets v0.4.19
===============================

Professional, compact, mobile-first Elementor widgets and shortcodes for Amaley page sections.

This is the merged home-section safe build. It keeps the existing Amaley Compact Widgets system and merges the approved home-page section widgets and control fixes from the former Compact Spacing Controls add-on.

Status
------
- Current stable merged version: 0.4.19
- Source baseline: live/fresh Hostinger compact plugin supplied by Praveen
- Merge source: Amaley Compact Spacing Controls v1.0.23 icon color fix
- Deployment target: staging first, then final/live after backup and cache reset
- Separate add-on required: No

Merged home-section widgets
---------------------------
The following widgets are now part of the main Amaley Compact Widgets plugin:

- Amaley Mission Visual Statement
- Amaley Vision Visual Statement
- Amaley Process Journey
- Amaley Origin Pillars
- Amaley Livelihood Chain Band
- Amaley Gifting Feature Split

Merged control additions
------------------------
The following previously separate control improvements are now included:

- Split Editorial spacing controls
- Split Editorial card polish controls
- Split Editorial mobile text-first / image-first controls
- Origin Map Path visibility controls
- Origin Map Path layout controls
- Origin Map Path map, panel and step controls
- SVG/icon color fix for merged visual widgets

Important install rule
----------------------
After installing or updating to this merged Compact Widgets build, keep the separate plugin inactive:

Amaley Compact Spacing Controls v1.0.23

Only one active source should provide these merged widgets. The merged plugin includes guards to reduce duplicate registration risk, but the clean production setup is:

Amaley Compact Widgets v0.4.19 active
Amaley Compact Spacing Controls inactive

Safety notes
------------
This plugin is presentation-only. The v0.4.19 merge does not add product, mapping, media-management or migration logic.

Not changed:
- WooCommerce products
- Product images or galleries
- Cluster / SHG / Member data
- Product-origin mapping
- Import/export flows
- Header/footer
- Theme templates
- Amaley Core data structures

No product-management, migration or media-overwrite functionality was added as part of this merge.

CSS scope
---------
The merged CSS remains scoped to Amaley widget wrappers, including:

- .amaley-cw4
- .amaley-mvr
- .acwsc-pj
- .acwsc-op
- .acwsc-lc
- .acwsc-gift

The merge should not introduce global body/html/header/footer/WooCommerce overrides.

Post-update checklist
---------------------
After installing/updating the plugin:

1. Keep Amaley Compact Spacing Controls v1.0.23 inactive.
2. Confirm only Amaley Compact Widgets v0.4.19 is active for this merged section system.
3. Elementor -> Tools -> Regenerate CSS & Data.
4. LiteSpeed / cache plugin -> Purge All.
5. Hard refresh the browser.
6. Check desktop, tablet and mobile for the merged widgets.
7. Confirm icon color, image, spacing and responsive controls work in Elementor.

Documentation
-------------
For details, see:

- CHANGELOG.md
- MERGE_NOTES_v0.4.19.md
- INSTALLATION_NOTES.md

Version note
------------
v0.4.19 keeps the old compact widgets and adds the approved final home-section widgets into the main compact plugin. Treat v0.4.19 as the current stable merged checkpoint unless a later version supersedes it.
