<?php

include_once("../includes/creply.php");

class cContactInfoReply extends cBaseReply {
	public $location;
	public $address;
	public $email;
	public $phone;
	

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
	}
}

function returnContactInfo($reqKeys)
{
    $contactInfoReply = new cContactInfoReply();
    
    $contactInfoReply->setRestAPIKeys($reqKeys);
    
	$jsonReply = trim(json_encode($contactInfoReply,JSON_HEX_APOS|JSON_PRETTY_PRINT),'"');
	return $jsonReply;
}

header('Content-Type: application/json');

$request = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);

echo returnContactInfo($request);
?>