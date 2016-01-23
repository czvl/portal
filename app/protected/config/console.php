<?php
$main = require "main.php";

$config =  [
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning, trace, info',
                    // 'logPath' => '/tmp',
                    // 'logFile' => 'application.log',
                    'enabled' => true,

                    // 'categories' => 'application',
				),
                // array(
                //     'class' => 'CWebLogRoute',
                //     'levels'=>'error, warning, trace, info, notice',
                //     'showInFireBug' => true,
                //     'enabled' => true,
                //     'categories' => 'application',
                // ),
			),
		),
        'urlManager' => array(
            'baseUrl' => 'http://czvl.org.ua',
        ),
	),
];

return CMap::mergeArray($main, $config);
