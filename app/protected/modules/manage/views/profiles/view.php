<?php
/* @var $this ProfilesController
 * @var $model CvList
 * @var $vacanciesDataProvider CDataProvider
 * @var $this CController
 * @var $statuses CvStatuses[]
 * @var $status CvStatuses
 */
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
    TbHtml::menuDivider(),
    array('label' => 'Адмінистративна частина'),
    array(
        'label' => 'Видалити анкету',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => 'Ви впевнені, що бажаєте видатили цю анкету?'
        ),
        'visible' => Yii::app()->user->checkAccess(User::ROLE_ADMIN)
    ),
);
?>

<?php echo TbHtml::pageHeader('Анкета "' . $model->firstLastName . '"', ''); ?>
<?php
	if (!$model->recruiter_id) {
		Yii::app()->user->setFlash(
			TbHtml::ALERT_COLOR_WARNING,
			'<h4>Увага</h4> Для продовження роботи з кандидатом, вкажіть себе в полі &laquo;Рекрутер&raquo;'
		);
	}

	$this->widget('bootstrap.widgets.TbAlert', array('block' => true));
?>

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'cvstatus-form',
        'enableClientValidation' => true,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'clientOptions' => array('validateOnSubmit' => true),
    )); /* @var $form CActiveForm*/
?>
    <?php echo $form->dropDownList($model, 'status', $model->statusTypes, array('span' => 5)); ?>&nbsp;
    <?php echo TbHtml::submitButton('Оновити', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'class' => 'inline')); ?>
<?php $this->endWidget(); ?>

<?php

echo TbHtml::lead('Статуси про претендента &laquo;' . $model->first_name . ' ' . $model->last_name . '&raquo;');

$statusList = array();
foreach ($statuses as $s) { /* @var $s CvStatuses */
    $date = Yii::app()->dateFormatter->formatDateTime($s->added_time, "long");

    $vacancies = '';
    foreach($s->vacancies as $vacancy) {
        $vacancies .= CHtml::link($vacancy->name , ['vacancies/view', 'id' => $vacancy->id])
        . " (" . VacancyHelper::statusName($vacancy) . ")";
    }

    echo TbHtml::quote(nl2br($s->message), [
            'site' => '',
            'source' => Yii::t('main',
                    'vacancy.status.posted') . ': ' . $date . " (" . CHtml::link($s->operator->getFirstLastName(),
                    array('/manage/reqruiter', 'id' => $s->operator->id)) . ")"
                . (!empty($vacancies) ? ' | ' . Yii::t('main',
                        'vacancy.status.marked') . ': ' . $vacancies . ' ' : ''),
        ]
    );
}
?>
<hr />
<?php echo TbHtml::lead('Оновити статус:'); ?>
<a name="statuses"></a>
<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'status-form',
        'enableAjaxValidation' => true,
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); /* @var $form TbActiveForm */
?>
    <fieldset>
        <?= $form->hiddenField($status, 'cv_id', ['value' => $model->id]); ?>

        <?= $form->textAreaControlGroup($status, 'message', [
            'rows' => 5,
            'cols' => 100,
            'placeholder' => Yii::t('main', 'cv_status.massage.placeholder'),
            'style' => 'width: 98%;',
        ]); ?>

        <?= $form->textFieldControlGroup($status, 'vacancyIds', [
            'placeholder' => Yii::t('main', 'vacancy.ids.placeholder')
        ]) ?>

        <?= TbHtml::formActions(array(
            TbHtml::submitButton('Додати', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
            TbHtml::resetButton('Очистити'),
        )); ?>
    </fieldset>

<?php $this->endWidget(); ?>

<p><?php echo TbHtml::submitButton('Редагувати анкету', array('submit' => array('/manage/profiles/update', 'id' => $model->id), 'color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
    <?php if(Yii::app()->user->role == 'administrator'):?>
    <?php echo TbHtml::submitButton('Видалити анкету', array('submit' => array('/manage/profiles/delete',  'id' => $model->id), 'color' => TbHtml::BUTTON_COLOR_DANGER)); ?></p>
    <?php endif; ?>

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
        'other_contacts',
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
            'name' => 'disability',
            'value' => $model->disabilityGroups[$model->disability]
        ),
        array(
            'name' => 'categoryIds',
            'value' => implode(', ', array_values(CHtml::listData($model->categories, 'id', 'name'))),
            'type' => 'html'
        ),
        'desired_position',
        array(
            'name' => 'desiredPositionsIds',
            'value' => implode(', ', array_values(CHtml::listData($model->desiredPositions, 'id', 'name')))
        ),
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
            'name' => 'applicantTypeIds',
            'value' => implode(', ', array_values(CHtml::listData($model->applicantTypes, 'id', 'name')))
        ),
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
?>

<?php echo TbHtml::lead('Можливі вакансії:'); ?>


<?php
$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $vacanciesDataProvider,
    'filter' => null,
    'columns' => [
        'id',
        'name',
        'city.city_name',
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return $object->company->name;
            },
            'header' => Yii::t('main', 'vacancy.label.company'),
        ],

        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return $object->user->first_name . " " . $object->user->phone;
            },
            'header' => Yii::t('main', 'vacancy.label.user'),
        ],
        [
            'name' => 'close_time',
            'value' => function(Vacancy $vacancy) {
                return Yii::app()->dateFormatter
                    ->formatDateTime($vacancy->close_time, "long", false);
            }
        ],
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $vacancy){
                return VacancyHelper::statusName($vacancy);
            },
            'header' => Yii::t('main', 'vacancy.label.status'),
        ],
        [
            'class' => CDataColumn::class,
            'value' => function(Vacancy $object){
                return
                    CHtml::link(TbHtml::icon(TbHtml::ICON_EYE_OPEN), [
                        "vacancies/view", 'id' => $object->id,
                    ]) . ' ' .
                    CHtml::link(TbHtml::icon(TbHtml::ICON_EDIT), [
                    "vacancies/update", 'id' => $object->id,
                ]);
            },
            'type' => 'raw',
        ],
    ],
]);
