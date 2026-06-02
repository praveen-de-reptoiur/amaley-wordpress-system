# Amaley Project Guard

Status: Planning locked. Coding starts next chat after reading the full repository.

Main locked plan:

```text
docs/AMALEY_PROJECT_GUARD_MASTER_PLAN_LOCKED_v1.0.1_PERFORMANCE_LOCK.md
```

Next-chat start note:

```text
docs/NEXT_CHAT_START_AMALEY_PROJECT_GUARD_v1.0.0.md
```

---

## Plugin Role

Amaley Project Guard will be the read-only control-room, debug, audit and mapping plugin for the complete Amaley WordPress ecosystem.

It should help admins and developers quickly understand:

- Which Amaley plugins are active
- Which versions are active
- Which dependencies are missing
- Which old or broken plugins are still present
- Which widgets/sections exist
- Which widget is used on which page/template
- Which required CPTs are missing
- Which required fields are missing
- Whether WooCommerce is active
- Whether Elementor is active
- Whether Atomic Editor is active
- Whether required templates, assets, widgets, renderers or shortcodes may be broken

---

## Performance and Zero-Load Safety Lock

Project Guard must never make the live website heavy.

Non-negotiable rules:

- No frontend output.
- No frontend CSS.
- No frontend JS.
- No frontend render hooks in v1.0.0.
- No full scan on normal page load.
- No heavy DB/file/log scan without manual trigger.
- Dashboard should load cached last report first.
- Full scan must be manual-only.
- Scan time, memory usage and scanned item count must be reported.

If Project Guard slows frontend loading, rendering, WooCommerce, Elementor editor or cache behaviour, that version is considered failed.

---

## v1.0.0 Locked Scope

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

---

## Do Not Build in v1.0.0

- No frontend URL scanner
- No debug.log parser
- No full data integrity scanner
- No external conflict deep scanner
- No automatic fixes
- No plugin deactivation
- No theme/plugin file editing
- No scheduled scans
- No frontend CSS/JS

---

## Future Roadmap

```text
v1.0.0 — Foundation Guard
v1.0.1 — Usage Map
v1.0.2 — Deep Amaley Core Integrity
v1.0.3 — External Plugin Conflict Scanner
v1.0.4 — Error/Fatal Log Scanner
v1.0.5 — Data Integrity Scanner
```

---

## Next Chat Instruction

The next chat must begin by reading the full repository and the locked Project Guard plan first.

Then build `plugins/amaley-project-guard/` v1.0.0 as a read-only, admin-only, zero-frontend-load diagnostic plugin.
