# 🧩 Knowit Bedrock WordPress Project

Modern WordPress installation built on [Roots/Bedrock](https://roots.io/bedrock/).  
Composer-managed dependencies, Gulp-based theme builds, and strict coding standards.

---

## 📁 Project structure

project-root/
├── composer.json # PHP dependencies & scripts
├── phpcs.xml # WordPress Coding Standards (PHPCS)
├── phpstan.neon # PHP static analysis
├── .env.example # Environment template
├── web/
│ ├── app/
│ │ ├── mu-plugins/ # Must-use plugins (autoloaded)
│ │ ├── plugins/ # Managed via Composer
│ │ ├── themes/
│ │ │ ├── knowit-starter-theme/
│ │ │ └── (other themes)
│ │ └── uploads/ # Media (gitignored)
│ └── wp/ # WordPress core (Composer)
└── vendor/ # Composer vendor (gitignored)

yaml
Kopiera kod

---

## ⚙️ Requirements

| Tool | Minimum version |
|------|------------------|
| PHP | 8.2 |
| WordPress | 6.3 |
| Composer | 2.0 |
| Node.js | 18.0 |
| npm | 9.0 |

---

## 🚀 Setup

### 1️⃣ Clone & install
```bash
git clone <repo-url>
cd <project-folder>
composer install
2️⃣ Configure environment
Copy and edit the example environment file:

bash
Kopiera kod
cp .env.example .env
Then set database credentials, salts and URLs as needed.

3️⃣ Install WordPress
Run the installer in your browser:

pgsql
Kopiera kod
http://your-local-domain/wp/wp-admin/install.php
🧱 Theme development
Each theme has its own build tools.
Example for Knowit Starter Theme:

bash
Kopiera kod
cd web/app/themes/knowit-starter-theme
npm install
npm run dev      # Watch & BrowserSync
npm run build    # Production build
npm run lint     # Lint JS, CSS, PHP
See web/app/themes/knowit-starter-theme/README.md for full theme documentation.

🧹 Code Quality & Standards
This project follows WordPress Coding Standards (WPCS), PHPStan, ESLint, Stylelint, and Prettier.

PHP
bash
Kopiera kod
composer lint          # Run PHPCS
composer lint:fix      # Auto-fix with PHPCBF
composer stan          # PHPStan static analysis
composer stan:baseline # Create PHPStan baseline
JS / SCSS / Formatting
Run inside the theme folder:

bash
Kopiera kod
npm run lint:js
npm run lint:css
npm run format
All code must pass these checks before merge or deploy.

🧰 Deployment
Build production assets:

bash
Kopiera kod
cd web/app/themes/knowit-starter-theme
npm run build
Commit changes (excluding build artifacts — handled by .gitignore).

Deploy via your CI/CD pipeline or manually to the hosting environment (e.g. One.com).

Composer dependencies and environment variables ensure reproducible deployments.

🧠 Gitignore strategy
This project uses a clean-repo policy:

✅ Version control only source code & configuration

🚫 Ignore all generated, cache and upload files

Ignored includes:

vendor/, node_modules/, uploads/

Built assets (style.min.css, scripts.min.js, .map, .zip)

Cache files (.phpcs.cache, .phpstan.cache, .eslintcache, .stylelintcache)

See .gitignore for full rules.

🧩 Composer scripts summary
Command	Description
composer install	Install PHP dependencies
composer update	Update packages
composer lint	Run PHPCS
composer lint:fix	Fix PHP code style
composer stan	Run PHPStan analysis
composer stan:baseline	Generate PHPStan baseline

🧾 License
GPL-2.0 — see individual themes for their headers.

👏 Credits
Developed by Henrik Pettersson / Knowit Experience
Built with Roots Bedrock and Bootstrap 5
