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
			$this->provider_list[$provider->getCLSID()]=$provider;
		  }
		}          
      }   
    }
	
	public function getPartList($part_id,$makers) {
	  if(!is_array($makers)) {
		$makers = array($makers);
	  }  
	  $answer = array();
	  $list = array();
	  foreach ($makers as $name) {
		$list[$name] = array();
	  }
	  
	  foreach ($this->provider_list as $provider) {
		$producers = $provider->loadPartProducer($part_id);
		foreach($producers as $name=>$id) {
		  if(!in_array($name, $makers)){
			continue;
		  }
		  $list[$name] = array_merge($list[$name],$provider->LoadPartList($part_id,$id));
		}
	  }
	  return $list;	  
	}

	public function getProducers($part_id) {
	  $answer = array();
	  $list = array();
	  foreach ($this->provider_list as $CLSID=>$provider) {
		$list[$CLSID] = $provider->loadPartProducer($part_id);
	  }
	  foreach ($list as $item){
		foreach (array_keys($item) as $name) {		  
		  $answer[$name] = 1;
		}
	  }
	  ksort($answer);
	  return $answer;
    } 
    
}

