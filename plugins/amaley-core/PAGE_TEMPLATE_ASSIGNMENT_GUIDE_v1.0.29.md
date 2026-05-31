# Amaley Core v1.0.29 — Page Template Assignment Guide

This version adds safe page role assignment for normal WordPress pages.

## Locked method

Do not create one page per cluster.

Create normal WordPress pages and assign them inside:

Amaley Core → Settings → Page Template Assignment

## Cluster pages

### Cluster Archive Page
Create a normal page, for example:

- Title: Clusters
- Slug: clusters

Design it in Elementor using section widgets:

- Amaley Cluster Archive Hero
- Amaley Cluster Archive Trust Strip
- Amaley Cluster Archive Intro / Why Section
- Amaley Cluster Archive Grid
- Amaley Cluster Archive CTA Band

Then assign this page as Cluster Archive Page.

### Cluster Single Template Page
Create one normal page, for example:

- Title: Cluster Detail
- Slug: cluster-detail

This page will behave like a single cluster template. Every cluster card will open this same page with a URL parameter:

- /cluster-detail/?cluster_slug=cluster-name
- or /cluster-detail/?cluster_id=123

Then assign this page as Cluster Single Template Page.

## Archive card routing

In the Amaley Cluster Archive Grid widget, keep:

Use Assigned Single Template Page = Yes

The widget will read the assigned Cluster Single Template Page from settings and build the detail links automatically.

## Why this is safe

- No theme template override
- No WooCommerce template override
- No header/footer changes
- No clean permalink/rewrite dependency
- No one-page-per-cluster burden
- Elementor still controls design section by section
- Amaley Core CPTs control data

## Data source

Cluster data is edited from:

Amaley Core → Clusters

Linked SHGs, producers and products come from:

Amaley Core → SHG Groups
Amaley Core → Members / Producers
Amaley Core → Product Origin Mapping

## Future phases

SHG and Producer page assignment fields are present for planning consistency. Their section widgets will be built later.
