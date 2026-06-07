# Changelog — Amaley Universal Showcase

## v1.0.20 — Member / Producer Detail URL Fix

Date: 2026-06-08
Status: Active stable standalone plugin

- Added `includes/class-aus-member-detail-links.php`.
- Bumped plugin version from v1.0.19 to v1.0.20.
- Loaded the member detail link resolver from the main plugin file.
- Fixed Universal Showcase Member / Producer cards so they resolve to the assigned Producers Details page.
- Expected member card URL format: `/producers-details/?member_slug=member-slug`.
- Resolution priority: Amaley Core Producer Single Template Page, then `producers-details` page slug, then original WordPress permalink fallback.
- Scope is link routing only. No data, mapping, media, WooCommerce, header/footer or design logic was changed.

## v1.0.19 — Active Stable Standalone

Date: 2026-06-06
Status: Active stable standalone plugin

- Locked responsive final polish as current source-of-truth.
- Separate plugin decision confirmed.
- Core merge cancelled / not required.
- Bottom View All placement retained.
- Heading alignment, card meta controls and relation-by-cluster flow retained.
- Phone/tablet polish retained.

## v1.0.18 — Header Alignment + Bottom CTA

- Moved View All from top-right to bottom.
- Added heading alignment controls.
- Added bottom CTA alignment and spacing controls.

## v1.0.16 — Card Meta Controls

- Added SHG/Cluster/Member meta visibility controls.
- Added SHG meta order control.
- Added button width control.

## v1.0.15 — Count Resolver Correction

- Removed wrong zero-count hide direction.
- Kept real data visible.
- Strengthened member/SHG count resolver.

## v1.0.12 — Relation Status + Fallback

- Added relation status messaging.
- Added empty relation fallback behaviour.

## v1.0.4 to v1.0.8 — Relation Source Controls

- Added source modes by selected content type.
- Added SHG by Cluster relation flow.
- Added safe fallback modes.

## v1.0.0 to v1.0.3 — Base Widget

- Created standalone Elementor widget.
- Added slider/grid rendering.
- Added View All URL handling.
