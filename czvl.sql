-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Июл 27 2014 г., 23:03
-- Версия сервера: 5.5.34
-- Версия PHP: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `czvl`
--

-- --------------------------------------------------------

--
-- Структура таблицы `assistance_types`
--

CREATE TABLE `assistance_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `assistance_types`
--

INSERT INTO `assistance_types` (`id`, `name`) VALUES
(1, 'Консультація рекрутера, профоріентація'),
(2, 'Допомога в складанні резюме'),
(3, 'Допомога в пошуках постійної роботи'),
(4, 'Пропозиція тимчасового працевлаштування');

-- --------------------------------------------------------

--
-- Структура таблицы `cities_list`
--

CREATE TABLE `cities_list` (
  `city_index` char(5) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  PRIMARY KEY (`city_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cities_list`
--

INSERT INTO `cities_list` (`city_index`, `city_name`) VALUES
('00005', 'Вінницькаа область'),
('00007', 'Волинська область'),
('00009', 'Луганська область'),
('00012', 'Дніпропетровська область'),
('00014', 'Донецька область'),
('00018', 'Житомирська область'),
('00021', 'Закарпатська область'),
('00023', 'Запоріжська область'),
('00026', 'Івано-Франківська область'),
('00032', 'Київська область'),
('00035', 'Кіровоградська область'),
('00046', 'Львівська область'),
('00048', 'Миколаївська область'),
('00051', 'Одеська область'),
('00053', 'Полтавська область'),
('00056', 'Рівненська область'),
('00059', 'Сумська область'),
('00061', 'Тернопільська область'),
('00063', 'Харківська область'),
('00065', 'Херсонська область'),
('00068', 'Хмельницька область'),
('00071', 'Черкаська область'),
('00074', 'Чернігівська область'),
('00077', 'Чернівецька область'),
('01000', 'Київ'),
('09100', 'Біла Церква'),
('10000', 'Житомир'),
('14000', 'Чернігів'),
('18000', 'Черкаси'),
('21000', 'Вінниця'),
('25000', 'Кіровоград'),
('29000', 'Хмельницький'),
('32300', 'Кам''янець-Подільський'),
('33000', 'Рівне'),
('36000', 'Полтава'),
('39600', 'Кременчук'),
('40000', 'Суми'),
('43000', 'Луцьк'),
('46000', 'Тернопіль'),
('49000', 'Дніпропетровськ'),
('50000', 'Кривий Ріг'),
('51400', 'Павлоград'),
('51900', 'Дніпродзержинськ'),
('53200', 'Нікополь'),
('54000', 'Миколаїв'),
('58000', 'Чернівці'),
('61000', 'Харків'),
('65000', 'Одеса'),
('69000', 'Запоріжжя'),
('71100', 'Бердянськ'),
('72300', 'Мелітополь'),
('73000', 'Херсон'),
('76000', 'Івано-Франківськ'),
('79000', 'Львів'),
('83000', 'Донецьк'),
('84100', 'Слов''янськ'),
('84300', 'Краматорськ'),
('84600', 'Горлівка'),
('86100', 'Макіївка'),
('87500', 'Маріуполь'),
('88000', 'Ужгород'),
('91000', 'Луганськ'),
('93100', 'Лисичанськ'),
('93400', 'Сєвєродонецьк'),
('94200', 'Алчевськ'),
('95000', 'Сімферополь'),
('97400', 'Євпаторія'),
('98300', 'Керч'),
('98600', 'Ялта'),
('99000', 'Севастополь');

-- --------------------------------------------------------

--
-- Структура таблицы `cv_categories`
--

CREATE TABLE `cv_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `cv_categories`
--

