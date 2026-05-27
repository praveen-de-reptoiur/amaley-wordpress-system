# AMALEY DISCOVERY ENGINE AUDIT NOTES — v1.3.5 no-CPT

Repository path:

    plugins/amaley-discovery-engine/

Source reviewed:

    amaley-discovery-engine-v1.3.5-no-cpt(1).zip

Audit status:

    INITIAL SOURCE AUDIT COMPLETE
    PASS WITH NON-BLOCKING FUTURE-HARDENING NOTES

---

## Uploaded Source Structure

Expected GitHub path:

    plugins/amaley-discovery-engine/

Uploaded structure:

    AMALEY-DISCOVERY-ENGINE-NOTES.md
    README.md
    amaley-discovery-engine.php
    assets/
      css/
        amaley-de-admin.css
        amaley-de-frontend.css
        placeholder.svg
      js/
        amaley-de-frontend.js
    includes/
      class-amaley-de-plugin.php
      class-amaley-de-query.php
      class-amaley-de-renderer.php
      class-amaley-de-settings.php
      elementor/
        class-amaley-de-elementor-base.php
        class-amaley-de-elementor-product-widget.php
        class-amaley-de-elementor-product-topbar-widget.php
        class-amaley-de-elementor-collection-widget.php
        class-amaley-de-elementor-collection-topbar-widget.php
        class-amaley-de-elementor-cluster-widget.php
        class-amaley-de-elementor-cluster-topbar-widget.php
        class-amaley-de-elementor-shg-widget.php
        class-amaley-de-elementor-shg-topbar-widget.php
        class-amaley-de-elementor-member-widget.php
        class-amaley-de-elementor-member-topbar-widget.php
        class-amaley-de-elementor-heading-widget.php
        class-amaley-de-elementor-text-widget.php
        class-amaley-de-elementor-icon-list-widget.php

---

## Fast Technical Checks

### PHP syntax

Status:

    PASS

Result:

    PHP syntax check passed for all plugin PHP files.

### CPT registration

Status:

    PASS

Result:

    No active register_post_type() or register_taxonomy() registration was found.

Confirmed:

    v1.3.5 intentionally disables plugin-owned CPT/taxonomy registration.
    This prevents duplicate admin menus for Collections, Clusters, SHGs and Members.

Important:

    Existing Amaley internal content should continue through CPT UI + ACF during the current transition stage.
    Future Amaley Core should eventually own this cleanly.

---

## Main Plugin File

File:

    plugins/amaley-discovery-engine/amaley-discovery-engine.php

Status:

    PASS

Confirmed:

- Plugin Name is Amaley Discovery Engine.
- Version is 1.3.5.
- Author is Praveen.
- Requires WordPress 6.0.
- Requires PHP 7.4.
- ABSPATH guard is present.
- Constants are defined.
- Required class files load from includes.
- Main bootstrap helper exists:
    - amaley_de_bootstrap()
- Plugin description clearly says it does not register default CPTs.

Non-blocking note:

    Plugin URI uses amaley.in.
    Current Amaley domain direction should be checked later.
    Not a functional blocker.

---

## Plugin Bootstrap Class

File:

    includes/class-amaley-de-plugin.php

Status:

    PASS

Confirmed:

- Singleton bootstrap pattern exists.
- Settings, query and renderer classes are initialized.
- No plugin-owned CPT registration is active.
- Frontend assets are registered safely.
- Admin asset loads only on Amaley Discovery admin page.
- Shortcode exists:
    - [amaley_discovery]
- AJAX filter action exists for logged-in and guest users.
- AJAX nonce is created and checked.
- Elementor widgets are registered after Elementor is loaded.
- Elementor category is registered.

AJAX safety:

    check_ajax_referer() is used.
    User inputs are sanitized before filters are passed to renderer.

Non-blocking note:

    AJAX settings JSON is accepted from frontend data attribute.
    Renderer normalizes/sanitizes settings again, which is good.
    Keep this normalization layer protected in future updates.

---

## Settings / Admin / Import Export

File:

    includes/class-amaley-de-settings.php

