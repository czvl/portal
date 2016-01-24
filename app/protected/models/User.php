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
 * @property string $phone
 * @property string $position
 * @property string $additional_contact
 * @property string $role
 * @property string $signin_time
 * @property string $last_login
 * @property integer $status
 * @property string $hash
 * @property string $email_activated
 *
 * The followings are the available model relations:
 * @property CvList[] $cvLists
 * @property CvStatuses[] $cvStatuses
 * @property CvCategories[] $cvCategories
 * @property CitiesList[] $citiesList
 * @property Company|null[] $company
 */
class User extends CActiveRecord
{

    const ROLE_ADMIN = 'administrator';
    const ROLE_MANAGER = 'manager';
    const ROLE_EMPL = 'employer';
    const ROLE_VOLONT = 'volunteer';
    const ROLE_APPLIC = 'applicant';

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    public $password_repeat = '';
    public $password_new = '';
    public $statusTypes;

    private  $_roles = array();

    /**
     * @inheritdoc
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->statusTypes = Yii::app()->config->user_statuses;
    }

    /**
     * @inheritdoc
     */
    public function defaultScope()
    {
        return array(
            'order' => 'signin_time DESC',
        );
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
            ['username', 'unique'],
            ['username, role, email', 'required'],
            ['email', 'email'],
            ['password, password_repeat, phone, hash', 'length', 'max' => 32],
            ['password, password_repeat', 'required', 'on' => 'create'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'create'],

            ['password_repeat', 'compare', 'compareAttribute' => 'password_new', 'on' => 'update'],
            ['password_new, password_repeat', 'safe', 'on' => 'update'],

            ['status', 'numerical', 'integerOnly' => true],
            ['username, email, role, first_name, last_name, additional_contact, position', 'length', 'max' => 255],
            ['signin_time, last_login, email_activated', 'safe'],
            ['username, role', 'safe', 'on' => 'search'],
            ['phone', 'match', 'pattern'=>'/^([+]?[0-9 \)\(\-]+)$/']
        );
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return array(
            'cvLists' => array(self::HAS_MANY, 'CvList', 'recruiter_id'),
            'cvStatuses' => array(self::HAS_MANY, 'CvStatuses', 'operator_id'),
            'cvCategories'=>array(self::MANY_MANY, 'CvCategories',
                'user_to_cv_categories(user_id, cv_category_id)'),
            'citiesList'=>array(self::MANY_MANY, 'CitiesList',
                'user_to_cities(user_id, city_index)'),
            'companiesList' => [self::MANY_MANY, 'Company',
                'user_to_company(user_id, company_id)']
        );
    }

    /**
     * @inheritdoc
     */
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
     * @inheritdoc
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
            'firstLastName' => Yii::t('main', 'user.firstLastName'),
            'position' => Yii::t('main', 'user.position'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        if (Yii::app()->user->role == User::ROLE_MANAGER) {
            $criteria->addNotInCondition("role", array(User::ROLE_MANAGER, User::ROLE_ADMIN));
        }

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

    public function getRoles()
    {
        if (empty($this->_roles)) {
            $authRoles = Yii::app()->config->auth;

            foreach ($authRoles as $key => $item) {
                if (Yii::app()->user->role == "administrator" || !in_array($key, array('guest', 'manager', 'administrator'))) {
                    $this->_roles[$key] = $item['description'];
                }
            }
        }

        return $this->_roles;
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
        $criteria->order = 'first_name';

        $models = User::model()->findAll($criteria);
        $list = CHtml::listData($models, 'id', 'firstLastName');

        return $list;
    }

}
