<?php

include_once("../includes/creply.php");
include_once ("reeldata.php");

class cReelsReply extends cBaseReply {
	public $numReels;
	public $reelList;
    
    public function __construct(){
		parent::__construct();

        $this->numReels = 0;
        $this->reelList = Array();
    }

	public function addReel($vid){
		$this->reelList[] = $vid;
		$this->numReels++;
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

function returnReels($reqKeys)
{
    $videoList = getDemoReels();
    $reelsReply = new cReelsReply();
    
    $reelsReply->setRestAPIKeys($reqKeys);

    if( 2 == count($reqKeys)){
        addReelsToReply($reelsReply,$videoList,$reqKeys[1]);
    } else {
        addReelsToReply($reelsReply,$videoList);
    }
    
	$jsonReply = trim(json_encode($reelsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');

$request = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);

echo returnReels($request);
?>