# Amaley Site Shell Changelog

## 1.0.1 - 2026-05-27

### Added
- Added backend-controlled Auto Render Header and Footer mode so header/footer can be enabled or disabled from WordPress admin without placing shortcodes on every page.
- Added optional staging-only controls to hide the existing theme header/footer using safe CSS selector lists.
- Added body classes for optional theme shell replacement: `amaley-shell-hide-theme-header` and `amaley-shell-hide-theme-footer`.

### Changed
- Auto footer now renders on `get_footer` before the theme footer loads, instead of inside `wp_footer`, to avoid hiding the Amaley footer when the existing theme footer is hidden.
- Auto render functions now protect against duplicate output during one request.

### Safety
- Auto Render remains OFF by default.
- Theme header/footer hiding remains OFF by default.
- Shortcode mode remains available for testing.

## 1.0.0 — 2026-05-27

### Added

- Initial Amaley Site Shell plugin structure.
- Header renderer.
- Footer renderer.
- Mobile drawer renderer.
- Announcement strip renderer.
- Admin settings dashboard.
- Header settings controls.
- Navigation manager controls.
- Footer settings controls.
- Footer column controls.
- Design color/font controls.
- Import/export/reset settings.
- Shortcodes: `[amaley_site_header]` and `[amaley_site_footer]`.
- Safe Elementor widgets: Amaley Header and Amaley Footer.
- Scoped frontend CSS.
- Small vanilla JS mobile drawer.

### Safety

- Auto render mode is default OFF.
- No external library.
- No global CSS.
- WooCommerce and Elementor are not replaced.
