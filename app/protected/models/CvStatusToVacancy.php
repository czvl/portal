<?php

/**
 * Class CvStatusToVacancy
 * @property $id
 * @property $cv_status_id
 * @property $vacancy_id
 */
class CvStatusToVacancy extends CActiveRecord
{
    public function tableName()
    {
        return 'cv_status_to_vacancy';
    }

    public function rules()
    {
        return [
            ['cv_status_id, vacancy_id', 'required'],
            ['cv_status_id, vacancy_id', 'numerical'],
        ];
    }
}