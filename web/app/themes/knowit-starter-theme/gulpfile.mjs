/* eslint-disable no-console */

// Stäng av OS-popups från gulp-notify (behåll BrowserSync-notiser)
process.env.DISABLE_NOTIFIER = 'true';

import gulp from 'gulp';
import plumber from 'gulp-plumber';
import autoprefixer from 'gulp-autoprefixer';
import eslint from 'gulp-eslint-new';
import terser from 'gulp-terser';
import rename from 'gulp-rename';
import notify from 'gulp-notify';
import include from 'gulp-include';
import gulpSass from 'gulp-sass';
import * as dartSass from 'sass';
import browserSyncLib from 'browser-sync';
import { stream as critical } from 'critical';
import zip from 'gulp-zip';
import rev from 'gulp-rev';
import revDel from 'gulp-rev-delete-original';
import sourcemaps from 'gulp-sourcemaps';

import path from 'path';
import { exec as _exec, spawn } from 'child_process';
import { fileURLToPath } from 'url';
import { promisify } from 'util';

const exec = promisify(_exec);

const sass = gulpSass(dartSass);
const browserSync = browserSyncLib.create();

const isProduction = process.env.NODE_ENV === 'production';

const config = {
  nodeDir: './node_modules',
  jsFiles: ['./assets/js/**/*.js', '!./assets/js/dist/*.js'],
  cssFiles: ['./assets/sass/**/*.scss', './inc/**/*.scss'],
  browserSyncWatchFiles: ['./*.min.css', './assets/js/**/*.min.js', './**/*.php'],
  proxyUrl: process.env.LOCAL_URL || 'http://knowit-starter-theme.local/',
};

// ==== Helpers ==================================================
function onError(err) {
  console.error('An error occurred:', err.message);
  this.emit('end');
}

function bsNotify(title, message, timeout = 5000) {
  if (isProduction) {return;} // undvik BS-notiser i prod
  try {
    browserSync.notify(`<strong>${title}</strong><br>${message}`, timeout);
  } catch {
    /* noop */
  }
}

let phpTimer;
const debounce = (fn, delay = 150) => (...args) => {
  clearTimeout(phpTimer);
  phpTimer = setTimeout(() => fn(...args), delay);
};

// Debounce per SCSS-fil så vi inte kör dubbelt vid snabba förändringar
const scssBounce = new Map();
function debounceScss(filePath, fn, delay = 150) {
  const prev = scssBounce.get(filePath);
  if (prev) {clearTimeout(prev);}
  const t = setTimeout(() => {
    scssBounce.delete(filePath);
    fn();
  }, delay);
  scssBounce.set(filePath, t);
}

