# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

Every entry should clearly explain what changed, why it changed, which file/plugin/module was affected, and whether it is safe, experimental, or archived.

---

## 2026-06-10

### Amaley Discovery Engine v1.6.2 — Clean Stable Baseline

- Synced `plugins/amaley-discovery-engine/` source to Amaley Discovery Engine v1.6.2.
- Confirmed plugin header and `AMALEY_DE_VERSION` are set to `1.6.2`.
- Locked current active Elementor widgets to 8 approved widgets only:

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

- Removed/retired old legacy Elementor widgets from the active baseline:

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

- Kept the Discovery Engine focused on current shop, product filter, CTA and contact page widgets.
- Confirmed old Discovery/Product/Topbar widgets must not be restored in future builds.
- Added `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md` as the current Discovery Engine status lock.
- Updated repo-level documentation to point future work to v1.6.2 clean stable.

Safety decision:

```text
No WooCommerce cart/checkout/order logic changes.
No product data changes.
No product image/gallery changes.
No product-origin mapping changes.
No header/footer source changes.
No broad global CSS.
No old legacy Elementor widget registration.
No ZIP/media/screenshots/videos committed to GitHub.
```

Future rule:

```text
Every future Amaley Discovery Engine update must start from v1.6.2 clean stable.
Do not use old v1.4.x/v1.5.x patch files as current source.
Do not restore old Heading/Text/Icon/Discovery/Topbar widgets.
```

Affected docs:

```text
README.md
plugins/README.md
docs/PROJECT_MANIFEST.md
docs/NEXT_CHAT_PROMPT.md
docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md
docs/CHANGELOG.md
```

---

## 2026-06-07

### Amaley Compact Widgets v0.4.18 — Dual Heading and Non-Dual Alignment System Reset

- Synced `plugins/amaley-compact-widgets/` source to Amaley Compact Widgets v0.4.18.
- Confirmed plugin header and `AMALEY_CW_VERSION` are set to `0.4.18`.
- Added and locked the approved `Amaley Dual Section Heading` widget.
- Kept Dual Heading as a dedicated heading-only widget with no card/grid/repeater controls.
- Cleaned non-dual compact widget alignment by removing the old broad `Overall Alignment` control.
- Accepted alignment model for non-dual widgets:

```text
Header Alignment      → heading / kicker / title / description only
Card Text Alignment   → cards / items only
Button Alignment      → action rows / buttons only, where applicable
```

- Confirmed the compact widget update is limited to compact visual widgets only.
- Product data, product images/gallery, product-origin mapping, WooCommerce templates, cart/checkout, header/footer, Amaley Core and Discovery Engine were not intentionally changed.

Rejected / archived compact widget attempts:

```text
v0.4.14 — broad alignment over-correction, rejected
v0.4.15 — incomplete rollback/root fix, archived
v0.4.16 — incomplete live-preview alignment fix, archived
v0.4.17 — improved reset but still needed live-preview correction, archived
```

Affected source / docs:

```text
plugins/amaley-compact-widgets/
plugins/amaley-compact-widgets/amaley-compact-widgets.php
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
README.md
plugins/README.md
docs/CHANGELOG.md
docs/PROJECT_MANIFEST.md
docs/NEXT_CHAT_PROMPT.md
000_READ_FIRST_BEFORE_ANY_WORK.md
```

Safety decision:

```text
No WooCommerce cart/checkout/template override.
No product data change.
No product image/gallery change.
No product-origin mapping change.
No header/footer change.
No Amaley Core source change.
No Amaley Discovery Engine source change.
No broad global CSS.
No ZIP/media/screenshots/videos committed to GitHub.
```

Next safe work:

```text
1. Install final v0.4.18 ZIP on the WordPress site.
2. Clear cache and hard-refresh Elementor.
3. Check Dual Heading, Info Cards, Purpose Cards, Quote Cards and Metric Tiles.
4. Do not change compact widgets again without isolating the exact widget and testing it individually.
```

---

## 2026-06-06

### Amaley Discovery Engine v1.4.4 — Historical Stable OG Product Card Source Renderer and Full Card Controls

This entry is retained as historical context only. The current Discovery Engine baseline is v1.6.2 clean stable.

- Synced `plugins/amaley-discovery-engine/` source to Amaley Discovery Engine v1.4.4.
- Confirmed plugin header and `AMALEY_DE_VERSION` were set to `1.4.4` at that time.
- Preserved the source-level renderer path introduced after the v1.3.6 core-card source fix.
- Product Discovery supported the selected Amaley Core product-card renderer without frontend card-replacement patches.
- Accepted renderer flow at that time:

```text
Product Discovery widget
→ Card Renderer: Amaley Core Product Card — Select Template
→ Template: OG Product Card 1
```

Safety decision at that time:

```text
No product data changes.
No product images/gallery changes.
No product-origin mapping changes.
No WooCommerce cart/checkout/template override.
No header/footer change.
No broad global CSS.
No frontend replacement/stabilizer patch layer.
```

Rejected / archived attempts:

```text
v1.3.7 — broken Style tab restoration path
v1.3.8 — section-close recovery but incomplete control behaviour
v1.3.9 — broad CSS/control attempt that damaged cards
v1.4.0 — safe-control attempt but incomplete micro-control planning
v1.4.1 — hover-control attempt with confusing structure
v1.4.2 — fatal activation risk / rejected
v1.4.3 — rollback package only, not the final accepted version
```