INSERT INTO `cv_categories` (`id`, `name`, `description`) VALUES
(1, 'Продажи', 'Дистрибуция \r\nМенеджер по работе с клиентами\r\nОптовая торговля\r\nПродажи по телефону, Телемаркетинг\r\nПрямые продажи\r\nТендеры\r\nТорговый представитель\r\nУправление продажами'),
(2, 'Адмінперсонал', 'Архивист\r\nВвод данных\r\nВодитель\r\nДелопроизводство\r\nКурьер\r\nПерсональный ассистент\r\nПисьменный перевод\r\nПоследовательный перевод\r\nРесепшен\r\nСекретарь\r\nСинхронный перевод\r\nСотрудник call-центра\r\nУборщица\r\nУправляющий офисом(Оffice manager)\r\nУчет товарооборота'),
(3, 'Рабочий персонал', 'Грузчик\r\nДворник, Уборщик\r\nКомплектовщик, Укладчик-упаковщик\r\nМаляр\r\nМеханик\r\nМонтажник\r\nРазнорабочий\r\nСантехник\r\nСборщик\r\nСварщик\r\nСлесарь\r\nСтоляр\r\nТокарь, Фрезеровщик\r\nШвея\r\nШлифовщик\r\nШтукатур\r\nЭлектрик\r\nОхранники'),
(4, 'Медицина', 'Ветеринария\r\nКлинические исследования\r\nЛаборант\r\nЛечащий врач\r\nМедицинский представитель\r\nМладший и средний медперсонал\r\nОптика\r\nПсихология\r\nРегистратура\r\nФармацевт'),
(5, 'Промышленность, производство', 'Главный механик\r\nИнженер\r\nКонструктор\r\nКонтроль качества\r\nМетролог\r\nТехнолог\r\nУправление проектами\r\nУправление цехом\r\nСметчик\r\nИнженер'),
(6, 'Юристы', 'Адвокат\r\nЮристконсульт\r\nНотариус'),
(7, 'Розничная торговля', 'Продавец в магазине\r\nАдминистратор магазина'),
(8, 'Наука', 'Освіта, наука'),
(9, 'ГО, НГО', 'Государственная служба, некоммерческие организации'),
(10, 'Охрана', ''),
(11, 'Домашний персонал', 'Воспитатель, Гувернантка, Няня\r\nПерсональный водитель\r\nПовар\r\nПомощник по хозяйству, Управляющий\r\nРепетитор\r\nСадовник\r\nСиделка\r\nДомработница, Горничная'),
(12, 'Банки', 'Автокредитование\r\nАкции, Ценные бумаги\r\nАналитик\r\nАудит, Внутренний контроль\r\nВнутренние операции (Back Office)\r\nИпотека, Ипотечное кредитование\r\nКассовое обслуживание, инкассация\r\nКредиты\r\nЛизинг\r\nНалоги\r\nОбменные пункты, Банкоматы\r\nПривлечение клиентов\r\nПроектное финансирование\r\nФинансовый мониторинг'),
(13, 'Маркетинг, PR', 'PR, Маркетинговые коммуникации\r\nАналитик\r\nАрт директор\r\nБренд-менеджмент\r\nДизайнер\r\nИнтернет-маркетинг\r\nИсследования рынка\r\nКонсультант\r\nКопирайтер\r\nМенеджер по работе с клиентами\r\nМерчендайзинг\r\nПланирование, Размещение рекламы\r\nПроведение опросов, Интервьюер\r\nПроизводство рекламы\r\nПромоутер\r\nРекламный агент\r\nТорговый маркетинг(Trade marketing)\r\nУправление маркетингом'),
(14, 'Искусство, медиа', 'Дизайн, графика, живопись\r\nЖурналистика\r\nИздательская деятельность\r\nКазино и игорный бизнес\r\nКино\r\nЛитературная, Редакторская деятельность\r\nМода\r\nМузыка\r\nПресса\r\nРадио\r\nТелевидение\r\nФотография'),
(15, 'Транспорт, логистика', 'Водитель\r\nДиспетчер\r\nЗакупки, Снабжение\r\nКладовщик\r\nЛогистика\r\nРабочий склада\r\nЭкспедитор'),
(16, 'Красота,спорт', 'Администрация\r\nКосметология\r\nМассажист\r\nНогтевой сервис\r\nПарикмахер\r\nТренерский состав'),
(17, 'Туризм, отели, рестораны', 'Гид, Экскурсовод\r\nОрганизация встреч, Конференций\r\nОфициант, Бармен\r\nПерсонал кухни\r\nПовар\r\nСомелье\r\nУправление гостиницами\r\nУправление ресторанами, Барами\r\nУправление туристическим бизнесом\r\nХостес\r\nШеф-повар'),
(18, 'ІТ, телеком', 'CTO, CIO, Директор по IT\r\nWeb инженер\r\nWeb мастер\r\nАдминистратор баз данных\r\nАналитик\r\nКомпьютерная безопасность\r\nКонсалтинг, Аутсорсинг\r\nОптимизация сайта (SEO)\r\nПоддержка, Helpdesk\r\nПрограммирование, Разработка\r\nСетевые технологии\r\nСистемная интеграция\r\nСистемный администратор\r\nСотовые, Беспроводные технологии\r\nТелекоммуникации\r\nТестирование'),
(19, 'Финансы', 'Аудит\r\nБухгалтер\r\nКазначейство\r\nКассир, Инкассатор\r\nКредитный контроль\r\nНалоги\r\nПланово-экономическое управление\r\nРуководство бухгалтерией\r\nФинансовый анализ\r\nФинансовый менеджмент\r\nЭкономист'),
(20, 'Строительство', 'Дизайн/Оформление\r\nЖКХ\r\nЗемлеустройство\r\nОценка\r\nПроектирование, Архитектура\r\nПрораб\r\nРабочие строительных специальностей\r\nУправление проектами'),
(21, 'Переводчики', ''),
(22, 'Менеджеры', 'Руководящие должности'),
(23, 'Персонал, психолог', ''),
(24, 'По решению рекрутера', '');

