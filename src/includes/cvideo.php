<?php
// This file is covered by the LICENSE file in the root of this project.

class cVideo {
	/*
	**	This class defines a Video object. This contains all the elements needed to
	**	describe a video. Note that everything is public, so that when json_encode()
	**	is called with one of these objects, all the data will be returned (i.e. encoded)
	*/
    public $title;	// The title of the video
    public $url;	// The URL of the video on Vimeo
    public $sUrl;	// The streaming URL of the video on Vimeo
    public $thumb;	// The thumbnail of the video (not yet defined)
    public $frame;	// The frame of the video (not yet defined)
    
    public function __construct($title, $videoID, $streamID, $thumb, $frame){
    	/*
    	**	Initialize the object with the passed parameters
    	**
    	**	$title - The title
    	**	$videoID - The Vimeo video ID (a number)
    	**	$streamID - The Vimeo stream ID (a long number that identifies the video)
    	**	$thumb - This will be the thumbnail -- NOT SURE OF IMPLEMENTATION YET
    	**	$frame - This will be the frame for the video -- NOT SURE OF IMPLEMENTATION YET
    	*/
        $this->title = $title;
        $this->url = "https://vimeo.com/$videoID";
        $this->sUrl = "http://player.vimeo.com/external/$videoID.m3u8?p=high,standard,mobile&amp;s=$streamID";
        $this->thumb = $thumb;
        $this->frame = $frame;
    }
    
    /*
    **	These are the Getters for the object variables. Although all of our instance
    **	data is public so these are not required, I want to use them when accessing the
    **	instance data because that's just a better way to do it. If it weren't for the
    **	fact that json_encode requires things you want encoded to be declared public,
    **	then I would have defined them as private instead.
    */
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
	/*
	**	The cShowcaseVideo class extends the cVideo class by adding a few additional
	**	data elements useful for describing one of the showcase videos.
	*/
    public $type;			// A descriptive 'type' for the video. e.g. "Music Video"
    public $roles;			// A class object that defines the roles. e.g. Director, Editor, etc.
    public $description;	// A long description of the project.
    
    public function __construct($title,$vID, $sID, $type, $thumb, $frame, $ro_dir="", $ro_dp="", $ro_cam="", $ro_ed="", $desc=""){
        /*
        **	Invoke the base class constructor with the passed parameters first.
        */
        parent::__construct($title,$vID,$sID,$thumb,$frame);
		/*
		**	Now assign the additional fields with the specified data
		*/
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
	/*
	**	This class implements a video list. The videoList will contain a list of
	**	demo reel videos for the company.
	**
	**	We won't use this object with json_encode, so we don't have to declare this
	**  as public.
	*/
    protected $videoList;	// An array of all the demo reels
    
    public function __construct(){
    	// Just initialize videoList to an empty array.
        $this->videoList = Array();
    }
    
    public function addVideo($title,$videoID,$streamID="vimeoSID", $thumb="thumbnail", $frame="image-frame"){
        /*
        **	Add a video to the demo reel list.
        */
        $this->videoList[] = new cVideo($title,$videoID,$streamID,$thumb,$frame);
    }
    
    public function totalVideos(){
    	/*
    	**	Return the count of videos in the videoList.
    	*/
    	return count($this->videoList);
    }
    
    public function getNextVideo($start = 0){
    	/*
    	**	An iterator for cycling through the videos in the list.
    	**
    	**	Returns a cVideo object, or NULL if at the end of the list.
    	*/
        if ($start < count($this->videoList))
        	/*
        	**	Return the specified cVideo object.
        	*/
            return $this->videoList[$start];
            
        return NULL;
    }

    public function getVideo($which){
    	/*
    	**	Return the specific video being requested.
    	**
    	**	Returns a cVideo object, or NULL if an invalid index is specified.
    	*/
        if ($which < count($this->videoList))
            return $this->videoList[$which];
        
        return NULL;
    }
}

class cShowcaseVideos extends cVideos {
	/*
	**	The cShowcaseVideos class extends the cVideos class by simply overriding the
	**	addVideo() method to allow the additional items to be specified when new
	**	videos are added to the list.
	*/
    public function addVideo($title, $vID, $sID="vimSID", $type="Generic", $thumb="tn", $frame="fr-img", $ro_dir="Director", $ro_dp="DP", $ro_cam="Camera", $ro_ed="Editor", $desc="Long description"){
        $this->videoList[] = new cShowcaseVideo($title, $vID, $sID, $type, $thumb, $frame, $ro_dir, $ro_dp, $ro_cam, $ro_ed, $desc);
    }
}

?>
