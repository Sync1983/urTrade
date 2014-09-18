<?php

class UserInfo extends CActiveRecord {
  
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
	
	public static function load() {
	  $record = UserInfo::model()->findByPk(YII::app()->user->getId());
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
