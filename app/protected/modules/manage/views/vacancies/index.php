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
    'afterAjaxUpdate' => "function(id,data){
        var close_time = $('#Vacancy_close_time').val();
        jQuery('#Vacancy_close_time').datepicker(jQuery.extend({showMonthAfterYear:false},
        jQuery.datepicker.regional['ru'],{'dateFormat':'yy-mm-dd'}));
    }",
    'filter' => $model,
    'columns' => [
        'id',
        [
            'class' => CDataColumn::class,
            'name' => 'city_id',
            'value' => function(Vacancy $object){
                return $object->city->city_name;
            },
            'type' => 'raw',
            'header' => Yii::t('main', 'city.name'),
        ],        'name',
        [
            'class' => CDataColumn::class,
            'name' => 'company_id',
            'value' => function(Vacancy $company){
                    return CHtml::link($company->company->name, [
                        'companies/view', 'id' => $company->company_id
                    ]);
            },
            'type' => 'raw',
            'header' => Yii::t('main', 'company.name'),
        ],
        [
            'name'=>'housing',
            'value' => "housing?'Так':'Нi'",
            'filter' => array(0 => Yii::t('app', 'Так'), 1 => Yii::t('app', 'Нi')),
        ],
        [
            'name' => 'user_id',
            'value' => function(Vacancy $object){
                return $object->user->first_name . " " . $object->user->phone;
            },
            'header' => Yii::t('main', 'vacancy.label.user'),
        ],
        array(
            'name' => 'close_time',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model,
                'attribute'=>'close_time',
                'language' => 'ru',

            'options' => array(
                'dateFormat'=>'yy-mm-dd',
            ),
            ),
                true), // (#4)
        ),
        [
            'name' => 'status',
            'filter' => array(0 => Yii::t('app', 'Закрита'), 1 => Yii::t('app', 'Вiдкрита')),
            'value' => function(Vacancy $vacancy){
                return VacancyHelper::statusName($vacancy);
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
