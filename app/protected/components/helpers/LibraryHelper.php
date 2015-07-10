<?php

abstract class LibraryHelper
{

    /**
     * @return string name of attribute
     * @throws ErrorException
     */
    static function attributeName()
    {
        throw new ErrorException('You have specify attribute name');
    }

    /**
     * @return string field name
     * @throws ErrorException
     */
    static function fieldName()
    {
        throw new ErrorException('You have specify field name');
    }

    /**
     * Key-value pairs of all categories
     * @return array
     * @throws ErrorException
     */
    static function all()
    {
        throw new ErrorException('You have specify function all()');
    }

    /**
     * @return string checkbox list
     */
    public static function checkBoxList($model)
    {
        $list = CHtml::checkBoxList(static::fieldName(), self::exists($model),
            static::all(),
            [
                'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                'separator' => '',
            ]);

        return $list;
    }

    /**
     * Category ids bound for user
     * @param $model
     * @return array
     */
    public static function exists($model)
    {
        $checked = [];

        foreach ($model->{static::attributeName()} as $category) {
            array_push($checked, $category->id);
        }

        return $checked;
    }
}