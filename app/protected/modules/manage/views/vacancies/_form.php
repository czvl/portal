<?php
/**
 * @var $model Vacancy
 * @var $company Company
 * @var $this CController
 */

?>

<div class="form">
    <?php
    $form = $this->beginWidget('system.web.widgets.CActiveForm', array(
        'id' => 'vacancy-form',
        'enableAjaxValidation' => true,
    )); /* @var $form CActiveForm */
    ?>

    <?= $form->labelEx($model, 'user_id') ?>
    <?= $form->dropDownList($model, 'user_id', CompanyHelper::userList($company->id), [
        'class' => 'span8',
    ]) ?>
    <?= $form->error($model, 'user_id') ?>

    <?= $form->labelEx($model, 'name') ?>
    <?= $form->textField($model, 'name', ['size' => 200, 'class' => 'span8']) ?>
    <?= $form->error($model, 'name') ?>

    <?= $form->labelEx($model, 'city_id') ?>
    <?= $form->dropDownList($model, 'city_id', UserCitiesHelper::all()) ?>
    <?= $form->error($model, 'city_id') ?>

    <?= $form->labelEx($model, 'description') ?>
    <?= $form->textArea($model, 'description', ['rows' => 8, 'class' => 'span8']) ?>
    <?= $form->error($model, 'description') ?>

    <?= $form->labelEx($model, 'requirements') ?>
    <?= $form->textArea($model, 'requirements', ['rows' => 4, 'class' => 'span8']) ?>
    <?= $form->error($model, 'requirements') ?>

    <?= $form->labelEx($model, 'experience_id') ?>
    <?= $form->dropDownList($model, 'experience_id', ExperienceHelper::all()) ?>
    <?= $form->error($model, 'experience_id') ?>

    <?= $form->label($model, 'housing') ?>
    <?= $form->checkBox($model, 'housing') ?>
    <?= $form->error($model, 'housing') ?>

    <hr />
    <?= $form->label($model, VacancyCategoriesHelper::fieldName()) ?>

    <div class="div-overflow narrow">
        <?= VacancyCategoriesHelper::checkBoxList($model) ?>
    </div>

    <hr />
    <?= $form->label($model, EducationHelper::fieldName()) ?>
    <div class="div-overflow narrow">
        <?= EducationHelper::checkBoxList($model) ?>
    </div>

    <hr />
    <?= $form->label($model, PositionsHelper::fieldName()) ?>
    <div class="div-overflow narrow">
        <?= PositionsHelper::checkBoxList($model) ?>
    </div>


    <div class="form-actions">
        <?php
        echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main', 'form.button.add') : Yii::t('main',
            'form.button.save'),
            [
                'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                'size' => TbHtml::BUTTON_SIZE_LARGE,
            ]);
        ?>
    </div>

    <?php $this->endWidget() ?>
</div>