<?php
    $age = $this->getTimeDiff($data->birth_date);
    $inProgress = $this->getTimeDiff($data->added_time);
    $lastUpdate = $this->getTimeDiff($data->last_update);
?>
        <tr class="leadtr">
            <td>
                <?php echo $data->statusTypes[$data->status]; ?>
                <br />
                <span class="time">
                    <?php echo $inProgress; ?>
                    <br />
                    <em>[<?php echo $lastUpdate; ?>]</em>
                </span>
            </td>
            <td colspan="3">
                <strong><?php echo $data->firstLastName; ?></strong> - 
                <?php echo $data->genderTypes[$data->gender]; ?>, 
                <?php echo $age; ?>, 
                <?php echo $data->maritalStatuses[$data->gender][$data->marital_status]; ?>, 
                <?php echo implode(', ', array_values(CHtml::listData($data->citiesResidence, 'city_index', 'city_name'))); ?>, 
                <?php echo $data->contact_phone; ?>, <?php echo CHtml::mailto($data->email); ?>
            </td>
            <td>
                <?php echo $data->desired_position; ?> у м.
                <?php echo implode(', ', array_values(CHtml::listData($data->citiesJobLocations, 'city_index', 'city_name'))); ?>
                <br />
                <strong><?php echo $data->getAttributeLabel('categoryIds'); ?>:</strong><br />
                <?php echo implode(', ', array_values(CHtml::listData($data->categories, 'id', 'name'))); ?>
            </td>
            <td style="text-align: right;">
                <?php 
                    echo CHtml::link(TbHtml::icon(TbHtml::ICON_EYE_OPEN), array("profiles/view", 'id' => $data->id));
                    echo " | " . CHtml::link(TbHtml::icon(TbHtml::ICON_EDIT), array("profiles/update", 'id' => $data->id));
                    if (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) {
                        echo " | " . CHtml::link(TbHtml::icon(TbHtml::ICON_REMOVE), array("profiles/delete", 'id' => $data->id), array('confirm' => 'Ви впевнені, що хочете видалити цей запис?'));
                    }
                ?>
            </td>
        </tr>
        <tr class="additional">
            <td colspan="2">
                <strong><?php echo $data->getAttributeLabel('summary'); ?>:</strong><br />
                <?php echo nl2br($data->summary); ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('education'); ?>:</strong> <?php echo $data->educationTypes[$data->education]; ?>, 
                <?php echo $data->eduction_info; ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('skills'); ?>:</strong> <?php echo $data->skills; ?>
            </td>
            <td colspan="2">
                <strong><?php echo $data->getAttributeLabel('work_experience'); ?>:</strong><br />
                <?php echo $data->work_experience; ?>
            </td>
            <td>
                <strong><?php echo $data->getAttributeLabel('assistanceIds'); ?>:</strong>
                <?php echo $data->assistances; ?>
                
                <?php if (!empty($data->latestStatus)) { ?>
                <strong><?php echo $data->getAttributeLabel('statuses'); ?>:</strong><br />
                <?php echo $data->latestStatus->message; ?><br />
                <em>[<?php echo Yii::app()->dateFormatter->formatDateTime($data->latestStatus->added_time, "short"); ?> 
                    - <?php echo CHtml::link($data->latestStatus->operator->first_name . ' ' . $data->latestStatus->operator->last_name, array('/manage/reqruiter', 'id' => $data->latestStatus->operator->id)); ?>]</em>
                <?php } ?>
            </td>
            <td>
                <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('recruiter_id')); ?>:</strong><br />
                <?php echo CHtml::link($data->recruiter->firstLastName, array('/manage/reqruiter', 'id' => $data->recruiter->id)); ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('recruiter_comments'); ?>:</strong><br />
                <?php echo $data->recruiter_comments; ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('who_filled'); ?>:</strong> <?php echo $data->who_filled; ?>
            </td>
        </tr>

