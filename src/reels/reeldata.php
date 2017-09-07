<?php
// This file is covered by the LICENSE file in the root of this project.

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

	$demoReels->addVideo( "Cloudy Logic Demo Reel", 
	                      "176516244",
	                      "499384905879d9a25a637fb60dfda1f7420f8f22",
                          "115f38a327640774d5e9ac32895e79511a5d8f2e&amp;profile_id=174",
                          "89ae7bb858d81e0dfab823fbaf82a33f86645ead&amp;profile_id=165",
                          "89ae7bb858d81e0dfab823fbaf82a33f86645ead&amp;profile_id=164",
	                      "img-dr2016.png",
	                      "frame-dr2016.png");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2014", 
	                       "81617741",
	                       "8ceaca859b241422a6eac062b14e003540d1bda9",
                           "59b2fa4be72c84d450a29cc8ba233d41ae8a69db&amp;profile_id=174",
                           "a65673ca51a46c5de57eecd343e3403b049d5520&amp;profile_id=165",
                           "a65673ca51a46c5de57eecd343e3403b049d5520&amp;profile_id=164",
	                       "img-dr2014.png",
	                       "frame-dr2014.png");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2011", 
	                      "20914693",
	                      "aecd7b179b1196e5331e891e0a131f68f38242f4",
                          "aa329461671722408c01f23273d4d3c6da0f2985&amp;profile_id=113",
                          "4ba639f1c229925d61197c8bf515abb8470ffcaf&amp;profile_id=112",
                          "ec5987f3e899d0ea151846c6817c068c3cac3e04&amp;profile_id=116",
	                      "img-dr2011.png",
	                      "frame-dr2011.png");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2010", 
	                      "12920154",
	                      "393d90fd092ae5683b05916c0b2bd2a046f42559",
                          "a9d7c71b7a45d9b288f2c76a37fcb6f4165c7adf&amp;profile_id=113",
                          "0bddab718df17102bfd0b68d6e6860acf1a4c539&amp;profile_id=112",
                          "f281f678c129ead2cb943cbdd0fca73b2821e37d&amp;profile_id=116",
	                      "img-dr2010.png",
	                      "frame-dr2010.png");
	$demoReels->addVideo( "Cloudy Logic Demo Reel 2009", 
	                      "8476572",
	                      "1dcf6e9e39fc8bb809e4cf036704dbdf898ec423",
                          "487710afd9a63b1d9cfbbb503571f7d5aab8cb69&amp;profile_id=113",
                          "73f37e3dbc5ed47dcd419db697da4968bc867e3d&amp;profile_id=112",
                          "c285da44056f950d91f82901c34835d7605b85bb&amp;profile_id=116",
	                      "img-dr2009.png",
	                      "frame-dr2009.png");
	

	return $demoReels;
}

?>
