# DRIVE FOLDER MAP — Amaley Project

This document explains the Google Drive folder structure for the Amaley project.

Google Drive is used for heavy project files.  
GitHub is used for source code and documentation.

## Main Drive Location

```text
Google Drive (G:) / My Drive / Amaley Project
```

Permanent Drive Folder Link:

```text
https://drive.google.com/drive/folders/1fYYtwPPxNGYDeSFwYqF1PZFseJ7VpAPN
```

Access note:

- This is the active Amaley project Drive folder reference.
- Keep sensitive files, backups, plugin ZIPs, exports, screenshots, videos, and handoff packages in Drive, not GitHub.
- Do not store passwords, API keys, license keys, database credentials, or `wp-config.php` in GitHub or public notes.
- If Drive permissions change, update this document with the current folder reference.

## Folder Structure

```text
Amaley Project/
  00_Project_Control/
  01_Backups/
  02_Active_Plugins/
  03_Code_Source/
  04_Elementor_Templates/
  05_Data_Exports/
  06_Design_System/
  07_Media_Reference/
  08_Migration/
  09_QA_Debug/
  10_Archive_Do_Not_Use/
  11_Handoff_Packages/
```

## 00_Project_Control

Project control documents.

Use for:

- Read-first files
- Master notes
- Project manifest
- Next chat prompt
- Folder map

## 01_Backups

Website backups.

Use for:

- `.wpress` backups
- All-in-One WP Migration files
- Full website backup files

Do not upload these files to GitHub.

## 02_Active_Plugins

Latest usable plugin ZIP backups.

Current active plugin ZIPs:

```text
amaley-templates-v1.2.7.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
```

Future active plugin ZIPs should also be stored here after testing.

## 03_Code_Source

Extracted plugin source code.

Expected future folders:

```text
amaley-templates/
amaley-discovery-engine/
amaley-core/
amaley-project-guard/
amaley-debug-toolkit/
```

This source can also be added to GitHub after review.

## 04_Elementor_Templates

Elementor template exports.

Use for:

- Header templates
- Footer templates
- Single product templates
- Shop/archive templates
- Product card loop templates
- Cluster / SHG / Member templates
- Popup / form trigger templates
- Reusable section templates

## 05_Data_Exports

Data exports.

Use for:

- WooCommerce products
- ACF fields
- CPT structures
- Product origin mapping
- Cluster data exports
- SHG Group data exports
- SHG Member / Producer data exports
- Amaley Core import/export CSVs
- Variation import CSVs

## 06_Design_System

Locked design-system documents.

Use for:

- Colors
- Fonts
- Spacing
- Buttons
- Cards
- Mobile rules
- Component control rules
- Full-control widget/template rules
- Lightweight performance rules

## 07_Media_Reference

Media reference files.

Use for:

- Logos
- Product images
- Cluster images
- SHG member images
- Screenshots
- Videos
- Product mockups
- Website visual references

Do not upload large media files to GitHub.

## 08_Migration

Migration planning files.

Use for:

- Fresh WordPress migration plan
- Plugin install order
- Dependency removal plan
- Migration checklist
- Live-to-fresh export notes
- Staging test notes

## 09_QA_Debug

Testing and debug notes.

Use for:

- QA checklist
- Responsive test notes
- Plugin health checks
- Debug records
- Project Guard reports
- Debug Toolkit reports
- WooCommerce product/cart/checkout test notes
- Low-network performance notes

## 10_Archive_Do_Not_Use

Old or unsafe files.

Use for:

- Broken plugins
- Old plugin versions
- Deprecated snippets
- Experimental files
- Rejected templates
- Unused Elementor exports

Do not activate anything from this folder without review.

## 11_Handoff_Packages

Handoff ZIPs and project packages.

Use for:

- Workspace starter ZIP
- Master handoff ZIPs
- Final transfer packages
- Next-chat continuation files
- Release notes packages

## Hard Rule

Heavy files go to Google Drive.

Source code and documentation go to GitHub.

Do not mix them.
