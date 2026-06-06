# Amaley Core Current Status v1.0.99.5

Status: accepted live baseline after testing.

Current source path:

```text
plugins/amaley-core/
```

Current version:

```text
v1.0.99.5 - OG Product Card Price Stack Fix Merged
```

Working setup:

```text
Amaley Core: v1.0.99.5
Amaley Discovery Engine: v1.4.4
```

What changed:

- Amaley Core version changed from 1.0.99.4 to 1.0.99.5.
- Tested product price stack CSS was merged into assets/amaley-core-cards.css.
- Old price appears smaller with strikethrough.
- Sale price appears on the next line and remains bold/readable.

Architecture rule:

```text
Card design and price layout = Amaley Core
Grid, filter, search, sort and pagination = Amaley Discovery Engine
```

No changes were made to product data, product images, product-origin mappings, Discovery Engine query logic, WooCommerce templates, header, footer, or the pending Cluster/SHG/Producer filters.

Next pending Discovery work remains:

```text
1. Cluster filter
2. SHG / Collective filter
3. Producer / Member filter
```
