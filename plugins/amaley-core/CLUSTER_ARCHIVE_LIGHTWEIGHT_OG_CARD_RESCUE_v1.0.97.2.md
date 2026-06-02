# Cluster Archive Lightweight OG Card Rescue v1.0.97.2

## Why this exists
v1.0.97 and v1.0.97.1 added too many Elementor style controls for Cluster Archive OG card. This could make Elementor left panel keep showing the loader/spinner.

## Fix direction
This version is rebuilt from stable v1.0.96, not from 97/97.1.

It keeps only a lightweight selector:
- Current / Existing Card
- OG Cluster Card 1

No heavy OG full controls are added in this version.

## OG card flow
- image / initials placeholder
- label
- title
- description
- meta/stat boxes
- tags/chips
- rounded rust button

## Controls kept
- Card Template selector
- show/hide card elements
- OG description word limit

## Removed/avoided
- No OG full controls
- No heavy Elementor style-control sections
- No transform controls
- No duplicate controls

## Untouched
- Single Cluster
- Single SHG
- Single Member
- Pagination
- Discovery Engine
- WooCommerce
- Header/footer
