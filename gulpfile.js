const babelify = require('babelify');
const browserify = require('browserify')
const buffer = require('vinyl-buffer');
const concat = require('gulp-concat');
const del = require('del');
const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const gulpif = require('gulp-if');
const minifyCSS = require('gulp-csso');
const pug = require('gulp-pug');
const sass = require('gulp-sass');
const source = require('vinyl-source-stream');
const sourcemaps = require('gulp-sourcemaps');
const sync = require('browser-sync').create();
const uglify = require('gulp-uglify');
const pxtorem = require('gulp-pxtorem');

const isProd = process.env.NODE_ENV === 'production';


/**
 * SCSS
 */
function scss() {
    return gulp.src('web/scss/**/*.scss')
        .pipe(gulpif(!isProd, sourcemaps.init()))
        .pipe(sass())
        .pipe(gulpif(isProd, minifyCSS()))
        .pipe(gulpif(!isProd, sourcemaps.write('.')))
        .pipe(gulp.dest('dist/css'))
        .pipe(sync.stream());
}

// function html() {
//     return gulp.src('app/**/*.html')
//         .pipe(gulp.dest('dist/'))
//         .pipe(sync.stream());
// }

/**
 * JS
 */

function js() {
    return browserify({entries: ['web/js/main.js'], debug: true})
        .transform(babelify, {presets: 'es2015'})
        .bundle()
        .pipe(source('main.js'))
        .pipe(buffer())
        .pipe(gulpif(!isProd, sourcemaps.init({loadMaps: true})))
        .pipe(uglify())
        .pipe(gulpif(!isProd, sourcemaps.write('.')))
        .pipe(gulp.dest('dist/js'))
        .pipe(sync.stream());
}

/**
 * IMAGES
 */

function images() {
    return gulp.src('web/img/**/*')
        .pipe(gulpif(isProd, imagemin({verbose: true})))
        .pipe(gulp.dest('dist/img'));
}

/**
 * FONTS
 */
function fonts() {
    return gulp.src('web/fonts/**/*')
        .pipe(gulp.dest('dist/fonts'));
}


/**
 * GLOBAL
 */
function clean() {
    return del(['dist']);
}


// TODO: ADD GULP JS TO PARALLEL
gulp.task('build', gulp.series(clean, gulp.parallel( scss, images, fonts, js)));

gulp.task('default', gulp.parallel( scss, images, fonts, js, function(done) {
    sync.init({
        server: {
            baseDir: './dist'
        }
    });

    gulp.watch('web/**/*.scss', scss);
    // gulp.watch('web/*.html', html);
    gulp.watch('web/**/*.js', js);

    done();

}));