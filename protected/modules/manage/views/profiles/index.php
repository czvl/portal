<?php

$this->menu = array(
    array('label' => 'Додати анкету', 'url' => array('create')),
);
?>

<h1>Анкети претендентів</h1>

<h4>Пошук</h4>
<form>
    <div class="search-filters">
        <table class="search-table">
            <tr>
                <td>
                    <div class="scrollY">
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('status')); ?></strong><br />
                        <?php echo CHtml::dropDownList('status', $this->getVariable('status'), CvList::model()->getStatusTypes(), array('empty' => '---')); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('last_name')); ?></strong><br />
                        <?php echo CHtml::textField('last_name', $this->getVariable('last_name'), array('span' => 5, 'maxlength' => 255)); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('first_name')); ?></strong><br />
                        <?php echo CHtml::textField('first_name', $this->getVariable('first_name'), array('span' => 5, 'maxlength' => 255)); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('internal_num')); ?></strong><br />
                        <?php echo CHtml::textField('internal_num', $this->getVariable('internal_num'), array('span' => 5, 'maxlength' => 255)); ?>
                        <br />
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('recruiter_id')); ?></strong><br />
                        <?php echo CHtml::dropDownList('recruiter_id', $this->getVariable('recruiter_id'), User::model()->recruiters, array('empty' => '---')); ?>
                    </div>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('jobLocationsIds')); ?></strong><br />
                    <input type="text" name="locationsFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('locations', $this->getVariable('locations'), CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('residenciesIds')); ?></strong><br />
                    <input type="text" name="residenciesFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('residencies', $this->getVariable('residencies'), CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('categoryIds')); ?></strong><br />
                    <input type="text" name="categoryFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('categories', $this->getVariable('categories'), CHtml::listData(CvCategories::model()->findAll(array('order' => 'name')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('positionsIds')); ?></strong><br />
                    <input type="text" name="positionsFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('positions', $this->getVariable('positions'), CHtml::listData(CvPositions::model()->findAll(array('order' => 'name')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('assistanceIds')); ?></strong><br />
                    <input type="text" name="assistanceFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('assistanceIds', $this->getVariable('assistanceIds'), CHtml::listData(AssistanceTypes::model()->findAll(array('order' => 'name')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('driverLicensesIds')); ?></strong><br />
                    <input type="text" name="licensesFilter" class="filter" size="10" />
                    <div class="div-overflow narrow">
                        <?php echo CHtml::checkBoxList('licensesIds', $this->getVariable('licensesIds'), CHtml::listData(DriverLicenses::model()->findAll(array('order' => 'name')), 'id', 'name'), array('template' => '{beginLabel}{input} {labelTitle}{endLabel}', 'separator' => '')); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br />
    <input type="submit" class="btn btn-primary btn-small" value="знайти" />
    <input type="button" class="btn btn-primary btn-small" value="сброс" onclick="location.href='/manage/profiles'" />
</form>

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