<?php
 
class WebUser extends CWebUser {
	const adminRole = 11;
  // Store model to not repeat query.
  private $_model;
	private $id;

  function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->getId());
    if(!$user) {
      return false;
    }
		return intval($user->role) == 11;
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
