<?php
/**
 * @var $model Company
 * @var $this CompaniesController
 */

$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'id',
        'name',
        'address',
        'site_url:url',
        [
            'class' => CDataColumn::class,
            'value' => function(Company $object){
                return CHtml::link(Yii::t('main', 'vacancy.create.link'),
                    $this->createUrl("vacancies/create", ['id' => $object->id]));
            },
            'type' => 'raw'
        ]
    ]
]);
