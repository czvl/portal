<?php

/**
 * This is the model class for table "foreign_languages".
 *
 * The followings are the available columns in table 'foreign_languages':
 * @property integer $id
 * @property string $name
 * @property string $level
 *
 * The followings are the available model relations:
 * @property CvToLanguage[] $cvToLanguage
 */

class ForeignLanguages extends CActiveRecord{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'foreign_languages';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('level', 'required'),
            // rules used by search()
            array('id', 'name', 'level', 'safe', 'on'=>'search')
        );
    }

    // model relations

    public function relations() {
        return array  (
            'cvToLanguage' => array(self::MANY_MANY, 'cvList', 'cv_to_language(language_id, cv_id)')
        );
    }

    public function attributeLabels() {
        return array (
            'id' => 'Id',
            'name ' => 'Name',
            'level' => 'Level',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name);
        $criteria->compare('level', $this->level);

        return new CActiveDataProvider($this, array (
            'criteria' => $criteria,
        ));



    }

    public function findByLanguage($languageName) {
        return $this->findAllByAttributes(array('origin'=>$languageName));
    }

    public function getLevelFormat() {
        return "{$this->name} - {$this->level}";
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}