var gulp = require('gulp'),
	browserSync = require('browser-sync'),
	php = require('gulp-connect-php'),
	fs = require('fs-extra');

// helper function to build an FTP connection based on our configuration
function checkForAuthOverride(authFilename) {

	var sourceName = '../../' + authFilename;
	
	try {
		fs.copySync(sourceName, authFilename)
		console.log("Auth override for " + authFilename + " successful!");
	} catch (err) {
		console.error("Autho override for " + authFilename + " failed.\r\n" + err);
	}
}

// I don't think we need this override for Wordpress theme development...

gulp.task('override-auth', function(){

	checkForAuthOverride('users.logininfo.php');
	checkForAuthOverride('sql.logininfo.php');
});

var srcDir = '../../src/'

gulp.task('php', ['override-auth'], function() {
    php.server({}, function () {
        browserSync({ proxy: '127.0.0.1:8000'});
    });
    
    gulp.watch([srcDir + '*',srcDir + 'reels/*', srcDir + 'about-us/*',srcDir + 'our-work/*', srcDir + 'contact-info/*']).on('change', function () {
        browserSync.reload('');
    });
});

gulp.task('default', ['php']);
