<?php

class Billing extends CActiveRecord {
    public $sum;
    /**
     * Returns the static model of the specified AR class.
     * @return Billing
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
	
    /* @var $basket_item Basket */
	public function orderPart($basket_item,$order_articul,$order_list_id){
	  $sum = Billing::model()->getBalance();
	  $price = Yii::app()->user->convertPrice($basket_item->price)*$basket_item->count;
	  if(($sum>$price)&&($price>0)){
		$row = new Billing();
		$row->value = -$price;
		$row->user_id = Yii::app()->user->getId();
		$row->time = new CDbExpression('CURRENT_TIMESTAMP');  
		$row->comment = "Оплата заказа ".sprintf("%07d", $order_list_id)." деталь ".$order_articul;
		$row->save();
		return TRUE;
	  }
	  return false;
	}

	public static function getBalance(){        
        $result = Billing::model()->find(array(
            'select'=>'SUM(`value`) as sum',
            'condition'=>'user_id=:user_id',
            'params'=>array(':user_id'=>Yii::app()->user->getId()),
        ));        
        return round($result->sum,2);        
    }
    
    public static function getList() {
        $result = Billing::model()->findAll(array(
            'select'=>'time,value,type,comment',
            'condition'=>'user_id=:user_id',
            'params'=>array(':user_id'=>Yii::app()->user->getId()),
            'order'=>'time'
        ));        
        $answer = array();
        foreach ($result as $row) {
            $answer[] = array($row->time,$row->value,$row->comment);
        }
        return $answer;                
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

