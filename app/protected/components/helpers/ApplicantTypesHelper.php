<?php

class ApplicantTypesHelper extends LibraryHelper
{
    public static function attributeName()
    {
        return 'applicant_types';
    }

    /**
     * @return string field name
     */
    static function fieldName()
    {
        return 'applicant_types';
    }

    /**
     * Key-value pairs of all categories
     * @return array [category_id => category_name]
     */
    public static function all()
    {
        static $result;

        if (!is_null($result)) {
            return $result;
        }

        $command = Yii::app()->db;
        /* @var CDbConnection $command */
        $rows = $command->createCommand()
            ->select('id, name')
            ->from(CvApplicantTypes::model()->tableName())
            ->queryAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['id']] = $row['name'];
        }

        return $result;
    }
}
