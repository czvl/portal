<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs = array(
    'Список користувачів' => array('index'),
);

$this->menu = array(
    array('label' => 'Список користувачів', 'url' => array('index')),
    array('label' => 'Додати користувача', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $('#user-grid').yiiGridView('update', {
                    data: $(this).serialize()
            });
            return false;
    });
");

?>

<h1>Керування користувачами</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php //$this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{items}",
    'columns' => array(
        'username',
        'email',
        'first_name',
        'last_name',
        array(
            'name' => 'role',
            'value' => '$data->roles[$data->role]',
            'filter' => $model->roles
        ),
//        'last_login',
        array(
            'name' => 'status',
            'value' => '$data->statusTypes[$data->status]',
            'filter' => $model->statusTypes
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
