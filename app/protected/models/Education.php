<?php

/**
 * Class Education
 * @property int $id
 * @property string $name
 */
class Education extends CActiveRecord
{

    public function tableName()
    {
        return 'educations';
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