# QA CHECKLIST — Amaley WordPress System

This checklist must be used before approving any major Amaley website, plugin, template, UI section, data, or migration update.

No change is complete until it is tested, documented, and rollback-safe.

---

## 1. Backup and Version Check

Before making changes:

- Latest `.wpress` backup is available where relevant
- Backup is stored in Google Drive
- Current active plugin versions are recorded
- Current WordPress version is noted where relevant
- Current PHP version is noted where relevant
- Current WooCommerce version is noted where relevant
- Rollback file or rollback plan is available
- Changelog is ready to update
- Work is happening on staging/fresh/safe environment unless explicitly approved

Do not proceed if rollback is unclear.

---

## 2. GitHub / Drive Check

Before uploading or committing:

- No `.wpress` backup is uploaded to GitHub
- No full website ZIP is uploaded to GitHub
- No random plugin ZIP is uploaded to GitHub
- No image dump is uploaded to GitHub
- No video file is uploaded to GitHub
- No password, API key, license key, or `wp-config.php` is uploaded
- Heavy files remain in Google Drive
- GitHub contains only clean source code and documentation
- Commit message clearly explains the change

---

## 3. Step-by-Step Workflow Check

Before starting work:

- Only one task is active
- No parallel build/update/confusion
- Current step is clearly named
- Approval is taken before plugin build
- Approval is taken before ZIP creation
- Approval is taken before Drive upload
- Approval is taken before GitHub structural change
- Current step is checked before moving to next step

No build should start without approval.

---

## 4. Plugin Activation Check

Check these after plugin install/update:

- WordPress admin opens without error
- No critical error
- No PHP warning visible
- Plugin activates successfully
- Plugin deactivates safely
- Plugin reactivates safely
- Plugin version is visible where relevant
- No old plugin version accidentally activated
- No duplicate plugin/module names
- No broken shortcode
- No broken admin screen
- No frontend slowdown caused by admin/debug tools
- Safe fallback appears if dependency is missing

---

## 5. WooCommerce Check

WooCommerce must remain the commerce engine.

Test:

- Product page opens
- Product image gallery works
- Product title appears correctly
- Product price appears correctly
- Product sale price appears correctly if used
- Product variations work if product has variations
- Add to cart works
- Cart page opens
- Cart quantity update works
- Checkout page opens
- Coupon field works if enabled
- Order flow works
- Stock status appears correctly
- Reviews appear correctly if enabled
- No custom Amaley plugin replaces WooCommerce core flows
- No plugin breaks WooCommerce templates

---

## 6. Amaley Core Check

For Amaley Core updates:

- Plugin activates successfully
- Dashboard opens successfully
- Schema/version info appears correctly where relevant
- Cluster CPT/data works
- SHG Group CPT/data works
- Member / Producer CPT/data works
- Product Origin Mapping panel works
- Import/export works in dry-run where relevant
- Actual import works only after dry-run passes
- No duplicate Cluster records are created
- No fake Cluster / SHG / Producer / origin data is created
- Product origin mapping can be saved
- Product origin export can be verified
- WooCommerce product edit screen is not broken
- Core does not become a frontend design plugin

---

## 7. Amaley Discovery Engine Check

For Discovery Engine updates:

- Product grid loads
- Product filters load properly
- Category filters work
- Origin filters work
- Cluster filters work
- SHG filters work
- Producer filters work where relevant
- Search works
- Sorting works
- Pagination works
- Active filter chips work
- Mobile filter drawer works
- Empty state appears safely
- No CPT duplication
- No conflict with Amaley Core
- No conflict with Amaley Templates
- No conflict with Amaley UI Sections Kit
- No unlimited frontend queries
- Query limits are safe
- Filters do not permanently depend on JetEngine or Smart Filters

---

## 8. Amaley Site Shell Check

For Site Shell updates:

- Header shortcode works
- Footer shortcode works
- Mobile header works
- Mobile drawer works
- Navigation links work
- Announcement strip works if enabled
- CTA controls work if enabled
- Footer contact controls work
- Footer links work
- Header does not blindly override current/live header
- Footer does not blindly override current/live footer
- Auto Header Render remains OFF unless explicitly approved
- Auto Footer Render remains OFF unless explicitly approved
- Full replacement is tested only on fresh/staging after current header/footer source is confirmed
- No layout conflict with theme header/footer
- No z-index conflict on mobile menu
- No public frontend slowdown

---

## 9. Amaley UI Sections Kit Check

For future UI Sections Kit work:

- No Elementor Heading widget dependency
- No Elementor Button widget dependency
- No Elementor Icon Box widget dependency
- No Elementor Image Box widget dependency
- No Elementor HTML widget dependency
- No Elementor generic section layout dependency as the main system
- No CPT creation
- No WooCommerce replacement
- No header/footer replacement
- No discovery/filter engine replacement
- Components are WordPress-native / theme-like
- Components use scoped CSS
- Components use small vanilla JavaScript only where required
- Components support global design tokens
- Components are mobile-first
- Components are low-network-ready
- Components are easy to disable
- Components are rollback-safe
- No plugin ZIP is built until structure, inventory, design tokens, and phase plan are approved

Test relevant components:

- Buttons
- Button groups
- Section headings
- Heading strips
- Promise strips
- Product cards
- Product grids
- Story sections
- Media + text sections
- Trust strips
- CTA bands
- Origin blocks
- Cluster cards
- SHG / women collective cards
- Contact blocks
- Footer CTA sections

---

## 10. Amaley Templates Check

For Amaley Templates updates:

