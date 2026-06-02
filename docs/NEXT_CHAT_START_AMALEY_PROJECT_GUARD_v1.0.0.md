# NEXT CHAT START — Amaley Project Guard v1.0.0

Date locked: 2026-06-02

## Start exactly here in the next chat

The next chat should not start with random coding.

Start with this sequence:

1. Read the complete GitHub repository status.
2. Read `README.md`.
3. Read `plugins/README.md`.
4. Read `docs/PROJECT_MANIFEST.md`.
5. Read `docs/NEXT_CHAT_PROMPT.md`.
6. Read `docs/AMALEY_PROJECT_GUARD_MASTER_PLAN_LOCKED_v1.0.1_PERFORMANCE_LOCK.md`.
7. Confirm Amaley Core source is currently `v1.0.99.4`.
8. Confirm Project Guard `v1.0.0` scope before writing any code.

## Current locked source state

```text
Amaley Core: v1.0.99.4
Amaley Discovery Engine: v1.3.5
Amaley Site Shell: v1.0.1
Amaley UI Sections Kit: v0.6.1
Amaley Compact Widgets: v0.4.3 source
Amaley Templates: v1.2.7
```

## Current priority

Build:

```text
Amaley Project Guard v1.0.0 — Foundation Guard
```

Do not build a new frontend widget yet.

Do not start Amaley Core cleanup yet unless Praveen explicitly switches back to cleanup.

Current next priority is Project Guard because it will protect future cleanup and development.

## v1.0.0 exact scope

Build only:

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

## Performance lock

Project Guard must never make the live website heavy.

Rules:

- No frontend output.
- No frontend CSS.
- No frontend JS.
- No full scan on normal page load.
- No heavy DB/file/log scan without manual trigger.
- Admin dashboard should load cached last report first.
- Full scan must be manual-only.
- Deep scans must be batched in later versions.

## Do not build in v1.0.0

- No frontend URL scanner
- No log parser
- No data integrity scanner
- No external conflict deep scanner
- No automatic fix
- No plugin deactivation
- No theme/plugin file editing
- No scheduled scan
- No frontend CSS/JS

## Final instruction

Next chat must begin by reading the repo and this file, then building `plugins/amaley-project-guard/` v1.0.0 as a read-only, admin-only, zero-frontend-load diagnostic plugin.
