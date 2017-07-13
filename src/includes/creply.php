<?php

class cBaseReply {
    public $debugInfo;
    
    public function __construct(){
        $this->debugInfo = new StdClass();
        $this->debugInfo->request_uri = $_SERVER["REQUEST_URI"];
        $this->debugInfo->query_string = $_SERVER["QUERY_STRING"];
        $this->debugInfo->restAPIkeys = Array();
    }

    public function setRestAPIKeys($keys){
    	$this->debugInfo->restAPIkeys = $keys;
    }
} 


?>
