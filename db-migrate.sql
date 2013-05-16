-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 16 2013 г., 15:58
-- Версия сервера: 5.5.29
-- Версия PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `agent`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `education` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `income` int(11) DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `age`, `sex`, `education`, `income`, `city`) VALUES
(1, 'admin', 'admin', 'marchukilya@gmail.com', 'marchukilya@gmail.com', 1, '6ymk8ljquskkwc8k8ssc04ckgwwgsw', '+wnODwlCO0f4EQJYGlbQJDfI/E0iTQ6RmhjUjA6Bt+3MZIMelF3gZmGEDmzJMpzmrV2o6Zkvhk7sGPbAZNMNbg==', '2013-05-16 10:13:12', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ilya', 'ilya', 'ilya@gmail.com', 'ilya@gmail.com', 1, '1udpzyc4too0gsg8cgko0044sc4ggcw', 'N4WwiISp4FL9JyPWL0IXVjiHdw8rTocO3L28vjCWFSdghxh/+MehV/PSsObcAIpg7MqScTNemCMjIoIJruVOhQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Franchise`
--

CREATE TABLE IF NOT EXISTS `Franchise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `industry` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `Franchise`
--

INSERT INTO `Franchise` (`id`, `brand`, `industry`, `logo`) VALUES
(1, 'CoffeeHeaven', 'horeca', ''),
(2, 'Starbucks Coffee Company', 'horeca', ''),
(3, 'йуцк1', 'фыва', 'ch.gif'),
(5, 'вася', 'петя', '');

-- --------------------------------------------------------

--
-- Структура таблицы `Mission`
--

CREATE TABLE IF NOT EXISTS `Mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `runtime` time NOT NULL,
  `need_buy` tinyint(1) DEFAULT NULL,
  `costs` int(11) NOT NULL,
  `icons` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `missionType_id` int(11) DEFAULT NULL,
  `point_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5FDACBA0AB3A88C2` (`missionType_id`),
  KEY `IDX_5FDACBA0C028CEA2` (`point_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `Mission`
--

INSERT INTO `Mission` (`id`, `runtime`, `need_buy`, `costs`, `icons`, `description`, `missionType_id`, `point_id`, `active`) VALUES
(1, '02:00:00', 0, 34, '456', 'Общее впечатление о заведении', 2, 2, NULL),
(3, '20:00:00', 0, 20, 'afdaqfqerf', 'qefqe', 1, 1, NULL),
(4, '00:10:00', 1, 100, 'бла бла', 'Оценка обслуживания', 1, 1, NULL),
(5, '00:15:00', 0, 100, 'ico', 'Чистота стола', 1, 1, NULL),
(6, '01:00:00', 1, 30, 'ico2', 'Улыбки', 1, 1, NULL),
(7, '02:00:00', 0, 22, 'ico_test.ico', 'описание', NULL, NULL, NULL),
(9, '01:30:00', 1, 100, 'ico', 'тест создания с добавлением точки', 3, 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `MissionAccomplished`
--

CREATE TABLE IF NOT EXISTS `MissionAccomplished` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coordinates` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `info` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `form` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `files` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `MissionType`
--

CREATE TABLE IF NOT EXISTS `MissionType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `MissionType`
--

INSERT INTO `MissionType` (`id`, `title`) VALUES
(1, 'Оценка сервиса (короткий и длинный вариант)'),
(2, 'Контрольная покупка (оценка процесса покупки и качества товара)'),
(3, 'Оценка выкладки (для ритейлеров)');

-- --------------------------------------------------------

--
-- Структура таблицы `Point`
--

CREATE TABLE IF NOT EXISTS `Point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `franchise_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `latitude` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `longitude` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7664DC20523CAB89` (`franchise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `Point`
--

INSERT INTO `Point` (`id`, `franchise_id`, `title`, `description`, `latitude`, `longitude`, `active`) VALUES
(1, 2, 'Старбакс', 'Описание старбакса , работает с 8 до 18', '55.77', '37.58', NULL),
(2, 1, 'coffee haven на Арбатской', 'с 8 до 22 каждый день', '37.584915', '37.584915', NULL),
(3, 1, 'тест точка кофе', 'с 8 до 22', '55.718022', '37.584915', NULL),
(4, 5, 'Скалолазный центр Big Wall', 'пн-пт 08:00-22:30; сб,вс 10:00-22:30', '55.789126', '37.587051', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Question`
--

CREATE TABLE IF NOT EXISTS `Question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` longtext COLLATE utf8_unicode_ci NOT NULL,
  `answers` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `questionType_id` int(11) DEFAULT NULL,
  `limitAnswer` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4F812B18BE6CAE90` (`mission_id`),
  KEY `IDX_4F812B18F49F7D84` (`questionType_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `Question`
--

INSERT INTO `Question` (`id`, `question`, `answers`, `mission_id`, `questionType_id`, `limitAnswer`) VALUES
(25, 'Стол чистый?', 'да, нет', 5, 1, 1),
(26, 'проверка', 'да,нет, может быть', 5, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `QuestionType`
--

CREATE TABLE IF NOT EXISTS `QuestionType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `QuestionType`
--

INSERT INTO `QuestionType` (`id`, `title`) VALUES
(1, 'Да / нет'),
(2, 'Числовая оценка (кликом)'),
(3, 'Выбор из закрытого списка одного варианта (кликом)'),
(4, 'Выбор из закрытого списка нескольких вариантов (кликом, с лимитом)'),
(5, 'Открытый вопрос (комментарии в текстовой форме)'),
(6, 'Запрос на фото');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Mission`
--
ALTER TABLE `Mission`
  ADD CONSTRAINT `FK_5FDACBA0AB3A88C2` FOREIGN KEY (`missionType_id`) REFERENCES `MissionType` (`id`),
  ADD CONSTRAINT `FK_5FDACBA0C028CEA2` FOREIGN KEY (`point_id`) REFERENCES `Point` (`id`);

--
-- Ограничения внешнего ключа таблицы `Point`
--
ALTER TABLE `Point`
  ADD CONSTRAINT `FK_7664DC20523CAB89` FOREIGN KEY (`franchise_id`) REFERENCES `Franchise` (`id`);

--
-- Ограничения внешнего ключа таблицы `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `FK_4F812B18BE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `Mission` (`id`),
  ADD CONSTRAINT `FK_4F812B18F49F7D84` FOREIGN KEY (`questionType_id`) REFERENCES `QuestionType` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
