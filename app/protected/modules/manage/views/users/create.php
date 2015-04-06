<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'Управління'),
    array('label' => 'Список користувачів', 'url' => array('index')),
);
?>

<?php echo TbHtml::pageHeader('Створити користувача', ''); ?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>