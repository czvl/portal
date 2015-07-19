<?php
/**
 * @var $model Vacancy
 * @var $company Company
 * @var $this CController
 */

?>

<h1><?=  $model->isNewRecord ? Yii::t('main', 'vacancy.title.create')
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

    <?= $form->dropDownListControlGroup($model, 'status', VacancyHelper::statuses(),['class' => 'span4']) ?>

    <?= $form->textFieldControlGroup($model, 'name', ['size' => 200, 'class' => 'span8']) ?>

    <?= $form->dropDownListControlGroup($model, 'user_id', CompanyHelper::userList($company->id), [
        'class' => 'span8',
    ]) ?>

    <?= $form->dropDownListControlGroup($model, 'city_id', UserCitiesHelper::all()) ?>


    <?= $form->textAreaControlGroup($model, 'description', ['rows' => 8, 'class' => 'span8']) ?>

    <?= $form->textAreaControlGroup($model, 'requirements', ['rows' => 4, 'class' => 'span8']) ?>

    <?= $form->dropDownListControlGroup($model, 'experience_id', ExperienceHelper::all(), ['class' => 'span4']) ?>

    <?= $form->checkBoxControlGroup($model, 'housing') ?>

    <hr/>
    <table border="0">
        <tr >
            <th align="left"><?= Yii::t('main', 'vacancy.label.categoryIds')?></th>
            <th align="left"><?= Yii::t('main', 'vacancy.label.positionIds')?></th>
            <th align="left"><?= Yii::t('main', 'vacancy.label.educationIds')?></th>
        </tr>

        <tr style="height: 500px">

            <td valign="top">
                <input type="text" name="categoryFilter" class="filter span8" placeholder="<?= Yii::t('main', 'text.filter.placeholder')?>" />

                <div class="div-overflow">
                    <?= $form->checkBoxList($model, 'categoryIds', CategoriesHelper::all()) ?>

                </div>
            </td>
            <td style="vertical-align: top; padding: 20px">
                <input type="text" name="positionFilter" class="span8 filter " placeholder="<?= Yii::t('main', 'text.filter.placeholder')?>" />

                <div class="div-overflow">
                    <?= $form->checkBoxList($model, 'positionIds', PositionsHelper::all()) ?>
                </div>
            </td>
            <td valign="top">
                <p></p>
                <p>
                <?= $form->checkBoxList($model, 'educationIds', EducationHelper::all()) ?>
                </p>
            </td>
        </tr>
    </table>

    <hr/>


    <hr/>


    <hr/>

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