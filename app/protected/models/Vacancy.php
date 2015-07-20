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
 *
 * @property Company $company
 * @property User $user
 * @property CitiesList $city
 * @property Experience $experience
 * @property CvCategories[] $categories
 * @property Education[] $educations
 * @property CvPositions[] $positions
 */
class Vacancy extends CActiveRecord
{

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    public $categoryIds;
    public $positionIds;
    public $educationIds;

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
            ['name, company_id, city_id, user_id, status, experience_id, categoryIds', 'required'],
            ['company_id, city_id, user_id, status, housing, experience_id', 'numerical'],
            ['name', 'length', 'max' => 255],
            ['description, requirements', 'length', 'max' => 5000],
            ['user_id', 'contactPersonValidator'],
            ['positionIds, educationIds', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
            'class' => 'application.components.ESaveRelatedBehavior')
        );
    }

    public function contactPersonValidator()
    {
        $userIds = array_keys(CompanyHelper::userList($this->company->id));
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

        if($this->status == self::STATUS_CLOSED) {
            $this->close_time = null;
        }

        $this->categories = $this->categoryIds;
        $this->positions = $this->positionIds;
        $this->educations = $this->educationIds;

        return parent::beforeSave();
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();

        if (empty($this->categoryIds)) {
            foreach ($this->categories as $c) {
                $this->categoryIds[] = $c->id;
            }
        }
        if (empty($this->positionIds)) {
            foreach ($this->positions as $p) {
                $this->positionIds[] = $p->id;
            }
        }
        if (empty($this->educationIds)) {
            foreach ($this->educations as $e) {
                $this->educationIds[] = $e->id;
            }
        }
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
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('main', 'vacancy.label.name'),
            'company_id' => Yii::t('main', 'vacancy.label.company'),
            'city_id' => Yii::t('main', 'vacancy.label.city_id'),
            'user_id' => Yii::t('main', 'vacancy.label.user'),
            'experience_id' => Yii::t('main', 'vacancy.label.experience_id'),
            'housing' => Yii::t('main', 'vacancy.label.housing'),
            'description' => Yii::t('main', 'vacancy.label.description'),
            'requirements' => Yii::t('main', 'vacancy.label.requirements'),
            'status' => Yii::t('main', 'vacancy.label.status'),
            'categories' => Yii::t('main', 'vacancy.label.categories'),
            'educations' => Yii::t('main', 'vacancy.label.educations'),
            'positions' => Yii::t('main', 'vacancy.label.positions'),
            'close_time' => Yii::t('main', 'vacancy.label.close_time'),
            'updated_at' => Yii::t('main', 'vacancy.label.updated_at'),
            'created_at' => Yii::t('main', 'vacancy.label.created_at'),

            'categoryIds' => Yii::t('main', 'vacancy.label.categoryIds'),
            'positionIds' => Yii::t('main', 'vacancy.label.positionIds'),
            'educationIds' => Yii::t('main', 'vacancy.label.educationIds'),
        ];
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
            'user' => [
                self::BELONGS_TO,
                User::class,
                'user_id',
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