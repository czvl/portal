<?php
/**
 * @var $this SiteController
 * @var $model RegisterCompanyForm
 */

?>

<section id="services" class="single-page">
    <div class="container">
        <h1>Добавить компанию</h1>

        <?php
        $form = $this->beginWidget('system.web.widgets.CActiveForm', array(
            'id' => 'company-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); /* @var $form CActiveForm */
        ?>

        <?= $form->errorSummary($model); ?>


        <h2>Данные о компании</h2>

        <?= $form->label($model, 'name'); ?>
        <?= $form->textField($model, 'name') ?>
        <?= $form->error($model, 'name'); ?>

        <?= $form->label($model, 'address'); ?>
        <?= $form->textArea($model, 'address') ?>
        <?= $form->error($model, 'address'); ?>

        <h2>Данные администратора</h2>

        <?= $form->label($model, 'phone'); ?>
        <?php
        $this->widget('CMaskedTextField', [
            'model' => $model,
            'attribute' => 'phone',
            'mask' => '+380 (99) 999-99-99',
            'placeholder' => '*',
        ]);
        echo $form->error($model, 'phone');
        ?>



        <?= $form->label($model, 'first_name'); ?>
        <?= $form->textField($model, 'first_name') ?>
        <?= $form->error($model, 'first_name'); ?>

        <?= $form->label($model, 'last_name'); ?>
        <?= $form->textField($model, 'last_name') ?>
        <?= $form->error($model, 'last_name'); ?>

        <?= $form->label($model, 'position'); ?>
        <?= $form->textField($model, 'position') ?>
        <?= $form->error($model, 'position'); ?>

        <?= $form->label($model, 'email'); ?>
        <?= $form->textField($model, 'email') ?>
        <?= $form->error($model, 'email'); ?>

        <?= $form->label($model, 'username'); ?>
        <?= $form->textField($model, 'username') ?>
        <?= $form->error($model, 'username'); ?>

        <?= $form->label($model, 'password'); ?>
        <?= $form->passwordField($model, 'password') ?>
        <?= $form->error($model, 'password'); ?>

        <?= $form->label($model, 'repeat_password'); ?>
        <?= $form->passwordField($model, 'repeat_password') ?>
        <?= $form->error($model, 'repeat_password'); ?>

        <p>
            <?= CHtml::submitButton() ?>
        </p>

        <?php
        $this->endWidget();
        ?>


    </div>
</section>
