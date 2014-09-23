<?php

class UsersController extends Controller {
  
  public function actionExtend(){
	if(Yii::app()->request->isAjaxRequest){	  	  
      $id = Yii::app()->request->getPost('id');	  
	  $model = new SettingsForm();
	  $data = UserInfo::model()->findByPk($id);
	  $model->setAttributes($data->getAttributes(),false);	  
	  $this->renderPartial( '/users/extend',
							array('model'=>$model,'prices'=>""));
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

