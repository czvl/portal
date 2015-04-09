<?php

$dbFileName = file_exists(dirname(__FILE__) . '/db_local.php') ? dirname(__FILE__) . '/db_local.php' : dirname(__FILE__) . '/db.php';
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'preload'=>array('log'),
	'components'=>array(
		'db'=> require $dbFileName,
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);