# Project Brief

## Project Context

Project goal: convert the existing static frontend into a modern WordPress +
WooCommerce classic theme for the Re Style brand.

The repository now contains:

- a baseline WordPress classic theme scaffold in the repository root
- static prototype references in `sito-statico/`
- project documentation in `docs/`

Static reference materials currently available:

- `sito-statico/index.html`: homepage prototype with one-page sections
- `sito-statico/shop.html`: catalog / shop listing prototype
- `sito-statico/informazioni.html`: customer information page prototype
- `sito-statico/assets/css/style.css`: monolithic stylesheet
- `sito-statico/assets/js/main.js`: small interaction layer

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

## Current Theme Baseline

The scaffold currently includes:

- theme metadata in `style.css`
- bootstrap in `functions.php`
- setup and enqueue modules under `inc/`
- shared shell templates: `header.php`, `footer.php`
- fallback templates: `index.php`, `home.php`, `page.php`, `single.php`,
  `archive.php`, `search.php`, `404.php`
- content partials under `template-parts/content/`
- front-page partials under `template-parts/front-page/`
- site-level partials for topbar and footer menu columns
- initial `theme.json`
- base asset folders under `assets/`
- `woocommerce/` directory reserved for future justified overrides only

This baseline is intentionally minimal and contains no business logic.

The global shell now also includes:

- WordPress-native primary navigation in `header.php`
- WordPress-native footer navigation split into multiple footer menu locations
- a reusable topbar partial for announcement messaging
- CSS-only submenu disclosure based on semantic list markup and keyboard-safe
  `:focus-within` behavior

The homepage baseline now includes:

- a real `front-page.php` assembled from reusable front-page sections
- a dedicated `inc/front-page-data.php` helper for lightweight structured
  default content
- a dedicated `oc_video_tutorial` editorial type for homepage video cards, with
  native admin management for title, cover image and source url/file
- local theme copies of the currently available homepage images
- minimal homepage-only JS for service modal, gallery hover rotation and FAQ
  disclosure

The design-system baseline now includes:

- a selective `theme.json` preset layer for palette, typography, spacing and
  editor-facing global styles
- a runtime token bridge from Customizer settings to CSS custom properties for
  both frontend and editor
- editor styles aligned with the frontend tokens, fonts and baseline typography
- homepage section content editable through native Customizer controls with
  PHP defaults as fallback

The WooCommerce shop baseline now includes:

- a dedicated `inc/woocommerce.php` integration layer for catalog query
  filters, archive helpers and loop hook customization
- a dedicated `assets/css/woocommerce.css` stylesheet that carries the static
  shop prototype layout into the classic theme without mixing it into
  `assets/css/main.css`
- one justified WooCommerce template override:
  `woocommerce/archive-product.php`, used only because the shop prototype
  requires a page-level structure with toolbar, tabs, filter sidebar, results,
  benefits and CTA that cannot be assembled cleanly with hooks/CSS alone
- one justified WooCommerce loop-item override:
  `woocommerce/content-product.php`, introduced after the hook-only card
  approach proved insufficient to keep the product cards visually 1:1 with the
  static shop prototype
- dynamic category tabs, taxonomy-driven sidebar filters, availability filters,
  price range filtering, custom archive search and custom loop cards built on
  top of WooCommerce data rather than hardcoded mockup content

## Working Assumptions

Conservative assumptions documented for this phase:

- theme slug: `re-style`
- text domain: `re-style`
- function prefix: `re_style_`
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
- the new theme scaffold already exposes a smaller baseline stylesheet, but the
  design migration from the prototype is still pending
- no responsive `@media` rules were detected in the static prototype, so
  responsive behavior is likely incomplete or still implicit there
- Google Fonts are imported from static CSS; this should be replaced with a
  proper theme asset strategy during conversion

### Token Strategy

Current direction after the design-token migration:

- `theme.json` owns canonical preset definitions that benefit WordPress and the
  editor directly: palette, font families, font sizes, spacing sizes, layout
  widths and a small set of global element styles
- runtime Customizer overrides map back onto those presets through CSS custom
  properties, so the classic theme keeps one token vocabulary across frontend
  and editor
- `assets/css/main.css` keeps the token aliases, reset/base typography, global
  shell and classic-theme structural rules that are clearer in CSS than in
  `theme.json`
- `assets/css/front-page.css` keeps section-specific layout, component states
  and interaction styling that are tightly coupled to the curated homepage UX
