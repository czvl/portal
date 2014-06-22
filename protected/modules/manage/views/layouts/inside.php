<?php
Yii::app()->bootstrap->register();
Yii::app()->clientScript->registerPackage('inside');
?>
<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="utf-8" />
        <title><?php echo Yii::t('main', $this->pageTitle); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/images/favicon.ico" />
    </head>
    <body>
        <div class="container-fluid">
            <?php echo $content; ?>

            <div class="footer">
                <p>&copy; <?php echo date('Y'); ?>. <?php echo Yii::t('main', 'All rights reserved.'); ?></p>
            </div>
        </div>
    </body>
</html>
