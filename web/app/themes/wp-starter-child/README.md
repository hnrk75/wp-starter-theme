# WP Starter Child

Child theme for [WP Starter Theme](../wp-starter-theme/). All site-specific work goes
here, so the parent theme can be updated without overwriting it.

Rename the theme for each site: change `Theme Name` and `Text Domain` in `style.css`,
the text domain in `functions.php`, and the folder name.

---

## Files

```
wp-starter-child/
├── style.css        # Theme header + site-specific CSS
├── functions.php    # Hooks, filters and pluggable function overrides
├── theme.json       # Only what differs from the parent (merged automatically)
└── README.md
```

---

## How to customize

| What | How |
|------|-----|
| CSS | Write it in `style.css`. It loads after the parent's CSS, on the front end and in the editor. |
| CSS variables | Override the parent's custom properties in `:root`, e.g. `--color-primary`, `--measure`. |
| Colors, font sizes, spacing in the editor | Add them to `theme.json`. It is merged with the parent's `theme.json`. |
| A template | Copy the file from the parent's `template-parts/` (or a root template like `page.php`) to the same path here and edit the copy. |
| A `wpst_*` function | Define a function with the same name in `functions.php`. Works for functions the parent wraps in `function_exists()`, e.g. `wpst_posted_on()`, `wpst_button()`. |
| Behaviour | Use hooks and filters, e.g. `remove_action()`, `add_filter()`. |
| Logo and icons | Put your own `assets/svg/logo.svg` or icons here; they replace the parent's. |

Do not copy files from the parent's `inc/` folder — they are always loaded from the
parent, and a copy would stop receiving updates.

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
