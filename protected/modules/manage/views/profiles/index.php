<?php
$this->menu = array(
    array('label' => 'Додати анкету', 'url' => array('create')),
);
?>

<h1>Анкети претендентів</h1>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{items}",
    'columns' => array(
        array(
            'name' => 'id',
            'filter' => false,
        ),
        array(
            'name' => 'category_id',
            'value' => '$data->category->name',
            'filter' => CHtml::listData(CvCategories::model()->findAll(), 'id', 'name')
        ),
        'first_name',
        'last_name',
        array(
            'name' => 'gender',
            'value' => '$data->genderTypes[$data->gender]',
            'filter' => $model->genderTypes
        ),
        array(
            'name' => 'status',
            'value' => '$data->statusTypes[$data->status]',
            'filter' => $model->statusTypes
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
//                'update' => array(
//                    'url' => 'Yii::app()->controller->createUrl("ports/update", array("id"=>$data[id]))',
//                ),
                'delete' => array(
                    'visible' => 'Yii::app()->user->checkAccess(User::ROLE_ADMIN)'
                ),
            ),
        ),
    ),
));
?>