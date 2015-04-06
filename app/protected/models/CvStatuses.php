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
 */
class CvStatuses extends CActiveRecord
{

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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cv_id, message', 'required'),
            array('cv_id, operator_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cv_id, operator_id, message, added_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'operator' => array(self::BELONGS_TO, 'User', 'operator_id'),
            'cv' => array(self::BELONGS_TO, 'CvList', 'cv_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cv_id' => 'Cv',
            'operator_id' => 'Operator',
            'message' => 'Message',
            'added_time' => 'Added Time',
        );
    }
    
    public function defaultScope()
    {
        return array(
            'order' => 'added_time ASC',
        );
    }

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
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CvStatuses the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
