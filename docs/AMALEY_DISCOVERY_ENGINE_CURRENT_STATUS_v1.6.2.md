# Amaley Discovery Engine — Current Status v1.6.2

## Current lock

```text
Amaley Discovery Engine v1.6.2 — Clean Stable Baseline
```

Source path:

```text
plugins/amaley-discovery-engine/
```

## Active Elementor widgets

Only these widgets are part of the current active baseline:

```text
1. Amaley Collection Product Filter
2. Amaley Shop Hero
3. Amaley Shop Strip
4. Amaley Universal CTA
5. Amaley Contact Hero
6. Amaley Contact Info Cards
7. Amaley Contact Map Section
8. Amaley Contact Form CTA
```

## Retired / removed legacy widgets

The following old widgets are not part of the current baseline and must not be restored:

```text
Amaley Heading
Amaley Text
Amaley Icon List
Amaley Product Discovery
Amaley Collection Discovery
Amaley Cluster Discovery
Amaley SHG Discovery
Amaley Member Discovery
Product Topbar Discovery
Collection Topbar Discovery
Cluster Topbar Discovery
SHG Topbar Discovery
Member Topbar Discovery
```

Reason for removal:

```text
- Avoid old CSS conflicts.
- Avoid accidental old widget registration.
- Avoid duplicate Elementor widget confusion.
- Avoid old product/filter query calls.
- Keep the plugin lightweight and future-safe.
```

## Current accepted capabilities

### Amaley Collection Product Filter

- Product listing and filtering widget.
- Uses current product filter architecture with AJAX filtering, sort and pagination.
- Supports WooCommerce category/tag/stock filters and product attribute filters used for Amaley source/collection discovery.
- Mobile/tablet responsive toolbar supports Filter + Sort row.
- Mobile drawer works in frontend and Elementor preview.
- Quick pills/category chips can be hidden device-wise.
- Product card visuals are not owned by Discovery Engine; accepted OG Product Card rendering stays with Amaley Core.

### Amaley Shop Hero

- Reusable shop/page hero widget.
- Full Elementor-native controls.
- Content, layout, alignment, typography, spacing, background, pattern/visual and device visibility controls.

### Amaley Shop Strip

- Reusable strip/trust/navigation widget.
- Full Elementor-native layout and visibility controls.
- Supports mobile stack/scroll/grid style behaviour.

### Amaley Universal CTA

- Reusable CTA widget for shop, product, cluster, SHG, blog and general pages.
- Supports kicker, heading, description, buttons, visual/pattern and trust points.
- Full controls for layout, spacing, colors, typography, alignment, buttons and device visibility.

### Amaley Contact Hero

- Contact page hero widget.
- Full responsive controls.

### Amaley Contact Info Cards

- Contact detail cards.
- Supports multiple phone/email/address/contact lines.
- Auto-linking for phone, email and URL-style lines.
- Full card layout and responsive controls.

### Amaley Contact Map Section

- Contact location/map widget.
- Supports address auto-map, Google embed iframe, fallback image and shortcode mode.
- Full content panel, contact details, map panel and responsive layout controls.

### Amaley Contact Form CTA

- Contact form CTA widget.
- Supports built-in demo/mailto form, shortcode mode for Contact Form 7/WPForms/Fluent Forms, and custom safe embed mode.
- Full panel, form, text, trust point and button controls.

## Safety lock

```text
No WooCommerce cart/checkout/order logic changes.
No product data changes.
No product image/gallery changes.
No product-origin mapping changes.
No header/footer source changes.
No broad global CSS.
No legacy Elementor widget registration.
No old Discovery/Product/Topbar widget files as future baseline.
No ZIP/media/screenshots/videos committed to GitHub.
```

## Current source responsibility split

```text
Amaley Core
→ Owns data backbone, origin mapping, CPTs and accepted OG card rendering.

Amaley Discovery Engine
→ Owns current shop/filter/CTA/contact Elementor widgets and product discovery UI.

WooCommerce
→ Owns products, prices, stock, cart, checkout, orders and reviews.
```

## Future development rule

Every future Discovery Engine update must start from:

```text
plugins/amaley-discovery-engine/ at v1.6.2 clean stable
```

Do not use these as current baselines:

```text
v1.4.x legacy Product Discovery flow
v1.5.x interim patch files
old Heading/Text/Icon/Discovery/Topbar widgets
old ZIPs copied into GitHub
```

## QA checklist after any future update

```text
1. Plugin activates without fatal error.
2. Elementor search shows only current approved widgets.
3. Product filter works on desktop.
4. Product filter drawer works on tablet/mobile.
5. Sort and pagination work after filter apply/reset.
6. Shop Hero and Shop Strip controls open cleanly.
7. Universal CTA controls open cleanly.
8. Contact widgets are responsive on phone first.
9. No old Discovery/Topbar widgets reappear.
10. Docs remain aligned with current source version.
```
