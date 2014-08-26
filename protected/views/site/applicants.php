        <section id="services" class="single-page scrollblock">
            <div class="container">
                <h1>Додати анкету</h1>
                <div class="form">
                <?php if (filter_input(INPUT_GET, 'success')) { ?>
                    <p>Ваші дані були збережені. Найближчим часом з Вами зв’яжуться наші представники.</p>
                <?php } else { ?>
                    <?php
                        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id' => 'cv-list-form',
                            'enableAjaxValidation' => true,
                        ));
                    ?>
                    <p><span class="required">*</span> - поля, обов’язкові для заповнення.</p>
                    
                    <?php echo $form->errorSummary($model); ?>

                    <?php echo $form->textFieldControlGroup($model, 'first_name', array('span' => 5, 'maxlength' => 255)); ?>

                    <?php echo $form->textFieldControlGroup($model, 'last_name', array('span' => 5, 'maxlength' => 255)); ?>

                    <?php echo $form->dropDownListControlGroup($model, 'gender', $model->genderTypes, array('span' => 5, 'maxlength' => 1)); ?>

                    <?php echo $form->dateFieldControlGroup($model, 'birth_date', array('span' => 5)); ?>

                    <?php echo $form->labelEx($model, 'contact_phone'); ?>
                    <?php
                        $this->widget('CMaskedTextField', array(
                            'model' => $model,
                            'attribute' => 'contact_phone',
                            'mask' => '+380 (99) 999-99-99',
                            'placeholder' => '*',
                        ));
                    ?>

                    <?php echo $form->textAreaControlGroup($model, 'other_contacts', array('rows' => 6, 'span' => 8)); ?>

                    <?php echo $form->textFieldControlGroup($model, 'email', array('span' => 5, 'maxlength' => 255)); ?>

                    <?php echo $form->labelEx($model, 'residenciesIds'); ?>
                    <div class="div-overflow">
                        <?php echo $form->checkBoxList($model, 'residenciesIds', CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>
                    </div>

                    <?php echo $form->dropDownListControlGroup($model, 'education', $model->educationTypes, array('span' => 5)); ?>

                    <?php echo $form->textAreaControlGroup($model, 'eduction_info', array('rows' => 6, 'span' => 8)); ?>

                    <?php echo $form->textAreaControlGroup($model, 'work_experience', array('rows' => 6, 'span' => 8)); ?>

                    <?php echo $form->textAreaControlGroup($model, 'skills', array('rows' => 6, 'span' => 8)); ?>

                    <?php echo $form->textAreaControlGroup($model, 'summary', array('rows' => 6, 'span' => 8)); ?>
                    
                    <?php echo $form->urlFieldControlGroup($model, 'cv_file', array('span' => 5, 'maxlength' => 255)); ?>
                    
                    <?php echo $form->textFieldControlGroup($model, 'desired_position', array('span' => 5, 'maxlength' => 255)); ?>
                    
                    <?php echo $form->textFieldControlGroup($model, 'salary', array('span' => 5, 'maxlength' => 255)); ?>

                    <?php echo $form->labelEx($model, 'jobLocationsIds'); ?>
                    <div class="div-overflow">
                        <?php echo $form->checkBoxList($model, 'jobLocationsIds', CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>
                    </div>

                    <?php echo $form->textAreaControlGroup($model, 'documents', array('rows' => 6, 'span' => 8)); ?>

                    <?php echo $form->labelEx($model, 'driverLicensesIds'); ?>
                    <div class="div-overflow">
                        <?php echo $form->checkBoxList($model, 'driverLicensesIds', CHtml::listData(DriverLicenses::model()->findAll(array('order' => 'id')), 'id', 'name')); ?>
                    </div>
                    <?php echo $form->labelEx($model, 'applicant_type'); ?>
                    <p><small>Участь у Майдані / Вимушений переселенець з окупованої території (Крим), зони проведення АТО та Сходу України.</small></p>
                    <?php echo $form->textArea($model, 'applicant_type', array('rows' => 6, 'span' => 8)); ?>

                    <?php echo $form->checkBoxListControlGroup($model, 'assistanceIds', CHtml::listData(AssistanceTypes::model()->findAll(array('order' => 'id')), 'id', 'name')); ?>
                    
                    <div>
                        <?php echo $form->labelEx($model, 'verifyCode'); ?>
                        <p><?php $this->widget('CCaptcha'); ?></p>
                        <?php echo $form->textField($model, 'verifyCode'); ?>
                    </div>
                    
                    <?php echo $form->checkBox($model, 'personal_data'); ?>
                    <?php echo $form->labelEx($model, 'personal_data', array('class' => 'inline')); ?>

                    <div class="form-actions">
                        <?php
                        echo TbHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти', array(
                            'color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE,
                        ));
                        ?>
                    </div>

                <?php $this->endWidget(); ?>
                </div>
                <?php } ?>
            </div>
        </section>