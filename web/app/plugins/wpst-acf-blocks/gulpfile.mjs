import gulp from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import autoprefixer from 'gulp-autoprefixer';
import rename from 'gulp-rename';
import sourcemaps from 'gulp-sourcemaps';

const sass = gulpSass( dartSass );
const isProd = process.env.NODE_ENV === 'production';

const paths = {
  scss: 'blocks/**/block.scss',
};

// Compile each block's block.scss → block.css (same folder)
function compileBlockSass() {
  return gulp
    .src( paths.scss )
    .pipe( isProd ? gulp.dest( '.' ) : sourcemaps.init() )
    .pipe(
      sass( {
        outputStyle: isProd ? 'compressed' : 'expanded',
      } ).on( 'error', sass.logError )
    )
    .pipe( autoprefixer() )
    .pipe( rename( { extname: '.css' } ) )
    .pipe( isProd ? gulp.dest( ( file ) => file.base ) : sourcemaps.write( '.' ) )
    .pipe( gulp.dest( ( file ) => file.base ) );
}

function watchFiles() {
  gulp.watch( paths.scss, compileBlockSass );
}

export const build = gulp.series( compileBlockSass );
export default gulp.series( compileBlockSass, watchFiles );
