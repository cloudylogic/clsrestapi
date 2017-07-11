<?php

class cVideo {
    protected $title;
    protected $id;
    
    public function __construct($title, $id){
        $this->title = $title;
        $this->id = $id;
    }
    
	public function getTitle(){
		return $this->title;
	}
	
	public function getID(){
	    return $this->id;
	}
}

class cVideos{
    protected $videoList;
    
    public function __construct(){
        $this->videoList = Array();
    }
    
    public function addVideo($title,$id){
        $this->videoList[] = new cVideo($title,$id);
    }
    
    public function totalVideos(){
    
    	return count($this->videoList);
    }
    
    public function getNextVideo($start = 0){
        if ($start < count($this->videoList))
            return $this->videoList[$start];
            
        return NULL;
    }

    public function getVideo($which){
        if ($which < count($this->videoList))
            return $this->videoList[$which];
            
        return NULL;
    }
        
    public function allVideos($callback)
    {
    	for( $i = 0; $i < count($this->videoList); ++$i ){
    		call_user_func($callback, $this->videoList[$i]);
    	}
    }
}

$gb_videos = new cVideos;

$gb_videos->addVideo(          "Latest Demo Reel", "70368527");
$gb_videos->addVideo(            "2014 Demo Reel", "70368527");
$gb_videos->addVideo(            "2011 Demo Reel", "70368527");

function foreachVideo($callback)
{
	global $gb_videos;
	$gb_videos->allVideos($callback);
}

function getVideoCount()
{
    global $gb_videos;
    
    return count($gb_videos);
}

function getVideoList()
{
    global $gb_videos;
    
    return $gb_videos;
}


?>