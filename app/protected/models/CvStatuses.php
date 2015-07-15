<?php

/**
 * This is the model class for table "cv_statuses".
 *
 * The followings are the available columns in table 'cv_statuses':
 * @property integer $id
 * @property integer $cv_id
 * @property integer $operator_id
 * @property string $message
 * @property string $added_time
 *
 * The followings are the available model relations:
 * @property User $operator
 * @property CvList $cv
 * @property Vacancy[] $vacancies
 */
class CvStatuses extends CActiveRecord
{

    public $vacancyIds;
    private $vacancyIdsArray;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cv_statuses';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            ['cv_id, message', 'required'],
            ['cv_id, operator_id', 'numerical', 'integerOnly' => true],
            ['vacancyIds', 'validateVacancyIds'],
            ['id, cv_id, operator_id, message, added_time', 'safe', 'on' => 'search'],
        );
    }

    public function validateVacancyIds()
    {
        $ids = array_map(
            function ($id) {
                return (int)$id;
            }, explode(",", trim( $this->vacancyIds, "\t\n\r\0\x0B,;.")));

        if(!empty($this->vacancyIds)) {
            if(!preg_match("/^[0-9\,\s]+$/", $this->vacancyIds)) {
                $this->addError('vacancyIds', Yii::t('main', 'cv_status.incorrectVacancyIds'));
                return;
            }
        } else {
            return;
        }

        $db = Yii::app()->db->createCommand();
        /* @var $db CDbCommand */

        $exists = $db->select('id')
            ->from('vacancies')
            ->where(['in', 'id', $ids])
            ->queryColumn();

        if (count($exists) !== count($ids)) {

            sort($exists);
            sort($ids);

            $this->addError('vacancyIds', Yii::t('main', 'cv_status.notFoundVacancyIds', [
                ':ids' => implode(",", array_diff($ids, $exists)),
            ]));
        }

        $this->vacancyIdsArray = $ids;
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'operator' => [self::BELONGS_TO, User::class, 'operator_id'],
            'cv' => [self::BELONGS_TO, CvList::class, 'cv_id'],
            'vacancies' => [
                self::MANY_MANY,
                Vacancy::class,
                'cv_status_to_vacancy(cv_status_id, vacancy_id)',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cv_id' => 'Cv',
            'operator_id' => 'Operator',
            'message' => Yii::t('main', 'cv_status.massage.label'),
            'added_time' => 'Added Time',
            'vacancyIds' => Yii::t('main', 'vacancy.ids.label'),
        );
    }

    /**
     * @inheritdoc
     */
    public function defaultScope()
    {
        return array(
            'order' => 'added_time ASC',
        );
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->operator_id = Yii::app()->user->id;
            $this->added_time = new CDbExpression('NOW()');
            
            $cv = CvList::model()->findByPk($this->cv_id);
            $cv->last_update = new CDbExpression('NOW()');
            $cv->save(false);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function afterSave()
    {
        if($this->scenario == 'insert') {
            foreach($this->vacancyIdsArray as $vacancyId) {
                $cvStatusToVacancy = new CvStatusToVacancy();
                $cvStatusToVacancy->cv_status_id = $this->id;
                $cvStatusToVacancy->vacancy_id = $vacancyId;
                $cvStatusToVacancy->save();
//                var_dump($cvStatusToVacancy->getErrors());
//                die;
            }
        }
    }

    /**     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cv_id', $this->cv_id);
        $criteria->compare('operator_id', $this->operator_id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('added_time', $this->added_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @inheritdoc
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
