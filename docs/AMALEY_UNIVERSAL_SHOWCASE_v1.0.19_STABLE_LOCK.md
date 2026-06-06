# Amaley Universal Showcase v1.0.19 — Stable Lock

Date: 2026-06-06  
Status: Active stable standalone plugin  
Author / Maintainer: Praveen

## Lock

- **Amaley Universal Showcase stays a separate plugin.**
- **Do not merge into Amaley Core.**
- Current source-of-truth version is **v1.0.19**.

## Plugin Path

```text
plugins/amaley-universal-showcase/
```

## Confirmed Working

- Elementor widget loads cleanly.
- Content type selection works for Cluster, SHG / Producer, Member / Producer and Product.
- SHG by Cluster relation works.
- Members count display works when SHG/member count data is mapped.
- View All button is placed at the bottom.
- Heading alignment and CTA alignment controls are available.
- Card meta controls are available.
- Phone/tablet responsive polish is completed.

## Safety Boundaries

This standalone plugin does not touch:

- WooCommerce product data
- Product images or galleries
- Product origin mappings
- Discovery Engine filters, search, sort or filtered pagination
- Header/footer logic
- Theme templates
- Cart, checkout or orders

## Installation Rule for Current Test Site

```text
Deactivate old Amaley Universal Showcase
Delete old Amaley Universal Showcase
Upload v1.0.19 ZIP
Activate
Hard refresh Elementor with Ctrl + F5
```

## QA Before Production Use

- Test Cluster + grid
- Test Cluster + slider
- Test SHG / Producer + relation by Cluster
- Test Member / Producer + latest/manual
- Test Product + latest/category/manual
- Test desktop, tablet and phone
- Test two showcase widgets on the same page
