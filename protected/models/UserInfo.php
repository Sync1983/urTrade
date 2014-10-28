<?php

class UserInfo extends CActiveRecord {
  public $uid;
  public $caption;
  public $name;
  public $sname;
  public $inn;
  public $kpp;
  public $addres;
  public $phone;
  public $type;
  
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
	
	public static function load($id=null) {
	  if(!$id){
		$id = YII::app()->user->getId();
	  }
	  $id = intval($id);
	  $record = UserInfo::model()->findByPk($id);
	  if(!$record) {
		$record = new UserInfo();
	  }
	  return $record;
	}

	public function relations() {
	  return array(
		'uid'=>array(self::BELONGS_TO, 'User', 'id'),		
	  );
	}
	
	public function primaryKey() {
	  return 'uid';    
	}
 
    public function tableName() {
        return 'tbl_user_info';
    }
}

