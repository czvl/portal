<?php
/**
 * @var $this CController
 * @var $model CvList
 */
?>

<section id="services" class="single-page scrollblock">
    <div class="container" >
        <h1>Додати анкету</h1>

        <div class="notice">
            <p><strong>Будь ласка не заповнюйте анкету вдруге!</strong></p>

            <p>Дублювання ваших даних не збільшить шанси, ще й ускладнить роботу волонтерів.</p>

            <p>Ви завжди можете написати нам <a href="mailto:czsl.staff@gmail.com">листа</a> або <a href="/#contact">зателефонувати
                    на Гарячу лінію ЦЗВЛ</a>: щоб оновити дані, дізнатись чи є нові пропозиції для вас або з будь-яких
                інших питань. Це рекомендований спосіб &laquo;просування&raquo; вашої справи.</p>
        </div>

        <div class="form">

            <?php if (filter_input(INPUT_GET, 'success')) { ?>
                <p>Ваші дані були збережені. Найближчим часом з Вами зв’яжуться наші представники.</p>
            <?php } else { ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'cv-list-form',
                'enableAjaxValidation' => true,
            )); /* @var $form CActiveForm */
            ?>

            <?php echo $form->errorSummary($model); ?>

            <p><span class="required">*</span> - поля, обов’язкові для заповнення.</p>

            <?= $form->labelEx($model, 'first_name') ?>
            <?= $form->textField($model, 'first_name', ['class' => 'span8', 'maxlength' => 255]) ?>
            <?= $form->error($model, 'first_name') ?>

            <?= $form->labelEx($model, 'last_name') ?>
            <?= $form->textField($model, 'last_name', ['class' => 'span8', 'maxlength' => 255]) ?>
            <?= $form->error($model, 'last_name') ?>

            <?= $form->label($model, 'gender') ?>
            <?= $form->dropDownList($model, 'gender', $model->genderTypes) ?>
            <?= $form->error($model, 'gender') ?>

            <?= $form->label($model, 'marital_status') ?>
            <?= $form->dropDownList($model, 'marital_status', $model->maritalStatuses['m']) ?>
            <?= $form->error($model, 'marital_status') ?>

            <?= $form->labelEx($model, 'birth_date'); ?>
            <p><?= Yii::t('main', 'user.resume.form.birth.text') ?></p>
            <?php
            $this->widget('CMaskedTextField', array(
                'model' => $model,
                'attribute' => 'birth_date',
                'mask' => '9999-99-99',
                'placeholder' => '*',
                'htmlOptions' => [
                    'class' => 'span4',
                    'style' => 'font-size: 18px;'
                ]

            ));
            ?>
            <?= $form->error($model, 'birth_date') ?>

            <?= $form->labelEx($model, 'contact_phone'); ?>
            <?php
            $this->widget('CMaskedTextField', array(
                'model' => $model,
                'attribute' => 'contact_phone',
                'mask' => UserHelper::PHONE_MASK,
                'placeholder' => '*',
            ));
            ?>
            <?= $form->error($model, 'contact_phone') ?>

            <?= $form->labelEx($model, 'email') ?>
            <?= $form->textField($model, 'email', ['class' => 'span8', 'maxlength' => 255]) ?>
            <p><?= Yii::t('main', 'user.resume.form.email.text') ?></p>
            <?= $form->error($model, 'email') ?>

            <?= $form->labelEx($model, 'other_contacts') ?>
            <?= $form->textArea($model, 'other_contacts', ['rows' => 6, 'class' => 'span8']) ?>
            <?= $form->error($model, 'other_contacts') ?>


            <?= $form->labelEx($model, 'residenciesIds'); ?>
            <div class="div-overflow">
                <?= $form->checkBoxList($model, 'residenciesIds',
                    CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index',
                        'city_name'), [
                        'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                        'separator' => '',
                    ]) ?>
            </div>
            <?= $form->error($model, 'residenciesIds') ?>

            <?= $form->labelEx($model, 'education') ?>
            <?= $form->dropDownList($model, 'education', $model->educationTypes, ['class' => 'span8']) ?>
            <?= $form->error($model, 'education') ?>

            <?= $form->labelEx($model, 'eduction_info') ?>
            <?= $form->textArea($model, 'eduction_info', ['rows' => 2, 'class' => 'span8']) ?>
            <?= $form->error($model, 'eduction_info') ?>

            <label class="control-label required" for="CvList_work_experience">
                <?= Yii::t('main', 'user.resume.form.exp.text') ?>
            </label>
            <?= $form->textArea($model, 'work_experience', array(
                'rows' => 6,
                'class' => 'span8',
            )); ?>

            <?= $form->labelEx($model, 'skills') ?>
            <?= $form->textArea($model, 'skills', [
                'rows' => 6,
                'class' => 'span8',
                'placeholder' => Yii::t('main', 'user.resume.form.skills.text')
            ]) ?>
            <?= $form->error($model, 'skills') ?>


            <?= $form->labelEx($model, 'summary') ?>
            <?= $form->textArea($model, 'summary', ['rows' => 6, 'class' => 'span8']) ?>
            <?= $form->error($model, 'summary') ?>

            <?= $form->label($model, 'disability') ?>
            <?= $form->dropDownList($model, 'disability', $model->disabilityGroups) ?>
            <?= $form->error($model, 'disability') ?>

            <?= $form->labelEx($model, 'cv_file') ?>
            <?= $form->textField($model, 'cv_file', ['class' => 'span8', 'maxlength' => 255]) ?>
            <?= $form->error($model, 'cv_file') ?>


            <?php echo $form->labelEx($model, 'desiredPositionsIds'); ?>
            <input type="text" name="desiredPositionsFilter" class="filter span8"
                   placeholder="<?= Yii::t('main', 'text.filter.placeholder') ?>"/>

            <div class="div-overflow">
                <?= $form->checkBoxList($model, 'desiredPositionsIds', PositionsHelper::all(), [
                    'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                    'separator' => '',
                ]) ?>
            </div>
            <?= $form->error($model, 'desiredPositionsIds') ?>


            <?php echo $form->labelEx($model, 'positionsIds'); ?>
            <input type="text" name="positionsFilter" class="filter span8"
                   placeholder="<?= Yii::t('main', 'text.filter.placeholder') ?>"/>

            <div class="div-overflow">
                <?= $form->checkBoxList($model, 'positionsIds', PositionsHelper::all(), [
                    'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                    'separator' => '',
                ]) ?>
            </div>

            <?= $form->labelEx($model, 'salary') ?>
            <?= $form->textField($model, 'salary', ['class' => 'span8', 'maxlength' => 255]) ?>
            <?= $form->error($model, 'salary') ?>

            <?= $form->labelEx($model, 'jobLocationsIds'); ?>

            <div class="div-overflow">
                <?php echo $form->checkBoxList($model, 'jobLocationsIds',
                    CHtml::listData(CitiesList::model()->findAll(['order' => 'city_name']), 'city_index', 'city_name'),
                    [
                        'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                        'separator' => '',
                    ]); ?>
            </div>
            <?= $form->error($model, 'jobLocationsIds'); ?>


            <?= $form->labelEx($model, 'documents') ?>
            <?= $form->textArea($model, 'documents', ['rows' => 2, 'class' => 'span8']) ?>
            <?= $form->error($model, 'documents') ?>

            <?= $form->labelEx($model, 'driverLicensesIds'); ?>
            <div class="div-overflow">
                <?= $form->checkBoxList($model, 'driverLicensesIds',
                    CHtml::listData(DriverLicenses::model()->findAll(array('order' => 'id')), 'id', 'name'),
                    [
                        'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                        'separator' => '',
                    ]); ?>
            </div>
            <?= $form->error($model, 'driverLicensesIds') ?>

            <?= $form->labelEx($model, 'applicantTypeIds'); ?>
            <div class="div-overflow">
                <?= LibraryHelper::checkBoxListLimited($model, 'applicantTypeIds',
                    ApplicantTypesHelper::all(),
                    [
                        'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                        'separator' => '',
                    ], 2); ?>
            </div>
            <?= $form->error($model, 'applicantTypeIds') ?>

            <?= $form->labelEx($model, 'assistanceIds'); ?>
            <div class="div-overflow">
                <?= $form->checkBoxList($model, 'assistanceIds',
                    CHtml::listData(ActiveAssistanceTypes::model()->findAll(array('order' => 'name')), 'id', 'name'),
                    [
                        'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                        'separator' => '',
                    ]); ?>
            </div>

            <br/>

            <?= $form->error($model, 'assistanceIds') ?>

            <?= $form->checkBox($model, 'personal_data'); ?>
            <?= $form->labelEx($model, 'personal_data', array('class' => 'inline')); ?>

            <?=CHtml::activeLabelEx($model, 'verifyCode')?>
            <?$this->widget('CCaptcha')?>
            <?=CHtml::activeTextField($model, 'verifyCode')?>

            <p><strong>Якщо бажаєте приєднатися до команди волонтерів, <a href="http://bit.ly/czslvlntr"
                                                                          target="_blank">заповніть форму</a>.</strong>
            </p>

            <div class="form-actions">
                <?php
                echo TbHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти', array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'size' => TbHtml::BUTTON_SIZE_LARGE,
                ));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <?php } ?>
    </div>
</section>
