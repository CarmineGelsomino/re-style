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
