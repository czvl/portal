<?php

$dbFileName = file_exists(dirname(__FILE__) . '/db_local.php') ? dirname(__FILE__) . '/db_local.php' : dirname(__FILE__) . '/db.php';

Yii::setPathOfAlias('vendor', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../vendor');
$local = file_exists(dirname(__FILE__) . "/main_local.php") ? require dirname(__FILE__) . "/main_local.php" : [];

return CMap::mergeArray(array(
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
            // 'class' => 'vendor.swiftmailer.SwiftMailer',
            'type' => 'file',

        ),
        'db' => require($dbFileName),
        'cache' => array(
            'class' => 'system.caching.CMemCache',
            'servers' => array(
                array('host' => 'localhost', 'port' => 11211, 'weight' => 100),
            ),
        ),
    ),
    'params' => array(
        'adminEmail' => 'shvaykovska@gmail.com',
    ),
), $local );
