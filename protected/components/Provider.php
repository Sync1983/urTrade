<?php

class Provider extends Controller {
    protected $_login = "";
    protected $_pass = "";
    protected $_cache;
	protected $_CLSID =	"";
    
    const ProducerPrefix    =   "producers";
	const PartPrefix		=   "parts";

    public function __construct($login, $password,$data=null) {
        $this->_login = $login;
        $this->_pass = $password;
        foreach($data as $key=>$value) {
            $param = "_".$key;
            $this->$param = $value;
        }        
        $this->_cache = Yii::app()->cache;
    }
    
	public function getCLSID() {
	  return $this->_CLSID;
	}

	public function loadPartList($part_id,$producer=null) {
        throw new Exception("Use parent method");
    }
    
    public function loadPartProducer($part_id) {
        throw new Exception("Use parent method");
    }
	
	protected function loadCache($name){
	  return $this->_cache->hgetall($name);
	}

	protected function saveCache($name,$part,$value,$time = 0){
	  $this->_cache->hset($name, $part, json_encode($value),$time);
	}
}
