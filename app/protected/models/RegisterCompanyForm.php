<?php

class RegisterCompanyForm extends CFormModel
{

    public $name;
    public $phone;
    public $site_url;

    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $repeat_password;

    public function rules()
    {
        return array(
            ['username, email, name, phone, password, first_name, last_name, repeat_password', 'required'],
            ['password, repeat_password', 'length', 'min' => 6, 'max' => 25],
            ['name', 'length', 'min' => 5, 'max' => 255],
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
        $user->phone = $this->phone;
        $user->password = $this->password;
        $user->username = $this->username;
        $user->role = User::ROLE_EMPL;

        if(!$user->save()) {
            $this->addError('username', 'Can`t create user '. serialize($user->getErrors()));
            return false;
        }

        $company = new Company();
        $company->name = $this->name;
        $company->site_url = $this->site_url;
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

}