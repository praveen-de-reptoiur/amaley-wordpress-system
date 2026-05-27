# AMALEY GITHUB AUDIT NOTES — Amaley WordPress System

This file records GitHub source audit notes, plugin review status, non-blocking issues, future fixes, performance risks, and safe development reminders.

Purpose:

- Do not forget audit findings.
- Do not repeat mistakes in future chats.
- Keep Amaley source code clean, versioned, and safe.
- Protect the future fresh WordPress build from slow, messy, or conflict-heavy architecture.

---

## Current Audit Scope

Current audit focus:

    Amaley Templates v1.2.7

Source path:

    plugins/amaley-templates/

Current uploaded source status:

    Uploaded to GitHub
    Extracted source added
    ZIP file not uploaded
    desktop.ini files removed
    .gitignore added

---

## GitHub Cleanup Completed

Windows desktop.ini files were accidentally uploaded during manual source upload.

They were removed from:

    plugins/amaley-templates/assets/
    plugins/amaley-templates/assets/css/
    plugins/amaley-templates/assets/js/
    plugins/amaley-templates/includes/
    plugins/amaley-templates/includes/widgets/

Root .gitignore was added to prevent accidental upload of:

    desktop.ini
    .wpress
    .zip
    .sql
    backups
    logs
    wp-config.php
    uploads folder
    cache folders

Rule:

    GitHub must contain clean source code and documentation only.
    Heavy backups and ZIPs belong in Google Drive.

---

## Amaley Templates v1.2.7 Audit Status

### Main plugin file

File:

    plugins/amaley-templates/amaley-templates.php

Status:

    PASS

Confirmed:

- Plugin header is present.
- Plugin Name is Amaley Templates.
- Version is 1.2.7.
- Author is Praveen.
- Requires at least is 6.0.
- Requires PHP is 7.4.
- Text domain is amaley-templates.
- ABSPATH security guard is present.
- Constants are defined cleanly.
- Elementor is checked safely.
- WooCommerce warning is non-breaking.
- Plugin does not replace WooCommerce.
- Plugin does not hard-depend on ACF, CPT UI, JetEngine, or Smart Filters.
- Elementor loader runs only after Elementor is loaded.

Note:

    Plugin URI and Author URI use amaleycollective.com.
    This is acceptable because this is the intended future domain.

---

### Elementor loader

File:

    plugins/amaley-templates/includes/class-amaley-templates-elementor.php

Status:

    PASS

Confirmed:

- Elementor category is registered.
- Category name is Amaley Templates.
- Frontend CSS is registered.
- Frontend JS is registered.
- Widget files are included.
- Widgets are registered safely.

Registered widgets:

- Product Hero
- Origin Panel
- Info Tabs
- Trust Strip
- Shop Hero
- Shop Discovery
- Member Value Strip

Non-blocking note:

    Origin Panel exists as a separate widget.
    Info Tabs can also show origin content.
    Do not use both together in the same single product template unless duplicate origin display is intended.

---

### Settings file

File:

    plugins/amaley-templates/includes/class-amaley-templates-settings.php

Status:

    PASS

Confirmed:

- ABSPATH security guard is present.
- Settings defaults are centralized.
- Settings retrieval logic exists.
- Saved settings merge with defaults.
- Version/settings storage logic exists.
- No hard dependency on ACF, CPT UI, JetEngine, or Smart Filters was observed.
- No WooCommerce replacement logic observed.

---

### Admin file

File:

    plugins/amaley-templates/includes/class-amaley-templates-admin.php

Status:

    PASS

Confirmed:

- ABSPATH security guard is present.
- Admin class structure is present.
- Admin page logic is present.
- current_user_can check is present.
- check_admin_referer is present.
- wp_nonce_field is present.
- sanitize functions are used.
- escaping functions are visible.
- Admin settings/actions appear protected.

Non-blocking future improvement:

    Import/export JSON validation can be strengthened in a future version.
    Error messages can be made clearer for non-coders.

---

### Base widget helper

File:

    plugins/amaley-templates/includes/widgets/class-amaley-tpl-widget-base.php

Status:

    PASS

Confirmed:

- ABSPATH security guard is present.
- Product context is based on WooCommerce product.
- ACF is optional.
- get_field is used only if available.
- Post meta fallback exists.
- No fake product system created.
- No fake origin system created.
- Origin helper logic exists.
- Output appears generally escaped.
- WooCommerce remains the product source.

Important note:

    Current transition phase can support ACF fields.
    Future Amaley Core should eventually own these fields and relationships.

---

### Product Hero widget

File:

    plugins/amaley-templates/includes/widgets/class-amaley-tpl-product-hero.php

Status:

    PASS

Confirmed:

- Product data comes from WooCommerce.
- Product context is respected.
- Title output is escaped.
- Price output is handled safely.
- Short description is rendered safely.
- Add to cart uses WooCommerce standard function.
- Gallery uses WordPress attachment functions.
- Breadcrumb uses WooCommerce standard function.
- Wishlist is currently placeholder and not dangerous.
- Plugin does not replace WooCommerce cart logic.

---

### Info Tabs widget

File:

    plugins/amaley-templates/includes/widgets/class-amaley-tpl-info-tabs.php

Status:

    PASS

Confirmed:

- ABSPATH security guard is present.
- Elementor category is correct.
- Controls are section-wise.
- CSS selectors are scoped with WRAPPER and amaley-tpl classes.
- Product description uses safe render logic.
- Labels and field values use escaping.
- Reviews use WooCommerce standard reviews tab function.
- Origin content is embedded inside tab safely.
- Origin fallback message exists.

