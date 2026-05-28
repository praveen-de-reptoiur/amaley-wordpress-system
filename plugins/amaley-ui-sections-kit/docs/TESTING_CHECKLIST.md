# Testing Checklist — Amaley UI Sections Kit v0.1.3

## Activation

- [ ] Upload ZIP on staging/local first
- [ ] Activate plugin without fatal error
- [ ] Confirm no PHP warnings/notices in debug mode
- [ ] Confirm plugin can deactivate cleanly

## Shortcode Rendering

- [ ] `[amaley_section_heading]` renders heading, label, accent and description
- [ ] `[amaley_button]` renders primary, secondary, outline, text and pill variants
- [ ] `[amaley_button_group]` stacks correctly on mobile
- [ ] `[amaley_trust_item]` renders icons without external library
- [ ] `[amaley_brand_promise]` renders items without overflow
- [ ] `[amaley_cta_band]` renders dark and warm tones
- [ ] `[amaley_empty_state]` renders safely with missing fields

## Responsiveness

Test widths:

- [ ] 360px
- [ ] 390px
- [ ] 430px
- [ ] 768px
- [ ] 1024px
- [ ] 1366px

## Conflict Safety

- [ ] No global body styling changed
- [ ] No Elementor widget styling changed
- [ ] No WooCommerce product/card styling changed
- [ ] No Freshen theme header/footer styling changed
- [ ] No horizontal overflow on mobile
- [ ] No frontend JavaScript loaded by this plugin

## Visual Checks

- [ ] Buttons have minimum 44px touch target
- [ ] Headings are not oversized on mobile
- [ ] CTA band remains readable
- [ ] Brand promise strip remains clean on mobile
- [ ] Empty state looks intentional, not broken
