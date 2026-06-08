## 0.6.9.3 - Real Form Embed Safe Fix

- Improved Gifting Enquiry Section real form embed mode for Contact Form 7, WPForms, Elementor forms, and safe custom form HTML.
- Added controlled safe allow-list for form/input/select/textarea/label/button markup after shortcode rendering.
- Kept dummy fillable form as the fallback when no real shortcode/HTML is provided.
- Refined form CSS so hidden, checkbox, radio, and file inputs are not accidentally styled like text fields.
- No Core, Discovery, WooCommerce, Header/Footer, product data, or origin mapping changes.

## 0.6.9.2 - Safe Gifting Enquiry Dummy Form Fix

- Made the Gifting Enquiry dummy form fields fillable for preview/testing.
- Kept dummy submit non-submitting; real submissions should use Shortcode / HTML Form mode.
- No Core, Discovery, WooCommerce, Header/Footer, product data, or origin mapping changes.

# Changelog

## 0.6.4.1
- Completed Elementor control system for `Amaley Pages Hero Other` across all active styles except the intentionally removed Style 4.
- Kept accepted Style 10 as the approved base and avoided redesigning it.
- Added selected-style-only control panels so users do not see unrelated mixed controls for other variations.
- Added device-wise visibility controls for remaining styles.
- Added layout, typography, image/media, editorial note, stats/proof, statement pill, intent card, right panel and button control groups according to each variation's structure.
- Added stats value/label spacing controls: `Value and Label Gap` and `Label Top Spacing Fallback`.
- Added CSS support for remaining Pages Hero Other variations using scoped `.amaley-pages-hero-other--style-*` selectors.
- Confirmed staging status: Style 10 working, remaining styles controls visible, stats gap fix working, CSS support applied, plugin version visible as 0.6.4.1.
- No WooCommerce, cart, checkout, Discovery Engine, Amaley Core, Amaley Templates, header/footer, product data, origin mapping, uploaded photos or database schema changes.

## 0.6.3
- Added and tested Style 10 full control pilot for `Amaley Pages Hero Other`.
- Added single `Style 10 — Visibility (Device Wise)` panel after removing duplicated show/hide visibility panels.
- Added control-friendly renderer classes for stats, editorial note, side panel, intent card and statement pills.
- Added scoped Style 10 CSS safety support.
- Bumped plugin version to 0.6.3 after staging test.
- No other plugin area changed.

## 0.6.1
- Performance and asset-loading cleanup only. No new visual widget and no redesign.
- Frontend assets are now registered first and conditionally enqueued based on detected shortcode/Elementor widget usage.
- Base UI CSS loads only when Amaley UI shortcodes/widgets are detected on the current page.
- Home Hero V6 CSS and counter JS load only when `[amaley_home_hero_v6]` or the Home Hero V6 Elementor widget is present.
- Pages Hero Other CSS loads only when `[amaley_pages_hero_other]` or the Pages Hero Other Elementor widget is present.
- Elementor editor/preview intentionally loads all UI Sections Kit assets for safe editing.
- Added Elementor asset dependency methods for Home Hero V6, Pages Hero Other and Page Trust Strip widgets.
- Added developer filters for forced asset handles where dynamic builder output is rendered late.
- No Discovery Engine, Amaley Core, Amaley Templates, Site Shell, WooCommerce cart/checkout or accepted design output changes.

## 0.6.0
- Pages Hero Other final control/layout fix.
- Style dropdown labels now clearly show numbers: 01, 02, 03, etc.
- Added Image / Media Side control for all image-based styles, not only Style 6.
- Editorial image styles now correctly switch image left/right from Elementor.
- Fixed image gaps at browser zoom by enforcing no-gap media wrappers and absolute cover images.
- Kept Home Hero V6, Page Trust Strip, Discovery Engine, Core, Templates, Site Shell and WooCommerce untouched.

## 0.5.9
- Removed Style 4 Journal / Image Split from Pages Hero Other.
- Removed Style 2 bottom feature strip; Style 2 now uses clean text and stats only.
- Added Style 9, Style 10 and Style 11 as distinct premium editorial/image hero variations.
- Added Style 12 and Style 13 as centered/minimal statement variations.
- Kept style-specific Elementor controls and image controls scoped to relevant styles.
- No Discovery Engine, Amaley Core, Templates, Site Shell or WooCommerce cart/checkout changes.

## 0.5.8
- Pages Hero Other controls audit/fix.
- Added typography controls for kicker, title, accent, description, buttons, stats, feature strip, side card and image-card copy where applicable.
- Added working image fit, focus, height, border radius, border, shadow and hover-zoom controls for image-based styles.
- Kept controls conditionally visible by selected style.
- Did not touch Home Hero V6, Page Trust Strip, Discovery Engine, Core, Templates, Site Shell or WooCommerce.

## 0.5.7
- Cleaned Pages Hero Other controls so each style shows only its relevant control sections.
- Fixed Style 2 feature strip text wrapping/layout bug.
- Improved style-specific control naming for professional Elementor editing.
- Kept Home Hero V6, Page Trust Strip, Discovery Engine, Core, Templates, Site Shell and WooCommerce untouched.

## 0.5.7
- Added `Amaley Pages Hero Other` Elementor widget for non-home page hero variations.
- Added shortcode `[amaley_pages_hero_other]` with style dropdown support: style-1 to style-6.
- Added six lightweight page hero presets: About, Clusters, Collections, Journal, Contact and Gifting.
- Added scoped CSS file `amaley-ui-pages-hero-other.css` only.
- No changes to Discovery Engine, Amaley Core, Amaley Templates, Site Shell, WooCommerce cart/checkout or accepted Home Hero V6.

## 0.5.4
- Final accepted Home Hero V6 no-gap image mosaic lock.
- Right image mosaic changed to absolute no-gap layout.
- Image default: cover + center center.

## 0.3.7
- Final accepted Page Trust Strip.
