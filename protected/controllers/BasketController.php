<?php

class BasketController extends Controller {
  
  public function actionAdd() {
    //$model=new Basket;		
	
    //$model->
		/*if(isset($_POST['request-form'])) {			
			$model->attributes=$_POST['request-form'];	
		}
    
    if(Yii::app()->request->isAjaxRequest){
			$part_id = Yii::app()->request->getPost('part_id');
      $filters = Yii::app()->request->getPost('filters');
      $answer = $filters;              
			//$answer = $model->load_data($part_id);
			echo $answer;//CHtml::encode($answer);*/
	  echo 'Добавлено';
      Yii::app()->end();	
  }
  
  public function relations() {
    return array(
            'user_id'=>array(self::BELONGS_TO, 'User', 'id'),
        );
  }
    
}

