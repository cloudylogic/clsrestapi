<?php

include_once ("../includes/cvideo.php");

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