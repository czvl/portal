<?php

/* @var $this ProfilesController */
/* @var $model CvList */
?>

<?php

$this->breadcrumbs = array(
    'Cv Lists' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'Список претендентів', 'url' => array('index')),
    array('label' => 'Додати анкету', 'url' => array('create')),
);
?>

<?php echo TbHtml::lead('Редагувати анкету &laquo;' . $model->first_name . ' ' . $model->last_name . '&raquo;'); ?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>