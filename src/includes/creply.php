<?php

class cBaseReply {
    public $dbgObj;
    public $apiVer;
    
    public function __construct($apiVer){
        $this->apiVer = $apiVer;
        $this->dbgObj = new StdClass();
        $this->dbgObj->traceMsgQ = Array();
        $this->dbgObj->parseOK = true;
        $this->dbgObj->request_uri = $_SERVER["REQUEST_URI"];
        $this->dbgObj->query_string = $_SERVER["QUERY_STRING"];
        $this->dbgObj->restAPIkeys = preg_split('/\//',$_SERVER["REQUEST_URI"],-1,PREG_SPLIT_NO_EMPTY);
        $apiNameFromUri = $this->dbgObj->restAPIkeys[0];
        $apiNameFromVerObj = $apiVer->apiName;
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
        return $this->dbgObj->parseOK;
    }

    public function numRestApiKeys(){
        return count($this->dbgObj->restAPIkeys);
    } 
    
    public function getRestApiKey($which){
        if( $which < count($this->dbgObj->restAPIkeys) ){
            return $this->dbgObj->restAPIkeys[$which];
        }
        return NULL;
    } 
} 


?>
