<?php

/**
 * @property $id
 * @property $name
 * @property $category_id
 * @property $site_url
 * @property $phone
 * @property $email
 * @property $status
 * @property $priority
 * @property $created_at
 * @property $updated_at
 */
class Company extends CActiveRecord
{
   public function tableName()
   {
       return 'companies';
   }

    public function rules()
    {
        return [
            ['name, phone, email', 'required'],
            ['name', 'length', 'min' => 5],
            ['email', 'email']
        ];
    }

    /**
     * @param string $className
     * @return Company
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}