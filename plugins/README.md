## Dependency Direction

The future Amaley system should not depend on ACF, CPT UI, JetEngine, Smart Filters, or random utility plugins as permanent core dependencies.

These plugins may exist in the old/current WordPress setup, but they are not part of the target architecture.

Target direction:

- Amaley Core will manage custom post types and fields.
- Amaley Discovery Engine will manage discovery, filters, listings, and pagination.
- Amaley Templates will manage Elementor-native visual sections and templates.
- Amaley Project Guard / Debug Toolkit will manage health checks, dependency warnings, and debug visibility.

## Custom Data System Plan

Amaley will eventually manage its own data structures for:

- Clusters
- SHG Groups
- SHG Members
- Product origin mapping
- Producer / maker profiles
- Source village / region information
- Traceability fields
- Product usage and storage fields

These should not remain permanently dependent on ACF or CPT UI.

## Filtering System Plan

Amaley should not depend permanently on JetEngine or Smart Filters.

Filtering should be handled by Amaley Discovery Engine.

Discovery Engine should support:

- Product filters
- Category filters
- Origin filters
- Cluster filters
- SHG filters
- Producer filters
- Search
- Sorting
- Pagination
- Mobile filter drawer
- Safe empty-state handling

## Migration Warning

Do not remove ACF, CPT UI, JetEngine, Smart Filters, or any existing dependency from the current live site blindly.

They may still be supporting old content, fields, templates, or filters.

Removal must happen only after Amaley Core and Amaley Discovery Engine fully replace the required functionality and QA is complete.
