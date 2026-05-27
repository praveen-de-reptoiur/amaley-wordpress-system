# AMALEY WIDGET, TEMPLATE AND PERFORMANCE FULL CONTROL RULE

Date locked: 2026-05-27  
Project: Amaley WordPress System  
Scope: Fresh WordPress / staging build only  
Status: Primary rule for all future Amaley components

## Locked Rule

From this point onward, every new Amaley widget, Template Studio module, section, popup/form trigger, single template, archive/listing template, card/grid/timeline widget, form module, addon, or reusable component must be built with a full professional control system.

The approved control depth reference is the Hero widget style: clear, section-wise, tab-wise, editable, responsive, safe for non-coders, and lightweight.

No future Amaley component should be treated as production-ready if it is fixed, half-controlled, desktop-only, heavy, or difficult for a non-coder to manage.

---

## 1. Non-Coder Full Control Rule

Every future Amaley component must be manageable by a non-coder or beginner.

The user should be able to:

- Add content
- Delete content
- Edit text
- Replace images/icons
- Change colors
- Change typography
- Change spacing
- Change margins and padding
- Change layout
- Change columns
- Change card count/items through repeaters
- Control visibility
- Adjust desktop/tablet/mobile settings
- Manage buttons and links
- Manage badges/tags/eyebrows
- Manage images/icons without editing code

Normal content/design changes must not require code editing.

---

## 2. Section-Wise and Tab-Wise Control Rule

All controls must be organized professionally.

Controls must not be mixed randomly.

Each visual part must have its own section or tab.

Example structure:

### Content Tab

- Section content
- Eyebrow / badge text
- Heading text
- Description text
- Cards / repeater items
- Image / icon selection
- Button labels and links
- Visibility toggles
- Empty-state text where needed

### Style Tab

Controls must be section-wise.

Required style sections where relevant:

1. Section / Background
2. Container / Wrapper
3. Eyebrow / Badge
4. Heading
5. Description / Body Text
6. Cards / Items
7. Icons / Images
8. Buttons / Links
9. Layout / Columns
10. Spacing / Gap / Padding
11. Border / Radius / Shadow
12. Mobile / Tablet responsive behaviour
13. Empty State
14. Pagination / Filters / Chips where relevant

### Advanced / Behaviour Tab where needed

- Visibility toggles
- Animation enable/disable
- Sticky behaviour
- Popup trigger behaviour
- Mobile collapse/drawer behaviour
- Query/source selection where relevant
- Safe fallback text
- Import/export or preset selection where useful

---

## 3. Heading Control Example

If a component has a heading, there must be a proper Heading control section.

Heading controls should include where relevant:

- HTML tag selection
- Typography
- Font size
- Font weight
- Line height
- Letter spacing
- Text transform
- Text color
- Alignment
- Margin
- Padding
- Max width
- Responsive desktop/tablet/mobile size
- Responsive alignment
- Optional highlight/accent controls where design needs it

This same logic applies to every other element.

If there is a badge, create a Badge control section.  
If there is a card, create a Card control section.  
If there is a button, create a Button control section.  
If there is an image, create an Image control section.  
If there is a layout, create a Layout control section.

---

## 4. Mandatory Control Groups

Every new widget or module must include these groups where relevant:

1. Section / Background
2. Container
3. Heading
4. Eyebrow / Badge
5. Description
6. Cards / Items
7. Icons / Images
8. Buttons
9. Spacing / Gap / Padding
10. Border / Radius / Shadow
11. Layout / Columns
12. Desktop / Tablet / Mobile responsive controls
13. Visibility toggles where needed
14. Repeater controls where cards, steps, tags, features, timeline items, slides, or list items are used

---

## 5. Repeater Rule

Wherever cards, steps, tags, features, highlights, timeline points, gallery items, tabs, FAQs, trust points, statistics, or list items are used, repeater controls must be provided.

Repeater items should allow:

- Add item
- Delete item
- Reorder item
- Edit item title
- Edit item description
- Select image/icon where relevant
- Set link/button where relevant
- Toggle item visibility where relevant

Hardcoded card/item counts are not acceptable when the component is meant to be edited by non-coders.

---

## 6. Mobile-First Responsive Rule

Every component must be designed mobile-first.

Responsive controls must be available where layout can change.

Minimum responsive checks:

- 360px
- 390px
- 430px
- 768px
- 1024px
- 1366px

A desktop-only layout is not ready.

