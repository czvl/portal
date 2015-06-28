<?php

/**
 * @property int $id
 * @property int $vacancy_id
 * @property int $position_id
 */
class VacancyToPosition extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'vacancy_to_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['vacancy_id, position_id', 'required'],
            ['vacancy_id, position_id', 'numerical'],
        ];
    }
}