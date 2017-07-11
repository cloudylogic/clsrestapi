<?php

include_once ("data.php");

function returnReels($req){
    
    $videoList = getVideoList();
    $videos = Array();

    for( $start = 0; $start < $videoList->totalVideos(); ++$start ){
        $vid = $videoList->getNextVideo($start);

        $videos[] = $vid->getTitle();
    }
    
    $x = [$_SERVER["REQUEST_URI"], $_SERVER["QUERY_STRING"],$req];  //REQUEST_URI
    
	$mystr = trim(json_encode([$x,$videos],JSON_HEX_APOS),'"');		//JSON_HEX_TAG doesn't seem to matter...
	//echo "[$mystr]\n\n";
	return $mystr;
//	return str_replace("\n","\\n",htmlspecialchars($htmlStr,ENT_QUOTES|ENT_HTML401,null,false));
}

function returnLatestReel()
{
	$mystr = trim(json_encode(["latest reel"],JSON_HEX_APOS),'"');		//JSON_HEX_TAG doesn't seem to matter...
	return $mystr;
}

function returnSpecificReel($which)
{
	$mystr = trim(json_encode(["specific reel", $which],JSON_HEX_APOS),'"');		//JSON_HEX_TAG doesn't seem to matter...
	return $mystr;
}

header('Content-Type: application/json');

$request = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);

if (2 == count($request)){
    if ($request[1] == "0") {
        echo returnLatestReel();
    } else {
        echo returnSpecificReel($request[1]);
    }
} else {
    echo returnReels($request);
}
?>