Responsive controls should include where relevant:

- Columns per device
- Gap per device
- Padding per device
- Margin per device
- Font size per device
- Alignment per device
- Image ratio/height per device
- Button width per device
- Card stacking behaviour
- Hide/show controls per device where useful

---

## 7. Lightweight Performance Rule

The Amaley site must remain light, fast, and smooth.

It should load properly even in low-network areas.

Every new component must be built with performance in mind.

Required performance rules:

- No unnecessary external libraries
- No heavy animation libraries unless explicitly approved
- No frontend-heavy debug scans
- No large CSS/JS loaded globally
- Load assets only where required
- Enqueue widget/module assets conditionally where practical
- Use scoped CSS
- Use small, clean JavaScript
- Prefer vanilla JavaScript where possible
- Avoid duplicate CSS and JS
- Avoid render-blocking scripts where possible
- Avoid large DOM structures when simple markup is enough
- Avoid unnecessary AJAX calls
- Cap query limits and repeater output where needed
- Use lazy loading for images where appropriate
- Use optimized image sizes
- Avoid background videos unless explicitly approved
- Avoid auto-loading heavy sliders/carousels unless required
- Keep admin diagnostics out of the public frontend
- Keep Project Guard and Debug Toolkit admin-only/lightweight
- Test on mobile and low-bandwidth conditions before approval

If a component looks good but makes the site heavy, it is not ready.

---

## 8. CSS Safety Rule

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

No CSS should be added casually.

Every CSS block must answer:

- Which component does this style control?
- Is it scoped?
- Can it affect another widget?
- Is it mobile-safe?
- Is it necessary?
- Can the same thing be controlled through Elementor settings instead?

---

## 9. PHP Naming and Safety Rule

All PHP classes and functions must use clear Amaley prefixes.

Allowed prefix patterns:

- `Amaley_Tpl_` / `amaley_tpl_`
- `Amaley_Discovery_` / `amaley_discovery_`
- `Amaley_Core_` / `amaley_core_`
- `Amaley_Guard_` / `amaley_guard_`
- `Amaley_Debug_` / `amaley_debug_`

Every plugin must include:

- Direct-access protection
- Capability checks where needed
- Sanitization
- Escaping
- Nonce checks for admin actions
- Safe fallbacks
- Version constant
- Clear README
- Changelog or version notes where needed

---

## 10. WooCommerce Boundary Rule

WooCommerce remains the commerce engine.

WooCommerce handles:

- Products
- Prices
- Stock
- Variations
- Cart
- Checkout
- Orders
- Reviews

Custom Amaley plugins must support WooCommerce, not replace it.

Any product card, quick view, listing, archive, cart-related button, or checkout-adjacent feature must be tested with WooCommerce flows.

---

## 11. Elementor Boundary Rule

Elementor remains the visual builder layer.

Custom Amaley plugins may provide Elementor-native widgets, but must not break:

- Elementor editor loading
- Elementor template preview
- Widget registration
- Widget categories
- Responsive controls
- Global styles
- CSS regeneration
- Existing templates

Every new Elementor widget must use clear categories, clear labels, and clean controls.

---

## 12. Conflict-Free Rule

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

---

## 13. Data Integrity Rule

Do not create fake Cluster, SHG, Producer, or origin data.

Data must be:

- Real
- Traceable
- Migration-safe
- Easy to audit
- Connected correctly
- Safe for future Amaley Core

---

## 14. Approval Gate

A new Amaley widget/module/template/component is not ready unless it answers:

1. Can a non-coder edit the content?
2. Can a non-coder change the style?
3. Can a non-coder adjust spacing/layout?
4. Can a non-coder manage responsive behaviour?
5. Are repeatable items controlled through repeaters where needed?
6. Are controls organized section-wise and tab-wise?
7. Is the CSS scoped?
8. Is the JavaScript lightweight?
9. Is it Elementor-safe?
10. Is it WooCommerce-safe where relevant?
11. Is it mobile-first?
12. Is it light enough for low-network users?
13. Can it be disabled safely?
14. Can it be rolled back safely?
15. Is it documented?

---

## Final Rule

If a new Amaley component does not provide full non-coder control for content, style, layout, responsiveness, visibility, repeatable items, and safe performance where relevant, it is not production-ready.

If it creates conflict, breaks mobile layout, leaks CSS, slows the site, or requires code editing for normal changes, it is not acceptable.
