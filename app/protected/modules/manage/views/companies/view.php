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

<?php if(Yii::app()->user->checkAccess(User::ROLE_ADMIN)): ?>

<p><?= CHtml::link('Видалити',
                   array("companies/delete/id/{$company->id}"),
                   array('class'=>'btn btn-danger')); ?>
</p>

<?php endif; ?>

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