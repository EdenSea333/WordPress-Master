var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var sourcemaps = require('gulp-sourcemaps');
var prefix = require('gulp-autoprefixer');
var rename = require('gulp-rename');
var zip = require('gulp-zip');

gulp.task('default', function() {
    return sass('scss/main.scss', { sourcemap: true, style: 'expanded' })
        .pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css'));
});

gulp.task('default.min', function() {
    return sass('scss/main.scss', { sourcemap: true, style: 'compressed' })
        .pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
        .pipe(rename('main.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css'));
});


gulp.task('watch', function() {
    gulp.watch('scss/*.scss', gulp.series('default'));
    gulp.watch('scss/*.scss', gulp.series('default.min'));
});

gulp.task('build', function () {
    return gulp.src([
        './**',
        '!./dist/**',
        '!./.sass-cache/**',
        '!./.DS_Store',
        '!./**/.DS_Store',
        '!./node_modules/**',
        '!./scss/**',
        '!./.git',
        '!./.gitignore',
        '!./gulpfile.js',
        '!./css/main.css.map',
        '!./css/main.min.css.map',
        '!./package.json',
        '!./package-lock.json',
    ])
        .pipe(zip('maester-lite.zip'))
        .pipe(gulp.dest('./dist'))
});
