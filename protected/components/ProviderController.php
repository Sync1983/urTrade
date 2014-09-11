<?php

class ProviderController extends Controller {
    private $_login = "";
    private $_pass = "";
    
    public function __construct($login, $password,$data=null) {
        $this->_login = $login;
        $this->_pass = $password;
        foreach($data as $key=>$value) {
            $param = "_".$key;
            $this->$param = $value;
        }
    }
    
    public function loadPartList($part_id) {
        throw new Exception("Use parent method");
    }
    
    public function loadPartProducer($part_id) {
        throw new Exception("Use parent method");
    }    
}

