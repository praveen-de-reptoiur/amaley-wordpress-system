# Amaley Project Guard

Independent read-only admin control room for the Amaley WordPress ecosystem.

## Current Build

**Version:** 1.0.4 — Fatal / Error / Log Scanner

**Author:** Praveen

## Correct GitHub Path

`plugins/amaley-project-guard/`

Do not place this plugin inside `plugins/amaley-core/`.

## Safety Lock

- Separate plugin.
- Not inside Amaley Core.
- Amaley Core remains a read-only scan target only.
- No frontend output.
- No frontend CSS/JS.
- No auto-fix.
- No deletion.
- No plugin activation/deactivation.
- Manual scan only.
- Error/log scanning is admin-only and reads only a recent safe tail of `wp-content/debug.log`.
- Logs are not cleared, deleted, rotated, changed or exposed publicly.

## v1.0.4 Added

- Fatal / Error / Log Scanner tab.
- Safe recent-tail reader for `wp-content/debug.log`.
- Error grouping for fatal, parse, warning, deprecated, notice and other PHP log findings.
- Related-area hints for Amaley Project Guard, Amaley Core, WooCommerce, Elementor, theme and external sources.
- Manual next-step guidance for each grouped log finding.
- Markdown report includes Fatal / Error / Log Scanner summary and category hits.

## Previous Builds

### 1.0.3

External Plugin Conflict Scanner added and tested.

### 1.0.2

Deep Amaley Core Integrity checks added and tested.

### 1.0.1.3

Usage Map compact accordion fix. Long usage lists became easier to review inside WordPress admin.

### 1.0.1

Usage Map base added.

### 1.0.0

Clean separate foundation build.
