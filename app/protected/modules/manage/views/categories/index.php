<?php
/**
 * @var $model CvCategories
 */

$provider = $model->search();
$provider->pagination->pageSize = 20;
?>

<h1><?= Yii::t('main', 'vacancy.label.categoryIds')?></h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $provider,
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
    ),
));