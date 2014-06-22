<?php
/* @var $this ProfilesController */
/* @var $model CvList */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'category_id',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'first_name',array('span'=>5,'maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($model,'last_name',array('span'=>5,'maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($model,'gender',array('span'=>5,'maxlength'=>1)); ?>

                    <?php echo $form->textFieldControlGroup($model,'birth_date',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'contact_phone',array('span'=>5,'maxlength'=>15)); ?>

                    <?php echo $form->textFieldControlGroup($model,'email',array('span'=>5,'maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($model,'education',array('span'=>5)); ?>

                    <?php echo $form->textAreaControlGroup($model,'eduction_info',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textAreaControlGroup($model,'work_experience',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textAreaControlGroup($model,'skills',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textAreaControlGroup($model,'summary',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'desired_position',array('span'=>5,'maxlength'=>255)); ?>

                    <?php echo $form->textAreaControlGroup($model,'documents',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textAreaControlGroup($model,'applicant_type',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'cv_file',array('span'=>5,'maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($model,'recruiter_id',array('span'=>5)); ?>

                    <?php echo $form->textAreaControlGroup($model,'recruiter_comments',array('rows'=>6,'span'=>8)); ?>

                    <?php echo $form->textFieldControlGroup($model,'who_filled',array('span'=>5,'maxlength'=>255)); ?>

                    <?php echo $form->textFieldControlGroup($model,'added_time',array('span'=>5)); ?>

                    <?php echo $form->textFieldControlGroup($model,'status',array('span'=>5)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Search',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->