import gulp from "gulp";
import plumber from "gulp-plumber";
import autoprefixer from "gulp-autoprefixer";
import watch from "gulp-watch";
import jshint from "gulp-jshint";
import stylish from "jshint-stylish";
import uglify from "gulp-uglify";
import rename from "gulp-rename";
import notify from "gulp-notify";
import include from "gulp-include";
import sass from "gulp-sass";
import browserSync from "browser-sync";
import critical from "critical";
import zip from "gulp-zip";

const config = {
  nodeDir: "./node_modules"
};

const onError = function (err) {
  console.log("An error occured:", err.message);
  this.emit("end");
};

const jsFiles = ["./js/**/*.js", "!./js/dist/*.js"];
const cssFiles = ["./sass/**/*.scss"];

const browserSyncWatchFiles = ["./*.min.css", "./js/**/*.min.js", "./**/*.php"];

const browserSyncOptions = {
  watchTask: true,
  proxy: "http://starterwp.local/"
};

gulp.task("zip", function () {
  return gulp
    .src(
      [
        "**/*",
        "!node_modules/**",
        "!starterwp.zip",
        "!gulpfile.js",
        "!package-lock.json",
        "!yarn.lock"
      ],
      { base: "." }
    )
    .pipe(zip("starterwp-bs5.zip"))
    .pipe(gulp.dest("."));
});

gulp.task("jshint", function () {
  return gulp
    .src("./js/src/*.js")
    .pipe(jshint())
    .pipe(jshint.reporter(stylish))
    .pipe(jshint.reporter("fail"));
});

gulp.task("scripts", function () {
  return (
    gulp
      .src("./js/manifest.js")
      .pipe(include())
      .pipe(rename({ basename: "scripts" }))
      .pipe(gulp.dest("./js/dist"))
      .pipe(uglify())
      .pipe(rename({ suffix: ".min" }))
      .pipe(gulp.dest("./js/dist"))
      .pipe(browserSync.reload({ stream: true }))
      .pipe(notify({ message: "scripts task complete" }))
  );
});

gulp.task("sass", function () {
  return gulp
    .src("./sass/style.scss")
    .pipe(plumber())
    .pipe(
      sass({
        errLogToConsole: true,
        precision: 8,
        noCache: true,
        includePaths: [config.nodeDir + "/bootstrap/scss"]
      }).on("error", sass.logError)
    )
    .pipe(autoprefixer())
    .pipe(gulp.dest("."))
    .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest("."))
    .pipe(browserSync.reload({ stream: true }))
    .pipe(notify({ title: "Sass", message: "sass task complete" }));
});

gulp.task("critical", function (cb) {
  critical.generate({
    base: "./",
    src: "http://starterwp.local/",
    dest: "css/home.min.css",
    ignore: ["@font-face"],
    dimensions: [
      {
        width: 320,
        height: 480
      },
      {
        width: 768,
        height: 1024
      },
      {
        width: 1280,
        height: 960
      }
    ],
    minify: true
  });
});

gulp.task("browser-sync", function () {
  browserSync.init(browserSyncWatchFiles, browserSyncOptions);
});

gulp.task("watch", function () {
  gulp.watch(jsFiles, gulp.series("jshint", gulp.parallel("scripts")));
  gulp.watch(cssFiles, gulp.parallel("sass"));
});

gulp.task("default", gulp.parallel("watch", "browser-sync"));
