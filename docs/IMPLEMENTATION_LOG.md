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

---

## T006

### Objective

Realign the global theme header with the static prototype by restoring the
brand logo fallback on the left and the quick action icons on the right while
keeping the implementation native to WordPress and WooCommerce.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `inc/template-tags.php`
- `inc/theme-setup.php`
- `assets/css/main.css`
- `template-parts/site/icon-sprite.php`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`

### Files Created/Modified

- `header.php`
- `front-page.php`
- `inc/template-tags.php`
- `assets/css/main.css`
- `template-parts/site/icon-sprite.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The shared SVG sprite is now loaded from the global shell so header icons are
  available on every template instead of only on the front page.
- The header now falls back to the static `assets/img/logo.webp` brand mark
  when no WordPress custom logo has been assigned, preserving the prototype
  look without forcing admin setup first.
- Quick actions for profile, favorites and cart were added as a dedicated
  header action group rather than mixing them into the navigation menu markup.
- WooCommerce-native destinations are used where available for account and cart
  links; the favorites icon falls back to a `/wishlist/` page when present, or
  to the shop page otherwise.
- The desktop header layout was realigned to the static prototype with a
  full-width flex row, matching the original logo/menu/actions distribution and
  horizontal padding more closely.
- Header navigation weight, spacing and submenu geometry were tightened to
  better match the static prototype without abandoning native WordPress menu
  output.
- The WordPress header navigation classes were aligned more closely with the
  static CSS naming and spacing model so the header rules can now mirror the
  prototype more faithfully.
- The submenu trigger chevron and dropdown list reset were refined again so the
  header matches the static preview more closely and no list markers appear in
  the opened panel.

### Assumptions

- Restoring the prototype parity for the header is more important here than
  waiting for a future wp-admin custom logo configuration.
- A dedicated wishlist plugin is not guaranteed, so the favorites action needs
  a conservative fallback instead of assuming third-party functionality.
- The user request is scoped to the visual/header parity issue, so no wider
  WooCommerce archive styling work was included in this task.

### Verification

- Compared the static header markup/CSS against the current theme header before
  editing.
- Confirmed the fallback brand asset exists in `assets/img/logo.webp`.
- Reviewed the updated PHP and CSS to ensure the header now renders logo,
  primary navigation and right-side actions together in the global shell.
- Recompared the current header CSS against the static navigation rules after
  the refinement pass for centering, font weight and dropdown alignment.
- Recompared the latest header CSS against the static navigation block to bring
  padding, logo size, menu gap and dropdown metrics back to the same values.
- Rechecked the submenu arrow treatment and list reset after the latest header
  CSS pass to remove visible list bullets from the dropdown.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the restored header in a real WordPress browser runtime, especially
  menu wrapping and icon alignment on smaller screens.
- Revisit the favorites destination if a specific wishlist plugin or page
  strategy is later chosen for the project.
- Continue the broader WooCommerce baseline integration in a later task, since
  this fix intentionally stays focused on header parity.

---

## T007

### Objective

Bring the full homepage much closer to the static prototype by realigning the
homepage partial markup, section classes, interactions and CSS values so the
WordPress front page visually matches the original design more faithfully.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `sito-statico/assets/js/main.js`
- `front-page.php`
- `assets/css/front-page.css`
- `assets/js/theme.js`
- `inc/front-page-data.php`
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

- `assets/css/front-page.css`
- `assets/js/theme.js`
- `inc/front-page-data.php`
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
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- Homepage section partials now use class names and structure much closer to the
  static prototype so the original CSS model can be mirrored more faithfully.
- The homepage stylesheet was rewritten around the static homepage measurements,
  section spacing, button styling, grid structure and typography rather than the
  earlier simplified theme interpretation.
- The front-page interaction script now supports the static-style service modal,
  FAQ state classes and video modal behavior used by the updated markup.
- Social links and video cards were brought closer to the original homepage
  design through icon-based rendering and static-style card markup.
- The static homepage scroll-snap behavior was restored only for the WordPress
  front page through a dedicated body class, so the effect does not leak into
  blog, page or WooCommerce views.
- The floating WhatsApp and booking buttons were refined to match the static
  prototype sizing, radius, shadow and hover/active feedback exactly.
- The floating CTA finish pass also restored the full WhatsApp icon sprite path
  and removed unintended link underlines from the booking tab.

### Assumptions

- Matching the static homepage more closely is the priority for this task, even
  when that means reusing prototype class naming inside WordPress partials.
- The missing original video cover assets are still absent from the repository,
  so the video card layout was restored using available theme images as a visual
  fallback instead of leaving the cards as generic placeholders.
- This task remains scoped to homepage fidelity, so no global footer/shop
  template refactors were introduced beyond what the homepage itself needs.

### Verification

- Recompared homepage sections against the static `index.html` and homepage CSS
  while updating partial markup and class names.
- Rechecked the updated homepage stylesheet to ensure section heights, grid
  geometry, button treatments and typography now follow the static model much
  more closely.
- Rechecked the updated homepage script for service modal, video modal, gallery
  rotation and FAQ disclosure compatibility with the new markup/state classes.
- Reintroduced the static section snap-scrolling behavior in a homepage-only
  scope and verified the selectors stay isolated from non-home templates.
- Rechecked the floating CTA styles against the static CSS so the homepage side
  booking tab and WhatsApp button now use the same dimensions and states.
- Rechecked the floating CTA markup and icon sprite so the WhatsApp glyph is
  visible again and both floating links render without stray text decoration.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the homepage in a real WordPress browser runtime to catch any final
  spacing mismatches caused by core/editor output around the front page.
- Replace the temporary fallback video covers with the original intended assets
  if those files are later added to the repository.
- If the user wants pixel-level parity after browser review, continue with a
  screenshot-driven refinement pass limited to homepage differences only.

---

## T008

### Objective

Optimize header, homepage and footer behavior for tablet and mobile without
changing the established desktop presentation.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `footer.php`
- `template-parts/navigation/footer-column.php`

### Files Created/Modified

- `assets/css/main.css`
- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- Responsive refinements were limited to new and updated `max-width`
  breakpoints so desktop rules remain unchanged.
- Header spacing, nav density, action icon sizing and footer columns were tuned
  separately for tablet and mobile rather than collapsing directly from desktop
  to a single small-screen layout.
- Homepage full-height sections remain intact on desktop, but switch to more
  natural content height and roomier stacking on touch-device breakpoints.
- Mobile homepage snap scrolling is disabled to avoid awkward touch scrolling,
  while desktop homepage snap behavior stays intact.
- The floating booking tab is still hidden on smaller screens, while the
  WhatsApp action is reduced and repositioned for safer thumb reach.

### Assumptions

- Preserving desktop fidelity means all responsive work should live under
  tablet/mobile media queries only.
- Touch usability on smaller screens is more important than preserving the
  desktop section snap effect on mobile.
- Existing WordPress menu/output structure is sufficient; this task only needs
  CSS-level responsive improvements.

### Verification

- Confirmed the new changes in `assets/css/main.css` are scoped to
  `@media (max-width: 1100px)`, `@media (max-width: 1024px)` and
  `@media (max-width: 782px)`.
- Confirmed the new homepage responsive adjustments live only inside the
  existing tablet/mobile media queries in `assets/css/front-page.css`.
- Reviewed the header, homepage and footer selectors after edit to ensure the
  desktop base rules were left untouched.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the updated breakpoints in a real browser on tablet and mobile
  widths, especially header wrapping and homepage section spacing.
- Revisit menu ergonomics later if the primary navigation grows in depth or
  item count beyond the current CSS-only mobile handling.

### Additional Note - Accessibility And SEO Hardening Pass

#### Objective

Run a focused accessibility and SEO technical pass on the classic theme,
verifying landmarks, heading hierarchy, skip links, focus states, keyboard
navigation, form labels and SEO-safe markup without duplicating plugin
responsibilities.

#### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `footer.php`
- `front-page.php`
- `page.php`
- `archive.php`
- `search.php`
- `single.php`
- `index.php`
- `home.php`
- `404.php`
- `searchform.php`
- `comments.php`
- `template-parts/navigation/footer-column.php`
- `template-parts/content/content-none.php`
- `template-parts/front-page/hero.php`
- `template-parts/front-page/services.php`
- `template-parts/front-page/shop-categories.php`
- `template-parts/front-page/gallery.php`
- `template-parts/front-page/video-tips.php`
- `template-parts/front-page/contacts.php`
- `woocommerce/archive-product.php`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `inc/theme-setup.php`
- `inc/template-tags.php`
- `inc/enqueue.php`

#### Files Created/Modified

- `header.php`
- `footer.php`
- `front-page.php`
- `page.php`
- `archive.php`
- `search.php`
- `single.php`
- `index.php`
- `home.php`
- `404.php`
- `searchform.php`
- `template-parts/navigation/footer-column.php`
- `template-parts/content/content-none.php`
- `template-parts/front-page/hero.php`
- `template-parts/front-page/services.php`
- `template-parts/front-page/shop-categories.php`
- `template-parts/front-page/gallery.php`
- `template-parts/front-page/video-tips.php`
- `template-parts/front-page/contacts.php`
- `woocommerce/archive-product.php`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `docs/IMPLEMENTATION_LOG.md`

#### Decisions Made

- Added two skip links and made every `#primary` main landmark programmatically
  focusable so keyboard users can reliably bypass repeated chrome.
- Promoted the header quick-action group to a real navigation landmark and
  converted footer column labels into semantic headings without changing the
  visual treatment.
- Reduced heading-hierarchy noise by downgrading the generic empty-state title
  from `h1` to `h2` in contexts that already expose a page-level heading.
- Hardened modal and mobile filter interactions with focus return and focus
  trapping, keeping the current UX while making keyboard use more predictable.
- Added explicit labels to the WooCommerce price-range inputs and reinforced
  focus styling where later component CSS had neutralized the global outline.
- Kept SEO compatibility plugin-first: no theme-side meta tags, canonical tags,
  schema duplication or title handling beyond existing WordPress supports.
- Applied only native, markup-level performance refinements: hero
  `fetchpriority="high"` and lazy/async loading for non-critical manual images.

#### Assumptions

- Existing WordPress core supports already provide the correct baseline for SEO
  plugins, so this pass should avoid adding overlapping head/meta features.
- Focus trapping was applied only to the theme-owned modal/off-canvas surfaces,
  not to every navigation context, to avoid broader behavioral regressions.
- The footer copyright line was normalized with ASCII-safe copy because the
  repository still shows intermittent encoding artifacts in terminal output.

#### Verification

- Re-reviewed theme templates for landmarks, heading levels, form labels and
  skip-link targets after the patch.
- Verified via repository search that the new skip links, focus-trap helper,
  semantic footer heading class, focusable `main` landmarks and price-input
  labels are present in the expected files.
- Confirmed the theme still relies on `wp_head()`, `wp_footer()`,
  `language_attributes()`, `body_class()`, `wp_body_open()` and `title-tag`
  support for SEO-plugin compatibility.
- Automated PHP lint, browser tab-order testing and screen-reader testing could
  not be run here because this workspace does not provide a local WordPress/PHP
  runtime or browser automation target.

#### TODO / Residual Risks

- Validate the new focus-trap behavior in a real browser on mobile and desktop,
  especially around the service modal, video modal and shop filters drawer.
- Check the visible skip-link offset against the live fixed header in WordPress
  once real content and admin-bar states are present.
- Run a follow-up accessibility sweep with browser devtools or aXe/Lighthouse
  when a runtime environment is available, because this pass relied on source
  review rather than executable QA.

---

## T009

### Objective

Add proper mobile header menu handling so the navigation can be toggled open and
closed cleanly on small screens without changing desktop behavior.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `assets/css/main.css`
- `assets/js/theme.js`

### Files Created/Modified

- `header.php`
- `assets/css/main.css`
- `assets/js/theme.js`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- A dedicated mobile menu toggle button was added to the header instead of
  forcing the primary navigation to remain always expanded on small screens.
- The mobile header now reveals the primary navigation and quick actions only
  when the toggle is open, while the desktop header remains unchanged.
- Menu open/close state is handled with a header class plus minimal JavaScript,
  keeping the implementation lightweight and scoped.

### Assumptions

- The existing WordPress menu structure is sufficient; only the small-screen
  interaction model needed improvement.
- A simple toggle pattern is the most maintainable option for the current menu
  depth and project scope.

### Verification

- Reviewed the updated header markup, CSS media-query behavior and theme script
  together to confirm the mobile toggle is isolated from desktop behavior.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the toggle in a real mobile browser, especially submenu disclosure
  and spacing when real WordPress menus are populated.

---

## T010

### Objective

Realign the homepage `location-hours` section with the static prototype by
restoring the original flat two-column presentation, schedule row styling and
CTA alignment.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `template-parts/front-page/location-hours.php`
- `assets/css/front-page.css`

