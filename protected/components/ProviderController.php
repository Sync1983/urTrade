<?php

class ProviderController extends Controller {
    protected $_login = "";
    protected $_pass = "";
    protected $_cache;
    
    const ProducerPrefix    =   "producers";

    public function __construct($login, $password,$data=null) {
        $this->_login = $login;
        $this->_pass = $password;
        foreach($data as $key=>$value) {
            $param = "_".$key;
            $this->$param = $value;
        }        
        $this->_cache = Yii::app()->cache;
    }
    
    public function loadPartList($part_id) {
        throw new Exception("Use parent method");
    }
    
    public function loadPartProducer($part_id) {
        
    }    
}

