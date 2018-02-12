# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 192.168.59.103 (MySQL 5.6.39)
# Схема: funds
# Время создания: 2018-02-12 19:00:21 +0000
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
  `country` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `max_companies` int(11) DEFAULT NULL,
  `max_agents` int(11) DEFAULT NULL,
  `currency_short_name` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;

INSERT INTO `currencies` (`id`, `country`, `currency`, `max_companies`, `max_agents`, `currency_short_name`)
VALUES
	(1,'Империя Дракона','Золотой Дракон',0,0,'SGD'),
	(2,'СЛЗ','Динар',0,0,'DR'),
	(3,'Республика Энерия','Энерго-кредит',0,0,'MP'),
	(4,'Нова','Нова-Кредит',0,0,'NC'),
	(5,'Ирландия','Золотой Дублон',0,0,'GD'),
	(6,'РКВ','у.е.',0,0,'UU');

/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы markets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `markets`;

CREATE TABLE `markets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_currency` int(11) DEFAULT NULL,
  `type` enum('INTERNAL','EXTERNAL') DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `market_short_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `markets` WRITE;
/*!40000 ALTER TABLE `markets` DISABLE KEYS */;

INSERT INTO `markets` (`id`, `fk_currency`, `type`, `name`, `market_short_name`)
VALUES
	(1,2,'INTERNAL','Moon and Star union Internal Exchange','MSUIE'),
	(2,2,'EXTERNAL','Moon and Star union External Exchange','MSUEE'),
	(3,3,'EXTERNAL','Enerian Republic Exchange Service','ERES'),
	(4,4,'INTERNAL','Nova System Internal Stock','NSIS'),
	(5,4,'EXTERNAL','Nova System External Stock','NSES'),
	(6,6,'EXTERNAL','Glory Shining Cat Overlord Market','GSCOM');

/*!40000 ALTER TABLE `markets` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы stock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_market` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `capitalization` int(11) DEFAULT NULL,
  `sum` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы stock_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock_history`;

CREATE TABLE `stock_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_stock` int(11) DEFAULT NULL,
  `tick_id` int(11) DEFAULT NULL,
  `sum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
