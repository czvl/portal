<?php
$this->pageTitle = Yii::app()->name . ' - Error';
?>

<div id="headerwrap">
    <header class="clearfix error">
        <h2><?php echo Yii::t('main', 'Error') . ' ' . $code; ?></h2>
        <?php echo CHtml::encode($message); ?>
    </header>
</div>