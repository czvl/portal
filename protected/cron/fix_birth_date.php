<?php

$sql = "UPDATE cv_list SET birth_date = NULL WHERE (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birth_date)), '%Y')+0) < 10";

$config = include_once '../config/db.php';

$pdo = new PDO($config['connectionString'], $config['username'], $config['password']);
$fix = $pdo->prepare($sql);
$fix->execute();
