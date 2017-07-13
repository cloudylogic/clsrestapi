<?php

class cVideo {
    public $title;
    public $url;
    public $sUrl;
    public $thumb;
    public $frame;
    
    public function __construct($title, $videoID, $streamID, $thumb, $frame){
        $this->title = $title;
        $this->url = "https://vimeo.com/$videoID";
        $this->sUrl = "http://player.vimeo.com/external/$videoID.m3u8?p=high,standard,mobile&amp;s=$streamID";
        $this->thumb = $thumb;
        $this->frame = $frame;
    }
    
	public function getTitle(){
		return $this->title;
	}
	
	public function getUrl(){
	    return $this->url;
	}
	
	public function getSurl(){
	    return $this->sUrl;
	}
	
	public function getThumb(){
	    return $this->thumb;
	}
	
	public function getFrame(){
	    return $this->frame;
	}
}

class cShowcaseVideo extends cVideo {
    public $type;
    public $roles;
    public $description;
    
    public function __construct($title,$vID, $sID, $type, $thumb, $frame, $ro_dir="", $ro_dp="", $ro_cam="", $ro_ed="", $desc=""){
        parent::__construct($title,$vID,$sID,$thumb,$frame);

        $this->type = $type;        
        $this->roles = new StdClass();
        $this->roles->director = $ro_dir;
        $this->roles->dp = $ro_dp;
        $this->roles->camera = $ro_cam;
        $this->roles->editor = $ro_ed;
        
        $this->description = $desc;
    }
}

class cVideos{
    protected $videoList;
    
    public function __construct(){
        $this->videoList = Array();
    }
    
    public function addVideo($title,$videoID,$streamID="vimeoSID", $thumb="thumbnail", $frame="image-frame"){
        $this->videoList[] = new cVideo($title,$videoID,$streamID,$thumb,$frame);
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
}

class cShowcaseVideos extends cVideos {
    public function addVideo($title, $vID, $sID="vimSID", $type="Generic", $thumb="tn", $frame="fr-img", $ro_dir="Director", $ro_dp="DP", $ro_cam="Camera", $ro_ed="Editor", $desc="Long description"){
        $this->videoList[] = new cShowcaseVideo($title, $vID, $sID, $type, $thumb, $frame, $ro_dir, $ro_dp, $ro_cam, $ro_ed, $desc);
    }
}

?>