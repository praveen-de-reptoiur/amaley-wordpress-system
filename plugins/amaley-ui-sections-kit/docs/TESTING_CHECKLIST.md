# Testing Checklist — Amaley UI Sections Kit v0.6.4.1

Use this checklist on staging before moving the plugin to live.

## 1. Backup first

- Create a ZIP backup of the current working plugin folder.
- Keep the previous safe backup available before replacing files.
- Do not test directly on live.

## 2. Activation and version

- Upload/replace on staging only.
- Confirm plugin activates without PHP fatal error.
- Confirm WordPress Plugins page shows:

```text
Amaley UI Sections Kit — Version 0.6.4.1
```

## 3. Pages Hero Other widget visibility

Open Elementor and confirm the widget appears under:

```text
Amaley UI > Amaley Pages Hero Other
```

Confirm the style dropdown includes active styles:

```text
Style 1, Style 2, Style 3, Style 5, Style 6, Style 7, Style 8, Style 9, Style 10, Style 11, Style 12, Style 13
```

Style 4 should not appear.

## 4. Selected-style control check

For each selected style, confirm unrelated controls do not appear.

Minimum check:

- Style 1 shows right text panel controls.
- Style 2 shows stats controls.
- Style 3 shows intent card and stats controls.
- Style 6 shows image/media controls.
- Style 7 shows editorial note, image/media and stats controls.
- Style 8 shows statement pill controls.
- Style 10 shows the accepted `Style 10 — Visibility (Device Wise)` and its existing style controls.
- Style 12/13 show statement pill controls.

## 5. Stats gap test

For Style 3 and one editorial style such as Style 7 or Style 9:

- Open `Stats / Proof` controls.
- Change `Value and Label Gap`.
- Confirm spacing changes between the stat value and stat label.
- Test `Label Top Spacing Fallback` only if the label still appears too close.

## 6. Responsive test

Check Desktop, Tablet and Mobile preview in Elementor.

Confirm:

- No horizontal scroll.
- No text overflow.
- Images do not collapse into very small height.
- Editorial note cards stay readable.
- Stats stack or fit properly on mobile.
- Buttons do not overlap.
- Device-wise visibility controls work where tested.

## 7. Style 10 safety test

Style 10 was the accepted base. Confirm after v0.6.4.1:

- Existing Style 10 layout still looks the same.
- Style 10 device visibility still works.
- Style 10 stats controls still work.
- Style 10 image/media controls still work.
- No duplicate Show/Hide panel appears for Style 10.

## 8. Other plugin safety

Confirm these areas still work and were not affected:

- Amaley Discovery Engine filters and product grid.
- Amaley Core CPT pages/cards.
- Amaley Templates widgets.
- Header/footer.
- WooCommerce product pages.
- Cart and checkout.
- Existing Home Hero V6.
- Existing Page Trust Strip.

## 9. Cache cleanup

If Elementor does not show new controls:

1. Elementor → Tools → Regenerate CSS & Data.
2. Elementor → Tools → Sync Library.
3. Clear site/cache plugin cache if used.
4. Close Elementor and reopen the page.
5. Hard refresh the browser.

## 10. Live move rule

Move to live only after at least these are checked on staging:

- One page using Style 10.
- One page using Style 3 or Style 7.
- One mobile preview.
- One checkout/cart safety check.
