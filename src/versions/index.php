<?php

include_once("../includes/creply.php");

class cAPIversion {
    public $apiName;
    public $apiVersion;
    public $apiDataVersion;
    
    public function __construct($apiName,$apiVersion,$apiDataVersion){
        $this->apiName = $apiName;
        $this->apiVersion = $apiVersion;
        $this->apiDataVersion = $apiDataVersion;
    }
}

class cVersionsReply extends cBaseReply {
	protected $totApis;
    protected $allApiList;

	public $numApis;
    public $apiList;
    
    public function __construct(){
		parent::__construct();

        $this->allApiList = Array();
        $this->allApiList[] = new cAPIversion("versions",      "1.0", "1.0");
        $this->allApiList[] = new cAPIversion("reels",         "1.0", "1.0");
        $this->allApiList[] = new cAPIversion("about-us",      "1.0", "1.0");
        $this->allApiList[] = new cAPIversion("contact-info",  "1.0", "1.0");
        $this->allApiList[] = new cAPIversion("our-work",      "1.0", "1.0");
        
        $this->totApis = count($this->allApiList);
        
        $this->numApis = 0;
        $this->apiList = Array();
    }
    
    public function addApiVersion($api){
        $this->apiList[] = $api;
        $this->numApis++;
    }
    
    public function getApiVersion($apiName){
        for($i = 0; $i < $this->totApis; ++$i){
            if (!strcasecmp($apiName,$this->allApiList[$i]->apiName)){
                return $this->allApiList[$i];
            }
        }
        return NULL;
    }
    
    public function addAllApiVersions(){
        $this->apiList = $this->allApiList;
    }
}

function addVersionsToReply($versionsReply, $which="*")
{
    if ($which != "*"){
        $version = $versionsReply->getApiVersion($which);
        
        if( $version != NULL ){
            $versionsReply->addApiVersion($version);
            return;
        }
    }
    $versionsReply->addAllApiVersions();
}

function returnVersions($reqKeys)
{
    $versionsReply = new cVersionsReply($_SERVER["REQUEST_URI"], $_SERVER["QUERY_STRING"]);
    
    $versionsReply->setRestAPIKeys($reqKeys);
    
    if( 2 == count($reqKeys)){
        addVersionsToReply($versionsReply,$reqKeys[1]);    
    } else {
        addVersionsToReply($versionsReply);    
    }
    
	$jsonReply = trim(json_encode($versionsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');

$request = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);

echo returnVersions($request);
?>