- parity work should restore the static prototype CSS as faithfully as
  possible, reusing the original values and behavior instead of reinterpreting
  them for the theme unless a task explicitly asks for adaptation
- `assets/css/editor.css` mirrors frontend tokens and editorial typography
  rather than duplicating all frontend component rules
- homepage content editing remains native and conservative: Customizer settings
  cover the current hero, service, shop, story, location, gallery, video,
  contacts, FAQ and newsletter copy/link/image needs without introducing custom
  fields or page builders
- homepage video cards now have a richer native editorial model than the other
  sections: they are managed from a dedicated admin menu instead of a textarea
  list in the Customizer because each item needs title, cover image and
  video/file source metadata

### JavaScript Findings

- `main.js` is small and uses vanilla JS progressive enhancement
- behaviors currently cover service modal, gallery hover rotation, nav dropdown,
  video modal and FAQ accordion
- the scaffold includes only a minimal theme script placeholder; behavior
  migration remains a later task

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

## Static-To-Template Mapping

### Global Shell

Map shared chrome into classic templates and reusable partials:

- `header.php`: document head, skip link, site branding, primary navigation
- `footer.php`: footer navigation, legal links area, footer credits
- `template-parts/site/topbar.php`: scrolling announcement bar
- `template-parts/site/floating-actions.php`: floating WhatsApp and booking CTA
- `template-parts/site/icon-sprite.php`: centralized SVG symbol sprite to avoid
  per-page duplication
- `template-parts/navigation/primary.php`: primary menu wrapper and dropdown
  affordances if needed
- `template-parts/navigation/footer.php`: footer menu columns or fallback lists

### Template Hierarchy Targets

- `front-page.php`: curated homepage composed from reusable homepage sections
- `home.php`: editorial posts index only; not a clone of the static homepage
- `page.php`: default static pages with standard content flow
- `single.php`: default post content, initially generic and minimal
- `archive.php`: non-search archives and fallback archive rendering
- `search.php`: generic search result listing
- `404.php`: lightweight branded not-found state

### Homepage Section Mapping

The current `sito-statico/index.html` should be decomposed into:

- `template-parts/front-page/hero.php`
- `template-parts/front-page/services.php`
- `template-parts/front-page/shop-categories.php`
- `template-parts/front-page/history.php`
- `template-parts/front-page/gallery.php`
- `template-parts/front-page/video-tips.php`
- `template-parts/front-page/location-hours.php`
- `template-parts/front-page/contacts.php`
- `template-parts/front-page/faq.php`
- `template-parts/front-page/newsletter.php`

Recommended behavior:

- `front-page.php` orchestrates the section order only
- each section partial owns its local markup
- modal containers that are section-specific stay close to their section partial
- repeated CTA styles stay in assets, not in section-specific business logic

Current implementation status:

- implemented: hero, services, shop categories, history, location/hours,
  gallery, video tips, contacts, FAQ, newsletter
- implemented as reusable site pieces: icon sprite and floating actions
- current compromise: structured homepage copy is still theme-defined through a
  PHP data helper instead of a richer editorial UI
- current compromise: video cards now support admin-managed uploads and
  embeddable links, with theme defaults kept only as a fallback when no
  published tutorial exists yet

### Information Page Mapping

The current `sito-statico/informazioni.html` should become a native WordPress
page using `page.php` or a focused page template only if the anchor layout
needs dedicated control.

Reusable partial candidates:

- `template-parts/page/info-hero.php`
- `template-parts/page/info-sections.php`
- `template-parts/common/faq.php`

Current recommendation:

- start with standard `page.php` plus content-aware partials
- introduce a custom page template only if the anchor navigation and repeated
  info-card layout become awkward in the default page flow

### Shop And WooCommerce Mapping

The current `sito-statico/shop.html` is a visual reference for WooCommerce, not
an independent hardcoded shop template.

Preferred mapping:

- product archive and shop index: WooCommerce archive flow styled by theme CSS
- toolbar/search/sort areas: hooks, wrappers and CSS before overrides
- filter sidebar: deferred until the project confirms whether it relies on
  WooCommerce core widgets, blocks in classic theme context, or a plugin
- product cards: theme styles aligned with WooCommerce loop markup
- pagination: theme styles applied to WooCommerce pagination output
- benefits and final CTA: optional archive-adjacent partials if retained in the
  final UX

Potential reusable WooCommerce-oriented partials:

