var gulp = require('gulp'),
	gutil = require('gulp-util'),
	gulpif = require('gulp-if'),
	debug = require('gulp-debug'),
	//webserver = require('gulp-webserver2'),
	cached = require('gulp-cached');

var env,
	srcDir,
	bldRoot,
	cssSources,
	phpSources,
	phpServerSrc,
	gulpSources,
	outDir;

env = process.env.NODE_ENV || 'dev';
srcDir = 'src/';
bldRoot = 'build/';
miscSources = [srcDir + '.htaccess'];
phpServerSrc = [srcDir + 'gulpfiles/phpserver.js'];
phpSources = [srcDir + '**/*.php'];
cssSources = [srcDir + '**/*.css'];
imgSources = [srcDir + '**/images/*', srcDir + '**/images/jdt/*'];
gulpSources = [srcDir + 'gulpfiles/*.js'];

if (env === 'dev'){
	outDir = bldRoot + 'dev/';
} else {
	outDir = bldRoot + 'rel/';
}

console.log('Building clsrestapi in ' + env + ' mode to ' + outDir);

gulp.task( 'css', function() {
	return gulp.src(cssSources)
         .pipe(cached("csscache"))
         .pipe(debug())
         .pipe(gulp.dest(outDir))
});

gulp.task('php', function(){
   return gulp.src(phpSources,{base: srcDir})
          .pipe(cached("phpcache"))
          .pipe(debug())
          .pipe(gulp.dest(outDir));
});

gulp.task('cpgulpsrc', function(){
   return gulp.src(gulpSources)
          .pipe(cached("gulpcache"))
          .pipe(debug())
          .pipe(gulp.dest(outDir));
});

gulp.task('cpmiscsrc', function(){
   return gulp.src(miscSources)
          .pipe(cached("misccache"))
          .pipe(debug())
          .pipe(gulp.dest(outDir));
});

gulp.task('cpimages', function(){
    return gulp.src(imgSources,{base: srcDir})
           .pipe(cached("images"))
           .pipe(debug())
           .pipe(gulp.dest(outDir));
});

gulp.task('watch', function(done) {
  gulp.watch(cssSources, gulp.series(['css']));
  gulp.watch(phpSources, gulp.series(['php']));
  gulp.watch(imgSources, gulp.series(['cpimages']));
  gulp.watch(gulpSources,gulp.series(['cpgulpsrc']));
  gulp.watch(miscSources,gulp.series(['cpmiscsrc']));
  done();
});

var buildtasks=['php', 'css', 'cpgulpsrc', 'cpmiscsrc', 'cpimages'];

gulp.task('build', gulp.series(buildtasks)); 

gulp.task('default', gulp.parallel(buildtasks.concat(['watch'])));
