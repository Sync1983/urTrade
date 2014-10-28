<?php

class ProviderList extends CModel {
    public $id;
    protected $provider_list;
    
    public function attributeNames() {
        return array('id');
    }
	
	/** @return Provider */
	public function getProviderByCLSID($clsid){
	  return isset($this->provider_list[$clsid])?$this->provider_list[$clsid]:false;
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
	
	public function getPart($provider,$uid,$part_id,$maker_id){
	  if(!isset($this->provider_list[$provider])) {
		return FALSE;
	  }
	  /* @var $selected_provider Provider */
	  $selected_provider = $this->provider_list[$provider];
	  return $selected_provider->loadPart($uid,$part_id,$maker_id);	  
	}

	public function getPartList(RequestParts $model) {	  
	  $maker	= $model->maker;
	  $part_id	= $model->part_id;
	  
	  if(is_array($maker)){
		return null;
	  }	  
	  
	  $list = array();
	  
	  foreach ($this->provider_list as $provider) {
		$producers = $provider->loadPartProducer($part_id);
		if(isset($producers[$maker])) {		  
		  $list = array_merge($list, $provider->LoadPartList($part_id,$producers[$maker]));
		}
	  }
	  //usort($list, array(get_class($this),'sortByProducer'));
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
	
	public function getFileProvider(){
	  $answer = array();	
	  foreach ($this->provider_list as $CLSID=>$provider) {
		/* @var $provider Provider */
		if ($provider->isFile()) {
		  $answer[$CLSID] = $provider;
		}
	  }
	  return $answer;
	}

	protected function sortByProducer($A,$B) {
	  if($A->producer>$B->producer) {
		return 1;
	  } elseif($A->producer<$B->producer) {
		return -1;
	  }
		return 0;	  
	}
    
}

