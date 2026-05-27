# AMALEY PRIMARY BUILD RULES

Date locked: 2026-05-27  
Project: Amaley WordPress System  
Scope: Fresh WordPress / staging build

These rules apply before creating or changing any Amaley plugin, Elementor template, widget, shortcode, page section, CSS, JavaScript, WooCommerce flow, import, export, migration step, or admin setting.

## 1. Fresh / staging build only

All new development must happen on the fresh or staging Amaley WordPress setup.

The existing live Amaley site is only a reference and export source for products, media, content, templates, plugin list, backups, and migration evidence.

## 2. No conflict rule

Every new item must be checked for possible conflict with:

- WordPress
- PHP
- WooCommerce
- Elementor
- Elementor Pro
- Amaley Templates
- Amaley Discovery Engine
- Future Amaley Core
- Future Amaley Project Guard
- Future Amaley Debug Toolkit
- Active theme
- Existing templates
- Existing widgets
- Existing shortcodes
- Product pages
- Shop pages
- Cart and checkout
- Cache and generated CSS

No change should be treated as ready if conflict risk is unclear.

## 3. Mobile-first responsive rule

Every new item must be designed and tested mobile-first.

Minimum responsive checks:

- 360px
- 390px
- 430px
- 768px
- 1024px
- 1366px

A desktop-only layout is not ready.

## 4. CSS safety rule

CSS must be scoped and predictable.

Use Amaley prefixes such as:

- `.amaley-tpl-`
- `.amaley-discovery-`
- `.amaley-core-`
- `.amaley-guard-`
- `.amaley-debug-`

Avoid broad global selectors in custom Amaley work, including:

- `body`
- `button`
- `h1`
- `.card`
- `.elementor-widget`

Custom CSS must not disturb theme, Elementor, WooCommerce, or other plugin styling.

## 5. PHP naming and safety rule

All PHP classes and functions must use clear Amaley prefixes.

Allowed prefix patterns:

- `Amaley_Tpl_` / `amaley_tpl_`
- `Amaley_Discovery_` / `amaley_discovery_`
- `Amaley_Core_` / `amaley_core_`
- `Amaley_Guard_` / `amaley_guard_`
- `Amaley_Debug_` / `amaley_debug_`

Every plugin must include direct-access protection, capability checks where needed, sanitization, escaping, and nonce checks for admin actions.

## 6. WooCommerce boundary rule

WooCommerce remains the commerce engine.

WooCommerce handles products, prices, stock, variations, cart, checkout, orders, and reviews.

Custom Amaley plugins must support WooCommerce, not replace it.

## 7. Elementor boundary rule

Elementor remains the visual builder layer.

Custom Amaley plugins may provide Elementor-native widgets, but must not break Elementor editor loading, template preview, widget registration, or responsive controls.

## 8. Non-coder control rule

Every future Amaley plugin, widget, template system, admin panel, or editable module must be designed so a non-coder or beginner can control it safely.

Required direction:

- Clear admin settings
- Elementor-native controls where useful
- Section-wise controls
- Simple labels
- Safe defaults
- Import/export where useful
- Restore or rollback notes where useful
- No hidden critical settings
- No confusing mixed controls
- No code editing required for normal content/design changes

A future developer may write the code, but day-to-day control must be possible for a non-coder.

## 9. Data integrity rule

Do not create fake Cluster, SHG, Producer, or origin data.

Data must be real, traceable, and migration-safe.

## 10. Testing gate

Before approval, every change must answer:

1. What changed?
2. Which file, plugin, widget, or template changed?
3. Which dependency may be affected?
4. Is there any likely conflict?
5. Does it work on mobile, tablet, and desktop?
6. Does WooCommerce product, cart, and checkout remain safe?
7. Can the change be disabled safely?
8. Can it be rolled back?
9. Is it documented?
10. Can a non-coder manage the relevant settings after delivery?

## Final rule

If a future Amaley change cannot be checked, debugged, documented, tested, rolled back, and managed safely by a non-coder where relevant, it is not production-ready.
