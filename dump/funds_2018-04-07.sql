# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 192.168.59.103 (MySQL 5.6.39)
# Схема: funds
# Время создания: 2018-04-07 18:46:24 +0000
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
  `capitalization` double DEFAULT NULL,
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
