# Amaley Compact Widgets v0.4.19 Installation Notes

## Use this for

Use these notes when moving the merged Compact Widgets build from staging to the final/live Amaley site.

Current stable merged build:

Amaley Compact Widgets v0.4.19

## Before installation

1. Take a full site backup using the current backup workflow.
2. Confirm the site is on the intended staging or final/live environment.
3. Confirm the current plugin package is Amaley Compact Widgets v0.4.19.
4. Keep the separate Amaley Compact Spacing Controls v1.0.23 plugin inactive after the merge.

## Clean plugin state

The final clean plugin state should be:

Active:
- Amaley Compact Widgets v0.4.19

Inactive:
- Amaley Compact Spacing Controls v1.0.23

Do not keep both as active long-term sources for the same merged widgets.

## Update steps

1. Go to WordPress Admin -> Plugins.
2. Confirm Amaley Compact Widgets is present.
3. Upload or update the merged Amaley Compact Widgets v0.4.19 package if required.
4. If WordPress asks to replace the current plugin with the uploaded one, proceed only after backup.
5. Activate Amaley Compact Widgets v0.4.19.
6. Keep Amaley Compact Spacing Controls v1.0.23 inactive.

## After installation

1. Go to Elementor -> Tools.
2. Run Regenerate CSS & Data.
3. Clear LiteSpeed/site cache.
4. Hard refresh the browser.
5. Open the homepage or test page in Elementor.
6. Search for the merged widgets in the Amaley Compact category.

## Widgets to verify

Verify these widgets in Elementor and on frontend:

- Amaley Mission Visual Statement
- Amaley Vision Visual Statement
- Amaley Process Journey
- Amaley Origin Pillars
- Amaley Livelihood Chain Band
- Amaley Gifting Feature Split
- Amaley Split Editorial
- Amaley Origin Map Path

## Control checks

For each merged widget, check:

- Kicker, heading and description controls
- Image controls
- Icon color controls
- Card spacing and padding controls
- Desktop layout
- Tablet layout
- Mobile layout
- Button colors and hover controls where available
- Bottom strip or trust strip controls where available

## Responsive checks

Check these breakpoints:

- Desktop
- Tablet
- Mobile

The final review should confirm:

- No horizontal overflow
- No excessive blank gap
- Icons align correctly
- Images crop cleanly
- Text does not overlap
- Buttons remain usable
- Section spacing is consistent

## Cache checklist

After every update or style change:

1. Elementor -> Tools -> Regenerate CSS & Data
2. LiteSpeed -> Purge All
3. Browser hard refresh
4. Test in incognito/private window if the frontend still shows old styles

## Troubleshooting

### Widget not visible in Elementor

- Confirm Elementor is active.
- Confirm Amaley Compact Widgets v0.4.19 is active.
- Regenerate Elementor CSS.
- Clear cache.

### Duplicate widget or duplicate controls

- Keep Amaley Compact Spacing Controls v1.0.23 inactive.
- Confirm only one Amaley Compact Widgets version is active.

### Styling not updating

- Regenerate Elementor CSS.
- Purge site cache.
- Hard refresh browser.
- Check that the page is using the v0.4.19 widget, not an old copied section from another plugin instance.

### Frontend looks different from Elementor

- Clear cache.
- Re-save the Elementor page.
- Regenerate CSS.
- Check responsive settings for tablet/mobile separately.

## Rollback

If a final/live install shows issues that cannot be resolved quickly:

1. Restore the last full site backup.
2. Re-test v0.4.19 on staging.
3. Record the exact page, widget and control where the issue appears.
4. Prepare a corrected plugin version before trying again on final/live.

## Production rule

Treat v0.4.19 as the current stable merged checkpoint. Future changes should be versioned as v0.4.20 or later and should include updated README, CHANGELOG and merge notes.
