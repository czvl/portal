<?php
/**
 * @var $model Vacancy
 * @var $company Company
 * @var $this CController
 */

?>

<h1><?= $model->isNewRecord ? Yii::t('main', 'vacancy.title.create')
        : Yii::t('main', 'vacancy.title.edit'); ?></h1>


<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'vacancy-form',
        'enableAjaxValidation' => true,
    )); /* @var $form TbActiveForm */
    ?>
    <div class="alert alert-block">
        <?= Yii::t('main', 'company') . ': ' . $company->name ?>

        <?php if (!$model->isNewRecord): ?>
            [ <?= $model->getAttributeLabel('created_at') . ': ' . $model->created_at ?> ]
            [ <?= $model->getAttributeLabel('updated_at') . ': ' . $model->updated_at ?>]
        <?php endif; ?>
    </div>

    <?= $form->errorSummary($model) ?>

    <?= $form->dropDownListControlGroup($model, 'status', VacancyHelper::statuses(), ['class' => 'span4']) ?>

    <?= $form->textFieldControlGroup($model, 'name', ['size' => 200, 'class' => 'span8']) ?>

    <?= $form->dropDownListControlGroup($model, 'user_id', CompanyHelper::userList($company->id), [
        'class' => 'span8',
    ]) ?>

    <?= $form->dropDownListControlGroup($model, 'city_id', UserCitiesHelper::all()) ?>


    <?= $form->textAreaControlGroup($model, 'description', ['rows' => 8, 'class' => 'span8']) ?>

    <?= $form->textAreaControlGroup($model, 'requirements', ['rows' => 4, 'class' => 'span8']) ?>

    <?= $form->dropDownListControlGroup($model, 'experience_id', ExperienceHelper::all(), ['class' => 'span4']) ?>

    <div class="control-group">
        <?= $form->checkBoxControlGroup($model, 'housing') ?>
    </div>

    <hr />
    <div class="control-group">
        <p>
            <b>
                <?= $form->labelEx($model, 'educationIds') ?>
            </b>
        </p>
        <?= $form->checkBoxList($model, 'educationIds', EducationHelper::all()) ?>
    </div>
    <hr />
    <div class="control-group">
        <p>
            <b>
                <?= $form->labelEx($model, 'categoryIds') ?>
            </b>
        </p>
        <input type="text" name="categoryFilter" class="filter span8"
               placeholder="<?= Yii::t('main', 'text.filter.placeholder') ?>"/>

        <div>
            <?= $form->inlineCheckBoxList($model, 'categoryIds', CategoriesHelper::all(), [
                'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                'separator' => '',
            ]) ?>
        </div>
    </div>
    <hr />
    <div class="control-group">
        <p>
            <b>
                <?= $form->labelEx($model, 'positionIds') ?>
            </b>
        </p
        <p>
            <?= Yii::t('main', 'vacancy.label.positionIds.ext') ?>
        </p>
        <input type="text" name="positionsFilter" class="filter span8"
               placeholder="<?= Yii::t('main', 'text.filter.placeholder') ?>"/>

        <div>
            <?= $form->inlineCheckBoxList($model, 'positionIds', PositionsHelper::all(), [
                'template' => '{beginLabel}{input} {labelTitle}{endLabel}',
                'separator' => '',
            ]) ?>
        </div>
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