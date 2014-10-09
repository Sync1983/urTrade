<?php

class OrdersController extends Controller {
  
  public function actionAdd() {    
    if(Yii::app()->request->isAjaxRequest){	  
	  $ids	= Yii::app()->request->getPost('ids');
	  $uid = Yii::app()->user->GetId();
	  $order_id = new OrdersList();
	  $order_id->uid = $uid;
	  $order_id->save();	
	  $orders = array();
	  foreach ($ids as $id){
		$id = intval($id);
		/* @var $item Basket */
		$item = Basket::model()->findByPk($id);
		if((!$item)||($item->uid!=$uid)) {
		  echo "Указанная позиция ".$item->producer." ".$item->articul." ".$item->name." в корзине не найдена";
		  Yii::app()->end();
		  return;
		}
		/* @var $order Orders */
		$order = new Orders();		
		$order->setAttributes($item->getAttributes(),false);
		$order->id = null;
		$order->list_id = $order_id->id;
		$order->uid = $uid;	
		$order->date = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm',  time()+86400*Yii::app()->user->convertShiping(0));	
			//new CDbExpression('CURRENT_TIMESTAMP');
		$order->save();
		$item->delete();
		$orders[] = $order;
	  }
	}
	$mailer = new Mailer();
	$mailer->SendAddNewOrders($orders);
	echo "ok";
    Yii::app()->end();
  }
  
  public function actionOrders() {
	$uid = Yii::app()->user->getId();
	$lists = OrdersList::model()->findAllByAttributes(array('uid'=>$uid));
	$orders = array();
	/* @var $list_item OredersList */
	foreach ($lists as $list_item){
	  $list_id = $list_item->id;
	  $row = Orders::model()->findAllByAttributes(array('uid'=>$uid,'list_id'=>$list_id));
	  $orders[$list_id] = $row;
	}
	$states = array(
			0 => 'Ожидает заказа',
			1 => 'Заказан',
			2 => 'На складе',
			3 => 'Выдан',
			4 => 'Отказ'		
	);
	Yii::app()->clientScript->registerPackage('datatable_q');
	$this->render('/orders/orders',array('orders'=>$orders,'states'=>$states));
  }
  
  public function relations() {
    return array(
            'uid'=>array(self::BELONGS_TO, 'User', 'id'),
        );
  }
    
}