// ==== JavaScript ===============================================
export function lintJS() {
  return gulp
    .src(['./assets/js/src/**/*.js', './assets/js/manifest.js'], { allowEmpty: true })
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

export function scripts() {
  let pipeline = gulp
    .src('./assets/js/manifest.js', { allowEmpty: true })
    .pipe(
      include().on('error', function (err) {
        notify.onError({ title: 'Include error', message: '<%= error.message %>' })(err);
        this.emit('end');
      })
    );

  if (!isProduction) {
    pipeline = pipeline.pipe(sourcemaps.init());
  }

  pipeline = pipeline.pipe(rename({ basename: 'scripts' }));

  if (isProduction) {
    pipeline = pipeline.pipe(terser());
  }

  pipeline = pipeline
    .pipe(gulp.dest('./assets/js/dist'))
    .pipe(rename({ suffix: '.min' }));

  if (!isProduction) {
    pipeline = pipeline.pipe(sourcemaps.write('.'));
  }

  if (isProduction) {
    pipeline = pipeline
      .pipe(rev())
      .pipe(revDel())
      .pipe(gulp.dest('./assets/js/dist'))
      .pipe(rev.manifest('rev-manifest.json', { merge: true }))
      .pipe(gulp.dest('./assets/js/dist'));
  } else {
    pipeline = pipeline.pipe(gulp.dest('./assets/js/dist'));
  }

  return pipeline.pipe(browserSync.stream()).on('end', () => bsNotify('Scripts', 'Klar'));
}

// ==== Sass/CSS ================================================
// Stylelint – kör hela trädet (manuellt vid behov)
export function lintSCSSAll() {
  return new Promise((resolve, reject) => {
    const args = [
      'stylelint',
      'assets/sass/**/*.scss',
      'inc/**/*.scss',
      '--custom-syntax',
      'postcss-scss',
    ];
    // Viktigt: shell:false så att paths med mellanslag funkar
    const child = spawn('npx', args, { stdio: 'inherit', shell: false });
    child.on('close', (code) => {
      if (code === 0) {
        bsNotify('Stylelint', 'Allt ser bra ut! ✅', 2500);
        resolve();
      } else {
        bsNotify('Stylelint', 'Lint-fel hittades – se terminalen.');
        reject(new Error(`stylelint exited ${code}`));
      }
    });
  });
}

// Stylelint – endast ändrad fil (snabb feedback vid save)
function lintScssFile(filePath) {
  return new Promise((resolve) => {
    const args = ['stylelint', filePath, '--custom-syntax', 'postcss-scss'];
    // Viktigt: shell:false så att paths med mellanslag funkar
    const child = spawn('npx', args, { stdio: 'inherit', shell: false });
    child.on('close', (code) => {
      if (code === 0) {
        bsNotify('Stylelint', `OK: ${path.basename(filePath)} ✅`, 2000);
      } else {
        bsNotify('Stylelint', `Fel i ${path.basename(filePath)} – se terminalen.`);
      }
      // fortsätt watch-flödet oavsett
      resolve();
    });
  });
}

export function compileSass() {
  let pipeline = gulp
    .src('./assets/sass/style.scss', { allowEmpty: true })
    .pipe(plumber({ errorHandler: onError }));

  if (!isProduction) {
    pipeline = pipeline.pipe(sourcemaps.init());
  }

  pipeline = pipeline
    .pipe(
      sass({
        includePaths: [`${config.nodeDir}/bootstrap/scss`],
        quietDeps: true,
        silenceDeprecations: ['legacy-js-api', 'import', 'global-builtin', 'color-functions'],
      })
    )
    .pipe(autoprefixer())
    .pipe(gulp.dest('./'))
    .pipe(rename({ suffix: '.min' }));

  if (!isProduction) {
    pipeline = pipeline.pipe(sourcemaps.write('.'));
  }

  // Ingen rev på CSS i WP-tema – behåll stabilt filnamn
  pipeline = pipeline.pipe(gulp.dest('./'));

  return pipeline
  .pipe(browserSync.stream())
  .on('end', () => bsNotify('Sass', 'Klar'));
}

// ==== Critical CSS (oförändrat) ================================
export function generateCritical() {
  return gulp
    .src('index.html', { allowEmpty: true })
    .pipe(
      critical({
        base: './',
        inline: true,
        dimensions: [
          { width: 320, height: 480 },
          { width: 768, height: 1024 },
          { width: 1280, height: 960 },
        ],
        minify: true,
      })
    )
    .pipe(gulp.dest('css'))
    .pipe(notify({ message: 'Critical CSS task complete' }));
}

// ==== Zip ======================================================
export function zipFiles() {
  return gulp
    .src(
      [
        '**/*',
        '!node_modules/**',
        '!*.zip',
        '!gulpfile.*',
        '!package-lock.json',
        '!yarn.lock',
        '!.eslintrc.json',
        '!.prettierrc.json',
        '!.stylelintrc.json',
      ],
      { base: '.' }
    )
    .pipe(zip('knowit-starter-theme.zip'))
    .pipe(gulp.dest('.'));
}

// ==== PHP Lint & Fix ==========================================
const __filename = fileURLToPath(import.meta.url);
const THEME_DIR = path.dirname(__filename);
const ROOT_DIR = path.resolve(THEME_DIR, '../../../..');

const PHPCS =
  process.platform === 'win32'
    ? path.join(ROOT_DIR, 'vendor/bin/phpcs.bat')
    : path.join(ROOT_DIR, 'vendor/bin/phpcs');
const PHPCBF =
  process.platform === 'win32'
    ? path.join(ROOT_DIR, 'vendor/bin/phpcbf.bat')
    : path.join(ROOT_DIR, 'vendor/bin/phpcbf');

export async function lintPHPAll() {
  try {
    const { stdout, stderr } = await exec(`"${PHPCS}" -p -s web/app/themes/knowit-starter-theme`, {
      cwd: ROOT_DIR,
    });
    process.stdout.write(stdout || '');
    process.stderr.write(stderr || '');
    bsNotify('PHPCS', 'Allt ser bra ut! ✅');
  } catch (e) {
    process.stdout.write(e.stdout || '');
    process.stderr.write(e.stderr || e.message || '');
    bsNotify('PHPCS', 'Lint-fel hittades – se terminalen.');
  }
}

async function lintPHPFile(filePath) {
  const rel = path.relative(ROOT_DIR, filePath);
  try {
    const { stdout, stderr } = await exec(`"${PHPCS}" -p -s "${rel}"`, { cwd: ROOT_DIR });
    console.log(`\n▶ PHPCS OK: ${rel}\n${stdout}${stderr}`);
    bsNotify('PHPCS', `OK: ${rel} ✅`, 2500);
  } catch (e) {
    console.log(`\n▶ PHPCS ERR: ${rel}\n${e.stdout || ''}${e.stderr || e.message || ''}`);
    bsNotify('PHPCS', `Fel i ${rel} – se terminalen.`);
  }
}

async function fixPHPFile(filePath) {
  const rel = path.relative(ROOT_DIR, filePath);
  try {
    await exec(`"${PHPCBF}" "${rel}"`, { cwd: ROOT_DIR });
  } catch {
    /* auto-fix kan misslyckas – det är OK */
  }
  await lintPHPFile(filePath);
}

export async function fixPHPAll() {
  try {
    await exec(`"${PHPCBF}" web/app/themes/knowit-starter-theme`, { cwd: ROOT_DIR });
  } catch {
    /* ignore */
  }
  await lintPHPAll();
}

// ==== Watchers ================================================
export function watchFiles() {
  // JS: ESLint + build på varje ändring (befintligt beteende)
  gulp.watch(config.jsFiles, gulp.series(lintJS, scripts));

  // SCSS: stylelint på ändrad fil, därefter kompilering – debounced
  const scssWatcher = gulp.watch(config.cssFiles);
  scssWatcher.on('change', (fp) =>
    debounceScss(fp, async () => {
      await lintScssFile(path.resolve(fp));
      compileSass();
    })
  );
  scssWatcher.on('add', (fp) =>
    debounceScss(fp, async () => {
      await lintScssFile(path.resolve(fp));
      compileSass();
    })
  );

  // PHP: auto-fix + lint (debounce för att undvika spam)
  const phpGlob = [
    './**/*.php',
    '!./node_modules/**',
    '!./vendor/**',
    '!./**/dist/**',
    '!./**/build/**',
  ];
  const w = gulp.watch(phpGlob);
  w.on('change', (fp) => debounce(() => fixPHPFile(path.resolve(fp)))());
  w.on('add', (fp) => debounce(() => fixPHPFile(path.resolve(fp)))());
}

// ==== BrowserSync =============================================
export function startBrowserSync() {
  browserSync.init({
    proxy: config.proxyUrl,
    files: config.browserSyncWatchFiles,
  });
}

// ==== Build & Default =========================================
export const build = gulp.series(compileSass, scripts, zipFiles);
export default gulp.parallel(watchFiles, startBrowserSync);
