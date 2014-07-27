<?php

$this->menu = array(
    array('label' => 'Додати анкету', 'url' => array('create')),
);
?>

<h1>Анкети претендентів</h1>

<h4>Пошук</h4>
<form>
    <table class="search-table">
        <tr>
            <td width="30%">
                <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('status')); ?></strong><br />
                <?php echo CHtml::dropDownList('status', $this->getVariable('status'), CvList::model()->statusTypes, array('empty' => '---')); ?>
            </td>
            <?php /*<td>
                <div class="div-overflow">
                    <strong><?php echo CHtml::encode(CvList::model()->getAttributeLabel('jobLocationsIds')); ?></strong><br />
                    <?php echo CHtml::checkBoxList('locations', $this->getVariable('locations'), CHtml::listData(CitiesList::model()->findAll(array('order' => 'city_name')), 'city_index', 'city_name')); ?>    
                </div>
            </td>
            <td width="30%">
                3
            </td>*/ ?>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" class="btn btn-primary btn-small" value="знайти" />
            </td>
        </tr>
    </table>
</form>

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