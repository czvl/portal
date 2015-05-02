<?php

/**
 * Created by A.Belyakovskiy.
 * Date: 5/1/15
 * Time: 2:39 PM
 * @property integer $user_id
 * @property integer $cv_category_id
 */
class UserToCvCategories extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'user_to_cv_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'cv_category_id'], 'required'],
            [['user_id', 'cv_category_id'], 'numerical', 'integerOnly' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}