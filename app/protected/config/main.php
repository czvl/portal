<?php

$dbFileName = file_exists(dirname(__FILE__) . '/db_local.php') ? dirname(__FILE__) . '/db_local.php' : dirname(__FILE__) . '/db.php';

if (file_exists(dirname(__FILE__) . '/payment_local.php')) {
    $payment = CMap::mergeArray(
        require(dirname(__FILE__) . '/payment.php'),
        require(dirname(__FILE__) . '/payment_local.php')
    );
} else {
    $payment = require(dirname(__FILE__) . '/payment.php');
}

Yii::setPathOfAlias('vendor', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../vendor');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Employment center of free people',
    'charset' => 'utf-8',
    'sourceLanguage' => 'uk_UA',
    'language' => 'uk',
    'timeZone' => 'Europe/Kiev',
    'preload' => array('log'),
    'aliases' => array(
        'bootstrap' => 'ext.bootstrap'
    ),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.helpers.*',
        'application.extensions.yii-mail.YiiMailMessage',
        'bootstrap.helpers.TbHtml',
        'bootstrap.helpers.TbArray',
        'bootstrap.behaviors.TbWidget',
        'bootstrap.widgets.*'
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'czvl0',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        ),
        'manage',
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),
        'BsHtml' => array(
            'class' => 'bootstrap.helpers.BsHtml'
        ),
        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'autoRenewCookie' => true,
            'loginUrl' => array('/manage/login')
        ),
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
        'config' => array(
            'class' => 'Config'
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '/' => 'site/index',

                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                
                'manage/login' => 'manage/default/login',
                'manage/logout' => 'manage/default/logout',
                'applicants' => 'site/applicants',
                
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'mailer' => array(
            'class' => 'vendor.janisto.yii-mailer.SwiftMailerComponent',
            'type' => 'smtp',

        ),
        'db' => require($dbFileName),
        'clientScript' => array(
            'coreScriptPosition' => CClientScript::POS_END,
            'packages' => array(
                'main' => array(
                    'baseUrl' => '/js/',
                    'js' => array(
                        'jquery.js',
                        'inside.js'
                    ),
                ),
                'inside' => array(
                    'baseUrl' => '/',
                    'js' => array(
                        'js/inside.js'
                    ),
                    'css' => array(
                        'css/inside.css?v=1'
                    ),
                ),
            ),
            'scriptMap' => array(
                'jquery.js' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
                'jquery-ui.min.js' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'cache' => array(
            'class' => 'system.caching.CMemCache',
            'servers' => array(
                array('host' => 'localhost', 'port' => 11211, 'weight' => 100),
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
//                array(
//                    'class' => 'CWebLogRoute',
//                ),
            ),
        ),
    ),
    'params' => array(
        'adminEmail' => 'shvaykovska@gmail.com',
        'payment' => $payment,
    ),
);
