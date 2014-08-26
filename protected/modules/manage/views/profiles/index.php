<?php

$this->menu = array(
    array('label' => 'Додати анкету', 'url' => array('create')),
);
?>

<h1>Анкети претендентів</h1>

<h4>Пошук</h4>
<div>
    <form>
        <table class="search-table">
            <tr>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('status')); ?></strong><br />
                    <?php echo CHtml::dropDownList('status', $this->getVariable('status'), CvList::model()->statusTypes, array('empty' => '---')); ?>
                </td>
                <?php /*<td>
                    <div class="div-overflow">
                        <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('jobLocationsIds')); ?></strong><br />
                        <?php echo CHtml::checkBoxList('locations', $this->getVariable('locations'), CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>    
                    </div>
                </td>
                */ ?>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('last_name')); ?></strong><br />
                    <?php echo CHtml::textField('last_name', $this->getVariable('last_name'), array('span' => 5, 'maxlength' => 255)); ?>
                </td>
                <td>
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('first_name')); ?></strong><br />
                    <?php echo CHtml::textField('first_name', $this->getVariable('first_name'), array('span' => 5, 'maxlength' => 255)); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" class="btn btn-primary btn-small" value="знайти" />
                    <input type="button" class="btn btn-primary btn-small" value="сброс" onclick="location.href='/manage/profiles'" />
                </td>
            </tr>
        </table>
    </form>
</div>

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
<?php

$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_list'
));
?>
        <tbody>
    </tbody>
</table>