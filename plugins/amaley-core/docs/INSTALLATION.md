# Amaley Core Installation Guide

## Live WordPress installation

Use the clean installable ZIP:

`amaley-core-v1.0.144-clean-installable.zip`

Upload from:

WordPress Admin → Plugins → Add New → Upload Plugin

## File Manager replacement

If replacing through hosting File Manager:

1. Take backup of current `wp-content/plugins/amaley-core/` folder.
2. Extract the installable ZIP locally.
3. Upload/replace files inside:

```text
wp-content/plugins/amaley-core/
```

4. Refresh WordPress Plugins screen.
5. Confirm version shows `1.0.144`.
6. Open Elementor and run visual QA on desktop, tablet, and mobile.

## Post-install cache steps

If Elementor preview shows old layout:

WordPress Admin → Elementor → Tools → Regenerate CSS & Data

Then hard refresh browser with Ctrl + F5.
