<?php $this->beginContent('application.modules.manage.views.layouts.inside'); ?>
            <div class="masthead">
                    <?php
                        $this->widget('bootstrap.widgets.TbNavbar', array(
                            'brandLabel' => Yii::t('main', Yii::app()->name),
                            'brandUrl' => array('/manage/'),
                            'collapse' => true,
                            'items' => array(
                                array(
                                    'class' => 'bootstrap.widgets.TbNav',
                                    'items' => array(
                                        array('label' => 'Анкети претендентів', 'url' => array('/manage/profiles'), 'visible' => !Yii::app()->user->isGuest),
//                                        array('label' => 'Dropdown', 'items' => array(
//                                            array('label' => 'Action', 'url' => '#'),
//                                            array('label' => 'Another action', 'url' => '#'),
//                                            array('label' => 'Something else here', 'url' => '#'),
//                                            TbHtml::menuDivider(),
//                                            array('label' => 'Separate link', 'url' => '#'),
//                                        ), 'visible' => !Yii::app()->user->isGuest),
                                    ),
                                ),
                                array(
                                    'class' => 'bootstrap.widgets.TbNav',
                                    'htmlOptions' => array('class' => 'pull-right'),
                                    'items' => array(
                                        array('label' => Yii::t('main', 'Hello') . ", " . Yii::app()->session['first_name'] . " " . Yii::app()->session['last_name'] . "!", 'visible' => !Yii::app()->user->isGuest),
                                        array('label' => Yii::t('main', 'Logout'), 'url' => array('/manage/logout'), 'visible' => !Yii::app()->user->isGuest),
                                        array('label' => Yii::t('main', 'Login'), 'url' => array('/manage/login'), 'visible' => Yii::app()->user->isGuest),
                                    ),
                                ),
                            ))
                        );
                ?>
            </div>
            <div class="row-fluid">
            <?php if (!empty($this->menu)) { ?>
                <div class="span3">
                    <div class="well" style="max-width: 340px; padding: 8px 0;">
                        <?php echo TbHtml::navList($this->menu); ?>
                    </div>
                </div>
                <div class="span9">
                    <?php echo $content; ?>
                </div>
            <?php } else { ?>
                <?php echo $content; ?>
            <?php } ?>
            </div>
<?php $this->endContent(); ?>