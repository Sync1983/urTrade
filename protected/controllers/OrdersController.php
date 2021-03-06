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
        $order->id      = null;
        $order->list_id = $order_id->id;
        $order->uid     = $uid;
        $order->date    = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm',  time()+86400*Yii::app()->user->convertShiping(0));
        $order->comment = $item->commnet;
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
	$states = array(
			0 => 'Ожидает заказа',
			1 => 'Заказан',
			2 => 'На складе',
			3 => 'Выдан',
			4 => 'Отказ'		
	);
	Yii::app()->clientScript->registerPackage('datatable_q');
	$this->render('/orders/orders',array('orders'=>  Orders::model()->getOrders($uid),'states'=>$states));
  }
  
  public function actionDeleteItem() {
	if(Yii::app()->request->isAjaxRequest){	  
	  $id	= intval(Yii::app()->request->getPost('id'));
	  $uid = Yii::app()->user->getId();	
	  /* @var $order Orders */
	  $order = Orders::model()->findByPk($id);
	  if(($order->uid!=$uid)||($order->state!=0)){
		echo "Access Error!";
		Yii::app()->end();
		return;
	  }elseif($order->delete()){
		echo "ok";
		Yii::app()->end();
		return;
	  }
	}	
	echo "Error";
    Yii::app()->end();
  }
  
  public function relations() {
    return array(
            'uid'=>array(self::BELONGS_TO, 'User', 'id'),
        );
  }
    
}

