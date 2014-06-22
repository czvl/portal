<?php

class UserIdentity extends CUserIdentity
{
    protected $_id;

    public function authenticate()
    {
        $user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
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
