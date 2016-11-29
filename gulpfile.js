var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    del = require('del'),
    rename = require("gulp-rename"),
    clearCSS = require('gulp-clean-css'),
    watch = require('gulp-watch'),
    sass = require('gulp-sass'),
    babel = require('gulp-babel');

var paths = {
    'stage': 'resources/stage/',
    'angular': 'resources/assets/angular/',
    'sass': 'resources/assets/sass/',
    'npm': 'node_modules/',
    'legacy': 'resources/assets/legacy/',
    'public': {
        'js': 'public/js/',
        'css': 'public/css/',
        'font': 'public/fonts'
    }
};

gulp.task('fonts', function(){
    return gulp.src([
        paths.npm+'bootstrap-sass/assets/fonts/bootstrap/*',
        paths.npm+'font-awesome/fonts/*',
        paths.npm+'ionicons/dist/fonts/*',
    ])
        .pipe(gulp.dest(paths.public.font));
});

gulp.task('vendorcss', function(){
    return gulp.src([
        paths.legacy+'**/*.css',
    ])
        .pipe(concat('vendor.css'))
        .pipe(gulp.dest(paths.stage));
});

gulp.task('css',['vendorcss', 'fonts'], function() {
    return gulp.src([
        paths.npm+'bootstrap-sass/assets/stylesheets/_bootstrap.scss',
        paths.sass+'**/core.scss',
        paths.sass+'**/*.sass'
    ])
        .pipe(sass())
        .pipe(concat('core.css'))
        .pipe(gulp.dest(paths.stage));
});

gulp.task('vendorjs', function(){
    return gulp.src([
        paths.npm+'jquery/dist/jquery.js',
        paths.npm+'bootstrap-sass/assets/javascripts/bootstrap.js',
        paths.npm+'angular/angular.js',
        paths.npm+'angular-route/angular-route.js',
        paths.npm+'angular-ui-router/release/angular-ui-router.js',
        paths.npm+'angular-ui-bootstrap/dist/ui-bootstrap-tpls.js',
        paths.legacy+'**/*.js',
    ])
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest(paths.stage));
});

gulp.task('js', ['vendorjs'], function(){
    return gulp.src([
        paths.angular+'core.js',
        paths.angular+'**/*.js',
    ])
        .pipe(babel().on('error', console.error))
        .pipe(concat('core.js'))
        .pipe(gulp.dest(paths.stage));
});

gulp.task('pushcss', ['css'], function(){
    return gulp.src([
        paths.stage+'vendor.css',
        paths.stage+'*.css'
    ])
        .pipe(concat('core.css'))
        .pipe(gulp.dest(paths.public.css));
});

gulp.task('pushjs', ['js'], function(){
    return gulp.src([
        paths.stage+'vendor.js',
        paths.stage+'*.js',
        'resources/assets/legacyAnnoying/js/app.js',
    ])
        .pipe(concat('core.js'))
        .pipe(gulp.dest(paths.public.js));
});

gulp.task('clear', function(){
    return del([
        paths.public.js+'*.js',
        paths.public.css+'*.css'
    ]);
});

gulp.task('build',['clear', 'pushjs','pushcss'],function(){

});

gulp.task('default',['pushjs','pushcss', 'watch'],function(){

});

gulp.task('prod',['clear', 'css', 'js'],function(){
    gulp.src([
        paths.stage+'vendor.css',
        paths.stage+'*.css'
    ])
        .pipe(concat('core.css'))
        .pipe(clearCSS())
        .pipe(gulp.dest(paths.public.css));

    return gulp.src([
        paths.stage+'vendor.js',
        paths.stage+'*.js',
        'resources/assets/legacyAnnoying/js/app.js'
    ])
        .pipe(concat('core.js'))
        .pipe(uglify())
        .pipe(gulp.dest(paths.public.js));
});

gulp.task('watch',function(){
    console.log("Watching...");
    gulp.watch(paths.sass+'**/*.scss',['pushcss']);
    gulp.watch(paths.angular+'**/*.js',['pushjs']);
});