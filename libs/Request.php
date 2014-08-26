<?php

class Request{
    private $query_params;
    
    private static $instance;
    
    private function __construct(){
        
    }
    
    /**
     * @return Request
     */
    static public function instance(){
        if(!isset(static::$instance)){
            static::$instance = new self();
        }
        
        return static::$instance;
    }
            
    public function getQueryParams(){
        if(!isset($this->query_params)){
            $parts = explode('&', $_SERVER['QUERY_STRING']);

            $this->query_params = array();
            foreach($parts as $part){
                $tmp = explode('=', $part);
                $this->query_params[$tmp[0]] = trim(urldecode($tmp[1]));
            }
        }
        
        return $this->query_params;
    }    
    
    public function getQuerySingleParam($name, $default = NULL){
        $qparams = $this->getQueryParams();
        
        if(isset($qparams[$name])){
            return $qparams[$name];
        }
        
        return $default;
    }
    
    
    public function isMethod($method){
        return ($_SERVER['REQUEST_METHOD'] == $method);
    }
    
}