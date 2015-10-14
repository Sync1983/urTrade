<?php

/**
 * Description of RestController
 * @author Sync<atc58.ru>
 */

class RestController extends Controller{

  //public vars
  //protected vars
  protected $providers = null;
  //private vars  
  private $format = 'json';
  //============================= Public =======================================  
  public function actionMakers(){
    $part_id = Yii::app()->request->getParam('part_id','');
    
    $part_id  = preg_replace("/[^a-zA-Z0-9\s]/", "", $part_id);
    $makers = $this->providers->getProducers($part_id);    
    
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($makers);
    
    Yii::app()->end();
  }
  
  public function actionParts(){
    /* @var $user User */
    $user = $this->auth();
    
    if ( !$user ){
      Yii::app()->end();
      return;      
    }
    
    $part_id  = Yii::app()->request->getParam('part_id','');
    $analog   = Yii::app()->request->getParam('analog',0);
    $maker    = Yii::app()->request->getParam('maker','');
    
    $part_id  = preg_replace("/[^a-zA-Z0-9\s]/", "", $part_id);
    $model = new RequestParts();
    $model->part_id = $part_id;
    $model->cross   = intval($analog);
    $model->maker   = $maker;
    $model->price_add = 0;
    
    $makers = $this->providers->getPartList($model);        
    
    foreach($makers as $part){
      $part->price = $user->convertPrice($part->price);
    }
    
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($makers);
    
    Yii::app()->end();
    
  }

  public function actionOrder(){
    /* @var $user User */
    $user = $this->auth();

    if ( !$user ){
      Yii::app()->end();
      return;
    }
    $percent = $user->getPercent();
    
    $order = new Orders();
    
    $attributes     = $order->getAttributes();    
    
    foreach ($attributes as $attr=>$value){
      $order->setAttribute($attr,Yii::app()->request->getPost($attr,false));      
    }

    $order->id      = null;
    $order->list_id = 0;
    $order->uid     = $user->id;
    $order->date    = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm',  time());
    $order->state   = 0;
    $order->count   = Yii::app()->request->getPost('basket_count',false);
    $order->user_price = $order->price;
    $order->user_price = $order->price * $order->count;

    $order->price = round($order->price/(1 + $percent/100),2);
    
    if( !$order->save() ) {
      echo json_encode(array('error'=>'Save Error'));
    }

    $orders[0] = $order;
    $mailer = new Mailer();
    $mailer->SendAddNewOrders($orders);

    echo json_encode(array('status'=>'OK'));
    
    Yii::app()->end();

    return;
  }

  //============================= Protected ====================================
  //============================= Private ======================================
  //============================= Constructor - Destructor =====================
  public function __construct(){
    if( !$this->providers ){
      $this->providers = new ProviderList();
    }
  }
  
  public function auth(){
    $user = isset($_SERVER['PHP_AUTH_USER'])?$_SERVER['PHP_AUTH_USER']:false;
    $pass = isset($_SERVER['PHP_AUTH_PW'])?$_SERVER['PHP_AUTH_PW']:false;
    
    if( !$user || !$pass ){
      header('WWW-Authenticate: Basic realm="atc58 Realm"');
      header('HTTP/1.0 401 Unauthorized');
      echo 'Auth Error';
      return false;
    }
    
    $user_rec = User::model()->findByAttributes(array('username'=>$user,'password'=>$pass));
    if( !$user_rec ){
      header('WWW-Authenticate: Basic realm="atc58 Realm"');
      header('HTTP/1.0 401 Unauthorized');
      echo 'Auth Error';
      return false;      
    }
    
    return $user_rec;
    
  }

}
