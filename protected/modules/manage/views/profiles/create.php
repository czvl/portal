<?php
/* @var $this ProfilesController */
/* @var $model CvList */
?>

<?php
$this->breadcrumbs = array(
    'Cv Lists' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'Список претендентів', 'url' => array('index')),
);
?>

<h1>Додати анкету</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>