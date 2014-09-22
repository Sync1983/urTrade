<?php

class OrdersList extends CActiveRecord {
  public $id;  
  public $uid;  
  public $commnet;

  public static function model($className=__CLASS__) {
	return parent::model($className);
  }

  public function tableName() {
	return 'tbl_orders_list';
  }
}

