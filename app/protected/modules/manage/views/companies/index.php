<?php
/**
 * @var $model Company
 * @var $this CompaniesController
 */
?>

    <h1><?= Yii::t('main', 'companies')?></h1>

<?php
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
        ],
        [
            'class' => CDataColumn::class,
            'value' => function (Company $object) {
                return
                    CHtml::link(TbHtml::icon(TbHtml::ICON_EYE_OPEN), [
                        "companies/view",
                        'id' => $object->id,
                    ]);

            },
            'type' => 'raw',
        ],
    ]
]);
