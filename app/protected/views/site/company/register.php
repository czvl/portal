<?php
/**
 * @var $this SiteController
 * @var $model RegisterCompanyForm
 */

?>

<section id="services" class="single-page">
    <div class="container">
        <h1>Додати компанію</h1>

        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'company-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));  /* @var $form TbActiveForm */
        ?>

        <?= $form->errorSummary($model); ?>



        <fieldset>
            <legend>Дані про компанію:</legend>
            <?= $form->textFieldControlGroup($model, 'name', ['class' => 'span8 form-control']) ?>
            <?= $form->textAreaControlGroup($model, 'address', ['class' => 'span8']) ?>
        </fieldset>

        <fieldset>
            <legend>Дані особи, що буде адмініструвати вакансіі:</legend>
            </fieldset>

        <?= $form->label($model, 'phone'); ?>
        <?php
        $this->widget('CMaskedTextField', [
            'model' => $model,
            'attribute' => 'phone',
            'mask' => UserHelper::PHONE_MASK,
            'placeholder' => '*',
        ]);
        echo $form->error($model, 'phone');
        ?>


        <?= $form->textFieldControlGroup($model, 'first_name', ['class' => 'span4']) ?>
        <?= $form->textFieldControlGroup($model, 'last_name', ['class' => 'span4']) ?>
        <?= $form->textFieldControlGroup($model, 'position', ['class' => 'span4']) ?>
        <?= $form->textFieldControlGroup($model, 'email', ['class' => 'span4']) ?>
        <?= $form->textFieldControlGroup($model, 'username', ['class' => 'span4']) ?>
        <?= $form->passwordField($model, 'password', ['class' => 'span4']) ?>
        <?= $form->passwordFieldControlGroup($model, 'repeat_password', ['class' => 'span4']) ?>

        <div class="form-actions">
            <?php
            echo TbHtml::submitButton(Yii::t('main', 'form.button.add'),
                [
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                    'size' => TbHtml::BUTTON_SIZE_LARGE,
                ]);
            ?>
        </div>

        <?php
        $this->endWidget();
        ?>


    </div>
</section>
