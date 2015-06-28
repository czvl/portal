<?php

/**
 * Class Vacancy
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $city_id
 * @property int $user_id
 * @property string $description
 * @property string $requirements
 * @property int $status
 * @property int $housing
 * @property string $close_time
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Vacancy extends CActiveRecord
{

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'vacancies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name, company_id, city_id, user_id, status, housing', 'required'],
            ['company_id, city_id, user_id, status, housing', 'numerical'],
            ['name', 'length', 'max' => 255],
            ['description, requirements', 'length', 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        $now = new CDbExpression('NOW()');

        $this->updated_at = $now;
        if ($this->scenario = 'create') {
            $this->created_at = $now;
            $this->close_time = new CDbExpression('NOW() + INTERVAL 14 DAY');
        }

        return parent::beforeSave();
    }

}