- Existing product template sections work
- Existing shop template sections work
- Product Hero section works
- Product Info Tabs work
- Product Trust Strip works
- Origin / traceability display works
- Shop hero works if used
- Shop discovery layout works if used
- Style controls are visible section-wise where relevant
- Responsive controls work where relevant
- WooCommerce add-to-cart still works
- Variable product selector works if product has variations
- No WooCommerce cart/checkout override is broken
- Future clean reusable UI components are not forced into Elementor default widgets
- Future clean UI components are planned for Amaley UI Sections Kit

---

## 11. Project Guard Check

For Project Guard updates:

- Admin dashboard opens
- Active Amaley plugin versions are visible
- WooCommerce dependency status is visible
- Missing dependency warnings are clear
- Duplicate/old plugin warnings are clear
- CPT/field checks are visible where relevant
- No sensitive information is exposed
- Dashboard is admin-only
- Frontend users cannot access diagnostics
- Heavy checks run only in admin/manual diagnostic context
- Public frontend does not slow down

---

## 12. Debug Toolkit Check

For Debug Toolkit updates:

- Admin-only access works
- Permission checks work
- Plugin health status appears
- Module/component registration status appears
- WooCommerce dependency status appears
- Product/origin data issues appear where relevant
- Cache warnings appear where relevant
- Exportable debug report works if implemented
- No secrets are exposed
- No full error logs are shown publicly
- Debug can be disabled easily
- Public frontend does not slow down

---

## 13. Elementor Migration Context Check

Elementor may still exist in old/current migration contexts.

Check only where relevant:

- Elementor editor loads for old/current pages
- Template preview loads for old/current templates
- CSS regenerates properly where needed
- Existing Elementor sections are not broken during migration
- Existing Elementor Pro templates are not removed blindly
- Existing Elementor-based content is replaced only after approved alternative is ready
- Future clean UI sections are not built with Elementor default widgets

After major Elementor-related migration update:

- Regenerate Elementor CSS
- Clear cache
- Test frontend again

---

## 14. Design System Check

Compare every section with:

```text
docs/AMALEY_DESIGN_SYSTEM_LOCKED.md
```

Check:

- Font family
- Heading size
- Body text size
- Text color
- Background color
- Button style
- Card radius
- Card shadow
- Spacing
- Image crop
- Mobile layout
- Premium earthy feel
- Himalayan / natural / trust positioning
- Women collective / community-rooted positioning where relevant

If it does not match the design system, it is not ready.

---

## 15. Global Design Token Check

For any future UI/component work, check:

- Brand colors are controlled globally
- Background colors are controlled globally
- Text colors are controlled globally
- Heading font is controlled globally
- Body font is controlled globally
- Font sizes are controlled globally where practical
- Button styling is controlled globally
- Border radius is controlled globally
- Card styling is controlled globally
- Shadows are controlled globally
- Section spacing is controlled globally
- Mobile spacing is controlled globally
- Product card styling is controlled globally where relevant
- Trust strip styling is controlled globally where relevant

If global font, color, radius, spacing, or button style changes, connected UI components should update without editing every section manually.

---

## 16. Performance / Low-Network Check

Every frontend update must be tested for lightweight performance.

Check:

- No unnecessary external libraries
- No heavy animation libraries
- No global CSS dumps
- No duplicate CSS/JS
- No unnecessary frontend requests
- No unlimited frontend queries
- No frontend-heavy diagnostics
- Images are optimized
- Lazy loading is used where appropriate
- HTML output is clean
- JavaScript is small and necessary
- Admin/debug tools do not load heavy assets on public frontend
- Component remains usable on low-network conditions
- Mobile load experience is acceptable

If a component looks premium but makes the site heavy, it is not approved.

---

## 17. Responsive Check

Test these widths:

```text
360px
390px
430px
768px
1024px
1366px
```

Check:

- No horizontal scroll
- Header fits
- Footer fits
- Product cards fit
- Product grids adapt
- Buttons do not break
- Text remains readable
- Images do not distort
- Filter drawer works on mobile
- CTA sections remain clean
- Spacing is not too large on mobile
- Touch targets are usable

---

## 18. Accessibility and Usability Check

Check:

- Buttons have clear text
- Links are understandable
- Contrast is readable
- Mobile tap areas are usable
- Important content is not hidden
- Forms show clear labels
- Error states are understandable
- Empty states are helpful
- Navigation is clear
- User can return/back out of overlays/drawers/popups

---

## 19. Security Check

Check:

- Direct access protection exists in PHP files
- Nonces are used for state-changing actions
- Capability checks are used for admin actions
- Inputs are sanitized
- Outputs are escaped
- File uploads are restricted where applicable
- No database credentials are exposed
- No API keys are exposed
- No license keys are exposed
- No `wp-config.php` information is exposed
- Debug output is not public

---

## 20. Documentation Check

After serious updates:

- `docs/CHANGELOG.md` is updated
- `docs/PROJECT_MANIFEST.md` is updated if architecture changed
- `plugins/README.md` is updated if plugin/module structure changed
- Relevant plugin/module README is updated
- Version number is updated where relevant
- Commit message is clear
- Rollback note exists where relevant
- Testing status is recorded

---

## 21. Final Approval Gate

Do not approve the update unless:

- It is tested
- It is documented
- It is versioned
- It is rollback-safe
- It is WooCommerce-safe
- It is mobile-safe
- It is lightweight
- It is low-network-ready
- It respects the no-Elementor future UI rule where applicable
- It respects global design-token direction where applicable
- It does not create dependency confusion
- It does not break future migration

If it is not tested, it is not done.
