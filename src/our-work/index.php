<?php
// This file is covered by the LICENSE file in the root of this project.

/*
**	This file has the implementation of the 'our-work' API for the CLS REST API
*/

include_once("../includes/versions.php");
include_once("../includes/creply.php");
include_once ("videodata.php");

class cVideosReply extends cBaseReply {
	/*
	**	The our-work API provide a list of showcased videos for the company.
	*/
    public function __construct(){
    	/*
    	**	First invoke the base class constructor by passing in our apiVer object.
    	*/
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,CLSRESTAPI_VER_OUR_WORK_API,CLSRESTAPI_VER_OUR_WORK_DATA));
		/*
		**	Now just initialize our API specific data elements. The actual data to
		**	be returned will be added later.
		*/
		$this->apiObj = new StdClass();
        $this->apiObj->numVideos = 0;
        $this->apiObj->videoList = Array();
    }

	public function addVideo($vid){
		/*
		**	Add a showcase video to the list and increment the counter.
		*/
		$this->apiObj->videoList[] = $vid;
		$this->apiObj->numVideos++;
	}
}

function addVideosToReply($videosReply, $videoList2, $which=-1)
{
	/*
	**	Initialize the return object with the requested showcase videos
	*/
    if ($which != -1){
    	/*
    	**	A specific video is being requested.
    	*/
        $vid = $videoList2->getVideo((int)$which);
        
        if ($vid != NULL){
        	/*
        	**	Add the requested showcase video to the list and return.
        	*/
            $videosReply->addVideo($vid);
            return;
        }
        /*
        **	The specified video does not exist. Just return them all.
        */
    }
    /*
    **	Return all of the showcase videos to the client.
    */
    for( $start = 0; $start < $videoList2->totalVideos(); ++$start ){
        $vid = $videoList2->getNextVideo($start);

        $videosReply->addVideo($vid);
    }    
}

function returnVideos()
{
	/*
	**	First, initialize the full list of showcase videos.
	**	Next, instantiate a cVideosReply object.
	**	Finally, look at the path and determine what showcase videos to return.
	*/
    $videoList2 = getShowcaseVideos();
    $videosReply = new cVideosReply();

    if( $videosReply->parseOK() ){
		/*
		**	Check to make sure we parsed the path correctly
		*/
        if( 2 == $videosReply->numRestApiKeys()){
			/*
			**	If exactly 2 elements are present, then get the second element and
			**	return that specific showcase video. For example:
			**
			**	GET http://api.cloudylogic.com/our-work/3/
			**
			**	Return the 3rd item in the list of showcase videos only.
			*/
            addVideosToReply($videosReply,$videoList2,$videosReply->getRestApiKey(1));
        } else {
        	/*
        	**	Either GET http://api.cloudylogic.com/our-work/ was invoked, or the
        	**	user passed more than 2 elements in the path.
        	**
        	**	Return ALL of the showcase videos.
        	*/
            addVideosToReply($videosReply,$videoList2);
        }
    }
    /*
    **	Encode the object in JSON format and return that string.
    */    
	$jsonReply = trim(json_encode($videosReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

// Tell the caller that the type of the return data is application/json
header('Content-Type: application/json');

// Write the JSON encoded object as the document data
echo returnVideos();

?>
