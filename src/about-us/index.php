<?php
/*
**	This file has the implementation of the 'about-us' API for the CLS REST API
*/
include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cAboutUsReply extends cBaseReply {
	/*
	**	The about-us API only has a single string that provides some background
	**	on the company.
	*/
	public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_ABOUT_US_NAME,CLSRESTAPI_VER_ABOUT_US_API,CLSRESTAPI_VER_ABOUT_US_DATA));
		
		$this->apiObj->aboutus = 
		     "Although Cloudy Logic wasn't officially formed until 2004, we have been creating all types of " .
             "media content since the late 1990′s. With over 30 years of combined experience, you can be certain " .
             "that we can create exactly what you’re looking for. Let us help you take your idea from concept to completion, " .
             "whether it’s a business profile, narrative film, commercial, music video or documentary. Or, if you " .
             "already have your concept, we can simply provide production and/or post-production services. " .
             "Whatever your needs are, we are eager to help you achieve them. Go ahead and give us a call at 512-710-7257 or email " .
             "us at info@cloudylogic.com for more information or to get a quote for your project.";
    }
}

function returnAboutUs()
{
	/*
	**	Instantiate a cAboutUsReply object and we're done.
	*/
    $aboutUsReply = new cAboutUsReply();
    /*
    **	Encode the object in JSON format and return that string.
    */
	$jsonReply = trim(json_encode($aboutUsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

// Tell the caller that the type of the return data is application/json
header('Content-Type: application/json');

// Write the JSON encoded object as the document data
echo returnAboutUs();

?>
