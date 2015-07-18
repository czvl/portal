<?php
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гість',
        'bizRule' => null,
        'data' => null
    ),
    'applicant' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Претендент',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'volunteer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Волонтер',
        'bizRule' => null,
        'data' => null
    ),
    'employer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Роботодавець',
        'bizRule' => null,
        'data' => null
    ),
    'manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Менеджер',
        'children' => array(
            'volunteer'
        ),
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Адміністратор',
        'children' => array(
            'manager',
            'volunteer',
        ),
        'bizRule' => null,
        'data' => null
    ),
);