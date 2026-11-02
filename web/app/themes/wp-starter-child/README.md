# WP Starter Child

Child theme for [WP Starter Theme](../wp-starter-theme/). All site-specific work goes
here, so the parent theme can be updated without overwriting it.

Rename the theme for each site — folder, `style.css`, `functions.php`, language files,
`phpcs.xml` and `phpstan.neon`. The full checklist is in the project's README, under
"New client site → Rename the child theme".

---

## Files

```
wp-starter-child/
├── style.css        # Theme header + site-specific CSS
├── functions.php    # Hooks, filters and pluggable function overrides
├── theme.json       # Only what differs from the parent (merged automatically)
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

## How to customize

| What | How |
|------|-----|
| CSS | Write it in `style.css`. It loads after the parent's CSS, on the front end and in the editor. |
| Colors | Change them in `theme.json` (see [Colors](#colors)). Links, buttons, focus rings and the editor's color picker follow. |
| Other CSS variables | Override the parent's custom properties in `:root` in `style.css`, e.g. `--measure`. |
| Font sizes, spacing in the editor | Add them to `theme.json`. It is merged with the parent's `theme.json`. |
| A template | Copy the file from the parent's `template-parts/` (or a root template like `page.php`) to the same path here and edit the copy. |
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

---

## Fonts

The parent self-hosts Montserrat and Fraunces. To use other fonts:

1. Put the woff2 files in `assets/fonts/` here (e.g. from [Fontsource](https://fontsource.org)).
2. Define `fontFamilies` with `fontFace` in `theme.json`. This replaces the parent's list,
   so include every family and style you need. `file:./` paths look in this theme first
   and then in the parent, so the parent's files can be reused without copying.
3. Update `font-family` in `style.css` if the family names change.

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
