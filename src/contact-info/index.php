<?php

include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cSocialMedia {
	public $network;
	public $id;
	public $url;
	
	public function __construct($network, $id, $url){
		$this->network = $network;
		$this->id = $id;
		$this->url = $url;
	}
}

class cContactInfoReply extends cBaseReply {
    public $apiObj;

	public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_CONTACT_INFO_NAME,CLSRESTAPI_VER_CONTACT_INFO_API,CLSRESTAPI_VER_CONTACT_INFO_DATA));

        $this->apiObj = new StdClass();
		
		$this->apiObj->location = "Cloudy Logic Studios is located between San Antonio and Austin Texas.";

		$this->apiObj->address = new StdClass();
		$this->apiObj->address->name = "Cloudy Logic Studios";
		$this->apiObj->address->street = "8190 Bindseil Ln";
		$this->apiObj->address->city = "San Antonio";
		$this->apiObj->address->state = "TX"; 
		$this->apiObj->address->zipcode = "78266";
				   
		$this->apiObj->email = "info@cloudylogic.com";
		
		$this->apiObj->phone = "512.710.7257";
		
		$this->apiObj->socialNetworks = Array();
		$this->apiObj->socialNetworks[] = new cSocialMedia("Facebook", "cloudylogic", "https://www.facebook.com/cloudylogic");
		$this->apiObj->socialNetworks[] = new cSocialMedia("Twitter", "cloudylogic", "https://twitter.com/cloudylogic");
		$this->apiObj->socialNetworks[] = new cSocialMedia("Vimeo", "cloudylogic", "https://vimeo.com/cloudylogic");
	}
}

function returnContactInfo()
{
    $contactInfoReply = new cContactInfoReply();
    
	$jsonReply = trim(json_encode($contactInfoReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');
echo returnContactInfo($request->reqKeys);

?>
