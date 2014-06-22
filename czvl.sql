-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Июн 23 2014 г., 00:04
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

-- --------------------------------------------------------

--
-- Структура таблицы `cv_list`
--

CREATE TABLE `cv_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('m','f','u') NOT NULL DEFAULT 'm',
  `birth_date` date NOT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `education` int(1) NOT NULL,
  `eduction_info` text NOT NULL,
  `work_experience` text NOT NULL,
  `skills` text NOT NULL,
  `summary` text NOT NULL,
  `desired_position` varchar(255) NOT NULL,
  `documents` text NOT NULL,
  `applicant_type` text NOT NULL COMMENT 'Діяльність на Майдані / Внутрішні переселенці',
  `cv_file` varchar(255) NOT NULL,
  `recruiter_id` int(11) NOT NULL,
  `recruiter_comments` text NOT NULL,
  `who_filled` varchar(255) NOT NULL DEFAULT 'претендент',
  `added_time` datetime NOT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`gender`),
  KEY `recruiter_id` (`recruiter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_assistance`
--

CREATE TABLE `cv_to_assistance` (
  `cv_id` int(11) NOT NULL,
  `assistance_type_id` int(1) NOT NULL,
  PRIMARY KEY (`cv_id`,`assistance_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_job_location`
--

CREATE TABLE `cv_to_job_location` (
  `cv_id` int(11) NOT NULL,
  `city_id` char(6) NOT NULL,
  PRIMARY KEY (`cv_id`,`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_to_residence`
--

CREATE TABLE `cv_to_residence` (
  `cv_id` int(11) NOT NULL,
  `city_id` char(4) NOT NULL,
  PRIMARY KEY (`cv_id`,`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `role` varchar(100) NOT NULL DEFAULT '1',
  `signin_time` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`,`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cv_list`
--
ALTER TABLE `cv_list`
  ADD CONSTRAINT `cv_list_ibfk_2` FOREIGN KEY (`recruiter_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cv_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `cv_categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_statuses`
--
ALTER TABLE `cv_statuses`
  ADD CONSTRAINT `cv_statuses_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cv_statuses_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_assistance`
--
ALTER TABLE `cv_to_assistance`
  ADD CONSTRAINT `cv_to_assistance_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_job_location`
--
ALTER TABLE `cv_to_job_location`
  ADD CONSTRAINT `cv_to_job_location_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`);

--
-- Ограничения внешнего ключа таблицы `cv_to_residence`
--
ALTER TABLE `cv_to_residence`
  ADD CONSTRAINT `cv_to_residence_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_list` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
