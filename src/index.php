<!doctype html>
<html lang="en">
<head>
    <title>CLS REST API</title>
	<meta charset='UTF-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">

	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
	<link rel='stylesheet' href="css/styles.css" type="text/css" />
    
    <!--<link rel="shortcut icon" type="image/x-icon" href=@@favicon>-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<header id=mainheader class="header">
    <!-- Fixed navbar -->
	<include src="../tmpl/navbar.htpl"></include>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Home</a>
        </div><!-- navbar-header -->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="reels/">reels</a></li>
            <li><a href="our-work/">our-work</a></li>
            <li><a href="about-us/">about-us</a></li>
          </ul>
        </div><!-- #navbar navbar-collapse collapse -->
      </div><!-- container -->
    </nav><!-- navbar navbar-inverse navbar-fixed-top -->
	
</header> <!-- #mainheader class="header" -->

<section id=main class="section">
    <div class="container">
        <div class="heading">
            <h3>Cloudy Logic Studios REST API Front-End</h3>
            <p>Welcome to the front-end app for the Cloudy Logic Studios REST API (aka CLSRESTAPI)! This app allows you to <em>manually test</em> the various APIs that are part of this system.</p>
        </div>
        
        <div class="content">
            <h4>CLS REST API</h4>
            <p>Click on the links below to test each API</p>
            <input type="button" value="reels" id="reels">
            <br />
            <input type="button" value="about-us" id="about-us">
            <br />
            <input type="button" value="versions" id="versions">
            <br />
            <input type="button" value="contact-info" id="contact-info">
            <br />
            <input type="button" value="our-work" id="our-work">
            <br />
        </div>
    </div><!-- <div class="container"> -->
</section>

<footer class="footer">
	<div id="contact" class='container'>
	    <h3>Connect with me.</h3>
        <ul>
          <li><a href="https://www.linkedin.com/in/kenlowrie" class="button social"><span class="fa-stack fa-fw"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-linkedin fa-stack-1x"></i></span></a></li>
          <li><a href="https://github.com/kenlowrie" class="button social"><span class="fa-stack fa-fw"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-github fa-stack-1x"></i></span></a></li>
          <li><a href="https://twitter.com/kenl" class="button social"><span class="fa-stack fa-fw"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a></li>
          <li><a href="https://vimeo.com/cloudylogic" class="button social"><span class="fa-stack fa-fw"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-vimeo fa-stack-1x"></i></span></a></li>
        </ul>
    </div>
    <div id="footer-bottom">
    	Coded with <span class="fa fa-heart"></span> by <a href="https://www.kenlowrie.com" target="_blank">Ken Lowrie</a>
    </div>
</footer> <!-- footer -->

<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
        /*$('#reels').click(function(){
            var root = '';  // http://api.cloudylogic.com
            $.ajax({
              url: root + '/reels',
              method: 'GET'
            }).then(function(data) {
              console.log(data);
            });
        });*/
        attachRESTapi('#reels', 'reels');
        attachRESTapi('#our-work', 'our-work');
        attachRESTapi('#about-us', 'about-us');
        attachRESTapi('#contact-info', 'contact-info');
        attachRESTapi('#versions', 'versions');
    });
    
    function attachRESTapi(id,apiName){
        $(id).click(function(){
            $.ajax({
                url: '/' + apiName,
                method: 'GET'
            }).then(function(data) {
                console.log(data);
            });
        });
    }
</script>


</body>
</html>


