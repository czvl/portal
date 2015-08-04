<?php
$main = require "main.php";

$config = [
    'components' => [
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
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ],
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
];

return CMap::mergeArray($main, $config);