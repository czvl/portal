<?php

$this->pageTitle = Yii::app()->name;

?>

        <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class' => 'form-signin'
            ),
            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <fieldset>
            <legend><?php echo Yii::t('main', 'Sign in'); ?></legend>
            <?php echo $form->textFieldControlGroup($model, 'username'); ?>
            <?php echo $form->passwordFieldControlGroup($model, 'password'); ?>
            <?php echo $form->checkBoxControlGroup($model, 'rememberMe'); ?>
            <?php echo TbHtml::submitButton(Yii::t('main', 'Login'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'style' => 'float:right;')); ?>
        
            <?php /*
            <h2>Do you already have an account on one of these sites? Click the logo to log in with it here:</h2>
            <?php $this->widget('ext.eauth.EAuthWidget'); ?>
            */ ?>
        </fieldset>
        
      <?php $this->endWidget(); ?>
