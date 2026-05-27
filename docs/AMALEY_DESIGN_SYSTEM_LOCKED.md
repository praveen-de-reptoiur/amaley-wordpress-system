# AMALEY DESIGN SYSTEM LOCKED

This document locks the visual direction for Amaley.

No page, plugin, template, UI section, component, product card, origin block, CTA, header, footer, or section should visually drift away from this system unless a new design-system version is approved.

This file is the design source-of-truth until the final Amaley brand PDF replaces or upgrades these tokens.

---

## 1. Brand Position

Amaley is a premium Himalayan product brand rooted in:

- Women collectives
- Producer families
- Small-batch production
- Natural Himalayan ingredients
- Conscious sourcing
- Traceable origin stories
- Respect for local ecology and seasonal rhythms
- Community-rooted value creation
- Clean, credible, health-conscious product experience

The design must feel:

- Premium
- Earthy
- Warm
- Calm
- Natural
- Trustworthy
- Community-rooted
- Himalayan
- Small-batch and carefully made

The design must not feel:

- Loud
- Cheap
- Random
- Over-decorated
- Generic
- Artificial
- Mass-market discount style
- Overly glossy
- Heavy or cluttered

---

## 2. Core Visual Direction

Use a warm editorial e-commerce style.

The website should feel like:

- Premium food and wellness brand
- Himalayan craft and community enterprise
- Clean modern e-commerce
- Soft editorial storytelling
- Mobile-first product discovery system
- Trust-led product experience
- Origin-aware marketplace

The visual tone should balance:

```text
Premium + Earthy
Natural + Reliable
Community-rooted + Professional
Himalayan + Modern
Editorial + E-commerce
```

---

## 3. Core Design Principles

Every Amaley section/component must follow:

- Mobile-first layout
- Warm editorial spacing
- Soft cards, not harsh boxes
- Clear product discovery
- Clean typography hierarchy
- Trust-led product copy
- Earthy premium colors
- Lightweight visual effects
- No unnecessary animation
- No clutter
- No random section styling
- No global CSS shortcuts
- No inconsistent fonts
- No component that slows the site unnecessarily

---

## 4. Primary Color Tokens

Use these as the current locked Amaley palette.

```text
--amaley-deep-chocolate: #2E1203;
--amaley-warm-chocolate: #4A2208;
--amaley-ivory-base: #FFF8ED;
--amaley-warm-cream: #F6EFE3;
--amaley-soft-sand: #EFE3D0;
--amaley-muted-gold: #C2880A;
--amaley-rust-accent: #B85C38;
--amaley-leaf-green: #6F7A3A;
--amaley-text-brown: #4A2208;
--amaley-muted-text: #7A6250;
--amaley-border-warm: #E5D7C2;
--amaley-white: #FFFFFF;
```

---

## 5. Color Usage Rules

### Page Background

Use:

```text
Ivory Base: #FFF8ED
Warm Cream: #F6EFE3
Soft Sand: #EFE3D0
```

Rules:

- Main page background should remain warm and soft.
- Avoid pure white as the main full-page background except inside clean product cards.
- Avoid cold grey backgrounds.
- Avoid dark full sections unless they are controlled premium editorial sections.

---

### Primary Text

Use:

```text
Deep Chocolate: #2E1203
Warm Chocolate: #4A2208
Text Brown: #4A2208
```

Rules:

- Main headings should use Deep Chocolate.
- Body text should use Warm Chocolate or Text Brown.
- Avoid black unless absolutely necessary.
- Avoid low-contrast beige text on cream background.

---

### Muted Text

Use:

```text
Muted Text: #7A6250
```

Rules:

- Use for small labels, descriptions, metadata, product secondary text.
- Do not use muted text for important CTAs or critical product details.

---

### Primary Accent

Use:

```text
Muted Gold: #C2880A
```

Use for:

- Small labels
- Premium highlights
- Icon accents
- Borders
- Tiny dividers
- Product origin accents
- Quality/purity markers

Rules:

- Gold should feel restrained, not shiny.
- Do not overuse gold as large background blocks.

---

### Secondary Accent

Use:

```text
Rust Accent: #B85C38
```

Use for:

- Primary CTA background
- Sale/highlight badge where appropriate
- Warm emphasis
- Selected state
- Important action buttons

Rules:

- Rust should feel warm and handcrafted.
- Avoid bright red for Amaley CTAs.

---

### Natural Accent

Use:

```text
Leaf Green Accent: #6F7A3A
```

Use for:

- Natural ingredient cues
- Sustainability cues
- Origin/nature tags
- Small eco/natural badges

Rules:

- Use lightly.
- Avoid turning Amaley into a generic green organic website.

---

## 6. Typography Direction

Current preferred typography direction:

```text
Heading Font: Playfair Display
Body Font: Lato
```

If the future brand PDF changes fonts, global tokens should update typography without editing every section manually.

---

### Heading Style

Headings should feel premium, editorial, warm, and readable.

