# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository status

This repo currently contains **no source code** — only brand assets and a project-level design-skill library under `.claude/rules/`. The expected deliverable is a marketing/landing site for Axiom Technology (see `assets/Копия Лендинг _ Axiom Technology.pdf` for client copy reference). When implementing, scaffold the project from scratch; there is no existing build/test/lint setup to follow.

## Brand assets

Working copies the site must use (filenames are stable, treat as the contract):

- `assets/images/logo/axiom-black.png` — light surfaces (nav, favicon, OG)
- `assets/images/logo/axiom-white.png` — dark surfaces (footer)
- `assets/images/logo/axiom-{golden,silver}.png` — reserve accent treatments
- `assets/images/products/axiom-smart-ai.jpg` — hero, products, calculator
- `assets/images/products/axiom-basic.png` — products section

Original client deliverables live alongside (`assets/logo axiomtech/`, `assets/товари /`, the PDF). Their paths contain URL-unsafe characters (Cyrillic, spaces) and must **not** be referenced at runtime — copy into `assets/images/` instead. Cache-busting convention: append `?v=<mtime>` to image URLs.

Product photography is shot on neutral white. The site is expected to add its own pedestal, glow, and floor reflection in CSS/markup — do not bake those effects into the source files. No stock photos, no AI-generated imagery.

## Design system (mandatory)

The `.claude/rules/` directory contains a large set of design/engineering skills that are auto-loaded as project instructions and **override** default behavior. Key constraints applied to every visual deliverable:

- **No emojis anywhere** in code, markup, content, or alt text.
- **Banned fonts:** Inter, Roboto, Arial, generic system fonts, generic serifs (Times/Georgia/Garamond). Use `Geist`, `Satoshi`, `Cabinet Grotesk`, `Outfit`, or — for editorial — `Fraunces`/`Instrument Serif`.
- **No pure `#000000`** — use Zinc-950 / off-black. Max one accent color, saturation < 80%. Banned: purple/blue "AI" gradients, neon glows.
- **Banned icon defaults:** Lucide/Feather. Use Phosphor or Radix.
- **Layout:** never `h-screen` (use `min-h-[100dvh]`); CSS Grid over flexbox percentage math; no 3-equal-card feature rows; container ~1400px max.
- **Animation:** only `transform` / `opacity`; spring physics over linear easing; `IntersectionObserver` over scroll listeners.
- **Content:** no AI clichés ("Elevate", "Seamless", "Unleash", "Next-Gen"); no fake names ("John Doe", "Acme"); no fake-round metrics (`99.99%`).

Skill files relevant to most tasks:
- `taste-skill/SKILL.md` — baseline frontend engineering directives + dial config (DESIGN_VARIANCE, MOTION_INTENSITY, VISUAL_DENSITY).
- `stitch-skill/DESIGN.md` — full token system (palette hex codes, typography scale, component specs).
- `output-skill/SKILL.md` — forbids `// ...`, `// rest of code`, "for brevity" shortcuts. Always deliver complete files.
- `redesign-skill/SKILL.md` — audit checklist when modifying existing code.
- `imagegen-frontend-web/SKILL.md`, `imagegen-frontend-mobile/SKILL.md`, `image-to-code-skill/SKILL.md` — image-first workflows (one image per section, no cropping old images).
- `brandkit/SKILL.md`, `minimalist-skill/SKILL.md`, `brutalist-skill/SKILL.md`, `soft-skill/SKILL.md`, `gpt-tasteskill/SKILL.md` — alternative aesthetic modes; pick one and commit, do not mix.

When the user picks an aesthetic mode, that skill's rules supersede the others where they conflict. The `output-skill` non-truncation rule and the universal bans (emojis, Inter, pure black, AI clichés) always apply.

## Localization

User communication is in Ukrainian (per environment locale). Site copy language follows the client PDF — verify before writing user-facing strings.
