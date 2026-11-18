# WP Starter Child

Child theme for [WP Starter Theme](../wp-starter-theme/). All site-specific work goes
here, so the parent theme can be updated without overwriting it.

Rename the theme for each site — folder, `style.css`, `functions.php`, `package.json`,
language files, `phpcs.xml` and `phpstan.neon`. The full checklist is in the project's README, under
"New client site → Rename the child theme".

---

## Files

```
wp-starter-child/
├── style.css        # Theme header only
├── functions.php    # Hooks, filters and pluggable function overrides
├── theme.json       # Only what differs from the parent (merged automatically)
├── assets/scss/     # The site's CSS, built to assets/css/style.min.css (see Build)
├── package.json     # The SCSS build (Dart Sass)
├── blocks/          # The site's blocks; _example/ is a template to copy
├── acf-json/        # ACF field groups (saved here by ACF)
├── screenshot.png   # Shown under Appearance → Themes (1200×900); replace with the site's own
├── languages/       # Text domain wp-starter-child (also translates the theme header)
└── README.md
```

After changing the theme header or adding strings, update the translations from this folder:

```bash
../../../../vendor/bin/wp i18n make-pot . languages/wp-starter-child.pot --domain=wp-starter-child
../../../../vendor/bin/wp i18n update-po languages/wp-starter-child.pot languages/sv_SE.po
# Translate the new strings in sv_SE.po, then:
../../../../vendor/bin/wp i18n make-mo languages/sv_SE.po languages/
```

---

## Build

The site's CSS is written in SCSS in `assets/scss/` and built with Dart Sass to
`assets/css/style.min.css`, which loads after the parent's CSS on the front end and in
the editor. The built file is not committed — it is built locally and on deploy.

```bash
npm ci           # once, and after package-lock.json changes
npm run dev      # while working: watch + Browsersync
npm run watch    # only the SCSS build, without a browser
npm run build    # minified, as on deploy
```

`npm run dev` opens the site through Browsersync, injects CSS changes and reloads the
page when PHP, `theme.json` or block files change. It proxies `WP_HOME` from the
project's `.env`, so `bs-config.cjs` works unchanged on every site.

The build needs the parent theme installed (`composer install` in the project root
first): every partial starts with `@use '../abstracts' as *;`, which forwards the
parent's abstracts (`$color-*`, `$radius-*`, `mq-up()`, `focus-visible-shadow()` …) and
this site's own tokens in `abstracts/_tokens.scss`.

Take every value from a token: colors, fonts, radius, transitions and the site's own
tokens are set in `theme.json` and reach the CSS as `var(--wp--preset--…)` and
`var(--wp--custom--…)`, so a change there needs no rebuild.

If `npm run watch` does not notice changes (npm 11 does not run `@parcel/watcher`'s install
script until it is approved), run `npm install-scripts approve @parcel/watcher`, or
`npx sass --load-path=.. --watch --poll assets/scss/style.scss:assets/css/style.min.css`.

---

## How to customize

