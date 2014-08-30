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
		
		$answer = "
			<table class='part-table'>
				<tr class='part-table-head'>
					<th>Склад</th>					
					<th>Производитель</th>					
					<th>Артикул</th>
					<th>Наименование</th>
					<th>Цена</th>
					<th>Упаковка</th>
					<th>Срок поставки</th>
					<th>Количество</th>
					<th>Обновление цен</th>					
				</tr>";
    $this->producer = array();
    $articul = array();    
		foreach ($obj as $detail) {
      $this->producer[$detail[3]] = 1;
      $articul[$detail[4]]=1;
      if(!$this->inFilter($detail)) {
        continue;
      }
      $hint = '';
      if($detail[10]!=="") {
        $hint = "*<div class=\"info-hint\"><p>$detail[10]</p></div>";
      }
			$row = "<tr> 
                <td><a href=\"#\" onClick=\"addFilter('Склад',2,'$detail[2]')\">      $detail[2]</a><span class=\"info\">$hint</span></td>
								<td><a href=\"#\" onClick=\"addFilter('Производитель',3,'$detail[3]')\"> $detail[3]</a></td>
								<td><a href=\"#\" onClick=\"addFilter('Артикул',4,'$detail[4]')\">       $detail[4]</a></td>
								<td><a href=\"#\" onClick=\"addFilter('Наименование',5,'$detail[5]')\">  $detail[5]</a></td>
								<td>$detail[6]</td>
								<td>$detail[7]</td>
								<td><a href=\"#\" onClick=\"addFilter('Срок поставки',8,'$detail[8]')\"> $detail[8]</a></td>
								<td></td>
								<td>$detail[9]</td></tr>";
			$answer.= $row;
		}
		$this->producer = array_keys($this->producer);    
    sort($this->producer);    
    $articul = array_keys($articul);
    sort($articul);
    
		$this->answer = $answer."</table>";    
    $this->answer.= "<div class=\"select-panel\"><ul>";
    foreach ($this->producer as $value) {
       $this->answer.="<li onClick=\"addFilter('Производитель',3,'$value')\">$value</li>";
    }  
    $this->answer .="</ul></div>";
    
    $this->answer.= "<div class=\"select-panel articul\"><ul>";
    foreach ($articul as $value) {
      if($value===$part_id){
        $this->answer.="<li class=\"active\" onClick=\"addFilter('Артикул',4,'$value')\">$value</li>";
      } else {
       $this->answer.="<li onClick=\"addFilter('Артикул',4,'$value')\">$value</li>";
      }
    }  
    $this->answer .="</ul></div>";
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