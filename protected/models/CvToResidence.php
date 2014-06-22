<?php

/**
 * This is the model class for table "cv_to_residence".
 *
 * The followings are the available columns in table 'cv_to_residence':
 * @property integer $cv_id
 * @property string $city_id
 *
 * The followings are the available model relations:
 * @property CvList $cv
 */
class CvToResidence extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cv_to_residence';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cv_id, city_id', 'required'),
            array('cv_id', 'numerical', 'integerOnly' => true),
            array('city_id', 'length', 'max' => 4),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cv_id, city_id', 'safe', 'on' => 'search'),
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
            'cv' => array(self::BELONGS_TO, 'CvList', 'cv_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'cv_id' => 'Cv',
            'city_id' => 'City',
        );
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

        $criteria->compare('cv_id', $this->cv_id);
        $criteria->compare('city_id', $this->city_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CvToResidence the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
