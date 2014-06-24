<?php

Yii::app()->clientScript->registerPackage('main');

?>
<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="utf-8" />
        <title>Центр Зайнятості Вільних Людей</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Громадянська ініціатива, покликана допомогти соціальній реабілітації та працевлаштуванню учасників новітньої української революції, а також вимушених переселенців із Криму та інших регіонів України." />
        <meta name="author" content="Nataliya Shvaykovska (czsl.staff@gmail.com)" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/prettyPhoto.css" rel='stylesheet' id='prettyphoto-css' type="text/css" media="all" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontello.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" type="text/css" rel="stylesheet" />
        <!--[if lt IE 7]><link href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontello-ie7.css" type="text/css" rel="stylesheet" /><![endif]-->
        <link href="http://fonts.googleapis.com/css?family=Quattrocento:400,700" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Scada" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" />
    </head>
    <body>
        <?php if (!IS_LOCALHOST) { ?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=320686717952781"; fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
        <?php } ?>
        <!--******************** NAVBAR ********************-->
        <div class="navbar-wrapper">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
                        <h1 class="brand"><a href="#top"><?php echo Yii::t('main', Yii::app()->name); ?></a><sup>BETA</sup></h1>
                        <nav class="pull-right nav-collapse collapse">
                            <ul id="menu-main" class="nav">
                                <li><a title="services" href="#services"><?php echo Yii::t('main', 'How can you get involved?'); ?></a></li>
                                <li><a title="contact" href="#contact"><?php echo Yii::t('main', 'Contacts'); ?></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div id="top"></div>
	<?php echo $content; ?>

        <div class="footer-wrapper">
            <div class="container">
                <footer>
                    <small>&copy; <?php echo date('Y'); ?>. <?php echo Yii::t('main', 'All rights reserved.'); ?></small>
                </footer>
            </div>
        </div>
        <?php if (!IS_LOCALHOST) { ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-34204107-3', 'czvl.ua-selector.in');
            ga('send', 'pageview');
        </script>
        <?php } ?>
    </body>
</html>