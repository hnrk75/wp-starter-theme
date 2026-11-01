# WP Starter

Starting point for new client sites, built on [Roots/Bedrock](https://roots.io/bedrock/).
Clone it for every new site: it installs the shared parent theme and security plugin with
Composer, and contains a child theme template for the site's own design.

Everything is host-agnostic: no web server specific configuration is required, so a
site runs the same on any host.

---

## How the pieces fit together

| Part | Where it lives | How a site gets it |
|------|----------------|--------------------|
| Parent theme | [`hnrk75/wp-starter-theme-parent`](https://github.com/hnrk75/wp-starter-theme-parent) | Composer, exact version |
| Security plugin | [`hnrk75/wp-security-hardening`](https://github.com/hnrk75/wp-security-hardening) | Composer, exact version |
| Cookie banner | [`hnrk75/hnrk-cookie-consent`](https://github.com/hnrk75/hnrk-cookie-consent) | Composer, exact version |
| Child theme | `web/app/themes/wp-starter-child/` in this repo | Copied and renamed per site |
| Bedrock setup, config, tooling | This repo | Cloned per site |

The parent theme and the security plugin are **never edited in a client site**. All
site-specific work goes in the child theme. Improvements to the shared packages are made
in their own repos, released as a new version, and picked up by each site with
`composer update`.

---

## Project structure

```
project-root/
├── composer.json                    # PHP dependencies & scripts
├── wp-translation-downloader.lock   # Installed translations (like composer.lock)
├── phpcs.xml                        # WordPress Coding Standards (child theme + own mu-plugins)
├── phpstan.neon                     # PHP static analysis
├── scripts/dev-link.php             # composer dev:link / dev:unlink (see below)
├── .env.example                     # Environment template
├── config/                          # Bedrock config (application.php + environments/)
├── web/
│   ├── app/
│   │   ├── languages/               # Translations (Composer, gitignored)
│   │   ├── mu-plugins/
│   │   │   └── wp-security-hardening/   # Composer package (gitignored)
│   │   ├── plugins/                 # Composer packages (gitignored)
│   │   ├── themes/
│   │   │   ├── wp-starter-theme/    # Parent theme — Composer package (gitignored)
│   │   │   └── wp-starter-child/    # Child theme template — the site's own code
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

## New client site

The examples use `svenssonsmetropol` as the site's slug — replace it with your own.

### 1. Get the code

**A brand-new project:** clone this repo into the project folder.

**An existing project folder** (e.g. a Local site that is already set up):

1. Copy `.env` somewhere safe — it has the database settings and salts.
2. Empty the project folder (the folder with `composer.json`, not the Local site folder).
3. Clone this repo into it and put `.env` back.

**Either way**, the clone still points to the template repo. Make it the client's own repo
with a clean history:

```bash
rm -rf .git
git init -b main
git remote add origin git@github.com:<account>/<client-repo>.git
```

### 2. Install

1. `composer install`
2. New project only: `cp .env.example .env` and fill in database, salts
   ([roots.io/salts.html](https://roots.io/salts.html)) and URL, then install WordPress at
   `http://your-local-domain/wp/wp-admin/install.php`.
3. Set `config.platform.php` in `composer.json` to the exact PHP version of the client's
   server (see [PHP version and Composer platform](#php-version-and-composer-platform)).

### 3. Rename the child theme

| What | Change |
|------|--------|
| Folder | `web/app/themes/wp-starter-child` → `web/app/themes/svenssonsmetropol` |
| `style.css` | `Theme Name` and `Text Domain: svenssonsmetropol` |
| `functions.php` | The text domain in `load_child_theme_textdomain()` |
| `languages/` | Rename `wp-starter-child.pot` → `svenssonsmetropol.pot`, set `X-Domain: svenssonsmetropol` in the `.po` header, then regenerate (`vendor/bin/wp i18n make-pot`, `update-po`, `make-mo` — see the child theme's README) |
| `phpcs.xml` | The `<file>` path and the `text_domain` element |
| `phpstan.neon` | The path under `paths` |
| Child theme `README.md` | The title and the "Rename the theme…" paragraph |

### 4. Activate

1. **Appearance → Themes**: activate the child theme.

   **If the child theme gets the same folder name as an old theme the database knows**
   (e.g. the site used to run a copied theme called `svenssonsmetropol`): activate the
   **parent theme** (WP Starter Theme) first, then the child theme. Otherwise WordPress
   keeps the old parent setting and the child theme breaks.
2. **Appearance → Menus → Manage Locations**: assign the menus again (menu locations are
   stored per theme).
3. **Plugins**: activate Advanced Custom Fields PRO and HNRK Cookie Consent. Activate
   Two Factor on TEST and PROD — leave it inactive locally.

### 5. Build the site

All site-specific work goes in the child theme. See the child theme's `README.md`.

---

## Updating a shared package on a site

Each package has its own version and is updated on its own. Admins see a notice on the
Dashboard when a newer version exists (from parent theme 1.3.0).

1. Read the package's `CHANGELOG.md` for the new version. A **major** version can need
   changes in the child theme.
2. Change the version in `composer.json`, e.g. `"hnrk75/wp-starter-theme-parent": "1.3.0"`.
3. Run `composer update hnrk75/wp-starter-theme-parent`.
4. Test locally, then deploy as usual (the server runs `composer install`).

`composer outdated hnrk75/*` lists the packages that have newer versions.

---

## Developing the shared packages

This site (the starter repo itself) is the workshop for the shared packages. Clone the
package repos next to the Local site folder:

```
Local Sites/WordPress/
├── wp-starter-theme/              # this Local site
├── wp-starter-theme-parent/       # git clone of the parent theme
├── wp-security-hardening/         # git clone of the security plugin
└── plugins/
    └── hnrk-cookie-consent/       # git clone of the cookie plugin
```

Then link them into this site:

```bash
composer dev:link     # replace the installed packages with symlinks to the clones
composer dev:unlink   # back to the tagged versions from composer.lock
```

While linked, edits in the clones show up in this site directly. Work, commit and
release in each clone (see their READMEs and CHANGELOGs). `composer install` leaves the
links alone, but `composer update` of a linked package replaces the link — run
`composer dev:link` again afterwards.

Packages without a local clone are skipped, so the commands are harmless in client
projects. Set `WPST_DEV_DIR` to use another folder for the clones.

---

## Translations

[`inpsyde/wp-translation-downloader`](https://github.com/inpsyde/wp-translation-downloader)
downloads sv_SE translations from wordpress.org on every `composer install`/`update`
into `web/app/languages/`. Translations follow the versions in `composer.lock`, so
nothing has to be updated manually on the servers (WordPress cannot download
translations itself, since Bedrock sets `DISALLOW_FILE_MODS` in production).

- Configured under `extra.wp-translation-downloader` in `composer.json`.
- ACF Pro and our own `hnrk75/*` packages are excluded — they ship their own translations.
- Commit `wp-translation-downloader.lock`.

---

## Security

The [Security Hardening](https://github.com/hnrk75/wp-security-hardening) must-use plugin
is always active and needs no configuration — see its README for what it does. Install
[Two Factor](https://wordpress.org/plugins/two-factor/) (`wpackagist-plugin/two-factor`)
and activate it on TEST and PROD: the security plugin then requires two-factor
authentication for all users. Leave it inactive locally.

`robots.txt` is WordPress core's own output (admin blocked, sitemap when public).

---

## Plugins

The template already requires the plugins every site needs: Advanced Custom Fields PRO,
HNRK Cookie Consent and Two Factor. Plugins you add yourself get an exact version:

```bash
composer require vendor/package-name:1.2.3
```

---

## Code quality

```bash
composer lint              # PHPCS
composer lint:fix          # Auto-fix with PHPCBF
composer analyze           # PHPStan static analysis
composer analyze:baseline  # Generate PHPStan baseline
```

PHPCS and PHPStan check this project's own code: the child theme and loose files in
`web/app/mu-plugins/`. The parent theme and the security plugin are checked in their own repos.

---

## Gitignore strategy

Only this project's own source code and configuration are versioned.

Ignored:
- `vendor/`, `uploads/`, `web/wp/`
- Composer packages: `web/app/plugins/`, `web/app/mu-plugins/*/`, the parent theme
  `web/app/themes/wp-starter-theme`, and `web/app/languages/`
- Environment files (`.env`)
- Editor and tool settings (`.vscode/`, `.idea/`, `.claude/`)

Versioned on purpose:
- The child theme, including its translations
- `composer.lock` and `wp-translation-downloader.lock`

---

## License

| Part | License |
|------|---------|
| Project skeleton and config (based on Bedrock) | MIT — see `LICENSE.md` (Roots' original notice must be kept) |
| Child theme template | GNU General Public License v2 or later — see its `style.css` |
| Parent theme / security plugin | See their own repos (GPL-2.0-or-later / MIT) |