- `template-parts/woocommerce/archive-intro.php`
- `template-parts/woocommerce/archive-benefits.php`
- `template-parts/woocommerce/archive-cta.php`

Current implementation status:

- implemented: `woocommerce/archive-product.php` as a single justified
  override for the archive page shell, plus `woocommerce/content-product.php`
  as a narrow justified override for exact product-card parity
- implemented: dynamic toolbar search, WooCommerce ordering dropdown,
  top-level category tabs, taxonomy-aware filter sidebar, custom result count,
  custom product cards and archive pagination styling
- implemented: on tablet/mobile the filter sidebar now becomes an off-canvas
  drawer opened from the toolbar, so the archive stays compact without losing
  the same filter set available on desktop
- implemented: benefits and final CTA as reusable archive-adjacent template
  parts
- implemented: "Novita" badges now mark the latest 5 published products within
  each product category
- current compromise: the sidebar lists all non-empty product taxonomies and
  product attributes dynamically, so the number of filter groups may exceed the
  exact mockup when the catalog grows
- current compromise: the wishlist/favorites control inside product cards is
  normalized with defensive CSS because plugin markup can vary; it is styled as
  a consistent floating heart button without introducing a theme-side plugin
  dependency
- implemented: single product layout now stays on WooCommerce core templates
  and is reshaped via hooks/CSS/JS first, with no additional legacy single
  template override; description, quantity stepper, related products and a
  dedicated reviews section are arranged from the theme integration layer
- implemented: the wishlist/favorites control for shop cards and single-product
  summary is now rendered by the theme using the shared `icon-favourite` and
  `icon-favourite-solid` symbols, while keeping compatibility with the plugin's
  current `localStorage` key for stored items
- current compromise: the single-product wishlist position is styled
  defensively when a wishlist plugin injects markup into the summary, but the
  theme still does not hard-depend on any one plugin implementation

### Shared Reusable Blocks

Patterns that should not remain duplicated:

- FAQ accordion
- section heading pattern with label + title + intro copy
- CTA button variants
- contact/social block
- legal/footer link groups

Suggested homes:

- `template-parts/common/section-heading.php`
- `template-parts/common/faq.php`
- `template-parts/common/social-links.php`
- `template-parts/common/contact-list.php`

### Asset Reuse And Reorganization

Static assets to preserve and reorganize:

- move reusable images into theme `assets/img/`
- split CSS into global foundations, layout, components and page/context files
- migrate JS into small, scoped modules or guarded initializers inside the
  theme script
- replace duplicated inline SVG sprites with one shared include strategy

Recommended asset grouping:

- `assets/css/base.css`: reset, tokens, typography, utilities
- `assets/css/layout.css`: header, footer, wrappers, grid primitives
- `assets/css/components.css`: buttons, cards, accordion, modal, nav dropdown
- `assets/css/front-page.css`: homepage-only sections
- `assets/css/woocommerce.css`: WooCommerce-specific styling
- `assets/css/pages.css`: informational page patterns if needed
- `assets/js/theme.js`: guarded global bootstrap
- `assets/js/modules/`: optional later modules for modal, FAQ, dropdown, gallery

### Asset Risks And Gaps

- shop product images referenced in static markup are still missing
- video covers and mp4 files referenced by the homepage are still missing
- Google Fonts import in static CSS must be replaced by explicit theme asset
  loading strategy
- text encoding should be normalized before content migration to avoid carrying
  broken characters into templates

### Mapping Assumptions

- homepage content remains curated and theme-driven in the short term
- `home.php` serves posts/blog concerns, not marketing homepage concerns
- WooCommerce markup should stay as close as possible to plugin defaults
- repeated FAQ content may appear both on homepage and informational contexts,
  so it should be designed as a reusable partial rather than duplicated markup
- legal pages are assumed to be normal WordPress pages, linked from menus/footer

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

Planned next tasks after the mapping phase:

1. `T032` - Implement WooCommerce cart, checkout and account styling using
   hooks/CSS first, documenting any override that proves necessary.
2. `T033` - Convert the information area into native WordPress pages or focused
   page templates and define handling for legal/support content.
3. `T034` - Run hardening pass on responsiveness, accessibility, encoding,
   missing assets/content placeholders and documentation updates.

## Open Decisions

- whether homepage sections will remain theme-driven or require a richer native
  editing model
- whether booking functionality will stay external or require future WordPress
  integration
- whether future WooCommerce flows beyond the archive can stay hook-first or
  will require additional narrow overrides
