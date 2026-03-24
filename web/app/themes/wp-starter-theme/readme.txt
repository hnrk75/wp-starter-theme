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
├── components/    # Links, buttons, navigation, icons, card
└── gutenberg/     # Editor alignment classes
```

---

## Knappar & Länkar

All CSS finns i:
- `assets/sass/components/_links.scss` – alla länkstilar
- `assets/sass/components/_buttons.scss` – alla knappstilar
- PHP-hjälpare: `inc/helpers-buttons.php` → `wpst_button()`
- SVG-ikoner: `assets/svg/icon-intern-link.svg`, `icon-extern-link.svg`

---

### Länkar

#### Standard `<a>` – neutral (ingen klass)
Alla `<a>` utanför `.btn` är neutrala: färg + hover-färg, ingen underline.

```html
<a href="/om-oss">Om oss</a>
```

#### `.link-animated` – animerat underline
Opt-in animerat underline som glider in vid hover.

```html
<a href="/om-oss" class="link-animated">Om oss</a>
```

#### `.link-icon` – länk med ikon
Opt-in ikon efter länktexten. Kräver `<span class="icon">` med inline-SVG inuti länken.
Använd `wpst_icon()` för att ladda rätt ikon – PHP avgör intern/extern baserat på URL:en.

```php
// Intern länk (pil-ikon)
<a href="/om-oss" class="link-icon">
    Om oss <?php wpst_icon( 'icon-intern-link' ); ?>
</a>

// Extern länk (extern-ikon)
<a href="https://extern.se" class="link-icon" target="_blank" rel="noopener noreferrer">
    Extern sajt <?php wpst_icon( 'icon-extern-link' ); ?>
</a>
```

---

### Knappar

Grundklassen är `.btn`. Lägg alltid till en variant. PHP-hjälparen `wpst_button()` rekommenderas.

#### Varianter

| Klass | Användning |
|-------|-----------|
| `.btn-primary` | Primär CTA (standardvalet) |
| `.btn-secondary` | Sekundär åtgärd |
| `.btn-tertiary` | Tertiär / mjuk åtgärd |
| `.btn-light` | Ljus bakgrund |
| `.btn-dark` | Mörk bakgrund |
| `.btn-ghost` | Outline-knapp |

#### Storlekar

| Klass | Användning |
|-------|-----------|
| *(ingen)* | Standardstorlek |
| `.btn-sm` | Liten |
| `.btn-lg` | Stor |

#### HTML direkt

```html
<a href="/kontakt" class="btn btn-primary">Kontakta oss</a>
<button type="submit" class="btn btn-primary">Skicka</button>
<a href="/om-oss" class="btn btn-ghost btn-lg">Läs mer</a>
```

#### PHP-hjälparen `wpst_button()`

```php
// Enkel knapp
wpst_button( array(
    'label' => 'Kontakta oss',
    'href'  => '/kontakt',
) );

// Knapp med ikon (automatisk intern/extern-detektion)
$is_external = ! empty( $link_host ) && $link_host !== $home_host;
$icon_name   = $is_external ? 'icon-extern-link' : 'icon-intern-link';

wpst_button( array(
    'label'     => 'Besök sidan',
    'href'      => $url,
    'external'  => $is_external,
    'icon_html' => wpst_icon( $icon_name, array( 'echo' => false ) ),
    'icon_pos'  => 'after',
) );

// Formulärknapp
wpst_button( array(
    'label' => 'Skicka',
    'type'  => 'submit',
) );
```

#### Argument för `wpst_button()`

| Argument | Standard | Beskrivning |
|----------|----------|-------------|
| `label` | `''` | Synlig text |
| `variant` | `'primary'` | Knappvariant (se tabell ovan) |
| `size` | `''` | `btn-sm` eller `btn-lg` |
| `href` | `''` | URL – renderar `<a>`, annars `<button>` |
| `type` | `'button'` | `button`, `submit`, `reset` |
| `target` | `''` | `_blank` etc. |
| `external` | `false` | Lägger till `rel="noopener noreferrer"` |
| `disabled` | `false` | Inaktiverar knappen |
| `icon_html` | `''` | SVG-sträng (t.ex. från `wpst_icon()`) |
| `icon_pos` | `'before'` | `before` eller `after` |
| `class` | `array()` | Extra CSS-klasser |
| `aria_label` | `''` | Tillgänglig etikett |
| `display` | `true` | `false` returnerar HTML istället för att echa |

---

### SVG-ikoner

```php
wpst_icon( 'icon-intern-link' );                              // Echa direkt
$svg = wpst_icon( 'icon-intern-link', array( 'echo' => false ) ); // Hämta som sträng
wpst_icon( 'icon-intern-link', array( 'title' => 'Gå till' ) );   // Med a11y-titel
```

| Fil | Användning |
|-----|-----------|
| `icon-intern-link.svg` | Pil – interna länkar |
| `icon-extern-link.svg` | Extern-ikon – externa länkar |
