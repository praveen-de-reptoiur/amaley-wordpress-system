# Amaley Site Shell

**Plugin Name:** Amaley Site Shell  
**Slug:** `amaley-site-shell`  
**Author:** Praveen  
**Version:** 1.0.1  
**Status:** Staging-tested in shortcode/manual render mode. Auto render is available but currently on HOLD.

Amaley Site Shell is a lightweight, scoped, mobile-first header/footer shell plugin for the Amaley WordPress system.

It is designed to support a future clean Amaley build with controlled header, footer, mobile drawer, navigation, announcement strip, CTA, and footer contact/link sections.

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

## Current Tested Status

Tested on staging clone:

```text
https://lightsalmon-lemur-689499.hostingersite.com/
```

Passed:

- Plugin installed successfully.
- Plugin activated successfully.
- Admin dashboard loaded successfully.
- Shortcode mode tested successfully.
- Elementor Shortcode widget rendered the header and footer output.
- HTML widget shortcode issue was identified and corrected by using Elementor Shortcode widget.

Current safe usage:

```text
[amaley_site_header]
[amaley_site_footer]
```

## Shortcodes

```text
[amaley_site_header]
[amaley_site_footer]
```

Use these inside Elementor **Shortcode** widget, not Elementor HTML widget.

## Safety Rules

- Auto render is OFF by default.
- Use shortcodes or Elementor widgets first.
- Do not replace the current live/header footer blindly.
- Existing clone header/footer source is not fully confirmed yet.
- Full header/footer replacement must be tested only on fresh/staging build.
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

## Auto Render Decision

Auto render is available in v1.0.1, but it is currently on HOLD.

Reason:

- Current clone/live header-footer source is not fully confirmed.
- Header/footer may be coming from theme options, Freshen/Apus builder, Elementor templates, Megamenu plugin, or theme hooks.
- Enabling auto-render without mapping the existing header/footer source can create duplicate headers/footers or layout conflicts.

Current decision:

```text
Auto Header: OFF
Auto Footer: OFF
Mode tested: Shortcode/manual mode
Fresh build test required before replacement mode
```

## GitHub / Drive Status

GitHub source path:

```text
plugins/amaley-site-shell/
```

Drive ZIP backup:

```text
Amaley Project / 02_Active_Plugins / amaley-site-shell-v1.0.1.zip
```

## Development Rule

Amaley Site Shell must remain:

- Lightweight
- Scoped
- Mobile-first
- WooCommerce-safe
- Elementor-safe
- Non-coder manageable
- Tested before production use
- Reversible and rollback-ready
