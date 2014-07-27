<?php

/**
 * This is the model class for table "edb_users".
 *
 * The followings are the available columns in table 'edb_users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property string $signin_time
 * @property string $last_login
 * @property integer $status
 * 
 * The followings are the available model relations:
 * @property CvList[] $cvLists
 * @property CvStatuses[] $cvStatuses
 */
class User extends CActiveRecord
{

    const ROLE_ADMIN = 'administrator';
    const ROLE_EMPL = 'employer';
    const ROLE_VOLONT = 'volunteer';
    const ROLE_APPLIC = 'applicant';

    public $password_repeat = '';
    public $password_new = '';
    public $roles = array();
    
    public $statusTypes;

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        parent::init();
        
        $controller = Yii::app()->getController();
        $authRoles = $controller->loadConfigFromFile('auth');
        foreach ($authRoles as $key => $item) {
            if ($key != 'guest') {
                $this->roles[$key] = $item['description'];
            }
        }
        
        $this->statusTypes = $controller->loadConfigFromFile('user_statuses');
    }

    public function defaultScope()
    {
        return array(
            'order' => 'signin_time DESC',
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username', 'unique'),
            array('username, role, email', 'required'),
            array('password, password_repeat', 'length', 'max' => 32),
            array('password, password_repeat', 'required', 'on' => 'create'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'create'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password_new', 'on' => 'update'),
            array('password_new', 'safe', 'on' => 'update'),
            array('status', 'numerical', 'integerOnly' => true),
            array('username, email, role, first_name, last_name', 'length', 'max' => 255),
            array('signin_time, last_login', 'safe'),
            array('username, role', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'cvLists' => array(self::HAS_MANY, 'CvList', 'recruiter_id'),
            'cvStatuses' => array(self::HAS_MANY, 'CvStatuses', 'operator_id'),
        );
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $userSalt = base64_encode(mcrypt_create_iv(30));
            if ($this->isNewRecord) {
                $this->signin_time = new CDbExpression('NOW()');
                $this->password = crypt($this->password, $userSalt);
            }
            if ($this->password_new) {
                $this->password = crypt($this->password_new, $userSalt);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => Yii::t('main', 'Username'),
            'password' => Yii::t('main', 'Password'),
            'password_repeat' => Yii::t('main', 'Password repeat'),
            'password_new' => Yii::t('main', 'Password new'),
            'email' => Yii::t('main', 'Email'),
            'role' => Yii::t('main', 'Role'),
            'first_name' => Yii::t('main', 'First name'),
            'last_name' => Yii::t('main', 'Last name'),
            'signin_time' => Yii::t('main', 'Registration time'),
            'last_login' => Yii::t('main', 'Last login at'), 
            'status' => Yii::t('main', 'Status'), 
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('signin_time', $this->signin_time, true);
        $criteria->compare('last_login', $this->last_login, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getFirstLastName()
    {
        return $this->first_name . " " . $this->last_name;
    }
    
    public function getRecruiters()
    {
        $recruitersRoles = array(self::ROLE_VOLONT, self::ROLE_ADMIN);
        
        $criteria = new CDbCriteria;
        $criteria->addInCondition('role', $recruitersRoles);

        $models = User::model()->findAll($criteria);
        $list = CHtml::listData($models, 'id', 'firstLastName');
        
        return $list;
    }

}
