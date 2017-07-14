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
            <p>Click on the buttons below to test each API. Buttons in the first column are the primary APIs. Buttons in the second column, when present, illustrate passing a parameter to the API by embedding it in the URL.</p>
            <input type="button" class="btn btn-primary" value="reels" id="reels">
            <input type="button" class="btn btn-secondary" value="reels/0" id="reels_0">
            <br />
            <input type="button" class="btn btn-primary" value="about-us" id="about-us">
            <br />
            <input type="button" class="btn btn-primary" value="versions" id="versions">
            <input type="button" class="btn btn-secondary" value="versions/reels" id="versions_reels">
            <br />
            <input type="button" class="btn btn-primary" value="contact-info" id="contact-info">
            <br />
            <input type="button" class="btn btn-primary" value="our-work" id="our-work">
            <input type="button" class="btn btn-secondary" value="our-work/3" id="our-work_3">
            <br />
            <input type="button" class="btn btn-info" value="reset" id="reset">
            <br />
        </div>
        <div>
        	<pre id="reply">API return data here</pre>
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
        attachRESTapi('#reels_0', 'reels/0');
        attachRESTapi('#our-work', 'our-work');
        attachRESTapi('#our-work_3', 'our-work/3');
        attachRESTapi('#about-us', 'about-us');
        attachRESTapi('#contact-info', 'contact-info');
        attachRESTapi('#versions', 'versions');
        attachRESTapi('#versions_reels', 'versions/reels');
        resetReply('#reset');
    });
    
    function resetReply(id){
        $(id).click(function(){
            document.getElementById("reply").innerHTML = "API return data here";
        });
    }
    
    function attachRESTapi(id,apiName){
        $(id).click(function(){
            $.ajax({
                url: '/' + apiName,
                method: 'GET'
            }).then(function(data) {
                //console.log(data);
                var str = JSON.stringify(data,null,2);
                //$('#reply').replaceWith("<div id=\"reply\"><pre>" + str + "</pre></div>");
                document.getElementById("reply").innerHTML = str;
            });
        });
    }
</script>

</body>
</html>


