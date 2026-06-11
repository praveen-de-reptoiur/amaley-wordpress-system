Amaley Blog System v1.4.7 - Audit Safe Baseline

Source: user-uploaded plugin ZIP audited and repacked.

What changed:
- Version bumped to 1.4.7.
- WordPress upload ZIP structure fixed to one plugin folder: amaley-blog-system/.
- Removed old historical README clutter from plugin package.
- Removed obsolete old single CSS selectors (.amaley-blog-single-*, old .abs1-layout*) no longer registered by current accepted single widgets.
- Frontend CSS/JS now loads only on assigned Blog archive page, assigned Blog detail template page, routed single posts, and Elementor edit/preview mode. This reduces global site/theme/plugin conflict risk and page weight.
- Accepted Hero and Layout widgets/design were not changed.
- Archive widgets/design/JS were not changed.

Checks performed:
- PHP lint clean.
- JS syntax clean.
- CSS brace balance clean.
- ZIP integrity clean.
- No eval/base64_decode/shell_exec/passthru/system/curl/wp_remote calls found.
- No render-time inline CSS injection in single widgets.
- No render_type=template in single controls.
- Root folder validated: amaley-blog-system/ only.

Notes:
- Some scoped !important rules remain only in archive/mobile drawer/view-toggle/hidden-state code to protect already accepted archive behaviour. They are scoped to .amaley-blog-* and do not target global theme selectors.
