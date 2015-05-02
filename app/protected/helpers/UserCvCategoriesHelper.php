<?php

/**
 * Created by A.Belyakovskiy.
 * Date: 5/1/15
 * Time: 12:53 PM
 */
class UserCvCategoriesHelper
{

    /**
     * @param User $user
     * @return string checkbox list
     */
    public static function checkBoxList(User $user)
    {

        $list = CHtml::checkBoxList('categories', self::exists($user),
            self::all(),
            [
                'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                'separator' => '',
            ]);

        return $list;
    }

    /**
     * Category ids bound for user
     * @param User $user
     * @return array
     */
    public static function exists(User $user)
    {
        $checked = [];
        foreach ($user->cvCategories as $category) {
            array_push($checked, $category->id);
        }

        return $checked;
    }

    /**
     * Key-value pairs of all categories
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
            ->from(CvCategories::model()->tableName())
            ->queryAll();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['id']] = $row['name'];
        }
        asort($result);

        return $result;
    }

}