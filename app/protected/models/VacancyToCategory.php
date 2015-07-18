<?php

/**
 * @property int $id
 * @property int $vacancy_id
 * @property int $category_id
 */
class VacancyToCategory extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'vacancy_to_category';
    }


    /**
     * @inheritdoc
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['vacancy_id, category_id', 'required'],
            ['vacancy_id, category_id', 'numerical'],
        ];
    }
}