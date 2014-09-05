<?php
/* @var $this ProfilesController */
/* @var $model CvList */
?>

<?php
$this->breadcrumbs = array(
    'Cv Lists' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Меню'),
    array('label' => 'Список претендентів', 'url' => array('index')),
    array('label' => 'Додати анкету', 'url' => array('create')),
//    TbHtml::menuDivider(),
//    array('label' => 'Адмінистративна частина'),
//    array(
//        'label' => 'Видалити анкету', 
//        'url' => '#', 
//        'linkOptions' => array(
//            'submit' => array('delete', 'id' => $model->id), 
//            'confirm' => 'Ви впевнені, що бажаєте видатили цю анкету?'
//        )
//    ),
);
?>

<?php echo TbHtml::pageHeader('Анкета "' . $model->firstLastName . '"', ''); ?>

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'cvstatus-form',
        'enableClientValidation' => true,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'clientOptions' => array('validateOnSubmit' => true),
    ));
?>
    <?php echo $form->dropDownList($model, 'status', $model->statusTypes, array('span' => 5)); ?>&nbsp;
    <?php echo TbHtml::submitButton('Оновити', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'class' => 'inline')); ?>
<?php $this->endWidget(); ?>

<?php 

echo TbHtml::lead('Статуси про претендента &laquo;' . $model->first_name . ' ' . $model->last_name . '&raquo;');

$statusList = array();
foreach ($model->cvStatuses as $s) {
    $date = Yii::app()->dateFormatter->formatDateTime($s->added_time, "long");
    $from = $s->operator->first_name . ' ' . $s->operator->last_name;
    
    echo TbHtml::quote(nl2br($s->message), array(
        'source' => '',
        'cite' => "Опубліковано " . $date . " (" . CHtml::link($from, array('/manage/reqruiter', 'id' => $s->operator->id)) . ")"
    ));
}
?>
<hr />
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php echo TbHtml::lead('Оновити статус:'); ?>
<a name="statuses"></a>
<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'status-form',
        'enableClientValidation' => true,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
?>
        <fieldset>
            <?php echo $form->hiddenField($status, 'cv_id',array('value'=> $model->id)); ?>
            <?php echo $form->textArea($status, 'message', array('rows' => 5, 'cols' => 100, 'placeholder' => 'Ваш комментар', 'style' => 'width: 98%;')); ?>
            <?php echo TbHtml::formActions(array(
                TbHtml::submitButton('Додати', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
                TbHtml::resetButton('Очистити'),
            )); ?>
        </fieldset>
        
<?php $this->endWidget(); ?>

<p><?php echo TbHtml::submitButton('Редагувати анкету', array('submit' => array('/manage/profiles/update', 'id' => $model->id), 'color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?></p>

<?php

$this->widget('bootstrap.widgets.TbDetailView', array(
    'type' => 'bordered condensed',
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'status',
            'value' => $model->statusTypes[$model->status]
        ),
        'first_name',
        'last_name',
        array(
            'name' => 'gender',
            'value' => $model->genderTypes[$model->gender]
        ),
        array(
            'name' => 'birth_date',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->birth_date, "long", false) . " (" . $this->getTimeDiff($model->birth_date) . ")"
        ),
        'contact_phone',
        'email:email',
        array(
            'name' => 'residenciesIds',
            'value' => implode(', ', array_values(CHtml::listData($model->citiesResidence, 'city_index', 'city_name')))
        ),
        array(
            'name' => 'education',
            'value' => $model->educationTypes[$model->education]
        ),
        'eduction_info:ntext',
        'work_experience:ntext',
        'skills:ntext',
        'summary:ntext',
        array(
            'name' => 'categoryIds',
            'value' => implode(', ', array_values(CHtml::listData($model->categories, 'id', 'name'))),
            'type' => 'html'
        ),
        'desired_position',
        array(
            'name' => 'positionsIds',
            'value' => implode(', ', array_values(CHtml::listData($model->positions, 'id', 'name')))
        ),
        'salary',
        array(
            'name' => 'jobLocationsIds',
            'value' => implode(', ', array_values(CHtml::listData($model->citiesJobLocations, 'city_index', 'city_name')))
        ),
        'documents',
        array(
            'name' => 'driverLicensesIds',
            'value' => implode(', ', array_values(CHtml::listData($model->driverLicensesTypes, 'id', 'name')))
        ),
        'applicant_type',
        'cv_file:url',
        array(
            'name' => 'assistanceIds',
            'value' => $model->assistances,
            'type' => 'html'
        ),
        array(
            'name' => 'recruiter_id',
            'value' => (isset($model->recruiter->last_name)) ? CHtml::link($model->recruiter->first_name. " " .$model->recruiter->last_name, array('/manage/reqruiter', 'id' => $model->recruiter->id)) : '',
            'type' => 'html'
        ),
        'recruiter_comments:ntext',
        'who_filled',
        array(
            'name' => 'added_time',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->added_time, "long"),
            'type' => 'html'
        )
    ),
));
