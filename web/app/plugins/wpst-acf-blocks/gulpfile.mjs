import gulp from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import autoprefixer from 'gulp-autoprefixer';
import rename from 'gulp-rename';

const sass = gulpSass( dartSass );
const isProd = process.env.NODE_ENV === 'production';

const paths = {
  blockScss:  'blocks/**/block.scss',
  sharedScss: 'assets/scss/shared.scss',
  sharedCss:  'assets/css',
};

const sassOptions = { outputStyle: isProd ? 'compressed' : 'expanded' };

// Compile each block's block.scss → block.css (same folder)
function compileBlockSass() {
  return gulp
    .src( paths.blockScss )
    .pipe( sass( sassOptions ).on( 'error', sass.logError ) )
    .pipe( autoprefixer() )
    .pipe( rename( { extname: '.css' } ) )
    .pipe( gulp.dest( ( file ) => file.base ) );
}

// Compile shared.scss → assets/css/shared.css
function compileSharedSass() {
  return gulp
    .src( paths.sharedScss )
    .pipe( sass( sassOptions ).on( 'error', sass.logError ) )
    .pipe( autoprefixer() )
    .pipe( gulp.dest( paths.sharedCss ) );
}

function watchFiles() {
  gulp.watch( paths.blockScss, compileBlockSass );
  gulp.watch( paths.sharedScss, compileSharedSass );
}

export const build = gulp.series( compileBlockSass, compileSharedSass );
export default gulp.series( compileBlockSass, compileSharedSass, watchFiles );
