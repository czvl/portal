        <!-- ******************** HeaderWrap ********************-->
        <div id="headerwrap">
            <header class="clearfix">
                <div class="logo">
                    <img src="/images/logo.png" width="250" height="161" alt="<?php echo $this->pageTitle; ?>" border="0" />
                </div>
                <h1><span>Ми</span> – громадська ініціатива, покликана сприяти працевлаштуванню та соціальній реабілітації громадян України, які у зв’язку з політичними репресіями, військовими діями та складною економічною ситуацією втратили роботу та потребують допомоги.</h1>
                <div class="container">
                    <div class="row">
                        <?php if (!IS_LOCALHOST) { ?>
                        <div class="fb-like" data-href="http://czvl.ua-selector.in/" data-layout="standard" data-action="recommend" data-show-faces="false" data-share="true"></div>
                        <?php } ?>
                        <?php
                        /*<div class="span12">
                            <ul class="icon">
                                <!--li><a href="#" target="_blank"><i class="icon-pinterest-circled"></i></a></li-->
                                <!--li><a href="https://www.facebook.com/groups/MaydanPulse/" target="_blank"><i class="icon-facebook-circled"></i></a></li-->
                                <!--li><a href="#" target="_blank"><i class="icon-twitter-circled"></i></a></li-->
                                <!--li><a href="#" target="_blank"><i class="icon-gplus-circled"></i></a></li-->
                                <!--li><a href="#" target="_blank"><i class="icon-skype-circled"></i></a></li-->
                            </ul>
                        </div>*/
                        ?>
                        <div class="dblock">
                            <h3>Допомогти проекту</h3>

                            <form method="post" action="https://www.liqpay.com/api/pay" accept-charset="utf-8" style="display: inline;">
                                <input type="hidden" name="amount" value="<?php echo $liqpay['amount']; ?>" />
                                <input type="hidden" name="currency" value="<?php echo $liqpay['currency']; ?>" />
                                <input type="hidden" name="description" value="<?php echo $liqpay['description']; ?>" />
                                <input type="hidden" name="order_id" value="<?php echo $liqpay['order_id']; ?>" />
                                <input type="hidden" name="type" value="<?php echo $liqpay['type']; ?>" />
                                <input type="hidden" name="public_key" value="<?php echo $liqpay['public_key']; ?>" />
                                <input type="hidden" name="signature" value="<?php echo $liqpay['signature']; ?>" />
                                <input type="image" src="http://static.liqpay.com/buttons/d1ru.radius.png" name="btn_text" />
                            </form>

                        </div>
                    </div>
                </div>
            </header>
        </div>
        <!--******************** Feature ********************-->
        <div class="scrollblock">
            <section id="feature">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <article>
                                <p>Наше завдання – допомогти тим, хто внаслідок участі в акціях протесту втратили роботу і доступ до засобів існування. Тим, хто були вимушені покинути дім через події в Криму та південно-східних регіонах України.</p>
                                <p>У базі даних &laquo;Центру зайнятості Вільних людей&raquo; – небайдужі громадяни, які шукають спосіб повернутися в русло мирного життя.</p>
                                <p>У базі даних &laquo;Центру зайнятості Вільних людей&raquo; - небайдужі компанії, підприємці та організації, готові допомогти в працевлаштуванні тим, хто сьогодні цього потребує найдужче.</p>
                            </article>
	                        <div align="center">
		                        <img src="http://www.czvl.org.ua/blog/wp-content/uploads/2015/03/results.png" width="757" height="535" alt="Результати роботи ЦЗВЛ за рік" />
	                        </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--******************** Services Section ********************-->
        <a name="services"></a>
        <section id="services" class="single-page scrollblock">
            <div class="container">
                <div class="align"><i class="icon-cog-circled"></i></div>
                <h1>Як ви можете долучитися?</h1>
                <div class="row">
                    <div class="span3">
                        <div class="align"> <i class="icon-rocket sev_icon"></i> </div>
                        <h2>Як волонтер-рекрутер:</h2>
                        <ul>
                            <li>Надавати індивідуальні консультації, допомагати в профорієнтації, складанні резюме;</li>
                            <li>Працювати в точках &laquo;Центру зайнятості Вільних людей&raquo;;</li>
                            <li>Підбирати вакансії для пошукачів до бази даних &laquo;Центру зайнятості Вільних людей&raquo;.</li>
                        </ul>
                        <p>Зареєструватися: <a href="http://bit.ly/czslvlntr" target="_blank">http://bit.ly/czslvlntr</a>.</p>
                    </div>
                    <div class="span3">
                        <div class="align"> <i class="icon-thumbs-up sev_icon"></i> </div>
                        <h2>Як роботодавець:</h2>
                        <ul>
                            <li>Заповнити
                                <?= CHtml::link('Анкету Роботодавця',
                                    Yii::app()->createAbsoluteUrl('/site/registercompany'))?>  &laquo;Центру зайнятості Вільних людей&raquo;;
                            </li>
                            <li>Повідомити &laquo;Центру зайнятості Вільних людей&raquo; про наявні та можливі вакансії;</li>
                            <li>Поширити інформацію про проект у професійних спільнотах, серед друзів та колег.</li>
                        </ul>
                    </div>
                    <div class="span3">
                        <div class="align"> <i class="icon-vector-pencil sev_icon"></i> </div>
                        <h2>Як кандидат:</h2>
                        <ul>
                            <li>Надіслати резюме на адресу czsl.staff@gmail.com та заповнити <a href="/applicants" target="_blank">анкету онлайн</a>;</li>
                        </ul>
                    </div>
                </div>
                <hr />
                <a name="useful"></a>
                <div class="align"><i class="icon-monitor"></i></div>
                <h1>Корисна інформація</h1>
                <div class="row">
                    <div class="span3">
                        <div class="align"> <i class="icon-chat sev_icon"></i> </div>
                        <h2>Як потрапити на зустріч з рекрутерами-волонтерами ЦЗВЛ?</h2>
                        <ul>
                            <li><a href="http://www.czvl.org.ua/blog/counseling/" target="_blank">Кар’єрне консультування</a></li>
                        </ul>
                    </div>
                    <div class="span3">
                        <div class="align"> <i class="icon-map sev_icon"></i> </div>
                        <h2>Як знайти роботу?</h2>
                        <ul>
                            <li><a href="http://www.slideshare.net/undpukraine/undp-employm-idps-ukraine" target="_blank">Бюлетень ООН</a></li>
                            <!--<li><a href="/downloads/CZVL_handout_July2014.pdf" target="_blank">Інформаційний бюлетень ЦЗВЛ, липень '14</a></li>-->
                        </ul>
                    </div>
                    <div class="span3">
                        <div class="align"> <i class="icon-alert sev_icon"></i> </div>
                        <h2>Корисна інформація для вимушених переселенців з Криму, Донбассу:</h2>
                        <ul>
                            <!--li><a href="http://bit.ly/czvlsosinfo" target="_blank">http://bit.ly/czvlsosinfo</a></li-->
                            <li><a href="/downloads/helpful_notes.jpg" target="_blank">Пам'ятка Волонтерської Сотні</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <hr />
        <?php if (!empty($blog_articles)) { ?>
        <a name="blog"></a>
        <!--******************** News Section ********************-->
        <section id="news" class="single-page scrollblock">
            <div class="container">
                <div class="align"><i class="icon-pencil-circled"></i></div>
                <h1>Наш блог</h1>
                <div class="row">
                <?php foreach ($blog_articles as $article) { ?>
                    <article class="span4 post"> <img class="img-news" src="<?php echo $this->getThumb($article['ID']); ?>" width="370" alt="">
                        <div class="inside">
                            <p class="post-date"><i class="icon-calendar"></i> <?php echo $article['p_date']; ?></p>
                            <h2><?php echo $article['post_title']; ?></h2>
                            <div class="entry-content">
                                <p><?php echo mb_substr(strip_tags($article['post_content']), 0, 320); ?> &hellip;</p>
                                <a href="<?php echo $article['guid']; ?>" target="_blank" class="more-link">читати далі</a> </div>
                        </div>
                    </article>
                <?php } ?>
                </div>
                <a href="/blog/" target="_blank" class="btn btn-large">Перейти до блогу</a> </div>
        </section>
        <?php } ?>
        <!--******************** Contact Section ********************-->
        <a name="contact"></a>
        <section id="contact" class="single-page scrollblock">
            <div class="container">
                <div class="align"><i class="icon-mail-2"></i></div>
                <h1>Наші контакти:</h1>
                <div class="row">
                    <div class="span12">
                        <h3>Київ</h3>
                        <h4>Працевлаштування переселенців</h4>
                        <p>+380 (67) 507-09-30 (Kyivstar), +380 (66) 500-35-75 (MTS), czsl.staff@gmail.com
                            Графік прийому дзвінків та відвідувачів: Понеділок, Середа та Пятниця, 10:00-18:00. Обов’язковий попередній запис
                        </p>
                        <h4>Працевлаштування ветеранів АТО, проект “Воїну-гідна праця”</h4>
                        <p>
                            координатор Оксана Воропай +380 (63) 802-61-51, сторінка проекту в <a href="https://www.facebook.com/jobsoldiers" target="_blank">Facebook</a>.
                        </p>

                        <h4>Навчання підприємництву, проект “BizClub”</h4>
                        <p>
                            координатор Віра Лебедєва, +380 (66) 905-62-34, office.bizclub@gmail.com
                        </p>

                        <h4>Працевлаштування людей з інвалідністю</h4>
                        <p>
                            координатор Марина Лебідь, +380 (99) 609-93-45, czvl.inclusion@gmail.com
                        </p>

                        <h4> Працевлаштування людей старшого віку, проект “Дивовік”</h4>
                        <p>координатор Оксана Сулич, +380 (95) 671-85-08, czvl45@ukr.net</p>


                        <h3>Дніпро</h3>

                        +380 (95) 726-80-40, czvl.dp@gmail.com
                        <h3>Запоріжжя</h3>
                        +380 (99) 290-67-71, czvl.zp@gmail.com
                        <h3>Харків</h3>
                        +380 (50) 400-98-67, +380 (97) 365-95-05, kharkov.czvl@gmail.com
                        <h3>Краматорськ</h3>
                        +380 (99) 539-00-23, +380 (95) 919 4416, kram.czvl@gmail.com
                        <h3>Маріуполь</h3>
                        +380 (97) 073-18-77, bcmariupol@gmail.com, cторінка проекту BizClub в Маріуполі на Facebook


                        <p>Для ЗМІ: +380 (63) 415-44-79</p>

                        <p>Наша сторінка у <a href="https://facebook.com/czvl.staff" target="_blank" rel="nofollow">Facebook</a>.</p>
                        <p>Наш <a href="/blog/">Блог</a>.</p>
                    </div>
                </div>
            </div>
        </section>