### Files Created/Modified

- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The fix stays CSS-only because the current WordPress partial markup already
  matches the static section structure closely enough.
- The boxed card interpretation previously used for the two columns was
  removed in favor of the original flat layout from the static prototype.
- The schedule list was restored to the prototype model with top and bottom
  borders, fixed first-column width and row-level spacing.
- The booking CTA was realigned to the prototype behavior by centering it at
  the section bottom with intrinsic width instead of treating it like a full
  content card action.

### Assumptions

- The reported mismatch concerns the visual fidelity of the `location-hours`
  section, not its editable content model or link destinations.
- Existing mobile full-width button behavior can remain unchanged because the
  previous responsive pass intentionally optimized smaller screens separately
  from desktop fidelity.

### Verification

- Compared the static `location-hours` markup and CSS against the current theme
  partial and section styles before editing.
- Rechecked the updated selectors in `assets/css/front-page.css` to confirm the
  changes are scoped to the homepage `location-hours` section only.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the section in a real browser to catch any remaining spacing or font
  differences caused by live WordPress rendering around the homepage content.

---

## T011

### Objective

Restore compliance with the project constraint that existing theme CSS must
remain unchanged during parity work, then correct the remaining
`location-hours` details through data and documentation updates instead of CSS
edits.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `template-parts/front-page/location-hours.php`
- `inc/front-page-data.php`
- `assets/css/front-page.css`

### Files Created/Modified

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `inc/front-page-data.php`
- `assets/css/front-page.css`

### Decisions Made

- The `T010` CSS changes to `location-hours` were rolled back to respect the
  clarified project rule that current theme CSS must not be modified for this
  kind of parity refinement.
- The stable-CSS constraint was added to the operating documentation so it is
  visible in the mandatory files read before each task.
- Remaining section fidelity adjustments were limited to structured content:
  the schedule day labels now restore Italian accents and the location booking
  CTA default returns to the static prototype placeholder destination.

### Assumptions

- The user clarification applies as a standing repository rule, not only to the
  current section fix.
- Aligning the `location-hours` section under this rule means preferring data
  parity over visual restyling when the existing CSS diverges from the static
  prototype.

### Verification

- Recompared the static `location-hours` section against the theme partial and
  confirmed the remaining structural markup already matches closely enough.
- Rechecked `assets/css/front-page.css` after rollback to ensure the
  `location-hours` block no longer carries the prior CSS-only parity edits.
- Rechecked `inc/front-page-data.php` to confirm `Lunedì`, `Martedì`,
  `Venerdì` and the `#` booking CTA default are now aligned with the static
  source content.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- If further parity gaps remain in `location-hours`, they should be resolved
  through template/data adjustments unless the user explicitly authorizes CSS
  edits.

---

## T012

### Objective

Align the homepage `location-hours` section 1:1 with the static prototype by
restoring the original CSS values and correcting the previously misdocumented
parity rule.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `template-parts/front-page/location-hours.php`

### Files Created/Modified

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/main.css`
- `assets/css/front-page.css`

### Decisions Made

- The `location-hours` rules in the theme were updated to match the static
  prototype values directly instead of using the earlier theme-specific
  reinterpretation.
- Static CSS variable names used by the section were bridged in `main.css` to
  the theme token system so the section can keep the original prototype values
  without breaking the classic theme setup.
- The project rule was clarified in the mandatory-read documentation: parity
  work should reproduce static CSS faithfully rather than freezing the current
  theme CSS state.

### Assumptions

- For this task, 1:1 fidelity means matching the static section behavior and
  numeric CSS values while keeping the theme's existing scope prefixes.
- Reusing aliased variables in the theme is acceptable because it preserves the
  static values while remaining compatible with the current token architecture.

### Verification

- Recompared the static `location-hours` markup and CSS against the updated
  theme section after the edit.
- Confirmed the theme now restores the static section behaviors that were
  previously missing: flat columns, row-bounded schedule list, `inline-flex`
  address line, static button sizing and bottom-centered booking CTA.
- Confirmed the static variable names referenced by the restored section now
  resolve through aliases declared in `assets/css/main.css`.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the updated section in a real browser to confirm there are no
  remaining parity gaps caused by surrounding homepage rules or WordPress
  runtime output.

---

## T013

### Objective

Restore the homepage `videoconsigli` section with 1:1 static-prototype CSS
behavior inside the theme, including the card overlay/play treatment and the
video modal presentation.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `sito-statico/assets/js/main.js`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/js/theme.js`
- `template-parts/front-page/video-tips.php`
- `inc/front-page-data.php`

### Files Created/Modified

- `assets/css/main.css`
- `assets/css/front-page.css`
- `inc/front-page-data.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The `videoconsigli` section styling was realigned to the static prototype by
  restoring the original section height, spacing, card geometry, gradient
  overlay, centered play button, absolute title placement and modal layout.
- Additional static variable aliases were bridged in `assets/css/main.css` so
  the copied prototype rules can resolve against the existing theme token
  system without changing the design values.
- The last video card title and related accessibility strings were updated to
  restore the accented `più` used by the static source.
- The current theme markup and JS were kept because they already match the
  static behavior closely enough for this section; the work remained focused on
  parity gaps rather than broader refactors.

### Assumptions

- 1:1 parity here means matching the static CSS values and behavior while
  retaining the theme scope prefix and existing WordPress-safe markup.
- The missing original `video-cover-1.webp` through `video-cover-4.webp` and
  mp4 assets remain a repository gap, so image/media file parity cannot be
  completed until those files exist.

### Verification

- Recompared the static `videoconsigli` markup/CSS and modal block against the
  updated theme section after the edit.
- Confirmed the theme now restores the static card treatment: full-height
  imagery, dark gradient overlay, centered circular play affordance and
  bottom-positioned title text.
- Confirmed the video modal now follows the static dimensions and presentation:
  portrait media frame, transparent dialog wrapper, top-right close control and
  centered title styling.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Add the missing original video cover images and mp4 files if the section must
  reach full media parity with the static prototype rather than layout parity
  only.

---

## T014

### Objective

Restore the homepage `contatti` section with 1:1 static-prototype CSS behavior
and matching default content formatting inside the theme.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `assets/css/front-page.css`
- `template-parts/front-page/contacts.php`
- `inc/front-page-data.php`

### Files Created/Modified

- `assets/css/front-page.css`
- `inc/front-page-data.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The `contatti` section styling was realigned to the static prototype by
  restoring the original section height, grid structure, contact-row geometry,
  centered social icon strip, circular owner image and bottom CTA placement.
- The theme partial markup already matched the static section closely enough, so
  the parity work stayed focused on CSS values and default content formatting.
- The default contact description now preserves the static line break and
  `Social` capitalization, and the booking CTA default returns to the static
  placeholder destination `#`.

### Assumptions

- 1:1 parity here means matching the static CSS values and visible content while
  keeping the existing theme-safe markup and escaping.
- The existing owner image asset already corresponds to the static reference, so
  no media substitution was required for this section.

### Verification

- Recompared the static `contatti` markup and CSS against the updated theme
  section after the edit.
- Confirmed the theme now restores the static section behaviors that were
  previously missing: 300px owner column, 140px label column, centered social
  links, circular 260px portrait and intrinsic-width booking CTA.
- Confirmed the default contact copy now renders on two lines through the
  existing `nl2br()` handling in the template.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the updated section in a real browser to confirm there are no
  remaining parity gaps caused by surrounding homepage rules or WordPress
  runtime output.

---

## T015

### Objective

Refine the homepage `contatti` section so social icon rendering and contact
links match the static prototype more closely.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/assets/css/style.css`
- `assets/css/front-page.css`
- `template-parts/site/icon-sprite.php`

### Files Created/Modified

- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- Contact email and telephone links now explicitly remove text underlines in
  the section, matching the static prototype instead of relying on broader link
  defaults.
- Social links in the contact block now also remove text decoration explicitly
  and force a zero line-height icon wrapper so the glyphs render more cleanly.
- The generic social icon size in the contact strip was slightly increased to
  improve Instagram legibility while staying within the visual intent of the
  static section.

### Assumptions

- The Instagram visibility issue is caused by icon presentation inside the
  themed contact strip rather than by an incorrect SVG symbol definition.

### Verification

- Rechecked the updated `contatti` selectors in `assets/css/front-page.css` to
  confirm the changes are scoped to email/phone links and social icons only.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the icon rendering in a browser to confirm the Instagram symbol now
  reads clearly at the updated size.

---

## T016

### Objective

Fix the missing Instagram icon rendering in the homepage `contatti` section by
restoring the complete static SVG symbol in the shared icon sprite.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `template-parts/site/icon-sprite.php`
- `assets/css/front-page.css`

### Files Created/Modified

- `template-parts/site/icon-sprite.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The Instagram visibility issue was traced to an incomplete `icon-instagram`
  symbol path in the shared sprite, not to the section CSS.
- The theme sprite now restores the exact Instagram path used by the static
  prototype, including the outer camera ring and top-right detail.

### Assumptions

- All sections using the shared sprite should benefit safely from the restored
  Instagram symbol because the change only completes the missing vector data.

### Verification

- Compared the `icon-instagram` symbol in `template-parts/site/icon-sprite.php`
  against the static sprite embedded in `sito-statico/index.html`.
- Confirmed the theme symbol previously ended early and now includes the full
  static path data.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the restored icon in a browser to confirm the symbol now renders
  clearly in the contact social strip and any other sprite consumers.

---

## T017

### Objective

Restore the homepage `faq` section with 1:1 static-prototype CSS behavior and
matching default fallback copy inside the theme.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `assets/css/front-page.css`
- `assets/js/theme.js`
- `template-parts/front-page/faq.php`
- `inc/front-page-data.php`

### Files Created/Modified

- `assets/css/front-page.css`
- `inc/front-page-data.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The `faq` section styling was realigned to the static prototype by restoring
  the original section sizing, card styling, contrast-highlight open state,
  question row spacing, arrow treatment and answer reveal animation model.
- Existing FAQ markup and JavaScript were kept because they already support the
  same accordion interaction model used by the static prototype.
- The default FAQ description, questions and answers were updated to restore
  accented Italian copy so the fallback content now matches the static source
  more closely.
- A leftover mobile selector was updated to target the new FAQ paragraph rule
  path consistently after the section CSS realignment.

### Assumptions

- 1:1 parity here means matching the static desktop CSS values and accordion
  behavior while keeping the theme-safe markup and scoped selectors.

### Verification

- Recompared the static `faq` markup and CSS against the updated theme section
  after the edit.
- Confirmed the theme now restores the static FAQ behaviors that were
  previously missing: rounded cards, contrast-colored open state, hover fill on
  the question row, arrow sizing/rotation and the grid-row based answer reveal.
- Rechecked the responsive selector update so the mobile FAQ answer padding now
  still applies to the current paragraph rule.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the updated FAQ section in a real browser to confirm there are no
  remaining parity gaps caused by surrounding homepage rules or WordPress
  runtime output.

---

## T018

### Objective

Restore the homepage `newsletter` section with 1:1 static-prototype CSS
behavior and matching fallback copy inside the theme.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `template-parts/front-page/newsletter.php`
- `inc/front-page-data.php`

### Files Created/Modified

- `assets/css/main.css`
- `assets/css/front-page.css`
- `inc/front-page-data.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The `newsletter` section styling was realigned to the static prototype by
  restoring the original section height, centered card width, form spacing,
  input/button sizing, consent row styling and newsletter note treatment.
- A static alias for `--btn-bg-hover` was added to the main token bridge so the
  newsletter submit button hover state can match the prototype without
  hardcoding inconsistent values elsewhere.
- The default newsletter description and note were updated to restore accented
  Italian copy so the fallback content now matches the static source more
  closely.
- Existing markup and responsive rules were preserved where already compatible,
  with the responsive newsletter box padding left intact as the current
  small-screen adaptation layer.

### Assumptions

- 1:1 parity here means matching the static desktop CSS values and visible copy
  while keeping the existing theme-safe form markup and accessibility labels.

### Verification

- Recompared the static `newsletter` markup and CSS against the updated theme
  section after the edit.
- Confirmed the theme now restores the static newsletter behaviors that were
  previously missing: 820px card width, 640px form width, 60px controls,
  underline hoverable privacy link and muted note styling.
- Confirmed the copied button hover rule now resolves through the new
  `--btn-bg-hover` alias in `assets/css/main.css`.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the updated newsletter section in a real browser to confirm there
  are no remaining parity gaps caused by surrounding homepage rules or form
  rendering in WordPress.

---

## T019

### Objective

