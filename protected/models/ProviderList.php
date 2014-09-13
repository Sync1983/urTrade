<?php

class ProviderList extends CModel {
    public $id;
    protected $provider_list;
    
    public function attributeNames() {
        return array('id');
    }

    public function __construct() {
      $this->provider_list  = array();
	  $providers = Yii::app()->params['providers_data'];      
      foreach ($providers as $name=>$params) {          
		$class = "Provider".$name;          
        if(class_exists($class,true)){		  
          $data = $params;
		  unset($data['login']) ;
		  unset($data['pass']);            
		  $provider = new   $class($params['login'],$params['pass'],$data);
		  if($provider!=NULL) {      
			$this->provider_list[$name]=$provider;
		  }
		}          
      }   
    }
    
    public function getProducers($part_id) {
	  $answer = array();
	  $list = array();
	  foreach ($this->provider_list as $provider) {
		$list[] = $provider->loadPartProducer($part_id);
	  }
	  foreach ($list as $item){
		foreach ($item as $name => $obj) {
		  if(!isset($answer[$obj->name])) {
			$answer[$obj->name]	= array();
		  }
		  $answer[$obj->name][] = array($obj->producer=>$obj->id);		  
		}
	  }
	  return $answer;
    }    
    
}

