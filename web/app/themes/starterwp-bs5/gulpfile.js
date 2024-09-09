const gulp = require("gulp");
const plumber = require("gulp-plumber");
const autoprefixer = require("gulp-autoprefixer");
const watch = require("gulp-watch");
const jshint = require("gulp-jshint");
const stylish = require("jshint-stylish");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const notify = require("gulp-notify");
const include = require("gulp-include");
const sass = require("gulp-sass")(require("sass"));
const browserSync = require("browser-sync").create();
const critical = require("critical");
const zip = require("gulp-zip");

const config = {
    nodeDir: "./node_modules"
};

// Default error handler
function onError(err) {
    console.log("An error occurred:", err.message);
    this.emit("end");
}

// JS and CSS files to watch
const jsFiles = ["./js/**/*.js", "!./js/dist/*.js"];
const cssFiles = ["./sass/**/*.scss"];
const browserSyncWatchFiles = ["./*.min.css", "./js/**/*.min.js", "./**/*.php"];

const browserSyncOptions = {
    watchTask: true,
    proxy: "http://starterwp-bs5.local/"
};

// Zip files up
gulp.task("zip", () => {
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
});

// Jshint for JavaScript files
gulp.task("jshint", () => {
    return gulp.src("./js/src/*.js")
    .pipe(jshint())
    .pipe(jshint.reporter(stylish))
    .pipe(jshint.reporter("fail"));
});

// Concatenate and minify JavaScript
gulp.task("scripts", () => {
    return gulp.src("./js/manifest.js")
    .pipe(include())
    .pipe(rename({ basename: "scripts" }))
    .pipe(gulp.dest("./js/dist"))
    .pipe(uglify())
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest("./js/dist"))
    .pipe(browserSync.reload({ stream: true }))
    .pipe(notify({ message: "Scripts task complete" }));
});

// Compile Sass to CSS
gulp.task("sass", () => {
    return gulp.src("./sass/style.scss")
    .pipe(plumber())
    .pipe(sass({
        errLogToConsole: true,
        precision: 8,
        noCache: true,
        includePaths: [config.nodeDir + "/bootstrap/scss"]
    }).on("error", sass.logError))
    .pipe(autoprefixer())
    .pipe(gulp.dest("."))
    .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest("."))
    .pipe(browserSync.reload({ stream: true }))
    .pipe(notify({ title: "Sass", message: "Sass task complete" }));
});

// Generate and inline critical-path CSS
gulp.task("critical", (cb) => {
    critical.generate({
        base: "./",
        src: "http://starterwp-bs5.local/",
        dest: "css/home.min.css",
        ignore: ["@font-face"],
        dimensions: [
            { width: 320, height: 480 },
            { width: 768, height: 1024 },
            { width: 1280, height: 960 }
        ],
        minify: true
    });
});

// Start Browser Sync server
gulp.task("browser-sync", () => {
    browserSync.init(browserSyncWatchFiles, browserSyncOptions);
});

// Watch files for changes
gulp.task("watch", () => {
    gulp.watch(jsFiles, gulp.series("jshint", "scripts"));
    gulp.watch(cssFiles, gulp.parallel("sass"));
});

// Default task
gulp.task("default", gulp.parallel("watch", "browser-sync"));
