<?php

class RequestForm extends CFormModel
{
  public $part_id = "302060";  
  
  public function rules() {
    return array(			
      array('part_id', 'required','message'=>'Заполните поле Артикул'),
    );
  }
	
}
