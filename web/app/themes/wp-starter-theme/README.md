# WP Starter Theme

A modern, Bootstrap-free WordPress starter theme built with SCSS (ITCSS), Gulp, and Bedrock.
Follows WordPress Coding Standards (WPCS) with built-in linting for PHP, JS, and SCSS.

---

## Theme information

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
- Fluid spacing scale (--space-xs to --space-xl)
- Gulp 5 build system — CSS, JS, BrowserSync
- Google Fonts loaded via wp_enqueue_style (heading + body)
- Custom Bootstrap-like container system in rem
- BEM methodology with consistent nesting
- WCAG-compliant navigation with custom navwalker
- Gutenberg support — editor-style, theme.json, alignment classes
- Accessibility — skip link, aria-labels, screen-reader-text, focus-visible
- Code linting via ESLint, Stylelint, Prettier, PHPCS and PHPStan

---

## Installation

This theme is part of a Bedrock project and is managed via Composer.
See the project root `README.md` for full setup instructions.

To activate, log in to WordPress admin and go to **Appearance › Themes**.

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

## SCSS structure

```
assets/scss/
├── abstracts/     # Variables, mixins, functions
├── base/          # Reset, root (CSS custom properties), typography, accessibility
├── layout/        # Grid/containers, header, footer, content
├── components/    # Links, buttons, navigation, icons, card
└── gutenberg/     # Editor alignment classes
```

---

## Buttons & Links

All CSS is located in:
- `assets/scss/components/_links.scss` — all link styles
- `assets/scss/components/_buttons.scss` — all button styles
- PHP helper: `inc/helpers-buttons.php` → `wpst_button()`
- SVG icons: `assets/svg/icon-intern-link.svg`, `icon-extern-link.svg`

---

### Links

#### Standard `<a>` — neutral (no class)
All `<a>` outside `.btn` are neutral: color + hover color, no underline.

```html
<a href="/about">About us</a>
```

#### `.link-animated` — animated underline
Opt-in animated underline that slides in on hover.

```html
<a href="/about" class="link-animated">About us</a>
```

#### `.link-icon` — link with icon
Opt-in icon after the link text. SVG is inlined via `wpst_icon()` which automatically determines internal/external icon based on the URL.

```php
// Internal link (arrow icon)
<a href="/about" class="link-icon">
    About us <?php wpst_icon( 'icon-intern-link' ); ?>
</a>

// External link (external icon)
<a href="https://example.com" class="link-icon" target="_blank" rel="noopener noreferrer">
    External site <?php wpst_icon( 'icon-extern-link' ); ?>
</a>
```

---

### Buttons

The base class is `.btn`. Always add a variant. The PHP helper `wpst_button()` is recommended.

#### Variants

| Class | Usage |
|-------|-------|
| `.btn-primary` | Primary CTA (default) |
| `.btn-secondary` | Secondary action |
| `.btn-tertiary` | Tertiary / soft action |
| `.btn-light` | Light background |
| `.btn-dark` | Dark background |
| `.btn-ghost` | Outline button |

#### Sizes

| Class | Usage |
|-------|-------|
| *(none)* | Default size |
| `.btn-sm` | Small |
| `.btn-lg` | Large |

#### Plain HTML

```html
<a href="/contact" class="btn btn-primary">Contact us</a>
<button type="submit" class="btn btn-primary">Submit</button>
<a href="/about" class="btn btn-ghost btn-lg">Read more</a>
```

#### PHP helper `wpst_button()`

```php
// Simple button
wpst_button( array(
    'label' => 'Contact us',
    'href'  => '/contact',
) );

// Button with icon (automatic internal/external detection)
$is_external = ! empty( $link_host ) && $link_host !== $home_host;
$icon_name   = $is_external ? 'icon-extern-link' : 'icon-intern-link';

wpst_button( array(
    'label'     => 'Visit page',
    'href'      => $url,
    'external'  => $is_external,
    'icon_html' => wpst_icon( $icon_name, array( 'echo' => false ) ),
    'icon_pos'  => 'after',
) );

// Form button
wpst_button( array(
    'label' => 'Submit',
    'type'  => 'submit',
) );
```

#### Arguments for `wpst_button()`

| Argument | Default | Description |
|----------|---------|-------------|
| `label` | `''` | Visible text |
| `variant` | `'primary'` | Button variant (see table above) |
| `size` | `''` | `btn-sm` or `btn-lg` |
| `href` | `''` | URL — renders `<a>`, otherwise `<button>` |
| `type` | `'button'` | `button`, `submit`, `reset` |
| `target` | `''` | `_blank` etc. |
| `external` | `false` | Adds `rel="noopener noreferrer"` |
| `disabled` | `false` | Disables the button |
| `icon_html` | `''` | SVG string (e.g. from `wpst_icon()`) |
| `icon_pos` | `'before'` | `before` or `after` |
| `class` | `array()` | Extra CSS classes |
| `aria_label` | `''` | Accessible label |
| `display` | `true` | `false` returns HTML instead of echoing |

---

### SVG icons

```php
wpst_icon( 'icon-intern-link' );                                   // Echo directly
$svg = wpst_icon( 'icon-intern-link', array( 'echo' => false ) );  // Return as string
wpst_icon( 'icon-intern-link', array( 'title' => 'Go to' ) );      // With a11y title
```

| File | Usage |
|------|-------|
| `icon-intern-link.svg` | Arrow — internal links |
| `icon-extern-link.svg` | External icon — external links |
