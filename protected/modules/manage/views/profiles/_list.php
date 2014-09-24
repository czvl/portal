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
                    [<?php echo Yii::app()->dateFormatter->formatDateTime($data->added_time, "short"); ?>]
                    <br />
                    <em>Останне оновлення - <?php echo $lastUpdate; ?> тому</em>
                </span>
            </td>
            <td colspan="3">
                <strong><?php echo CHtml::link($data->firstLastName, array("profiles/view", 'id' => $data->id)); ?></strong> - 
                <?php echo $data->genderTypes[$data->gender]; ?>, 
                <?php
                    if (isset($data->birth_date)) {
                        echo $age . ", ";
                    }
                ?>
                <?php if ($data->marital_status) { ?>
                <?php echo $data->maritalStatuses[$data->gender][$data->marital_status]; ?>, 
                <?php } ?>
                <?php
                    if (!empty($data->citiesResidence)) {
                        echo implode(', ', array_values(CHtml::listData($data->citiesResidence, 'city_index', 'city_name'))) . ", ";
                    }
                ?>
                <?php echo $data->contact_phone; ?>, <?php echo CHtml::mailto($data->email); ?>
                <?php if (!empty($data->internal_num)) { ?>
                    , внутрішній номер <?php echo $data->internal_num; ?>
                <?php } ?>
            </td>
            <td>
                <?php echo $data->desired_position; ?> 
            <?php if (!empty($data->citiesJobLocations)) { ?>
                у м. <?php echo implode(', ', array_values(CHtml::listData($data->citiesJobLocations, 'city_index', 'city_name'))); ?>
            <?php } ?>
                <br />
            <?php if (!empty($data->categories)) { ?>
                <strong><?php echo $data->getAttributeLabel('categoryIds'); ?>:</strong><br />
                <?php echo implode(', ', array_values(CHtml::listData($data->categories, 'id', 'name'))); ?>
                <br />
            <?php } ?>
            <?php if (!empty($data->positions)) { ?>
                <strong><?php echo $data->getAttributeLabel('positionsIds'); ?>:</strong><br />
                <?php echo implode(', ', array_values(CHtml::listData($data->positions, 'id', 'name'))); ?>
            <?php } ?>
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
                <?php echo nl2br(stripslashes($data->summary)); ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('education'); ?>:</strong> <?php echo $data->educationTypes[$data->education]; ?>, 
                <?php echo stripslashes($data->eduction_info); ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('skills'); ?>:</strong> <?php echo stripslashes($data->skills); ?>
            </td>
            <td colspan="2">
                <strong><?php echo $data->getAttributeLabel('work_experience'); ?>:</strong><br />
                <?php echo stripslashes($data->work_experience); ?>
            </td>
            <td>
                <strong><?php echo $data->getAttributeLabel('assistanceIds'); ?>:</strong>
                <?php echo $data->assistances; ?>
                
            <?php if (!empty($data->latestStatuses)) { ?>
                <strong><?php echo $data->getAttributeLabel('statuses'); ?>:</strong><br />
                <?php foreach($data->latestStatuses as $status) { ?>
                <div class="list-statuses">
                    <?php echo $status->message; ?><br />
                    <em>[<?php echo Yii::app()->dateFormatter->formatDateTime($status->added_time, "short"); ?> 
                    - <?php echo CHtml::link($status->operator->first_name . ' ' . $status->operator->last_name, array('/manage/reqruiter', 'id' => $status->operator->id)); ?>]</em>
                </div>
                <?php } ?>
            <?php } ?>
                 
            </td>
            <td>
                <?php if ($data->recruiter) { ?>
                <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('recruiter_id')); ?>:</strong><br />
                <?php echo CHtml::link($data->recruiter->firstLastName, array('/manage/reqruiter', 'id' => $data->recruiter->id)); ?>
                <br /><br />
                <?php } ?>
                <strong><?php echo $data->getAttributeLabel('recruiter_comments'); ?>:</strong><br />
                <?php echo $data->recruiter_comments; ?>
                <br /><br />
                <strong><?php echo $data->getAttributeLabel('who_filled'); ?>:</strong> <?php echo $data->who_filled; ?>
            </td>
        </tr>

