<?php

class SettingsForm extends CFormModel
{  
	public $id;
	public $caption;
	public $name;
	public $sname;
	public $inn;
	public $kpp;
	public $addres;
	public $phone;
	public $type;
	public $prices;
	public $email;
	
	public function attributeNames(){
	  return array(	'caption', 
					'name',
					'sname',
					'inn',
					'kpp',
					'addres',
					'phone',
					'email',
					'type',
					'id');
	}


	public function rules()
	{
		return array(
			array('caption, name, addres, phone', 'required'),			
			array('email', 'email'),			
			array('inn, kpp', 'numerical',
			  'allowEmpty'=>false,
			  'integerOnly'=>true,
			  'min'=>1,			  
			  'tooSmall'=>'Введите корректный номер'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'type'	  =>	'Заказчик: ',
			'caption' =>	'Название организации: ',
			'name'	  =>	'Имя контактного лица:',
			'sname'	  =>	'Фамилия контактного лица:',
			'inn'	  =>	'ИНН (для организаций обязательно к заполнению):',
			'kpp'	  =>	'КПП (для организаций обязательно к заполнению):',
			'addres'  =>	'Адрес доставки:',
			'phone'	  =>	'Контактный телефон:',
			'submit'  =>	'Контактный телефон:',				
			'email'	  =>	'Почта(e-mail):',
		);
	}
	
	public function save(){
	  $record = UserInfo::load();
	  $record->setAttributes($this->getAttributes(),false);
	  $record->uid = YII::app()->user->getId();
	  $record->save();	  
	}
	
	public function saveForId($id) {
	  $id = intval($id);
	  $record = UserInfo::load($id);
	  $record->setAttributes($this->getAttributes(),false);
	  $record->uid = $id;
	  $record->update();
	  $user = User::model()->findByPk($id);
	  if($user){
		$user->email = $this->email;
		$user->update();
	  }
	}
}