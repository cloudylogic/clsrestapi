<?php

define("CLSRESTAPI_VER_ABOUT_US_NAME", "about-us");
define("CLSRESTAPI_VER_ABOUT_US_API", "1.0");
define("CLSRESTAPI_VER_ABOUT_US_DATA", "1.0");
define("CLSRESTAPI_VER_CONTACT_INFO_NAME", "contact-info");
define("CLSRESTAPI_VER_CONTACT_INFO_API", "1.0");
define("CLSRESTAPI_VER_CONTACT_INFO_DATA", "1.0");
define("CLSRESTAPI_VER_OUR_WORK_NAME", "our-work");
define("CLSRESTAPI_VER_OUR_WORK_API", "1.0");
define("CLSRESTAPI_VER_OUR_WORK_DATA", "1.0");
define("CLSRESTAPI_VER_REELS_NAME", "reels");
define("CLSRESTAPI_VER_REELS_API", "1.0");
define("CLSRESTAPI_VER_REELS_DATA", "1.0");
define("CLSRESTAPI_VER_VERSIONS_NAME", "versions");
define("CLSRESTAPI_VER_VERSIONS_API", "1.0");
define("CLSRESTAPI_VER_VERSIONS_DATA", "1.0");

class cAPIversion {
    public $apiName;
    public $apiVersion;
    public $apiDataVersion;
    
    public function __construct($apiName,$apiVersion,$apiDataVersion){
        $this->apiName = $apiName;
        $this->apiVersion = $apiVersion;
        $this->apiDataVersion = $apiDataVersion;
    }
}

function parseAPIparameters($apiName)
{
    header('Content-Type: application/json');

    $apiRequest = new StdClass();
    $apiRequest->parseOK = true;
        
    $apiRequest->reqKeys = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);

    if (count($apiRequest->reqKeys) < 1 || strcasecmp($apiRequest->reqKeys[0],$apiName)){
        $name = count($apiRequest->reqKeys) ? $apiRequest->reqKeys[0] : "Not Specified";
    
        $apiRequest->parseOK = false;
        $apiRequest->errormessage = "Expected API name of '$apiName' but got '$name' instead";
    
        echo trim(json_encode($apiRequest,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
    }
    return $apiRequest;
}

?>
