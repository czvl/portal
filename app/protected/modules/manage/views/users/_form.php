<?php
/* @var $this UsersController */
/* @var $model User */
/* @var $form TbActiveForm */
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
                <?php echo $form->textFieldControlGroup($model, 'phone', array('span' => 5, 'maxlength' => 255)); ?>
                <?php echo $form->textFieldControlGroup($model, 'position', array('span' => 5, 'maxlength' => 255)); ?>
                <?php echo $form->textFieldControlGroup($model, 'additional_contact', array('span' => 5, 'maxlength' => 255)); ?>
                <?php echo $form->dropDownListControlGroup($model, 'role', $model->roles, array('empty' => '', 'options' => array('volunteer' => array('selected' => 'selected')))); ?>
                <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusTypes); ?>

                <?php if (!$model->isNewRecord) { ?>
                    <h4><?= Yii::t('main', 'user.profile.responsibility.title')?></h4>
                    <div class="search-filters">
                        <table class="search-table">
                            <tr>
                                <td>
                                    <strong><?= Yii::t('main', 'user.profile.responsibility.cities')?></strong><br />
                                    <input type="text" name="locationsFilter" class="filter" size="10" />
                                    <div class="div-overflow narrow">
                                        <?= UserCitiesHelper::checkBoxList($model)?>
                                    </div>
                                </td>
                                <td>
                                    <strong><?= Yii::t('main', 'user.profile.responsibility.categories')?></strong><br />
                                    <input type="text" name="categoryFilter" class="filter" size="10" />
                                    <div class="div-overflow narrow">
                                        <?= UserCvCategoriesHelper::checkBoxList($model) ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>


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