Non-blocking future improvements:

- Improve ARIA/accessibility for tabs.
- Add aria-selected, aria-controls, role tab, role tabpanel, and keyboard navigation.
- Improve How to Use formatting for line breaks if needed.
- Avoid using separate Origin Panel and Info Tabs Origin section together unless intentional.

---

### Frontend JS

File:

    plugins/amaley-templates/assets/js/amaley-templates.js

Status:

    PASS

Confirmed:

- JS is scoped to amaley-tpl widgets.
- No jQuery dependency.
- No external library dependency.
- Tab switching logic is simple and safe.
- Buy Now helper works inside Amaley product hero widget only.
- No obvious global conflict.

Non-blocking future improvement:

    Top comment says FRONTEND JS v1.0.0 while plugin version is 1.2.7.
    Update comment later to avoid confusion.

---

### Frontend CSS

File:

    plugins/amaley-templates/assets/css/amaley-templates.css

Status:

    PASS

Confirmed:

- CSS is scoped mostly under .amaley-tpl-*.
- No dangerous global body/html/h1/button/card overrides were observed.
- WooCommerce styling is scoped inside Amaley Product Hero.
- Shop Discovery styling is scoped inside Amaley Shop Discovery.
- Responsive breakpoints exist.
- Product Hero, Info Tabs, Origin Panel, Trust Strip, Shop Hero, Shop Discovery, variable product support, and Member Value Strip are included.
- No direct Freshen/Apus global override was observed.

Non-blocking future improvements:

- Top comment says FRONTEND CSS v1.2.3 while plugin version is 1.2.7.
- CSS contains layered historical blocks from v1.1.5, v1.1.6, v1.2.1, v1.2.2, v1.2.3, v1.2.6, and v1.2.7.
- Future cleanup should consolidate CSS without changing frontend behaviour.
- Do not refactor CSS blindly before staging test.

---

## Current Audit Pass List

Files checked and passed so far:

    plugins/amaley-templates/amaley-templates.php
    plugins/amaley-templates/includes/class-amaley-templates-elementor.php
    plugins/amaley-templates/includes/class-amaley-templates-settings.php
    plugins/amaley-templates/includes/class-amaley-templates-admin.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-widget-base.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-product-hero.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-info-tabs.php
    plugins/amaley-templates/assets/js/amaley-templates.js
    plugins/amaley-templates/assets/css/amaley-templates.css

---

## Pending Amaley Templates Audit

Still to review:

    plugins/amaley-templates/includes/widgets/class-amaley-tpl-origin-panel.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-trust-strip.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-shop-hero.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-shop-discovery.php
    plugins/amaley-templates/includes/widgets/class-amaley-tpl-member-value-strip.php
    plugins/amaley-templates/README-Amaley-Templates-v1.2.7.txt

Important next file:

    plugins/amaley-templates/includes/widgets/class-amaley-tpl-shop-discovery.php

Reason:

    This file connects Amaley Templates with Amaley Discovery Engine.
    It must be checked for dependency safety and conflict risk.

---

## Known Non-Blocking Issues

These are not urgent blockers but should be remembered.

### Version comments mismatch

JS comment says:

    v1.0.0

CSS top comment says:

    v1.2.3

Plugin version is:

    1.2.7

Future cleanup:

    Align comments with plugin version or remove specific version from asset comments.

### CSS historical layering

CSS contains multiple version sections.

This is acceptable for now because the current site may depend on this layered CSS.

Future cleanup:

    Consolidate CSS only after staging comparison.

Do not:

    Do not aggressively refactor CSS on live site.

### Origin duplication risk

Info Tabs can show origin section.

Origin Panel widget can also show origin section.

Rule:

    Do not use both on the same single product template unless duplicate origin display is intended.

### Tabs accessibility

Tabs work visually.

Future improvement:

    Add aria-selected, aria-controls, role tab, role tabpanel, and keyboard navigation.

### Admin import/export hardening

Admin actions have permissions and nonce protection.

Future improvement:

    Add stronger JSON validation and clearer error messages.

---

## Performance and Fresh Site Notes

Existing Amaley site is slow.

Future fresh WordPress build must be:

- Lightweight
- Smooth
- Mobile-first
- Responsive
- WooCommerce-safe
- Elementor-safe
- Cache-aware
- Minimal plugin dependency
- No heavy theme dependency
- No random utility plugin dependency
- No fake data
- No duplicate systems
- No unmanaged global CSS
- No plugin conflicts

Target direction:

    Fresh WordPress should not depend permanently on Freshen, ACF, CPT UI, JetEngine, Smart Filters, or random helper plugins.

Replacement direction:

    Amaley Core should manage data.
    Amaley Discovery Engine should manage filters/discovery.
    Amaley Templates should manage visual template widgets.
    Amaley Project Guard should manage health checks.
    Amaley Debug Toolkit should manage diagnostics.

---

## Fresh Build Safety Rule

Before moving anything to the fresh site:

1. Backup current live site.
2. Keep plugin ZIPs in Google Drive.
3. Keep source code in GitHub.
4. Test plugin syntax.
5. Test plugin activation on staging.
6. Test Elementor editor.
7. Test WooCommerce product page.
8. Test cart and checkout.
9. Test desktop, tablet, and mobile.
10. Update changelog.
11. Keep rollback plan ready.

---

## Hard Rule

If a plugin, template, or design change cannot be tested, debugged, and rolled back, it is not production-ready.
