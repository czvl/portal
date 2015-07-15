<?php
/**
 * @var $this SiteController
 * @var $model RegisterCompanyForm
 */

?>

<section id="services" class="single-page">
    <div class="container">
        <h1><?= Yii::t('main', 'company.register.title') ?></h1>

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
            <legend><?= Yii::t('main', 'company.register.company') ?></legend>
            <?= $form->textFieldControlGroup($model, 'name', ['class' => 'span8 ']) ?>
            <?= $form->textAreaControlGroup($model, 'address', [
                'class' => 'span8',
                'label' => Yii::t('main', 'company.address.ext'),
            ]) ?>
            <?= $form->textFieldControlGroup($model, 'site_url', ['class' => 'span8', 'placeholder' => 'http://site.com.ua']) ?>
        </fieldset>

        <fieldset>
            <legend><?= Yii::t('main', 'company.register.user') ?></legend>
        </fieldset>


        <?= $form->textFieldControlGroup($model, 'first_name', ['class' => 'span4']) ?>
        <?= $form->textFieldControlGroup($model, 'last_name', ['class' => 'span4']) ?>
        <?= $form->textFieldControlGroup($model, 'position', ['class' => 'span4']) ?>

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
        <?= $form->textAreaControlGroup($model, 'additional_contact', [ 'class' => 'span8']) ?>
        <?= $form->textFieldControlGroup($model, 'email', ['class' => 'span4', 'label' => Yii::t('main', 'company.register.email.label') ]) ?>
        <?= $form->textFieldControlGroup($model, 'username', ['class' => 'span4', 'label' => Yii::t('main', 'company.register.username.label')]) ?>
        <?= $form->passwordFieldControlGroup($model, 'password', ['class' => 'span4']) ?>
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
