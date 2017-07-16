<?php

/*
**	Define a bunch of constants for the api names, versions and data versions.
**	The idea is that if you change an API structure, you would bump the _API
**	version number. If you change the DATA only in an API, you would bump the _DATA
**	version number. One way this might be used by clients is to allow them to cache
**	data, such that they would only have to make API calls again if the data version
**	changed from the last time they called the API. Time will tell if this will be
**	a workable solution.
*/
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
	/*
	**	This class defines an API version.
	*/
    public $apiName;		// The API name
    public $apiVersion;		// The API version
    public $apiDataVersion;	// The API DATA version
    
    public function __construct($apiName,$apiVersion,$apiDataVersion){
    	/*
    	**	Construct the cAPIversion object with the passed parameters.
    	*/
        $this->apiName = $apiName;
        $this->apiVersion = $apiVersion;
        $this->apiDataVersion = $apiDataVersion;
    }
}
?>
