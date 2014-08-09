
        <div class="form">
            <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'cv-list-form',
                    'enableAjaxValidation' => true,
                ));
            ?>
            
            <div class="form-actions">
                <?php
                echo TbHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти', array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE,
                ));
                ?>
            </div>

            <?php echo $form->errorSummary($model); ?>
            
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusTypes, array('span' => 5)); ?>
            
            <?php echo $form->textAreaControlGroup($model, 'recruiter_comments', array('rows' => 2, 'span' => 8)); ?>
            
            <table class="table">
                <tr>
                    <td>
                        <?php echo $form->labelEx($model, 'categoryIds'); ?>
                        <input type="text" name="categoryFilter" class="filter" size="10" />
                        <div class="div-overflow">
                            <?php echo $form->checkBoxList($model, 'categoryIds', CHtml::listData(CvCategories::model()->findAll(array('order' => 'name')), 'id', 'name')); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'positionsIds'); ?>
                        <input type="text" name="positionsFilter" class="filter" size="10" />
                        <div class="div-overflow">
                            <?php echo $form->checkBoxList($model, 'positionsIds', CHtml::listData(CvPositions::model()->findAll(array('order' => 'name')), 'id', 'name')); ?>
                        </div>
                    </td>
                </tr>
            </table>
            
            <?php echo $form->textFieldControlGroup($model, 'desired_position', array('span' => 10, 'maxlength' => 255)); ?>
            
            <table class="table">
                <tr>
                    <td>
                        <?php echo $form->labelEx($model, 'jobLocationsIds'); ?>
                        <input type="text" name="jobLocationsFilter" class="filter" size="10" />
                        <div class="div-overflow">
                            <?php echo $form->checkBoxList($model, 'jobLocationsIds', CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'residenciesIds'); ?>
                        <input type="text" name="residenciesFilter" class="filter" size="10" />
                        <div class="div-overflow">
                            <?php echo $form->checkBoxList($model, 'residenciesIds', CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>
                        </div>
                    </td>
                </tr>
            </table>
            
            <?php echo $form->textFieldControlGroup($model, 'salary', array('span' => 5, 'maxlength' => 255)); ?>
            
            <?php echo $form->textAreaControlGroup($model, 'documents', array('rows' => 2, 'span' => 8)); ?>
            
            <?php echo $form->labelEx($model, 'driverLicensesIds'); ?>
            <div class="div-overflow">
                <?php echo $form->checkBoxList($model, 'driverLicensesIds', CHtml::listData(DriverLicenses::model()->findAll(array('order' => 'id')), 'id', 'name')); ?>
            </div>
            
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
            
            <?php echo $form->textAreaControlGroup($model, 'other_contacts', array('rows' => 1, 'span' => 8)); ?>
            
            <?php echo $form->textFieldControlGroup($model, 'email', array('span' => 5, 'maxlength' => 255)); ?>
            
            <?php echo $form->dropDownListControlGroup($model, 'education', $model->educationTypes, array('span' => 5)); ?>
            
            <?php echo $form->textAreaControlGroup($model, 'eduction_info', array('rows' => 3, 'span' => 8)); ?>
            
            <?php echo $form->textAreaControlGroup($model, 'work_experience', array('rows' => 4, 'span' => 8)); ?>
            
            <?php echo $form->textAreaControlGroup($model, 'skills', array('rows' => 4, 'span' => 8)); ?>
            
            <?php echo $form->textAreaControlGroup($model, 'summary', array('rows' => 2, 'span' => 8)); ?>            
            
            <?php echo $form->labelEx($model, 'applicant_type'); ?>
            <p><small>Участь у Майдані / Вимушений переселенець з окупованої території (Крим), зони проведення АТО та Сходу України.</small></p>
            <?php echo $form->textArea($model, 'applicant_type', array('rows' => 6, 'span' => 8)); ?>
            
            <?php echo $form->checkBoxListControlGroup($model, 'assistanceIds', CHtml::listData(AssistanceTypes::model()->findAll(array('order' => 'id')), 'id', 'name')); ?>
            
            <?php echo $form->urlFieldControlGroup($model, 'cv_file', array('span' => 5, 'maxlength' => 255)); ?>

            <div class="form-actions">
                <?php
                echo TbHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти', array(
                    'color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE,
                ));
                ?>
            </div>

        <?php $this->endWidget(); ?>
        </div>