# WP Starter Theme

Modern WordPress installation built on [Roots/Bedrock](https://roots.io/bedrock/).
Composer-managed dependencies, Gulp-based theme builds, and strict coding standards.

---

## Project structure

```
project-root/
├── composer.json              # PHP dependencies & scripts
├── phpcs.xml                  # WordPress Coding Standards (PHPCS)
├── phpstan.neon               # PHP static analysis
├── .env.example               # Environment template
├── web/
│   ├── app/
│   │   ├── mu-plugins/        # Must-use plugins (autoloaded)
│   │   ├── plugins/           # Plugins (Composer or manual)
│   │   ├── themes/
│   │   │   └── wp-starter-theme/
│   │   └── uploads/           # Media (gitignored)
│   └── wp/                    # WordPress core (Composer)
└── vendor/                    # Composer vendor (gitignored)
```

---

## Requirements

| Tool       | Minimum version |
|------------|-----------------|
| PHP        | 8.1             |
| WordPress  | 6.9             |
| Composer   | 2.0             |
| Node.js    | 20.0            |
| npm        | 10.0            |

---

## Setup

### 1. Clone & install

```bash
git clone git@github.com:hnrk75/wp-starter-theme.git
cd wp-starter-theme
composer install
```

### 2. Configure environment

```bash
cp .env.example .env
```

Edit `.env` with your database credentials, salts and local URL.
Generate salts at [roots.io/salts.html](https://roots.io/salts.html).

### 3. Install WordPress

Open in browser:

```
http://your-local-domain/wp/wp-admin/install.php
```

### 4. Install theme dependencies

```bash
cd web/app/themes/wp-starter-theme
npm install
```

---

## Theme development

Run inside `web/app/themes/wp-starter-theme/`:

```bash
npm run dev      # Watch files, compile & BrowserSync
npm run build    # Production build
npm run lint     # Lint JS, CSS and PHP
npm run fix      # Auto-fix JS, CSS and PHP
```

---

## Recommended plugins

The theme dashboard widget lists recommended plugins and their install commands.
Add plugins to `composer.json` with:

```bash
composer require vendor/package-name
```

---

## Code quality

### PHP (from project root)

```bash
composer lint              # Run PHPCS
composer lint:fix          # Auto-fix with PHPCBF
composer analyze           # PHPStan static analysis
composer analyze:baseline  # Generate PHPStan baseline
```

### JS / SCSS (from theme folder)

```bash
npm run lint:js        # ESLint
npm run lint:css       # Stylelint
npm run format         # Prettier
```

---

## Gitignore strategy

Only source code and configuration are versioned.

Ignored:
- `vendor/`, `node_modules/`, `uploads/`
- Built assets (`assets/css/*.min.css`, `*.min.js`, `.zip`)
- Cache files (`.phpcs.cache`, `.eslintcache`, etc.)
- Environment files (`.env`)

---

## License

GPL-2.0 — see theme `style.css` for details.
