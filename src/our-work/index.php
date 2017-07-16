<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");
include_once ("videodata.php");

class cVideosReply extends cBaseReply {
	//public $apiVer;
	public $apiObj;
 
    public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,CLSRESTAPI_VER_OUR_WORK_API,CLSRESTAPI_VER_OUR_WORK_DATA));

		//$this->apiVer = new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,CLSRESTAPI_VER_OUR_WORK_API,CLSRESTAPI_VER_OUR_WORK_DATA);
		$this->apiObj = new StdClass();
        $this->apiObj->numVideos = 0;
        $this->apiObj->videoList = Array();
    }

	public function addVideo($vid){
		$this->apiObj->videoList[] = $vid;
		$this->apiObj->numVideos++;
	}
}

function addVideosToReply($videosReply, $videoList2, $which=-1)
{
    if ($which != -1){
        $vid = $videoList2->getVideo((int)$which);
        
        if ($vid != NULL){
            $videosReply->addVideo($vid);
            return;
        }
    }
    for( $start = 0; $start < $videoList2->totalVideos(); ++$start ){
        $vid = $videoList2->getNextVideo($start);

        $videosReply->addVideo($vid);
    }    
}

function returnVideos()
{
    $videoList2 = getShowcaseVideos();
    $videosReply = new cVideosReply();
    
    if( $videosReply->parseOK() ){
        if( 2 == $videosReply->numRestApiKeys()){
            addVideosToReply($videosReply,$videoList2,$videosReply->getRestApiKey(1));
        } else {
            addVideosToReply($videosReply,$videoList2);
        }
    }
    
	$jsonReply = trim(json_encode($videosReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');
echo returnVideos();

?>
