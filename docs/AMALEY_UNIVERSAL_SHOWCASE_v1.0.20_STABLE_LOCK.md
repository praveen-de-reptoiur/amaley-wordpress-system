# Amaley Universal Showcase v1.0.20 — Stable Lock

Date: 2026-06-06  
Status: Stable standalone checkpoint after Elementor testing  
Author / Maintainer: Praveen

---

## 1. What This Locks

This locks the standalone **Amaley Universal Showcase** plugin tested through iterative Elementor checks.

Current stable install ZIP:

```text
amaley-universal-showcase-v1.0.20-stable.zip
```

Current source path in repository:

```text
plugins/amaley-universal-showcase/
```

This source is separate from Amaley Core for now. It should not be merged into Core without a separate backup, merge plan and QA checkpoint.

---

## 2. Confirmed Working

- Elementor widget loads cleanly.
- Content type selection works for Cluster, SHG / Producer, Member / Producer and Product.
- SHG by Cluster relation works.
- Member count display works when SHG/member count data is mapped.
- View All button is placed at the bottom, not top-right.
- Heading alignment and CTA alignment controls are available.
- Card meta controls are available.
- Phone/tablet responsive polish is completed.
- Old wrong zero-count hide direction was removed.

---

## 3. Safety Boundaries

This standalone plugin does not touch:

- WooCommerce product data
- Product images or galleries
- Product origin mappings
- Discovery Engine filters, search, sort or filtered pagination
- Header/footer logic
- Theme templates
- Cart, checkout or orders

---

## 4. Installation Rule for Current Test Site

Because the current WordPress setup showed fatal/update issues during direct plugin replacement, use this exact process:

```text
Deactivate old Amaley Universal Showcase
Delete old Amaley Universal Showcase
Upload v1.0.20 stable ZIP
Activate
Hard refresh Elementor with Ctrl + F5
```

Do not upload the ZIP over an active old plugin on this site.

---

## 5. QA Before Production Use

Test these combinations:

- Cluster + grid
- Cluster + slider
- SHG / Producer + relation by Cluster
- SHG / Producer + slider
- Member / Producer + latest/manual
- Product + latest/category/manual
- Two showcase widgets on the same page
- Desktop preview
- Tablet preview
- Phone preview
- Published frontend

---

## 6. Future Core Merge Rule

The repository already has a Core-owned Universal Showcase direction. This standalone source should only move into `plugins/amaley-core/` after:

1. Amaley Core backup is confirmed.
2. Current Core version is frozen.
3. Standalone `AUS_Plugin` classes are converted into Core-safe class names.
4. Assets are renamed to Core asset names.
5. Elementor widget category/registration is merged safely.
6. One full QA round is completed after merge.

Until then, treat this as the stable standalone source.
