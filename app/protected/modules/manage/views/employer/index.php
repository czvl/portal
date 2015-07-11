<?php
/**
 * @var $dataProvider CDataProvider
 * @var $this VacanciesController
 */

$this->menu = array(
    array('label' => Yii::t('main', 'vacancy.create.link'), 'url' => array('create_vacancy')),

);


$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $dataProvider,
    'filter' => null,
    'columns' => [
        'id',
        'name',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return $object->user->first_name . " " . $object->user->phone;
            },
            'header' => Yii::t('main', 'vacancy.label.user'),
        ],
        'city.city_name',
        'close_time:date',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $vacancy){
                return VacancyHelper::statusName($vacancy);
            },
            'header' => Yii::t('main', 'vacancy.label.status'),
        ],
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return CHtml::link(TbHtml::icon(TbHtml::ICON_EDIT), [
                    "update_vacancy", 'id' => $object->id,
                ]);
            },
            'type' => 'raw',
        ],
    ],
]);