Restore the homepage footer with 1:1 static-prototype structure and styling,
and fix the front-page scroll/snap behavior so the footer can be reached
properly.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`
- `footer.php`
- `template-parts/navigation/footer-column.php`
- `inc/template-tags.php`
- `assets/css/main.css`
- `assets/css/front-page.css`

### Files Created/Modified

- `footer.php`
- `template-parts/navigation/footer-column.php`
- `inc/template-tags.php`
- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The theme footer markup was realigned to the static prototype by restoring
  the `site-footer-inner`, `footer-grid`, `footer-col` and `footer-bottom`
  structure, plus the branded `OC Corporation` credit line.
- Footer column headings now use the static visual pattern with `section-label`
  styling, and the first three headings can act as links like the static
  prototype.
- Footer fallback menus were upgraded from a generic single `Home` item to
  location-specific fallback lists that mirror the static footer information
  architecture more closely.
- The front-page footer now becomes a snap area with front-page-specific
  sizing, spacing and alignment rules, which should resolve the issue where the
  final footer area was difficult or impossible to scroll into.
- Existing generic footer styles remain available for non-front-page contexts,
  while front-page parity rules are scoped through the `re-style-front-page`
  body class.

### Assumptions

- The reported footer scroll issue is primarily caused by the footer not being
  configured as a compatible snap destination within the front-page scrolling
  model.
- Using location-specific fallback links is acceptable because the project
  still aims to mirror the static footer structure before menus are configured
  in WordPress admin.

### Verification

- Recompared the static footer markup and CSS against the updated theme footer
  structure and styles after the edit.
- Confirmed the front-page footer now has its own snap-aware layout rules,
  static-style column geometry and branded bottom credit row.
- Confirmed the footer fallback callback now outputs static-like lists for
  navigation, shop, information and legal columns instead of a one-link
  placeholder.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the updated footer in a real browser to confirm the homepage now
  scrolls cleanly into the footer and that no final snap/overflow issue
  remains.

---

## T020

### Objective

Correct the footer heading-link selector so `.footer-col > a.section-label`
matches the static prototype exactly.

### Files Read

- `AGENTS.md`
- `sito-statico/assets/css/style.css`
- `assets/css/main.css`

### Files Created/Modified

- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The front-page footer now styles the direct anchor heading selector
  `.footer-col > a.section-label` with the exact static typography, spacing,
  color and hover behavior instead of relying on a broader `.section-label`
  rule.
- A separate non-link footer heading rule was kept for `.footer-col >
  .section-label` so the legal column still matches the visual pattern without
  inheriting link-only hover behavior.

### Assumptions

- The reported mismatch concerned the direct linked footer headings rather than
  the list links inside each footer column.

### Verification

- Compared the static `.footer-col > a.section-label` rule against the updated
  front-page footer selector in `assets/css/main.css`.
- Automated runtime verification in WordPress and PHP lint could not be run in
  this environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the footer headings in a browser to confirm the linked and non-linked
  column labels now both match the intended static styling.

---

## T021

### Objective

Expose the scrolling topbar text and the floating side booking button through
the native Customizer, with optional automatic WooCommerce free-shipping
messaging based on the configured shipping threshold.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `functions.php`
- `inc/customizer.php`
- `inc/template-tags.php`
- `inc/front-page-data.php`
- `template-parts/site/topbar.php`
- `template-parts/site/floating-actions.php`

### Files Created/Modified

- `inc/customizer.php`
- `inc/template-tags.php`
- `template-parts/site/floating-actions.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- A new Customizer section was added for site-shell controls so header-adjacent
  content can be managed without mixing it into unrelated homepage sections.
- The topbar now supports manual scrolling messages from a textarea plus an
  optional checkbox that appends a WooCommerce-derived free-shipping notice.
- Free-shipping detection follows WooCommerce zones and active shipping methods,
  prefers the lowest enabled minimum threshold and falls back to a generic
  message only when free shipping is available without a threshold.
- The floating booking tab now reads its label and destination URL from the
  Customizer instead of remaining hardcoded in the template.
- Existing topbar behavior was preserved by keeping the previous static message
  set as the default manual fallback until the automatic shipping option is
  explicitly enabled.

### Assumptions

- The requested "barra che scorre" refers to the existing site topbar rendered
  above the header.
- Automatic shipping messaging should be additive and opt-in through a checkbox,
  not forced by default.
- When WooCommerce free shipping depends only on a coupon, no automatic topbar
  message should be injected because there is no reliable threshold to show.

### Verification

- Manually reviewed the new Customizer controls and the related helper/template
  wiring after the edits.
- Confirmed the floating booking CTA template now consumes sanitized Customizer
  values for both text and link.
- Confirmed the topbar helper now reads manual lines from theme mods and can
  replace the legacy static shipping message with a WooCommerce-derived one when
  the checkbox is enabled.
- Attempted PHP lint on the modified files, but the local environment does not
  provide a `php` executable, so automated syntax verification could not be run
  here.

### TODO / Residual Risks

- Validate the new Customizer controls in a real WordPress admin session to
  confirm live-preview/save behavior.
- Verify the WooCommerce free-shipping message against the store's actual zone
  configuration, especially if multiple zones expose different thresholds.
- If the floating WhatsApp CTA also needs to be editable later, add that as a
  separate scoped task rather than expanding this change ad hoc.

---

## T022

### Objective

Make the homepage `videoconsigli` section dynamic through a dedicated
WordPress admin menu so editors can manage each card as a real content item
with title, cover image and uploaded/external video source.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `functions.php`
- `inc/theme-setup.php`
- `inc/enqueue.php`
- `inc/customizer.php`
- `inc/front-page-data.php`
- `template-parts/front-page/video-tips.php`
- `assets/js/theme.js`
- `assets/css/front-page.css`

### Files Created/Modified

- `functions.php`
- `inc/video-tutorials.php`
- `inc/front-page-data.php`
- `inc/customizer.php`
- `template-parts/front-page/video-tips.php`
- `assets/js/theme.js`
- `assets/js/admin-video-tutorials.js`
- `assets/css/front-page.css`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The video cards now use a dedicated custom post type `oc_video_tutorial`
  with admin menu label `OC | Video Tutorial` instead of a Customizer textarea,
  because each card needs structured editorial fields rather than one-line text.
- Each tutorial uses native WordPress title and featured image support, while a
  dedicated meta box handles the video source as either uploaded media or an
  external URL.
- Frontend card attributes such as `aria-label`, title ID and cover-image alt
  fallback are now generated automatically from the saved content, preserving
  the dynamic behavior that the theme already had.
- Homepage rendering now prefers published `oc_video_tutorial` posts ordered by
  `menu_order` and falls back to the existing theme defaults only when no
  tutorial has been published yet.
- The video modal was extended to support both local/direct video files and
  embeddable external providers such as YouTube or Vimeo without changing the
  overall homepage section design.

### Assumptions

- The requested dedicated menu should be a native WordPress admin sidebar item,
  not another Customizer subsection.
- "Indicare un link" can include both direct video-file URLs and common
  embeddable provider URLs, so the frontend now distinguishes file playback
  from iframe embeds automatically.
- The featured image of each `oc_video_tutorial` entry is the intended cover
  image for the homepage card unless no cover is set, in which case the theme
  fallback image remains acceptable.

### Verification

- Manually reviewed the CPT registration, meta-box save flow, homepage data
  assembly and modal rendering after the edits.
- Confirmed the old Customizer field for per-card video titles was removed so
  editorial management now has one clear source of truth.
- Confirmed the frontend template and JS now carry a source mode per card and
  switch the modal between native `<video>` playback and iframe embeds.
- Attempted automated PHP verification earlier in this environment, but the
  local machine does not provide a `php` executable, so syntax linting still
  could not be run here.

### TODO / Residual Risks

- Validate the new `OC | Video Tutorial` flow in a real WordPress admin session,
  especially media selection, featured-image usage and publish ordering.
- Test at least one uploaded MP4 and one YouTube/Vimeo URL in the browser to
  confirm the modal player behavior and provider policies match expectations.
- If the business later needs per-card descriptions, categories or explicit
  homepage inclusion toggles, extend the CPT deliberately rather than
  reintroducing ad hoc Customizer fields.

---

## T023

### Objective

Turn the homepage gallery section into a swipeable slider on mobile only while
preserving the existing desktop grid layout.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `template-parts/front-page/gallery.php`
- `assets/css/front-page.css`
- `assets/js/theme.js`

### Files Created/Modified

- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile gallery behavior was implemented with CSS only using horizontal
  overflow and `scroll-snap`, avoiding unnecessary JavaScript for a simple
  touch-first slider interaction.
- The change is scoped to the existing `@media (max-width: 782px)` breakpoint,
  so the desktop gallery remains a grid exactly as before.
- Gallery cards now become fixed-width horizontal slides on mobile, with hidden
  scrollbars and momentum scrolling for a cleaner swipe experience.

### Assumptions

- "Solo da mobile" maps to the theme's existing mobile breakpoint of `782px`.
- A touch/swipe slider without arrows or dots is sufficient for the requested
  behavior and fits the current visual language better than introducing new UI
  controls.

### Verification

- Manually reviewed the updated mobile gallery rules to confirm they only
  affect the mobile breakpoint and only the `.gallery-grid` / `.gallery-card`
  pair.
- Confirmed the desktop gallery CSS remains unchanged outside the mobile media
  query.

### TODO / Residual Risks

- Validate the swipe behavior on a real mobile device or responsive browser
  mode to confirm the chosen slide width feels right with the live content.

---

## T024

### Objective

Turn the homepage `video-tips` card grid into a swipeable slider on mobile
only while preserving the existing desktop layout.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/front-page.css`

### Files Created/Modified

- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile video tutorial behavior was implemented with CSS only using
  horizontal overflow and `scroll-snap`, matching the approach already used for
  the gallery mobile slider.
- The change is scoped to the existing `@media (max-width: 782px)` breakpoint,
  so the desktop `video-tips-grid` remains untouched.
- Video cards now become fixed-width horizontal slides on mobile, with hidden
  scrollbars and a bounded card height to keep swipe behavior stable inside the
  section.

### Assumptions

- "Solo da mobile" maps to the current theme mobile breakpoint of `782px`.
- A touch/swipe slider without extra navigation controls is sufficient for the
  requested mobile interaction.

### Verification

- Manually reviewed the updated mobile selectors to confirm they only affect
  `.video-tips-grid` and `.video-tip-card` inside the mobile media query.
- Confirmed the desktop grid rules remain unchanged outside the mobile
  breakpoint.

### TODO / Residual Risks

- Validate the mobile card height and swipe feel in a real browser or device to
  confirm the chosen slide sizing works well with the current covers and titles.

---

## T025

### Objective

Turn the homepage `shop-grid` into a swipeable slider on mobile only while
preserving the existing desktop layout.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/front-page.css`

### Files Created/Modified

- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile shop behavior was implemented with CSS only using horizontal
  overflow and `scroll-snap`, matching the mobile slider pattern already used
  for gallery and video tips.
- The change is scoped to the existing `@media (max-width: 782px)` breakpoint,
  so the desktop `shop-grid` layout remains unchanged.
- Shop cards now become fixed-width horizontal slides on mobile, with hidden
  scrollbars and touch-friendly momentum scrolling.

### Assumptions

- "Solo da mobile" maps to the current theme mobile breakpoint of `782px`.
- A touch/swipe slider without arrows or dots is sufficient for the requested
  mobile interaction.

### Verification

- Manually reviewed the updated mobile selectors to confirm they only affect
  `.shop-grid` and `.shop-card` inside the mobile media query.
- Confirmed the desktop shop grid rules remain unchanged outside the mobile
  breakpoint.

### TODO / Residual Risks

- Validate the mobile swipe behavior in a real browser or device to confirm the
  chosen slide width works well with the current shop card content.

---

## T026

### Objective

Refine three mobile/front-page interaction details: make mobile shop cards
square, clean up the header menu-toggle icon rendering, and point all booking
CTAs labeled `Prenota` to the provided external booking URL.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `inc/front-page-data.php`
- `template-parts/front-page/hero.php`
- `template-parts/front-page/history.php`
- `template-parts/front-page/services.php`
- `template-parts/front-page/shop-categories.php`
- `template-parts/front-page/location-hours.php`
- `template-parts/front-page/contacts.php`

### Files Created/Modified

