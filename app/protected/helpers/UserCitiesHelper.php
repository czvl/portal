<?php

/**
 * Created by A.Belyakovskiy.
 * Date: 5/2/15
 * Time: 10:34 AM
 */
class UserCitiesHelper
{
    /**
     * @param User $user
     * @return string checkbox list
     */
    public static function checkBoxList(User $user)
    {

        $list = CHtml::checkBoxList('cities', self::exists($user),
            self::all(),
            [
                'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                'separator' => '',
            ]);

        return $list;
    }

    /**
     * City ids bound for user
     * @param User $user
     * @return array
     */
    public static function exists(User $user)
    {
        $checked = [];
        foreach ($user->citiesList as $city) {
            array_push($checked, $city->city_index);
        }

        return $checked;
    }

    /**
     * Key-value pairs of all cities
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
            ->select('city_index, city_name')
            ->from(CitiesList::model()->tableName())
            ->queryAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['city_index']] = $row['city_name'];
        }
        asort($result);

        return $result;
    }
}