<?php

class BasketController extends Controller {
  
  public function actionAdd() {    
    if(Yii::app()->request->isAjaxRequest){
	  $providers= new ProviderList();
	  $provider	= Yii::app()->request->getPost('provider');
      $uid		= Yii::app()->request->getPost('uid');
      $maker_id	= Yii::app()->request->getPost('maker_id');
      $part_id	= Yii::app()->request->getPost('part_id');
      $part		= $providers->getPart($provider,$uid,$part_id,$maker_id);
	  if(!$part){
		echo 'Данные по детали изменились. Пожалуйста повторите запрос';
		Yii::app()->end();
		return;
	  }	  
	  if(!Basket::addPart($part)){
		echo 'Ошибка добавления. Данные ошибки отправлены на обработку';
		Yii::app()->end();
		return;
	  }	  
	  echo 'Добавлено';	
	}
    Yii::app()->end();
  }
  
  public function actionChangeItem() {    
    if(Yii::app()->request->isAjaxRequest){	  
	  $items = Yii::app()->request->getPost('items');
	  foreach ($items as $item) {		
		$id		= intval($item["id"]);      
		$count	= intval($item["count"]);      
		$comment= CHtml::encode($item["comment"]);
		/* @var $row Basket */
		$row = Basket::model()->findByPk($id);
		if(!$row||($row->uid!==Yii::app()->user->getId())){
		  echo "Ошибка доступа к записи";
		  Yii::app()->end();
		  return;
		}	  
		if($count % $row->lot_party > 0) {
		  echo "Добавляемое количество не кратно упаковке";
		  Yii::app()->end();
		  return;
		}		  
		$row->commnet = $comment;
		$row->count = $count;
		$row->save();
	  }
	}
    Yii::app()->end();
  }
  
  public function actionDeleteItem() {    
    if(Yii::app()->request->isAjaxRequest){	  	  
      $items		= Yii::app()->request->getPost('items');
	  foreach ($items as $id){
		$id		= intval($id);
		if(!Basket::deleteById($id)) {
		  echo "Ошибка доступа к записи";
		  Yii::app()->end();
		  return;
		}
	  }
	}
    Yii::app()->end();
  }
  
  public function actionBasket() {	 
	$basket = Basket::getBasket();
	Yii::app()->clientScript->registerPackage('datatable_q');
	$this->render('/basket/basket',array(
								  'basket'=>$basket)
	  );   
  }
  
  public function relations() {
    return array(
            'uid'=>array(self::BELONGS_TO, 'User', 'id'),
        );
  }
    
}

