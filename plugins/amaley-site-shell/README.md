# Amaley Site Shell

**Plugin Name:** Amaley Site Shell  
**Slug:** `amaley-site-shell`  
**Author:** Praveen  
**Version:** 1.0.0

Amaley Site Shell is a lightweight, scoped, mobile-first header/footer plugin for the Amaley WordPress system.

## Purpose

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation manager
- Announcement strip
- CTA controls
- Footer contact and link controls
- Shortcodes
- Elementor widgets
- Optional auto-render mode, OFF by default

## Shortcodes

```text
[amaley_site_header]
[amaley_site_footer]
```

## Safety Rules

- Auto render is OFF by default.
- Use shortcodes or Elementor widgets first.
- CSS is scoped with `.amaley-shell-`.
- PHP is prefixed with `Amaley_Shell_` and `amaley_shell_`.
- WooCommerce remains the commerce engine.
- Elementor is not replaced.
- Fresh/staging testing first.

## Admin

WordPress Admin → Amaley Site Shell

Sections:

- Dashboard
- Header Settings
- Mobile Header
- Navigation
- Footer Settings
- Design Controls
- Import / Export
- Settings


## v1.0.1 Backend Auto Render Update

- Added backend-controlled Auto Render Header and Footer mode.
- Added optional staging-only existing theme header/footer hide controls.
- Header can render automatically through `wp_body_open`.
- Footer can render automatically before theme footer through `get_footer`.
- Shortcodes remain available for safe page-level testing.
