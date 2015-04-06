<?php

class UserIdentity extends CUserIdentity
{
    protected $_id;

    public function authenticate()
    {
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $user = User::model()->find('LOWER(email)=?', array(strtolower($this->username)));
        } else {
            $user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
        }
        if (($user === null) || ($user->password !== crypt($this->password, $user->password))) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            
            Yii::app()->session['first_name'] = $user->first_name;
            Yii::app()->session['last_name'] = $user->last_name;
            
            $user->last_login = new CDbExpression('NOW()');
            $user->save(false);
            
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
    
    public function getRole()
    {
        return $this->_role;
    }

}
