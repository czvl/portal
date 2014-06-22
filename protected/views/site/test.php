<?php

$this->widget('bootstrap.widgets.TbNavbar', array(
    'brandLabel' => 'Title',
    'collapse' => true,
    'items' => array(
        array('label' => 'Home', 'url' => '#', 'active' => true),
        array('label' => 'Link', 'url' => '#'),
        array('label' => 'Link', 'url' => '#'),
    ),
));
?>

<div style="width: 90%; margin: 100px auto;">
<?php

$this->widget('bootstrap.widgets.TbHeroUnit', array(
    'heading' => 'Hello, world!',
    'content' => '<p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>' . TbHtml::button('Learn more', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_LARGE)),
));

?>
</div>
