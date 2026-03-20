# Implementation Log

## Logging Rule

For every task, add a new section with:

- Task ID
- Objective
- Files read
- Files created/modified
- Decisions made
- Assumptions
- Verification
- TODO / residual risks

---

## T000

### Objective

Establish the project operating baseline, analyze the current repository and
document the conversion plan from static frontend to a modern WordPress +
WooCommerce classic theme.

### Files Read

- `AGENT.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `README.md`
- `sito-statico/index.html`
- `sito-statico/shop.html`
- `sito-statico/informazioni.html`
- `sito-statico/assets/css/style.css`
- `sito-statico/assets/js/main.js`
- repository file inventory via `rg --files`

### Files Created/Modified

- `AGENTS.md`
- `AGENT.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- `AGENTS.md` becomes the canonical root operations document; `AGENT.md` stays
  as a compatibility alias.
- The target architecture is confirmed as a WordPress classic theme with
  standard PHP templates and template hierarchy.
- `theme.json` is approved only as a selective tool for design tokens, editor
  settings and global styles inside the classic theme.
- WooCommerce integration will follow a hook-first and support-first approach,
  minimizing legacy template overrides.
- The static frontend is the visual reference, but the future theme must not
  inherit prototype rigidities such as full-page `scroll-snap` behavior.
- Work will proceed in small documented tasks, starting with scaffold, shared
  layout, homepage conversion and WooCommerce baseline integration.

### Assumptions

- Provisional theme slug, text domain and prefix can all use `re-style`.
- No page builder or extra custom-field dependency is assumed at this stage.
- Native WordPress editing should be preferred until a stronger content model is
  proven necessary.
- Missing product images, video covers and video files are considered expected
  prototype gaps, not blockers for the planning phase.
- UTF-8 normalization will likely be required during migration because current
  terminal reads show encoding anomalies.

### Verification

- Root and static frontend structure were inventoried.
- Shared UI patterns and likely WordPress template targets were mapped.
- CSS and JS architecture were reviewed for migration impact.
- Missing referenced media files were identified from the static markup.
- Project governance documents were updated to reflect the real repository
  state and the next 8-task roadmap.

### TODO / Residual Risks

- Create the actual WordPress theme scaffold in the next task.
- Split the monolithic CSS into theme-oriented layers without losing the visual
  language.
- Rework one-page assumptions into a robust WordPress navigation/content model.
- Decide how homepage structured content should be edited natively.
- Validate which WooCommerce screens can be solved with CSS/hooks alone before
  considering overrides.
- Replace or source missing media assets referenced by the prototype.

---

## T001

### Objective

Create the initial scaffold of a modern WordPress classic theme that is
activable, readable and ready for the next conversion tasks.

### Files Read

- `AGENT.md`
- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- repository file inventory via `rg --files`
- current root structure via `Get-ChildItem`

### Files Created/Modified

- `style.css`
- `functions.php`
- `index.php`
- `header.php`
- `footer.php`
- `front-page.php`
- `home.php`
- `page.php`
- `single.php`
- `archive.php`
- `search.php`
- `404.php`
- `searchform.php`
- `comments.php`
- `theme.json`
- `inc/theme-setup.php`
- `inc/enqueue.php`
- `inc/template-tags.php`
- `assets/css/main.css`
- `assets/css/editor.css`
- `assets/js/theme.js`
- `template-parts/content/content.php`
- `template-parts/content/content-page.php`
- `template-parts/content/content-search.php`
- `template-parts/content/content-none.php`
- `woocommerce/.gitkeep`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The theme scaffold lives in the repository root and uses `re-style` as theme
  slug and text domain.
- The architecture remains a classic theme: PHP templates drive rendering,
  while `theme.json` is limited to tokens, layout and editor-adjacent defaults.
- Theme setup concerns were separated into `inc/` modules to keep
  `functions.php` minimal.
