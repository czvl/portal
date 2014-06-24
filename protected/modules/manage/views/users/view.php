<?php

/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Управління'),
    array('label' => 'Список користувачів', 'url' => array('index')),
    array('label' => 'Створити нового', 'url' => array('create')),
    array('label' => 'Редагувати дані', 'url' => array('update', 'id' => $model->id)),
    TbHtml::menuDivider(),
    array('label' => 'Адмінистративна частина'),
    array('label' => 'Видалити користувача', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Ви впевнені?')),
);
?>

<?php echo TbHtml::pageHeader('Користувач "' . $model->first_name . ' ' . $model->last_name . '"', ''); ?>

<?php

$this->widget('bootstrap.widgets.TbDetailView', array(
    'type' => 'bordered condensed',
    'data' => $model,
    'attributes' => array(
        'username',
        'email',
        array(
            'name' => 'signin_time',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->signin_time, "long")
        ),
        array(
            'name' => 'last_login',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->last_login, "long")
        ),
        array(
            'name' => 'role',
            'value' => $model->roles[$model->role]
        ),
        array(
            'name' => 'status',
            'value' => $model->statusTypes[$model->status]
        )
    ),
));
?>
