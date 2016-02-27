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
     * The same as CHtml::checkBoxList, but with js handlers to limit the number
     * of choices in the list
     * 
     * @param  [type] $model       [description]
     * @param  [type] $attribute   [description]
     * @param  [type] $data        [description]
     * @param  array  $htmlOptions [description]
     * @param  integer $maxLimit
     * @return string  checkBoxList
     */
    public static function checkBoxListLimited($model,$attribute,$data,$htmlOptions=array(), $maxLimit)
    {

        if (isset($maxLimit) && $maxLimit > 0) {

            // javascript function that performs validation of number of checkboxes clicked in a list. When number of checkboxes clicked reaches maxLimit it grays out non-clicked checkboxes. Otherwise it makes available all checkboxes in a list.
            $js=<<<EOD
function checkboxClickedLimit(maxLimit){
    var checkboxes = arguments[1].parentNode.parentNode.getElementsByTagName("input");

    // Get number of checked checkboxes
    var checkedCounter = 0;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked)
            checkedCounter++;
    }

    // If limit of checked succeeded mark all other checkboxes as read only, otherwise make all checkboxes updateable
    if (checkedCounter >= maxLimit) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (!checkboxes[i].checked) {
                checkboxes[i].disabled = true;
                checkboxes[i].parentNode.className = "checkbox-disabled";
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].disabled = false;
                checkboxes[i].parentNode.className = "checkbox-enabled";
        }
    }
}
EOD;

            $cs=Yii::app()->getClientScript();
            $cs->registerScript('checkboxClickedLimit', $js,  CClientScript::POS_END);

            // add event to all of the checkboxes in a list
            $htmlOptions['onchange'] = 'javascript:checkboxClickedLimit(' . $maxLimit . ', this);';

            return CHtml::activeCheckBoxList($model,$attribute,$data,$htmlOptions);
        }
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
