<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");
include_once ("reeldata.php");

class cReelsReply extends cBaseReply {
	public $apiObj;
    
    public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_REELS_NAME,CLSRESTAPI_VER_REELS_API,CLSRESTAPI_VER_REELS_DATA));

        $this->apiObj = new StdClass();
        $this->apiObj->numReels = 0;
        $this->apiObj->reelList = Array();   
    }

	public function addReel($vid){
		$this->apiObj->reelList[] = $vid;
		$this->apiObj->numReels++;
	}
}

function addReelsToReply($reelsReply, $videoList, $which=-1)
{
    if ($which != -1){
        $vid = $videoList->getVideo((int)$which);
        
        if ($vid != NULL){
            $reelsReply->addReel($vid);
            return;
        }
    }
    for( $start = 0; $start < $videoList->totalVideos(); ++$start ){
        $vid = $videoList->getNextVideo($start);

        $reelsReply->addReel($vid);
    }    
}

function returnReels()
{
    $videoList = getDemoReels();
    $reelsReply = new cReelsReply();
    
    if( $reelsReply->parseOK() ){
        if( 2 == $reelsReply->numRestApiKeys()){
            addReelsToReply($reelsReply,$videoList,$reelsReply->getRestApiKey(1));
        } else {
            addReelsToReply($reelsReply,$videoList);
        }
    }
    
	$jsonReply = trim(json_encode($reelsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');
echo returnReels();

?>
