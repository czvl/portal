<?php

/**
 * Class UserToCompany
 * @property int $user_id
 * @property int $company_id
 */
class UserToCompany extends CActiveRecord
{

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'user_to_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'company_id'], 'required'],
            [['user_id', 'company_id'], 'numerical']
        ];
    }

    /**
     * @return UserToCompany
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}