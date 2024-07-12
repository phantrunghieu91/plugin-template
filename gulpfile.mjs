'use strict';
// Gulp
import { task, watch, src, parallel, dest } from 'gulp';
// Utilities
import rename from 'gulp-rename';
import sourcemaps from 'gulp-sourcemaps';
import fancyLog from 'fancy-log';
import browserSync from 'browser-sync';
// Css related
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import autoprefixer from 'gulp-autoprefixer';
// JS related
import browserify from 'browserify';
import source from 'vinyl-source-stream';
import watchify from 'watchify';
import buffer from 'vinyl-buffer';
import terser from 'gulp-terser';
import Babelify from 'babelify';
const sass = gulpSass(dartSass);
const paths = {
  scss: {
    src: 'src/scss/exports',
    exports: 'src/scss/exports/*.scss',
    dest: './dist/css',
    watch: 'src/scss/**/*.scss',
  },
  ts: {
    src: 'src/ts/exports/',
    entries: [],
    dest: './dist/js',
    watch: 'src/ts/**/*.ts',
  },
  php: {
    watch: '**/*.php',
  },
};
// Browser sync
function initBrowserSync() {
  browserSync.init({
    open: false,
    injectChanges: true,
    // proxy: 'http://localhost:3000',  // Uncomment this line if you are using a local server
  });
}
function reload(done) {
  browserSync.reload();
  done();
}
function compileScss() {
  return src(paths.scss.exports)
    .pipe(sourcemaps.init()) // Initialize sourcemaps before any transformations
    .pipe(
      sass({
        errorLogToConsole: true,
        outputStyle: 'compressed',
      })
    )
    .on('log', fancyLog)
    .pipe(
      autoprefixer({
        cascade: false,
      })
    )
    .pipe(rename({ suffix: '.min' }))
    .pipe(
      sourcemaps.write({
        includeContent: false,
        sourceRoot: `../../${paths.scss.src}`, // This is the path to the source file in the sourcemap
      })
    ) // Write sourcemaps after transformations, before saving the output
    .pipe(dest(paths.scss.dest))
    .pipe(browserSync.stream());
}
function bundleJS() {
  paths.ts.entries.map(entry => {
    const watchedBrowserify = watchify(
      browserify({
        basedir: paths.ts.src,
        debug: true,
        entries: [`${entry}.ts`],
        cache: {},
        packageCache: {},
      })
    )
      .on('log', fancyLog)
      .plugin('tsify')
      .transform(
        Babelify.configure({
          extensions: ['.ts'],
          presets: ['@babel/preset-env'],
        })
      ); // Use tsify plugin to compile TypeScript
    function reBundle() {
      return watchedBrowserify
        .bundle()
        .pipe(source(`${entry}.min.js`))
        .pipe(buffer())
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(terser()) // Minify the output
        .pipe(
          sourcemaps.write({
            includeContent: false,
            sourceRoot: `../../${paths.ts.src}`, // This is the path to the source file in the sourcemap
          })
        )
        .pipe(dest(paths.ts.dest))
        .pipe(browserSync.stream());
    }
    watchedBrowserify.on('update', reBundle);
    return reBundle();
  });
}
function watchFiles() {
  watch(paths.scss.watch, compileScss);
  watch(paths.php.watch, { events: 'change' }, reload);
  bundleJS();
}
// Define gulp tasks
task('browser-sync', initBrowserSync);
task('style', compileScss);
task('script', bundleJS);
task('watch', watchFiles);
task('default', parallel('browser-sync', 'style', 'script', 'watch'));
