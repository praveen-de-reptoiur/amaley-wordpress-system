# DRIVE FOLDER MAP — Amaley Project

This document explains the Google Drive folder structure for the Amaley project.

Google Drive is used for heavy project files. GitHub is used for clean source code and documentation.

---

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
- Keep sensitive files, backups, plugin ZIPs, exports, screenshots, videos and handoff packages in Drive, not GitHub.
- Do not store passwords, API keys, license keys, database credentials, or `wp-config.php` in GitHub or public notes.
- If Drive permissions change, update this document with the current folder reference.

---

## Recommended Folder Structure

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

---

## 00_Project_Control

Use for:

- Read-first files
- Master notes
- Project manifest
- Next chat prompt
- Folder map
- Architecture registry copies

---

## 01_Backups

Use for website backups:

- `.wpress` backups
- All-in-One WP Migration files
- Full website backup files

Do not upload these files to GitHub.

---

## 02_Active_Plugins

Use for latest usable plugin ZIP backups only.

Current active / locked plugin ZIP backups:

```text
amaley-core-v1.0.2.zip
amaley-discovery-engine-v1.3.5-no-cpt.zip
amaley-site-shell-v1.0.1.zip
amaley-ui-sections-kit-v0.6.1.zip
amaley-compact-widgets-v0.4.2.zip
amaley-templates-v1.2.7.zip
```

Rules:

- Only current usable ZIP backups should stay here.
- Old versions should move to `10_Archive_Do_Not_Use/old-plugin-versions/`.
- GitHub should receive only the clean extracted source, never the plugin ZIP.

---

## 03_Code_Source

Use for extracted plugin source code copies when needed for handoff/reference.

Expected folders:

```text
amaley-core/
amaley-discovery-engine/
amaley-site-shell/
amaley-ui-sections-kit/
amaley-compact-widgets/
amaley-templates/
amaley-project-guard/
amaley-debug-toolkit/
```

GitHub remains the main clean source repository after review.

---

## 04_Elementor_Templates

Use for:

- Header templates
- Footer templates
- Single product templates
- Shop/archive templates
- Product card loop templates
- Cluster / SHG / Member templates
- Popup / form trigger templates
- Reusable section templates

---

## 05_Data_Exports

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

---

## 06_Design_System

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

---

## 07_Media_Reference

Use for media/reference files:

- Logos
- Product images
- Cluster images
- SHG member images
- Screenshots
- Videos
- Product mockups
- Website visual references

Do not upload large media files to GitHub.

---

## 08_Migration

Use for:

- Fresh WordPress migration plan
- Plugin install order
- Dependency removal plan
- Migration checklist
- Live-to-fresh export notes
- Staging test notes

---

## 09_QA_Debug

Use for:

- QA checklist
- Responsive test notes
- Plugin health checks
- Debug records
- Project Guard reports
- Debug Toolkit reports
- WooCommerce product/cart/checkout test notes
- Low-network performance notes

---

## 10_Archive_Do_Not_Use

Use for old, unsafe, superseded, rejected, or experimental files.

Examples:

- Broken plugins
- Old plugin versions
- Deprecated snippets
- Experimental files
- Rejected templates
- Unused Elementor exports

Do not activate anything from this folder without review.

---

## 11_Handoff_Packages

Use for handoff ZIPs and project packages.

Current handoff pattern:

```text
AMALEY_MASTER_HANDOFF_YYYY-MM-DD_FINAL_LOCKED.zip
```

A good handoff package should contain:

```text
00_READ_FIRST_NEXT_CHAT/
01_FINAL_ACCEPTED_PLUGINS/
02_FINAL_PREVIEWS_AND_DRY_TESTS/
03_GITHUB_SYNC_AND_REGISTRY/
04_REJECTED_VERSION_HISTORY_DO_NOT_USE/
05_RAW_USER_REFERENCES_AND_SCREENSHOTS/
06_SHORTCODES_AND_INSTALL_GUIDES/
07_MANIFESTS/
```

---

## Hard Rule

Heavy files go to Google Drive. Clean reviewed source and documentation go to GitHub.
