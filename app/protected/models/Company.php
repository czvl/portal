<?php

/**
 * @property $id
 * @property $name
 * @property $site_url
 * @property $address
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
            ['name, phone, address', 'required'],
            ['address', 'length', 'max' => 1000],
            ['name', 'length', 'min' => 5],
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