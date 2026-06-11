Amaley Blog System v1.4.6 — Doc Complete Controls

Baseline: v1.4.5 accepted Hero + Layout.
Purpose: Add missing Elementor controls according to Amaley Universal Full-Control Elementor Design Standard v2 without changing the accepted frontend design.

Touched:
- amaley-blog-system.php
- includes/elementor/class-amaley-single-layout-clean-widget.php

Not touched:
- Accepted Single Hero design and render
- Archive Hero/Layout and archive interactions
- Discovery Engine / Amaley Core / data/images

Changes:
- Split Tags/Navigation from Related Articles controls.
- Added Related Articles section controls with tabs: Section, Card, Image, Text, Button.
- Added full related card controls: background, border, radius, shadow, card padding, body gap, hover lift.
- Added related image controls: height, object-fit, X/Y position, radius, overlay, hover zoom.
- Added related text controls: category chip, title, meta, excerpt typography/colors/margins.
- Added related button controls: normal/hover color, background, padding, radius, border, shadow, typography.
- Cleaned sidebar controls into tabs: Box, Heading, TOC, Share, Mini Posts.
- Added share icon and mini-post controls.
- Added article blockquote/list controls under Article Content > Elements.
- Removed duplicate sidebar box controls from earlier build.

Checks:
- PHP lint clean.
- JS syntax clean.
- CSS brace balance clean.
- ZIP integrity clean.
- ZIP root folder: amaley-blog-system/

Install:
1. Upload ZIP through WordPress plugin uploader or replace plugin files.
2. Elementor -> Tools -> Regenerate CSS & Data.
3. Clear cache and hard refresh.

Template widgets:
1. Amaley Single Hero — Full Width
2. Amaley Single Article Layout — Fixed
