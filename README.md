# WP Starter Theme

Modern WordPress installation built on [Roots/Bedrock](https://roots.io/bedrock/).
Composer-managed dependencies, Gulp-based theme builds, strict coding standards and
built-in security hardening. Everything is host-agnostic: no web server specific
configuration is required, so the project runs the same on any host.

---

## Project structure

```
project-root/
├── composer.json                    # PHP dependencies & scripts
├── wp-translation-downloader.lock   # Installed translations (like composer.lock)
├── phpcs.xml                        # WordPress Coding Standards (PHPCS)
├── phpstan.neon                     # PHP static analysis
├── .env.example                     # Environment template
├── config/                          # Bedrock config (application.php + environments/)
├── web/
│   ├── app/
│   │   ├── languages/               # Core/plugin/theme translations (Composer, gitignored)
│   │   ├── mu-plugins/              # Must-use plugins
│   │   │   └── security.php         # Security hardening (see below)
│   │   ├── plugins/                 # Plugins (Composer, gitignored)
│   │   ├── themes/
│   │   │   └── wp-starter-theme/
│   │   └── uploads/                 # Media (gitignored)
│   └── wp/                          # WordPress core (Composer)
└── vendor/                          # Composer vendor (gitignored)
```

---

## Requirements

| Tool       | Minimum version |
|------------|-----------------|
| PHP        | 8.4             |
| WordPress  | 7.1             |
| Composer   | 2.0             |
| Node.js    | 24.0            |
| npm        | 11.0            |

### PHP version and Composer platform

`config.platform.php` in `composer.json` must be the **exact** PHP version the server
runs, e.g. `"8.5.12"` (never `"8.5"`, which means 8.5.0). Composer resolves dependencies
against this value instead of the local PHP.

`roave/security-advisories` refuses to install if the platform version has known
security issues. The fix is to raise `platform.php` to the server's current version,
not to remove roave. Read the version in WP admin under
**Tools → Site Health → Info → Server → PHP version** on both TEST and PROD.

`require.php` must not be higher than the PHP version of the local site.

---

## Setup

### 1. Clone & install

```bash
git clone git@github.com:hnrk75/wp-starter-theme.git
cd wp-starter-theme
composer install
```

`composer install` also downloads Swedish (sv_SE) translations for WordPress core,
themes and plugins (see [Translations](#translations)).

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

See the theme `README.md` for theme-specific documentation.

---

## Translations

[`inpsyde/wp-translation-downloader`](https://github.com/inpsyde/wp-translation-downloader)
downloads sv_SE translations from wordpress.org on every `composer install`/`update`
into `web/app/languages/`. Translations follow the versions in `composer.lock`, so
nothing has to be updated manually on the servers (WordPress cannot download
translations itself, since Bedrock sets `DISALLOW_FILE_MODS` in production).

- Configured under `extra.wp-translation-downloader` in `composer.json`.
- ACF Pro is excluded, since it is not on wordpress.org and ships its own translations.
- Commit `wp-translation-downloader.lock`.

The theme's own translations live in the theme's `languages/` folder and are versioned.

---

## Security

`web/app/mu-plugins/security.php` is always active and needs no configuration:

- **Registration** is always disabled and the default role is always subscriber,
  regardless of the database settings.
- **XML-RPC** and **application passwords** are disabled.
- **Usernames are hidden** from logged-out visitors: REST `/wp/v2/users`, `?author=`,
  author archives, the users sitemap and oEmbed author data.
- **Login** gives the same error for wrong username and wrong password, and the
  lost password form gives the same confirmation whether the account exists or not.
- **Login throttling:** 5 failed logins for the same account from the same IP within
  15 minutes lock that combination for 15 minutes. Counting per IP and account works
  behind proxies too, where all visitors share one IP.
- **Two-factor authentication is required** when the [Two Factor](https://wordpress.org/plugins/two-factor/)
  plugin is active: users without it are sent to their profile until it is set up.
  Leave the plugin inactive locally.
- **Security headers:** `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`,
  `Permissions-Policy`, and HSTS in production over HTTPS. The WordPress version is hidden.
- **Email notifications** to the admin when a user is created or becomes administrator/editor.

`robots.txt` is WordPress core's own output (admin blocked, sitemap when public).

---

## Recommended plugins

The theme's **Recommended Plugins** dashboard widget shows the status of each plugin:

| Status | Meaning |
|--------|---------|
| Active | Installed and activated |
| Not activated | Installed but inactive, with an **Activate** button |
| Pending | In `composer.json`, run `composer install` |
| Not installed | **Add to composer.json** button |

Plugins you add yourself get an exact version:

```bash
composer require vendor/package-name:1.2.3
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

PHPCS and PHPStan cover the theme and our own files in `web/app/mu-plugins/`.
Subfolders in `mu-plugins/` are installed by Composer and are skipped.

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
- `web/app/plugins/` and `web/app/languages/` (installed by Composer)
- Built assets (`assets/css/*.min.css`, `*.min.js`, `.zip`)
- Cache files (`.phpcs.cache`, `.eslintcache`, etc.)
- Environment files (`.env`)
- Editor and tool settings (`.vscode/`, `.idea/`, `.claude/`)

Versioned on purpose:
- The theme's translations (`web/app/themes/*/languages/`)
- `wp-translation-downloader.lock`

---

## License

The project uses two licenses, which is the common setup for Bedrock projects:

| Part | License |
|------|---------|
| Project skeleton and config (based on Bedrock) | MIT — see `LICENSE.md` (Roots' original notice must be kept) |
| Our must-use plugins in `web/app/mu-plugins/` | MIT — see each file's header |
| The theme `web/app/themes/wp-starter-theme/` | GNU General Public License v2 or later — see the theme's `style.css` |

MIT is GPL-compatible, so the parts can be combined and distributed together.
The theme is GPL like WordPress itself, which is the convention for themes.
