<?php

/**
 * Class Vacancy
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $city_id
 * @property int $experience_id
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
 * @property Company $company
 * @property CitiesList $city
 * @property Experience $experience
 * @property VacancyToCategory[] $categories
 * @property VacancyToEducation[] $educations
 */
class Vacancy extends CActiveRecord
{

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'vacancies';
    }

    /**
     * @return Vacancy
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name, company_id, city_id, user_id, status, experience_id', 'required'],
            ['company_id, city_id, user_id, status, housing, experience_id', 'numerical'],
            ['name', 'length', 'max' => 255],
            ['description, requirements', 'length', 'max' => 5000],
            ['user_id', 'contactPersonValidator']
        ];
    }

    public function contactPersonValidator()
    {
        $userIds = array_keys(CompanyHelper::userList($this->company_id));
        if(!in_array($this->user_id, $userIds)) {
            $this->addError('user_id', 'Incorrect user_id');
        }
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

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->order = 'created_at DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'company' => [
                self::BELONGS_TO,
                Company::class,
                'company_id',
            ],
            'city' => [
                self::BELONGS_TO,
                CitiesList::class,
                'city_id',
            ],
            'experience' => [
                self::BELONGS_TO,
                Experience::class,
                'experience_id'
            ],
            'categories' => [
                self::MANY_MANY,
                CvCategories::class,
                'vacancy_to_category(vacancy_id, category_id)',
            ],
            'educations' => [
                self::MANY_MANY,
                Education::class,
                'vacancy_to_education(vacancy_id, education_id)',
            ],
            'positions' => [
                self::MANY_MANY,
                CvPositions::class,
                'vacancy_to_position(vacancy_id, position_id)',
            ],
        ];
    }

}