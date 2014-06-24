<?php
/* @var $this UsersController */
/* @var $model User */
/* @var $form CActiveForm */
?>

        <div class="form">

            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => true,
            ));
            ?>
            <?php echo $form->errorSummary($model); ?>
            <fieldset>
                <?php
                if (!$model->isNewRecord) {
                    echo $form->uneditableFieldControlGroup($model, 'username', array('span' => 5, 'maxlength' => 150));
                } else {
                    echo $form->textFieldControlGroup($model, 'username', array('span' => 5, 'maxlength' => 150));
                }
                ?>
                <?php echo $form->textFieldControlGroup($model, 'email', array('span' => 5, 'maxlength' => 255)); ?>
                <?php echo $form->textFieldControlGroup($model, 'first_name', array('span' => 5, 'maxlength' => 255)); ?>
                <?php echo $form->textFieldControlGroup($model, 'last_name', array('span' => 5, 'maxlength' => 255)); ?>
                <?php echo $form->dropDownListControlGroup($model, 'role', $model->roles); ?>
                <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusTypes); ?>            
            </fieldset>
            <hr />
            <fieldset>
                <?php 
                if (!$model->isNewRecord) {
                    echo $form->passwordFieldControlGroup($model, 'password_new', array('span' => 5, 'maxlength' => 20));
                } else {
                    echo $form->passwordFieldControlGroup($model, 'password', array('span' => 5, 'maxlength' => 20));
                }
                ?>
                <?php echo $form->passwordFieldControlGroup($model, 'password_repeat', array('span' => 5, 'maxlength' => 20)); ?>
            </fieldset>
            <div class="form-actions">
                <?php
                    echo TbHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти', array(
                        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                        'size' => TbHtml::BUTTON_SIZE_LARGE,
                    ));
                ?>
            </div>
            

        <?php $this->endWidget(); ?>

        </div><!-- form -->