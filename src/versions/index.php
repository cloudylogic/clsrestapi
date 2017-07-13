<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");

//TODO: Seems like the apiVersion info needs to be kept with the actual api
//		so that it's more likely to be kept up to date when things are changed.

class cVersionsReply extends cBaseReply {
	protected $totApis;
    protected $allApiList;

	public $numApis;
    public $apiList;
    
    public function __construct(){
		parent::__construct();

        $this->allApiList = Array();
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_VERSIONS_NAME,     CLSRESTAPI_VER_VERSIONS_API, 		CLSRESTAPI_VER_VERSIONS_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_REELS_NAME,		CLSRESTAPI_VER_REELS_API, 			CLSRESTAPI_VER_REELS_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_ABOUT_US_NAME,     CLSRESTAPI_VER_ABOUT_US_API, 		CLSRESTAPI_VER_ABOUT_US_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_CONTACT_INFO_NAME, CLSRESTAPI_VER_CONTACT_INFO_API,	CLSRESTAPI_VER_CONTACT_INFO_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,     CLSRESTAPI_VER_OUR_WORK_API, 		CLSRESTAPI_VER_OUR_WORK_DATA);
        
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
        $this->numApis = count($this->apiList);
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