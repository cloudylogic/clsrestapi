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
	public $location;
	public $address;
	public $email;
	public $phone;
	public $socialNetworks;
	public $apiVer;

	public function __construct(){
		parent::__construct();
		
		$this->location = "Cloudy Logic Studios is located between San Antonio and " .
					"Austin Texas.";

		$this->address = new StdClass();
		$this->address->name = "Cloudy Logic Studios";
		$this->address->street = "8190 Bindseil Ln";
		$this->address->city = "San Antonio";
		$this->address->state = "TX"; 
		$this->address->zipcode = "78266";
				   
		$this->email = "info@cloudylogic.com";
		
		$this->phone = "512.710.7257";
		
		$this->socialNetworks = Array();
		$this->socialNetworks[] = new cSocialMedia("Facebook", "cloudylogic", "https://www.facebook.com/cloudylogic");
		$this->socialNetworks[] = new cSocialMedia("Twitter", "cloudylogic", "https://twitter.com/cloudylogic");
		$this->socialNetworks[] = new cSocialMedia("Vimeo", "cloudylogic", "https://vimeo.com/cloudylogic");
		
		$this->apiVer = new cAPIversion(CLSRESTAPI_VER_CONTACT_INFO_NAME,CLSRESTAPI_VER_CONTACT_INFO_API,CLSRESTAPI_VER_CONTACT_INFO_DATA);

	}
}

function returnContactInfo($reqKeys)
{
    $contactInfoReply = new cContactInfoReply();
    
    $contactInfoReply->setRestAPIKeys($reqKeys);
    
	$jsonReply = trim(json_encode($contactInfoReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

$request = parseAPIparameters(CLSRESTAPI_VER_CONTACT_INFO_NAME);

if( $request->parseOK ){
    echo returnContactInfo($request->reqKeys);
}

?>
