# Amaley Project Guard

Independent read-only admin control room for the Amaley WordPress ecosystem.

## Version

1.0.0 — Clean separate plugin rebuild.

## Author

Praveen

## Important architecture note

This plugin is intentionally separate from Amaley Core.

- It does not create a submenu under Amaley Core.
- It does not include Amaley Core files.
- It does not require Amaley Core to activate.
- It only scans Amaley Core as a read-only target if detected.

## Admin menu

WordPress Dashboard → Amaley Project Guard

## Safety

- No frontend output.
- No frontend CSS/JS.
- No auto-fix.
- No deletion.
- No plugin activation/deactivation.
- Manual scan only.