-- --------------------------------------------------------

--
-- Структура таблицы `cv_list`
--

CREATE TABLE `cv_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('m','f','u') NOT NULL DEFAULT 'm',
  `marital_status` int(1) NOT NULL DEFAULT '0',
  `birth_date` date NOT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `other_contacts` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `education` int(1) NOT NULL,
  `eduction_info` text NOT NULL,
  `work_experience` text NOT NULL,
  `skills` text NOT NULL,
  `summary` text NOT NULL,
  `salary` varchar(255) NOT NULL,
  `desired_position` varchar(255) NOT NULL,
  `documents` text NOT NULL,
  `applicant_type` text NOT NULL COMMENT 'Діяльність на Майдані / Внутрішні переселенці',
  `cv_file` varchar(255) NOT NULL,
  `recruiter_id` int(11) NOT NULL,
  `recruiter_comments` text NOT NULL,
  `who_filled` varchar(255) NOT NULL DEFAULT 'претендент',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `added_time` datetime NOT NULL,
  `status` int(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`gender`),
  KEY `recruiter_id` (`recruiter_id`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `gender` (`gender`),
  KEY `birth_date` (`birth_date`),
  KEY `education` (`education`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `cv_list`
--

INSERT INTO `cv_list` (`id`, `first_name`, `last_name`, `gender`, `marital_status`, `birth_date`, `contact_phone`, `other_contacts`, `email`, `education`, `eduction_info`, `work_experience`, `skills`, `summary`, `salary`, `desired_position`, `documents`, `applicant_type`, `cv_file`, `recruiter_id`, `recruiter_comments`, `who_filled`, `last_update`, `added_time`, `status`) VALUES
(1, 'Валерий', 'Назарчук', 'm', 1, '1983-02-10', '380631234530', '', 'test@test.com', 5, 'Высшее\r\nс 09.2004 по 06.2008\r\nНациональный транспортный университет (НТУ), факультет “Дорожностроительный” , специальность “Автомобильные дороги и аэродромы”, Киев.\r\n\r\nСреднее специальное\r\nс 09.2000 по 05.2004\r\nКиевский техникум мененджмента транспортного строительства, Строительство тоннелей и метрополитенов, Киев.', 'Руководитель группы\r\nс 09.2011 по 06.2014 (2 года 9 месяцев)\r\nТОВ"Євродоринжпроект" (Проектирование автомобильных дорог)\r\n\r\nУправление группой проектировщиков, работа с заказчиками, организация выпуска проектной документации по стадиям РП и РД, защита проектов в экспертизе.\r\n\r\nИнженер-проектировщик\r\nс 06.2008 по 09.2011 (3 года 3 месяца)\r\nООО«Институт проектирования объектов дорожного хозяйства» (ООО «ГИПРОДОР») (Проектирование автомобильных дорог)\r\n\r\nПроектирование автомобильных дорог, выполнение заданий по разработке проектной документации, полевых и камеральных работ на изысканиях, проектирование организации дорожного движения.', 'Навыки работы с компьютером, ПО\r\nУверенный пользователь.\r\nWord, Excel, AutoCAD, CREDO ДОРОГИ,CREDO ГЕНПЛАН, АС-4 ПИР', 'Инженер-строитель, проектировщик автомобильных дорог, геодезист, прораб, мастер, полная занятость, неполная занятость, удаленная работа', '3000', 'Инженер-строитель', 'паспорт, диплом', 'Активист майдану', 'http://bit.ly/doc1', 1, 'Личные качества:\r\nОтветственность, честность, коммуникабельность, умение работать с людьми, открыт для новог', 'претендент', '2014-07-27 20:07:12', '2014-06-22 12:34:03', 2),
(2, 'Віталій Володимирович', 'Смірнов', 'm', 1, '1977-08-07', '3805555555', '', 'test@test.com', 2, 'some text', 'Text, text, text, text, text, text, text, text, text, text, text, text, text.', 'Text, text, text, text, text, text, text, text, text, text, text, text, text.\r\nText, text, text, text, text, text, text, text, text, text, text, text, text.', 'Text, text, text, text, text, text, text, text, text, text, text, text, text.', '', 'Anykey', 'passport', 'переселенці', 'http://bit.ly/test.doc', 2, 'Nothing.', 'претендент', '2014-07-27 08:15:46', '2014-06-26 00:00:00', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cv_statuses`
--

