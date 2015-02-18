<?php

class MobileController extends Controller {
  
  public function actionGetUser() {    
    $login = Yii::app()->request->getPost('login');
    $pass  = Yii::app()->request->getPost('pass');
    $result = [];
    if(!$login||!$pass){
      $result['error'] = "Ошибка авторизации";
      echo json_encode($result);
      Yii::app()->end();
      return;
    }
    $user=User::model()->findByAttributes(array('username'=>$login));//,'password'=>$pass));
    $result['action'] = Yii::app()->request->getPost('action');
    $result['answer'] = "Guest";
    if(($user==null)||($user->password!=$pass)){
      $result['error'] = "User not found";
    }else{
      $result['name'] = "\"".$user->username."\"";
    
      $user_info = UserInfo::load($user->id);
      $result['name'] .= " (".$user_info->caption.")";
    }

    echo json_encode($result);
    Yii::app()->end();
  }

  public function actionGetProdecers(){
    $login = Yii::app()->request->getPost('login');
    $pass  = Yii::app()->request->getPost('pass');
    $result = [];
    if(!$login||!$pass){
      $result['error'] = "Ошибка авторизации";
      echo json_encode($result);
      Yii::app()->end();
      return;
    }
    $user=User::model()->findByAttributes(array('username'=>$login));//,'password'=>$pass));
    $result['action'] = Yii::app()->request->getPost('action');
    if(($user==null)||($user->password!=$pass)){
      $result['error'] = "User not found";
    }else{
      $part_id  = Yii::app()->request->getPost('text');
      $part_id  = preg_replace("/[^a-zA-Z0-9\s]/", "", $part_id);
      $providers = new ProviderList();
      $producers = $providers->getProducers($part_id); 
      $result['search_text'] = $part_id;
      $result['makers'] = $producers;
    }

    echo json_encode($result);
    Yii::app()->end();
  }
  
     
}

