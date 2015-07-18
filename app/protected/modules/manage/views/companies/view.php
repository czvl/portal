<?php
/**
 * @var $company Company
 * @var $usersDataProvider CDataProvider
 * @var $this Controller
 */

$this->menu = [
    ['label' => Yii::t('main', 'vacancy.create.link'), 'url' => ['vacancies/create', 'id' => $company->id]]
];
?>

    <h1><?= Yii::t('main', 'company') ?> <?= $company->name ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', [
        'data' => $company,
    ]
);
$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $usersDataProvider,
    'filter' => null,
    'columns' => [
        'firstLastName',
        'username',
        'position',
        'phone',
        'additional_contact',
        [
            'name' => 'status',
            'value' => '$data->statusTypes[$data->status]',
        ]
    ]
]);