- `assets/css/main.css`
- `assets/css/front-page.css`
- `inc/front-page-data.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile `shop-card` slider items now enforce a `1 / 1` aspect ratio so
  cards remain square while preserving the existing swipe behavior.
- The header menu toggle icon was refined by normalizing line spacing, width,
  radius and transform origin so the hamburger/close transition reads more
  cleanly on mobile.
- A central booking URL helper was added in `inc/front-page-data.php`, and all
  homepage CTAs whose label contains `Prenota` are now forced to use the
  provided Skipres link.
- The booking-link enforcement is label-based after Customizer overrides are
  applied, so user-edited CTA text containing `Prenota` still resolves to the
  same booking destination automatically.

### Assumptions

- The supplied URL should be treated as the canonical booking destination for
  homepage CTAs that visibly present themselves as booking actions.
- Buttons without the word `Prenota` in their label, such as shop-discovery or
  maps actions, should keep their existing destinations.

### Verification

- Manually reviewed the updated mobile shop-card rules to confirm square cards
  are scoped to the mobile slider breakpoint only.
- Manually reviewed the menu-toggle CSS to confirm the icon styling changes are
  limited to the toggle control and its line elements.
- Confirmed the homepage data helper now exposes the Skipres URL once and
  reapplies it consistently to all `Prenota` CTA labels after theme-mod
  overrides are loaded.

### TODO / Residual Risks

- Validate the menu-toggle rendering and animation on a real mobile browser to
  confirm the line geometry now appears clean in both closed and open states.
- If future booking buttons outside homepage sections need the same behavior,
  the booking helper should be reused there instead of duplicating the URL.

---

## T027

### Objective

Refine the mobile header so wishlist and cart remain visible beside the menu
toggle, while the account action moves inside the mobile navigation as a text
link labeled `Il mio account`.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `assets/css/main.css`
- `inc/template-tags.php`

### Files Created/Modified

- `header.php`
- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- Mobile-only quick actions for wishlist and cart were added beside the menu
  toggle, reusing the existing header-action URLs and icons instead of creating
  separate data sources.
- The account action was moved into the mobile navigation as a dedicated text
  link labeled `Il mio account`, with no icon, while desktop header actions
  remain unchanged.
- New mobile-specific header selectors were introduced and hidden by default so
  the desktop header layout continues to use the original action list.

### Assumptions

- The requested mobile layout should keep the current desktop header untouched
  and affect only the `max-width: 782px` breakpoint already used by the theme.
- The wishlist and cart icons should remain icon-only in the mobile header,
  while the account entry should be easier to read as a text row inside the
  opened mobile menu.

### Verification

- Manually reviewed the updated header markup to confirm the same action-link
  source now feeds both desktop actions and the new mobile quick-action area.
- Manually reviewed the new mobile header CSS to confirm the extra controls are
  hidden on desktop and activated only inside the mobile breakpoint.

### TODO / Residual Risks

- Validate the mobile header on a real device to confirm spacing stays balanced
  between logo, icons and toggle on narrower screens.
- If the assigned primary menu already contains a separate account item, decide
  later whether to keep both entries or suppress one of them conditionally.

---

## T028

### Objective

Correct the previous mobile-header refinement so desktop behavior remains
unchanged and the mobile wishlist/cart icons render with cleaner sizing and
alignment.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `assets/css/main.css`

### Files Created/Modified

- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile header control cluster was tightened by reducing icon-control
  spacing, slightly increasing icon glyph size and switching the mobile control
  wrapper to a compact inline grid for more stable alignment.
- The mobile header layout now uses `minmax(0, 1fr) auto` so the logo keeps the
  left side while the icon/toggle cluster stays visually anchored on the right.
- The desktop action list is now explicitly kept hidden on mobile even when the
  mobile menu opens, preventing the desktop quick-action behavior from leaking
  into the mobile header.
- The `Il mio account` link remains mobile-only and is visually separated inside
  the opened mobile navigation with a top border and spacing.

### Assumptions

- The reported desktop regression was caused by mobile CSS re-enabling
  `.site-header__actions` during the open-menu state rather than by the desktop
  breakpoint styles themselves.

### Verification

- Manually reviewed the updated mobile breakpoint rules to confirm
  `.site-header__actions` now stays hidden on mobile in both closed and open
  states.
- Manually reviewed the icon and control sizing rules to confirm the changes
  are scoped to the new mobile-header selectors and do not alter desktop action
  icon dimensions.

### TODO / Residual Risks

- Validate the revised mobile header in a real browser to confirm the wishlist,
  cart and toggle cluster now reads clearly across common device widths.

---

## T026

### Objective

Convert the static `shop.html` prototype into a scalable WooCommerce product
archive that stays visually faithful to the mockup while keeping WooCommerce
template overrides to the minimum strictly necessary.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/shop.html`
- `sito-statico/assets/css/style.css`
- `functions.php`
- `inc/theme-setup.php`
- `inc/enqueue.php`
- `inc/template-tags.php`
- `header.php`
- `footer.php`
- `archive.php`
- `assets/css/main.css`

### Files Created/Modified

- `functions.php`
- `inc/enqueue.php`
- `inc/woocommerce.php`
- `assets/css/woocommerce.css`
- `woocommerce/archive-product.php`
- `template-parts/woocommerce/archive-benefits.php`
- `template-parts/woocommerce/archive-cta.php`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The WooCommerce archive page shell is handled with one justified override:
  `woocommerce/archive-product.php`, because the static shop design requires a
  dedicated page-level structure with toolbar, category tabs, sidebar filters,
  results area, benefits and CTA that cannot be reproduced cleanly with hooks
  and CSS alone.
- Product cards remain based on the native WooCommerce loop template
  `content-product.php`; the theme reshapes the markup through hooks and
  filters instead of overriding that template, which keeps the catalog more
  maintainable during WooCommerce updates.
- A dedicated `inc/woocommerce.php` layer now centralizes archive helpers,
  GET-based filtering, taxonomy discovery, result-count rendering, badge logic
  and loop customization so WooCommerce integration does not leak into
  unrelated theme files.
- Sidebar filters are dynamic and scalable: product categories and all
  non-empty product attribute taxonomies are discovered automatically instead
  of being hardcoded to the exact prototype labels.
- Search, ordering, availability filters and price range filtering all operate
  on the WooCommerce main query, preserving archive context where useful while
  still allowing category filters to be broadened/reset from the sidebar.
- Shop-specific CSS lives in `assets/css/woocommerce.css` so the static archive
  parity work does not bloat `assets/css/main.css` or homepage styles.
- Benefits and final CTA were extracted into reusable WooCommerce-oriented
  template parts so the archive shell stays readable and future reuse remains
  possible.

### Assumptions

- "Nuovi arrivi" is currently modeled as products published in the last 30
  days; this window is filterable in PHP if merchandising rules change later.
- The store will use native WooCommerce taxonomies and product attributes as
  the primary source for archive filters, without assuming third-party layered
  navigation plugins.
- Preserving 1:1 fidelity means matching the static toolbar, filter, grid,
  pagination, benefits and CTA layout while still using real WooCommerce data,
  query state and product actions.
- Product thumbnails, excerpts and prices will be supplied by WooCommerce data
  rather than the missing static mockup images.

### Verification

- Manually compared the static `shop.html` structure and shop-specific CSS
  rules against the new archive template, loop hook output and dedicated
  WooCommerce stylesheet.
- Reviewed the new PHP helpers to confirm that search, ordering, taxonomy
  filters, availability filters, price range and pagination all flow through
  the main WooCommerce archive query.
- Confirmed that only `woocommerce/archive-product.php` was overridden, while
  product-card rendering remains based on WooCommerce default loop templates.
- Attempted PHP lint on the modified files, but the local environment does not
  provide a `php` executable, so automated syntax verification could not be run
  here.
- Attempted to inspect the change set with `git diff`, but this workspace is
  not currently initialized as a git repository, so diff review was completed
  by direct file inspection instead.

### TODO / Residual Risks

- Validate the archive in a real WordPress + WooCommerce browser runtime,
  especially add-to-cart behavior, pagination state and filter combinations.
- Confirm the real catalog data model for attributes/taxonomies so the dynamic
  sidebar group set aligns with editorial expectations.
- Revisit price filtering if the project later needs to rely on WooCommerce's
  product lookup tables or a different catalog indexing strategy for very large
  inventories.
- Continue with single product, cart, checkout and account styling in the next
  WooCommerce task, keeping the same hook-first discipline.

---

## T027

### Objective

Refine the WooCommerce shop archive after visual review by fixing the search
icon, aligning ordering/category behavior with real WooCommerce data, bringing
product cards closer to 1:1 parity, switching the "Novita" badge to the latest
five products per category and strengthening the mobile layout.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `header.php`
- `template-parts/site/icon-sprite.php`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `inc/woocommerce.php`
- `woocommerce/archive-product.php`
- `sito-statico/assets/css/style.css`

### Files Created/Modified

- `template-parts/site/icon-sprite.php`
- `inc/woocommerce.php`
- `woocommerce/archive-product.php`
- `woocommerce/content-product.php`
- `assets/css/woocommerce.css`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The shared SVG sprite now includes the missing search icon symbol so the shop
  search field can match the static prototype exactly.
- WooCommerce ordering options are now sourced from the same filter chain used
  by WooCommerce itself, rather than a narrower hardcoded list, so the shop
  sort control reflects real store behavior more reliably.
- Category tabs now fall back to all non-empty product categories when there
  are no top-level categories available, preventing the toolbar from appearing
  empty in flatter catalog structures.
- The product-card rendering moved from a hook-shaped loop transformation to a
  narrow `woocommerce/content-product.php` override because exact visual parity
  with the static mockup was easier and safer to maintain with direct loop-item
  markup control.
- "Novita" badges no longer use a date window; they now mark the latest five
  published products inside each assigned product category, matching the new
  merchandising rule from the task feedback.
- The mobile layout was hardened by stacking toolbar/sidebar earlier on tablet,
  making category tabs horizontally scrollable on mobile and tightening card
  behavior for narrower screens.

### Assumptions

- When a product belongs to multiple categories, it is considered "Novita" if
  it appears in the latest five products of at least one assigned category.
- Using ASCII `Novita`/`Disponibilita` strings in code is acceptable for now in
  order to avoid carrying forward the repository's current encoding anomalies.
- The global header already uses the same shared template on homepage and shop;
  this task therefore focused on verifying that no shop-specific CSS was
  distorting it rather than introducing a separate shop header implementation.

### Verification

- Re-read the static header/shop CSS and the updated theme files to confirm the
  search icon, toolbar, tabs, product cards and mobile breakpoints now align
  more closely with the prototype.
- Reviewed the new `woocommerce/content-product.php` loop markup against the
  static product-card structure to verify direct parity in media, category,
  title, description, price group and CTA placement.
- Reviewed the updated badge logic to confirm that "Novita" now comes from the
  latest five products per category instead of a rolling 30-day window.
- Attempted PHP lint on the modified PHP files, but the local environment still
  does not provide a `php` executable, so automated syntax verification could
  not be run here.

### TODO / Residual Risks

- Validate the updated archive in a real WooCommerce browser runtime to confirm
  the new loop-item override behaves correctly with variable, external and
  out-of-stock products.
- Confirm with live catalog data whether the fallback-to-all-categories toolbar
  rule is the desired editorial behavior when a store uses only child terms.
- If the shop archive still shows a header mismatch in the real browser after
  these fixes, inspect the live menu assignment/content rather than the theme
  shell first, since the header template itself remains shared.

---

## T028

### Objective

Refine the WooCommerce archive visual balance after further review by aligning
the shop content canvas with the shared header shell and compacting product
cards that were still appearing too long and sparse.

### Files Read

- `AGENTS.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/woocommerce.css`
- `inc/woocommerce.php`

### Files Created/Modified

- `assets/css/woocommerce.css`
- `inc/woocommerce.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The shop archive now overrides the generic constrained `.site-main` width so
  the catalog content aligns with the same shell padding used by the fixed
  header, matching the static prototype more closely.
- Product cards were compacted through both CSS and data shaping: image height
  was slightly reduced, title and description were line-clamped, and excerpt
  trimming was shortened from 22 to 16 words.
- The shop-specific horizontal padding now scales with the existing shell
  padding on desktop/tablet and collapses cleanly on mobile.

### Assumptions

- The perceived header misalignment comes from the shop canvas width and
  padding relationship, not from a separate header-template discrepancy.
- A more compact editorial rhythm is preferable to showing full excerpts in the
  product grid, because the static mockup prioritizes scanability over long
  descriptive text.

### Verification

- Manually reviewed the updated CSS selectors and spacing rules to confirm the
  shop canvas now follows header shell padding on larger breakpoints.
- Confirmed the product title/description stack now has both shorter source
  text and visual line clamps, reducing the tall-card effect.
- Automated PHP lint could not be run because the local environment still does
  not provide a `php` executable.

### TODO / Residual Risks

- Validate the updated spacing in the live browser with real product titles and
  thumbnails, because unusually long catalog data may still need minor tuning.

---

## T029

### Objective

Resolve the remaining visual mismatch on the WooCommerce archive by correcting
the shared header logo sizing and further compacting product cards that were
still reading as too tall and visually off compared with the static shop
preview.

### Files Read

- `AGENTS.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `woocommerce/content-product.php`

