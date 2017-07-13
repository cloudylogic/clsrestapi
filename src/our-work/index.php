<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");
include_once ("videodata.php");

class cVideosReply extends cBaseReply {
	public $apiVer;
	public $numVideos;
	public $videoList;
    
    public function __construct(){
		parent::__construct();

		$this->apiVer = new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,CLSRESTAPI_VER_OUR_WORK_API,CLSRESTAPI_VER_OUR_WORK_DATA);
        $this->numVideos = 0;
        $this->videoList = Array();
    }

	public function addVideo($vid){
		$this->videoList[] = $vid;
		$this->numVideos++;
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

function returnVideos($reqKeys)
{
    $videoList2 = getShowcaseVideos();
    $videosReply = new cVideosReply();
    
    $videosReply->setRestAPIKeys($reqKeys);

    if( 2 == count($reqKeys)){
        addVideosToReply($videosReply,$videoList2,$reqKeys[1]);
    } else {
        addVideosToReply($videosReply,$videoList2);
    }
    
	$jsonReply = trim(json_encode($videosReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');

$request = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);

//TODO: SHOULD WE CHECK THAT REQUEST[0] == CLSRESTAPI_VER_OUR_WORK_NAME?
echo returnVideos($request);
?>