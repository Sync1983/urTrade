<?php

class RequestParts	extends CFormModel
{
  public $part_id;  
  public $maker;  
  public $cross;  
  public $price_add;  
  
  public function rules() {
    return array(			
      array('part_id', 'required','message'=>'Заполните поле Артикул'),	  
	  array('maker', 'required','message'=>'Укажите производителя')
    );
  }
	
}
