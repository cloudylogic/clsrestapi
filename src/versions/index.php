<?php
// This file is covered by the LICENSE file in the root of this project.

/*
**	This file has the implementation of the 'versions' API for the CLS REST API
*/

include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cVersionsReply extends cBaseReply {
	/*
	**	The versions API provide a list of API versions for the CLS REST API.
	**
	**	The $totApis will have a count of all the apiVer objects in our list.
	**	The $allApiList will be a list of all the apiVer objects.
	**
	**	These are protected, because we do NOT want them all returned to the client.
	**	Instead, based on what the client requests (via the path), we will return
	**	the request apiVer object(s).
	*/
	protected $totApis;
    protected $allApiList;
    
    public function __construct(){
    	/*
    	**	First invoke the base class constructor by passing in our apiVer object.
    	*/
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_VERSIONS_NAME,CLSRESTAPI_VER_VERSIONS_API,CLSRESTAPI_VER_VERSIONS_DATA));
		/*
		**	Now construct the allApiList array by loading all 5 of our API ver objects in.
		**	Store the total count in $totApis, and then initialize the apiObj, which will
		**	contain the specific apiVer object(s) requested.
		*/
        $this->allApiList = Array();
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_VERSIONS_NAME,     CLSRESTAPI_VER_VERSIONS_API, 		CLSRESTAPI_VER_VERSIONS_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_REELS_NAME,		CLSRESTAPI_VER_REELS_API, 			CLSRESTAPI_VER_REELS_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_ABOUT_US_NAME,     CLSRESTAPI_VER_ABOUT_US_API, 		CLSRESTAPI_VER_ABOUT_US_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_CONTACT_INFO_NAME, CLSRESTAPI_VER_CONTACT_INFO_API,	CLSRESTAPI_VER_CONTACT_INFO_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,     CLSRESTAPI_VER_OUR_WORK_API, 		CLSRESTAPI_VER_OUR_WORK_DATA);
        
        $this->totApis = count($this->allApiList);

        $this->apiObj->numApis = 0;
        $this->apiObj->apiList = Array();
    }
    
    public function addApiVersion($api){
    	/*
    	**	Add a specific apiVer object to our list of objects being returned.
    	*/
        $this->apiObj->apiList[] = $api;
        $this->apiObj->numApis++;
    }
    
    public function getApiVersion($apiName){
    	/*
    	**	Return an apiVer object based on the apiName passed in.
    	**
    	**	If the apiName is not in our list, return NULL.
    	*/
        for($i = 0; $i < $this->totApis; ++$i){
            if (!strcasecmp($apiName,$this->allApiList[$i]->apiName)){
                return $this->allApiList[$i];
            }
        }
        return NULL;
    }
    
    public function addAllApiVersions(){
    	/*
    	**	Return ALL of the apiVer objects to our client.
    	*/
        $this->apiObj->apiList = $this->allApiList;
        $this->apiObj->numApis = count($this->apiObj->apiList);
    }
}

function addVersionsToReply($versionsReply, $which="*")
{
	/*
	**	Initialize the return object with the requested version object(s)
	*/
    if ($which != "*"){
    	/*
    	**	$which is '*' when only a single path element is present (or if the
    	**	client passes '*' for that path element (if supported).
    	**
    	**	If $which is NOT '*', then attempt a lookup on the requested apiName.
    	*/
        $version = $versionsReply->getApiVersion($which);
        
        if( $version != NULL ){
        	/*
        	**	Return the specific apiVer object requested.
        	*/
            $versionsReply->addApiVersion($version);
            return;
        }
        /*
        **	If $version is NULL, then that apiName was not found. Return them all.
        */
    }
    /*
    **	Return all of the apiVer objects.
    */
    $versionsReply->addAllApiVersions();
}

function returnVersions()
{
	/*
	**	First, instantiate a cVersionsReply object.
	**	Then, look at the path and determine what apiVer objects to return.
	*/
    $versionsReply = new cVersionsReply();

    if( $versionsReply->parseOK() ){    
		/*
		**	Check to make sure we parsed the path correctly
		*/
        if( 2 == $versionsReply->numRestApiKeys()) {
			/*
			**	If exactly 2 elements are present, then get the second element and
			**	return that specific apiVer object. For example:
			**
			**	GET http://api.cloudylogic.com/versions/reels/
			**
			**	Return the 'reels' apiVer object only.
			*/
            addVersionsToReply($versionsReply,$versionsReply->getRestApiKey(1));    
        } else {
        	/*
        	**	Either GET http://api.cloudylogic.com/versions/ was invoked, or the
        	**	user passed more than 2 elements in the path.
        	**
        	**	Return ALL of the apiVer objects.
        	*/
            addVersionsToReply($versionsReply);    
        }
    }
    /*
    **	Encode the object in JSON format and return that string.
    */
	$jsonReply = trim(json_encode($versionsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

// Tell the caller that the type of the return data is application/json
header('Content-Type: application/json');

// Write the JSON encoded object as the document data
echo returnVersions();

?>
