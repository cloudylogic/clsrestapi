<?php
// This file is covered by the LICENSE file in the root of this project.

class cBaseReply {
	/*
	**	This class provides the common elements that all CLS REST APIs use.
	*/
    public $dbgObj;		// Encapsulates all the debug related items
    public $apiVer;		// Each API has an embedded version object
    /*
    **	apiObj encapsulates the API specific data. It is defined here
    **	and initialized to an empty StdClass() object, and then each
    **	derived class provides the specific implementation details for it.
    */
    public $apiObj;
    
    public function __construct($apiVer){
    	/*
    	**	The caller passes in the apiVer object to us. That way, they have 
    	**	the version data in front of them, and will be more likely to update
    	**	it when it changes.
    	*/
        $this->apiVer = $apiVer;
        /*
        **	As previously discussed, just initialize the apiObj to an empty object.
        */
		$this->apiObj = new StdClass();
		/*
		**	Setup the dbgObj object. This contains useful information to assist the
		**	client developer while developing a new app that uses the API.
		*/
        $this->dbgObj = new StdClass();
        $this->dbgObj->traceMsgQ = Array();
        $this->dbgObj->parseOK = true;
        $this->dbgObj->request_uri = $_SERVER["REQUEST_URI"];
        $this->dbgObj->query_string = $_SERVER["QUERY_STRING"];
        $this->dbgObj->restAPIkeys = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);
        $apiNameFromUri = $this->dbgObj->restAPIkeys[0];
        $apiNameFromVerObj = $apiVer->apiName;
        /*
        **	Set the parseOK flag to tell the client whether or not what they passed was
        **	successfully parsed. This should usually succeed, but if you copy/paste this
        **	code into a new API file, and don't follow the specification for naming APIs,
        **	this should catch the issue.
        */
        if (count($this->dbgObj->restAPIkeys) < 1 || strcasecmp($apiNameFromUri,$apiNameFromVerObj)){
            $this->dbgObj->parseOK = false;
            $this->addTraceMessage("Expected API name of '$apiNameFromVerObj' but got '$apiNameFromUri' instead");
        }
    }
    public function addTraceMessage($msg){
		/*
		**	This provides a mechanism for adding queued debug messages to the API instead
		**  of adding random variables with debug strings. From within the class, call it
		**  like this: $this->addTraceMessage("your message here");
		**
		**	From an instance, like this: $instance->addTraceMessage("your msg");
		*/    
    	$this->dbgObj->traceMsgQ[] = $msg;
    }

    public function parseOK(){
    	/*
    	**	Return the parseOK boolean.
    	*/
        return $this->dbgObj->parseOK;
    }

    public function numRestApiKeys(){
    	/*
    	**	Return the number of API keys. i.e. how many path segments there are.
    	**
    	**	For example, if you GET http://api.cloudylogic.com/reels/0/
    	**
    	**	This API will return 2. ['reels', '0'] are the 2 path segments.
    	*/
        return count($this->dbgObj->restAPIkeys);
    } 
    
    public function getRestApiKey($which){
    	/*
    	**	Return the specified API key. i.e. parameter.
    	**
    	**	For example, if you GET http://api.cloudylogic.com/reels/0/
    	**
    	**	And then call: obj->getRestApiKey(1)
    	**
    	**	This API will return '0'. ['reels', '0'] are the 2 path segments, and
    	**	index 1 is the second element.
    	*/
        if( $which < count($this->dbgObj->restAPIkeys) ){
            return $this->dbgObj->restAPIkeys[$which];
        }
        return NULL;
    } 
} 


?>
