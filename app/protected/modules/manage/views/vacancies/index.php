<?php
/**
 * @var $model Vacancy
 * @var $dataProvider CDataProvider
 * @var $this VacanciesController
 */

$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => [
        'id',
        'city.city_name',
        'name',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                    return CHtml::link($object->company->name,'#');
            },
            'type' => 'raw'
        ],
        'housing:boolean',
        'updated_at',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                    return CHtml::link(TbHtml::icon(TbHtml::ICON_EDIT), [
                        "vacancies/update", 'id' => $object->id,
                    ]);
            },
            'type' => 'raw'
        ],
    ],
]);
