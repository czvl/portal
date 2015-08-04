<?php

class Config extends CComponent
{

    private static $_c = [];


    public function init()
    {
    }

    public function __get($file)
    {
        if (array_key_exists($file, self::$_c)) {
            return self::$_c;
        }

        $filePath = Yii::getPathOfAlias('application.config.' . $file) . '.php';
        if (is_file($filePath)) {
            $config = require($filePath);
            $localConfig = [];
            $localFilePath = Yii::getPathOfAlias('application.config.' . $file) . '_local.php';

            if (is_file($localFilePath)) {
                $localConfig = require($localFilePath);
            }

            self::$_c = CMap::mergeArray($config, $localConfig);
        } else {
            self::$_c = [];
        }

        return self::$_c;
    }
}
