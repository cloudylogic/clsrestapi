<?php
// This file is covered by the LICENSE file in the root of this project.

/*
**	This file has the implementation of the 'reels' API for the CLS REST API
*/

include_once("../includes/versions.php");
include_once("../includes/creply.php");
include_once ("reeldata.php");

class cReelsReply extends cBaseReply {
	/*
	**	The reels API provide a list of demo reels for the company.
	*/
    public function __construct(){
    	/*
    	**	First invoke the base class constructor by passing in our apiVer object.
    	*/
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_REELS_NAME,CLSRESTAPI_VER_REELS_API,CLSRESTAPI_VER_REELS_DATA));
		/*
		**	Now just initialize our API specific data elements. The actual data to
		**	be returned will be added later.
		*/
        $this->apiObj = new StdClass();
        $this->apiObj->numReels = 0;
        $this->apiObj->reelList = Array();   
    }

	public function addReel($vid){
		/*
		**	Add a demo reel video to the list and increment the counter.
		*/
		$this->apiObj->reelList[] = $vid;
		$this->apiObj->numReels++;
	}
}

function addReelsToReply($reelsReply, $videoList, $which=-1)
{
	/*
	**	Initialize the return object with the requested demo reel videos
	*/
    if ($which != -1){
    	/*
    	**	A specific demo reel is being requested.
    	*/
        $vid = $videoList->getVideo((int)$which);
        
        if ($vid != NULL){
        	/*
        	**	Add the requested demo reel video to the list and return.
        	*/
            $reelsReply->addReel($vid);
            return;
        }
        /*
        **	The specified demo reel does not exist. Just return them all.
        */
    }
    /*
    **	Return all of the demo reel videos to the client.
    */
    for( $start = 0; $start < $videoList->totalVideos(); ++$start ){
        $vid = $videoList->getNextVideo($start);

        $reelsReply->addReel($vid);
    }    
}

function returnReels()
{
	/*
	**	First, initialize the full list of showcase videos.
	**	Next, instantiate a cReelsReply object.
	**	Finally, look at the path and determine what demo reel videos to return.
	*/
    $videoList = getDemoReels();
    $reelsReply = new cReelsReply();
    
    if( $reelsReply->parseOK() ){
		/*
		**	Check to make sure we parsed the path correctly
		*/
        if( 2 == $reelsReply->numRestApiKeys()){
			/*
			**	If exactly 2 elements are present, then get the second element and
			**	return that specific showcase video. For example:
			**
			**	GET http://api.cloudylogic.com/reels/0/
			**
			**	Return the 1st item in the list of demo reel videos only.
			*/
            addReelsToReply($reelsReply,$videoList,$reelsReply->getRestApiKey(1));
        } else {
        	/*
        	**	Either GET http://api.cloudylogic.com/reels/ was invoked, or the
        	**	user passed more than 2 elements in the path.
        	**
        	**	Return ALL of the demo reel videos.
        	*/
            addReelsToReply($reelsReply,$videoList);
        }
    }
    /*
    **	Encode the object in JSON format and return that string.
    */        
	$jsonReply = trim(json_encode($reelsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

// Tell the caller that the type of the return data is application/json
header('Content-Type: application/json');

// Write the JSON encoded object as the document data
echo returnReels();

?>
