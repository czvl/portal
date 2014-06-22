<?php

class Controller extends CController
{
    public $menu = array();
    public $breadcrumbs = array();

    public function loadConfigFromFile($file)
    {
        $filePath = Yii::getPathOfAlias('application.config.' . $file).'.php';
        
        if (is_file($filePath)) {
            return require($filePath);
        } else {
            return array();
        }
    }
}
