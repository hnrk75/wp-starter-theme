# WP Starter Theme

A modern, Bootstrap-free WordPress starter theme built with SCSS (ITCSS), Gulp, and Bedrock.
Follows WordPress Coding Standards (WPCS) with built-in linting for PHP, JS, and SCSS.

---

## Theme Information

**Theme Name:** WP Starter Theme
**Version:** 2.0.1
**Author:** Henrik Pettersson
**License:** GPL-2.0
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html

---

## Description

A responsive WordPress starter theme with a clean ITCSS/BEM SCSS architecture, fluid typography
via theme.json, a Gulp 5 build pipeline, and full accessibility (WCAG) support.
No Bootstrap — custom container system, spacing scale with clamp(), and Google Fonts via PHP.

---

## Requirements

| Dependency | Minimum |
|------------|---------|
| WordPress  | 6.9     |
| PHP        | 8.1     |
| Node.js    | 20.x    |
| npm        | 10.0    |
| Composer   | 2.0     |

---

## Features

- SCSS ITCSS architecture with @use/@forward (no Bootstrap)
- Fluid typography via theme.json (clamp-based font sizes)
- Fluid spacing scale (--space-xs to --space-xxl)
- Gulp 5 build system — CSS, JS, BrowserSync, sourcemaps
- Google Fonts loaded via wp_enqueue_style (heading + body)
- Custom Bootstrap-like container system in rem
- BEM methodology with consistent nesting
- WCAG-compliant navigation with custom navwalker
- Gutenberg support — editor-style, theme.json, alignment classes
- Accessibility — skip link, aria-labels, screen-reader-text, focus-visible
- Code linting via ESLint, Stylelint, Prettier, PHPCS and PHPStan

---

## Installation

1. In WordPress admin, go to **Appearance › Themes › Add New**.
2. Click **Upload**, select `wp-starter-theme.zip`.
3. Click **Install Now**, then **Activate**.

---

## Development

Run from inside `web/app/themes/wp-starter-theme/`:

```bash
npm install        # Install dependencies
npm run dev        # Watch + BrowserSync
npm run build      # Production build
npm run lint       # Lint JS, CSS and PHP
npm run fix        # Auto-fix JS, CSS and PHP
```

---

## SCSS Structure

```
assets/sass/
├── abstracts/     # Variables, mixins, functions
├── base/          # Reset, root (CSS custom properties), typography, accessibility
├── layout/        # Grid/containers, header, footer, content
├── components/    # Buttons, navigation, icons, card
└── gutenberg/     # Editor alignment classes
```
