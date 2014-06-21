<?php

$serverAddr = filter_input(INPUT_SERVER, 'SERVER_ADDR');
defined('IS_LOCALHOST') or define('IS_LOCALHOST', ($serverAddr == '127.0.0.1' ? true : false));

$yii = dirname(__FILE__) . '/../../../Sites/yii/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($config)->run();
