        <section id="services" class="single-page scrollblock">
            <div class="container">
                <h1>Додати анкету</h1>
                
                <div class="notice">
                    <p><strong>Будь ласка не заповнюйте анкету вдруге!</strong></p>
                    <p>Дублювання ваших даних не збільшить шанси, ще й ускладнить роботу волонтерів.</p>
                    <p>Ви завжди можете написати нам <a href="mailto:czsl.staff@gmail.com">листа</a> або <a href="/#contact">зателефонувати на Гарячу лінію ЦЗВЛ</a>: щоб оновити дані, дізнатись чи є нові пропозиції для вас або з будь-яких інших питань. Це рекомендований спосіб &laquo;просування&raquo; вашої справи.</p>
                </div>
                
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
                    
                    <?php echo $form->errorSummary($model); ?>
                    
                    <p><span class="required">*</span> - поля, обов’язкові для заповнення.</p>

                    <?php echo $form->textFieldControlGroup($model, 'first_name', array('span' => 5, 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldControlGroup($model, 'last_name', array('span' => 5, 'maxlength' => 255)); ?>
                    <?php echo $form->dropDownListControlGroup($model, 'gender', $model->genderTypes, array('span' => 5, 'maxlength' => 1)); ?>
                    <?php echo $form->dropDownListControlGroup($model, 'marital_status', $model->maritalStatuses['m'], array('span' => 5, 'maxlength' => 1)); ?>
                    <?php echo $form->labelEx($model, 'birth_date'); ?>
                    <?php
	                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		                    'model' => $model,
		                    'attribute' => 'birth_date',
		                    'options' => array(
			                    'showAnim' => 'fold',
			                    'changeYear'  => true,
			                    'dateFormat' => 'yy-mm-dd',
		                    )
	                    ));
                    ?>
                    <?php echo $form->labelEx($model, 'contact_phone'); ?>
                    <?php
                        $this->widget('CMaskedTextField', array(
                            'model' => $model,
                            'attribute' => 'contact_phone',
                            'mask' => '+380 (99) 999-99-99',
                            'placeholder' => '*',
                        ));
                    ?>
                    <?php echo $form->textFieldControlGroup($model, 'email', array('span' => 5, 'maxlength' => 255)); ?>
                    <?php echo $form->textAreaControlGroup($model, 'other_contacts', array('rows' => 6, 'span' => 8)); ?>
                    <?php echo $form->labelEx($model, 'residenciesIds'); ?>
                    <div class="div-overflow">
                        <?php echo $form->checkBoxList($model, 'residenciesIds', CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>
                    </div>
                    <?php echo $form->dropDownListControlGroup($model, 'education', $model->educationTypes, array('span' => 5)); ?>
                    <?php echo $form->labelEx($model, 'eduction_info'); ?>
                    <p><small>Навчальний заклад, спеціальність, рік закінчення.</small></p>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'eduction_info', array('rows' => 2, 'span' => 8)); ?>
                    </div>
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
                    <?php echo $form->textAreaControlGroup($model, 'documents', array('rows' => 2, 'span' => 8)); ?>
                    <?php echo $form->labelEx($model, 'driverLicensesIds'); ?>
                    <div class="div-overflow">
                        <?php echo $form->checkBoxList($model, 'driverLicensesIds', CHtml::listData(DriverLicenses::model()->findAll(array('order' => 'id')), 'id', 'name')); ?>
                    </div>
                    <?php echo $form->labelEx($model, 'applicant_type'); ?>
                    <p><small>Учасник протестів на Майдані / Внутрішньо Переміщена Особа (з Криму, зі Сходу України).</small></p>
                    <?php echo $form->textArea($model, 'applicant_type', array('rows' => 6, 'span' => 8)); ?>
                    <?php echo $form->checkBoxListControlGroup($model, 'assistanceIds', CHtml::listData(AssistanceTypes::model()->findAll(array('order' => 'id')), 'id', 'name')); ?>
                    <?php echo $form->checkBox($model, 'personal_data'); ?>
                    <?php echo $form->labelEx($model, 'personal_data', array('class' => 'inline')); ?>

	                <p><strong>Якщо бажаєте приєднатися до команди волонтерів, <a href="http://bit.ly/czslvlntr" target="_blank">заповніть форму</a>.</strong></p>

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
