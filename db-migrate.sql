-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 09 2013 г., 20:02
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
-- Структура таблицы `Point`
--

CREATE TABLE IF NOT EXISTS `Point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `franchise_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `latitude` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `longitude` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7664DC20523CAB89` (`franchise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `Point`
--

INSERT INTO `Point` (`id`, `franchise_id`, `title`, `description`, `latitude`, `longitude`) VALUES
(1, 2, 'Старбакс', 'Описание старбакса , работает с 8 до 18', '0.000000', '0.000000'),
(2, 1, 'coffee haven на Арбатской', 'с 8 до 22 каждый день', '0.000000', '0.000000'),
(3, 1, 'тест точка кофе', 'с 8 до 22', '55.718022', '37.584915');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Point`
--
ALTER TABLE `Point`
  ADD CONSTRAINT `FK_7664DC20523CAB89` FOREIGN KEY (`franchise_id`) REFERENCES `Franchise` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
