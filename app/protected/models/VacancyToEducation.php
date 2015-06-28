<?php

/**
 * @property int $id
 * @property int $vacancy_id
 * @property int $education_id
 */
class VacancyToEducation extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'vacancy_to_education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['vacancy_id, education_id', 'required'],
            ['vacancy_id, education_id', 'numerical'],
        ];
    }
}