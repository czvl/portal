<?php

class RegisterCompanyForm extends CFormModel
{

    /**
     * Company
     */
    public $name;
    public $site_url;
    public $address;

    /**
     * User
     */
    public $first_name;
    public $last_name;
    public $username;
    public $position;
    public $email;
    public $phone;
    public $password;
    public $repeat_password;

    public function rules()
    {
        return array(
            ['username, email, name, phone, password, first_name, last_name, repeat_password, address', 'required'],
            ['password, repeat_password', 'length', 'min' => 6, 'max' => 25],
            ['name, position', 'length', 'min' => 5, 'max' => 255],
            ['password', 'compare', 'compareAttribute' => 'repeat_password'],
            ['username', 'usernameUniqueValidator'],
            ['username', 'length', 'min' => 3, 'max' => 25],
            ['email', 'email'],
            ['email', 'emailUniqueValidator'],
        );
    }

    public function usernameUniqueValidator()
    {
        $user = User::model()->find('username=:username', [':username' => $this->username]);
        if($user) {
            $this->addError('username', 'Username already used');
        }
    }

    public function emailUniqueValidator()
    {
        $user = User::model()->find('email=:email', [':email' => $this->email]);
        if($user) {
            $this->addError('email', 'Email already used');
        }
    }

    public function register()
    {
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->position = $this->position;
        $user->phone = $this->phone;
        $user->password = $this->password;
        $user->username = $this->username;
        $user->role = User::ROLE_EMPL;
        $user->status = User::STATUS_DISABLED;
        $user->hash = md5(microtime(true).rand());

        if(!$user->save()) {
            $this->addError('username', 'Can`t create user '. serialize($user->getErrors()));
            return false;
        }

        UserHelper::sendEmailConfirmation($user);

        $company = new Company();
        $company->name = $this->name;
        $company->site_url = $this->site_url;
        $company->address = $this->address;
        $company->created_at = new CDbExpression('NOW()');
        $company->updated_at = new CDbExpression('NOW()');

        if(!$company->save()) {
            $this->addError('name', 'Can`t create company ' . serialize($company->getErrors()));
            return false;
        }

        $bind = new UserToCompany();
        $bind->user_id = $user->id;
        $bind->company_id = $company->id;

        if(!$bind->save()) {
            $this->addError('name', 'Can`t bind company ' . serialize($bind->getErrors()));
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => Yii::t('main', 'Username'),
            'phone' => Yii::t('main', 'phone'),
            'name' => Yii::t('main', 'company.name'),
            'address' => Yii::t('main', 'company.address'),
            'position' => Yii::t('main', 'user.position'),
            'password' => Yii::t('main', 'Password'),
            'repeat_password' => Yii::t('main', 'Password repeat'),
            'email' => Yii::t('main', 'Email'),
            'first_name' => Yii::t('main', 'First name'),
            'last_name' => Yii::t('main', 'Last name'),
        );
    }

}