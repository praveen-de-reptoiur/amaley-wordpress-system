# Changelog

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
