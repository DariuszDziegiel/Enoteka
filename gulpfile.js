var gulp = require('gulp');
var beep = require('beepbeep');
//var browserSync = require('browser-sync').create();
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var compass = require('gulp-compass');
var plumber = require('gulp-plumber');
var using = require('gulp-using');
var run = require('gulp-run');

var onError = function(err) {
    beep(3, 1000);
    console.log(err.toString());
    this.emit("End");
}

var bundles = ['App', 'Admin', 'Rs'];

gulp.task('admin_bundle_js', function() {
    gulp.src(['src/AdminBundle/Resources/public/**/*.js', '!src/AdminBundle/Resources/public/**/*.min.js'])
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest('web/bundles/admin'));
});


gulp.task('app_bundle_js', function() {
    gulp.src(['src/AppBundle/Resources/public/**/*.js', '!src/AppBundle/Resources/public/**/*.min.js'])
        .pipe(using())
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest('web/bundles/app'));
});



var RsBundleJsConfig = {
    sourcePath: ['src/RsBundle/Resources/public/**/*.js', '!src/RsBundle/Resources/public/**/*.min.js'],
    destPath:   'web/bundles/rs'
};
gulp.task('rs_bundle_js', function() {
    gulp.src(RsBundleJsConfig.sourcePath)
        .pipe(using())
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest(RsBundleJsConfig.destPath));
});



/**
 * App bundle sass parse
 */
gulp.task('app_bundle_sass', function() {
    gulp.src(['src/AppBundle/Resources/public/**/*.scss'])
        .pipe(using())
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(
            sass({outputStyle: 'compressed'})
            //.on('error', sass.logError())
        )
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest('web/bundles/app'))
        /*.pipe(browserSync.reload({
            stream: true
        }))*/
});

/**
 * Admin bundle sass parse
 */
gulp.task('admin_bundle_sass', function() {
    var oldPath = null;
    gulp.src(['src/AdminBundle/Resources/public/**/*.scss'])
        //.pipe(using())
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(
            sass({outputStyle: 'compressed'})
            //.on('error', sass.logError())
        )
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest('web/bundles/admin'));
});


/**
 * RS bundle sass parse
 */
var RsBundleSassConfig = {
    sourcePath: ['src/RsBundle/Resources/public/**/*.scss'],
    destPath:   'web/bundles/rs'
};
gulp.task('rs_bundle_sass', function() {
    var oldPath = null;
    gulp.src(RsBundleSassConfig.sourcePath)
    //.pipe(using())
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(
            sass({outputStyle: 'compressed'})
            //.on('error', sass.logError())
        )
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest(RsBundleSassConfig.destPath));
});

/**
 * App Bundle Images
 **/
var AppBundleImgConfig = {
  sourcePath: 'src/AppBundle/Resources/public/**/img/*.*',
  destPath:   'web/bundles/app'
};
gulp.task('app_bundle_img', function() {
    return gulp.src(AppBundleImgConfig.sourcePath)
        .pipe(using())
        .pipe(gulp.dest(AppBundleImgConfig.destPath));
});

/**
 * Admin Bundle Images
 **/
var AdminBundleImgConfig = {
    sourcePath: 'src/AdminBundle/Resources/public/**/img/*.*',
    destPath:   'web/bundles/admin'
};
gulp.task('admin_bundle_img', function() {
    return gulp.src(AdminBundleImgConfig.sourcePath)
        .pipe(using())
        .pipe(gulp.dest(AdminBundleImgConfig.destPath));
});


//Dump bazinga translations
var JsTranslationsConfig = {
    sourcePath: 'src/**/translations/*.yml'
};
gulp.task('js_translations_dump', function() {
    return gulp.src(JsTranslationsConfig.sourcePath)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(run('php bin/console bazinga:js-translation:dump'));
});



gulp.task('watch', function () {
    gulp.watch(['src/AdminBundle/Resources/public/**/*.js', '!src/AdminBundle/Resources/public/**/*.min.js'], ['admin_bundle_js']);
    gulp.watch(['src/AppBundle/Resources/public/**/*.js', '!src/AppBundle/Resources/public/**/*.min.js'], ['app_bundle_js']);
    gulp.watch(RsBundleJsConfig.sourcePath, ['rs_bundle_js']);
    
    gulp.watch('src/AppBundle/Resources/public/**/*.scss', ['app_bundle_sass']);
    gulp.watch('src/AdminBundle/Resources/public/**/*.scss', ['admin_bundle_sass']);
    gulp.watch(RsBundleSassConfig.sourcePath, ['rs_bundle_sass']);
    
    gulp.watch(AppBundleImgConfig.sourcePath, ['app_bundle_img']);
    gulp.watch(AdminBundleImgConfig.sourcePath, ['admin_bundle_img']);
    //gulp.watch(JsTranslationsConfig.sourcePath, ['js_translations_dump']);
})

gulp.task('default', ['app_bundle_img', 'admin_bundle_img', 'admin_bundle_js', 'admin_bundle_sass', 'app_bundle_js',
    'app_bundle_sass', 'rs_bundle_sass', 'rs_bundle_js', 'watch']);
