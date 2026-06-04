# Changelog

## Hold checkpoint — 2026-06-04

Project Guard is paused at:

**v1.0.4 — Fatal / Error / Log Scanner Test Pass + GitHub Full Source Verified.**

Reason for hold: the next priority is to move to a fresh WordPress install, install all required plugins, and begin the Amaley website build. Project Guard will resume later from this checkpoint.

Latest master handoff checkpoint:

`AMALEY_MASTER_HANDOFF_2026-06-04_v10.5_PROJECT_GUARD_v1.0.4_FATAL_ERROR_LOG_SCANNER_GITHUB_VERIFIED_BACKUP_PENDING_LOCKED_COMPLETE.zip`

When resuming:

1. Confirm v1.0.4 backup done.
2. Update tracker/master handoff from v10.5.
3. Continue to v1.0.5 — Data Integrity Scanner.

## v1.0.4 — Fatal / Error / Log Scanner

- Added Error Logs tab.
- Added admin-only recent-tail `wp-content/debug.log` reader.
- Added fatal/parse/warning/deprecated/notice grouping.
- Added related-area hints and manual next-step guidance.
- Added Markdown report summary for error logs.
- Maintained read-only safety: no frontend output, no auto-fix, no deletion, no plugin deactivation, no log clearing.
- Tested with report result: Critical 0, High 0, Medium 0, Fatal 0, Parse 0, Warnings 0, Deprecated 0, Notices 0.
- GitHub full source verified.

## 1.0.3 — External Plugin Conflict Scanner

- Added External Risks tab.
- Added read-only scanner for active external plugins.
- Added risk categories for cache/performance, snippets/custom code, filters/search, security/firewall, image/CDN/lazy-load, page builder add-ons and WooCommerce add-ons.
- Added External Plugin Conflict Scanner summary to Markdown report.
- No frontend output, no auto-fix, no delete/deactivate.
- Tested and GitHub source verified.
- Backup completed before moving to v1.0.4.

## 1.0.2

- Added Deep Amaley Core Integrity checks.
- Added required Core class availability checks without including Core files.
- Added required card renderer and registry method checks.
- Added basic section render method checks.
- Added Core asset file/registered/enqueued signal checks.
- Added duplicate Amaley Elementor widget-name checks.
- Added integrity summary to Markdown export.
- Kept Project Guard separate, read-only, admin-only, no frontend output, no auto-fix and no deletion.

## 1.0.1.3

- Changed Usage Map into compact accordion layout.
- Used Elementor Widgets and Used Shortcodes now open row-by-row.
- Unused Widgets and Unused Shortcodes are now collapsed review-only panels.
- Added max-height scroll inside long page/widget lists.
- No frontend output, no auto-fix, no deletion, no Amaley Core dependency.

## 1.0.1.2

- Converted used widget/shortcode rows into responsive cards.
- Forced Usage Map sections into one-column admin layout for better readability.
- Improved wrapping for long Elementor class names, callbacks, widget IDs and page labels.
- No frontend, Core, cleanup, auto-fix or delete changes.

## 1.0.1.1

- Fixed Usage Map responsive layout.
- Converted unused widget/shortcode review tables into responsive review cards.
- Added horizontal scroll safety for long widget classes, shortcode callbacks and page lists.
- No frontend output, no auto-fix and no Core changes.

## 1.0.1 — Usage Map

- Added Usage Map tab.
- Added safe Elementor `_elementor_data` scanner for Amaley widget usage.
- Added safe post content scanner for Amaley shortcodes.
- Added used/unused widget lists.
- Added used/unused shortcode lists.
- Added review-only cleanup candidates.
- Kept read-only mode, no frontend output, no auto-fix, no deletion and no plugin deactivation.

## 1.0.0 — Clean Separate Foundation

- Separate top-level admin menu.
- Manual Quick Scan.
- Cached report.
- Plugin registry.
- Project Map.
- Amaley Core read-only target checks.
- Elementor check.
- WooCommerce check.
- Markdown/JSON report export.