Status:

    PASS WITH FUTURE-HARDENING NOTES

Confirmed:

- Settings defaults are centralized.
- register_cpts default is no.
- Optional CPT registration method exists only as no-op for backward compatibility.
- Admin menu uses manage_options capability.
- Admin actions are protected with current_user_can and nonce.
- Settings are sanitized before save.
- JSON import/export exists.
- Rollback backup logic exists before import/settings changes.
- Runtime CSS import has scoping validation.
- Runtime CSS blocks obvious dangerous patterns such as script-like CSS, javascript:, expression(), behavior:, and @import.

Future-hardening notes:

- Import file handling should later add file-size/type guard.
- Runtime CSS validation is useful but should still be used carefully.
- Settings page title/comment still mentions CPT registration in places; future wording can be cleaned so non-coders are not confused.

---

## Query Layer

File:

    includes/class-amaley-de-query.php

Status:

    PASS

Confirmed:

- Product query uses WP_Query.
- Product status is publish.
- per_page is capped to 96.
- Page number is absint and minimum 1.
- Search is sanitized.
- Category/tag/attribute filters are sanitized.
- Price values are float-casted.
- Stock and sort values are sanitized.
- Product include/exclude IDs are absint-cleaned.
- Tax include/exclude slugs are sanitized.
- Generic CPT query falls back safely if post type does not exist.
- Generic CPT query does not create CPTs.

Non-blocking note:

    Default CPT names still mention old plugin-owned names as fallback:
        amaley_collection
        amaley_cluster
        amaley_shg
        amaley_member

    This is okay only if admin settings are mapped to current CPT UI post types.
    Future Amaley Core should standardize these names.

---

## Renderer

File:

    includes/class-amaley-de-renderer.php

Status:

    PASS WITH IMPORTANT FUTURE-HARDENING NOTES

Confirmed:

- Frontend assets are enqueued through plugin bootstrap.
- Settings are normalized before use.
- Public settings are limited before being placed in data attribute.
- Root wrapper is scoped:
    - .amaley-discovery-engine-v1
- Custom wrapper class is sanitized.
- Style variables are escaped.
- Heading, labels, filters, buttons and term values are escaped.
- WooCommerce price HTML uses wp_kses_post.
- Elementor template card rendering has fallback.
- Global post/product context is restored after Elementor card render.
- Empty state exists.
- Pagination exists.
- Active chips are escaped.
- Term select values are escaped.
- Native marketplace product card output is mostly escaped.

Important compatibility note:

    Amaley Templates Shop Discovery currently exposes options such as:
        Right Sidebar
        Hidden filter mode

    Discovery Engine renderer currently normalizes filter position to:
        left
        top

    Discovery Engine renderer currently normalizes filter mode to:
        visible
        drawer
        compact

    Result:
        If right or hidden is selected from another widget, renderer may fallback instead of honoring that option.

    Current approved direction does not require right/hidden:
        Desktop: visible/full filter
        Tablet: compact inline
        Phone: compact inline

    So this is not a blocker now, but future controls should be aligned.

Future-hardening notes:

- Fully align filter position/mode option lists between Amaley Templates and Discovery Engine.
- Renderer output includes intentional unescaped internal HTML methods. This is acceptable only because those methods escape their own fields.
- Elementor template card output is raw Elementor-rendered HTML by design.
- Keep this audited whenever Elementor card render logic changes.

---

## Elementor Widgets

Folder:

    includes/elementor/

Status:

    PASS

Registered discovery widgets:

- Amaley Product Discovery
- Amaley Product Topbar Discovery
- Amaley Collection Discovery
- Amaley Collection Topbar Discovery
- Amaley Cluster Discovery
- Amaley Cluster Topbar Discovery
- Amaley SHG Discovery
- Amaley SHG Topbar Discovery
- Amaley Member Discovery
- Amaley Member Topbar Discovery

Additional content widgets:

- Amaley heading widget
- Amaley text widget
- Amaley icon list widget

Confirmed:

- Elementor category is scoped:
    - Amaley Discovery Engine
