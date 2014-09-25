<?php

class UsersController extends Controller {
  
  public function actionExtend(){
	$model = new SettingsForm();
	if(Yii::app()->request->isAjaxRequest){
	  $id = Yii::app()->request->getPost('id');	  	
	  $info	 = UserInfo::load($id);
	  $model->id = $id;
	  $model->setAttributes($info->attributes,false);
	  $this->renderPartial( '/users/extend',
							  array('model'=>$model,
									'id'=>$id),false,true);		
	  }	
	Yii::app()->end();
  }
  
  public function actionExtendSave(){
	$model = new SettingsForm();
	if(Yii::app()->request->isAjaxRequest){		  
	  $id = Yii::app()->request->getPost('id');	
	  $model->setAttributes($_POST['SettingsForm'],false);
	  if(($model->validate())&(YII::app()->user->isAdmin())&($id==$model->id)){
			$model->saveForId($model->id);
	  }
	  $this->renderPartial( '/users/extend',
							array('model'=>$model,
								  'id'=>$model->id));		
	}	
	Yii::app()->end();
  }
  
  public function actionMain(){
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  $info	 = UserInfo::load($id);
	  $user	 = User::model()->findByPk(intval($id));
	  $balance = Billing::getBalance($id);
	  $credit_balance = Billing::getCreditBalance($id);
	  $basket_count = count(Basket::getBasket($id));
	  $basket_price = Basket::getBasketPrice($id);
	  $order_count  = count(Orders::getOrders($id));
	  $order_price	= Orders::getOrdersPrice($id);
	  $this->renderPartial( '/users/main',
							array('user'=>$user,
								  'info'=>$info,
								  'balance'=>$balance,
								  'credit'=>$credit_balance,
								  'basket_count'=>$basket_count,
								  'basket_price'=>$basket_price,
								  'order_count'=>$order_count,
								  'order_price'=>$order_price,
								  'id'=>$id));
	}	
	Yii::app()->end();
  }
  
  public function actionMainSave(){
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));	  
	  $price_percent  = intval(Yii::app()->request->getPost('price_percent'));	  
	  $shiping_time	  = intval(Yii::app()->request->getPost('shiping_time'));	  
	  $user	 = User::model()->findByPk($id);
	  if(!$user){
		Yii::app()->end();
		return;
	  }
	  $user->shiping_time = $shiping_time;
	  $user->price_percent = $price_percent;
	  $user->update();
	}	
	Yii::app()->end();
  }
  
  public function actionMainSavePassword(){
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));	  
	  $password = Yii::app()->request->getPost('password');	  
	  $user	 = User::model()->findByPk($id);
	  if(!$user){
		Yii::app()->end();
		return;
	  }
	  $user->password = md5($password);
	  $user->update();
	}	
	Yii::app()->end();
  }
  
  public function actionBasket() {
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  $basket = Basket::getBasket($id);	
	  Yii::app()->clientScript->registerPackage('datatable_q');
	  $this->renderPartial( '/users/basket',
							array('basket'=>$basket,
								  'id'=>$id));
	}	
	Yii::app()->end();
  }
  
  public function actionOrder() {
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  $lists = OrdersList::model()->findAllByAttributes(array('uid'=>$id));
	  $orders = array();
	  /* @var $list_item OredersList */
	  foreach ($lists as $list_item){
		$list_id = $list_item->id;
		$row = Orders::model()->findAllByAttributes(array('uid'=>$id,'list_id'=>$list_id));
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
	  $this->renderPartial( '/users/orders',
							array('orders'=>$orders,
								  'states'=>$states,
								  'id'=>$id));
	}	
	Yii::app()->end();
  }
  
  public function actionBilling() {
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  $billing = Billing::getList($id);
	  Yii::app()->clientScript->registerPackage('datatable_q');	  
	  $this->renderPartial( '/users/billing',
							array('list'=>$billing,								  
								  'id'=>$id));
	}	
	Yii::app()->end();
  }

  public function actionShowItem(){
	if(Yii::app()->request->isAjaxRequest){	  	  
      $id = Yii::app()->request->getPost('id');
	  $action = Yii::app()->request->getPost('action');
	  $data = array();
	  $this->renderPartial( '/users/'.$action,
							array('data'=>$data));
	}
	Yii::app()->end();
  }
  
  public function actionTabsView(){
	$this->renderPartial( '/users/tabs',array());
  }

  public function actionIndex() {	 	
	$users = User::getUserList();	
	$uids = array();
	foreach ($users as $row) {
	  $uids[$row->id] = $row->username;
	}
	$extend = UserInfo::model()->findAll();
	$info = array();
	foreach ($extend as $row) {
	  if(isset($uids[$row->uid])){
		$info[$row->uid] = $row;
	  }
	}	
	Yii::app()->clientScript->registerPackage('datatable_q');	
	$this->render('/users/index',array(
								  'uids'=>$uids,
								  'info'=>$info)
	  );   
  }
    
}

