# AGENTS.md

## Purpose

This repository is the operating base for converting the existing static
frontend into a modern WordPress + WooCommerce classic theme.

This file is the canonical playbook for future tasks. If `AGENT.md` and
`AGENTS.md` ever diverge, follow `AGENTS.md`.

## Mandatory Read Order Before Any Change

Before modifying files:

1. Read `AGENTS.md`
2. Read `docs/PROJECT_BRIEF.md`
3. Read `docs/IMPLEMENTATION_LOG.md`
4. Inspect the relevant code already present in the repository
5. Limit changes to the explicit task scope
6. Update the final implementation log entry for the task

## Current Repository Snapshot

Current repository areas:

- `sito-statico/index.html`: static homepage / one-page prototype
- `sito-statico/shop.html`: static shop listing prototype
- `sito-statico/informazioni.html`: static customer information page
- `sito-statico/assets/css/style.css`: monolithic prototype stylesheet
- `sito-statico/assets/js/main.js`: prototype interaction scripts
- `docs/PROJECT_BRIEF.md`: product, architecture and roadmap brief
- `docs/IMPLEMENTATION_LOG.md`: chronological task log

## Architecture Guardrails

The target deliverable must be a WordPress classic theme, not a block theme.

Required direction:

- use classic PHP templates and standard WordPress template hierarchy
- keep WooCommerce compatibility first-class
- use `theme.json` only where it improves design tokens, editor settings or
  global styles inside a classic theme workflow
- prefer theme supports, hooks and styles before WooCommerce template overrides
- keep PHP lean, predictable and organized
- keep CSS and JS minimal, intentional and maintainable

Do not:

- convert the project into a block theme or FSE theme
- add page builders
- add unnecessary runtime dependencies
- move business logic into theme templates
- introduce WooCommerce legacy overrides without a written reason

## Working Principles

For every task:

- analyze the existing implementation first
- preserve the visual language of the static prototype unless the task says
  otherwise
- choose maintainable WordPress patterns over literal static 1:1 copies when
  the prototype is too rigid
- document every non-obvious compromise
- avoid refactors outside the requested scope

## WordPress Theme Conventions

Unless a later task changes them, use these provisional conventions:

- theme slug: `re-style`
- text domain: `re-style`
- function prefix: `re_style_`

Expected theme structure once implementation starts:

- `style.css`
- `functions.php`
- `theme.json`
- `inc/`
- `assets/css/`
- `assets/js/`
- `assets/img/`
- `template-parts/`
- `woocommerce/` only if an override is justified
- `templates/` only if needed for page templates or focused views

## Frontend-To-Theme Mapping Rules

Use the static frontend as the visual and content reference, not as the final
architectural shape.

Preferred mapping:

- global shell -> `header.php`, `footer.php`, shared template parts
- homepage sections -> `front-page.php` plus reusable template parts
- shop listing -> WooCommerce archive templates, hooks and styles
- product detail/cart/checkout/account -> WooCommerce defaults first, theme
  styling second, overrides only when necessary
- information pages -> standard WordPress pages or dedicated page templates

## Content And Editing Strategy

Make conservative assumptions unless the repository or user gives stronger
requirements.

Default content strategy:

- use native WordPress features first: menus, custom logo, widgets if needed,
  featured images, page content, excerpts, categories, product taxonomies
- use the block editor as a content editor inside a classic theme where useful
- avoid introducing extra option panels without a clear editorial need
- avoid assuming ACF or other custom-field plugins unless requested
- if structured homepage fields become necessary, document the reason before
  adding a dependency or custom data model

## Quality Bar

Always aim for:

- semantic HTML
- responsive layouts
- keyboard access
- visible focus states
- WCAG 2.2 AA aware decisions
- translation readiness
- proper escaping and sanitization
- compatibility with SEO plugins
- restrained asset loading

## WooCommerce Rules

WooCommerce work must follow this order of preference:

1. theme support declarations
2. CSS styling and wrapper alignment
3. hooks and filters
4. template overrides as a last resort

When an override is added, document:

- why hooks or CSS were insufficient
- which template was overridden
- which WooCommerce experience it affects
- maintenance risk during plugin updates

## Documentation Discipline

After every completed task:

1. update `docs/IMPLEMENTATION_LOG.md`
2. update `docs/PROJECT_BRIEF.md` if scope, assumptions or architecture changed
3. record files read, files modified, decisions, assumptions, verifications and
   residual risks

Use task IDs in ascending order: `T000`, `T001`, `T002`, and so on.

## Expected Output Style For Future Tasks

At task close-out, always provide:

- a short outcome summary
- files modified
- key decisions
- verification performed
- open TODOs or risks

If information is missing, make conservative assumptions and document them
explicitly instead of blocking progress.
