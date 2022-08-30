'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass');
const uglify = require('gulp-uglify');
const rename = require("gulp-rename");
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');

// CSS
gulp.task('sass', function () {
	return gulp.src('./assets/**/css/*.scss')
		// .pipe(sourcemaps.init())
		.pipe(sass({errLogToConsole: true, outputStyle: 'compressed'}))
		.pipe(rename({suffix: '.min'}))
		// .pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('./assets'))
});

// JS
gulp.task('js', function () {
	return gulp.src(['assets/**/js/*.js', '!assets/**/js/*.min.js', 'assets/**/js/**/*.js', '!assets/**/js/**/*.min.js'])
		.pipe(babel({
			presets: ['@babel/env']
		}))
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('./assets/'));
});

gulp.task('watch:sass', function () {
	gulp.watch('./assets/**/css/*.scss', gulp.series('sass'));
});
gulp.task('watch:js', function () {
	gulp.watch(['assets/**/js/*.js', '!assets/**/js/*.min.js', 'assets/**/js/**/*.js'], gulp.series('js'));
});

gulp.task('watch', gulp.parallel('sass', 'js', 'watch:sass', 'watch:js'));
