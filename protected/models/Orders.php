<?php

class Orders extends CActiveRecord {
  public $id;
  public $list_id;
  public $state;
  public $uid;
  public $date;
  public $part_uid;
  public $provider;
  public $articul;
  public $producer;
  public $name;
  public $price;
  public $shiping;
  public $stock;
  public $is_original;
  public $lot_party;
  public $count;  
  public $commnet;
  public $sum;
  
  public static function getOrders($id=null) {
	if(!$id){
	  $id = Yii::app()->user->getId();
	} else {
	  $id = intval($id);
	}
	$result = Orders::model()->findAllByAttributes(array("uid"=>$id));
	return $result;
  }
  
  public static function getOrdersPrice($id=null) {	
	if(!$id){
	  $id = Yii::app()->user->getId();
	} else {
	  $id = intval($id);
	}
	$result = Orders::model()->find(array(
            'select'=>'SUM(`count`*`price`) as sum',
            'condition'=>'uid=:uid and state=:state',
            'params'=>array(':uid'=>$id,':state'=>0),
        ));        
   return Yii::app()->user->convertPrice($result->sum,2); 
  }
  
  public static function deleteById($id){
	$row = Orders::model()->findByPk($id);
	if((!$row)||($row->uid!==Yii::app()->user->getId())){
	  return false;
	}
	if(!$row->delete()){
	  return false;
	}
	return true;
  }

  public static function model($className=__CLASS__) {
	return parent::model($className);
  }

  public function tableName() {
	return 'tbl_order';
  }
}

