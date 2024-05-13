'use strict';

const { files, browserSyncAtts } = require('./gulpconfig.js');



const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const rename = require("gulp-rename");
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const browserSync = require('browser-sync');
const reload = browserSync.reload;

// CSS
gulp.task('sass', function () {
	return gulp.src(files.sass.src)
		// .pipe(sourcemaps.init())
		.pipe(sass({errLogToConsole: true, outputStyle: 'compressed'}))
		.pipe(rename({suffix: '.min'}))
		// .pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./assets'))
		.pipe(browserSync.stream())
});

// JS
gulp.task('js', function () {
	return gulp.src(files.js.src)
		.pipe(babel({
			presets: ['@babel/env']
		}))
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('./assets/'))
		.pipe(browserSync.stream())
});

// BrowserSync
gulp.task('browserSync', function () {
	browserSync(browserSyncAtts);
});


gulp.task('watch:sass', function () {
	gulp.watch(files.sass.watch, gulp.series('sass'));
});
gulp.task('watch:js', function () {
	gulp.watch(files.js.watch, gulp.series('js'));
});
gulp.task('watch:php', function () {
	gulp.watch(files.php.watch).on('change', reload);
});

gulp.task('watch', gulp.parallel('sass', 'js', 'browserSync', 'watch:sass', 'watch:js', 'watch:php'));
