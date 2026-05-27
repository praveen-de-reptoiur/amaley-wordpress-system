# Amaley Site Shell v1.0.0 Architecture

## Plugin Identity

- Name: Amaley Site Shell
- Slug: amaley-site-shell
- Author: Praveen
- Version: 1.0.0

## Role

The plugin manages the Amaley website shell:

- Header
- Footer
- Mobile header
- Mobile drawer
- Navigation
- Announcement strip
- CTA controls
- Footer contact and links

## Render Modes

1. Shortcode mode:
   - `[amaley_site_header]`
   - `[amaley_site_footer]`
2. Elementor widget mode:
   - Amaley Header
   - Amaley Footer
3. Optional auto render mode:
   - Header via `wp_body_open`
   - Footer via `wp_footer`
   - Default OFF

## Compatibility

- Does not replace WooCommerce.
- Does not replace Elementor.
- Does not permanently depend on Freshen / Apus.
- Uses scoped CSS only.
- Uses minimal vanilla JS only.

## Prefixes

- CSS: `.amaley-shell-`
- PHP classes: `Amaley_Shell_`
- PHP functions/hooks/options: `amaley_shell_`

## Testing Gate

Before production use, test:

- Activation
- Admin settings save
- Header shortcode
- Footer shortcode
- Elementor header widget
- Elementor footer widget
- Desktop layout
- Tablet layout
- Mobile drawer open/close
- WooCommerce product/cart/checkout unaffected