CREATE TABLE `cv_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cv_id` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `operator_id` (`operator_id`),
  KEY `cv_id` (`cv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `cv_statuses`
--

INSERT INTO `cv_statuses` (`id`, `cv_id`, `operator_id`, `message`, `added_time`) VALUES
(1, 1, 1, 'Николай Иванович уловил замечательную для того времени тенденцию - немного провокационные, но при этом умные книги могут стать отличной рекламой для тренинговых центров.', '2014-06-22 13:02:59'),
(2, 1, 1, 'Из личного опыта поняла, что эта книга – не для ленивых, мало её просто прочитать, по ней нужно работать.', '2014-06-22 14:02:59'),
(3, 2, 2, 'Временно не ищет', '2014-07-26 20:07:32'),
(4, 1, 1, 'Тестовий статус.', '2014-07-27 08:18:56');

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_assistance`
--

CREATE TABLE `cv_to_assistance` (
  `cv_id` int(11) NOT NULL,
  `assistance_type_id` int(1) NOT NULL,
  PRIMARY KEY (`cv_id`,`assistance_type_id`),
  KEY `assistance_type_id` (`assistance_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv_to_assistance`
--

INSERT INTO `cv_to_assistance` (`cv_id`, `assistance_type_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_category`
--

CREATE TABLE `cv_to_category` (
  `cv_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`cv_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv_to_category`
--

INSERT INTO `cv_to_category` (`cv_id`, `category_id`) VALUES
(1, 3),
(2, 12),
(1, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_driver_license`
--

CREATE TABLE `cv_to_driver_license` (
  `cv_id` int(11) NOT NULL,
  `license_id` int(1) NOT NULL,
  PRIMARY KEY (`cv_id`,`license_id`),
  KEY `license_id` (`license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv_to_driver_license`
--

INSERT INTO `cv_to_driver_license` (`cv_id`, `license_id`) VALUES
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_job_location`
--

CREATE TABLE `cv_to_job_location` (
  `cv_id` int(11) NOT NULL,
  `city_id` char(5) NOT NULL,
  PRIMARY KEY (`cv_id`,`city_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv_to_job_location`
--

INSERT INTO `cv_to_job_location` (`cv_id`, `city_id`) VALUES
(1, '01000'),
(2, '10000'),
(1, '65000');

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_residence`
--

CREATE TABLE `cv_to_residence` (
  `cv_id` int(11) NOT NULL,
  `city_id` char(5) NOT NULL,
  PRIMARY KEY (`cv_id`,`city_id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv_to_residence`
--

INSERT INTO `cv_to_residence` (`cv_id`, `city_id`) VALUES
(1, '76000'),
(2, '84600');

-- --------------------------------------------------------

--
-- Структура таблицы `driver_licenses`
--

CREATE TABLE `driver_licenses` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `driver_licenses`
--

INSERT INTO `driver_licenses` (`id`, `name`) VALUES
(1, 'A1'),
(2, 'A'),
(3, 'B1'),
(4, 'B'),
(5, 'C1'),
(6, 'C'),
(7, 'D1'),
(8, 'D'),
(9, 'BE'),
(10, 'C1E'),
(11, 'CE'),
(12, 'D1E'),
(13, 'DE'),
(14, 'T');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'applicant',
  `signin_time` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`,`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `role`, `signin_time`, `last_login`, `status`) VALUES
(1, 'shvaykovski', 'IGbXUArjl59rE', 'maxim@shvaykovski.com', 'Максим', 'Швайковський', 'administrator', '2014-06-21 18:07:56', '2014-07-26 17:44:49', 1),
(2, 'shvaykovska', 'wclTRJy1jQDxQ', 'shvaykovska@gmail.com', 'Наталія', 'Швайковська', 'administrator', '2014-06-24 10:03:28', '2014-06-24 11:09:39', 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cv_list`
--
ALTER TABLE `cv_list`
  ADD CONSTRAINT `cv_list_ibfk_2` FOREIGN KEY (`recruiter_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_statuses`
--
ALTER TABLE `cv_statuses`
  ADD CONSTRAINT `cv_statuses_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`),
  ADD CONSTRAINT `cv_statuses_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_assistance`
--
ALTER TABLE `cv_to_assistance`
  ADD CONSTRAINT `cv_to_assistance_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`),
  ADD CONSTRAINT `cv_to_assistance_ibfk_2` FOREIGN KEY (`assistance_type_id`) REFERENCES `assistance_types` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_category`
--
ALTER TABLE `cv_to_category`
  ADD CONSTRAINT `cv_to_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `cv_categories` (`id`),
  ADD CONSTRAINT `cv_to_category_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_driver_license`
--
ALTER TABLE `cv_to_driver_license`
  ADD CONSTRAINT `cv_to_driver_license_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`),
  ADD CONSTRAINT `cv_to_driver_license_ibfk_2` FOREIGN KEY (`license_id`) REFERENCES `driver_licenses` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_job_location`
--
ALTER TABLE `cv_to_job_location`
  ADD CONSTRAINT `cv_to_job_location_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`),
  ADD CONSTRAINT `cv_to_job_location_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities_list` (`city_index`);

--
-- Ограничения внешнего ключа таблицы `cv_to_residence`
--
ALTER TABLE `cv_to_residence`
  ADD CONSTRAINT `cv_to_residence_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`),
  ADD CONSTRAINT `cv_to_residence_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities_list` (`city_index`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
