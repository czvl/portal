<?php

require(__DIR__ . '/../vendor/autoload.php');

$app = Yii::createConsoleApplication(__DIR__ .'/config/console.php');
$app->commandRunner->addCommands(YII_PATH.'/cli/commands');

$app->run();
