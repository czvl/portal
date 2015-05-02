<?php

/**
 * Created by A.Belyakovskiy.
 * Date: 5/1/15
 * Time: 2:38 PM
 * @property integer $user_id
 * @property integer $city_index
 */
class UserToCities extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'user_to_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'city_index'], 'required'],
            [['user_id', 'city_index'], 'numerical']
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