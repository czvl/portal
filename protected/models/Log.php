<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property integer $user_id
 * @property string $action
 * @property string $action_time
 */
class Log extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'logs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('action', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('action', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, action, action_time', 'safe', 'on' => 'search'),
        );
    }

    public function primaryKey()
    {
        return array('user_id', 'action_time');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'Користувач',
            'action' => 'Дія',
            'action_time' => 'Коли',
        );
    }
    
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->user_id = Yii::app()->user->id;
            $this->action_time = new CDbExpression('NOW()');
            return true;
        } else {
            return false;
        }
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
        
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('action_time', $this->action_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Logs the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