### Files Created/Modified

- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `woocommerce/content-product.php`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The shared header logo sizing was normalized by capping both custom-logo and
  fallback branding images to the same 2.5rem height, so the shop header now
  matches the homepage logo scale more closely.
- Product cards were compacted again by moving the media area to an
  aspect-ratio driven frame, reducing title sizing slightly, lowering text-gap
  density and trimming the visible description to two lines instead of three.
- Empty product descriptions no longer render an empty paragraph in the card,
  avoiding artificial vertical stretch when WooCommerce data is sparse.

### Assumptions

- The reported header mismatch was caused by image sizing differences rather
  than a different header template between homepage and shop.
- Matching the static shop card better means preferring a denser, more
  scan-friendly layout even when some live product text gets clipped sooner.

### Verification

- Manually reviewed the updated branding selectors in `assets/css/main.css` to
  confirm that both custom and fallback logo paths now share the same maximum
  height behavior.
- Rechecked the product-card template/CSS combination to confirm cards no
  longer reserve unnecessary height for missing descriptions and now keep a
  tighter visual rhythm.
- Automated runtime verification and PHP lint could not be run in this
  environment because no `php` executable is available locally.

### TODO / Residual Risks

- Validate the final logo size and product-card density in the live browser
  with the real WooCommerce catalog, since image crops and title lengths can
  still influence the perceived balance.

### Additional Note

- A later browser screenshot showed the product card collapsing to an extremely
  narrow width despite the earlier compacting pass. The shop grid CSS was
  therefore hardened with stronger archive-scoped selectors and explicit
  `float`/`width`/`max-width` resets on `li.product` so WooCommerce or
  third-party plugin loop styles cannot keep constraining the card width.
- A subsequent browser screenshot showed the wishlist control overlapping the
  left badge area and the card/button still reading differently from the static
  prototype. The product-card rules were therefore pulled back toward the
  original static values for media height, content spacing, title sizing,
  description depth and add-to-cart button sizing, while common wishlist plugin
  selectors were forced into a top-right floating control position.
- A later verification pass showed that the static footer had only been carried
  over faithfully for the front page, while the generic footer used by the shop
  was still on a different baseline. The shared footer rules in
  `assets/css/main.css` were therefore realigned to the static prototype for
  all contexts, and the shop product-card selectors were strengthened further
  so button/price/footer alignment is no longer left to weaker generic rules.
- A final shop pass changed the product-media area from fixed-height logic to a
  true square `4/4` ratio and widened the wishlist-position selectors so common
  plugin wrappers/buttons are forced to the top-right corner more reliably.
- A follow-up tweak increased wishlist icon legibility by strengthening the
  floating button contrast, setting explicit icon sizing and normalizing
  `svg`/icon-font coloring inside common wishlist plugin controls.
- A later browser screenshot showed the wishlist button shell rendering but the
  inner icon still appearing as a white blob. The shop CSS was therefore
  extended to force inner `svg`, `path`, `circle`, icon-font and nested span
  colors/backgrounds to a visible heart color, while removing plugin-introduced
  filters and extra shadows.
- When the plugin icon still rendered poorly after direct recoloring, the shop
  CSS switched to a more defensive approach: hide the plugin's inner visual
  fragments and draw a clean heart via a pseudo-element on the wishlist button
  shell itself.

---

## T029

### Objective

Refine the mobile footer layout so the column alignment, spacing and padding
feel consistent with the static prototype while leaving the desktop footer
unchanged.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `footer.php`
- `template-parts/navigation/footer-column.php`
- `assets/css/main.css`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`

### Files Created/Modified

- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The fix stays CSS-only because the footer structure was already correct; the
  visual issue came from the mobile breakpoint and default list spacing rather
  than from footer markup.
- Mobile front-page footer padding now uses the theme shell gutters again
  instead of collapsing to the viewport edges, which keeps the footer aligned
  with the rest of the mobile layout.
- On mobile, all footer columns now stretch consistently in the single-column
  stack and use tighter, more regular spacing between labels and links.
- Footer menus now explicitly reset margin, padding and bullets so WordPress
  menu output cannot introduce browser-default indentation.

### Assumptions

- The user's feedback refers primarily to the homepage/footer experience on
  mobile, where the front-page footer has dedicated styling different from
  generic internal pages.

### Verification

- Manually reviewed `footer.php` and `template-parts/navigation/footer-column.php`
  to confirm no markup changes were required.
- Compared the current footer CSS against the static prototype footer rules to
  preserve the existing visual language while adapting the mobile breakpoint.
- Reviewed the updated mobile selectors in `assets/css/main.css` to confirm the
  changes are scoped to footer layout and do not alter the desktop footer.

### TODO / Residual Risks

- Validate the footer on a real mobile viewport to confirm the new gutter,
  spacing and stacked-column rhythm feel balanced across common device widths.

---

## T030

### Objective

Fix the remaining wishlist/favorites control issue inside shop product cards
and improve the WooCommerce archive mobile experience with an off-canvas filter
sidebar and padding alignment closer to the static prototype.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/shop.html`
- `sito-statico/assets/css/style.css`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `woocommerce/archive-product.php`
- `woocommerce/content-product.php`
- `inc/woocommerce.php`
- `inc/enqueue.php`

### Files Created/Modified

- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `woocommerce/archive-product.php`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The wishlist/favorites issue was treated as both a positioning and rendering
  problem: product cards now explicitly establish a positioning context, and
  the wishlist control styling was simplified so plugin wrappers stay anchored
  to the top-right of the card without the previous overly aggressive inner
  hiding logic.
- The mobile/tablet filter experience now uses an off-canvas sidebar opened by
  a toolbar button, because stacking the full desktop sidebar under the results
  made the archive feel heavy and harder to use on smaller screens.
- The off-canvas filter remains inside the justified archive override rather
  than introducing another WooCommerce template override, keeping the existing
  page-shell decision contained to `woocommerce/archive-product.php`.
- Mobile shop padding now keeps horizontal gutters instead of collapsing fully
  edge-to-edge, which better matches the theme shell and is closer to the
  static spacing language.

### Assumptions

- The favorites control is still generated by a wishlist plugin or plugin-like
  extension outside the theme, so the safest theme-side fix is defensive CSS
  normalization rather than coupling the archive to one exact plugin markup.
- For mobile, "barra laterale a scomparsa" is best interpreted as an
  off-canvas filter drawer that preserves the same filter form and submit flow
  already used on desktop.
- Static shop padding is the primary fidelity reference on desktop; on mobile
  the prototype has no dedicated responsive rules, so keeping theme gutters is
  a better conservative match than a full-width edge-to-edge collapse.

### Verification

- Re-read the static `shop.html` and shop CSS to compare toolbar, sidebar and
  card spacing against the current theme implementation.
- Manually reviewed the archive override and theme script to confirm the mobile
  filter drawer supports open, close, overlay click, resize reset and `Escape`
  dismissal.
- Manually reviewed the updated wishlist selectors to confirm the floating
  control is now anchored by a `position: relative` product card and uses a
  simpler pseudo-icon approach with less risk of blank or malformed inner
  plugin markup.
- Automated PHP lint and browser rendering could not be run here because the
  local environment does not provide `php` and no live WordPress/WooCommerce
  runtime is available in this workspace.

### TODO / Residual Risks

- Validate the shop archive in the real browser with the active wishlist plugin
  enabled, because some plugins inject additional wrappers or state classes only
  at runtime.
- Confirm the off-canvas filter drawer interaction on real touch devices,
  especially scroll feel and overlay/close-button discoverability.
- If the live catalog uses especially long filter-group lists, consider adding
  sticky actions or a small internal header shadow inside the drawer later.

---

## T031

### Objective

Refine the mobile header cart badge so its colors match the requested token
combination and the badge/icon group no longer sits too close to the hamburger
menu.

### Files Read

- `AGENTS.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/main.css`
- `header.php`
- `inc/template-tags.php`

### Files Created/Modified

- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile cart badge now uses `var(--bg-clr)` for text and
  `var(--font-clr)` for its background, matching the requested token pairing
  directly in the shared badge selector.
- The mobile controls cluster received a slightly larger gap and the hamburger
  toggle gained a small left margin so the cart badge has clearer separation
  from the menu button without changing desktop spacing.

### Assumptions

- The reported overlap is limited to the mobile header control cluster under the
  existing `782px` breakpoint, so the fix stays scoped to the mobile media
  query.

### Verification

- Manually reviewed the shared cart badge selector to confirm the requested
  colors now come from `var(--bg-clr)` and `var(--font-clr)`.
- Manually reviewed the mobile header breakpoint rules to confirm the added
  spacing affects only `.site-header__mobile-controls` and
  `.site-header__menu-toggle`.

### TODO / Residual Risks

- Validate the spacing on a real mobile viewport with a non-zero cart count,
  since larger badge numbers can slightly change the perceived overlap.

---

## T032

### Objective

Tighten the spacing between the mobile header icon links while keeping a clearer
separation between the icon group and the hamburger toggle.

### Files Read

- `AGENTS.md`
- `docs/IMPLEMENTATION_LOG.md`
- `assets/css/main.css`

### Files Created/Modified

