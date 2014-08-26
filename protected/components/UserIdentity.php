<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  const adminRole = 11;
  protected $_id;
  protected $_role;
  protected $_email;
  protected $_price_percent;
  protected $_shiping_time;
  protected $_phone;
  protected $_shiping;

  /**
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = Yii::app()->db->createCommand()
        ->select('id,username, password,role,email,price_percent,shiping_time,phone,shiping')
        ->from('tbl_user')
        ->where('username=:name',array(':name'=>$this->username))
        //->where('password=:pass',array(':pass'=>md5($this->password)))
        ->limit(1)
        ->queryRow();
    print_r($user);
    print_r(md5($this->password));
		if(count($user)<1) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
    } elseif($user['password']!=md5($this->password)) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
    }else {
      $this->_id            = $user['id'];
      $this->_role          = $user['role'];
      $this->_email         = $user['email'];
      $this->_price_percent = $user['price_percent'];
      $this->_shiping_time  = $user['shiping_time'];
      $this->_phone         = $user['phone'];
      $this->_shiping       = $user['shiping'];
			$this->errorCode      = self::ERROR_NONE;
    }    
		return !$this->errorCode;
	}
  
  public function isAdmin() {
    return $this->_role==self::adminRole;
  }
  
}