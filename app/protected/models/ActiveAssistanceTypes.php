<?php

/**
 *
 */
class ActiveAssistanceTypes extends AssistanceTypes
{
    static function model($className=__CLASS__) {
        return parent::model($className);
    }

    function defaultScope(){
        return [
            'condition' => "active = true",
        ];
    }
}

 ?>
