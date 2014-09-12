<?php

class RequestForm extends CFormModel
{
  public $part_id = "302060";
  public $object;
  protected $answer;
  protected $filters = array();
  protected $sort = array();
  protected $producer = array();
  protected $providers = array();
  
  public function __construct() {
      $this->providers = array();
      $providers = Yii::app()->params['providers_data'];      
      foreach ($providers as $name=>$params) {          
          $class = "Provider".$name;          
          if(!class_exists($class,true))
              continue;          
          $data = $params;
          unset($data['login']) ;
          unset($data['pass']);
          $provider = new   $class($params['login'],$params['pass'],$data);
          if(!$provider)
              continue;          
          $this->providers[$name]=$provider;
      }      
  }

  public function rules() {
    return array(			
      array('part_id', 'required','message'=>'Заполните поле Артикул'),
    );
  }
  
  public function getAnswer(){
    return $this->answer;
  }
  
  public function getFilters(){
    return json_encode($this->filters);
  }
  
  public function getProducer(){
    return $this->producer;
  }
  
  public function setPartID($part_id) {
    $this->part_id = $part_id;
  }
  
  public function setFilter($filter) {
    $this->filters = json_decode($filter);
  }
  
  public function setSort($sort) {
    $this->sort = json_decode($sort,true);
  }
  
  public function data() {
    /*$url = 'http://online.atc58.ru?part_id='.$this->part_id;
		$answer = file_get_contents($url,false);      
		$obj = json_decode($answer, true);        */
    $data = array();
    foreach ($this->providers as  $prov) {
        //$data = array_merge($data,$prov->loadPartProducer($this->part_id));
        $data[] = $prov->loadPartProducer($this->part_id);
    }
    //usort($obj, array('RequestForm','sortTable'));
    return $data;
  }

  public function load_data($part_id,$filter=null, $sort=null) {
    $producer = array();
    $articul = array();
    
    foreach ($obj as $detail) {
      $this->setMinValue($producer, $detail[3], $detail[6]);
      $this->setMinValue($articul, $detail[4], $detail[6]);            
    }
    
    asort($producer);
    asort($articul);    
		
    $this->answer.= "<div class=\"select-panel\"><ul>";
    foreach ($producer as $key=>$value) {
       $this->answer.="<li onClick=\"addFilter('Производитель',3,'$key',true)\">$key { $value }</li>";
    }  
    $this->answer .="</ul></div>";
    
    $this->answer.= "<div class=\"select-panel articul\"><ul>";    
    foreach ($articul as $key=>$value) {
      if($key === $part_id){
        $this->answer.="<li class=\"active\" onClick=\"addFilter('Артикул',4,'$key',true)\">$key {$value}</li>";
      } else {
       $this->answer.="<li onClick=\"addFilter('Артикул',4,'$key',true)\">$key { $value }</li>";
      }
    }  
    $this->answer .="</ul></div>";
  }
	
public function sortTable($itemA,$itemB){
  if(!$this->sort)
    return 0;
  $key = array_keys($this->sort);
  if(!$key)
    return 0;
  $key = $key[0];
  $type = $this->sort[$key];
  if($type>0){
      if($itemA[$key]>$itemB[$key]) {
          return 1;
      }elseif($itemA[$key]<$itemB[$key]) {
          return -1;				
      } else {
          return 0;
      }			
  } else {
      if($itemA[$key]>$itemB[$key]) {
          return -1;
      }elseif($itemA[$key]<$itemB[$key]) {
          return 1;				
      } else {
          return 0;
      }
  }
}

protected function setMinValue(&$array,&$key,&$value){
    $val = floatval($value);
    if(!isset($array[$key])) {
      $array[$key]=$val;
    } elseif($array[$key]>$val){
      $array[$key] = $val;      
    }
}
          
public function inFilter($detail) {
    if(!is_array($detail)||!(is_array($this->filters))){
      return false;
    }    
    foreach ($this->filters as $value) {
      if(!is_object($value)){
        continue;
      }
      $col = intval($value->column);
      if($detail[$col]!=$value->value){
        return FALSE;
      }
    }
    return true;
  }
	
}
