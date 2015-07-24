<?php
/**
 * @var string $content
 */
?>
<?php $this->beginContent('application.modules.manage.views.layouts.inside'); ?>
            <div class="masthead">
                    <?php
                        $this->widget('bootstrap.widgets.TbNavbar', 
                            array(
                                'brandLabel' => Yii::t('main', Yii::app()->name),
                                'brandUrl' => array('/manage/'),
                                'collapse' => true,
                                'items' => array(
                                    array(
                                        'class' => 'bootstrap.widgets.TbNav',
                                        'items' => array(
                                            array(
                                                'label' => 'Анкети претендентів',
                                                'url' => array('/manage/profiles'),
                                                'visible' => Yii::app()->user->checkAccess(User::ROLE_VOLONT)                                           ),
                                            [
                                                'label' => 'Вакансіі',
                                                'items' => [
                                                    [
                                                        'label' => 'Перелік вакансій',
                                                        'url' => array('/manage/vacancies'),
                                                        'visible' => Yii::app()->user->checkAccess(User::ROLE_VOLONT)
                                                    ],
                                                    [
                                                        'label' => 'Компанії',
                                                        'url' => array('/manage/companies'),
                                                        'visible' => Yii::app()->user->checkAccess(User::ROLE_VOLONT)
                                                    ],

                                                ],
                                            ],

                                            array(
                                                'label' => 'Роботодавець',
                                                'visible' => Yii::app()->user->checkAccess(User::ROLE_EMPL),
                                                'url' => array('/manage/employer'),
                                            ),
                                            array('label' => 'Адміністративна частина', 'items' => array(
                                                    array('label' => 'Користувачі', 'url' => array('/manage/users')),
                                                    TbHtml::menuDivider(),
                                                    array('label' => 'Довідник категорій', 'url' => ['/manage/categories']),
                                                ), 'visible' => Yii::app()->user->checkAccess(User::ROLE_ADMIN) || Yii::app()->user->checkAccess(User::ROLE_MANAGER)
                                            ),
                                        ),
                                    ),
                                    array(
                                        'class' => 'bootstrap.widgets.TbNav',
                                        'htmlOptions' => array('class' => 'pull-right'),
                                        'items' => array(
                                            array('label' => Yii::t('main', 'Hello') . ", " . Yii::app()->session['first_name'] . " " . Yii::app()->session['last_name'] . "!", 'items' => array(
                                               array('label' => 'Мій профайл', 'url' => array('/manage/profile/')) 
                                            ), 'visible' => !Yii::app()->user->isGuest),
                                            array('label' => Yii::t('main', 'Logout'), 'url' => array('/manage/logout'), 'visible' => !Yii::app()->user->isGuest),
                                            array('label' => Yii::t('main', 'Login'), 'url' => array('/manage/login'), 'visible' => Yii::app()->user->isGuest),
                                        ),
                                    ),
                                )
                            )
                        );
                ?>
            </div>
            <div class="row-fluid">
            <?php if (!empty($this->menu)) { ?>
                <div class="float-menu">
                    <span class="sticker"><?php echo TbHtml::icon(TbHtml::ICON_TASKS); ?></span>
                    <?php echo TbHtml::navList($this->menu); ?>
                </div>
            <?php } ?>
                <?php if(Yii::app()->user->hasFlash('error')):?>
                        <div class="alert alert-danger">
                            <?=Yii::app()->user->getFlash('error')?>
                        </div>
                 <?php endif;?>
                <?php if(Yii::app()->user->hasFlash('success')):?>
                    <div class="alert alert-success">
                        <?=Yii::app()->user->getFlash('success')?>
                    </div>
                <?php endif;?>
                <?php echo $content; ?>
            </div>
<?php $this->endContent(); ?>