# Amaley Project Guard Install Test Checklist

## Current Build

v1.0.4 — Fatal / Error / Log Scanner

## Before Install

- Take full site backup.
- Confirm current stable version is backed up.
- Do not delete older Project Guard ZIPs or master handoff ZIPs.

## Install Test

1. Upload `amaley-project-guard-v1.0.4-fatal-error-log-scanner-install.zip` in WordPress Plugins.
2. Activate/update plugin.
3. Open `Amaley Project Guard` top-level admin menu.
4. Run `Quick Scan` manually.
5. Confirm Overview loads.
6. Confirm `External Risks` tab still loads.
7. Open `Error Logs` tab.
8. Confirm it shows one of:
   - debug.log not found / empty / clean; or
   - grouped recent findings with severity and manual next step.
9. Export Markdown report.
10. Confirm frontend has no visual/output change.

## Must Not Happen

- No frontend output.
- No frontend CSS/JS.
- No auto-fix.
- No deletion.
- No plugin deactivation.
- No log clear/delete/rotate.
- No Amaley Core edit.
