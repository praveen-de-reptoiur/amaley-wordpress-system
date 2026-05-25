# DRIVE FOLDER MAP — Amaley Project

This document explains the Google Drive folder structure for the Amaley project.

Google Drive is used for heavy project files.  
GitHub is used for source code and documentation.

## Main Drive Location

```text
Google Drive (G:) / My Drive / Amaley Project
```

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

## 03_Code_Source

Extracted plugin source code.

Expected future folders:

```text
amaley-templates/
amaley-discovery-engine/
amaley-core/
```

This source can also be added to GitHub.

## 04_Elementor_Templates

Elementor template exports.

Use for:

- Header templates
- Footer templates
- Single product templates
- Shop/archive templates
- Product card loop templates
- Cluster / SHG / Member templates

## 05_Data_Exports

Data exports.

Use for:

- WooCommerce products
- ACF fields
- CPT structures
- Product origin mapping
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

## 07_Media_Reference

Media reference files.

Use for:

- Logos
- Product images
- Cluster images
- SHG member images
- Screenshots
- Videos

Do not upload large media files to GitHub.

## 08_Migration

Migration planning files.

Use for:

- Fresh WordPress migration plan
- Plugin install order
- Dependency removal plan
- Migration checklist

## 09_QA_Debug

Testing and debug notes.

Use for:

- QA checklist
- Responsive test notes
- Plugin health checks
- Debug records

## 10_Archive_Do_Not_Use

Old or unsafe files.

Use for:

- Broken plugins
- Old plugin versions
- Deprecated snippets
- Experimental files

Do not activate anything from this folder without review.

## 11_Handoff_Packages

Handoff ZIPs and project packages.

Use for:

- Workspace starter ZIP
- Master handoff ZIPs
- Final transfer packages

## Hard Rule

Heavy files go to Google Drive.

Source code and documentation go to GitHub.

Do not mix them.
