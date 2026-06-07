# Amaley Universal Showcase

Standalone Elementor showcase widget for the Amaley WordPress ecosystem.

Version: 1.0.20  
Status: Active stable standalone plugin  
Author: Praveen

## Lock

- This plugin remains a **separate plugin**.
- **Do not merge into Amaley Core** unless separately approved later.
- Current source-of-truth version is **v1.0.20**.

## Purpose

This plugin provides a reusable Elementor widget for showing Amaley ecosystem content in section form across the website. It can display:

- Clusters
- SHG / Producer Groups
- Members / Producers
- WooCommerce Products

## Key Features

- Elementor widget: **Amaley Universal Showcase**
- Grid / slider / card-row / list support
- Cluster, SHG, Member and Product source modes
- SHG by Cluster relation working
- Section heading alignment controls
- Bottom View All button placement and alignment controls
- Card meta controls
- Phone/tablet responsive polish

## v1.0.20 Member / Producer URL Fix

v1.0.20 adds a dedicated member detail link resolver:

`includes/class-aus-member-detail-links.php`

The fix routes Universal Showcase Member / Producer cards to the assigned Producers Details page.

Expected card URL format:

`/producers-details/?member_slug=member-slug`

Resolution priority:

1. Amaley Core Settings -> Producer Single Template Page
2. WordPress page slug -> producers-details
3. Original WordPress permalink fallback if no valid page is found

## Safety Boundaries

This plugin should not modify or override:

- WooCommerce product data
- Product photos or galleries
- Product origin mappings
- Discovery Engine filters/search/sort/pagination
- Header/footer systems
- Theme templates
- Cart/checkout/order logic

## Install Rule on Current Test Site

1. Backup before replacing the plugin.
2. Upload the new ZIP.
3. Activate.
4. Purge cache after update.
5. Hard refresh Elementor.

## Post-Fix Test

After installing v1.0.20, test a Universal Showcase section where **What to Show** is set to **Member / Producer**.

Expected card URL format:

`/producers-details/?member_slug=dechen-wangmo`
