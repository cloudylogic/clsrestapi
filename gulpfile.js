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
gulpSources = [srcDir + 'gulpfiles/*.js'];

if (env === 'dev'){
	outDir = bldRoot + 'dev/';
} else {
	outDir = bldRoot + 'rel/';
}

console.log('Building clsrestapi in ' + env + ' mode to ' + outDir);

gulp.task( 'css', function() {
	gulp.src(cssSources)
        .pipe(cached("csscache"))
		.pipe(gulp.dest(outDir))
});

gulp.task('php', function(){
   gulp.src(phpSources,{base: srcDir})
    .pipe(cached("phpcache"))
  	.pipe(gulp.dest(outDir));
});

gulp.task('cpgulpsrc', function(){
   gulp.src(gulpSources)
    .pipe(cached("gulpcache"))
    .pipe(debug())
  	.pipe(gulp.dest(outDir));
});

gulp.task('cpmiscsrc', function(){
   gulp.src(miscSources)
    .pipe(cached("misccache"))
    .pipe(debug())
  	.pipe(gulp.dest(outDir));
});

gulp.task('watch', function() {
  gulp.watch(cssSources, ['css']);
  gulp.watch(phpSources, ['php']);
  gulp.watch(gulpSources,['cpgulpsrc']);
  gulp.watch(miscSources,['cpmiscsrc']);
});

/*
gulp.task('webserver', function() {
  gulp.src(outDir)
    .pipe(webserver({
      livereload: true,
      open: true
    }));
});

gulp.task('cpgulpphpsrv', function(){
/*   gulp.src(ftpXferSrc)
   	.pipe(debug())
  	.pipe(gulp.dest(outDir));

    gulp.src(phpServerSrc)
   	.pipe(debug())
  	.pipe(gulp.dest(bldRoot));
});
*/

var buildtasks=['php', 'css', 'cpgulpsrc', 'cpmiscsrc'];

gulp.task('build', buildtasks); 

gulp.task('default', buildtasks.concat(['watch']));
