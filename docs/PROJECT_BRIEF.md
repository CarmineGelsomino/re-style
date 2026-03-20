# Project Brief

## Project Context

Project goal: convert the existing static frontend into a modern WordPress +
WooCommerce classic theme for the Re Style brand.

The repository currently contains only analysis and prototype materials:

- `sito-statico/index.html`: homepage prototype with one-page sections
- `sito-statico/shop.html`: catalog / shop listing prototype
- `sito-statico/informazioni.html`: customer information page prototype
- `sito-statico/assets/css/style.css`: monolithic stylesheet
- `sito-statico/assets/js/main.js`: small interaction layer

No WordPress theme scaffold exists yet.

## Primary Objective

Build a maintainable classic theme that preserves the existing visual identity
while adopting native WordPress and WooCommerce conventions.

## Mandatory Architecture

Non-negotiable constraints:

- classic theme only
- classic PHP templates and standard template hierarchy
- WooCommerce compatible from the start
- no page builder
- no block theme / no FSE migration
- no unnecessary dependencies

Recommended architectural direction:

- `theme.json` used selectively for design tokens, editor settings and global
  styles inside a classic theme
- shared template parts for header, footer and reusable sections
- WooCommerce integration via support flags, hooks and CSS before template
  overrides
- minimal custom PHP with clear separation between setup, rendering helpers and
  integration code

## Working Assumptions

Conservative assumptions documented for this phase:

- provisional theme slug: `re-style`
- provisional text domain: `re-style`
- the static frontend is the visual reference, not the final implementation
  architecture
- native WordPress editing should be preferred before introducing custom-field
  plugins
- homepage content may initially be assembled with template parts and native
  content sources until stricter editorial requirements are defined

## Static Frontend Analysis

### Page Inventory

- Homepage prototype: hero, services, featured shop categories, story, gallery,
  video tips, contacts, FAQ, newsletter and footer
- Shop prototype: search, sort, category tabs, filter sidebar, product grid,
  pagination, benefits and CTA
- Information prototype: anchor navigation plus sections for shipping, returns,
  payments, support and FAQ

### Reusable UI Patterns

- fixed topbar and fixed header
- shared footer structure
- repeated dropdown navigation pattern
- CTA buttons with consistent visual language
- FAQ accordion pattern
- modal pattern for service details and video playback

### CSS Findings

- a single stylesheet of about 2219 lines drives the whole prototype
- design tokens already exist in `:root`, which makes a later `theme.json`
  bridge feasible
- the homepage is heavily modeled as a viewport-driven one-page experience with
  `scroll-snap` and full-height sections
- the shop page already breaks that model and introduces a more conventional
  document flow
- no responsive `@media` rules were detected, so responsive behavior is likely
  incomplete or still implicit
- Google Fonts are imported from CSS; this should be replaced with proper theme
  enqueue strategy during conversion

### JavaScript Findings

- `main.js` is small and uses vanilla JS progressive enhancement
- behaviors currently cover service modal, gallery hover rotation, nav dropdown,
  video modal and FAQ accordion
- scripts are globally loaded and will need context-aware initialization once
  moved into theme templates

### Content And Asset Gaps

- shop markup references `product-1.webp` through `product-9.webp`, but those
  images are not present in `sito-statico/assets/img/`
- homepage markup references `video-cover-1.webp` through `video-cover-4.webp`
  and `/assets/video/*.mp4`, but those files are not present in the repository
- several links are placeholders: account, wishlist, cart, booking, legal pages
  and some shop category destinations
- icon sprite markup is duplicated across static pages and should be normalized
  during theme conversion
- terminal output shows text encoding anomalies in current content, so UTF-8
  normalization must be part of the migration baseline

## Architectural Implications For The Theme

The prototype should not be copied literally.

Key translation decisions:

- convert the fixed shell into shared WordPress theme templates
- treat the homepage as a curated front page, not as a full-site navigation
  model
- map the static shop page to WooCommerce archive behavior instead of custom
  hardcoded catalog markup
- map the information page to native WordPress pages or a focused page template
- keep dynamic interactions optional and scoped per template
- centralize design tokens so CSS custom properties and `theme.json` can coexist

## Expected Quality

- semantic HTML and clear heading hierarchy
- responsive behavior on mobile and desktop
- keyboard-safe navigation and interactive states
- WCAG 2.2 AA aware implementation
- translation-ready strings
- SEO-safe markup and plugin compatibility
- restrained asset loading and maintainable file organization

## Documentation Sources Of Truth

- `AGENTS.md`: stable operating rules for future tasks
- `docs/PROJECT_BRIEF.md`: functional and technical brief
- `docs/IMPLEMENTATION_LOG.md`: chronological implementation log

## Next Task Roadmap

Planned next tasks after this analysis phase:

1. `T001` - Create the WordPress theme scaffold with `style.css`,
   `functions.php`, `theme.json`, asset folders and `inc/` structure.
2. `T002` - Define the global design system migration: move prototype tokens to
   theme variables, enqueue fonts/assets correctly and split monolithic CSS.
3. `T003` - Implement shared global layout: `header.php`, `footer.php`, menus,
   custom logo, topbar strategy and base template parts.
4. `T004` - Convert the homepage into `front-page.php` plus reusable
   template-parts for hero, services, story, gallery, FAQ and newsletter.
5. `T005` - Integrate WooCommerce baseline support, wrapper alignment and shop
   archive styling with minimal or no template overrides.
6. `T006` - Implement WooCommerce single product, cart, checkout and account
   styling using hooks/CSS first, documenting any override that proves
   necessary.
7. `T007` - Convert the information area into native WordPress pages or focused
   page templates and define handling for legal/support content.
8. `T008` - Run hardening pass on responsiveness, accessibility, encoding,
   missing assets/content placeholders and documentation updates.

## Open Decisions

- whether homepage sections will remain theme-driven or require a richer native
  editing model
- whether booking functionality will stay external or require future WordPress
  integration
- which WooCommerce templates, if any, truly need overrides after hook-first
  integration
