# CHANGELOG — Amaley WordPress System

This changelog records major project decisions, plugin versions, documentation updates, migration notes, and development milestones.

---

## 2026-06-12

### Amaley Blog System v1.4.7 — Audit Safe Baseline and Documentation Lock

- Synced `plugins/amaley-blog-system/` as the current editable source path.
- Confirmed Blog System current baseline as `v1.4.7 Audit Safe`.
- Locked current Blog System widgets:

```text
1. Amaley Blog Archive Hero
2. Amaley Blog Archive Layout
3. Amaley Single Hero — Full Width
4. Amaley Single Article Layout — Fixed
```

- Documented accepted Blog setup:

```text
Blogs page → Archive Hero → Archive Layout
Single post URL → Blog router → Blog Detail Template → Single Hero → Single Article Layout
```

- Documented that the custom Blogs page is managed from `Amaley Blog` settings.
- Documented that the final single blog model uses a separate full-width hero widget and a separate article layout widget.
- Expanded the Blog System current status doc and plugin README so future updates can start from the correct baseline.

Affected docs:

```text
README.md
plugins/README.md
plugins/amaley-blog-system/README.md
docs/PROJECT_MANIFEST.md
docs/AMALEY_BLOG_SYSTEM_CURRENT_STATUS_v1.4.7.md
docs/CHANGELOG.md
```

---

## 2026-06-10

### Amaley Discovery Engine v1.6.2 — Clean Stable Baseline

- Synced `plugins/amaley-discovery-engine/` source to Amaley Discovery Engine v1.6.2.
- Confirmed plugin header and `AMALEY_DE_VERSION` are set to `1.6.2`.
- Locked current active Elementor widgets to 8 approved widgets:

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

- Kept the Discovery Engine focused on current shop, product filter, CTA and contact page widgets.
- Added `docs/AMALEY_DISCOVERY_ENGINE_CURRENT_STATUS_v1.6.2.md` as the current Discovery Engine status lock.
- Updated repo-level documentation to point future work to v1.6.2 clean stable.

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
- Added and locked the approved `Amaley Dual Section Heading` widget.
- Kept Dual Heading as a dedicated heading-only widget.
- Cleaned non-dual compact widget alignment by removing the old broad `Overall Alignment` control.
- Accepted alignment model for non-dual widgets:

```text
Header Alignment      → heading / kicker / title / description only
Card Text Alignment   → cards / items only
Button Alignment      → action rows / buttons only, where applicable
```

Reference docs:

```text
docs/AMALEY_COMPACT_WIDGETS_CURRENT_STATUS_v0.4.18.md
docs/AMALEY_COMPACT_WIDGETS_VERSION_HISTORY.md
```

---

## 2026-06-06

### Amaley Discovery Engine v1.4.4 — Historical Stable OG Product Card Source Renderer and Full Card Controls

This entry is retained as historical context only. The current Discovery Engine baseline is v1.6.2 clean stable.

- Synced `plugins/amaley-discovery-engine/` source to Amaley Discovery Engine v1.4.4 at that time.
- Preserved the source-level renderer path introduced after the v1.3.6 core-card source fix.
- Product Discovery supported the selected Amaley Core product-card renderer without frontend card-replacement patches.