Rules:

- Use sentence case or title case.
- Avoid all-caps for long headings.
- Use italic accent words only where it adds premium editorial feel.
- Avoid oversized headings on mobile.
- Avoid cramped line-height.

Suggested heading treatment:

```text
font-family: Playfair Display, Georgia, serif;
font-weight: 600;
color: #2E1203;
letter-spacing: -0.02em;
line-height: 1.05 - 1.18;
```

---

### Body Style

Body text should feel clean, readable, and trustworthy.

Suggested body treatment:

```text
font-family: Lato, Arial, sans-serif;
font-weight: 400;
color: #4A2208;
line-height: 1.65;
```

Rules:

- Avoid very light body text.
- Avoid cramped paragraphs.
- Keep product copy short and useful.
- Use storytelling blocks only where needed.

---

### Small Label Style

Use small labels for premium/category/origin cues.

Suggested treatment:

```text
font-family: Lato, Arial, sans-serif;
font-size: 11px - 13px;
font-weight: 700;
letter-spacing: 0.10em;
text-transform: uppercase;
color: #C2880A;
```

Rules:

- Use labels sparingly.
- Do not make entire sections uppercase.

---

## 7. Spacing Tokens

Use consistent spacing across sections.

```text
--amaley-space-xs: 8px;
--amaley-space-sm: 12px;
--amaley-space-md: 18px;
--amaley-space-lg: 28px;
--amaley-space-xl: 44px;
--amaley-space-2xl: 72px;
```

Desktop section spacing:

```text
Top/bottom: 64px - 96px
Container side padding: 24px - 40px
```

Tablet section spacing:

```text
Top/bottom: 48px - 72px
Container side padding: 20px - 28px
```

Mobile section spacing:

```text
Top/bottom: 36px - 56px
Container side padding: 16px - 20px
```

Rules:

- Do not create huge empty gaps on mobile.
- Do not stack cards without breathing room.
- Keep product grids compact but readable.

---

## 8. Radius, Border, and Shadow Tokens

Use soft, premium card geometry.

```text
--amaley-radius-sm: 10px;
--amaley-radius-md: 16px;
--amaley-radius-lg: 22px;
--amaley-radius-xl: 28px;
--amaley-border: 1px solid #E5D7C2;
```

Preferred shadow:

```text
0 12px 30px rgba(46, 18, 3, 0.08)
```

Subtle shadow:

```text
0 6px 18px rgba(46, 18, 3, 0.06)
```

Rules:

- Avoid harsh black shadows.
- Avoid square, flat, generic cards.
- Avoid over-rounded cartoon-like corners.

---

## 9. Button System

Buttons must be consistent across the website.

### Primary Button

Use for important actions:

- Shop now
- Explore products
- View collection
- Add to cart where custom section requires CTA
- Learn about origin

Suggested treatment:

```text
background: #B85C38;
color: #FFFFFF;
border: 1px solid #B85C38;
border-radius: 999px;
font-weight: 700;
padding: 12px 22px;
```

Hover:

```text
background: #2E1203;
border-color: #2E1203;
```

---

### Secondary Button

Use for softer actions:

```text
background: transparent;
color: #2E1203;
border: 1px solid #C2880A;
border-radius: 999px;
font-weight: 700;
padding: 12px 22px;
```

Hover:

```text
background: #FFF8ED;
border-color: #2E1203;
```

---

### Text Link Button

Use for editorial links:

```text
color: #B85C38;
font-weight: 700;
text-decoration: none;
border-bottom: 1px solid rgba(184, 92, 56, 0.35);
```

Rules:

- Do not use random button colors.
- Do not use harsh red/green/blue buttons.
- Do not create different button radius per section.
- Buttons must remain readable on mobile.
- Touch target should be at least 44px high.

---

## 10. Card System

Cards should feel premium and simple.

Use for:

- Product cards
- Collection cards
- Origin cards
- Trust cards
- SHG/women collective cards
- Story cards
- Feature cards

Preferred card treatment:

```text
background: #FFFFFF;
border: 1px solid #E5D7C2;
border-radius: 22px;
box-shadow: 0 12px 30px rgba(46, 18, 3, 0.08);
```

Rules:

- Keep product card heights balanced.
- Do not let badges and buttons jump randomly.
- Image area should be consistent.
- Product title should not feel cramped.
- Price and CTA should remain aligned.
- Avoid visual clutter inside product cards.

---

## 11. Product Card Direction

Product cards should feel premium marketplace-style, not default WooCommerce clutter.

Product card should include:

- Clean image area
- Product title
- Short trust/origin cue where available
- Price
- Add to cart / View product action
- Optional small origin/quality badge

Rules:

- Keep badge positions consistent.
- Keep price and CTA alignment stable.
- Avoid too many labels.
- Avoid red sale clutter unless needed.
- Product card must be responsive and low-network-ready.
- Images should use optimized sizes and lazy loading.

---

