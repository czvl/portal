<?php

/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'Управління'),
    array('label' => 'Список користувачів', 'url' => array('index')),
    array('label' => 'Перегляд анкети', 'url' => array('view', 'id' => $model->id)),
);
?>

<?php echo TbHtml::lead('Редагувати дані користувача &laquo;' . $model->first_name . ' ' . $model->last_name . '&raquo;'); ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>