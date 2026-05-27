# Build Notes — Phase 1 MVP

## Build Decision

This build intentionally stays small. The objective is to create Amaley's reusable UI foundation before product cards or origin sections are attempted.

## Architecture

```text
amaley-ui-sections-kit/
  amaley-ui-sections-kit.php
  includes/
    class-amaley-ui-sections-kit.php
    class-amaley-ui-token-registry.php
    class-amaley-ui-shortcodes.php
    helpers/
      class-amaley-ui-helpers.php
    renderers/
      class-amaley-ui-section-container.php
      class-amaley-ui-section-heading.php
      class-amaley-ui-button.php
      class-amaley-ui-button-group.php
      class-amaley-ui-trust-item.php
      class-amaley-ui-brand-promise.php
      class-amaley-ui-cta-band.php
      class-amaley-ui-empty-state.php
  assets/css/amaley-ui-sections-kit.css
  docs/
```

## Asset Loading

The plugin enqueues one small scoped CSS file on the frontend. No JavaScript is loaded.

A developer can disable automatic CSS loading with:

```php
add_filter( 'amaley_ui_sections_kit_enqueue_frontend_assets', '__return_false' );
```

Do this only when the CSS is manually bundled or conditionally enqueued elsewhere.

## Strict Boundary

This plugin does not create or manage Amaley Core data, origin data, SHG records, WooCommerce product data, checkout, cart, filters, search or headers/footers.

## Next Build Gate

Next approved phase should be product display components only after this foundation is tested.
