<?php

// Yii::setPathOfAlias('local','path/to/local-folder');

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
        'application.helpers.*',
        
//        'ext.eoauth.*',
//        'ext.eoauth.lib.*',
//        'ext.lightopenid.*',
//        'ext.eauth.services.*',
        
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
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '/' => 'site/index',
//                'login/<service:(google|google-oauth|yandex|yandex-oauth|twitter|linkedin|vkontakte|facebook|steam|yahoo|mailru|moikrug|github|live|odnoklassniki)>' => 'site/login',
                
                'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                
                'manage/login' => 'manage/default/login',
                'manage/logout' => 'manage/default/logout',
                
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=czvl',
            'emulatePrepare' => true,
            'username' => 'czvl',
            'password' => 'ACu8wnmujybQC7em',
            'charset' => 'utf8',
        ),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType' => 'php',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',
        ),
        'clientScript' => array(
            'coreScriptPosition' => CClientScript::POS_END,
            'packages' => array(
                'main' => array(
                    'baseUrl' => '/js/',
                    'js' => array(
                        'jquery.js',
//                        'jquery.scrollTo-1.4.2-min.js',
//                        'jquery.localscroll-1.2.7-min.js',
//                        'bootstrap.js',
                        'site.js'
                    ),
                ),
                'inside' => array(
                    'baseUrl' => '/',
                    'js' => array(
//                        'js/bootstrap-wysiwyg.js',
//                        'js/inside.js'
                    ),
                    'css' => array(
                        'css/inside.css'
                    ),
//                    'depends'=>array('jquery'),
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
//        'cache' => array(
//            'class' => 'system.caching.CMemCache',
//            'servers' => array(
//                array('host' => 'localhost', 'port' => 11211, 'weight' => 100),
//            ),
//        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            /*
              array(
              'class' => 'CWebLogRoute',
              ),
             */
            ),
        ),
//        'cache' => array(
//            'class' => 'CFileCache',
//        ),
//        'loid' => array(
//            'class' => 'ext.lightopenid.loid',
//        ),
//        'eauth' => array(
//            'class' => 'ext.eauth.EAuth',
//            'popup' => true, // Use the popup window instead of redirecting.
//            'services' => array(// You can change the providers and their classes.
//                /* 'google' => array(
//                  'class' => 'GoogleOpenIDService',
//                  ), */
//                'google-oauth' => array(
//                    'class' => 'GoogleOAuthService',
//                    'client_id' => '180893836341-vcn01hiq0f8okbbgfefs1fpg8nd7hu61.apps.googleusercontent.com',
//                    'client_secret' => 'dIUp4JQarpWJtLd2mMEdr4rn',
//                    'title' => 'Google (OAuth2)',
//                ),
//                'yandex' => array(
//                    'class' => 'YandexOpenIDService',
//                ),
//                /*
//                  'twitter' => array(
//                  'class' => 'TwitterOAuthService',
//                  'key' => '...',
//                  'secret' => '...',
//                  ),
//                 */
//                'facebook' => array(
//                    'class' => 'FacebookOAuthService',
//                    'client_id' => '1431396713804066',
//                    'client_secret' => 'b56d111869e1dfc2aca8dc04c99da992',
//                ),
//            /*
//              'vkontakte' => array(
//              'class' => 'VKontakteOAuthService',
//              'client_id' => '...',
//              'client_secret' => '...',
//              ),
//              'mailru' => array(
//              'class' => 'MailruOAuthService',
//              'client_id' => '...',
//              'client_secret' => '...',
//              ),
//             */
//            ),
//        ),
    ),
    'params' => array(
        'adminEmail' => 'shvaykovska@gmail.com',
    ),
);
