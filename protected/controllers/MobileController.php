<?php

class MobileController extends Controller {
  
  public function actionGetUser() {    
    //if(Yii::app()->request->isAjaxRequest)
    //$items = Yii::app()->request->getPost('items');
    echo json_encode(['error'=>'Неверная аутендификация']);
    Yii::app()->end();
  }
  
     
}

