                <h1>Мій профайл</h1>
                
                <p><?php $this->widget('bootstrap.widgets.TbAlert'); ?></p>
                
                <p><strong>Ім’я та призвище:</strong> <?php echo Yii::app()->session['first_name'] . " " . Yii::app()->session['last_name']; ?></p>
                <div class="form">
                    <?php
                    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id' => 'profile-form',
                        'enableAjaxValidation' => true,
                    ));
                    ?>
                    <?php echo $form->errorSummary($model); ?>
                    <?php echo $form->textFieldControlGroup($model, 'first_name', array('span' => 5, 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldControlGroup($model, 'last_name', array('span' => 5, 'maxlength' => 255)); ?>

                    <?php echo $form->labelEx($model, 'phone'); ?>
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $model,
                        'attribute' => 'phone',
                        'mask' => UserHelper::PHONE_MASK,
                        'placeholder' => '*',
                    ));
                    ?>
                    <?php echo $form->textFieldControlGroup($model, 'position', array('span' => 5, 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldControlGroup($model, 'additional_contact', array('span' => 5, 'maxlength' => 255)); ?>

                    <?php echo $form->passwordFieldControlGroup($model, 'password_new', array('span' => 5, 'maxlength' => 20)); ?>
                    <?php echo $form->passwordFieldControlGroup($model, 'password_repeat', array('span' => 5, 'maxlength' => 20)); ?>

                    <div class="form-actions">
                        <?php
                        echo TbHtml::submitButton('Зберегти', array(
                            'color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE,
                        ));
                        ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>

