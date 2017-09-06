<?php
// This file is covered by the LICENSE file in the root of this project.

/*
**	This file has the implementation of the 'image-paths' API for the CLS REST API
*/

include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cImagePath {
	/*
	**	This class defines an Image Path.
	*/
    public $clientID;	        // The ID of the image path
    public $imagePath;      // The image path
    
    public function __construct($clientID,$imagePath){
    	/*
    	**	Construct the cImagePath object with the passed parameters.
    	*/
        $this->clientID = $clientID;
        $this->imagePath = $imagePath;
    }
}

class cImagePathsReply extends cBaseReply {
	/*
	**	The image-paths API provide a list of image paths for the various CLS REST API clients.
	**
	**	The $totPaths will have a count of all the imagePath objects in our list.
	**	The $allImagePathsList will be a list of all the imagePath objects.
	**
	**	These are protected, because we do NOT want them all returned to the client.
	**	Instead, based on what the client requests (via the path), we will return
	**	the requested imagePath object(s).
	*/
	protected $totPaths;
    protected $allImagePathsList;
    
    public function __construct(){
    	/*
    	**	First invoke the base class constructor by passing in our apiVer object.
    	*/
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_IMAGE_PATHS_NAME,CLSRESTAPI_VER_IMAGE_PATHS_API,CLSRESTAPI_VER_IMAGE_PATHS_DATA));
		/*
		**	Now construct the allImagePathsList array by loading all of the well known ImagePaths into it.
		**	Store the total count in $totPaths, and then initialize the apiObj, which will
		**	contain the specific apiVer object(s) requested.
		*/
        $this->allImagePathsList = Array();
        $this->allImagePathsList[] = new cImagePath("JavaDesktop",      "/images/jdt/");
        $this->allImagePathsList[] = new cImagePath("iOS",              "/images/iOS/");
        $this->allImagePathsList[] = new cImagePath("JavaAndroid",      "/images/jaos/");
        $this->allImagePathsList[] = new cImagePath("KotlinAndroid",    "/images/kaos/");
        
        $this->totPaths = count($this->allImagePathsList);

        $this->apiObj->numPaths = 0;
        $this->apiObj->imagePaths = Array();
    }
    
    public function addImagePath($imagePath){
    	/*
    	**	Add a specific imagePath object to our list of objects being returned.
    	*/
        $this->apiObj->imagePaths[] = $imagePath;
        $this->apiObj->numPaths++;
    }
    
    public function getImagePath($clientID){
    	/*
    	**	Return an imagePath object based on the clientID passed in.
    	**
    	**	If the clientID is not in our list, return NULL.
    	*/
        for($i = 0; $i < $this->totPaths; ++$i){
            if (!strcasecmp($clientID,$this->allImagePathsList[$i]->clientID)){
                return $this->allImagePathsList[$i];
            }
        }
        return NULL;
    }
    
    public function addAllImagePaths(){
    	/*
    	**	Return ALL of the imagePath objects to our client.
    	*/
        $this->apiObj->imagePaths = $this->allImagePathsList;
        $this->apiObj->numPaths = $this->totPaths;
    }
}

function addImagePathsToReply($imagePathsReply, $which="*")
{
	/*
	**	Initialize the return object with the requested imagePaths object(s)
	*/
    if ($which != "*"){
    	/*
    	**	$which is '*' when only a single path element is present (or if the
    	**	client passes '*' for that path element (if supported).
    	**
    	**	If $which is NOT '*', then attempt a lookup on the requested clientID.
    	*/
        $imagePath = $imagePathsReply->getImagePath($which);
        
        if( $imagePath != NULL ){
        	/*
        	**	Return the specific imagePath object requested.
        	*/
            $imagePathsReply->addImagePath($imagePath);
            return;
        }
        /*
        **	If $version is NULL, then that clientID was not found. Return them all.
        */
    }
    /*
    **	Return all of the apiVer objects.
    */
    $imagePathsReply->addAllImagePaths();
}

function returnImagePaths()
{
	/*
	**	First, instantiate a cImagePathsReply object.
	**	Then, look at the path and determine what apiVer objects to return.
	*/
    $imagePathsReply = new cImagePathsReply();

    if( $imagePathsReply->parseOK() ){    
		/*
		**	Check to make sure we parsed the path correctly
		*/
        if( 2 == $imagePathsReply->numRestApiKeys()) {
			/*
			**	If exactly 2 elements are present, then get the second element and
			**	return that specific imagePath object. For example:
			**
			**	GET http://api.cloudylogic.com/image-paths/jdt/
			**
			**	Return the 'jdt' image path object only.
			*/
            addImagePathsToReply($imagePathsReply,$imagePathsReply->getRestApiKey(1));    
        } else {
        	/*
        	**	Either GET http://api.cloudylogic.com/image-paths/ was invoked, or the
        	**	user passed more than 2 elements in the path.
        	**
        	**	Return ALL of the imagePath objects.
        	*/
            addImagePathsToReply($imagePathsReply);    
        }
    }
    /*
    **	Encode the object in JSON format and return that string.
    */
	$jsonReply = trim(json_encode($imagePathsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

// Tell the caller that the type of the return data is application/json
header('Content-Type: application/json');

// Write the JSON encoded object as the document data
echo returnImagePaths();

?>
