<?php

class Billing extends CActiveRecord {
  
	public $id;
	public $user_id;
	public $order_id;
	public $value;
	public $time;
	public $type;
	public $comment;
    public $sum;
	
    /**
     * Returns the static model of the specified AR class.
     * @return Billing
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }	
    
	public function orderPart($order_id){	  
	  /* @var $order Orders */
	  $order = Orders::model()->findByPk($order_id);
	  if(!$order){
		return false;
	  }
	  /* @var $user	User */
	  $user = User::model()->findByPk($order->uid);
	  $sum = Billing::model()->getBalance($order->uid);
	  if(!$user){
		return false;
	  }
	  
	  $price = $user->convertPrice($order->price)*$order->count;
	  
	  if(($sum>$price)&&($price>0)){
		$row = new Billing();
		$row->order_id=$order_id;
		$row->value = -$price;
		$row->user_id = $user->id;
		$row->time = new CDbExpression('CURRENT_TIMESTAMP'); 
    $row->type = 0;
		$row->comment = "Оплата заказа ".sprintf("%07d", $order->id)." деталь ".$order->articul;
		$row->save();
		$order->is_pay = 1;
		$order->save();
		return TRUE;
	  }
	  return false;
	}

	public static function getBalance($id=null){
		if(!$id){
		  $id = Yii::app()->user->getId();
		} else {
		  $id = intval($id);
		}
        $result = Billing::model()->find(array(
            'select'=>'SUM(`value`) as sum',
            'condition'=>'user_id=:user_id and type=:type',
            'params'=>array(':user_id'=>$id,'type'=>0),
        ));        
        return round($result->sum,2);        
    }
	
	public static function getCreditBalance($id=null){
		if(!$id){
		  $id = Yii::app()->user->getId();
		} else {
		  $id = intval($id);
		}
        $result = Billing::model()->find(array(
            'select'=>'SUM(`value`) as sum',
            'condition'=>'user_id=:user_id and type=:type',
            'params'=>array(':user_id'=>$id,':type'=>1),
        ));        
        return round($result->sum,2);        
    }
    
    public static function getList($id=null) {
		if(!$id){
		  $id = Yii::app()->user->getId();
		} else {
		  $id = intval($id);
		}
        $result = Billing::model()->findAllByAttributes(array('user_id'=>$id),array('order'=>'time'));        
        return $result;                
    }
    
    public function tableName() {
        return 'tbl_billing';
    }
    
    public function relations()
    {
        return array(
            'user_id'=>array(self::BELONGS_TO, 'User', 'id')            
        );
    }
}

