import * as _ from 'es6-promise';

import buildConfig from './gulp.config.js';
import gulp from 'gulp';
import fs from  'fs';
import babel from  'gulp-babel';
import header from  'gulp-header';
import sassCompiler from 'sass';
import sassGulp from  'gulp-sass';
import rtlcss from  'gulp-rtlcss';
import postcss from  'gulp-postcss';
import autoprefixer from  'gulp-autoprefixer';
import cssnano from  'cssnano';
import plumber from  'gulp-plumber';
import gutil from  'gulp-util';
import rename from  'gulp-rename';
import concat from  'gulp-concat';
import sourcemaps from  'gulp-sourcemaps';
import uglify from  'gulp-uglify';
import imagemin from  'gulp-imagemin';
import del from  'del';
import bump from  'gulp-bump';
import iconfont from  'gulp-iconfont';
import iconfontCss from  'gulp-iconfont-css';
import zip from  'gulp-zip';
import juice from  'gulp-juice';
import mode from  'gulp-mode';

const sass = sassGulp(sassCompiler);

var onError = function ( err ) {
  console.log( 'An error occurred:', gutil.colors.magenta( err.message ) );
  gutil.beep();
  this.emit( 'end' );
};

/**
 * This function compiles source *.scss files and concatenates them into a single file.
 * @function css
 * @return { stream } - returns a gulp stream.
 */
function cssTask() {
  return gulp.src( buildConfig.sources.allScssFiles.principalCSSFiles )
    .pipe( sourcemaps.init() )
    .pipe( plumber( { errorHandler: onError } ) )
    .pipe( header( buildConfig.sources.banner.join( '\n' ) ) )
    .pipe( sass() )
    .pipe( postcss( [ autoprefixer, cssnano ] ) )
    .pipe( sourcemaps.write( '/' ) )
    .pipe( gulp.dest( buildConfig.destination.destFolder )
    );
}

/**
 * This function compiles source *.scss files and concatenates them into a single file.
 * @function css
 * @return { stream } - returns a gulp stream.
 */
function cssAll() {
  return gulp.src( buildConfig.sources.allScssFiles.front )
    .pipe( sourcemaps.init() )
    .pipe( plumber( { errorHandler: onError } ) )
    .pipe( sass() )
    .pipe( postcss( [ autoprefixer, cssnano ] ) )
    .pipe( ( sourcemaps.write( '/' ) ) )
    .pipe( gulp.dest( buildConfig.destination.allScssFiles.front )
    );
}

/**
 * This function gets libraries files.
 * @function LibrariesTask
 * @return { stream } - returns a gulp stream
 */
function LibrariesTask() {
  return gulp.src( buildConfig.sources.allLibFiles, {
    base: './node_modules/'
  } )
    .pipe( gulp.dest( buildConfig.destination.allLibFiles ) );
}

/**
 * This function concatenates source *.js files into a single file.
 * @function js
 * @return { stream } - returns a gulp stream
 */
function jsTask() {
  return gulp.src( buildConfig.sources.allJsFiles.front )
    .pipe(  sourcemaps.init()  )
    .pipe( babel( {
      presets: [ "@babel/preset-env" ]
    } ) )
    .pipe( rename( {
      suffix: '.min'
    } ) )
    .pipe( uglify() )
    .pipe( (  sourcemaps.write( '/' )  ) )
    .pipe( gulp.dest( buildConfig.destination.allJsFiles.front ) );
}

/**
 * This function minify the images and transfers them to a location.
 * @function images
 * @return { stream } - returns a gulp stream
 */
function imagesTask() {
  return gulp.src( buildConfig.sources.allImgFiles )
    .pipe( plumber( {
      errorHandler: onError
    } ) )
    .pipe( imagemin( {
      optimizationLevel: 7,
      progressive: true
    } ) )
    .pipe( gulp.dest( buildConfig.destination.allImgFiles ) );
}

/**
 * This function creates the theme folder tree.
 * @function scaffolding
 * @return { stream } - returns a gulp stream
 */
function scaffolding() {
  return gulp.src( buildConfig.sources.scaffolding )
    .pipe( gulp.dest( buildConfig.destination.destFolder ) );
}

/**
 * This function appends scaffolding, js and css.
 * @function watchFiles
 */
function watchTask() {

  // Watch Php files.
  gulp.watch( buildConfig.sources.sourceFolder + '/**/*.{php,twig}', scaffolding );

  // Watch CSS files
  gulp.watch( buildConfig.sources.sourceFolder + '/static/sass/**/*.scss', cssTask );
  gulp.watch( buildConfig.sources.sourceFolder + '/static/sass/**/*.scss', cssAll );

  // Watch Javascript files.
  gulp.watch( buildConfig.sources.sourceFolder + '/static/js/**/*.js', jsTask );

  // Watch images files.
  gulp.watch( buildConfig.sources.sourceFolder + '/static/images/**/*.{png,jpg,jpeg,gif}', imagesTask );
}

/**
 * This function clean config.destPath (delete all files in folder)
 * @function clean
 * @return { stream } - returns a gulp stream
 */
function clean( cb ) {
  del.sync( [ buildConfig.destination.destFolder + '/**/**' ], { force: true } );
  cb();
}

function prerelease() {
  return gulp.src( './package.json' )
    .pipe( bump( { type: 'prerelease' } ) )
    .pipe( gulp.dest( './' )
    );
}

function updateWpVersion( cb ) {
  var banner = buildConfig.sources.banner.join( '\n' );
  fs.writeFile( buildConfig.sources.version, banner, cb );
}

function packagefunction() {
  return gulp.src( buildConfig.destination.destFolder + '/**', { base: buildConfig.general.dest } )
    .pipe( zip( buildConfig.general.package.name + '_' + buildConfig.general.package.version + '.zip' ) )
    .pipe( gulp.dest( buildConfig.destination.buildPackage ) )
}

const buildFunction  = gulp.series(
  clean,
  scaffolding,
  gulp.parallel( cssTask, cssAll, jsTask, LibrariesTask, imagesTask )
);

const reload = gulp.series( buildFunction, gulp.parallel( watchTask ) );

export var watch = reload;
export var build = buildFunction;
export var pack = gulp.series( updateWpVersion, build, packagefunction, prerelease );

export default buildFunction;
