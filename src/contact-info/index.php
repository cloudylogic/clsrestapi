<?php
// This file is covered by the LICENSE file in the root of this project.

/*
**	This file has the implementation of the 'contact-info' API for the CLS REST API
*/
include_once("../includes/versions.php");
include_once("../includes/creply.php");

class cSocialMedia {
	/*
	**	This class exposes a social media network.
	**
	**	As previously noted, all object that that you want to be encoded by JSON 
	**	must be declared public.
	*/
	public $network;	// The network name: e.g. Facebook
	public $id;			// The social media ID for CLS on this network: e.g. cloudylogic
	public $url;		// The URL for CLS on the network: e.g. https://facebook.com/cloudylogic
	/*
	**	Initialize the object with the passed parameters
	*/
	public function __construct($network, $id, $url){
		$this->network = $network;
		$this->id = $id;
		$this->url = $url;
	}
}

class cContactInfoReply extends cBaseReply {
	/*
	**	The contact-info API defines all of the contact information for the company.
	*/
	public function __construct(){
		parent::__construct(new cAPIversion(CLSRESTAPI_VER_CONTACT_INFO_NAME,CLSRESTAPI_VER_CONTACT_INFO_API,CLSRESTAPI_VER_CONTACT_INFO_DATA));
		
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
	/*
	**	Instantiate a cContactInfoReply object and we're done.
	*/
    $contactInfoReply = new cContactInfoReply();
    /*
    **	Encode the object in JSON format and return that string.
    */    
	$jsonReply = trim(json_encode($contactInfoReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

// Tell the caller that the type of the return data is application/json
header('Content-Type: application/json');

// Write the JSON encoded object as the document data
echo returnContactInfo($request->reqKeys);

?>
