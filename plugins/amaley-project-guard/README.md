# Amaley Project Guard

Independent read-only admin control room for the Amaley WordPress ecosystem.

## Current Build

**Version:** 1.0.4 — Fatal / Error / Log Scanner

**Status:** HOLD / paused at v1.0.4 GitHub verified checkpoint

**Author:** Praveen

## Correct GitHub Path

`plugins/amaley-project-guard/`

Do not place this plugin inside `plugins/amaley-core/`.

## Current Hold State

Project Guard is currently paused here:

**Amaley Project Guard v1.0.4 — Fatal / Error / Log Scanner Test Pass + GitHub Full Source Verified.**

The work is being held for now because the next priority is to move to a fresh WordPress install, install all required plugins, and begin the Amaley website build. Project Guard should resume later from this exact checkpoint.

Latest master handoff checkpoint:

`AMALEY_MASTER_HANDOFF_2026-06-04_v10.5_PROJECT_GUARD_v1.0.4_FATAL_ERROR_LOG_SCANNER_GITHUB_VERIFIED_BACKUP_PENDING_LOCKED_COMPLETE.zip`

Important: v1.0.4 backup is still marked pending in the latest tracker/master handoff. When resuming Project Guard, first confirm backup done, then move to v1.0.5.

See:

`docs/PROJECT_GUARD_HOLD_NOTE_v1.0.4_2026-06-04.md`

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

## Planned Next Build After Hold

### v1.0.5 — Data Integrity Scanner

Planned as read-only only:

- Data integrity review.
- Relation consistency checks.
- Missing/broken reference warnings where possible.
- No auto-fix.
- No deletion.
- No Core modification.
- No frontend output.

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
