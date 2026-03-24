# WPST ACF Blocks

Custom ACF blocks for wp-starter-theme. Requires **Advanced Custom Fields Pro**.

## Requirements

- WordPress 6.4+
- PHP 8.1+
- ACF Pro
- Node 20.x / npm 10+

## Structure

```
wpst-acf-blocks/
├── acf-json/               # ACF field groups (version controlled)
├── assets/scss/
│   └── shared.scss         # Shared styles (background colors etc.)
├── blocks/
│   ├── hero-block/         # block.php, block.scss, block.css
│   ├── image-text-block/   # block.php, block.scss, block.css
│   └── text-block/         # block.php, block.scss, block.css
├── inc/
│   └── register-blocks.php # Block registration
└── wpst-acf-blocks.php     # Plugin entry
```

## Gulp pipeline

Compiles SCSS → CSS for each block and for `assets/scss/shared.scss`.

```bash
npm install

# Development with watch
npm run dev

# Production build (minified)
npm run build

# Lint SCSS
npm run lint:css
npm run lint:css:fix
```

## Shared fields (ACF Clone)

The field group **WPST Block Appearance** (`group_wpst_block_appearance`) contains shared fields that are cloned into each block via the ACF Clone field with *Seamless* display.

Current shared fields:

| Field | Type | Description |
|-------|------|-------------|
| `wpst_bg_color` | Select | Background color: `none / light / gray / dark / primary / secondary` |

CSS classes on the `<section>` element: `has-bg has-bg--{color}`. Styles in `assets/scss/shared.scss`.

## Adding a new block

1. Copy `blocks/text-block/` → `blocks/my-block/`
2. Update class names and `get_field()` calls in `block.php`
3. Register the block in `inc/register-blocks.php` (copy an existing call and adjust)
4. Create a field group in ACF and clone the desired fields from *WPST Block Appearance*
5. Run `npm run dev` to compile SCSS

### Adding a new shared field

1. Add the field to the **WPST Block Appearance** field group in ACF
2. Clone the specific field into each block that needs it (Seamless = field name stays unprefixed)
3. Add CSS to `assets/scss/shared.scss` if needed

## ACF JSON

ACF field groups are automatically saved and loaded from `acf-json/`. Always commit changes in that folder so the field structure is tracked in version control.
