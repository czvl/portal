<?php

date_default_timezone_set('Europe/Kiev');

$isLocalhost = (filter_input(INPUT_SERVER, 'SERVER_ADDR') == '127.0.0.1' ? true : false);

defined('IS_LOCALHOST') or define('IS_LOCALHOST', $isLocalhost);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

$protected  = __DIR__ . '/../protected/';
$config     = $protected . '/config/main.php';
$yii        = $protected . '/vendor/yii/framework/yii.php';

require_once $yii;
Yii::createWebApplication($config)->run();
