Amaley Discovery Engine v1.6.2 - Contact Style Control Fix

Purpose:
- Fix contact widget style controls that appeared but did not apply correctly.
- Keep current clean stable widgets only.

Fixes:
1. Contact Hero
- Separated text alignment from button/trust flex alignment.
- Left/center/right now maps to valid CSS for each element.

2. Contact Info Cards
- Fixed duplicate selector bug in Text Alignment control.
- Added Header Text Alignment, Card Text Alignment, and Card Element Alignment separately.

3. Contact Form CTA
- Added Text Element Alignment and Trust Points Alignment.
- Form Panel Inner Gap now applies to panel contents, not only built-in form.
- Added Built-in Form Field Gap.
- Added Form Text Alignment.
- Added Submit Button Alignment.

4. Contact Map
- Added Content Panel Element Alignment.
- Added Map Button Alignment.

Unchanged:
- Product filter logic.
- WooCommerce/product queries.
- Shop Hero/Shop Strip/Universal CTA logic.
- Legacy widgets remain removed.