## 12. Origin / Traceability Direction

Origin sections should feel calm and credible.

Use:

- Warm cream or ivory background
- Small gold label
- Deep chocolate heading
- Short readable paragraphs
- Simple icon/card treatment
- Clear Cluster / SHG / Producer mapping if available

Rules:

- Do not fake origin data.
- Do not create dummy SHG/Cluster/Producer entries.
- If origin data is missing, show safe empty state or hide block.
- Keep storytelling respectful and concise.

---

## 13. Women Collective / Community Direction

Use words like:

- Women collectives
- Producer families
- SHG groups
- Community-rooted
- Small-batch
- Quality checked by Amaley
- Himalayan ingredients
- Conscious sourcing

Avoid unless specifically requested:

```text
women-led
```

Rules:

- Position communities with dignity, not charity language.
- Avoid overclaiming.
- Keep copy premium and credible.

---

## 14. Amaley UI Sections Kit Design Rule

Future clean UI sections should come from Amaley UI Sections Kit, not Elementor default widgets.

UI Sections Kit should follow this design system for:

- Buttons
- Button groups
- Section headings
- Heading strips
- Promise strips
- Product cards
- Product grids
- Story sections
- Media + text sections
- Trust strips
- CTA bands
- Origin blocks
- Cluster cards
- SHG / women collective cards
- Contact blocks
- Footer CTA sections

Rules:

- No Elementor Heading widget dependency.
- No Elementor Button widget dependency.
- No Elementor Icon Box widget dependency.
- No Elementor Image Box widget dependency.
- No Elementor HTML widget dependency.
- No Elementor generic layout dependency as the main system.
- No WooCommerce replacement.
- No CPT creation.
- No header/footer replacement.
- No discovery/filter engine replacement.
- Must be lightweight.
- Must be global design-token controlled.
- Must be mobile-first.
- Must be rollback-safe.

---

## 15. Site Shell Design Rule

Amaley Site Shell should follow this design system for:

- Header
- Mobile header
- Mobile drawer
- Footer
- Announcement strip
- Navigation
- CTA placement

Rules:

- Header should be clean, warm, and premium.
- Mobile drawer should be simple and readable.
- Footer should not feel heavy or black unless specifically approved.
- Site Shell must not blindly override live/current header/footer.
- Auto-render must remain off until approved and tested.

---

## 16. Discovery / Filter Design Rule

Product discovery should feel clean and easy.

Filter UI should be:

- Simple
- Mobile-friendly
- Clear
- Not too many chips
- Easy to reset
- Low-network-safe
- Not dependent permanently on JetEngine or Smart Filters

Empty states should be helpful and calm.

Example tone:

```text
No products found for this filter. Try another collection or origin.
```

---

## 17. Motion and Interaction Rule

Motion should be restrained.

Allowed:

- Soft hover lift
- Gentle button hover
- Smooth drawer open/close
- Simple accordion transition
- Subtle image hover

Avoid:

- Heavy animation libraries
- Scroll-jacking
- Excessive parallax
- Auto-playing video backgrounds
- Random moving elements
- Anything that hurts low-network performance

---

## 18. Mobile Rules

Mobile experience must be clean and compact.

Rules:

- No horizontal scroll.
- Buttons must fit in one or two neat rows.
- Cards must not become too tall.
- Product grid should remain readable.
- Text must not be too tiny.
- Hero headings must not clip.
- Sticky elements should not cover product actions.
- Drawer/menu must close clearly.
- Spacing should feel premium but not wasteful.

Test widths:

```text
360px
390px
430px
768px
1024px
1366px
```

---

## 19. Accessibility Rule

Every section should remain usable.

Check:

- Contrast is readable.
- Buttons have clear text.
- Links are understandable.
- Touch areas are large enough.
- Important content is not hidden.
- Error/empty states are clear.
- Navigation is understandable.
- Forms have labels.

---

## 20. Performance Rule

Design must not make the site heavy.

Every design/component decision must respect:

- No unnecessary libraries
- No heavy images
- No unoptimized background images
- No heavy sliders
- No duplicate CSS
- No frontend-heavy debug assets
- No unnecessary animations
- Optimized images
- Lazy loading where appropriate
- Clean HTML
- Scoped CSS

If design beauty hurts speed and low-network usability, it is not approved.

---

## 21. Section Approval Rule

A section is not approved unless it passes:

- Brand fit
- Color fit
- Typography fit
- Spacing fit
- Mobile fit
- WooCommerce safety where relevant
- Performance fit
- Low-network fit
- Global token fit
- Rollback safety
- No-Elementor future UI rule where applicable

---

## 22. Final Design Rule

Amaley design should feel like:

```text
Premium Himalayan products
Natural ingredients
Women collectives
Producer families
Small-batch care
Conscious sourcing
Trustworthy marketplace
Warm editorial commerce
```

If a section does not feel like Amaley, it should not be shipped.

If a component looks premium but makes the site heavy, it is not approved.