- `assets/css/main.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The mobile control cluster gap was reduced so the wishlist/cart icon links
  read more as one grouped unit.
- The hamburger toggle left margin was increased at the same time, preserving a
  clearer break between the icon group and the menu trigger.

### Assumptions

- The requested adjustment refers to the mobile-only header controls under the
  existing `782px` breakpoint.

### Verification

- Manually reviewed the mobile header CSS to confirm the tighter icon-link
  spacing and the larger toggle offset are both scoped to the mobile media
  query only.

### TODO / Residual Risks

- Validate the cluster visually on a real mobile viewport, especially when the
  cart badge is visible with multi-digit quantities.

---

## T031

### Objective

Implement the WooCommerce single product page to match the provided layout on
desktop and mobile, staying visually coherent with the current site and
minimizing legacy template overrides while also providing a dedicated reviews
area.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `inc/woocommerce.php`
- `inc/enqueue.php`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `woocommerce/archive-product.php`
- `woocommerce/content-product.php`
- `comments.php`
- `single.php`
- `sito-statico/assets/css/style.css`

### Files Created/Modified

- `inc/woocommerce.php`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The single product implementation stays hook-first: no new
  `woocommerce/single-product.php` or other legacy single-product override was
  introduced.
- The page layout is reshaped from `inc/woocommerce.php` by removing
  breadcrumb/rating/meta/tabs/upsells where they conflicted with the target
  composition and by injecting a summary description block plus a dedicated
  reviews section after related products.
- Quantity `- / +` controls were added through WooCommerce quantity hooks and a
  small guarded JS enhancement rather than overriding quantity templates.
- Related products were kept on WooCommerce output but normalized to a 4-card
  grid and styled to stay visually aligned with the existing shop card system.
- Reviews are now explicitly surfaced below the product area instead of staying
  inside WooCommerce tabs, which better matches the requested product-page flow
  while still relying on WooCommerce's native review system.

### Assumptions

- The provided screenshot is a structural and responsive reference, while
  colors, fonts and the overall visual language should remain consistent with
  the current Re Style theme rather than copied literally.
- The existing short description is the best source for the summary copy; when
  it is missing, a trimmed fallback from excerpt/content is acceptable.
- Wishlist/favorites markup on the single summary, if present, is still
  generated by a plugin outside the theme, so only defensive positioning/styling
  should be applied.

### Verification

- Manually reviewed the updated WooCommerce hooks to confirm the single-product
  page now removes tabs/meta/rating from the default flow and adds description,
  related-products normalization and reviews in the intended order.
- Manually reviewed the new single-product CSS for desktop/tablet/mobile
  breakpoints, gallery/thumb layout, summary spacing, add-to-cart controls,
  related cards and review form/list styling.
- Manually reviewed the quantity-stepper JS to confirm it targets only single
  product forms and dispatches `change` events after updating the input value.
- Automated PHP lint and runtime browser verification could not be run in this
  environment because no local `php` executable or live WordPress/WooCommerce
  runtime is available in the workspace.

### TODO / Residual Risks

- Validate the single-product page in the real browser with simple, variable
  and out-of-stock products, because add-to-cart forms can differ across
  product types.
- Confirm the review form/list rendering with the live WooCommerce review
  configuration and locale, especially if review ratings are optional or
  disabled.
- If the active wishlist plugin injects a substantially different summary
  markup than expected, a follow-up CSS normalization may still be needed.

### Additional Note

- A follow-up visual review showed two issues still open after the first
  single-product pass: the shop wishlist/favorites control could render in a
  repeated "a raffica" state because the defensive selectors were too broad,
  and the single-product gallery could still appear too small or visually
  misaligned because WooCommerce/FlexSlider layout wrappers were not reset
  strongly enough.
- The shop wishlist normalization in `assets/css/woocommerce.css` was therefore
  tightened to target only common actionable plugin wrappers/buttons instead of
  generic `[class*="wishlist"]` descendants, while common feedback/status text
  fragments were explicitly hidden.
- The single-product gallery CSS was also hardened by resetting
  `div.images`, `.woocommerce-product-gallery`, `.flex-viewport` and the
  gallery wrapper widths/floats directly, enlarging the main media frame and
  assigning the thumbnail rail and main image viewport to explicit grid
  columns, so the primary image can occupy the intended space more reliably.

---

## T032

### Objective

Move the wishlist/favorites icon rendering for WooCommerce products into the
theme, using the shared `icon-favourite` and `icon-favourite-solid` symbols,
instead of relying on plugin-side DOM injection.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `template-parts/site/icon-sprite.php`
- `inc/template-tags.php`
- `inc/woocommerce.php`
- `woocommerce/content-product.php`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `sito-statico/index.html`
- `sito-statico/shop.html`

### Files Created/Modified

- `template-parts/site/icon-sprite.php`
- `inc/template-tags.php`
- `inc/woocommerce.php`
- `woocommerce/content-product.php`
- `assets/css/woocommerce.css`
- `assets/js/theme.js`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The favorites button is now theme-owned on both shop cards and single product
  summary, so the visible control no longer depends on plugin markup being
  injected correctly into the DOM.
- The theme reuses the same `localStorage` key currently used by the custom
  wishlist plugin (`mio_wishlist_items`) so stored favorite items remain
  compatible with the existing plugin page/data flow.
- The shared icon sprite now includes both `icon-favourite` and
  `icon-favourite-solid`, which lets the button toggle between empty/filled
  states without loading external assets.
- Existing plugin-injected `.mio-wishlist-icon-wrapper` elements are hidden at
  theme level on product cards so the theme button remains the only visible
  favorites control in catalog contexts.
- Header wishlist links now prefer a `lista-preferiti` page slug before the
  older `wishlist` fallback, aligning the theme better with the current plugin.

### Assumptions

- The custom wishlist plugin may remain active for page rendering and storage,
  but the theme should own the product-card and single-product icon UI.
- Keeping compatibility with the plugin's `localStorage` key is preferable to
  introducing a separate theme-only storage model, because it avoids breaking
  the user's existing favorites list.

### Verification

- Manually reviewed the new PHP helper and hook usage to confirm the favorites
  button now renders directly inside `woocommerce/content-product.php` and the
  single-product summary flow.
- Manually reviewed the updated theme script to confirm it toggles active state
  from `localStorage`, syncs across tabs and updates the button UI without
  plugin DOM injection.
- Manually reviewed the new CSS to confirm the theme button uses the shared
  heart icons and plugin-injected wrappers are hidden in product contexts.
- Automated runtime verification and PHP lint could not be run here because no
  local `php` executable or live WordPress/WooCommerce runtime is available in
  the workspace.

### TODO / Residual Risks

- Validate the visible favorites flow in the live browser with the custom
  plugin still active, especially on pages where the plugin may also inject its
  own controls outside shop cards.
- If the plugin later stops using `localStorage` and moves to server-side
  persistence, the theme-side JS should be updated to follow the new source of
  truth instead of `mio_wishlist_items`.

### Additional Note

- A follow-up check showed the theme wishlist button shell rendering as a white
  circle without the heart glyph. The cause was `wp_kses_post()` stripping the
  inline SVG/`use` markup from the theme-generated button HTML.
- The loop card and single-product outputs were therefore adjusted to print the
  helper HTML directly, keeping attribute escaping inside the helper itself so
  the shared `icon-favourite` and `icon-favourite-solid` symbols can render
  correctly.

### Additional Note 2

- A later browser review of the single-product page showed three remaining
  issues: the reviews section was rendering the generic theme comments template
  instead of WooCommerce's product-review template, the review area layout was
  visually misaligned, and the main product image was still reading as too
  narrow/rectangular.
- The single-product reviews output was therefore switched from the generic
  `comments_template()` flow to the WooCommerce `single-product-reviews.php`
  template path, while the single-product CSS was strengthened to assign
  explicit grid columns to gallery/summary, force a square main media viewport
  and normalize WooCommerce review-template wrappers/avatar/comment-text
  spacing.

---

## T033

### Objective

Implement a branded 404 page and a theme-aligned WooCommerce My Account page,
both responsive and scalable, while keeping WooCommerce account work as
hook/CSS-first as possible and exposing key copy/CTA controls through the
Customizer.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `404.php`
- `page.php`
- `template-parts/content/content-page.php`
- `inc/customizer.php`
- `inc/front-page-data.php`
- `inc/woocommerce.php`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `functions.php`

### Files Created/Modified

- `404.php`
- `template-parts/content/content-page.php`
- `inc/customizer.php`
- `inc/woocommerce.php`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The 404 page now has a dedicated branded layout in the theme template, but
  its label, title, description and CTA links are driven by Customizer
  settings rather than being hardcoded.
- The My Account page intentionally stays on WooCommerce core templates: no new
  `woocommerce/myaccount/*` override was introduced for this task.
- A theme-owned account intro block is prepended via `the_content` on the
  account page, which keeps the solution lightweight and compatible with the
  existing page-based WooCommerce account flow.
- The default page title is suppressed only on the account page content
  template so the new intro can own the primary heading cleanly without showing
  duplicate visible titles.
- My Account styling is handled in `assets/css/woocommerce.css` using
  WooCommerce core selectors for navigation, dashboard content, login/register
  forms, orders tables, addresses and buttons, with responsive fallbacks for
  narrower screens.

### Assumptions

- The site should keep using the standard WooCommerce My Account page with its
  shortcode/content model; the theme's responsibility in this task is visual
  integration and light contextual framing rather than replacing the page
  architecture.
- Making the 404 and account intro copy editable from the Customizer is
  sufficient for the current editorial need, without introducing new admin
  option screens or a custom data model.
- The built-in page search form is acceptable for the 404 flow as long as the
  surrounding presentation matches the theme.

### Verification

- Manually reviewed the new Customizer helpers and settings to confirm they add
  dedicated sections for 404 and account copy/links under the existing theme
  options panel.
- Manually reviewed the updated 404 template to confirm it consumes the
  Customizer-driven data and renders branded CTA/search structure.
- Manually reviewed the My Account integration to confirm it uses page content
  filtering plus WooCommerce core markup, rather than introducing new account
  template overrides.
- Manually reviewed the new responsive CSS for 404 and My Account, including
  navigation, forms, orders tables and mobile stacking behavior.
- Automated PHP lint and runtime browser verification could not be run here
  because no local `php` executable or live WordPress/WooCommerce runtime is
  available in the workspace.

### TODO / Residual Risks

- Validate the My Account page in the live browser across logged-out, logged-in
  dashboard, orders, addresses and edit-account endpoints, because WooCommerce
  endpoint content can vary with store configuration.
- Confirm whether the account intro buttons should later change per endpoint
  (for example dashboard vs. orders vs. login state); this pass keeps one
  scalable shared intro for maintainability.
- If the project later requires stronger account-layout parity beyond what core
  WooCommerce markup allows, reassess whether a very narrow template override
  becomes justified and document the reason explicitly.

### Additional Note

- A follow-up requirement asked for stricter font consistency and clearer
  ownership of the internal My Account menu/endpoints while still avoiding
  extra template overrides.
- The account menu is therefore now normalized through the
  `woocommerce_account_menu_items` filter so core/plugin endpoints can present
  the requested labels (`Bacheca`, `Ordini`, `Download`, `Indirizzi`,
  `Dettagli account`, `Esci`, `Disdici iscrizione`) without replacing the
  WooCommerce navigation template.
- Account-area typography was also tightened so textual UI in My Account uses
  only the two theme font stacks already defined by the design system:
  navigation/headings/actions use the primary font and body/form/table content
  uses the secondary font.

### Additional Note 2

- A further refinement pass focused only on the visual quality of My Account
  endpoint-by-endpoint, again without adding WooCommerce account template
  overrides.
- Body classes now expose the active account endpoint so the theme can tune
  dashboard, orders, downloads, addresses, account-details and subscription
  states more precisely through CSS alone.
- Endpoint-specific CSS was then layered on top of the shared account styling
  to improve dashboard emphasis, orders/download actions, address cards,
  account-details fieldsets and active navigation feedback while preserving the
  same overall theme language.

### Additional Note 4

- A later desktop review showed the `edit-address` endpoint still laying out
  poorly because WooCommerce's internal `.col-1` / `.col-2` address wrappers
  were still constraining the two cards and the address-title/action row.
- The account CSS was therefore tightened for the address endpoint by resetting
  those column wrappers, making each address card a full-height grid container
  and improving the internal title/action alignment so the two desktop cards
  read as balanced panels.

### Additional Note 5

- A subsequent browser screenshot showed that the address-card heading row was
  still visually broken because the action link was trying to sit on the same
  line as the large title, producing awkward wrapping on both desktop and
  mobile.
- The address-title block was therefore simplified from a two-item flex row to
  a compact vertical grid so the title and CTA stack cleanly inside each card,
  which keeps the layout stable across viewport sizes.

### Additional Note 6

- A later cross-device screenshot confirmed the address cards were still
  breaking on both desktop and mobile because WooCommerce core float rules on
  the address heading (`h3` and edit/add link) were still winning over the
  theme layout.
- The account stylesheet was therefore tightened again to explicitly reset
  those floats, normalize the `u-columns.woocommerce-Addresses` wrapper as a
  full-width grid container and restate the two-column/one-column behavior for
  the `edit-address` endpoint so the cards stack and align consistently across
  viewport sizes.

### Additional Note 7

- A subsequent live review of the single-product page showed two regressions:
  the review area could still fall back to the wrong template flow and surface
  unrelated theme/sidebar markup, and the main product gallery could collapse
  visually into a very small image inside an oversized empty column.
- The single-product reviews output was therefore switched to the WooCommerce
  template loader (`wc_get_template( 'single-product-reviews.php' )`) with a
  `comments_template()` fallback only when WooCommerce helpers are unavailable.
- The single-product CSS was also strengthened to give the gallery viewport a
  real minimum height, force the inner gallery wrapper/image chain to fill that
  space, and hard-reset any stray sidebar/widget wrappers inside the dedicated
  reviews section so both the upper product layout and the reviews panel stay
  coherent on desktop and mobile.

### Additional Note 8

- A further browser report confirmed two issues still remained on the single
  product page: when a product had no thumbnail rail the gallery still reserved
  the left thumbnail column and visually shrank the main image, and the reviews
  section could still display the wrong fallback content in the live runtime.
- A narrow WooCommerce override was therefore introduced at
  `woocommerce/single-product-reviews.php`, documented as justified because the
  hook-only reviews insertion proved insufficient to guarantee the correct
  markup in this theme context.
- The gallery CSS was also extended with a no-thumbnails branch so
  `.woocommerce-product-gallery` collapses back to a single full-width column
  when no `flex-control-thumbs` items exist, allowing the main media area to
  occupy the full left column as intended.

### Additional Note 9

- A final verification of the repository confirmed that the visible "sidebar"
  content reported inside the reviews area did not originate from any theme
  sidebar template or widget registration in this codebase.
- The single-product integration was therefore hardened in two ways:
  WooCommerce gallery classes now receive a theme-owned `re-style-gallery--single-image`
  marker when the product has only one image, and the theme script now removes
  any unexpected sidebar/widget nodes that may be injected into the dedicated
  reviews block at runtime.

### Additional Note 10

- A later live HTML inspection clarified that the visible `#sidebar` node was
  not inside the reviews block at all: it was being printed after `#primary`
  and before the footer, while the single-product gallery markup on the page
  also lacked the expected `.flex-viewport` wrapper at the moment of render.
- The single-product CSS was therefore tightened again so a direct child
  `.woocommerce-product-gallery__wrapper` is assigned to the main media column
  even before FlexSlider-enhanced markup exists, with a dedicated branch for
  `re-style-gallery--single-image` products.
- As a defensive presentation fix, `body.single-product #sidebar` is now hidden
  in the theme stylesheet because that node is not part of the intended Re
  Style single-product layout and does not originate from the tracked theme
  templates in this repository.

### Additional Note 12

- A later single-product/header refinement pass adjusted three presentation
  details without introducing new WooCommerce template overrides for the main
  product flow.
- The desktop gallery viewport was reduced slightly so the media column feels
  less dominant relative to the summary column.
- WooCommerce success/info/error notices on the single-product page are now
  styled in the same visual language as the rest of the theme, including the
  cart CTA button.
- The header cart icon now includes a theme-owned quantity badge on both
  desktop and mobile, and WooCommerce cart fragments refresh that badge when
  the cart changes via AJAX.

### Additional Note 12

- A further visual review showed that variable products were still not
  inheriting a polished single-product layout: variation selects, stock text,
  reset links and the variation add-to-cart area were rendering too close to
  WooCommerce defaults, and the gallery still needed stronger constraints when
  multiple images/FlexSlider markup were present.
- The single-product stylesheet was therefore extended to cover
  `.variations_form`, `table.variations`, `select`, `reset_variations`,
  `single_variation_wrap`, variation price/availability states and the
  variation add-to-cart row, while keeping the implementation CSS-first.
- The gallery CSS was also reinforced for multi-image products by assigning a
  stable minimum height and full-width behavior to the direct
  `.woocommerce-product-gallery__wrapper` branch as well as the FlexSlider
  viewport branch, so variable products stay visually aligned with the custom
  single-product layout.

### Additional Note 13

- A follow-up browser report showed that gallery images selected from the
  thumbnail rail could still disappear instead of occupying the main viewport.
- The single-product gallery CSS was therefore tightened again for the
  FlexSlider-enhanced branch: the inner `.woocommerce-product-gallery__wrapper`
  now behaves as a stretching flex track and each
  `.woocommerce-product-gallery__image` inside the viewport is forced to occupy
  the full viewport width and a stable minimum height, so selected images stay
  visible when the active slide changes.

---

## T034

### Objective

Connect the existing homepage newsletter section to the provided `oc-newsletter`
 plugin without modifying the plugin itself and without changing the current
 section layout.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `oc-newsletter/oc-newsletter/oc-newsletter.php`
- `oc-newsletter/oc-newsletter/includes/class-oc-newsletter.php`
- `oc-newsletter/oc-newsletter/assets/js/newsletter.js`
- `oc-newsletter/oc-newsletter/templates/newsletter-form.php`
- `template-parts/front-page/newsletter.php`
- `assets/css/front-page.css`

### Files Created/Modified

- `template-parts/front-page/newsletter.php`
- `assets/css/front-page.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The plugin was left untouched; the theme-side newsletter form was adapted to
  the plugin's expected DOM/API contract instead.
- The existing theme markup structure and visual layout were preserved, with
  only the technical form identifiers/names updated so the plugin's frontend
  script can submit the form to `oc_newsletter_signup`.
- A minimal `.newsletter-success` state was added in theme CSS so the plugin's
  success/error replacement message remains visually coherent when the form is
  replaced after submission.

### Assumptions

- The provided `oc-newsletter` plugin will be active on the site, so its
  localized `oc_ajax.ajaxurl` object and frontend script are available.
- Preserving the layout means preserving the current section structure,
  spacing and styling rather than preserving the previous inactive form wiring.

### Verification

- Reviewed the plugin code to confirm it expects a form with
  `id="oc-newsletter-form"`, an `email` field and a `consent` field, then
  submits through AJAX action `oc_newsletter_signup`.
- Reviewed the updated theme newsletter partial to confirm those attributes now
  match the plugin contract without changing the rendered layout structure.
- Reviewed the added CSS success state to confirm the plugin-injected response
  text stays aligned with the current front-page newsletter design.

### TODO / Residual Risks

- Validate the live submission flow with the plugin active, because the plugin
  currently replaces the entire form with a message on success/error and does
  not expose nonce handling or richer field/state hooks.
- If the plugin's frontend script changes its expected selectors in the future,
  the theme-side newsletter partial may need a small compatibility update.

### Additional Note 3

- A later live check showed the My Account screen still rendering almost
  unstyled despite the new account CSS being present in the repository.
- The cause was the frontend enqueue condition in `inc/enqueue.php`: the theme
  was loading `assets/css/woocommerce.css` for `is_woocommerce()` and the shop
  archive helper, but not explicitly for `is_account_page()`.
- The enqueue rule was therefore extended so the WooCommerce stylesheet also
  loads on the account page, allowing the previously added account/menu/endpoint
  styling to actually apply in the browser.

---

## T035

### Objective

Restore 1:1 dimensional fidelity with the static prototype by replacing
theme-side `rem` frontend/token values with the corresponding `px` values used
by the provided static CSS.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `sito-statico/assets/css/style.css`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/css/woocommerce.css`
- `assets/css/editor.css`
- `theme.json`
- `inc/customizer.php`

### Files Created/Modified

- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/css/woocommerce.css`
- `assets/css/editor.css`
- `theme.json`
- `inc/customizer.php`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- Frontend CSS and theme token defaults were realigned to `px` wherever the
  static prototype expresses the corresponding dimensions in `px`.
- `theme.json` spacing units no longer advertise `rem`, reducing the chance of
  reintroducing non-parity values from the editor-facing token layer.
- The Customizer CSS-length sanitizer and helper copy were tightened so theme
  token inputs now prefer `px` and responsive units, instead of presenting
  `rem` as a normal default choice.

### Assumptions

- The user's parity requirement applies not only to section CSS, but also to
  theme-owned design-token defaults that feed the frontend and editor styles.
- Keeping `vw`, `vh` and `%` available remains acceptable for responsive or
  contextual sizing, because the static prototype constraint raised here
  specifically concerns prior theme conversions from `px` to `rem`.

### Verification

- Compared the static prototype token values in
  `sito-statico/assets/css/style.css` against the theme token defaults and
  frontend stylesheets.
- Replaced remaining `rem` values in `assets/css/main.css`,
  `assets/css/front-page.css`, `assets/css/woocommerce.css`,
  `assets/css/editor.css`, `theme.json` and `inc/customizer.php` with their
  `px` equivalents where applicable.
- Re-ran a repository search for `rem` across the updated frontend/token files
  and confirmed only two intentional references remained before cleanup: the
  Customizer validation regex/help text and `theme.json` allowed units.
- Updated those last two configuration/documentation points so the active theme
  implementation no longer uses or promotes `rem` for the parity-sensitive
  token layer.

### TODO / Residual Risks

- Live browser verification in WordPress is still recommended to confirm there
  are no visual regressions from the unit normalization, especially in areas
  later adapted for responsiveness beyond the static prototype.
- The repository still contains many non-parity responsive refinements added in
  later tasks; this pass normalizes units but does not remove those structural
  adaptations outside the explicit scope of the request.

### Additional Note

- A follow-up check after the `px` normalization showed the homepage could
  still appear unchanged in the browser because frontend styles were versioned
  only with the static theme version string.
- The enqueue layer was therefore updated to use `filemtime()`-based asset
  versions for `main.css`, `front-page.css`, `woocommerce.css` and `theme.js`,
  so browser and WordPress cache invalidation now follows the actual file
  change timestamp instead of requiring a manual theme version bump.

---

## T036

### Objective

Refine targeted frontend parity and WooCommerce presentation details across the
homepage location section, 404 page, My Account addresses, cart, single
product and shop filter drawer without expanding scope beyond the reported UI
issues.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `template-parts/site/icon-sprite.php`
- `template-parts/front-page/location-hours.php`
- `404.php`
- `inc/customizer.php`
- `woocommerce/content-product.php`
- `woocommerce/archive-product.php`
- `inc/woocommerce.php`
- `assets/css/main.css`
- `assets/css/front-page.css`
- `assets/css/woocommerce.css`
- `sito-statico/index.html`
- `sito-statico/assets/css/style.css`

### Files Created/Modified

- `template-parts/site/icon-sprite.php`
- `404.php`
- `inc/customizer.php`
- `woocommerce/content-product.php`
- `assets/css/main.css`
- `assets/css/woocommerce.css`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The homepage location pin was realigned to the static prototype by restoring
  the missing inner-circle path in the shared `icon-position` sprite symbol.
- The branded 404 page now removes the search form entirely, and the default
  Customizer description was updated so it no longer mentions search.
- My Account desktop address cards were reinforced to stretch the full content
  width; only the billing card now uses the secondary-button visual treatment
  via CSS-level color alignment rather than template overrides.
- Product-card descriptive copy was removed from the custom loop card template.
- The cart page now uses a two-column desktop layout with separate themed
  panels for line items and totals, while the page background inherits the
  former container background and cart item meta/description text is hidden.
- Single-product refinements were handled CSS-first: wider desktop reviews
  block, larger centered wishlist button, mobile quantity alignment fix,
  desktop sale badge repositioning, and price-decoration normalization.
- Shop mobile filters now open full-screen; the ordering select now has
  theme-colored option base styling, while browser-native option hover
  behavior remains partially system-controlled.

### Assumptions

- The user's cart "description" request was interpreted as hiding extra
  meta/description text shown beneath the product name, not removing the
  product title itself.
- Applying the secondary-button palette to the billing address card means
  reusing its transparent/light treatment and border language rather than
  introducing a new dedicated account-card component.
- Native browser control rendering may still keep system hover colors for
  `<option>` rows in some environments even when base option colors are set.

### Verification

- Compared the static homepage sprite/icon definition against the theme-owned
  sprite and confirmed the missing `icon-position` inner path before patching.
- Reviewed the 404 template and defaults to confirm the search form and search
  wording were both removed.
- Reviewed the updated WooCommerce CSS selectors for account addresses, cart,
  single-product and mobile shop filters to confirm each change stays scoped to
  the requested contexts and breakpoints.
- Reviewed the custom product loop template to confirm descriptive copy is no
  longer rendered.
- Automated PHP lint and live browser verification could not be run here
  because this workspace does not provide a local WordPress/PHP runtime.

### TODO / Residual Risks

- Verify the live cart layout with real coupon/notice/empty-cart states because
  WooCommerce can vary markup slightly across versions and extensions.
- Verify the live My Account `edit-address` endpoint on desktop with real
  billing/shipping content lengths to confirm the card proportions now match
  the intended rectangular presentation.
- Confirm in-browser whether the cart description the user referenced is fully
  covered by the hidden meta selectors; if a plugin injects additional custom
  description markup, a narrower selector may need a follow-up pass.
- On Windows browsers the orderby dropdown option hover state may still remain
  OS-controlled despite the new themed option colors; this is a platform
  limitation rather than a missing theme selector.

### Additional Note

- A follow-up QA pass highlighted that some of the first T036 fixes were still
  being neutralized by the real page wrappers and later mobile breakpoint
  overrides.
- The cart layout was therefore rebound from a direct `.site-main > .woocommerce`
  assumption to the actual `.entry-content > .woocommerce` structure, and the
  cart background/panel colors were inverted to match the requested visual
  hierarchy.
- The single-product sale badge was moved from the default
  `woocommerce_before_single_product_summary` position into the gallery via the
  `woocommerce_product_thumbnails` hook so desktop placement can stay on the
  image rather than drifting into the summary column.
- The My Account address endpoint was simplified from a two-column card grid to
  a single-column stack on desktop, because the user's requested "rectangular"
  cards require two rows rather than two square tiles.
- The mobile shop filter drawer was also corrected a second time because the
  narrower `@media (max-width: 782px)` override was still shrinking the panel
  after the first full-screen pass.

### Additional Note 2

- A later QA pass clarified two concrete causes behind the remaining regressions:
  the WooCommerce stylesheet was not being enqueued on cart/checkout screens at
  all, and the product reviews override was returning too early whenever new
  comments were closed even if existing reviews should still be visible.
- The enqueue condition was therefore extended to include `is_cart()` and
  `is_checkout()`, while the reviews template guard now allows existing review
  output to remain visible when comments exist.
- The account address stack was also adjusted again so shipping now appears
  before billing, matching the requested order on the `edit-address` endpoint.

### Additional Note 3

- A subsequent QA pass showed three narrower refinements were still needed on
  the single-product page: review visibility still depended too much on the
  global comments loop state, the sale-price decoration fix was over-coupled to
  descendant font sizing, and the quantity field change had unintentionally
  affected desktop as well as mobile.
- The reviews override now loads approved comments directly for the current
  product instead of relying on `have_comments()` from the surrounding page
  context, the old-price typography is now applied on the `del` wrapper rather
  than forcing decoration inheritance through child nodes, and the quantity
  field returns to its desktop width while keeping the mobile-only full-width
  expansion.

### Additional Note 4

- A later visual pass requested only a presentation refinement for the
  single-product reviews block after the functional visibility issue had been
  addressed.
- The reviews section was therefore restyled without changing its rendering
  logic: the outer panel now reads as a softer editorial surface, review items
  behave more like elevated cards, author/meta typography is clearer, the form
  fields have stronger focus treatment, and the submit button was refined to
  better match the rest of the theme actions.

### Additional Note 5

- A final visual tweak was requested specifically for the review cards and the
  review submit button.
- The individual review items now use a true white card surface with a slightly
  stronger shadow so they detach cleanly from the surrounding reviews panel,
  and the `Invia` button now enforces the darker primary CTA treatment with the
  warmer hover state already used elsewhere in the theme.

### Additional Note 6

- A final follow-up clarified that the review-card background should remain on
  the theme's `var(--bg-clr)` token rather than pure white.
- The review-item selector was therefore corrected directly at the main
  `.commentlist li` rule with an explicit token-based background assignment.

### Additional Note 7

- A later shop QA pass surfaced two layout-specific issues unrelated to the
  product-card component itself: on desktop the WooCommerce clearfix pseudo
  elements could still occupy the first grid slot, and on mobile the current
  breakpoint was still collapsing the catalog to a single column.
- The shop grid therefore now suppresses the `::before` / `::after` pseudo
  items on the product list and uses a two-column mobile grid at the narrowest
  shop breakpoint.

### Additional Note 8

- A final single-product review refinement focused only on the internal layout
  of each review item.
- The review `comment_container` now gives the avatar more breathing room and a
  clearer content column, while the avatar itself uses a larger framed circle
  with `object-fit: cover` so profile images read more cleanly inside the card.

### Additional Note 9

- A follow-up desktop screenshot showed WooCommerce's internal review meta still
  producing awkward visual artifacts inside the custom review cards.
- The review layout was therefore tightened again by anchoring the avatar and
  `.comment-text` to explicit grid columns and hiding the default
  `woocommerce-review__dash` separator inside the meta row.

### Additional Note 9

- A later shop QA pass showed the sidebar filters were not consistently
  affecting the catalog, while the price range still worked.
- The shop query builder was therefore hardened so taxonomy and meta clauses are
  rebuilt from clean numeric query fragments, category filters explicitly use
  `include_children`, and `on_sale` / `new_arrivals` now intersect safely with
  any existing `post__in` constraints instead of clobbering one another.
- The `new_arrivals` toggle also now behaves as a true filter over the latest
  products instead of only changing the sort order.

### Additional Note 10

- A follow-up report narrowed the remaining shop issue specifically to category
  filtering.
- The shop query now treats `product_cat` as a first-class WooCommerce archive
  parameter by feeding selected category slugs into the native `product_cat`
  query var and skipping duplicate `product_cat` clauses inside the rebuilt
  `tax_query`, reducing the risk of empty results caused by overlapping
  category constraints.

### Additional Note 12

- A later integration pass showed two practical follow-ups were still needed:
  category filters remained fragile when combined with the custom archive
  wrapper, and the newly added wishlist plugin could not be trusted to create
  its own page because its activation hook targets the wrong bootstrap file.
- The shop query therefore now applies selected `product_cat` values through an
  explicit `tax_query` clause with `include_children`, while clearing the native
  `product_cat` query var to avoid mixed strategies inside the same request.
- The wishlist integration was then constrained back to theme-only scope: the
  temporary plugin-side data/rendering extensions were removed, while the theme
  keeps responsibility only for creating a fallback `lista-preferiti` page,
  injecting the shortcode when needed, and restyling the plugin output to match
  the site's visual language.

### Additional Note 13

- A later QA pass surfaced two narrower follow-ups: the wishlist page could
  show the plugin title twice when the stored page content duplicated the same
  heading, and the category filter URL proved the form was submitting correct
  values while the WooCommerce main query still behaved inconsistently.
- The wishlist content filter now collapses duplicate title-only content into a
  single shortcode render, while the shop query hook now runs later on
  `pre_get_posts` so its custom taxonomy constraints are less likely to be
  overwritten by WooCommerce's own query assembly.

### Additional Note 14

- A final follow-up isolated the remaining catalog regression to requests where
  `min_price` and `max_price` were present in the URL but empty, which caused
  the custom price parser to treat those parameters as meaningful values and
  unintentionally exclude products without stored prices.
- The price filter helper now ignores empty price query vars before calling
  WooCommerce decimal formatting, and the wishlist page filter was simplified
  further so the wishlist page always renders only the plugin shortcode,
  preventing any duplicate title stored in page content from appearing above
  the plugin output.

### Additional Note 15

- A final cleanup pass focused on the shop URL shape rather than query parsing:
  empty GET fields such as `min_price=` and `max_price=` were still being sent
  by the archive forms even after the backend stopped treating them as active
  filters.
- The theme script now disables empty GET inputs, unchecked checkboxes and
  other blank filter fields right before submission on the search, sorting and
  filter forms, so the resulting shop URL contains only meaningful parameters.

### Additional Note 16

- A later UI refinement on the shop toolbar addressed a browser-level styling
  limitation rather than a WooCommerce data issue: native `<option>` hover
  states could not be themed consistently across platforms.
- The sort control therefore now keeps the native WooCommerce `<select>` for
  compatibility and form submission, but enhances it with a theme-side custom
  dropdown UI that mirrors the selected value, supports keyboard navigation,
  and allows fully themed hover and selected states for the visible options.

### Additional Note 17

- A later responsive polish pass requested slightly stronger and more uniform
  lateral breathing room on mobile across the site's main content areas,
  without affecting desktop spacing.
- A dedicated mobile main-padding token was therefore introduced and applied to
  the generic `.site-main`, the front page shell, and the WooCommerce mobile
  page wrappers so the perceived edge spacing stays consistent across pages.
- The homepage hero image overlay was also adjusted on desktop to strengthen
  the lower fade, bringing the bottom edge treatment in line with the already
  softened left, right and top sides of the visual.

### Additional Note 18

- A later desktop QA screenshot for the single-product page showed the quantity
  box no longer starting flush with the product description column, even though
  the mobile layout was already correct.
- The quantity control now explicitly resets any inherited left offset and pins
  itself to the start of the add-to-cart row on desktop, while keeping the
  existing mobile full-width behavior unchanged.

### Additional Note 19

- A follow-up refinement on the same single-product add-to-cart row showed the
  generic flex `gap` on `.woocommerce-variation-add-to-cart` was too blunt: it
  contributed to the unwanted desktop spacing, but removing it entirely also
  collapsed the separation between children.
- The row now uses only vertical gap at the wrapper level, while the desktop
  spacing between quantity and add-to-cart button is handled explicitly on the
  button itself and reset again on mobile, so the two breakpoints stay
  independently controllable.

### Additional Note 20

- A later cart refinement requested the Google Pay / express-payment action to
  feel visually consistent with the main theme CTA rather than keeping the
  plugin-default shape.
- The cart stylesheet now applies the same 8px radius and dark CTA background
  language used by the single-product add-to-cart button to the common
  WooPayments / Stripe payment-request button selectors, while keeping the
  standard checkout button unchanged.

### Additional Note 21

- A later cart QA screenshot showed some product rows were still rendering a
  visible short description beneath the item title despite the earlier cart
  cleanup rules.
- The cart `td.product-name` cleanup was therefore broadened to cover the most
  common short-description wrapper classes as well, so the cart keeps only the
  essential product information.

---

## T037

### Objective

Create a dedicated "Resi e rimborsi" page that matches the existing theme
language closely, uses the theme design variables, and incorporates the
client-provided refund copy plus a complementary returns section.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `page.php`
- `index.php`
- `single.php`
- `search.php`
- `searchform.php`
- `template-parts/content/content-page.php`
- `assets/css/main.css`
- `inc/enqueue.php`
- `inc/template-tags.php`
- `header.php`
- `footer.php`
- `sito-statico/informazioni.html`
- `sito-statico/assets/css/style.css`

### Files Created/Modified

- `page-resi-e-rimborsi.php`
- `assets/css/pages.css`
- `inc/enqueue.php`
- `inc/template-tags.php`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The new page is implemented as `page-resi-e-rimborsi.php`, so WordPress can
  target it natively through the `resi-e-rimborsi` page slug without changing
  the generic `page.php` flow.
- The layout reuses the established information-page language from the static
  prototype, but is adapted into a dedicated single-topic page with internal
  anchor navigation, structured cards and shared theme button styles.
- A dedicated `assets/css/pages.css` stylesheet was introduced and loaded only
  for the `resi-e-rimborsi` page, keeping informational-page styling isolated
  from the global and WooCommerce stylesheets.
- All new visual values reference the existing theme token system and CSS
  variables already exposed by `main.css`, instead of introducing a separate
  page-specific palette.
- The fallback footer information link for "Resi e rimborsi" now points to the
  new dedicated page URL rather than the old anchor inside `/informazioni/`.

### Assumptions

- The intended WordPress page slug for this content is `resi-e-rimborsi`.
- Using a theme-owned dedicated template is acceptable for this legal/support
  content because the request asked for a specific page to be created with
  curated copy and strict visual consistency.
- The existing site contact anchor `/#contatti` remains a valid assistance
  destination until a dedicated support/contact page is requested.
- The secondary CTA safely points to `/shop/`, consistent with the theme's
  existing WooCommerce-first direction.

### Verification

- Reviewed the static `informazioni.html` section structure and its CSS card /
  anchor layout before recreating the page in theme form.
- Confirmed the new stylesheet is conditionally enqueued only on
  `is_page( 'resi-e-rimborsi' )`.
- Checked the new template markup against the theme's existing button, label,
  content-width and spacing conventions in `assets/css/main.css`.
- Updated the project brief and implementation log to record the dedicated
  information-page template decision and its scope.
- Automated PHP lint and live WordPress rendering could not be run here because
  the workspace does not provide a local PHP / WordPress runtime.

### TODO / Residual Risks

- Verify in the live WordPress install that the target page slug is exactly
  `resi-e-rimborsi`; if the page uses a different slug, the dedicated template
  file name or enqueue condition should be aligned.
- Review the final in-browser typography for curly apostrophes in the provided
  Italian copy under the site's real encoding/runtime environment.
- If the broader information area is later split into multiple dedicated pages,
  consider extracting these information-page patterns into reusable partials to
  avoid duplication.

---

## T038

### Objective

Create a dedicated "Spedizioni" page that preserves the existing theme style,
uses the shared theme variables, and makes the key shipping information
editable through a dedicated Customizer section.

### Files Read

- `AGENTS.md`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`
- `inc/customizer.php`
- `inc/enqueue.php`
- `page.php`
- `page-resi-e-rimborsi.php`
- `assets/css/main.css`
- `assets/css/pages.css`
- `inc/front-page-data.php`
- `sito-statico/informazioni.html`

### Files Created/Modified

- `page-spedizioni.php`
- `inc/customizer.php`
- `inc/enqueue.php`
- `assets/css/pages.css`
- `docs/PROJECT_BRIEF.md`
- `docs/IMPLEMENTATION_LOG.md`

### Decisions Made

- The new page is implemented as `page-spedizioni.php`, so WordPress can target
  it natively via the `spedizioni` page slug without changing the generic
  `page.php` behavior.
- The layout deliberately reuses the same informational-page design language
  already introduced for `resi-e-rimborsi`, keeping card structure, anchor
  navigation and support CTA patterns visually coherent across both pages.
- Shipping content is split between stable layout copy and Customizer-managed
  operational data, using the existing theme helper pattern:
  `get_*_defaults()`, `get_*_data()` and a dedicated page section in the
  Customizer panel.
- Dynamic multi-item data such as shipping highlights, process steps and FAQ
  entries are stored in textarea controls using the same serialized list
  helpers already used by the homepage Customizer data model.
- Page-specific styles stay inside `assets/css/pages.css` and continue to rely
  on the shared theme CSS variables rather than introducing any new palette or
  spacing constants.

### Assumptions

- The intended WordPress page slug for this content is `spedizioni`.
- The user wants the changing shipping information to be manageable from the
  Customizer rather than embedded as hardcoded-only template copy.
- Reusing the existing informational-page component language is preferable to
  introducing a new visual treatment for a single support page.
- The contact anchor `/#contatti` remains a valid primary assistance
  destination until the project introduces a dedicated customer-support page.

### Verification

- Checked the existing `page-resi-e-rimborsi.php` and `assets/css/pages.css`
  implementation before extending the same pattern to the shipping page.
- Confirmed the page stylesheet is now conditionally enqueued for both
  `resi-e-rimborsi` and `spedizioni`.
- Verified the new shipping-page data model reuses the existing serialized-list
  helpers from `inc/front-page-data.php` instead of duplicating parsing logic.
- Reviewed the new template and CSS against the existing theme token variables
  exposed by `assets/css/main.css`.
- Automated live rendering in a WordPress runtime was not available in this
  workspace.

### TODO / Residual Risks

- Verify in the live WordPress install that the target page slug is exactly
  `spedizioni`; if it differs, the template filename and enqueue condition
  should be aligned.
- Confirm in wp-admin that the Customizer labels are sufficiently clear for the
  editorial workflow, especially for textarea controls that expect one item per
  line.
- If the information area grows further, consider extracting these repeated
  page sections into reusable template parts instead of keeping them in
  dedicated page templates.
