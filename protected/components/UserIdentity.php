<?php 

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
  /**
	 * @return boolean whether authentication succeeds.
	 */
	
	public function getId() {
    return $this->_id;
	}
	
	public function authenticate()
	{
		$this->errorCode = Yii::app()->user->auth($this->username,  $this->password);
		if(!$this->errorCode) {
			var_dump(Yii::app()->user);
		}
		return !$this->errorCode;
	}
  
}