# Knowit Starter Theme

A modern WordPress theme built with **Bootstrap 5**, **Gulp**, and **Composer (Bedrock)**.  
It follows WordPress Coding Standards (WPCS) and includes built-in linting and formatting for PHP, JS, and SCSS.

---

## 📦 Theme Information

**Theme Name:** Knowit Starter Theme  
**Version:** 2.0.1  
**Author:** [Henrik Pettersson](https://knowit.se/)  
**License:** GPL-2.0  
**License URI:** [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)

---

## 🖥️ Description
A responsive WordPress starter theme including **Bootstrap 5.3.3**, optimized for accessibility (WCAG), developer workflows, and clean front-end architecture.

---

## ⚙️ Installation (editor use)
1. In the WordPress admin, go to **Appearance › Themes › Add New**.
2. Click **Upload**, select the theme’s `.zip` file (e.g. `knowit-starter-theme.zip`).
3. Click **Install Now**, then **Activate**.

---

## 🧩 Theme Setup
After activation, install and activate the recommended plugins for extra functionality (e.g. ACF, Yoast SEO, etc. as defined by the project).

---

## 🧱 Requirements
| Dependency | Minimum |
|-------------|----------|
| WordPress | 6.0 |
| PHP | 8.0 |
| Node.js | 18.0 |
| npm | 9.0 |
| Composer | 2.0 |
| Bootstrap | 5.3.3 |

---

## ✨ Features
- 🧭 Responsive design with Bootstrap 5  
- 🎨 SCSS-based theming with sourcemaps (dev mode)  
- 🧰 Gulp 5 build system (CSS + JS + BrowserSync)  
- 🧹 Code linting via ESLint, Stylelint, Prettier, PHPCS & PHPStan  
- 🧼 Auto-fix of PHP via PHPCBF when saving in watch mode  
- 🗂️ Bedrock folder structure (`web/app/themes/…`)  

---

## 🧠 Developer Guide

### 1️⃣ Clone & install
```bash
# From project root (Bedrock)
composer install

# From theme folder
cd web/app/themes/knowit-starter-theme
npm install
