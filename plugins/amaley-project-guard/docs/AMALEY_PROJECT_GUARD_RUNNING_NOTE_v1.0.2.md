# Amaley Project Guard Running Note — v1.0.2

Status: Build prepared for testing.

Scope: Deep Amaley Core Integrity.

Added checks:

- Required Amaley Core classes.
- Core header/constant version match.
- Card renderer and card registry public methods.
- Key single/archive section render methods.
- Core CSS asset file and handle signals.
- Duplicate Amaley Elementor widget-name signals.

Safety:

- No Amaley Core file include.
- No Amaley Core edit.
- No auto-fix.
- No deletion.
- No plugin activate/deactivate.
- No frontend output.
- Manual Quick Scan only.

Testing needed:

- Install ZIP in WordPress.
- Run Quick Scan.
- Check Overview severity counts.
- Check Amaley Core tab and Deep Integrity section.
- Check frontend Home, Shop/Product, Cluster and Member pages.
