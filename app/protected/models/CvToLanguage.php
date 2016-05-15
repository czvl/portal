<?php

/**
 * This is the model class for table "cv_to_language".
 *
 * The followings are the available columns in table 'cv_to_language:
 * @property integer $cv_id
 * @property string $language_id
 */

class CvToLanguage extends CActiveRecord

{
    public function tableName()
    {
        return 'cv_to_language';
    }

    public function rules()
    {
        return array (
            array('cv_id', 'required'),
            array('language_id', 'required'),
            array('cv_id, language_id', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'cv_id' => 'Cv',
            'language_id' => 'Language',
        );
    }

    public function relations()
    {
        return array(
        );
    }


    public function search()

    {
        $criteria = new CDbCriteria;
        $criteria->compare('cv_id', $this->cv_id);
        $criteria->compare('language_id', $this->language_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }



    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}