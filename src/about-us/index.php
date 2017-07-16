<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cAboutUsReply extends cBaseReply {
	public $apiObj;

	public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_ABOUT_US_NAME,CLSRESTAPI_VER_ABOUT_US_API,CLSRESTAPI_VER_ABOUT_US_DATA));
		
		$this->apiObj = new StdClass();
		$this->apiObj->aboutus = 
		     "Although Cloudy Logic wasn't officially formed until 2004, we have been creating all types of " .
             "media content since the late 1990′s. With over 30 years of combined experience, you can be certain " .
             "that we can create exactly what you’re looking for.\r\nLet us help you take your idea from concept to completion, " .
             "whether it’s a business profile, narrative film, commercial, music video or documentary. Or, if you " .
             "already have your concept, we can simply provide production and/or post-production services.\r\n" .
             "Whatever your needs are, we are eager to help you achieve them. Go ahead and give us a call at 512-710-7257 or email " .
             "us at info@cloudylogic.com for more information or to get a quote for your project.";
    }
}

function returnAboutUs()
{
    $aboutUsReply = new cAboutUsReply();
        
	$jsonReply = trim(json_encode($aboutUsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');
echo returnAboutUs();

?>
