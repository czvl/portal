<?php

class ManageModule extends CWebModule
{   
//    public function init()
//    {
//        $this->setImport(array(
//            'manage.models.*',
//            'manage.components.*',
//        ));
//    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            
            $this->layout = 'inside_menu';
            
            return true;
        } else
            return false;
    }

}
