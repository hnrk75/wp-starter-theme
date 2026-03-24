# WPST ACF Blocks

Custom ACF blocks för wp-starter-theme. Kräver **Advanced Custom Fields Pro**.

## Krav

- WordPress 6.4+
- PHP 8.1+
- ACF Pro
- Node 20.x / npm 10+

## Struktur

```
wpst-acf-blocks/
├── acf-json/               # ACF fältgrupper (versionshanteras)
├── assets/scss/
│   └── shared.scss         # Delade stilar (bakgrundsfärger m.m.)
├── blocks/
│   ├── hero-block/         # block.php, block.scss, block.css
│   ├── text-block/         # block.php, block.scss, block.css
│   └── image-text-block/   # block.php, block.scss, block.css
├── inc/
│   └── register-blocks.php # Registrering av alla block
└── wpst-acf-blocks.php     # Plugin-entry
```

## Gulp-pipeline

Kompilerar SCSS → CSS för varje block samt för `assets/scss/shared.scss`.

```bash
npm install

# Utveckling med watch
npm run dev

# Produktionsbygge (minifierat)
npm run build

# Linta SCSS
npm run lint:css
npm run lint:css:fix
```

## Delade fält (ACF Clone)

Fältgruppen **WPST Blockutseende** (`group_wpst_block_appearance`) innehåller gemensamma fält som klonas in i varje block via ACF Clone-fältet med *Seamless*-visning.

Aktuella delade fält:

| Fält | Typ | Beskrivning |
|------|-----|-------------|
| `wpst_bg_color` | Select | Bakgrundsfärg: `none / light / gray / dark / primary / secondary` |

CSS-klasser på `<section>`-elementet: `has-bg has-bg--{color}`. Stilar i `assets/scss/shared.scss`.

## Lägga till ett nytt block

1. Kopiera `blocks/text-block/` → `blocks/mitt-block/`
2. Uppdatera klassnamn och `get_field()`-anrop i `block.php`
3. Registrera blocket i `inc/register-blocks.php` (kopiera ett befintligt anrop och justera)
4. Skapa fältgrupp i ACF och klona in önskade fält från *WPST Blockutseende*
5. Kör `npm run dev` för att kompilera SCSS

### Lägga till ett nytt delat fält

1. Lägg till fältet i fältgruppen **WPST Blockutseende** i ACF
2. Klona det specifika fältet i varje block som behöver det (Seamless = fältnamnet förblir oprefixat)
3. Lägg till CSS i `assets/scss/shared.scss` vid behov

## ACF JSON

ACF-fältgrupper sparas och laddas automatiskt från `acf-json/`. Commita alltid ändringar i den mappen så att fältstrukturen följer med i versionshanteringen.
