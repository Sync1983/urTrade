<?php

class RequestForm extends CFormModel
{
	public $part_id = "302060";
	public $object;
  protected $answer;
  protected $filters = array();
  protected $producer = array();

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
  
  public function data() {
    $url = 'http://online.atc58.ru?part_id='.$this->part_id;
		$answer = file_get_contents($url,false);      
		$obj = json_decode($answer, true);    
    /*if($filter) {
      $this->filters = json_decode($filter);      
    }*/
    
    return $obj;
  }

  public function load_data($part_id,$filter=null) {
		$obj = array();
    if($filter) {
      $this->filters = json_decode($filter);      
    }
		if(($part_id==$this->part_id)&&($this->object)) {
			$obj = $this->object;      
		} else {
			$url = 'http://online.atc58.ru?part_id='.$part_id;
			$answer = file_get_contents($url,false);      
			$obj = json_decode($answer, true);
			$this->object = $obj;
		}
		$this->part_id = $part_id;
		
		$answer = $this->addHtmlTableHead();
            
    $producer = array();
    $articul = array();    
    
		foreach ($obj as $detail) {
      $this->setMinValue($producer, $detail[3], $detail[6]);
      $this->setMinValue($articul, $detail[4], $detail[6]);      
      if(!$this->inFilter($detail))
        continue;
      $answer.= $this->addHtmlTableRow($detail);      
		}
    
		$this->answer = $answer."</table>";    
    
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
  
  
  protected function addHtmlTableRow($detail) {
    $hint = '';
    if($detail[10]!=="") {
      $hint = "<span class=\"info\">*<div class=\"info-hint\"><p>$detail[10]</p></div></span>";
    }
    $shiping = Yii::app()->user->convertShiping($detail[8]);
    $price = Yii::app()->user->convertPrice($detail[6]);
		return "<tr> 
      <td><a href=\"#\" onClick=\"addFilter('Склад',2,'$detail[2]')\">$detail[2]</a>$hint</td>
			<td><a href=\"#\" onClick=\"addFilter('Производитель',3,'$detail[3]')\"> $detail[3]</a></td>
			<td class=\"center\"><a href=\"#\" onClick=\"addFilter('Артикул',4,'$detail[4]')\">       $detail[4]</a></td>
			<td class=\"center\"><a href=\"#\" onClick=\"addFilter('Наименование',5,'$detail[5]')\">  $detail[5]</a></td>
			<td class=\"center\">$price</td>
			<td class=\"center\">$detail[7]</td>
			<td class=\"center\"><a href=\"#\" onClick=\"addFilter('Срок поставки',8,'$shiping')\"> $shiping</a></td>
			<td class=\"center\"><div onClick=\"addToBasket('".json_encode($detail)."');\" class=\"basket\">&nbsp</div></td>
			<td class=\"right\">$detail[9]</td></tr>";			
  }

  protected function setMinValue(&$array,&$key,&$value){
    $val = floatval($value);
    if(!isset($array[$key])) {
      $array[$key]=$val;
    } elseif($array[$key]>$val){
      $array[$key] = $val;      
    }
  }

    protected function inFilter($detail) {
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