- WooCommerce support was declared early, but no template overrides were added.
- Shared navigation uses safe fallbacks so the theme remains activable even
  before menus are assigned in WordPress admin.
- Base CSS is intentionally small and structural; no full static design
  migration was attempted in this task.

### Assumptions

- WordPress core will provide the runtime environment for template functions and
  asset loading.
- The current task only requires a safe scaffold, not a visual reproduction of
  the static prototype.
- Editor styles can remain minimal until the design-token migration task.
- The `woocommerce/` directory should exist now as a reserved location, even if
  still empty.

### Verification

- All required root theme files and support directories were created.
- Template hierarchy now has valid fallbacks for index, front page, home, page,
  single, archive, search and 404.
- `functions.php` only bootstraps modular includes and introduces no business
  logic.
- Menu fallbacks were added to avoid missing-callback issues during activation.
- No WooCommerce override templates were introduced.

### TODO / Residual Risks

- Run PHP lint and activate the theme in a real WordPress install when the
  execution environment is available.
- Replace placeholder base styling with the actual design-system migration in
  `T002`.
- Decide whether to load webfonts locally or via a controlled external strategy.
- Add screenshot, translation files and richer template parts only when the next
  tasks justify them.

---

## T002

### Objective

Analyze the static frontend and convert its structure into a concrete mapping
for classic WordPress templates, reusable partials and theme asset
organization.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/shop.html`
- `sito-statico/informazioni.html`

### Files Created/Modified

- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The static homepage is mapped to `front-page.php` orchestrating reusable
  section partials instead of one monolithic template.
- `home.php` is reserved for the posts index and will not replicate the
  marketing homepage.
- Shared topbar, floating actions, icon sprite, navigation and footer concerns
  should become reusable site-level partials.
- The static information page should start as a native WordPress page flow and
  only become a dedicated page template if the anchored layout requires it.
- The static shop page is treated as a WooCommerce visual reference, not a
  standalone hardcoded shop template.
- FAQ, section heading, contact/social and CTA patterns should be normalized
  into common partials or components instead of duplicated markup.
- Asset migration should split the static monolithic CSS into theme-oriented
  layers and centralize the SVG sprite strategy.

### Assumptions

- Homepage sections remain curated by the theme in the short term.
- Legal pages will be regular WordPress pages linked from menus/footer.
- Shop filters are deferred until the final source of filtering behavior is
  confirmed.
- Missing media files remain prototype gaps and do not block template mapping.
- Preserving design intent means preserving section hierarchy and interaction
  semantics, not reproducing the current static file boundaries literally.

### Verification

- Homepage, shop and informational page structures were re-read and classified.
- A concrete mapping was documented for the requested core templates:
  `front-page.php`, `home.php`, `page.php`, `single.php`, `archive.php`,
  `search.php` and `404.php`.
- Reusable partial candidates and asset reorganization targets were documented.
- Open assumptions and structural risks were recorded for future tasks.

### TODO / Residual Risks

- Implement the design-system migration described by the new mapping in the next
  task.
- Confirm whether the informational page can stay within `page.php` or deserves
  a dedicated template.
- Decide the final strategy for WooCommerce archive extras such as benefits and
  CTA sections.
- Normalize encoding before large-scale content migration.
- Source or replace missing product and video assets before final visual
  conversion.

---

## T003

### Objective

Convert the static header, footer and menu patterns into native WordPress
classic theme components with accessible navigation behavior.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `footer.php`
- `inc/theme-setup.php`
- `inc/template-tags.php`
- `assets/css/main.css`

### Files Created/Modified

- `header.php`
- `footer.php`
- `inc/theme-setup.php`
- `inc/template-tags.php`
- `assets/css/main.css`
- `template-parts/site/topbar.php`
- `template-parts/navigation/footer-column.php`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- Primary navigation remains a native `wp_nav_menu()` output in `header.php`
  with semantic list markup and no JS dependency.
- Footer navigation was split into dedicated menu locations to preserve the
  multi-column structure of the static design using native WordPress menus.
- The topbar was extracted into a reusable partial instead of remaining embedded
  in the header template.
- Submenu behavior is handled with CSS using hover and `:focus-within`, keeping
  keyboard access without introducing extra JavaScript.
- Existing fallback behavior was extended so the theme still renders usable
  navigation before menus are assigned in wp-admin.
- Styling was updated to move the scaffold closer to the static header/footer
  intent while keeping the implementation maintainable.

### Assumptions

- Footer content groups are best represented as separate WordPress menu
  locations rather than hardcoded link lists.
- A CSS-only submenu is sufficient for the current desktop/mobile scope.
- Topbar messages can remain theme-defined for now until content requirements
  justify a richer editorial source.
- Icon actions from the static prototype are deferred because they currently
  point to placeholder destinations and are not required for native menu
  integration.

### Verification

- Header and footer now use WordPress-native menu locations rather than a
  single generic footer menu.
- Navigation markup remains semantic with `nav`, list output and visible focus
  treatment in CSS.
- Keyboard users can reveal submenu items through `:focus-within`.
- No JavaScript was introduced for navigation behavior.
- Documentation was updated to reflect the new global shell baseline.

### TODO / Residual Risks

- Validate submenu behavior in a real WordPress browser runtime once menus are
  populated.
- Decide whether topbar messages should later come from Customizer, options or
  remain code-defined.
- Revisit mobile navigation if the real menu depth grows beyond the current
  CSS-only approach.
- Continue with design-system and asset layer migration in the next task.

---

## T004

### Objective

Convert the static homepage into a real `front-page.php` implementation with
reusable classic theme partials and a maintainable structure.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `front-page.php`
- `sito-statico/index.html`
- `sito-statico/assets/js/main.js`
- `assets/js/theme.js`
- current assets inventory under `assets/`

### Files Created/Modified

- `front-page.php`
- `functions.php`
- `inc/enqueue.php`
- `inc/front-page-data.php`
- `assets/css/front-page.css`
- `assets/js/theme.js`
- `template-parts/site/icon-sprite.php`
- `template-parts/site/floating-actions.php`
- `template-parts/front-page/hero.php`
- `template-parts/front-page/services.php`
- `template-parts/front-page/shop-categories.php`
- `template-parts/front-page/history.php`
- `template-parts/front-page/location-hours.php`
- `template-parts/front-page/gallery.php`
- `template-parts/front-page/video-tips.php`
- `template-parts/front-page/contacts.php`
- `template-parts/front-page/faq.php`
- `template-parts/front-page/newsletter.php`
- copied available static images into `assets/img/`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The homepage is now orchestrated by `front-page.php`, while each major static
  section lives in its own partial under `template-parts/front-page/`.
- A lightweight PHP data helper centralizes the current homepage defaults so the
  template files stay readable and hardcoding is reduced.
- Existing available static images were copied into the theme asset directory so
  homepage sections now use theme-owned asset paths.
- Minimal homepage-only JavaScript was introduced only for interactions that are
  materially useful to the experience: service modal, gallery hover rotation and
  FAQ disclosure.
- Video tips are rendered visually but not made playable yet because the
  referenced cover images and video files are missing from the repository.
- CTA links prefer native or context-aware destinations where possible, such as
  the WooCommerce shop url when available.

### Assumptions

- Structured homepage content can remain theme-defined for now until a clearer
  editorial model is requested.
- The front page title is still valuable for document structure, so it is kept
  as the page h1 for assistive technologies while the visual hero keeps the
  marketing heading style from the prototype.
- Placeholder social links and booking flows should remain conservative until
  final destinations are confirmed.
- Missing video media is a repository gap, not a reason to block homepage
  integration.

### Verification

- `front-page.php` now renders a full homepage structure instead of generic page
  content.
- The homepage is split into focused partials with a clear section-per-file
  organization.
- Homepage assets now resolve from the theme `assets/img/` directory for the
  currently available images.
- The interaction script is guarded so it only activates when matching homepage
  elements exist.
- Documentation was updated to record the implementation compromise and new
  baseline.

### TODO / Residual Risks

- Replace theme-defined homepage data with a more editorial WordPress-native
  model only if future requirements justify it.
- Revisit video tips once the missing cover images and mp4 assets are available.
- Continue with broader design-system cleanup so shared homepage styles can be
  merged more elegantly with the rest of the theme.
- Validate runtime behavior in a real WordPress environment with the front page
  assigned in Reading settings.

---

## T005

### Objective

Establish the classic-theme design-token baseline by migrating the key static
tokens into `theme.json`, bridging them to frontend/editor CSS and exposing
native editing controls for core homepage sections.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `theme.json`
- `functions.php`
- `inc/theme-setup.php`
- `inc/enqueue.php`
- `inc/front-page-data.php`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/css/editor.css`
- `sito-statico/assets/css/style.css`
- `front-page.php`
- `template-parts/front-page/hero.php`
- `template-parts/front-page/services.php`
- `template-parts/front-page/shop-categories.php`
- `template-parts/front-page/history.php`
- `template-parts/front-page/location-hours.php`
- `template-parts/front-page/gallery.php`
- `template-parts/front-page/video-tips.php`
- `template-parts/front-page/contacts.php`
- `template-parts/front-page/faq.php`
- `template-parts/front-page/newsletter.php`

