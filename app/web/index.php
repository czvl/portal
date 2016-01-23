<?php

date_default_timezone_set('Europe/Kiev');
$isLocalhost = (filter_input(INPUT_SERVER, 'SERVER_ADDR') == '127.0.0.1' || 'localhost' ? true : false);

// var_dump($isLocalhost);

defined('IS_LOCALHOST') or define('IS_LOCALHOST', $isLocalhost);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// var_dump(IS_LOCALHOST);
// var_dump(YII_DEBUG);
// var_dump(YII_TRACE_LEVEL);

// debug
ini_set('display_errors', 1);
error_reporting(E_ALL);


require(__DIR__ . '/../vendor/autoload.php');
$config = __DIR__ . '/../protected/config/web.php';

Yii::createWebApplication($config)->run();
