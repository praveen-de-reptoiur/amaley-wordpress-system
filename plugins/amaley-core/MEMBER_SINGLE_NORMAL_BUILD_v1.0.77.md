# Amaley Core v1.0.77 — Member Single Normal Build

Status: test package
Scope: Member / Producer Single only
Baseline: accepted v1.0.76.5 Member Archive + Manual Gallery build, originally restarted from clean v1.0.74 repo baseline.

## Added

Member / Producer Single section widgets:

1. Amaley Member Single Hero
2. Amaley Member Single Snapshot
3. Amaley Member Single Story
4. Amaley Member Single Linked SHG
5. Amaley Member Single Linked Cluster
6. Amaley Member Single Products
7. Amaley Member Single Gallery
8. Amaley Member Single Contact CTA

## Routing / preview

Widgets can auto-detect member data using:

```text
?member_slug={slug}
?producer_slug={slug}
?member_id={id}
```

Elementor editor can use Preview Member ID or Fixed Member Slug.

## Safety

- Member Archive accepted design untouched.
- Manual Gallery widget untouched.
- Cluster, SHG and Product locked card designs untouched.
- WooCommerce cart/checkout untouched.
- Header/footer untouched.
- Backend rich text/gallery fields untouched.
- CSS scoped to `.amms-*` Member Single selectors.

## Controls

This build is intentionally a normal first build. Full micro-controls will be added after visual structure is accepted.
