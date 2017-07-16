<?php

class cBaseReply {
    public $debugInfo;
    public $apiVer;
    
    public function __construct($apiVer){
        $this->apiVer = $apiVer;
        $this->debugInfo = new StdClass();
        $this->debugInfo->traceMsgQ = Array();
        $this->debugInfo->parseOK = true;
        $this->debugInfo->request_uri = $_SERVER["REQUEST_URI"];
        $this->debugInfo->query_string = $_SERVER["QUERY_STRING"];
        $this->debugInfo->restAPIkeys = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);
        $apiNameFromUri = $this->debugInfo->restAPIkeys[0];
        $apiNameFromVerObj = $apiVer->apiName;
        if (count($this->debugInfo->restAPIkeys) < 1 || strcasecmp($apiNameFromUri,$apiNameFromVerObj)){
            $this->debugInfo->parseOK = false;
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
    	$this->debugInfo->traceMsgQ[] = $msg;
    }

    public function parseOK(){
        return $this->debugInfo->parseOK;
    }

    public function numRestApiKeys(){
        return count($this->debugInfo->restAPIkeys);
    } 
    
    public function getRestApiKey($which){
        if( $which < count($this->debugInfo->restAPIkeys) ){
            return $this->debugInfo->restAPIkeys[$which];
        }
        return NULL;
    } 
} 


?>
