Amaley Discovery Engine v1.4.4 — Full OG Product Card Controls

Base: confirmed working v1.3.6 source-level core-card fix.

Scope:
- Keeps Amaley Core Product Card renderer as first-class source renderer.
- Keeps pagination/filter/sort source path unchanged.
- Adds Elementor Style tab controls using scoped selectors only inside current widget.
- Controls target .amaley-dcrsf-core-card-wrap > .amaley-card.amaley-card--product so native/default cards and other Amaley Core sections are not affected.

Checks run locally:
- PHP syntax check for all plugin PHP files.
- Elementor control section balance check.
- ZIP integrity check.
- Required OG card selectors present in control map.

Install after backing up current stable v1.3.6/v1.4.3.
