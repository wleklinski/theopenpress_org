/*
 * require gulp plugins
 */
var gulp         = require('gulp'),
    plumber      = require('gulp-plumber'),
    sass         = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss    = require('gulp-minify-css'),
    newer        = require('gulp-newer'),
    imagemin     = require('gulp-imagemin'),
    livereload   = require('gulp-livereload'),
    lr           = require('tiny-lr'),
    server       = lr();


/*
 * common directories
 */
var src         = 'wp-content/themes/theopenpress/src',
    images      = src + '/images',
    stylesheets = src + '/stylesheets',
    scripts     = src + '/scripts',
    build       = 'wp-content/themes/theopenpress/assets',
    img         = build + '/img',
    css         = build + '/css',
    js          = build + '/js';


/*
 * styles task
 */
gulp.task('styles', function() {
  return gulp.src(stylesheets + '/app.scss', {base: stylesheets})
/*   return gulp.src(stylesheets + '/app.scss', {base: stylesheets}) */
    .pipe(plumber())
    .pipe(sass({style: 'expanded'}))
    .pipe(gulp.dest(css))
    .pipe(autoprefixer('last 2 versions'))
    .pipe(minifycss())
    .pipe(gulp.dest(css))
    .pipe(livereload(server));
});


/*
 * images task
 */
gulp.task('images', function() {
  return gulp.src(images + '/*', {base: images})
    .pipe(newer(img))
    .pipe(imagemin({optimizationLevel: 3, progressive: true, interlaced: true}))
    .pipe(gulp.dest(img));
});


/*
 * watch task
 */
gulp.task('watch', function() {
  server.listen(35739, function(error) {
    if (error) {
      return console.log(error)
    };
    gulp.watch(stylesheets + '/*.scss', ['styles']);
    gulp.watch(stylesheets + '/**/*.scss', ['styles']);
    gulp.watch(images + '/**', ['images']);
  });
});


/*
 * default task
 */
gulp.task('default', ['styles', 'images', 'watch']);
