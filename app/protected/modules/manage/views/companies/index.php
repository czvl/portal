<?php
/**
 * @var $model Company
 */

$this->widget('bootstrap.widgets.TbGridView', [
    'dataProvider' => $model->search(),
    'filter' => $model,
]);
