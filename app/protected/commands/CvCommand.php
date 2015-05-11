<?php

/**
 * Created by A.Belyakovskiy.
 * Date: 4/9/15
 * Time: 3:47 PM
 */
class CvCommand extends CConsoleCommand
{
    public function actionFixBirthDate()
    {
        $sql = "UPDATE cv_list SET birth_date = NULL WHERE (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birth_date)), '%Y')+0) < 16";
        $app = Yii::app();

        /* @var $app CConsoleApplication */
        echo $app->db->createCommand($sql)->execute();
        echo PHP_EOL;
    }
}