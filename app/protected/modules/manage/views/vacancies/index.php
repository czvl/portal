<?php
/**
 * @var $model Vacancy
 * @var $dataProvider CDataProvider
 * @var $this VacanciesController
 */

$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $dataProvider,
    'filter' => null,
    'columns' => [
        'id',
        'city.city_name',
        'name',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                    return CHtml::link($object->company->name,'#');
            },
            'type' => 'raw',
            'header' => 'Company',
        ],
        'housing:boolean',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return $object->user->first_name . " " . $object->user->phone;
            },
            'header' => 'Contact',
        ],
        'updated_at',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                    return CHtml::link(TbHtml::icon(TbHtml::ICON_EDIT), [
                        "vacancies/update", 'id' => $object->id,
                    ]);
            },
            'type' => 'raw',
        ],
    ],
]);
