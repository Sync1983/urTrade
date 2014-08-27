<?php
 
class WebUser extends CWebUser {
	const adminRole = 11;
  // Store model to not repeat query.
  private $_model;
	public $id;

  function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->id);
    
		var_dump(Yii::app()->user);
		var_dump($user);
		return true;//intval($user->role) == 11;
  }
 
  // Load user model.
  protected function loadUser($id=null) {
		if($this->_model===null) {
			if($id!==null) {
				$this->_model=User::model()->findByPk($id);
				var_dump($this->_model);
			}
    }
    return $this->_model;
  }
	
	public function auth($username,$password) {
		$user=User::model()->find('username=:name',array(':name'=>$username));
		if(!$user) {
			return CUserIdentity::ERROR_USERNAME_INVALID;
    } elseif($user['password']!=md5($password)) {
			return CUserIdentity::ERROR_PASSWORD_INVALID;
    }else {
			$this->id = $user['id'];
      $this->loadUser($user['id']);
    }
		return 0;
	}

	
}


?>
