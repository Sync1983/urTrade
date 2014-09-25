<?php

class Basket extends CActiveRecord {
  public $id;
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

  /* @var $part Part */
  public static function addPart($part){
	if(!$part) {
	  return FALSE;
	}
	$result = Basket::model()->findByAttributes(array("part_uid"=>$part->id,"stock"=>$part->stock));
	if(!$result){
	  $item = new Basket();
	  $item->setAttributes($part->getDataForBasket(),false);
	  $item->count = $part->lot_party;
	  if(!$item->save()){
		return false;
	  }
	} else {
	  /* @var $result Basket */
	  $result->count += $part->lot_party;
	  if(!$result->save()){
		return false;
	  }
	}
	return true;	
  }
  
  public static function getBasket($id=null) {
	if(!$id){
	  $id = Yii::app()->user->getId();
	} else {
	  $id = intval($id);
	}
	$result = Basket::model()->findAllByAttributes(array("uid"=>$id));
	return $result;
  }
  
  public static function getBasketPrice($id=null) {
	if(!$id){
	  $id = Yii::app()->user->getId();
	} else {
	  $id = intval($id);
	}
	$result = Basket::model()->find(array(
            'select'=>'SUM(`count`*`price`) as sum',
            'condition'=>'uid=:uid',
            'params'=>array(':uid'=>$id),
        ));        
        return round($result->sum,2); 
  }
  
  public static function deleteById($id){
	$row = Basket::model()->findByPk($id);
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
	return 'tbl_basket';
  }
}

