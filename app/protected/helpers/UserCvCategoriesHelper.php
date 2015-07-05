<?php

class UserCvCategoriesHelper extends CategoriesHelper
{
    /**
     * @inheritdoc
     */
    static function attributeName()
    {
        return 'cvCategories';
    }

    /**
     * @return string field name
     */
    static function fieldName()
    {
        return 'categories';
    }

}