# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 192.168.59.103 (MySQL 5.6.39)
# Схема: funds
# Время создания: 2018-04-03 14:50:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы currencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `currencies`;

CREATE TABLE `currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_short_name` varchar(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;

INSERT INTO `currencies` (`id`, `country`, `currency`, `currency_short_name`, `created_at`, `updated_at`)
VALUES
	(1,'','','EU',NULL,NULL),
	(2,'СЛЗ','Динар','DR',NULL,NULL),
	(3,'Республика Энерия','Энерго-кредит','MP',NULL,NULL),
	(4,'Нова','Нова-Кредит','NC',NULL,NULL),
	(5,'Ирландия','Золотой Дублон','GD',NULL,NULL),
	(6,'РКВ','Золотой дракон','SGD',NULL,NULL);

/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы currency_delta
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_delta`;

CREATE TABLE `currency_delta` (
   `currency` VARCHAR(11) NULL DEFAULT NULL,
   `delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы currency_falling
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_falling`;

CREATE TABLE `currency_falling` (
   `currency_short_name` VARCHAR(11) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы currency_growth
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_growth`;

CREATE TABLE `currency_growth` (
   `currency_short_name` VARCHAR(11) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы currency_union
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_union`;

CREATE TABLE `currency_union` (
   `currency_short_name` VARCHAR(11) NULL DEFAULT NULL,
   `delta1` DOUBLE NULL DEFAULT NULL,
   `delta2` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `markets`;

CREATE TABLE `markets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_currency` int(11) unsigned NOT NULL,
  `type` enum('INTERNAL','EXTERNAL') NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `market_short_name` varchar(255) NOT NULL,
  `max_companies` int(11) DEFAULT NULL,
  `max_agents` int(11) DEFAULT NULL,
  `max_capitalization` double DEFAULT NULL,
  `min_capitalization` double(255,0) DEFAULT NULL,
  `min_amount` double(255,0) DEFAULT NULL,
  `max_amount` double(255,0) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `rate_agri` int(11) DEFAULT NULL,
  `rate_indus` int(11) DEFAULT NULL,
  `rate_serv` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `markets_id_uindex` (`id`),
  KEY `markets_currencies_id_fk` (`fk_currency`),
  CONSTRAINT `markets_currencies_id_fk` FOREIGN KEY (`fk_currency`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `markets` WRITE;
/*!40000 ALTER TABLE `markets` DISABLE KEYS */;

INSERT INTO `markets` (`id`, `fk_currency`, `type`, `name`, `logo`, `market_short_name`, `max_companies`, `max_agents`, `max_capitalization`, `min_capitalization`, `min_amount`, `max_amount`, `created_at`, `updated_at`, `rate_agri`, `rate_indus`, `rate_serv`)
VALUES
	(2,2,'EXTERNAL','Moon and Star union External Exchange','/resource/img/MSUEE.png','MSUEE',123,1,5000000000,1000000,100,500000,NULL,1518644325,0,50,50),
	(3,3,'EXTERNAL','Enerian Republic Exchange Service','/resource/img/ERES.png','ERES',130,1,2000000000,100000,1000,50000,NULL,1518644295,0,65,35),
	(5,4,'EXTERNAL','Nova System External Stock','/resource/img/NSES.png','NSES',18,1,20000000000,100000000,10000,100000,NULL,1518644383,0,75,25),
	(6,6,'EXTERNAL','Glory Shining Cat Overlord Market','/resource/img/GSCOM.png','GSCOM',200,1,1000000000,1000000,100,500000,NULL,1518810424,2,26,72),
	(7,5,'EXTERNAL','Federal Republic Ierland External Stock','/resource/img/FRIES.png','FRIES',99,1,50000000,10000,100,15000,NULL,1522617575,32,12,56),
	(8,2,'INTERNAL','Moon and Star union Internal Exchange','/resource/img/MSUIE.png','MSUIE',227,1,5000000000,1000000,100,500000,NULL,1518644325,5,48,47),
	(9,3,'INTERNAL','Enerian Republic Internal Exchange Service','/resource/img/ERIES.png','ERIES',304,1,2000000000,100000,1000,50000,NULL,1518644295,5,55,40),
	(10,4,'INTERNAL','Nova System Internal Stock','/resource/img/NSIS.png','NSIS',12,1,20000000000,100000000,10000,100000,NULL,1518644383,1,59,40);

/*!40000 ALTER TABLE `markets` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы markets_delta
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_delta`;

CREATE TABLE `markets_delta` (
   `market` VARCHAR(255) NULL DEFAULT NULL,
   `delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets_falling
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_falling`;

CREATE TABLE `markets_falling` (
   `currency_short_name` VARCHAR(255) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets_growth
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_growth`;

CREATE TABLE `markets_growth` (
   `currency_short_name` VARCHAR(255) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `markets_history`;

CREATE TABLE `markets_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_market` int(10) unsigned DEFAULT NULL,
  `delta` double DEFAULT NULL,
  `delta_abs` double DEFAULT NULL,
  `tick` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tick` (`tick`,`fk_market`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы markets_union
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_union`;

CREATE TABLE `markets_union` (
   `currency_short_name` VARCHAR(255) NULL DEFAULT NULL,
   `delta1` DOUBLE NULL DEFAULT NULL,
   `delta2` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы meta_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meta_news`;

CREATE TABLE `meta_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titl` varchar(255) DEFAULT NULL,
  `sectors` text,
  `news` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;

INSERT INTO `migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1518826153);

/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tick` int(11) DEFAULT NULL,
  `ttl` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `fk_market` int(11) unsigned DEFAULT NULL,
  `sector` enum('AGRI','INDUS','SERV') DEFAULT NULL,
  `type` enum('POSITIVE','NEGATIVE') DEFAULT NULL,
  `priority` enum('LOW','MEDIUM','HIGH','') DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_market_news` (`fk_market`),
  CONSTRAINT `fk_market_news` FOREIGN KEY (`fk_market`) REFERENCES `markets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rates`;

CREATE TABLE `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_source_currency` int(11) unsigned NOT NULL,
  `fk_target_currency` int(11) unsigned NOT NULL,
  `exchange_rate` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source_key` (`fk_source_currency`),
  KEY `target_key` (`fk_target_currency`),
  CONSTRAINT `source_key` FOREIGN KEY (`fk_source_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `target_key` FOREIGN KEY (`fk_target_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;

INSERT INTO `rates` (`id`, `fk_source_currency`, `fk_target_currency`, `exchange_rate`)
VALUES
	(1,1,3,13),
	(2,1,2,15),
	(3,1,4,17),
	(4,1,5,18),
	(8,1,6,1),
	(9,1,1,1);

/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы rates_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rates_history`;

CREATE TABLE `rates_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_source_currency` int(11) unsigned NOT NULL,
  `fk_target_currency` int(11) unsigned NOT NULL,
  `exchange_rate` double NOT NULL,
  `tick` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source_key` (`fk_source_currency`),
  KEY `target_key` (`fk_target_currency`),
  CONSTRAINT `rates_history_ibfk_1` FOREIGN KEY (`fk_source_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rates_history_ibfk_2` FOREIGN KEY (`fk_target_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `key`, `value`)
VALUES
	(1,'lastTick','1');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы stock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_market` int(11) unsigned NOT NULL COMMENT 'Ð’Ð½ÐµÑˆÐ½Ð¸Ð¹ ÐºÐ»ÑŽÑ‡ "Ð‘Ð¸Ñ€Ð¶Ð°"',
  `company_name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL COMMENT 'ÐšÐ¾Ð»Ð¸Ñ‡ÐµÑÑ‚Ð²Ð¾ Ð°ÐºÑ†Ð¸Ð¹',
  `capitalization` float DEFAULT NULL COMMENT 'ÐšÐ°Ð¿Ð¸Ñ‚Ð°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ñ ÐºÐ°Ð¼Ð¿Ð°Ð½Ð¸Ð¸ Ð¿Ð¾ Ð¸Ñ‚Ð¾Ð³Ð°Ð¼ Ñ‚Ð¾Ñ€Ð³Ð¾Ð²',
  `share_price` float DEFAULT NULL COMMENT 'Ð¦ÐµÐ½Ð° Ð°ÐºÑ†Ð¸Ð¸ Ð¿Ð¾ Ð¸Ñ‚Ð¾Ð³Ð°Ð¼ Ñ‚Ð¾Ñ€Ð³Ð¾Ð²',
  `delta` double DEFAULT NULL,
  `delta_abs` double DEFAULT NULL,
  `initial_share_price` float DEFAULT NULL COMMENT 'Ð£ÑÑ‚Ð°Ð½Ð¾Ð²Ð¾Ñ‡Ð½Ð°Ñ Ñ†ÐµÐ½Ð° Ð°ÐºÑ†Ð¸Ð¸',
  `initial_capitalization` float DEFAULT NULL COMMENT 'Ð£ÑÑ‚Ð°Ð½Ð¾Ð²Ð¾Ñ‡Ð½Ð°Ñ ÐºÐ°Ð¿Ð¸Ñ‚Ð°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ñ',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `behavior` enum('GROWTH','FALLING') DEFAULT NULL,
  `sector` enum('AGRI','INDUS','SERV') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_id_uindex` (`id`),
  KEY `stock_markets_id_fk` (`fk_market`),
  KEY `cap` (`capitalization`),
  CONSTRAINT `stock_markets_id_fk` FOREIGN KEY (`fk_market`) REFERENCES `markets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;

INSERT INTO `stock` (`id`, `fk_market`, `company_name`, `amount`, `capitalization`, `share_price`, `delta`, `delta_abs`, `initial_share_price`, `initial_capitalization`, `created_at`, `updated_at`, `behavior`, `sector`)
VALUES
	(2,9,'ХДР Ресурсес',25000,130000000000,5200000,0,0,5200000,130000000000,1522621127,1522621160,NULL,'INDUS'),
	(3,9,'АС Банк',25000,110500000000,4420000,0,0,4420000,110500000000,1522621233,1522621233,NULL,'SERV'),
	(4,3,'Магсофт',25000,98800000000,3952000,0,0,3952000,98800000000,1522621279,1522621279,NULL,'SERV'),
	(5,3,'Магфон',25000,92300000000,3692000,0,0,3692000,92300000000,1522621344,1522621344,NULL,'SERV'),
	(6,3,'Нексус гравитранспорт',25000,88400000000,3536000,0,0,3536000,88400000000,1522621376,1522621376,NULL,'INDUS'),
	(7,2,'Северной турагенство',2500,285000000000,114000000,0,0,114000000,285000000000,1522621511,1522621511,NULL,'INDUS'),
	(8,2,'МДМ Лимитед',4000,255000000000,63750000,0,0,63750000,255000000000,1522621546,1522621546,NULL,'SERV'),
	(9,2,'НСК',22000,240000000000,10909100,0,0,10909100,240000000000,1522621570,1522621570,NULL,'INDUS'),
	(10,8,'Северное торговое общество',3000,225000000000,75000000,0,0,75000000,225000000000,1522621612,1522621612,NULL,'SERV'),
	(11,8,'Черный консалтинг',18000,210000000000,11666700,0,0,11666700,210000000000,1522621652,1522621681,NULL,'INDUS'),
	(12,2,'Магасофт',150000,210000000000,1400000,0,0,1400000,210000000000,1522621709,1522621709,NULL,'SERV'),
	(13,2,'Твердые Металические Детали',15000,150000000000,10000000,0,0,10000000,150000000000,1522621749,1522621749,NULL,'INDUS'),
	(14,2,'Новые горизонты',210000,135000000000,642857,0,0,642857,135000000000,1522621786,1522621786,NULL,'INDUS'),
	(15,7,'Трисл Транс Биолоджик',10000,90000000000,9000000,0,0,9000000,90000000000,1522621822,1522621822,NULL,'SERV'),
	(16,7,'Акваформ',15000,57600000000,3840000,0,0,3840000,57600000000,1522621851,1522621851,NULL,'INDUS'),
	(17,7,'Генезис Технолоджис',8000,45000000000,5625000,0,0,5625000,45000000000,1522621876,1522621876,NULL,'SERV'),
	(18,7,'Горное торговое общество',15000,32400000000,2160000,0,0,2160000,32400000000,1522621900,1522621900,NULL,'INDUS'),
	(19,7,'Юнайтед Фермерс',15000,21600000000,1440000,0,0,1440000,21600000000,1522621922,1522621922,NULL,'AGRI'),
	(20,6,'Новая торговая компания',200000,13000000000,65000,0,0,65000,13000000000,1522621960,1522621960,NULL,'SERV'),
	(21,6,'Коткон',50000,10000000000,200000,0,0,200000,10000000000,1522621985,1522621985,NULL,'INDUS'),
	(22,6,'Гуррен Лагган',6000,9600000000,1600000,0,0,1600000,9600000000,1522622020,1522622020,NULL,'INDUS'),
	(23,6,'М-Аналитика',1000,7000000000,7000000,0,0,7000000,7000000000,1522622043,1522622043,NULL,'SERV'),
	(24,5,'Нова электрикс',10000,986000000000,98600000,0,0,98600000,986000000000,1522622104,1522622104,NULL,'INDUS'),
	(25,5,'Спейсшип детэйлс',100000,884000000000,8840000,0,0,8840000,884000000000,1522622140,1522622140,NULL,'INDUS'),
	(26,5,'Нова импорт',25000,697000000000,27880000,0,0,27880000,697000000000,1522622162,1522622162,NULL,'SERV');

/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы stock_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock_history`;

CREATE TABLE `stock_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_stock` int(11) unsigned NOT NULL,
  `tickId` int(11) NOT NULL,
  `capitalization` double DEFAULT NULL,
  `share_price` double NOT NULL,
  `delta` double NOT NULL,
  `delta_abs` double DEFAULT NULL,
  `behavior` enum('GROWTH','FALLING') NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_history_id_uindex` (`id`),
  KEY `stock_history_stock_id_fk` (`fk_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





# Replace placeholder table for markets_growth with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_growth`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_growth`
AS SELECT
   `m`.`market_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'GROWTH') group by `m`.`market_short_name`,`s`.`behavior`;


# Replace placeholder table for currency_union with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_union`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_union`
AS SELECT
   `T1`.`currency_short_name` AS `currency_short_name`,
   `T1`.`market_delta` AS `delta1`,
   `T2`.`market_delta` AS `delta2`
FROM (`currency_growth` `T1` left join `currency_falling` `T2` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`))) union select if(`T1`.`currency_short_name`,`T1`.`currency_short_name`,`T2`.`currency_short_name`) AS `currency_short_name`,`T1`.`market_delta` AS `delta1`,`T2`.`market_delta` AS `delta2` from (`currency_falling` `T2` left join `currency_growth` `T1` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`)));


# Replace placeholder table for currency_growth with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_growth`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_growth`
AS SELECT
   `c`.`currency_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'GROWTH') group by `c`.`currency_short_name`,`s`.`behavior`;


# Replace placeholder table for currency_delta with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_delta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_delta`
AS SELECT
   `currency_union`.`currency_short_name` AS `currency`,if((`currency_union`.`delta2` + `currency_union`.`delta1`),(`currency_union`.`delta2` + `currency_union`.`delta1`),if(`currency_union`.`delta2`,
   `currency_union`.`delta2`,if(`currency_union`.`delta1`,
   `currency_union`.`delta1`,0))) AS `delta`
FROM `currency_union`;


# Replace placeholder table for markets_delta with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_delta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_delta`
AS SELECT
   `markets_union`.`currency_short_name` AS `market`,if((`markets_union`.`delta2` + `markets_union`.`delta1`),(`markets_union`.`delta2` + `markets_union`.`delta1`),if(`markets_union`.`delta2`,
   `markets_union`.`delta2`,if(`markets_union`.`delta1`,
   `markets_union`.`delta1`,0))) AS `delta`
FROM `markets_union`;


# Replace placeholder table for markets_union with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_union`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_union`
AS SELECT
   `T1`.`currency_short_name` AS `currency_short_name`,
   `T1`.`market_delta` AS `delta1`,
   `T2`.`market_delta` AS `delta2`
FROM (`markets_growth` `T1` left join `markets_falling` `T2` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`))) union select if(`T1`.`currency_short_name`,`T1`.`currency_short_name`,`T2`.`currency_short_name`) AS `currency_short_name`,`T1`.`market_delta` AS `delta1`,`T2`.`market_delta` AS `delta2` from (`markets_falling` `T2` left join `markets_growth` `T1` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`)));


# Replace placeholder table for currency_falling with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_falling`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_falling`
AS SELECT
   `c`.`currency_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'FALLING') group by `c`.`currency_short_name`,`s`.`behavior`;


# Replace placeholder table for markets_falling with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_falling`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_falling`
AS SELECT
   `m`.`market_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'FALLING') group by `m`.`market_short_name`,`s`.`behavior`;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
