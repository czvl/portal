<?php

class WebUser extends CWebUser
{
    private $_model = null;
    private $_role = 'guest';

    function getRole()
    {
        if ($user = $this->getModel()) {
            $this->_role = $user->role;
            return $this->_role;
        }
    }

    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }

}