- Base widget provides shared controls.
- Assets are registered through plugin bootstrap.
- Render passes settings to renderer.
- Topbar widgets override defaults without duplicating render logic.

Non-blocking copy note:

    SHG widget default heading uses “Women-led SHGs”.
    Future Amaley copy direction prefers terms like:
        women collectives
        producer groups
        SHG groups
        community-rooted producers

    Update wording later if needed.

---

## Frontend JavaScript

File:

    assets/js/amaley-de-frontend.js

Status:

    PASS

Confirmed:

- Vanilla JavaScript.
- No jQuery dependency.
- Scoped to data-ade-root.
- AJAX filter submit handled.
- Pagination handled.
- Quick pills handled.
- Reset handled.
- Mobile filter open/close handled.
- URL query updates handled through replaceState.
- Fallback to form submit exists if AJAX fails.

Future-hardening notes:

- Add debounce for search if live search is added later.
- Add loading/error UI improvements later.
- Make sure multiple widgets on one page are tested.

---

## Frontend CSS

File:

    assets/css/amaley-de-frontend.css

Status:

    PASS WITH NON-BLOCKING VERSION NOTE

Confirmed:

- CSS is scoped mainly to:
    - .amaley-discovery-engine-v1
    - .amaley-de-
    - .amaley-native-product-card-v1 inside discovery root
- No direct global html/body override was observed.
- CSS includes responsive layout support.
- CSS includes marketplace card styling.
- CSS includes topbar/mobile filter behavior.
- CSS includes scoped Elementor template card support.

Non-blocking note:

    CSS header says Version: 1.3.2
    Plugin version is 1.3.5

Future cleanup:

    Update CSS header comment to 1.3.5 or remove asset-specific version number.

---

## Admin CSS

File:

    assets/css/amaley-de-admin.css

Status:

    PASS

Confirmed:

- CSS is scoped to:
    - .amaley-de-admin-wrap
    - .amaley-de-admin-card
- No frontend/global risk visible.

---

## Compatibility With Amaley Templates

Status:

    MOSTLY COMPATIBLE

Confirmed:

- Amaley Templates Shop Discovery checks for:
    - amaley_de_bootstrap()
    - Amaley_DE_Renderer
    - Amaley_DE_Query

These exist in Discovery Engine v1.3.5.

Compatibility note:

    Amaley Templates and Discovery Engine should align filter options:
        right sidebar
        hidden filter mode

Current approved mobile/tablet direction does not depend on these, so not blocking.

---

## Key Non-Blocking Issues To Remember

1. CSS comment version mismatch:
    - CSS says 1.3.2
    - Plugin says 1.3.5

2. Renderer supports left/top filter position only:
    - Templates may expose right option.

3. Renderer supports visible/drawer/compact filter modes only:
    - Templates may expose hidden option.

4. Default old CPT fallback names still exist:
    - This is okay only if admin settings are mapped correctly to current CPT UI post types.

5. Elementor template output is raw Elementor HTML:
    - Acceptable by design, but needs frontend testing.

6. Multiple widgets on one page need testing:
    - AJAX, URL parameters, sort and quick pills should be checked.

---

## Staging Test Checklist

Before using on live/fresh site:

1. Activate plugin on staging.
2. Confirm no duplicate CPT/admin menus appear.
3. Confirm admin page opens.
4. Confirm Elementor widgets appear under Amaley Discovery Engine.
5. Add Product Discovery widget to a test page.
6. Test category filter.
7. Test search.
8. Test price filter.
9. Test stock filter.
10. Test product attribute filters.
11. Test sorting.
12. Test pagination.
13. Test quick category pills.
14. Test tablet compact inline filter.
15. Test phone compact inline filter.
16. Test Elementor template card renderer.
17. Test native marketplace card renderer.
18. Test with Amaley Templates Shop Discovery widget.
19. Test cart/add-to-cart from product cards.
20. Test page speed and mobile layout.

---

## Final Source Audit Status

Amaley Discovery Engine v1.3.5 no-CPT is acceptable as GitHub source.

No immediate fatal source-level blocker was identified.

Do not push to live without staging testing.
