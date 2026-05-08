# Brand assets

This folder contains the **only** images used by the site. No stock photos, no
AI-generated renders. Logo and product photos come directly from Axiom
Technology brand kit.

## Structure

```
assets/images/
├── logo/
│   ├── axiom-black.png      Used on: light surfaces (nav, favicon, OG)
│   ├── axiom-white.png      Used on: dark surfaces (footer)
│   ├── axiom-golden.png     Reserve — alternative accent treatment
│   └── axiom-silver.png     Reserve — alternative accent treatment
└── products/
    ├── axiom-smart-ai.jpg   Used in: hero, products section, calculator
    └── axiom-basic.png      Used in: products section
```

## Replacing assets

Keep the **filenames identical** when replacing. The site uses cache-busting
via `?v=mtime`, so any update is visible after a single page reload.

Recommended export specs:

| Asset            | Format       | Min. size   | Color profile |
|------------------|--------------|-------------|---------------|
| Logo (light bg)  | PNG, 32-bit  | 512×512     | sRGB          |
| Logo (dark bg)   | PNG, 32-bit  | 512×512     | sRGB          |
| Product photo    | JPG/PNG      | 1600×1600   | sRGB          |

Product photography should sit on neutral white background; the site applies
its own pedestal, glow and floor reflection on top — no extra effects needed
in the source file.

## Original client deliverables

The originals provided by the client live next to this folder:

```
assets/Копия Лендинг _ Axiom Technology.pdf  ← landing copy reference
assets/товари /                               ← original product photos
assets/logo axiomtech/                        ← original logo set
```

These paths are not used at runtime (URL-unsafe characters). Working copies
are committed under `assets/images/`.
