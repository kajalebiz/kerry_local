let postcss = require('gulp-postcss');
let autoprefixer = require('autoprefixer');
let postcss_scss = require('postcss-scss');
let gulp = require('gulp');
let rename = require('gulp-rename');
let notify = require('gulp-notify');

// Sass Plugins
let sass = require('gulp-sass');
let sourcemaps = require('gulp-sourcemaps');

// Minifiy JS
let concat = require('gulp-concat');
let uglify = require('gulp-uglify');

let processors = [autoprefixer];

gulp.task('sass', function() {
  gulp
    .src('assets/styles/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(postcss(processors, { syntax: postcss_scss }))
    .pipe(sourcemaps.write('./assets/maps'))
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Regular styles finished.' }));
});

gulp.task('editor-sass', function() {
  gulp
    .src('assets/styles/editor-style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(postcss(processors, { syntax: postcss_scss }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Editor styles finished.' }));
});

//script paths
let jsFiles = 'assets/js/*.js',
  jsDest = 'assets/js/build/';

gulp.task('scripts', function() {
  return gulp
    .src(jsFiles)
    .pipe(concat('site-wide.js'))
    .pipe(gulp.dest(jsDest))
    .pipe(rename('site-wide.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(jsDest))
    .pipe(notify({ message: 'Scripts finished.' }));
});

gulp.task('watch', function() {
  gulp.watch('./assets/styles/**/*.scss', ['sass']);
  gulp.watch('assets/styles/editor-style.scss', ['editor-sass']);
  gulp.watch('./assets/js/*.js', ['scripts']);
});

gulp.task('default', ['sass', 'editor-sass', 'scripts', 'watch']);
