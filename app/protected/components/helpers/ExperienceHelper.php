<?php


class ExperienceHelper
{
    /**
     * Key-value pairs of all experiences
     * @return array [category_id => category_name]
     */
    public static function all()
    {
        static $result;

        if(!is_null($result)) {
            return $result;
        }

        $command = Yii::app()->db;
        /* @var CDbConnection $command */
        $rows = $command->createCommand()
            ->select('id, name')
            ->from(Experience::model()->tableName())
            ->queryAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['id']] = $row['name'];
        }

        return $result;
    }
}