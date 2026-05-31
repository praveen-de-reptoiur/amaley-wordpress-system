# Amaley Core v1.0.26 — Page-Based Cluster Setup Guide

## Safe live setup

Use normal WordPress pages with Elementor. Do not use theme template overrides or WooCommerce template overrides.

## Page 1: Cluster Archive

Create a WordPress page:

- Title: Clusters
- Slug: clusters
- Elementor: add Shortcode widget
- Shortcode: `[amaley_cluster_archive_page]`

Final URL:

`/clusters/`

## Page 2: Cluster Detail

Create a WordPress page:

- Title: Cluster Detail
- Slug: cluster-detail
- Elementor: add Shortcode widget
- Shortcode: `[amaley_cluster_single_page]`

This page receives the cluster from URL parameter:

`/cluster-detail/?cluster_id=123`

or

`/cluster-detail/?cluster_slug=ladakh-apricot-cluster`

## Archive card linking

In Amaley Core > Settings, use:

`/cluster-detail/?cluster_id={id}`

Supported tokens:

- `{id}`
- `{slug}`

## Where to edit data

- Cluster content: Amaley Core > Clusters
- SHG data: Amaley Core > SHG Groups
- Producer data: Amaley Core > Members / Producers
- Product mapping: Amaley Core > Product Origin Mapping
- Page text/visibility: Amaley Core > Settings
- Page placement/layout: Elementor page editor

## Why this setup is safe

- No theme template override
- No WooCommerce template override
- No rewrite-rule conflict
- Easy rollback: remove shortcode or deactivate plugin
- Non-coder friendly
