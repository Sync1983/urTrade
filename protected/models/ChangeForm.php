<?php

class ChangeForm extends CFormModel
{
  public $id = "id"; 
  public $state;
  public $is_pay;  
  public $date;  
  public $price;  
  public $user_price;  
  public $change_billing;
  public $count;
  public $count_step;
  
  public function rules() {
    return array(
			array('id','numerical', 'integerOnly' => true),
			array('state','numerical', 'integerOnly' => true),
			array('is_pay','numerical', 'integerOnly' => true),
			array('change_billing','numerical', 'integerOnly' => true),
			array('count','numerical', 'integerOnly' => true),
			array('price','numerical', 'integerOnly' => true),			
			array('date','date'),
    );
  }
  
  public function attributeLabels()
	{
		return array(
			'id'	  =>	'Номер: ',
			'state'	  =>	'Состояние: ',
			'is_pay'  =>	'Оплачено: ',
			'date'	  =>	'Дата ожидания:',
			'price'	  =>	'Стоимость(шт.):',
			'user_price'=>	'Стоимость для клиента(шт.):',
			'change_billing'=>'Провести оплату:',
			'count'	  =>	'Количество (шт.):'
		);
	}
	
}
