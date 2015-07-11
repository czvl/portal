<?php
/**
 * @var $model Vacancy
 * @var $dataProvider CDataProvider
 * @var $this VacanciesController
 */
?>

    <h1><?= Yii::t('main', 'vacancy.list')?></h1>

<?php
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
                    return CHtml::link($object->company->name, [
                        'companies/view', 'id' => $object->company_id
                    ]);
            },
            'type' => 'raw',
            'header' => Yii::t('main', 'vacancy.label.company'),
        ],
        'housing:boolean',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return $object->user->first_name . " " . $object->user->phone;
            },
            'header' => Yii::t('main', 'vacancy.label.user'),
        ],
        'close_time',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $vacancy){
                VacancyHelper::statusName($vacancy);
            },
            'header' => Yii::t('main', 'vacancy.label.status'),
        ],
        [
            'class' => CDataColumn::class,
            'value' => function (Vacancy $object) {
                return
                    CHtml::link(TbHtml::icon(TbHtml::ICON_EYE_OPEN), [
                        "vacancies/view",
                        'id' => $object->id,
                    ])
                    . ' ' .
                    CHtml::link(TbHtml::icon(TbHtml::ICON_EDIT), [
                        "vacancies/update",
                        'id' => $object->id,
                    ]);

            },
            'type' => 'raw',
        ],
    ],
]);