### Files Created/Modified

- `functions.php`
- `theme.json`
- `inc/customizer.php`
- `inc/enqueue.php`
- `inc/front-page-data.php`
- `inc/theme-setup.php`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/css/editor.css`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The main palette, font stacks, font sizes and spacing presets now live in
  `theme.json` because WordPress and the editor benefit directly from them.
- Runtime overrides remain in PHP + CSS variables: Customizer settings write to
  a single token bridge rather than duplicating values across multiple styles.
- Global shell, reset, classic-template layout and homepage-specific component
  behavior stay in CSS, where those concerns remain clearer and more
  maintainable than forcing them into `theme.json`.
- Frontend and editor now load the same Google Fonts through proper enqueue
  hooks instead of relying on the static CSS `@import`.
- Homepage content editing stays native and conservative: the Customizer now
  covers core copy, links, images and line-based repeatable content without
  adding extra dependencies or page builders.

### Assumptions

- The current editorial need is best served by Customizer controls and
  line-based repeatable fields rather than a custom post type or custom-fields
  dependency.
- Gallery image rotation can remain theme-owned for now; this task exposes the
  gallery section copy but not a media-driven gallery manager.
- `theme.json` should stay selective inside this classic theme, so structural
  CSS and bespoke homepage components are intentionally not moved wholesale.
- Google Fonts remain acceptable at this stage because no local font files are
  currently present in the repository.

### Verification

- Reviewed the static `:root` token set and mapped the primary palette,
  typography and spacing values into the theme token system.
- Added a Customizer panel for design tokens and homepage sections, with PHP
  fallback data still powering the templates when no override is saved.
- Updated frontend and editor stylesheets to consume the shared token aliases
  rather than hardcoded duplicate values where it was sensible.
- Confirmed the modified PHP files by manual source review after edit.
- Attempted PHP lint, but the local environment does not provide a `php`
  executable, so automated syntax verification could not be run here.

### TODO / Residual Risks

- Validate the Customizer controls and dynamic token output inside a real
  WordPress install, especially editor rendering and image control storage.
- Reassess whether any homepage repeatable content deserves a richer native
  editorial model after real content entry begins.
- Consider moving webfonts locally if performance, privacy or deployment rules
  require it later.
- Continue with WooCommerce baseline styling and wrapper alignment in `T006`.
