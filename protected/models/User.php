<?php
 
class User extends CActiveRecord
{
  
  public static function getUserList(){
	$users = User::model()->findAll('role=1');
	return $users;
  }

  public function __construct($scenario='insert') {
    parent::__construct($scenario);
    $this->price_percent = floatval($this->price_percent);
    $this->shiping_time = intval($this->shiping_time);
    if($this->price_percent<0) {
      $this->price_percent = 0;      
      $this->save();
    }
    if($this->shiping_time<0) {
      $this->shiping_time = 0;      
      $this->save();
    }    
  }

  public function getPercent() {
    return $this->price_percent;    
  }
  
  public function getShiping() {
    return $this->shiping_time;    
  }
  
  public static function model($className=__CLASS__) {
	return parent::model($className);
  }
 
  public function tableName() {
	return 'tbl_user';
  }
		
}