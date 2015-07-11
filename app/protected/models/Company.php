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
 * @property User[] $users
 */
class Company extends CActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name, address', 'required'],
            ['address', 'length', 'max' => 1000],
            ['name', 'length', 'min' => 5],
        ];
    }

    /**
     * @param string $className
     * @return Company
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('main', 'company.name'),
            'address' => Yii::t('main', 'company.address'),
            'site_url' => Yii::t('main', 'company.site_url'),
            'created_at' => Yii::t('main', 'company.created_at'),
            'updated_at' => Yii::t('main', 'company.updated_at'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'users' => [
                self::MANY_MANY,
                User::class,
                'user_to_company(company_id, user_id)',
            ]
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('site_url', $this->site_url, true);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}