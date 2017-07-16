<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cVersionsReply extends cBaseReply {
	protected $totApis;
    protected $allApiList;

    public $apiObj;
    
    public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_VERSIONS_NAME,CLSRESTAPI_VER_VERSIONS_API,CLSRESTAPI_VER_VERSIONS_DATA));

        $this->allApiList = Array();
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_VERSIONS_NAME,     CLSRESTAPI_VER_VERSIONS_API, 		CLSRESTAPI_VER_VERSIONS_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_REELS_NAME,		CLSRESTAPI_VER_REELS_API, 			CLSRESTAPI_VER_REELS_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_ABOUT_US_NAME,     CLSRESTAPI_VER_ABOUT_US_API, 		CLSRESTAPI_VER_ABOUT_US_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_CONTACT_INFO_NAME, CLSRESTAPI_VER_CONTACT_INFO_API,	CLSRESTAPI_VER_CONTACT_INFO_DATA);
        $this->allApiList[] = new cAPIversion(CLSRESTAPI_VER_OUR_WORK_NAME,     CLSRESTAPI_VER_OUR_WORK_API, 		CLSRESTAPI_VER_OUR_WORK_DATA);
        
        $this->totApis = count($this->allApiList);

        $this->apiObj = new StdClass();        
        $this->apiObj->numApis = 0;
        $this->apiObj->apiList = Array();
    }
    
    public function addApiVersion($api){
        $this->apiObj->apiList[] = $api;
        $this->apiObj->numApis++;
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
        $this->apiObj->apiList = $this->allApiList;
        $this->apiObj->numApis = count($this->apiObj->apiList);
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

function returnVersions()
{
    $versionsReply = new cVersionsReply();

    if( $versionsReply->parseOK() ){    
        if( 2 == $versionsReply->numRestApiKeys()) {
            addVersionsToReply($versionsReply,$versionsReply->getRestApiKey(1));    
        } else {
            addVersionsToReply($versionsReply);    
        }
    }

	$jsonReply = trim(json_encode($versionsReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');
echo returnVersions();

?>
