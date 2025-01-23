const gulp = require("gulp");
const plumber = require("gulp-plumber");
const autoprefixer = require("gulp-autoprefixer");
const jshint = require("gulp-jshint");
const stylish = require("jshint-stylish");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const notify = require("gulp-notify");
const include = require("gulp-include");
const sass = require("gulp-sass")(require("sass"));
const browserSync = require("browser-sync").create();
const critical = require("critical").stream;
const zip = require("gulp-zip");

const config = {
    nodeDir: "./node_modules",
    jsFiles: ["./js/**/*.js", "!./js/dist/*.js"],
    cssFiles: ["./sass/**/*.scss"],
    browserSyncWatchFiles: ["./*.min.css", "./js/**/*.min.js", "./**/*.php"],
    proxyUrl: process.env.LOCAL_URL || "http://starterwp-bs5.local/"
};

// Default error handler
function onError(err) {
    console.error("An error occurred:", err.message);
    this.emit("end");
}

// JavaScript linting
function lintJS() {
    return gulp.src("./js/src/*.js")
        .pipe(jshint())
        .pipe(jshint.reporter(stylish))
        .pipe(jshint.reporter("fail"));
}

// JavaScript tasks
function scripts() {
    return gulp.src("./js/manifest.js")
        .pipe(include())
        .pipe(rename({ basename: "scripts" }))
        .pipe(gulp.dest("./js/dist"))
        .pipe(uglify())
        .pipe(rename({ suffix: ".min" }))
        .pipe(gulp.dest("./js/dist"))
        .pipe(browserSync.stream())
        .pipe(notify({ message: "Scripts task complete" }));
}

// Compile Sass
function compileSass() {
    return gulp.src("./sass/style.scss")
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass({ includePaths: [`${config.nodeDir}/bootstrap/scss`] }))
        .pipe(autoprefixer()) // Autoprefixer will respect the browserslist config
        .pipe(gulp.dest("."))
        .pipe(rename({ suffix: ".min" }))
        .pipe(gulp.dest("."))
        .pipe(browserSync.stream())
        .pipe(notify({ title: "Sass", message: "Sass task complete" }));
}

// Generate Critical CSS
function generateCritical() {
    return gulp.src("index.html")
        .pipe(critical({
            base: "./",
            inline: true,
            dimensions: [
                { width: 320, height: 480 },
                { width: 768, height: 1024 },
                { width: 1280, height: 960 }
            ],
            minify: true
        }))
        .pipe(gulp.dest("css"))
        .pipe(notify({ message: "Critical CSS task complete" }));
}

// Zip task
function zipFiles() {
    return gulp.src([
        "**/*",
        "!node_modules/**",
        "!starterwp-bs5.zip",
        "!gulpfile.js",
        "!package-lock.json",
        "!yarn.lock"
    ], { base: "." })
        .pipe(zip("starterwp-bs5.zip"))
        .pipe(gulp.dest("."));
}

// Watch tasks
function watchFiles() {
    gulp.watch(config.jsFiles, gulp.series(lintJS, scripts));
    gulp.watch(config.cssFiles, compileSass);
}

// Browser Sync
function startBrowserSync() {
    browserSync.init({
        proxy: config.proxyUrl,
        files: config.browserSyncWatchFiles
    });
}

// Production Build
gulp.task("build", gulp.series(compileSass, scripts, zipFiles));

// Default task
exports.default = gulp.parallel(watchFiles, startBrowserSync);

// Other tasks
exports.zip = zipFiles;
exports.lintJS = lintJS;
exports.scripts = scripts;
exports.sass = compileSass;
exports.critical = generateCritical;
exports.build = gulp.series(compileSass, scripts, zipFiles);