| What | How |
|------|-----|
| CSS | Write SCSS in `assets/scss/` (see [Build](#build)). It loads after the parent's CSS, on the front end and in the editor. |
| Colors | Change them in `theme.json` (see [Colors](#colors)). Links, buttons, focus rings and the editor's color picker follow. |
| Spacing, widths, radius, shadows, headings, buttons, menu, focus ring … | Every design value is a token in `theme.json`: set your own values in this theme's `theme.json` — the full list is under "Design tokens" in the parent's README. |
| The site's own CSS variables | Put them in `:root` in `assets/scss/base/_root.scss`. |
| Font sizes, spacing in the editor | Add them to `theme.json`. It is merged with the parent's `theme.json`. |
| A template | Copy the file from the parent's `template-parts/` (or a root template like `page.php`) to the same path here and edit the copy. |
| Header logo / site name | Copy the parent's `template-parts/header/branding.php` here — e.g. a full logo next to the site name, or another logo on mobile (styles in your SCSS). |
| Footer | Build it with blocks in the footer widget areas, or copy the parent's `footer.php` here (see [Footer](#footer)). |
| A `wpst_*` function | Define a function with the same name in `functions.php`. Works for functions the parent wraps in `function_exists()`, e.g. `wpst_posted_on()`, `wpst_button()`. |
| Behaviour | Use hooks and filters, e.g. `remove_action()`, `add_filter()`. |
| Logo and icons | Put your own `assets/svg/logo.svg` or icons here; they replace the parent's. |

Do not copy files from the parent's `inc/` folder — they are always loaded from the
parent, and a copy would stop receiving updates.

---

## Menus

A menu item with a submenu only opens the submenu — it is a button, not a link, so it
works the same with mouse, keyboard and touch. If the parent page itself should be
reachable, add it as the first item in the submenu, preferably with its own label such as
"Overview".

Footer links go in a **Navigation Menu** widget in a footer widget area
(**Appearance → Widgets**). "Manage cookies" is added to the footer's copyright row by
HNRK Cookie Consent when it is set to **In the footer**. To add more to that row, use the
`wpst_footer_copyright_end` action.

A menu item that should look like a button: give it a CSS class in **Appearance → Menus**
(turn on **CSS Classes** under **Screen Options**) and style it in your SCSS.

---

## Footer

The footer's four widget areas (**Appearance → Widgets**) take blocks — columns,
headings, images, ACF blocks such as contact details — so most footers are built there.
Colors and spacing come from `custom.footer` in `theme.json`.

For a different layout, copy the parent's `footer.php` to this theme and change it:

1. Keep `<?php wp_footer(); ?>` and the closing tags (`</div>`, `</body>`, `</html>`) —
   plugins and scripts, e.g. the cookie banner, need `wp_footer()`.
2. Keep `<?php do_action( 'wpst_footer_copyright_end' ); ?>` in the footer. The parent
   prints the "Manage cookies" link there when HNRK Cookie Consent is set to
   **In the footer**; without it the link is gone, which GDPR does not allow.
3. The copy does not get the parent's later changes to `footer.php` — start from the
   parent's file and change only what you need.

Other widget areas: register them in `functions.php` with `register_sidebar()` and print
them in your `footer.php` with `dynamic_sidebar()`.

---

## Blocks

The site's own blocks live in `blocks/`, one folder per block. The parent theme registers
every `blocks/{name}/block.json` automatically — folders starting with `_` are skipped.

**A new ACF block:**

1. Copy `blocks/_example/` to `blocks/{name}/` (no leading `_`).
2. In `block.json`, change `name` (`acf/{name}`), `title`, `description` and `icon`.
3. Create a field group in **ACF → Field Groups** with the location **Block** is equal to
   your block. ACF saves it as JSON in `acf-json/` — commit those files.
4. Write the markup in `block.php` (`get_field()` for the fields) and the CSS in
   `block.css`. The CSS is loaded on pages with the block and in the editor.

ACF blocks are not registered while ACF PRO is inactive, so the site never shows broken
blocks. A block without an `acf` key in `block.json` is registered as a regular block
(it needs its own JavaScript for the editor).

### Hero block

When a page starts with a hero block, the parent theme leaves out its page title — the
hero block must then output the page's `<h1>`. Tell the theme which blocks are heroes:

```php
add_filter(
	'wpst_hero_blocks',
	function ( $blocks ) {
		$blocks[] = 'acf/hero';
		return $blocks;
	}
);
```

---

## Colors

All colors come from the parent's `theme.json` palette. To change one, add a color
with the same slug to this theme's `theme.json`:

```json
{
  "settings": {
    "color": {
      "palette": [
        { "slug": "primary", "color": "#0f766e", "name": "Primary" }
      ]
    }
  }
}
```

Note: a palette here replaces the parent's whole palette in the editor's color picker.
Copy the parent's palette and change the values you need, so all colors stay available
to editors. (The CSS keeps working either way — the parent has fallback values for
every color.)
Hover colors are computed in the browser with `color-mix()`, so they follow automatically.
If the darker shade does not work (e.g. a near-black primary), set your own in
`theme.json`, together with the text and heading colors if needed:

```json
{
  "settings": {
    "custom": {
      "color": { "text": "var(--wp--preset--color--gray-600)", "heading": "var(--wp--preset--color--gray-900)" },
      "link": { "hoverColor": "var(--wp--preset--color--gold-dark)" },
      "button": { "primaryHoverBackground": "var(--wp--preset--color--gold-dark)" }
    }
  }
}
```

---

## Fonts

The parent self-hosts Montserrat and Fraunces. To use other fonts:

1. Put the woff2 files in `assets/fonts/` here (e.g. from [Fontsource](https://fontsource.org)).
2. Define `fontFamilies` with `fontFace` in `theme.json`. This replaces the parent's list,
   so include every family and style you need. `file:./` paths look in this theme first
   and then in the parent, so the parent's files can be reused without copying.
3. Keep the slugs `body` (running text) and `heading` (headings, logo text). The parent's
   CSS uses those two families, so the site changes fonts without any CSS.

Example — adding Montserrat italic to the parent's fonts:

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "slug": "body",
          "name": "Body (Montserrat)",
          "fontFamily": "Montserrat, sans-serif",
          "fontFace": [
            { "fontFamily": "Montserrat", "fontStyle": "normal", "fontWeight": "100 900", "fontDisplay": "swap", "src": [ "file:./assets/fonts/montserrat-latin-wght-normal.woff2" ] },
            { "fontFamily": "Montserrat", "fontStyle": "italic", "fontWeight": "100 900", "fontDisplay": "swap", "src": [ "file:./assets/fonts/montserrat-latin-wght-italic.woff2" ] }
          ]
        },
        {
          "slug": "heading",
          "name": "Heading (Fraunces)",
          "fontFamily": "Fraunces, serif",
          "fontFace": [
            { "fontFamily": "Fraunces", "fontStyle": "normal", "fontWeight": "100 900", "fontDisplay": "swap", "src": [ "file:./assets/fonts/fraunces-latin-opsz-normal.woff2" ] }
          ]
        }
      ]
    }
  }
}
```

Only `montserrat-latin-wght-italic.woff2` needs to be added here — the other files are
found in the parent.
