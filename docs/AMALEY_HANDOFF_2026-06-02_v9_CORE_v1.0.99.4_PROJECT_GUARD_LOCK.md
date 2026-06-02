# Amaley Handoff — 2026-06-02 v9

Status: Locked handoff for next chat.

## Current Source State

```text
Amaley Core: v1.0.99.4
GitHub source path: plugins/amaley-core/
Project Guard status: planning locked, coding not started yet
Next plugin to build: Amaley Project Guard v1.0.0
```

## What happened in this chat

1. Amaley Core source was manually uploaded to GitHub under:

```text
plugins/amaley-core/
```

2. GitHub source was verified:

```text
Version: 1.0.99.4
AMALEY_CORE_VERSION: 1.0.99.4
```

3. Repository-level docs were updated for v1.0.99.4:

```text
README.md
plugins/README.md
docs/CHANGELOG.md
docs/PROJECT_MANIFEST.md
docs/NEXT_CHAT_PROMPT.md
```

4. Version-wise Amaley Core documentation was added:

```text
docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.md
docs/AMALEY_CORE_VERSION_HISTORY_v1.0.74_to_v1.0.99.4.csv
docs/AMALEY_CORE_CURRENT_STATUS_v1.0.99.4.md
docs/AMALEY_CORE_KNOWN_GAPS_AND_RISKS_v1.0.99.4.txt
docs/AMALEY_CORE_SAFE_CLEANUP_PLAN_v1.0.99.4.txt
docs/AMALEY_CORE_NEXT_WORK_PLAN_v1.0.99.4.txt
docs/AMALEY_CORE_INSTALL_AND_TEST_CHECKLIST_v1.0.99.4.txt
```

5. One messy/confusing file header was found and fixed:

```text
plugins/amaley-core/includes/widgets/class-amaley-core-member-archive-grid-widget.php
```

Old misleading header mentioned v1.0.76.4. It now clearly mentions v1.0.99.4 and the Member Archive OG bridge.

6. Amaley Project Guard master plan was locked with performance rules:

```text
docs/AMALEY_PROJECT_GUARD_MASTER_PLAN_LOCKED_v1.0.1_PERFORMANCE_LOCK.md
```

7. Next chat start note was added:

```text
docs/NEXT_CHAT_START_AMALEY_PROJECT_GUARD_v1.0.0.md
```

8. Project Guard planning README was updated:

```text
plugins/amaley-project-guard/README.md
```

## Locked Project Guard Direction

Amaley Project Guard will be a read-only, admin-only, zero-frontend-load diagnostic and mapping plugin.

It will eventually provide:

- System health
- Plugin registry
- Amaley plugin map
- Widget/section map
- Widget/page usage map
- Conflict scanner
- Elementor scanner
- WooCommerce scanner
- Asset scanner
- Fatal/error scanner
- Data/CPT scanner
- Report export

## Performance Lock

Project Guard must never make the live website heavy.

Rules:

- No frontend output.
- No frontend CSS.
- No frontend JS.
- No frontend render hooks in v1.0.0.
- No scan on normal page load.
- No heavy DB/file/log scan without manual trigger.
- Cached dashboard report first.
- Manual Quick Scan / Full Scan only.
- Scan time, memory usage and scanned item count must be reported.

## Next Chat Instruction

In the next chat, start exactly here:

1. Read the complete GitHub repository status first.
2. Read `README.md`.
3. Read `plugins/README.md`.
4. Read `docs/PROJECT_MANIFEST.md`.
5. Read `docs/NEXT_CHAT_PROMPT.md`.
6. Read `docs/AMALEY_PROJECT_GUARD_MASTER_PLAN_LOCKED_v1.0.1_PERFORMANCE_LOCK.md`.
7. Read `docs/NEXT_CHAT_START_AMALEY_PROJECT_GUARD_v1.0.0.md`.
8. Confirm Amaley Core is v1.0.99.4.
9. Confirm Project Guard v1.0.0 scope.
10. Then build only `Amaley Project Guard v1.0.0 — Foundation Guard`.

## Do not start with

- Do not start random coding.
- Do not build frontend widgets.
- Do not start data integrity scanner in v1.0.0.
- Do not start log parser in v1.0.0.
- Do not start frontend URL scanner in v1.0.0.
- Do not add frontend CSS/JS.
- Do not mutate the database except storing scan/cache reports.

## v1.0.0 exact scope

1. Admin menu: `Amaley → Project Guard`
2. Manual Quick Scan button
3. Cached dashboard report
4. Active/inactive plugin registry scan
5. Amaley plugin detection
6. External plugin detection
7. Amaley Core version/header/constant check
8. Required Amaley Core file checks
9. Elementor active check
10. Atomic Editor warning
11. WooCommerce active check
12. Basic shortcode list
13. Basic Elementor widget list
14. Basic Project Map
15. Export Markdown/JSON report
16. Performance metrics: scan time, memory usage, scanned item count

This handoff is the source-of-truth continuation note for the next chat.
