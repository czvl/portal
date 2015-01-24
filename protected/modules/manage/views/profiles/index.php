<?php

$this->menu = array(
    array('label' => 'Додати анкету', 'url' => array('create')),
);

$statusFilter           = $this->fetchVariable('status');
$lastNameFilter         = $this->fetchVariable('last_name');
$firstNameFilter        = $this->fetchVariable('first_name');
$internalNumFilter      = $this->fetchVariable('internal_num');
$recruiterIdFilter      = $this->fetchVariable('recruiter_id');
$locationsFilter        = $this->fetchVariable('locations');
$residenciesFilter      = $this->fetchVariable('residencies');
$categoriesFilter       = $this->fetchVariable('categories');
$positionsFilter        = $this->fetchVariable('positions');
$assistanceIdsFilter    = $this->fetchVariable('assistanceIds');
$licensesIdsFilter      = $this->fetchVariable('licensesIds');

function getClassName($fieldValue = NULL)
{
    return ($fieldValue != NULL) ? 'selected' : 'default';
}

function getOrder($fieldValue, $orderField = 'id')
{
    return ($fieldValue) ? $orderField . " IN (" . implode(",", $fieldValue) . ") DESC," : "";
}

?>

<h1>Анкети претендентів</h1>

<h4>Пошук</h4>
<form method="post" id="filter">
    <?php echo CHtml::hiddenField('post', 1); ?>
    <div class="search-filters">
        <table class="search-table">
            <tr>
                <td>
                    <div class="scrollY">
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('status')); ?></strong><br />
                        <?php echo CHtml::dropDownList('status', $statusFilter, CvList::model()->getStatusTypes(), array('empty' => '---', 'class' => getClassName($statusFilter))); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('last_name')); ?></strong><br />
                        <?php echo CHtml::textField('last_name', $lastNameFilter, array('span' => 5, 'maxlength' => 255, 'class' => getClassName($lastNameFilter))); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('first_name')); ?></strong><br />
                        <?php echo CHtml::textField('first_name', $firstNameFilter, array('span' => 5, 'maxlength' => 255, 'class' => getClassName($firstNameFilter))); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('internal_num')); ?></strong><br />
                        <?php echo CHtml::textField('internal_num', $internalNumFilter, array('span' => 5, 'maxlength' => 255, 'class' => getClassName($internalNumFilter))); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('recruiter_id')); ?></strong><br />
                        <?php echo CHtml::dropDownList('recruiter_id', $recruiterIdFilter, User::model()->recruiters, array('empty' => '---', 'class' => getClassName($recruiterIdFilter))); ?>
                    </div>
                </td>
                <td class="<?php echo getClassName($locationsFilter); ?>">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('jobLocationsIds')); ?></strong><br />
                    <input type="text" name="locationsFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('locations', $locationsFilter, CHtml::listData(CitiesList::model()->findAll(array('order' => getOrder($locationsFilter, 'city_index') . 'city_name ASC')), 'city_index', 'city_name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td class="<?php echo getClassName($residenciesFilter); ?>">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('residenciesIds')); ?></strong><br />
                    <input type="text" name="residenciesFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('residencies', $residenciesFilter, CHtml::listData(CitiesList::model()->findAll(array('order' => getOrder($residenciesFilter, 'city_index') . 'city_name ASC')), 'city_index', 'city_name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td class="<?php echo getClassName($categoriesFilter); ?>">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('categoryIds')); ?></strong><br />
                    <input type="text" name="categoryFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('categories', $categoriesFilter, CHtml::listData(CvCategories::model()->findAll(array('order' => getOrder($categoriesFilter) . 'name ASC')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td class="<?php echo getClassName($positionsFilter); ?>">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('positionsIds')); ?></strong><br />
                    <input type="text" name="positionsFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('positions', $positionsFilter, CHtml::listData(CvPositions::model()->findAll(array('order' => getOrder($positionsFilter) . 'name ASC')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td class="<?php echo getClassName($assistanceIdsFilter); ?>">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('assistanceIds')); ?></strong><br />
                    <input type="text" name="assistanceFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('assistanceIds', $assistanceIdsFilter, CHtml::listData(AssistanceTypes::model()->findAll(array('order' => getOrder($assistanceIdsFilter) . 'name ASC')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td class="<?php echo getClassName($licensesIdsFilter); ?>">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('driverLicensesIds')); ?></strong><br />
                    <input type="text" name="licensesFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('licensesIds', $licensesIdsFilter, CHtml::listData(DriverLicenses::model()->findAll(array('order' => getOrder($licensesIdsFilter) . 'name ASC')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br />
    <input type="submit" class="btn btn-primary btn-small" value="Знайти" />
    <input type="button" class="btn btn-primary btn-small reset" value="Скинути" onclick="$(':input','#filter').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected'); $('#filter').submit();" />
</form>

<?php
$params = array('class' => 'btn btn-success btn-small', 'id' => 'export-button');
if(!sizeof($this->toExport)) {
    $params['style'] = 'display:none';
}
echo CHtml::link('Експорт', array('profiles/export'), $params);

$params = array('class' => 'btn btn-default btn-small', 'id' => 'reset-button');
if(!sizeof($this->toExport)) {
    $params['style'] = 'display:none';
}
echo ' ', CHtml::link('Скинути', '#reset', $params);
?>

<p><?php $this->widget('bootstrap.widgets.TbAlert'); ?></p>

<table class="items table">
    <thead>
        <tr>
            <th style="width: 90px;"><?php echo CHtml::encode(CvList::model()->getAttributeLabel('status')); ?></th>
            <th><?php echo CHtml::encode(CvList::model()->getAttributeLabel('first_last_name')); ?></th>
            <th style="width: 300px;"></th>
            <th></th>
            <th style="width: 250px;"><?php echo CHtml::encode(CvList::model()->getAttributeLabel('desired_position')); ?></th>
            <th style="width: 180px;"></th>
        </tr>
    </thead>
    <tbody>
<?php

$listView = $this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_list'
));
?>
    </tbody>
</table>
<?php $listView->renderPager(); ?>

<?php
Yii::app()->clientScript->registerCoreScript('cookie');;
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('ext.profiles-export.js').'/export.js'
    ),
    CClientScript::POS_END
);
?>