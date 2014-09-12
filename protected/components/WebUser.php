<?php
 
class WebUser extends CWebUser {
    const adminRole = 11;
    // Store model to not repeat query.
    private $_model;
	private $id;
    private $_billing;

  public function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->getId());
    if(!$user) {
      return false;
    }
    return intval($user->role) == 11;
  }
  
  public function getBilling() {
      if(!$this->_billing) {
          $this->_billing = new Billing();
      }
      return $this->_billing;
  }

  public function convertPrice($price) {
    $user = $this->loadUser(Yii::app()->user->getId());
    if(!$user) {
      return false;
    }
    $percent = $user->getPercent();
    $price = floatval($price);
    $price += $price * $percent/100;
    return round($price,2);
  }
  
  public function convertShiping($shiping) {
    $user = $this->loadUser(Yii::app()->user->getId());
    if(!$user) {
      return false;
    }
    return $shiping+$user->getShiping();    
  }
  
  // Load user model.
  protected function loadUser($id=null) {
    if($this->_model===null) {
        if($id!==null) {        
            $this->_model=User::model()->findByPk($id,array('select'=>array('*')));				
        }
    }
    return $this->_model;
  }	
  
}
