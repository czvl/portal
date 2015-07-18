<?php

/**
 * Class Experience
 * @property int $id
 * @property string $name
 */
class Experience extends CActiveRecord
{

    public function tableName()
    {
        return 'experiences';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id, name', 'required'],
            ['id', 'numerical'],
            ['name', 'length', 'max' => 255]
        ];
    }

    /**
     * @return Education
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}