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
	
	public function getName() {
	  return 'root';
	}

	public function loadPart($uid,$part_id,$maker_id) {
        throw new Exception("Use parent method");
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
	
	protected function loadHashPart($name,$item){
	  return $this->_cache->hget($name,$item);
	}

	protected function saveCache($name,$part,$value,$time_sec = 0){
	  $this->_cache->hset($name, $part, json_encode($value));
	  if($time_sec>0) {
		$this->_cache->expire($name,$time_sec);
	  }
	}
  
  protected function clearPartId($part_id) {
    /*$part_id = str_replace(" ", "", $part_id);
    $part_id = str_replace(".", "", $part_id);
    $part_id = str_replace("-", "", $part_id);*/
    return preg_replace("/[^a-zA-Z0-9\s]/", "", $part_id);
    //return $part_id;
  }
}

