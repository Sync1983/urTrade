<?php

class UsersController extends Controller {
  
  public static $states = array(
			0 => 'Ожидает заказа',
			1 => 'Заказан',
			2 => 'На складе',
			3 => 'Выдан',
			4 => 'Отказ'		
	  );


  public function actionExtend(){
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	$model = new SettingsForm();
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  $info	 = UserInfo::load($id);
	  $user = User::model()->findByPk($id);
	  $model->id = $id;
	  $model->setAttributes($info->attributes,false);
	  $model->email = $user->email;
	  $this->renderPartial( '/users/extend',
							  array('model'=>$model,
									'id'=>$id),false,true);		
	  }	
	Yii::app()->end();
  }
  
  public function actionExtendSave(){
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	$model = new SettingsForm();
	if(Yii::app()->request->isAjaxRequest){		  
	  $id = intval(Yii::app()->request->getPost('id'));	
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
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));	  
	  $orders = Orders::model()->findAllByAttributes(array('uid'=>$id));
	  
	  Yii::app()->clientScript->registerPackage('datatable_q');	  
	  $this->renderPartial( '/users/orders',
							array('orders'=>$orders,
								  'states'=>self::$states,
								  'id'=>$id));
	}	
	Yii::app()->end();
  }
  
  public function actionBilling() {
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
  
  public function actionMainSaveBilling(){
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  $value	= floatval(Yii::app()->request->getPost('billing_value'));
	  $comment	= strval(Yii::app()->request->getPost('billing_comment'));
	  /* @var $billing Billing */
	  $billing = new Billing();
	  $billing->comment = $comment;
	  $billing->value = $value;
	  $billing->user_id = $id;
    $billing->type = 0;
	  $billing->time = new CDbExpression('CURRENT_TIMESTAMP');
	  $billing->save();
	}	
	Yii::app()->end();	
  }

  public function actionShowItem(){
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
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
  
  public function actionOrdersCtrl() {
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	$form = new ChangeForm();
	$orders = Orders::model()->getFullOrders();		
	$provider_list = new ProviderList();	
	foreach ($orders as $row) {	  
	  /* @var $row Orders */
	  /* @var $user User */
	  /* @var $user_info UserInfo */
	  $user = User::model()->findByPk($row->uid);
	  $user_info = UserInfo::model()->findByPk($row->uid);
	  $date = strtotime($row->date);
	  $row->date = $date;
	  $row->user_price = $user->convertPrice($row->price);
	  $row->provider = $provider_list->getProviderByCLSID($row->provider)->getName();
	  $row->user = $user_info->caption;
	}	
	Yii::app()->clientScript->registerPackage('datatable_q');	
	$this->render('/users/orderCtrl',array('orders'=>$orders,'states'=>  self::$states,'model'=>$form)); 	
  }
  
	public function actionChangeOrderState() {
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	$mailer = new Mailer();
	if(Yii::app()->request->isAjaxRequest){	  
	  $form = new ChangeForm();	  
	  if(isset($_POST['ChangeForm'])) {
		$form->attributes=$_POST['ChangeForm'];
	  }else{
		$this->render("/site/error",array("code"=>500,"message"=>"Ошибка доступа!"));	  
		return;
	  }
		
	  /* @var $row Orders */
	  $provider_list = new ProviderList();
	  $id = intval($form->id);	  
	  $row = Orders::model()->findByPk($id);	  
	  if(!$row){
		$this->render("/site/error",array("code"=>500,"message"=>"Ошибка доступа!"));	  
		return;
	  }	  
	  $row->price = floatval($form->price);
	  $row->state = intval($form->state);	
	  /* @var $user User */
	  $user = User::model()->findByPk($row->uid);
	  $row->user_price = $user->convertPrice($row->price);	 
    $row->count = $form->count;
	  $date = $form->date;	  
	  $date = strtotime($date);	  
	  $row->date = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm',$date);	 
	  $row->comment = $form->comment;	  
	  if($form->change_billing==1){
		$billing = Billing::model()->orderPart($id);
		$row->is_pay = intval($billing);		
	  }	  
	  
	  if($row->save()){
		$mailer->SendStateNotification($row, $form->state,$user->email);
		$row->provider = $provider_list->getProviderByCLSID($row->provider)->getName();
		$this->renderPartial( '/users/orderCtrlItem',
		  					array('row'=>$row,'states'=>self::$states));
	  } else {
		echo "<td colspan=\"10\">Ошибка записи</td>";
	  }
	}	
	Yii::app()->end();
  }
  
  public function actionGetOrderData(){
	if(!Yii::app()->user->isAdmin()){
	  $this->render("/site/error",array("code"=>500,"message"=>"Ошибка прав доступа!"));	  
	  return;
	}
	if(Yii::app()->request->isAjaxRequest){
	  $id = intval(Yii::app()->request->getPost('id'));
	  /* @var $row Orders */
	  /* @var $user User*/
	  $row = Orders::model()->findByPk($id);
	  $user = User::model()->findByPk($row->uid);	  
	  $form = new ChangeForm();
	  $form->setAttributes($row->getAttributes(),false);
	  $form->user_price = $user->convertPrice($row->price);
	  $form->date = date("Y-m-d", strtotime($row->date));
	  $form->count = $row->count;
	  $form->count_step = $row->lot_party;	  
	  $form->comment = $row->comment;
	  $this->renderPartial( '/users/orderCtrlChangeWindow',
		  					array('model'=>$form,'states'=>self::$states));
	}
	Yii::app()->end();
  }
    
}

