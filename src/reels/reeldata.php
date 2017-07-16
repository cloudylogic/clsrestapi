<?php

include_once ("../includes/cvideo.php");

/*
**	This function declares a video list array of demo reel videos. 
**	Basically, it's a substitution to avoid using a database. Because
**	in my instance, this data hardly ever changes, it's fine to 
**	hardcode the data this way.
*/

function getDemoReels()
{
	$demoReels = new cVideos();

	$demoReels->addVideo(      "Cloudy Logic Demo Reel", "176516244");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2014", "81617741");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2011", "20914693");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2010", "12920154");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2009", "8476572");

	return $demoReels;
}

?>
