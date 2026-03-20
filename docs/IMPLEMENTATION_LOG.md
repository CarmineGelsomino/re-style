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
