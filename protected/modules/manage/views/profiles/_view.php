<?php
/* @var $this ProfilesController */
/* @var $data CvList */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birth_date')); ?>:</b>
	<?php echo CHtml::encode($data->birth_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_phone')); ?>:</b>
	<?php echo CHtml::encode($data->contact_phone); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('education')); ?>:</b>
	<?php echo CHtml::encode($data->education); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eduction_info')); ?>:</b>
	<?php echo CHtml::encode($data->eduction_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_experience')); ?>:</b>
	<?php echo CHtml::encode($data->work_experience); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('skills')); ?>:</b>
	<?php echo CHtml::encode($data->skills); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('summary')); ?>:</b>
	<?php echo CHtml::encode($data->summary); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desired_position')); ?>:</b>
	<?php echo CHtml::encode($data->desired_position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documents')); ?>:</b>
	<?php echo CHtml::encode($data->documents); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('applicant_type')); ?>:</b>
	<?php echo CHtml::encode($data->applicant_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cv_file')); ?>:</b>
	<?php echo CHtml::encode($data->cv_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recruiter_id')); ?>:</b>
	<?php echo CHtml::encode($data->recruiter_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recruiter_comments')); ?>:</b>
	<?php echo CHtml::encode($data->recruiter_comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('who_filled')); ?>:</b>
	<?php echo CHtml::encode($data->who_filled); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_time')); ?>:</b>
	<?php echo CHtml::encode($data->added_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>