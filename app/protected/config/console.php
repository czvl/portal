<?php
$main = require "main.php";

$config =  [
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
        'urlManager' => array(
            'baseUrl' => 'http://czvl.org.ua',
        ),
	),
];

return CMap::mergeArray($main, $config);

