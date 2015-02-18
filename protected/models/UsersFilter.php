<?php

/**
 * This is the model class for table "users_filter".
 *
 * The followings are the available columns in table 'users_filter':
 * @property integer $id
 * @property integer $user_id
 * @property string $filter
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class UsersFilter extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_filter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, filter', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, filter', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'filter' => 'Filter',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('filter',$this->filter,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersFilter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function getAllowed() {
		return [
			'status',
			'last_name',
			'first_name',
			//'internal_num',
			'gender',
			'recruiter_id',
			'contact_phone',
			'email',
			'locations',
			'residencies',
			'categories',
			'positions',
			'assistanceIds',
			'licensesIds'
		];
	}


	public function setFilter( $user_id, $filter ) {
		if( !is_array($filter) ) return [];

		foreach( $filter as $key => $value ) {
			if( !in_array($key, $this->getAllowed()) || $value == '' ) {
				unset( $filter[$key] );
			}
		}

		$item = self::model()->findByAttributes(['user_id' => $user_id]);
		if( is_null($item) ) {
			$item = new self();
			$item->user_id = $user_id;
		}

		$item->filter = json_encode($filter);
		$item->save();

		return $filter;
	}


	public function getFilter( $user_id ) {
		$item = self::model()->findByAttributes(['user_id' => $user_id]);
		if( is_null($item) ) return array();

		return json_decode($item->filter, true);
	}


}
